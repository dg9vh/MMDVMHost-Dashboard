<?php
function format_time($seconds) {
   $secs           = intval($seconds % 60);
   $mins           = intval($seconds / 60 % 60);
   $hours          = intval($seconds / 3600 % 24);
   $days           = intval($seconds / 86400);
   $uptimeString   = "";

   if ($days > 0) {
      $uptimeString .= $days;
      $uptimeString .= (($days == 1) ? "&nbsp;day" : "&nbsp;days");
   }
   if ($hours > 0) {
      $uptimeString .= (($days > 0) ? ", " : "") . $hours;
      $uptimeString .= (($hours == 1) ? "&nbsp;hr" : "&nbsp;hrs");
   }
   if ($mins > 0) {
      $uptimeString .= (($days > 0 || $hours > 0) ? ", " : "") . $mins;
      $uptimeString .= (($mins == 1) ? "&nbsp;min" : "&nbsp;mins");
   }
   if ($secs > 0) {
      $uptimeString .= (($days > 0 || $hours > 0 || $mins > 0) ? ", " : "") . $secs;
      $uptimeString .= (($secs == 1) ? "&nbsp;s" : "&nbsp;s");
   }
   return $uptimeString;
}

function startsWith($haystack, $needle) {
   return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

function getMHZ($freq) {
   return substr($freq,0,3) . "." . substr($freq,3,6) . " MHz";
}

function isProcessRunning($processname) {
   exec("pgrep " . $processname, $pids);
   if(empty($pids)) {
      // process not running!
      return false;
   } else {
      // process running!
      return true;
   }
}

function clean($string) {
   
   return preg_replace('/[^A-Za-z0-9\-\/\ \.\_]/', '', $string); // Removes special chars.
}

function createConfigLines() {
   $out ="";
   foreach($_GET as $key=>$val) {
      if($key != "cmd") {
         $val = clean($val);
         $out .= "define(\"$key\", \"$val\");"."\n";
      }
   }
   return $out;
}

function getSize($filesize, $precision = 2) {
   $units = array('', 'K', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y');
   foreach ($units as $idUnit => $unit) {
      if ($filesize > 1024)
         $filesize /= 1024;
      else
         break;
   }
   return round($filesize, $precision).' '.$units[$idUnit].'B';
}

function checkSetup() {
   $el = error_reporting();
   error_reporting(E_ERROR | E_WARNING | E_PARSE);
   if (defined(DISTRIBUTION)) {
?>
<div class="alert alert-danger" role="alert"><?php echo _("You are using an old config.php. Please configure your Dashboard by calling <a href=\"setup.php\">setup.php</a>!"); ?></div>
<?php

      } else {
      if (file_exists ("setup.php") && ! defined("DISABLESETUPWARNING")) {
   ?>
   <div class="alert alert-danger" role="alert"><?php echo _("You forgot to remove setup.php in root-directory of your dashboard or you forgot to configure it! Please delete the file or configure your Dashboard by calling <a href=\"setup.php\">setup.php</a>!"); ?></div>
   <?php
      }
   }
   error_reporting($el);
}

function startStopwatch() {
   $time                   = microtime();
   $time                   = explode(' ', $time);
   $time                   = $time[1] + $time[0];
   $_SESSION['starttime']  = $time;
   return $time;
}

function getLapTime() {
   $start      = $_SESSION['starttime'];
   $time       = microtime();
   $time       = explode(' ', $time);
   $time       = $time[1] + $time[0];
   $finish     = $time;
   $lap_time   = round(($finish - $start), 4);
   return $lap_time;
}

function showLapTime($func) {
   if( defined("DEBUG") ) {
   ?><script>console.log('<?php echo $func . ": ". getLapTime(); ?> sec.');</script><?php
   }
}

function convertTimezone($timestamp) {
   $date = new DateTime($timestamp);
   $date->setTimezone(new DateTimeZone(TIMEZONE));   
   return $date->format('Y-m-d H:i:s');
}

function encode($hex) {
	$validchars = " abcdefghijklmnopqrstuvwxyzäöüßABCDEFGHIJKLMNOPQRSTUVWXYZÄÖÜ0123456789";
    $str        = '';
    $chrval     = hexdec($hex);
    $str        = chr($chrval);
    if (strpos($validchars, $str)>=0)
      return $str;
    else
      return "";
}

function recursive_array_search($needle,$haystack) {
    foreach($haystack as $key=>$value) {
        $current_key = $key;
        if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
            return $current_key;
        }
    }
    return false;
}
?>
