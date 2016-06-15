<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

// do not touch this includes!!! Never ever!!!
include "../config/config.php";
include "../include/tools.php";
include "../include/functions.php";

$fileName = MMDVMLOGPATH. "/MMDVM-".date(Y)."-".date(m)."-".date(d).".log";
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="<?php echo REFRESHAFTER?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <!-- Das neueste kompilierte und minimierte CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!-- Optionales Theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <!-- Das neueste kompilierte und minimierte JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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
      <span class="label label-info">Fichero log <?php echo $fileName ?></span>
   </div>
<div class="panel-body">
<?php
/*
$fileOutput = file_get_contents($fileName, FILE_USE_INCLUDE_PATH);

var_dump($fileOutput);
*/


$file = new SplFileObject($fileName);

// Loop until we reach the end of the file.
while (!$file->eof()) {
    // Echo one line from the file.
    echo $file->fgets();
    echo "<br>";
}

// Unset the file to call __destruct(), closing the file handle.
$file = null;

?>
   </div>
   <A NAME="TheEnd">
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

window.location.hash = '#TheEnd';
</script>
  </body>
</html>
