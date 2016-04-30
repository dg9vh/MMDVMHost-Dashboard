<?php
// 00000000001111111111222222222233333333334444444444555555555566666666667777777777888888888899999999990000000000111111111122
// 01234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901
// M: 2016-04-29 00:15:00.013 D-Star, received network header from DG9VH   /ZEIT to CQCQCQ   via DCS002 S
// M: 2016-04-29 19:43:21.839 DMR Slot 2, received network voice header from DL1ESZ to TG 9

function getLastHeard() {
	$lastHeard = array();
	$heardList = array();
	$heardCalls = array();
	if ($log = fopen(LOGFILE,'r')) {
		while ($logLine = fgets($log)) {
			// timestamp, mode, callsign, dstarid, target
			$timestamp = substr($logLine, 3, 19);
			$mode = substr($logLine, 27, strpos($logLine,",") - 27);
			$callsign2 = substr($logLine, strpos($logLine,"from") + 5, strpos($logLine,"to") - strpos($logLine,"from") - 6);
			$callsign = $callsign2;
			if (strpos($callsign2,"/") > 0) {
				$callsign = substr($callsign2, 0, strpos($callsign2,"/"));
			}
			$callsign = trim($callsign);
			$id ="";
			if ($mode == "D-Star") {
				$id = substr($callsign2, strpos($callsign2,"/") + 1);
			}
			$target = substr($logLine, strpos($logLine, "to") + 3); 
			
			if ( strlen($callsign <7) ) {
				array_push($heardList, array($timestamp, $mode, $callsign, $id, $target));
			}
			//Last-Heard-Liste: Array aufbauen in umgekehrter Richtung des Logs
			//Zeilen ausblenden, bei denen das Callsign länger als 6 Stellen ist
		}
		fclose($log);
	}
	array_multisort($heardList,SORT_DESC);
	foreach ($heardList as $listElem) {
		if(!(array_search($listElem[2], $heardCalls) > -1)) {
			array_push($heardCalls, $listElem[2]);
			array_push($lastHeard, $listElem);
		}
	}
	return $lastHeard;
}

//getLastHeard();
?>