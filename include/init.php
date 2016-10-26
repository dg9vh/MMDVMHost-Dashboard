<?php
//Some basic inits
$mmdvmconfigs = getMMDVMConfig();
if (!defined("MMDVMLOGPREFIX"))
	define("MMDVMLOGPREFIX", getConfigItem("Log", "FileRoot", $mmdvmconfigs));
echo MMDVMLOGPREFIX;
$logLinesMMDVM = getMMDVMLog();
showLapTime("getMMDVMLog");
//getNames(" ");
showLapTime("getNames");
//$_SESSION['logLinesMMDVM'] = $logLinesMMDVM;
$reverseLogLinesMMDVM = $logLinesMMDVM;
array_multisort($reverseLogLinesMMDVM,SORT_DESC);
showLapTime("array_multisort");
//$_SESSION['reverseLogLinesMMDVM'] = $reverseLogLinesMMDVM;
$lastHeard = getLastHeard($reverseLogLinesMMDVM, FALSE);
showLapTime("getLastHeard");
//$_SESSION['lastHeard'] = $lastHeard;

if (defined("ENABLEYSFGATEWAY")) {
	$logLinesYSFGateway = getYSFGatewayLog();
	showLapTime("getYSFGatewayLog");
	$reverseLogLinesYSFGateway = $logLinesYSFGateway;
  	array_multisort($reverseLogLinesYSFGateway,SORT_DESC);
	showLapTime("array_multisort");
  	$activeYSFReflectors = getActiveYSFReflectors();
	showLapTime("getActiveYSFReflectors");
}
?>
