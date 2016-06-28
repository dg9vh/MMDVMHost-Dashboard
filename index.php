<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

// do not touch this includes!!! Never ever!!!
include "config/config.php";
include "include/tools.php";
include "include/functions.php";
?>
<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=0.6,maximum-scale=1, user-scalable=yes">
	<!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">-->
    <meta http-equiv="refresh" content="<?php echo REFRESHAFTER?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
    <!-- Das neueste kompilierte und minimierte CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!-- Optionales Theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <!-- Das neueste kompilierte und minimierte JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"></style>
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
</div>
<?php
if (defined("ENABLEMANAGEMENT")) {
?>
  <button onclick="window.location.href='./scripts/log.php'"  type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>&nbsp;View Log</button>
  <button onclick="window.location.href='./scripts/rebootmmdvm.php'"  type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>&nbsp;Reboot MMDVMHost</button>
  <button onclick="window.location.href='./scripts/reboot.php'"  type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>&nbsp;Reboot System</button>
  <button onclick="window.location.href='./scripts/halt.php'"  type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-off" aria-hidden="true"></span>&nbsp;ShutDown System</button>
<?php
}
checkSetup();
// Here you can feel free to disable info-sections by commenting out with // before include
include "include/sysinfo.php";
include "include/disk.php";
include "include/repeaterinfo.php";
include "include/modes.php";
include "include/lh.php";
include "include/localtx.php";
if (defined("ENABLEYSFGATEWAY")) {
	include "include/ysfgatewayinfo.php";
}
?>
	<div class="panel panel-info">
<?php
$datum = date("Y-m-d");
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
  
var lastHeardT = $('#lastHeard').dataTable( {
   "aaSorting": [[0,'desc']]
  } );
var localTxT = $('#localTx').dataTable( {
    "aaSorting": [[0,'desc']]
  } );
});
</script>
  </body>
</html>
