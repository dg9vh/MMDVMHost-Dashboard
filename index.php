<?php
include "config/config.php";
include "include/tools.php";
include "include/functions.php";
?>
<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="<?php echo REFRESHAFTER?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <!-- Das neueste kompilierte und minimierte CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Optionales Theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!-- Das neueste kompilierte und minimierte JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <title><?php echo REPEATERCALLSIGN?> - MMDVM-Dashboard by DG9VH</title>
  </head>
  <body>
  <div class="page-header">
  <h1><small>MMDVM-Dashboard by DG9VH</small> Repeater: <?php echo REPEATERCALLSIGN?></h1>
</div>
<?php
include "include/sysinfo.php";
include "include/repeaterinfo.php";
include "include/lh.php";
?>
	<div class="panel panel-info">
<?php
	date_default_timezone_set("UTC");
	$datum = date("d.m.Y");
	$uhrzeit = date("H:i:s");
	echo "Last Update $datum, $uhrzeit";
?>
	</div>
  </body>
</html>