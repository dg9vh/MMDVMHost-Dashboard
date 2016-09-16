<?php
$totalLH = count($lastHeard);
?>
  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading">Last Heard List of today's <?php echo $totalLH; ?> callsigns.</div>
  <!-- Tabelle -->
  <div class="table-responsive">  
  <table id="lastHeard" class="table table-condensed table-striped table-hover">
   <thead>
    <tr>
      <th>Time (UTC)</th>
      <th>Mode</th>
      <th>Callsign</th>
      <?php
      if (defined("ENABLEXTDLOOKUP")) {
      ?>
      <th>Name</th>
      <?php
      }
      ?>
      <th>DSTAR-ID</th>
      <th>Target</th>
      <th>Source</th>
      <th>Dur (s)</th>
      <th>Loss</th>
      <th>BER</th>
    </tr>
   </thead>
   <tbody>
<?php
for ($i = 0;  ($i < $totalLH); $i++) {
		$listElem = $lastHeard[$i];
		echo"<tr>";
		echo"<td nowrap>$listElem[0]</td>";
		echo"<td nowrap>$listElem[1]</td>";
		if (constant("SHOWQRZ")) {
			echo"<td nowrap><a target=\"_new\" href=\"https://qrz.com/db/$listElem[2]\">".str_replace("0","&Oslash;",$listElem[2])."</a></td>";
		} else {
			echo"<td nowrap>".str_replace("0","&Oslash;",$listElem[2])."</td>";
		}
		if (defined("ENABLEXTDLOOKUP")) {
			echo "<td nowrap>".getName($listElem[2])."</td>";
		}
		echo"<td nowrap>$listElem[3]</td>";
		echo"<td nowrap>$listElem[4]</td>";
		if ($listElem[5] == "RF"){
			echo "<td nowrap><span class=\"label label-success\">RF</span></td>";
		}else{
			echo"<td nowrap>$listElem[5]</td>";
		}
		if ($listElem[6] == null) {
				echo'<td nowrap>transmitting</td><td></td><td></td>';
			} else if ($listElem[6] == "SMS") {
				echo'<td nowrap colspan=\"3\">sending or receiving SMS</td>';
			} else {
			echo"<td nowrap>$listElem[6]</td>";
			echo"<td nowrap>$listElem[7]</td>";
			echo"<td nowrap>$listElem[8]</td>";
		}
		echo"</tr>\n";
	}
?>
  </tbody>
  </table>
  </div>  
</div>

