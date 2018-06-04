<?php
//session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
include "config/config.php";

if (!defined("LOCALE"))
   define("LOCALE", "en_GB");
include "locale/".LOCALE."/settings.php";
$codeset = "UTF8";
putenv('LANG='.LANG_LOCALE.'.'.$codeset);
putenv('LANGUAGE='.LANG_LOCALE.'.'.$codeset);
bind_textdomain_codeset('messages', $codeset);
bindtextdomain('messages', dirname(__FILE__).'/locale/');
setlocale(LC_ALL, LANG_LOCALE.'.'.$codeset);
textdomain('messages');

include "include/tools.php";
include "include/functions.php";

$mmdvmconfigs = getMMDVMConfig();
if (!defined("MMDVMLOGPREFIX"))
   define("MMDVMLOGPREFIX", getConfigItem("Log", "FileRoot", $mmdvmconfigs));
if (!defined("TIMEZONE"))
   define("TIMEZONE", "UTC");
if (defined("RESOLVETGS")) {
   $tgList = getTGList();
}
$logLinesMMDVM = getMMDVMLog();
$reverseLogLinesMMDVM = $logLinesMMDVM;
rsort($reverseLogLinesMMDVM);

if ($_GET['section'] == "mode") {
   $mode = getActualMode(getLastHeard($reverseLogLinesMMDVM, TRUE), $mmdvmconfigs);
   echo $mode;
}

if ($_GET['section'] == "dstarlink") {
   $link = getActualLink($reverseLogLinesMMDVM, "D-Star");
   echo $link;
}


if ($_GET['section'] == "ysflink") {
   $logLinesYSFGateway = getYSFGatewayLog();
   $reverseLogLinesYSFGateway = $logLinesYSFGateway;
   rsort($reverseLogLinesYSFGateway);
   $activeYSFReflectors = getActiveYSFReflectors();
   $link = getActualLink($reverseLogLinesYSFGateway, "YSF");
   echo $link;
}


if ($_GET['section'] == "dmr1link") {
   $link = getActualLink($reverseLogLinesMMDVM, "DMR Slot 1");
   echo $link;
}


if ($_GET['section'] == "dmr2link") {
   $link = getActualLink($reverseLogLinesMMDVM, "DMR Slot 2")."/". getActualReflector($reverseLogLinesMMDVM, "DMR Slot 2") ;
   echo $link;
}

if ($_GET['section'] == "lastHeard") {
   $lastHeardList = getLastHeard($reverseLogLinesMMDVM, FALSE);
   $lastHeard = Array();
   for ($i = 0; $i < count($lastHeardList); $i++) {
      $listElem = $lastHeardList[$i];
      // Generate a canonicalized call for QRZ and name lookups
      $call_canon = preg_replace('/\s+\w$/', '', $listElem[2]);
      if (defined("ENABLEXTDLOOKUP")) {
      	 $listElem[11] ="";
         array_push($lastHeard, $listElem);
      } else {
         $listElem[10] ="";
         array_push($lastHeard, $listElem);
      }
   }
   echo '{"data": '.json_encode($lastHeard)."}";
}
if ($_GET['section'] == "localTx") {
   $localTXList = getHeardList($reverseLogLinesMMDVM, FALSE);
   $lastHeard = Array();
   for ($i = 0; $i < count($localTXList); $i++) {
      $listElem = $localTXList[$i];
      // Generate a canonicalized call for QRZ and name lookups
      $call_canon = preg_replace('/\s+\w$/', '', $listElem[2]);
      if (defined("ENABLEXTDLOOKUP")) {
      	 $listElem[11] ="";
         if ($listElem[6] == "RF" && ($listElem[1]=="D-Star" || startsWith($listElem[1], "DMR") || $listElem[1]=="YSF" || $listElem[1]=="P25" || $listElem[1]=="NXDN")) {
            $listElem[3] = getName($call_canon);
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
         }
      } else {
          $listElem[10] ="";
         if ($listElem[5] == "RF" && ($listElem[1]=="D-Star" || startsWith($listElem[1], "DMR") || $listElem[1]=="YSF" || $listElem[1]=="P25" || $listElem[1]=="NXDN")) {
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
         }
      }
   }
   echo '{"data": '.json_encode($lastHeard)."}";
}

if ($_GET['section'] == "sysinfo") {
   $cputemp = NULL;
   $cpufreq = NULL;
   if (file_exists ("/sys/class/thermal/thermal_zone0/temp")) {
      exec("cat /sys/class/thermal/thermal_zone0/temp", $cputemp);
      $cputemp = $cputemp[0] / 1000;
   }
   showLapTime("cputemp");
   if (file_exists ("/sys/devices/system/cpu/cpu0/cpufreq/scaling_cur_freq")) {
      exec("cat /sys/devices/system/cpu/cpu0/cpufreq/scaling_cur_freq", $cpufreq);
      $cpufreq = $cpufreq[0] / 1000;
   }
   showLapTime("cpufreq");

   if (defined("TEMPERATUREALERT") && $cputemp > TEMPERATUREHIGHLEVEL && $cputemp !== NULL) {
?>
      <script>
         function deleteLayer(id) {
            if (document.getElementById && document.getElementById(id)) {
               var theNode = document.getElementById(id);
               theNode.parentNode.removeChild(theNode);
            }
            else if (document.all && document.all[id]) {
               document.all[id].innerHTML='';
               document.all[id].outerHTML='';
            }
            // OBSOLETE CODE FOR NETSCAPE 4
            else if (document.layers && document.layers[id]) {
               document.layers[id].visibility='hide';
               delete document.layers[id];
            }
         }

         function makeLayer(id,L,T,W,H,bgColor,visible,zIndex) {
            if (document.getElementById) {
               if (document.getElementById(id)) {
                  alert ('Layer with this ID already exists!');
                  return;
               }
               var ST = 'position:absolute; text-align:center;padding-top:20px;'
               +'; left:'+L+'px'
               +'; top:'+T+'px'
               +'; width:'+W+'px'
               +'; height:'+H+'px'
               +'; clip:rect(0,'+W+','+H+',0)'
               +'; visibility:'
               +(null==visible || 1==visible ? 'visible':'hidden')
               +(null==zIndex  ? '' : '; z-index:'+zIndex)
               +(null==bgColor ? '' : '; background-color:'+bgColor);

               var LR = '<DIV id='+id+' style="'+ST+'">CPU-Temperature is very high!<br><input type="button" value="Close" onclick="deleteLayer(\'LYR1\')"></DIV>';

               if (document.body) {
                  if (document.body.insertAdjacentHTML)
                     document.body.insertAdjacentHTML("BeforeEnd",LR);
                  else if (document.createElement && document.body.appendChild) {
                     var newNode = document.createElement('div');
                     newNode.setAttribute('id',id);
                     newNode.setAttribute('style',ST);
                     document.body.appendChild(newNode);
                  }
               }
            }
         }
         var audio = new Audio('sounds/alert.mp3');
         audio.play();
         var x = window.innerWidth/2-100;
         var y = window.innerHeight/2-50;

         makeLayer('LYR1',x,y,200,100,'red',1,1);
      </script>
<?php
   }

   $output         = shell_exec('cat /proc/loadavg');
   $loadavg	   = explode(" ", $output);
   $sysload	   = $loadavg[0] . " / " . $loadavg[1] . " / " . $loadavg[2];
   Showlaptime("sysload");
   $stat1          = file('/proc/stat');
   sleep(1);
   $stat2          = file('/proc/stat');
   $info1          = explode(" ", preg_replace("!cpu +!", "", $stat1[0]));
   $info2          = explode(" ", preg_replace("!cpu +!", "", $stat2[0]));
   $dif            = array();
   $dif['user']    = $info2[0] - $info1[0];
   $dif['nice']    = $info2[1] - $info1[1];
   $dif['sys']     = $info2[2] - $info1[2];
   $dif['idle']    = $info2[3] - $info1[3];
   $total          = array_sum($dif);
   $cpu            = array();
   foreach($dif as $x=>$y) $cpu[$x] = round($y / $total * 100, 1);
   $cpuusage   = round($cpu['user'] + $cpu['sys'], 2);
   showLapTime("cpuusage");

   $output     = shell_exec('grep -c processor /proc/cpuinfo');
   $cpucores   = $output;

   $output     = shell_exec('cat /proc/uptime');
   $uptime     = format_time(substr($output,0,strpos($output," ")));
   $idletime   = format_time((substr($output,strpos($output," ")))/$cpucores);
   showLapTime("idletime");

   if (defined("SHOWPOWERSTATE")) {
      $pinStatus = trim(shell_exec("gpio -g read ".POWERONLINEPIN)); // Pin 18
   }
   //returns 0 = low; 1 = high
?>
<tbody>
            <tr>
               <?php
               if (defined("SHOWPOWERSTATE")) {
               ?>
               <th><?php echo _("Power"); ?></th>
               <?php
               }
               if ($cputemp !== NULL) {
               ?>
               <th><?php echo _("CPU-Temperature"); ?></th>
               <?php
               }
               if ($cpufreq !== NULL) {
               ?>
               <th><?php echo _("CPU-Frequency");?></th>
               <?php
               }
               ?>
               <th><?php echo _("System-Load"); ?></th>
               <th><?php echo _("CPU-Usage"); ?></th>
               <th><?php echo _("Uptime"); ?></th>
               <th><?php echo _("Idle"); ?></th>
            </tr>
            <tr class="gatewayinfo">
               <?php
               if (defined("SHOWPOWERSTATE")) {
               ?>
               <td><?php if ($pinStatus == POWERONLINESTATE ) {echo _("online");} else {echo _("on battery");} ?></td>
               <?php
               }
               if ($cputemp !== NULL) {
               ?>
               <td><?php echo $cputemp; ?> &deg;C</td>
               <?php
               }
               if ($cpufreq !== NULL) {
               ?>
               <td><?php echo $cpufreq; ?> MHz</td>
               <?php
               }
               ?>
               <td><?php echo $sysload; ?></td>
               <td>
<?php
   if (defined("SHOWPROGRESSBARS")) {
?>
                  <div class="progress"><div class="progress-bar <?php
      if ($cpuusage < 30)
         echo "progress-bar-success";
      if ($cpuusage >= 30 and $cpuusage < 60)
         echo "progress-bar-warning";
      if ($cpuusage >= 60)
         echo "progress-bar-danger";
?>" role="progressbar" aria-valuenow="<?php echo $cpuusage; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo intval($cpuusage); ?>%;"><?php echo $cpuusage; ?>%</div></div>
<?php
   } else {
      echo $cpuusage." %";
   }
?>
               </td>
               <td><?php echo $uptime; ?></td>
               <td><?php echo $idletime; ?></td>
            </tr>
         </tbody>
<?php
}
?>
