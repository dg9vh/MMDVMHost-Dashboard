<?php

function getMMDVMHostVersion() {
   // returns creation-time or version of MMDVMHost as version-number
   $filename = MMDVMHOSTPATH."/MMDVMHost";
   exec($filename." -v 2>&1", $output);
   if (!startsWith(substr($output[0],18,8),"20")) {
      showLapTime("getMMDVMHostVersion");
      return getMMDVMHostFileVersion();
   } else {
      showLapTime("getMMDVMHostVersion");
      return substr($output[0],18,8)." (compiled ".getMMDVMHostFileVersion().")";
   }
}

function getMMDVMHostFileVersion() {
   // returns creation-time of MMDVMHost as version-number
   $filename = MMDVMHOSTPATH."/MMDVMHost";
   if (file_exists($filename)) {
      showLapTime("getMMDVMHostFileVersion");
      return date("d M Y", filectime($filename));
   }
}

function getFirmwareVersion() {
   $logPath = MMDVMLOGPATH."/".MMDVMLOGPREFIX."-".date("Y-m-d").".log";
   $logLines = explode("\n", `grep "MMDVM protocol version" $logPath`);
   $firmware = "n/a";
   if (count($logLines) >= 2) {
      $firmware = substr($logLines[count($logLines)-2], strpos($logLines[count($logLines)-2], "description")+13, strlen($logLines[count($logLines)-2])-strpos($logLines[count($logLines)-2], "description")+13);
   }
   if ($firmware != "n/a") {
      $fp = fopen('/tmp/MMDVMFirmware.txt', 'w');
      fwrite($fp, $firmware);
      fclose($fp);
   } else {
      $fp = fopen('/tmp/MMDVMFirmware.txt', 'r');
      $contents = fread($fp, filesize("/tmp/MMDVMFirmware.txt"));
      $firmware = $contents;
   }
   echo $firmware;
}

function setDMRNetwork($network) {
   $fp = fopen('../config/DMRNetwork.txt', 'w');
   fwrite($fp, $network);
   fclose($fp);
}

function getDMRNetwork() {
   $filename = 'config/DMRNetwork.txt';
   $network = '';
   if (file_exists($filename)) {
      $fp = fopen($filename, 'r');
      $network = fread($fp, filesize($filename));
      fclose($fp);
   }
   return $network;
}

function getDMRNetwork2() {
   $filename = '../config/DMRNetwork.txt';
   $network = '';
   if (file_exists($filename)) {
      $fp = fopen($filename, 'r');
      $network = fread($fp, filesize($filename));
      fclose($fp);
   }
   return $network;

}

function getDMRMasterState() {
   $logPath = MMDVMLOGPATH."/".MMDVMLOGPREFIX."-".date("Y-m-d").".log";
   $logLines = explode("\n", `egrep -h "(DMR, Logged into the master successfully)|(DMR, Closing DMR Network)" $logPath`);
   $state = -1;
   foreach($logLines as $logLine) {
      if (strpos($logLine, "successfully") > 0) {
         $state = 1;
      }
      if (strpos($logLine, "Closing") > 0) {
         $state = 0;
      }
   }
   if ($state >= 0) {
      $fp = fopen('/tmp/DMRMasterState.txt', 'w');
      fwrite($fp, $state);
      fclose($fp);
   } else {
      $fp = fopen('/tmp/DMRMasterState.txt', 'r');
      $contents = fread($fp, filesize("/tmp/DMRMasterState.txt"));
      $state = $contents;
   }
   return $state;

}

function getMMDVMConfig() {
   // loads MMDVM.ini into array for further use
   $conf = array();
   if ($configs = fopen(MMDVMINIPATH."/".MMDVMINIFILENAME, 'r')) {
      while ($config = fgets($configs)) {
         array_push($conf, trim ( $config, " \t\n\r\0\x0B"));
      }
      fclose($configs);
   }
   return $conf;
}

function getYSFGatewayConfig() {
   // loads YSFGateway.ini into array for further use
   $conf = array();
   if ($configs = fopen(YSFGATEWAYINIPATH."/".YSFGATEWAYINIFILENAME, 'r')) {
      while ($config = fgets($configs)) {
         array_push($conf, trim ( $config, " \t\n\r\0\x0B"));
      }
      fclose($configs);
   }
   showLapTime("getYSFGatewayConfig");
   return $conf;
}

function getCallsign($mmdvmconfigs) {
   // returns Callsign from MMDVM-config
   return getConfigItem("General", "Callsign", $mmdvmconfigs);
}

function getConfigItem($section, $key, $configs) {
   // retrieves the corresponding config-entry within a [section]
   $sectionpos = array_search("[" . $section . "]", $configs) + 1;
   $len = count($configs);
   while(startsWith($configs[$sectionpos],$key."=") === false && $sectionpos <= ($len) ) {
      if (startsWith($configs[$sectionpos],"[")) {
         return null;
      }
      $sectionpos++;
   }
   return substr($configs[$sectionpos], strlen($key) + 1);
}

function getEnabled ($mode, $mmdvmconfigs) {
   // returns enabled/disabled-State of mode
   return getConfigItem($mode, "Enable", $mmdvmconfigs);
}

function showMode($mode, $mmdvmconfigs) {
   // shows if mode is enabled or not.
?>
      <td><span class="label <?php
   if (getEnabled($mode, $mmdvmconfigs) == 1) {
      switch ($mode) {
         case "D-Star Network":
            if (getConfigItem("D-Star Network", "GatewayAddress", $mmdvmconfigs) == "localhost" || getConfigItem("D-Star Network", "GatewayAddress", $mmdvmconfigs) == "127.0.0.1") {
               if (isProcessRunning(IRCDDBGATEWAY)) {
                  echo "label-success";
               } else {
                  echo "label-danger\" title=\"ircddbgateway is down!";
               }
            } else {
               echo "label-default\" title=\"Remote gateway configured - not checked!";
            }
            break;
         case "System Fusion Network":
            if (getConfigItem("System Fusion Network", "GwyAddress", $mmdvmconfigs) == "localhost" || getConfigItem("System Fusion Network", "GwyAddress", $mmdvmconfigs) == "127.0.0.1") {
               if (isProcessRunning("YSFGateway")) {
                  echo "label-success";
               } else {
                  echo "label-danger\" title=\"YSFGateway is down!";
               }
            } else {
               echo "label-default\" title=\"Remote gateway configured - not checked!";
            }
            break;
         default:
            if (isProcessRunning("MMDVMHost")) {
               echo "label-success";
            } else {
               echo "label-danger\" title=\"MMDVMHost is down!";
            }
      }
   } else {
      echo "label-default";
    }
    ?>"><?php echo $mode ?></span></td>
<?php
}

function getMMDVMLog() {
   // Open Logfile and copy loglines into LogLines-Array()
   $logPath = MMDVMLOGPATH."/".MMDVMLOGPREFIX."-".date("Y-m-d").".log";
   //$logLines = explode("\n", `grep M: $logPath`);
   $logLines = explode("\n", `egrep -h "from|end|watchdog|lost" $logPath`);
   return $logLines;
}

function getShortMMDVMLog() {
   // Open Logfile and copy loglines into LogLines-Array()
   $logPath = MMDVMLOGPATH."/".MMDVMLOGPREFIX."-".date("Y-m-d").".log";
   $logLines = explode("\n", `egrep -h "from|end|watchdog|lost" $logPath | tail -100`);
   return $logLines;
}

function getYSFGatewayLog() {
   // Open Logfile and copy loglines into LogLines-Array()
   $logPath = YSFGATEWAYLOGPATH."/".YSFGATEWAYLOGPREFIX."-".date("Y-m-d").".log";
   //$logLines = explode("\n", `egrep -h "D:|M:" $logPath`);
   $logLines = explode("\n", `egrep -h "Starting|DISCONNECT|Connect|Automatic" $logPath`);
   return $logLines;
}

// 00000000001111111111222222222233333333334444444444555555555566666666667777777777888888888899999999990000000000111111111122
// 01234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901
// M: 2016-04-29 00:15:00.013 D-Star, received network header from DG9VH   /ZEIT to CQCQCQ   via DCS002 S
// M: 2016-04-29 19:43:21.839 DMR Slot 2, received network voice header from DL1ESZ to TG 9
// M: 2016-04-30 14:57:43.072 DMR Slot 2, received RF voice header from DG9VH to 5000
// M: 2016-09-16 09:14:12.886 P25, received RF from DF2ET to TG10100
function getHeardList($logLines, $onlyLast) {
   $heardList = array();
   $ts1duration = "";
   $ts1loss = "";
   $ts1ber = "";
   $ts1rssi = "";
   $ts2duration = "";
   $ts2loss = "";
   $ts2ber = "";
   $ts2rssi = "";
   $dstarduration = "";
   $dstarloss = "";
   $dstarber = "";
   $dstarrssi = "";
   $ysfduration = "";
   $ysfloss = "";
   $ysfber = "";
   $ysfrssi = "";
   foreach ($logLines as $logLine) {
      $duration = "";
      $loss = "";
      $ber = "";
      $rssi = "";
      //removing invalid lines
      if(strpos($logLine,"BS_Dwn_Act")) {
         continue;
      } else if(strpos($logLine,"invalid access")) {
         continue;
      } else if(strpos($logLine,"received RF header for wrong repeater")) {
         continue;
      } else if(strpos($logLine,"unable to decode the network CSBK")) {
         continue;
      } else if(strpos($logLine,"overflow in the DMR slot RF queue")) {
         continue;
      } else if(strpos($logLine,"bad LC received")) {
         continue;
      }

      if(strpos($logLine,"end of") || strpos($logLine,"watchdog has expired") || strpos($logLine,"ended RF data") || strpos($logLine,"ended network") || strpos($logLine,"transmission lost")) {
         $lineTokens = explode(", ",$logLine);
         if (array_key_exists(2,$lineTokens)) {
            $duration = strtok($lineTokens[2], " ");
         }
         if (array_key_exists(3,$lineTokens)) {
            $loss = $lineTokens[3];
         }
         if (array_key_exists(4,$lineTokens)) {
            $ber = $lineTokens[4];
         }

         // if RF-Packet, no LOSS would be reported, so BER is in LOSS position
         // and RSSI in BER position
         if (startsWith($loss,"BER")) {
            if (substr($ber, 6) != "-0/-0/-0 dBm") {
               $rssiString = substr($ber, 6);
               if (constant("RSSI") == "min") $rssiVal = preg_replace('/(-\d+)\/-\d+\/-\d+ dBm/', "\\1", $rssiString);
               else if (constant("RSSI") == "max") $rssiVal = preg_replace('/-\d+\/(-\d+)\/-\d+ dBm/', "\\1", $rssiString);
               else if (constant("RSSI") == "avg") $rssiVal = preg_replace('/-\d+\/-\d+\/(-\d+) dBm/', "\\1", $rssiString);
               else $rssiVal = preg_replace('/-\d+\/-\d+\/(-\d+) dBm/', "\\1", $rssiString);
               if ($rssiVal > "-53") $rssi = "<img src=\"images/4.png\" \> <div class=\"tooltip2\">S9+40dB ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-63") $rssi = "<img src=\"images/4.png\" \> <div class=\"tooltip2\">S9+30dB ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-73") $rssi = "<img src=\"images/4.png\" \> <div class=\"tooltip2\">S9+20dB ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-83") $rssi = "<img src=\"images/4.png\" \> <div class=\"tooltip2\">S9+10dB ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-93") $rssi = "<img src=\"images/4.png\" \> <div class=\"tooltip2\">S9 ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-99") $rssi = "<img src=\"images/3.png\" \> <div class=\"tooltip2\">S8 ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-105") $rssi = "<img src=\"images/3.png\" \> <div class=\"tooltip2\">S7 ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-111") $rssi = "<img src=\"images/2.png\" \> <div class=\"tooltip2\">S6 ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-117") $rssi = "<img src=\"images/2.png\" \> <div class=\"tooltip2\">S5 ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-123") $rssi = "<img src=\"images/1.png\" \> <div class=\"tooltip2\">S4 ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-129") $rssi = "<img src=\"images/1.png\" \> <div class=\"tooltip2\">S3 ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-135") $rssi = "<img src=\"images/0.png\" \> <div class=\"tooltip2\">S2 ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-141") $rssi = "<img src=\"images/0.png\" \> <div class=\"tooltip2\">S1 ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
            }
            $ber = substr($loss, 5);
            $loss = "";
         } else {
            $loss = strtok($loss, " ");
            if (array_key_exists(4,$lineTokens)) {
               $ber = substr($lineTokens[4], 5);
            }
            if (array_key_exists(5,$lineTokens) && substr($lineTokens[5], 6) != "-0/-0/-0 dBm") {
               $rssiString = substr($lineTokens[5], 6);
               if (constant("RSSI") == "min") $rssiVal = preg_replace('/(-\d+)\/-\d+\/-\d+ dBm/', "\\1", $rssiString);
               else if (constant("RSSI") == "max") $rssiVal = preg_replace('/-\d+\/(-\d+)\/-\d+ dBm/', "\\1", $rssiString);
               else if (constant("RSSI") == "avg") $rssiVal = preg_replace('/-\d+\/-\d+\/(-\d+) dBm/', "\\1", $rssiString);
               else $rssiVal = preg_replace('/-\d+\/-\d+\/(-\d+) dBm/', "\\1", $rssiString);
               if ($rssiVal > "-53") $rssi = "<img src=\"images/4.png\" \> <div class=\"tooltip2\">S9+40dB ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-63") $rssi = "<img src=\"images/4.png\" \> <div class=\"tooltip2\">S9+30dB ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-73") $rssi = "<img src=\"images/4.png\" \> <div class=\"tooltip2\">S9+20dB ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-83") $rssi = "<img src=\"images/4.png\" \> <div class=\"tooltip2\">S9+10dB ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-93") $rssi = "<img src=\"images/4.png\" \> <div class=\"tooltip2\">S9 ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-99") $rssi = "<img src=\"images/3.png\" \> <div class=\"tooltip2\">S8 ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-105") $rssi = "<img src=\"images/3.png\" \> <div class=\"tooltip2\">S7 ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-111") $rssi = "<img src=\"images/2.png\" \> <div class=\"tooltip2\">S6 ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-117") $rssi = "<img src=\"images/2.png\" \> <div class=\"tooltip2\">S5 ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-123") $rssi = "<img src=\"images/1.png\" \> <div class=\"tooltip2\">S4 ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-129") $rssi = "<img src=\"images/1.png\" \> <div class=\"tooltip2\">S3 ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-135") $rssi = "<img src=\"images/0.png\" \> <div class=\"tooltip2\">S2 ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
               else if ($rssiVal > "-141") $rssi = "<img src=\"images/0.png\" \> <div class=\"tooltip2\">S1 ($rssiVal dBm)<span class=\"tooltip2text\">(min/max/avg)<br>$rssiString</span></div>";
            }
         }

         if (strpos($logLine,"ended RF data") || strpos($logLine,"ended network")) {
            switch (substr($logLine, 27, strpos($logLine,",") - 27)) {
               case "DMR Slot 1":
                  $ts1duration = "SMS";
                  break;
               case "DMR Slot 2":
                  $ts2duration = "SMS";
                  break;
            }
         } else {
            switch (substr($logLine, 27, strpos($logLine,",") - 27)) {
               case "D-Star":
                  $dstarduration = $duration;
                  $dstarloss = $loss;
                  $dstarber = $ber;
                  $dstarrssi = $rssi;
                  break;
               case "DMR Slot 1":
                  $ts1duration = $duration;
                  $ts1loss = $loss;
                  $ts1ber = $ber;
                  $ts1rssi = $rssi;
                  break;
               case "DMR Slot 2":
                  $ts2duration = $duration;
                  $ts2loss = $loss;
                  $ts2ber = $ber;
                  $ts2rssi = $rssi;
                  break;
               case "YSF":
                  $ysfduration = $duration;
                  $ysfloss = $loss;
                  $ysfber = $ber;
                  $ysfrssi = $rssi;
                  break;
               case "P25":
                  $p25duration = $duration;
                  $p25loss = $loss;
                  $p25ber = $ber;
                  $p25rssi = $rssi;
                  break;
            }
         }
      }

      $timestamp = substr($logLine, 3, 19);
      $mode = substr($logLine, 27, strpos($logLine,",") - 27);
      if ($topos = strpos($logLine, "to follow)")) {
         $topos = strpos($logLine, "to", $topos+1);
      } else {
         $topos = strpos($logLine, "to");
      }
      $callsign2 = substr($logLine, strpos($logLine,"from") + 5, $topos - strpos($logLine,"from") - 6);
      $callsign = $callsign2;
      if (strpos($callsign2,"/") > 0) {
         $callsign = substr($callsign2, 0, strpos($callsign2,"/"));
      }
      $callsign = trim($callsign);
      
      $id ="";
      if ($mode == "D-Star") {
         $id = substr($callsign2, strpos($callsign2,"/") + 1);
      }
      
      
      $target = substr($logLine, $topos + 3);
      $target = preg_replace('/\s/', '&nbsp;', $target);
      $source = "RF";
      if (strpos($logLine,"network") > 0 ) {
         $source = "Net";
      }

      switch ($mode) {
         case "D-Star":
            $duration = $dstarduration;
            $loss = $dstarloss;
            $ber = $dstarber;
            $rssi = $dstarrssi;
            break;
         case "DMR Slot 1":
            $duration = $ts1duration;
            $loss = $ts1loss;
            $ber = $ts1ber;
            $rssi = $ts1rssi;
            break;
         case "DMR Slot 2":
            $duration = $ts2duration;
            $loss = $ts2loss;
            $ber = $ts2ber;
            $rssi = $ts2rssi;
            break;
         case "YSF":
            $duration = $ysfduration;
            $loss = $ysfloss;
            $ber = $ysfber;
            $rssi = $ysfrssi;
            break;
         case "P25":
            $duration = $p25duration;
            $loss = $p25loss;
            $ber = $p25ber;
            $rssi = $p25rssi;
            break;
      }

      // Callsign or ID should be less than 11 chars long, otherwise it could be errorneous
      if ( strlen($callsign) < 11 ) {
         $name = "";
         if (defined("ENABLEXTDLOOKUP")) {
            array_push($heardList, array(convertTimezone($timestamp), $mode, $callsign, $name, $id, $target, $source, $duration, $loss, $ber, $rssi));
         } else {
            array_push($heardList, array(convertTimezone($timestamp), $mode, $callsign, $id, $target, $source, $duration, $loss, $ber, $rssi));
         }
         $duration = "";
         $loss ="";
         $ber = "";
         $rssi = "";
         if ($onlyLast && count($heardList )> 4) {
            return $heardList;
         }
      }
   }
   return $heardList;
}

function getLastHeard($logLines, $onlyLast) {
   //returns last heard list from log
   $lastHeard = array();
   $heardCalls = array();
   $heardList = getHeardList($logLines, $onlyLast);
   $counter = 0;
   foreach ($heardList as $listElem) {
      if ( ($listElem[1] == "D-Star") || ($listElem[1] == "YSF") || ($listElem[1] == "P25") || (startsWith($listElem[1], "DMR")) ) {
         if(!(array_search($listElem[2]."#".$listElem[1].$listElem[4], $heardCalls) > -1)) {
            // Generate a canonicalized call for QRZ and name lookups
            $call_canon = preg_replace('/\s+\w$/', '', $listElem[2]);
            array_push($heardCalls, $listElem[2]."#".$listElem[1].$listElem[4]);
            if (defined("ENABLEXTDLOOKUP")) {
               if ($listElem[2] !== "??????????") {
                  //$listElem[3] = "Dummy"; //Should speed up this function - time-issue!
                  $listElem[3] = getName($call_canon); //Should speed up this function - time-issue!
               } else {
                  $listElem[3] = "---";
               }
            }
            if ($listElem[2] !== "??????????") {
               if (!is_numeric($listElem[2])) {
                  if (defined("SHOWQRZ")) {
                     $listElem[2] = "<a target=\"_new\" href=\"https://qrz.com/db/$call_canon\">".str_replace("0","&Oslash;",$listElem[2])."</a>";
                  } else {
                     $listElem[2] = "<a target=\"_new\" href=\"http://dmr.darc.de/dmr-userreg.php?callsign=$call_canon\">".$listElem[2]."</a>";
                  }
               } else {
                  $listElem[2] = "<a target=\"_new\" href=\"http://dmr.darc.de/dmr-userreg.php?usrid=$listElem[2]\">".$listElem[2]."</a>";
               }
            }
            array_push($lastHeard, $listElem);
            $counter++;
         }
      }
   }
   return $lastHeard;
}

function getActualMode($metaLastHeard, $mmdvmconfigs) {
   // returns mode of repeater actual working in
   $listElem = $metaLastHeard[0];
   $timestamp = new DateTime($listElem[0],new DateTimeZone(TIMEZONE));
   
   $mode = $listElem[1];
   if (startsWith($mode, "DMR")) {
      $mode = "DMR";
   }
   if (defined("ENABLEXTDLOOKUP") && $listElem[7] == null || !defined("ENABLEXTDLOOKUP") && $listElem[6] == null) {
      return "<span class=\"label label-danger\">".$mode."</span>";
   } else {
      $now =  new DateTime('NOW',new DateTimeZone(TIMEZONE));
      $hangtime = getConfigItem("General", "ModeHang", $mmdvmconfigs);

      if ($hangtime != "") {
         $timestamp->add(new DateInterval('PT' . $hangtime . 'S'));
      } else {
         $source = $listElem[6];
         if ($source === "Network") {
            $hangtime = getConfigItem("General", "NetModeHang", $mmdvmconfigs);
         } else {
            $hangtime = getConfigItem("General", "RFModeHang", $mmdvmconfigs);
         }
         $timestamp->add(new DateInterval('PT' . $hangtime . 'S'));
      }
      if ($now->format('U') > $timestamp->format('U')) {
         return "idle";
      } else {
         return "<span class=\"label label-warning\">".$mode."</span>";
      }
   }
}

function getDSTARLinks() {
   // returns link-states of all D-Star-modules
   if (filesize(LINKLOGPATH."/Links.log") == 0) {
      return "not linked";
   }
   $out = "<table>";
   if ($linkLog = fopen(LINKLOGPATH."/Links.log",'r')) {
      while ($linkLine = fgets($linkLog)) {
         $linkDate = "&nbsp;";
         $protocol = "&nbsp;";
         $linkType = "&nbsp;";
         $linkSource = "&nbsp;";
         $linkDest = "&nbsp;";
         $linkDir = "&nbsp;";
// Reflector-Link, sample:
// 2011-09-22 02:15:06: DExtra link - Type: Repeater Rptr: DB0LJ  B Refl: XRF023 A Dir: Outgoing
// 2012-04-03 08:40:07: DPlus link - Type: Dongle Rptr: DB0ERK B Refl: REF006 D Dir: Outgoing
// 2012-04-03 08:40:07: DCS link - Type: Repeater Rptr: DB0ERK C Refl: DCS001 C Dir: Outgoing
         if(preg_match_all('/^(.{19}).*(D[A-Za-z]*).*Type: ([A-Za-z]*).*Rptr: (.{8}).*Refl: (.{8}).*Dir: (.{8})/',$linkLine,$linx) > 0){
            $linkDate = $linx[1][0];
            $protocol = $linx[2][0];
            $linkType = $linx[3][0];
            $linkSource = $linx[4][0];
            $linkDest = $linx[5][0];
            $linkDir = $linx[6][0];
         }
// CCS-Link, sample:
// 2013-03-30 23:21:53: CCS link - Rptr: PE1AGO C Remote: PE1KZU  Dir: Incoming
         if(preg_match_all('/^(.{19}).*(CC[A-Za-z]*).*Rptr: (.{8}).*Remote: (.{8}).*Dir: (.{8})/',$linkLine,$linx) > 0){
            $linkDate = $linx[1][0];
            $protocol = $linx[2][0];
            $linkType = $linx[2][0];
            $linkSource = $linx[3][0];
            $linkDest = $linx[4][0];
            $linkDir = $linx[5][0];
         }
// Dongle-Link, sample:
// 2011-09-24 07:26:59: DPlus link - Type: Dongle User: DC1PIA Dir: Incoming
// 2012-03-14 21:32:18: DPlus link - Type: Dongle User: DC1PIA Dir: Incoming
         if(preg_match_all('/^(.{19}).*(D[A-Za-z]*).*Type: ([A-Za-z]*).*User: (.{6,8}).*Dir: (.*)$/',$linkLine,$linx) > 0){
            $linkDate = $linx[1][0];
            $protocol = $linx[2][0];
            $linkType = $linx[3][0];
            $linkSource = "&nbsp;";
            $linkDest = $linx[4][0];
            $linkDir = $linx[5][0];
         }
         $out .= "<tr><td>" . $linkSource . "</td><td>&nbsp;" . $protocol . "-link</td><td>&nbsp;to&nbsp;</td><td>" . $linkDest . "</td><td>&nbsp;" . $linkDir . "</td></tr>";
      }
   }
   $out .= "</table>";

   fclose($linkLog);
   return $out;
}

function getActualLink($logLines, $mode) {
   // returns actual link state of specific mode
//M: 2016-05-02 07:04:10.504 D-Star link status set to "Verlinkt zu DCS002 S"
//M: 2016-04-03 16:16:18.638 DMR Slot 2, received network voice header from 4000 to 2625094
//M: 2016-04-03 19:30:03.099 DMR Slot 2, received network voice header from 4020 to 2625094
   switch ($mode) {
      case "D-Star":
         if (isProcessRunning(IRCDDBGATEWAY)) {
            return getDSTARLinks();
         } else {
            return "ircddbgateway not running!";
         }
         break;
      case "DMR Slot 1":
         foreach ($logLines as $logLine) {
            if(strpos($logLine,"unable to decode the network CSBK")) {
               continue;
            } else if(substr($logLine, 27, strpos($logLine,",") - 27) == "DMR Slot 1") {
               $to = "";
               if (strpos($logLine,"to")) {
                  $to = trim(substr($logLine, strpos($logLine,"to") + 3));
               }
               if ($to !== "") {
                  return $to;
               }
            }
         }
         return "not linked";
         break;
      case "DMR Slot 2":
         foreach ($logLines as $logLine) {
            if(strpos($logLine,"unable to decode the network CSBK")) {
               continue;
            } else if(substr($logLine, 27, strpos($logLine,",") - 27) == "DMR Slot 2") {
               $to = "";
               if (strpos($logLine,"to")) {
                  $to = trim(substr($logLine, strpos($logLine,"to") + 3));
               }
               if ($to !== "") {
                  return $to;
               }
            }
         }
         return "not linked";
         break;
      case "YSF":

// 00000000001111111111222222222233333333334444444444555555555566666666667777777777888888888899999999990000000000111111111122
// 01234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901
// M: 2016-09-25 16:08:05.811 Connect to 62829 has been requested by DG9VH
// M: 2016-10-01 17:52:36.586 Automatic connection to 62829

         if (isProcessRunning("YSFGateway")) {
            foreach($logLines as $logLine) {
               $to = "";
               if (strpos($logLine,"Connect to")) {
                  $to = substr($logLine, 38, 5);
               }
               if (strpos($logLine,"Automatic connection to")) {
                  $to = substr($logLine, 51, 5);
               }
               if ($to !== "") {
                  return $to;
               }
               if (strpos($logLine,"Starting YSFGateway")) {
                  $to = -1;
               }
               if (strpos($logLine,"DISCONNECT Reply")) {
                  $to = -1;
               }
            }
            return -1;
            break;
         } else {
            return -2;
            break;
         }

   }
   return "something went wrong!";
}

function getActualReflector($logLines, $mode) {
   // returns actual link state of specific mode
//M: 2016-05-02 07:04:10.504 D-Star link status set to "Verlinkt zu DCS002 S"
//M: 2016-04-03 16:16:18.638 DMR Slot 2, received network voice header from 4000 to 2625094
//M: 2016-04-03 19:30:03.099 DMR Slot 2, received network voice header from 4020 to 2625094
   foreach ($logLines as $logLine) {
      if(substr($logLine, 27, strpos($logLine,",") - 27) == "DMR Slot 2") {
         $from = substr($logLine, strpos($logLine,"from") + 5, strpos($logLine,"to") - strpos($logLine,"from") - 6);

         if (strlen($from) == 4 && startsWith($from,"4")) {
            if ($from == "4000") {
               return "Reflector not linked";
            } else {
               return "Reflector ".$from;
            }
         }
         $source = "RF";
         if (strpos($logLine,"network") > 0 ) {
            $source = "Net";
         }

         if ( $source == "RF") {
            $to = substr($logLine, strpos($logLine, "to") + 3);
            if (strlen($to) < 6 && startsWith($to, "4")) {
               return "Reflector ".$to." (not cfmd)";
            }
         }
      }
   }
   return "Reflector not linked";
}

function getActiveYSFReflectors() {
   $reflectorlist = Array();
   $file = fopen(YSFHOSTSPATH."/".YSFHOSTSFILENAME, 'r');
   if ($file) {
      while (($line = fgetcsv($file, 1000, ";")) !== FALSE) {
         array_push($reflectorlist, array($line[1], $line[2], $line[0], $line[5]));
      }
   }
   fclose($file);
   return $reflectorlist;
}

function getYSFReflectorById($id, $reflectors) {
   if ($id ==-1) {
      return "not linked";
   } else if ($id == -2 ) {
      return "YSFGateway not running";
   } else {
      foreach($reflectors as $reflector) {
         if ($reflector[2] === $id) {
            return $reflector[0];
         }
      }
   }
}

/*
function getNames($delimiter) {
   if (!isset($_SESSION['dmrIDs'])) {
      $dmrIDs = Array();
      $file = fopen(DMRIDDATPATH, 'r');
      if ($file) {
         while (($line = fgetcsv($file, 1000, $delimiter)) !== FALSE) {
            array_push($dmrIDs, array('id'=>$line[0], 'callsign'=>$line[1], 'name'=>$line[2]));
         }
      }
      $_SESSION['dmrIDs'] = $dmrIDs;
   }
}
function getName($callsign) {
   $dmrIDs = $_SESSION['dmrIDs'];
   $key = array_search("$callsign", array_column($dmrIDs, 'callsign'));
   //return $key;
   $dmrID = $_SESSION['dmrIDs'][$key];
   //var_dump($dmrID);
   return $dmrID['name'];
}

function getName($callsign) {
// var_dump($_SESSION['dmrIDs']);
   foreach ($_SESSION['dmrIDs'] as $dmrID) {
      if ($dmrID[1] == $callsign) {
         return $dmrID[2];
      }
   }
   return "---";
}
*/

function getName($callsign) {
   if (is_numeric($callsign)) {
      return "---";
   }

   if (file_exists(DMRIDDATPATH)) {
      $callsign = trim($callsign);
      if (strpos($callsign,"-")) {
         $callsign = substr($callsign,0,strpos($callsign,"-"));
      }
      $delimiter =" ";
      exec("grep -P '".$callsign.$delimiter."' ".DMRIDDATPATH, $output);
      if (count($output) == 0) {
         $delimiter = "\t";
         exec("grep -P '".$callsign.$delimiter."' ".DMRIDDATPATH, $output);
      }
      if (count($output) !== 0) {
         $name = substr($output[0], strpos($output[0],$delimiter)+1);
         $name = substr($name, strpos($name,$delimiter)+1);
         return $name;
      } else
         return "---";
   } else {
      return "DMRIDs.dat not correct!";
   }
}

?>
