<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

// do not touch this includes!!! Never ever!!!
include "../config/config.php";
include "../include/tools.php";
include "../include/functions.php";

$fileName = MMDVMLOGPATH."/".MMDVMLOGPREFIX."-".date("Y-m-d").".log";
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=800px,initial-scale=0.4,maximum-scale=0.6">
    <!--<meta http-equiv="refresh" content="<?php echo REFRESHAFTER?>">-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <!-- Das neueste kompilierte und minimierte CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!-- Optionales Theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <!-- Das neueste kompilierte und minimierte JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <title><?php echo getCallsign($mmdvmconfigs) ?> - MMDVM-Dashboard by DG9VH</title>

  </head>
  <body>
  <div class="page-header">
  <h1><small>MMDVM-Dashboard by DG9VH for <?php
  if (getConfigItem("General", "Duplex", $mmdvmconfigs) == "1") {
  	echo "Repeater";
  } else {
  	echo "Hotspot";  
  }
  ?>:</small>  <?php echo getCallsign($mmdvmconfigs) ?></h1>
  <h4>MMDVMHost by G4KLX Version: <?php echo getMMDVMHostVersion() ?></h4>
  <button onclick="window.location.href='../index.php'"  type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;Home</button>
  <button onclick="window.location.href='./rebootmmdvm.php'"  type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>&nbsp;Reboot MMDVMHost</button>
  <button onclick="window.location.href='./reboot.php'"  type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>&nbsp;Reboot System</button>
  <button onclick="window.location.href='./halt.php'"  type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-off" aria-hidden="true"></span>&nbsp;ShutDown System</button>

  </script>
</div>
<div class="panel panel-log">
   <div class="panel-heading">
      <span class="label label-info">Viewing log <?php echo $fileName ?></span>
   </div>
  <div class="table-responsive">  
  <table id="log" class="table table-condensed table-striped table-hover">
  <thead>
    <tr>
    <th>Level</th>
    <th>Timestamp</th>
    <th>Info</th>
    </tr>
  </thead>
<?php
$file = new SplFileObject($fileName);

// Loop until we reach the end of the file.
while (!$file->eof()) {
	$line = $file->fgets();
    // Echo one line from the file.
	echo"<tr>";
    echo "<td>";
	echo substr($line,0,3);
    echo "</td>";
    echo "<td>";
	echo substr($line,3,24);
    echo "</td>";
    echo "<td>";
	echo substr($line,27);
    echo "</td>";
	echo"</tr>\n";
}

// Unset the file to call __destruct(), closing the file handle.
$file = null;

?>
   </table>
   </div>
  </div>
	<div class="panel panel-info">


<?php
$datum = date("d-m-Y");
$uhrzeit = date("H:i:s");
echo "Last Update $datum, $uhrzeit";
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<!--Page generated in '.$total_time.' seconds.-->';	
?> | get your own at: <a href="https://github.com/dg9vh/MMDVMHost-Dashboard">https://github.com/dg9vh/MMDVMHost-Dashboard</a>
	</div>
	<script>
$(document).ready(function(){

var logT = $('#log').dataTable( {
    "aaSorting": [[1,'asc']]
  } );
});
</script>
  </body>
</html>
