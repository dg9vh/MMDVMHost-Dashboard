<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
include "config/config.php";
include "include/tools.php";
include "include/functions.php";
$mmdvmconfigs = getMMDVMConfig();
$logLinesMMDVM = getShortMMDVMLog();
$reverseLogLinesMMDVM = $logLinesMMDVM;
array_multisort($reverseLogLinesMMDVM,SORT_DESC);
$lastHeard = getLastHeard($reverseLogLinesMMDVM, True);
foreach ($lastHeard as $listElem) {
	echo "<tr>";
	if ($listElem[6] == null) {
		echo"<td nowrap>$listElem[0]</td>";
		echo"<td nowrap>$listElem[1]</td>";
		echo"<td nowrap>".str_replace("0","&Oslash;",$listElem[2])."</td>";
		if (defined("ENABLEXTDLOOKUP")) {
			echo "<td nowrap>".getName($listElem[2])."</td>";
		}
		echo"<td nowrap>$listElem[3]</td>";
		echo"<td nowrap>$listElem[4]</td>";
		if ($listElem[5] == "RF"){
			echo "<td nowrap><span class=\"label label-success\">RF</span></td>";
		}else{
			echo"<td nowrap>$listElem[5]</td>";
		}
		$UTC = new DateTimeZone("UTC");
		$d1 = new DateTime($listElem[0], $UTC);
		$d2 = new DateTime('now', $UTC);
		$diff = $d2->getTimestamp() - $d1->getTimestamp();
		echo"<td nowrap>$diff s</td>";
	}
	echo "</tr>";
}
?>

