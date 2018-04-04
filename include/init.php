<?php
//Some basic inits
$mmdvmconfigs = getMMDVMConfig();
if (!defined("MMDVMLOGPREFIX"))
   define("MMDVMLOGPREFIX", getConfigItem("Log", "FileRoot", $mmdvmconfigs));
if (!defined("TIMEZONE"))
   define("TIMEZONE", "UTC");
if (defined("RESOLVETGS")) {
   $tgList = getTGList();
}
$logLinesMMDVM = getMMDVMLog();
showLapTime("getMMDVMLog");
$reverseLogLinesMMDVM = $logLinesMMDVM;
rsort($reverseLogLinesMMDVM);
showLapTime("array_multisort");
$lastHeard = getLastHeard($reverseLogLinesMMDVM, FALSE);
showLapTime("getLastHeard");
if (defined("ENABLEYSFGATEWAY")) {
   $logLinesYSFGateway = getYSFGatewayLog();
   showLapTime("getYSFGatewayLog");
   $reverseLogLinesYSFGateway = $logLinesYSFGateway;
   rsort($reverseLogLinesYSFGateway);
   showLapTime("array_multisort");
   $activeYSFReflectors = getActiveYSFReflectors();
   showLapTime("getActiveYSFReflectors");
}
?>
