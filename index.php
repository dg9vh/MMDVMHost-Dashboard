<?php
//session_start();
/*
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;*/
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
// do not touch this includes!!! Never ever!!!
include "config/config.php";

include "locale/".LOCALE."/settings.php";
$codeset = "UTF8";
putenv('LANG='.LANG_LOCALE.'.'.$codeset);
putenv('LANGUAGE='.LANG_LOCALE.'.'.$codeset);
bind_textdomain_codeset('messages', $codeset);
bindtextdomain('messages', dirname(__FILE__).'/locale/');
setlocale(LC_ALL, LANG_LOCALE.'.'.$codeset);
textdomain('messages');

include "include/tools.php";
startStopwatch();
showLapTime("Start of page");
include "include/functions.php";
include "include/init.php";
include "version.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=0.6,maximum-scale=1, user-scalable=yes">
    <!-- Default-CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- CSS for tooltip display -->
    <link rel="stylesheet" href="css/tooltip.css">
    <!-- CSS for monospaced fonts in tables -->
    <link rel="stylesheet" href="css/monospacetables.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
    <!-- Das neueste kompilierte und minimierte CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/latest/css/bootstrap.min.css">
    <!-- Optionales Theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/latest/css/bootstrap-theme.min.css">
    <!-- Das neueste kompilierte und minimierte JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/latest/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
   <style>
   .nowrap {
      white-space:nowrap
   }
   </style>
    <title><?php echo getCallsign($mmdvmconfigs) ?> - MMDVM-Dashboard by DG9VH</title>
  </head>
  <body>
  <div class="page-header" style="position:relative;">
  <h1><small>MMDVM-Dashboard by DG9VH  <?php
  echo _("for");
  if (getConfigItem("General", "Duplex", $mmdvmconfigs) == "1") {
   echo " "._("Repeater");
  } else {
   echo " "._("Hotspot");
  }
  ?>:</small>  <?php echo getCallsign($mmdvmconfigs) ?></h1>
  <h4>MMDVMHost by G4KLX Version: <?php echo getMMDVMHostVersion() ?><br>Firmware: <?php echo getFirmwareVersion() ?>
  <?php
  if (strlen(getDMRNetwork()) > 0 ) {
   echo "<br>";
   echo _("DMR-Network: ").getDMRNetwork();
  }
  ?></h4>
  <?php
  $logourl = "";
  if (getDMRNetwork() == "BrandMeister") {
   if (constant('BRANDMEISTERLOGO') !== NULL) {
      $logourl = BRANDMEISTERLOGO;
    }
  }
  if (getDMRNetwork() == "DMRplus") {
   if (constant('DMRPLUSLOGO') !== NULL) {
     $logourl = DMRPLUSLOGO;
    }
  }

  if ($logourl == "") {
   $logourl = LOGO;
  }

  if ($logourl !== "") {
?>
<div id="Logo" style="position:absolute;top:-43px;right:10px;"><img src="<?php echo $logourl ?>" width="250px" style="width:250px; border-radius:10px;box-shadow:2px 2px 2px #808080; padding:1px;background:#FFFFFF;border:1px solid #808080;" border="0" hspace="10" vspace="10" align="absmiddle"></div>
<?php
  }
?>
</div>
<?php
if (defined("ENABLEMANAGEMENT")) {
?>
  <button onclick="window.location.href='./scripts/log.php'"  type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>&nbsp;<?php echo _("View Log"); ?></button>
  <button onclick="window.location.href='./scripts/rebootmmdvm.php'"  type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>&nbsp;<?php echo _("Reboot MMDVMHost"); ?></button>
  <button onclick="window.location.href='./scripts/reboot.php'"  type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>&nbsp;<?php echo _("Reboot System"); ?></button>
  <button onclick="window.location.href='./scripts/halt.php'"  type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-off" aria-hidden="true"></span>&nbsp;<?php echo _("ShutDown System"); ?></button>
<?php
}
if (defined("ENABLENETWORKSWITCHING")) {
?>
  <button onclick="window.location.href='./scripts/switchnetwork.php?network=DMRPLUS'"  type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;<?php echo _("DMRplus"); ?></button>
  <button onclick="window.location.href='./scripts/switchnetwork.php?network=BRANDMEISTER'"  type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-fire" aria-hidden="true"></span>&nbsp;<?php echo _("BrandMeister"); ?></button>
<?php
}
checkSetup();
// Here you can feel free to disable info-sections by commenting out with // before include
include "include/txinfo.php";
showLapTime("txinfo");
if (!defined("SHOWCPU") AND !defined("SHOWDISK") AND !defined("SHOWRPTINFO") AND !defined("SHOWMODES") AND !defined("SHOWLH") AND !defined("SHOWLOCALTX")) {
   define("SHOWCPU", "on");
   define("SHOWDISK", "on");
   define("SHOWRPTINFO", "on");
   define("SHOWMODES", "on");
   define("SHOWLH", "on");
   define("SHOWLOCALTX", "on");	
}
if (defined("SHOWCPU")) {
   include "include/sysinfo_ajax.php";
   showLapTime("sysinfo");
}
if (defined("SHOWDISK")) {
   include "include/disk.php";
   showLapTime("disk");
}
if (defined("SHOWRPTINFO")) {
    include "include/repeaterinfo.php";
    showLapTime("repeaterinfo");
}
if (defined("SHOWMODES")) {
   include "include/modes.php";
   showLapTime("modes");
}
if (defined("SHOWLH")) {
   include "include/lh_ajax.php";
   showLapTime("lh_ajax");
}
if (defined("SHOWLOCALTX")) {
   include "include/localtx_ajax.php";
   showLapTime("localtx_ajax");
}
if (defined("ENABLEYSFGATEWAY")) {
   include "include/ysfgatewayinfo.php";
   showLapTime("ysfgatewayinfo");
}
?>
   <div class="panel panel-info">
<?php
//$datum = date("Y-m-d");
//$uhrzeit = date("H:i:s");
$lastReload = new DateTime();
$lastReload->setTimezone(new DateTimeZone(TIMEZONE));
echo "MMDVMHost-Dashboard V ".VERSION." | "._("Last Reload")." ".$lastReload->format('Y-m-d, H:i:s')." (".TIMEZONE.")";
/*$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);*/
echo '<!--Page generated in '.getLapTime().' seconds.-->';
?> |
<?php
if (!isset($_GET['stoprefresh'])) {
   echo '<a href="?stoprefresh">'._("stop refreshing").'</a>';
} else {
   echo '<a href=".">'._("start refreshing").'</a>';
}
?>
 | <?php echo _("get your own at:");?> <a href="https://github.com/dg9vh/MMDVMHost-Dashboard">https://github.com/dg9vh/MMDVMHost-Dashboard</a> | <a href="credits.php"><?php echo _("Credits");?></a>
   </div>
   <noscript>
    For full functionality of this site it is necessary to enable JavaScript.
    Here are the <a href="http://www.enable-javascript.com/" target="_blank">
    instructions how to enable JavaScript in your web browser</a>.
   </noscript>
  </body>
  <script>
  		$(document).on('click', '.panel-heading span.clickable', function(e){
    var $this = $(this);
	if(!$this.hasClass('panel-collapsed')) {
		$this.parents('.panel').find('.panel-body').slideUp();
		$this.addClass('panel-collapsed');
		$this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
	} else {
		$this.parents('.panel').find('.panel-body').slideDown();
		$this.removeClass('panel-collapsed');
		$this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
	}
})
  </script>
</html>
<?php
   showLapTime("End of Page");
?>
