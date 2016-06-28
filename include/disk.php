  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
	  <div class="panel-heading">Disk use</div>
	  <!-- Tabelle -->
	  <div class="table-responsive">  
			<table id="diskuse" class="table table-condensed table-striped table-hover">

					<thead>
						<tr>
						   
							<th class="w10p filesystem">Filesystem</th>
							<th class="w20p">Mount</th>
							<th>Use</th>
							<th class="w15p">Free</th>
							<th class="w15p">Used</th>
							<th class="w15p">Total</th>
						</tr>
					</thead>
					<tbody>
						
<?php

 error_reporting(E_ERROR | E_WARNING | E_PARSE);

 //include "./functions.php";
 try{

 $datas = array();

if (!(exec('/bin/df -T | awk -v c=`/bin/df -T | grep -bo "Type" | awk -F: \'{print $2}\'` \'{print substr($0,c);}\' | tail -n +2 | awk \'{print $1","$2","$3","$4","$5","$6","$7}\'', $df)))
{
    $datas[] = array(
        'total'         => 'N.A',
        'used'          => 'N.A',
        'free'          => 'N.A',
        'percent_used'  => 0,
        'mount'         => 'N.A',
        'filesystem'    => 'N.A',
    );
}
else
{
    $mounted_points = array();
    $key = 0;

    foreach ($df as $mounted)
    {
        list($filesystem, $type, $total, $used, $free, $percent, $mount) = explode(',', $mounted);

       if (strpos($type, 'tmpfs') !== false )
            continue;


?>		

						<tr>
							<td><?php echo $filesystem ?></td>
							<td><?php echo $mount ?></td>
							<td><div class="progress"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo trim($percent, '%') ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo trim($percent, '%') ?>%;"><?php echo trim($percent, '%') ?>%</div></div></td>
							<td><?php echo getSize($free * 1024) ?></td>
							<td><?php echo getSize($used * 1024) ?></td>
							<td><?php echo getSize($total * 1024) ?></td>
						</tr>
					
<?php					
        $key++;
    }

}

 


} catch (Exception $e) {
    return false;
}

?>

   
	  
					</tbody>
			</table>
	  </div>  
  </div>

 
