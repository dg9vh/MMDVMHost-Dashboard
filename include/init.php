<?php
//Some basic inits
$mmdvmconfigs = getMMDVMConfig();
$logLinesMMDVM = getMMDVMLog();
$_SESSION['logLinesMMDVM'] = $logLinesMMDVM;
$reverseLogLinesMMDVM = $logLinesMMDVM;
array_multisort($reverseLogLinesMMDVM,SORT_DESC);
$_SESSION['reverseLogLinesMMDVM'] = $reverseLogLinesMMDVM;
$lastHeard = getLastHeard($reverseLogLinesMMDVM, FALSE);
$_SESSION['lastHeard'] = $lastHeard;

if (defined("ENABLEYSFGATEWAY")) {
		$activeYSFReflectors = getActiveYSFReflectors();
}
?>
