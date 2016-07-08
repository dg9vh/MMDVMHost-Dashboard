<?php
	$cputemp = NULL;
	$cpufreq = NULL;
	if (file_exists ("/sys/class/thermal/thermal_zone0/temp")) {
		exec("cat /sys/class/thermal/thermal_zone0/temp", $cputemp);
		$cputemp = $cputemp[0] / 1000;
	}
	if (file_exists ("/sys/devices/system/cpu/cpu0/cpufreq/scaling_cur_freq")) {
		exec("cat /sys/devices/system/cpu/cpu0/cpufreq/scaling_cur_freq", $cpufreq);
		$cpufreq = $cpufreq[0] / 1000;
	}
	
	if (defined("TEMPERATUREALERT") && $cputemp > TEMPERATUREHIGHLEVEL && $cputemp !== NULL) {
?>
		<script>
			function deleteLayer(id) {
				if (document.getElementById && document.getElementById(id)) {
					var theNode = document.getElementById(id);
					theNode.parentNode.removeChild(theNode);
				}
				else if (document.all && document.all[id]) {
					document.all[id].innerHTML='';
					document.all[id].outerHTML='';
				}
				// OBSOLETE CODE FOR NETSCAPE 4 
				else if (document.layers && document.layers[id]) {
					document.layers[id].visibility='hide';
					delete document.layers[id];
				}
			}

			function makeLayer(id,L,T,W,H,bgColor,visible,zIndex) {
				if (document.getElementById) {
					if (document.getElementById(id)) {
						alert ('Layer with this ID already exists!');
						return;
					}
					var ST = 'position:absolute; text-align:center;padding-top:20px;'
					+'; left:'+L+'px'
					+'; top:'+T+'px'
					+'; width:'+W+'px'
					+'; height:'+H+'px'
					+'; clip:rect(0,'+W+','+H+',0)'
					+'; visibility:'
					+(null==visible || 1==visible ? 'visible':'hidden')
					+(null==zIndex  ? '' : '; z-index:'+zIndex)
					+(null==bgColor ? '' : '; background-color:'+bgColor);

					var LR = '<DIV id='+id+' style="'+ST+'">CPU-Temperature is very high!<br><input type="button" value="Close" onclick="deleteLayer(\'LYR1\')"></DIV>';

					if (document.body) {
						if (document.body.insertAdjacentHTML)
							document.body.insertAdjacentHTML("BeforeEnd",LR);
						else if (document.createElement && document.body.appendChild) {
							var newNode = document.createElement('div');
							newNode.setAttribute('id',id);
							newNode.setAttribute('style',ST);
							document.body.appendChild(newNode);
						}
					}
				}
			}
			var audio = new Audio('sounds/alert.mp3');
			audio.play();
			var x = window.innerWidth/2-100;
			var y = window.innerHeight/2-50;

			makeLayer('LYR1',x,y,200,100,'red',1,1);
		</script>
<?php
	}

	$output = shell_exec('cat /proc/loadavg');
	$sysload = substr($output,0,strpos($output," "))*100; 

	$stat1 = file('/proc/stat'); 
	sleep(1); 
	$stat2 = file('/proc/stat'); 
	$info1 = explode(" ", preg_replace("!cpu +!", "", $stat1[0])); 
	$info2 = explode(" ", preg_replace("!cpu +!", "", $stat2[0])); 
	$dif = array(); 
	$dif['user'] = $info2[0] - $info1[0]; 
	$dif['nice'] = $info2[1] - $info1[1]; 
	$dif['sys'] = $info2[2] - $info1[2]; 
	$dif['idle'] = $info2[3] - $info1[3]; 
	$total = array_sum($dif); 
	$cpu = array(); 
	foreach($dif as $x=>$y) $cpu[$x] = round($y / $total * 100, 1); 
	$cpuusage = round($cpu['user'] + $cpu['sys'], 2);  
	
	$output = shell_exec('grep -c processor /proc/cpuinfo');
	$cpucores = $output;

	$output = shell_exec('cat /proc/uptime');
	$uptime = format_time(substr($output,0,strpos($output," ")));
	$idletime = format_time((substr($output,strpos($output," ")))/$cpucores);

?>
<div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading">System Info</div>
  <!-- Tabelle -->
	<div class="table-responsive">  
		<table id="sysinfo" class="table table-condensed">
			<tbody>
				<tr>
					<?php
					if ($cputemp !== NULL) {
					?>
					<th>CPU-Temperature</th>
					<?php
					}
					?>
					<?php
					if ($cpufreq !== NULL) {
					?>
					<th>CPU-Frequency</th>
					<?php
					}
					?>
					<th>System-Load</th>
					<th>CPU-Usage</th>
					<th>Uptime</th>
					<th>Idle</th>
				</tr>
				<tr class="gatewayinfo">
					<?php
					if ($cputemp !== NULL) {
					?>
					<td><?php echo $cputemp; ?> &deg;C</td>
					<?php
					}
					?>
					<?php
					if ($cpufreq !== NULL) {
					?>
					<td><?php echo $cpufreq; ?> MHz</td>
					<?php
					}
					?>
					<td><?php echo $sysload; ?> %</td>
					<td>
<?php
	if (defined("SHOWPROGRESSBARS")) {
?>
						<div class="progress"><div class="progress-bar <?php
		if ($cpuusage < 30)
			echo "progress-bar-success";
		if ($cpuusage >= 30 and $cpuusage < 60)
			echo "progress-bar-warning";
		if ($cpuusage >= 60)
			echo "progress-bar-danger";
?>" role="progressbar" aria-valuenow="<?php echo $cpuusage; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $cpuusage; ?>%;"><?php echo $cpuusage; ?>%</div></div>
<?php
	} else {
		echo $cpuusage." %";
	}
?>
					</td>
					<td><?php echo $uptime; ?></td>
					<td><?php echo $idletime; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
