<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

// do not touch this includes!!! Never ever!!!
include "../config/config.php";

include "../locale/".LOCALE."/settings.php";
$codeset = "UTF8";
putenv('LANG='.LANG_LOCALE.'.'.$codeset);
putenv('LANGUAGE='.LANG_LOCALE.'.'.$codeset);
bind_textdomain_codeset('messages', $codeset);
bindtextdomain('messages', dirname(__FILE__).'/../locale/');
setlocale(LC_ALL, LANG_LOCALE.'.'.$codeset);
textdomain('messages');

include "../include/tools.php";
include "../include/functions.php";
if (!isset($_SERVER['PHP_AUTH_USER']) && REBOOTUSER !== "" && REBOOTPW !== "") {
    header('WWW-Authenticate: Basic realm="Dashboard"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Zur Ausführung bitte die geforderten Login-Daten eingeben!';
    exit;
} else {
   if ($_SERVER['PHP_AUTH_USER'] == REBOOTUSER && $_SERVER['PHP_AUTH_PW'] == REBOOTPW) {
   $fileName = MMDVMLOGPATH."/".MMDVMLOGPREFIX."-".date("Y-m-d").".log";

?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
  <h1><small>MMDVM-Dashboard by DG9VH  <?php
  echo _("for");
  if (getConfigItem("General", "Duplex", $mmdvmconfigs) == "1") {
   echo " "._("Repeater");
  } else {
   echo " "._("Hotspot");
  }
  ?>:</small>  <?php echo getCallsign($mmdvmconfigs) ?></h1>
  <h4>MMDVMHost by G4KLX Version: <?php echo getMMDVMHostVersion() ?></h4>
  <button onclick="window.location.href='../index.php'"  type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;<?php echo _("Home"); ?></button>

  </script>
</div>
<?php
checkSetup();
   exec('sleep 5s && '. REBOOTSYS . ' > /dev/null 2>&1 &');
?>
<div class="alert alert-info" role="alert"><?php echo _("Executing"); ?>  <b><?php echo 'sleep 5s && '. REBOOTSYS . ' > /dev/null 2>&1 &'?></b><br><?php echo _("Reboot system in progress"); ?></div>
 
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
      } else {

    header('WWW-Authenticate: Basic realm="Dashboard"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Zur Ausführung bitte die geforderten Login-Daten eingeben!';
    exit;
      }
   }
?> | <?php echo _("get your own at:");?> <a href="https://github.com/dg9vh/MMDVMHost-Dashboard">https://github.com/dg9vh/MMDVMHost-Dashboard</a> | <a href="../credits.php"><?php echo _("Credits");?></a>
   </div>
  </body>
</html>
