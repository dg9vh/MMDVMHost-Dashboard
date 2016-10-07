<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
include "config/config.php";
include "include/tools.php";
include "include/functions.php";

$mmdvmconfigs = getMMDVMConfig();
$logLinesMMDVM = getMMDVMLog();
$reverseLogLinesMMDVM = $logLinesMMDVM;
array_multisort($reverseLogLinesMMDVM,SORT_DESC);
//$lastHeard = $_SESSION['lastHeard'];
if ($_GET['section'] == "lastHeard") {
	$lastHeard = getLastHeard($reverseLogLinesMMDVM, FALSE);
	echo '{"data": '.json_encode($lastHeard)."}";
}
if ($_GET['section'] == "localTx") {
	$localTXList = getHeardList($reverseLogLinesMMDVM, FALSE);
	$lastHeard = Array();
	for ($i = 0; $i < count($localTXList); $i++) {
	$listElem = $localTXList[$i];		
	if ($listElem[6] == "RF" && ($listElem[1]=="D-Star" || startsWith($listElem[1], "DMR") || $listElem[1]=="YSF" || $listElem[1]=="P25")) {
		$listElem[3] = getName($listElem[2]);
		
		if (constant("SHOWQRZ") && $listElem[2] !== "??????????" && !is_numeric($listElem[2])) {
			$listElem[2] = "<a target=\"_new\" href=\"https://qrz.com/db/$listElem[2]\">".str_replace("0","&Oslash;",$listElem[2])."</a>";
		} else {
			$listElem[2] = "<a target=\"_new\" href=\"http://dmr.darc.de/dmr-userreg.php?usrid=$listElem[2]\">".$listElem[2]."</a>";
		}
		array_push($lastHeard, $listElem);
	}
}
	echo '{"data": '.json_encode($lastHeard)."}";
}

?>