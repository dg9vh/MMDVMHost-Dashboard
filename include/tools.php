<?php
function format_time($seconds) {
	$secs = intval($seconds % 60);
	$mins = intval($seconds / 60 % 60);
	$hours = intval($seconds / 3600 % 24);
	$days = intval($seconds / 86400);
	$uptimeString = "";

	if ($days > 0) {
		$uptimeString .= $days;
		$uptimeString .= (($days == 1) ? "&nbsp;day" : "&nbsp;days");
	}
	if ($hours > 0) {
		$uptimeString .= (($days > 0) ? ", " : "") . $hours;
		$uptimeString .= (($hours == 1) ? "&nbsp;hour" : "&nbsp;hours");
	}
	if ($mins > 0) {
		$uptimeString .= (($days > 0 || $hours > 0) ? ", " : "") . $mins;
		$uptimeString .= (($mins == 1) ? "&nbsp;minute" : "&nbsp;minutes");
	}
	if ($secs > 0) {
		$uptimeString .= (($days > 0 || $hours > 0 || $mins > 0) ? ", " : "") . $secs;
		$uptimeString .= (($secs == 1) ? "&nbsp;second" : "&nbsp;seconds");
	}
	return $uptimeString;
}

function startsWith($haystack, $needle) {
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}
?>