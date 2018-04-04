<?php
//session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
include "config/config.php";
include "include/tools.php";
include "include/functions.php";
$mmdvmconfigs = getMMDVMConfig();
if (defined("RESOLVETGS")) {
   $tgList = getTGList();
}
if (!defined("MMDVMLOGPREFIX"))
   define("MMDVMLOGPREFIX", getConfigItem("Log", "FileRoot", $mmdvmconfigs));
if (!defined("TIMEZONE"))
   define("TIMEZONE", "UTC");
$logLinesMMDVM = getShortMMDVMLog();
$reverseLogLinesMMDVM = $logLinesMMDVM;
array_multisort($reverseLogLinesMMDVM,SORT_DESC);
$lastHeard = getLastHeard($reverseLogLinesMMDVM, True);
$counter = 0;
foreach ($lastHeard as $listElem) {
   $counter +=1;
   echo"<!--";
   var_dump($listElem);
   echo"-->";
   if (defined("ENABLEXTDLOOKUP") && $listElem[7] == null || !defined("ENABLEXTDLOOKUP") && $listElem[6] == null) {
      echo "<tr>";
      echo"<td nowrap>$listElem[0]</td>";
      echo"<td nowrap>$listElem[1]</td>";
      echo"<td nowrap>$listElem[2]</td>";
      if (defined("ENABLEXTDLOOKUP")) {
         echo"<td nowrap>$listElem[3]</td>";
         if (defined("TALKERALIAS"))
           echo"<td nowrap>$listElem[11]</td>";
         echo"<td nowrap>$listElem[4]</td>";
         echo"<td nowrap>$listElem[5]</td>";
         if ($listElem[6] == "RF"){
            echo "<td nowrap><span class=\"badge badge-success\">RF</span></td>";
         }else{
            echo"<td nowrap>$listElem[6]</td>";
         }
         $d1     = new DateTime($listElem[0], new DateTimeZone(TIMEZONE));
         $d2     = new DateTime('now', new DateTimeZone(TIMEZONE));
         $diff   = $d2->getTimestamp() - $d1->getTimestamp();
         echo"<td nowrap>$diff s</td>";
      } else {
      	 if (defined("TALKERALIAS"))
           echo"<td nowrap>$listElem[10]</td>";
         echo"<td nowrap>$listElem[3]</td>";
         echo"<td nowrap>$listElem[4]</td>";
         if ($listElem[5] == "RF"){
            echo "<td nowrap><span class=\"badge badge-success\">RF</span></td>";
         }else{
            echo"<td nowrap>$listElem[5]</td>";
         }
         $tz     = new DateTimeZone(TIMEZONE);
         $d1     = new DateTime($listElem[0], $tz);
         $d2     = new DateTime('now', $tz);
         $diff   = $d2->getTimestamp() - $d1->getTimestamp();
         echo"<td nowrap>$diff s</td>";
      }
      echo "</tr>";
   } else {
      if ($counter == 1) {
      	 $colspan = 7;
         if (defined("ENABLEXTDLOOKUP")) {
            $colspan++;
         } 
         if (defined("TALKERALIAS")) {
            $colspan++;
         } 
         echo "<tr><td colspan='".$colspan."'></td></tr>";
      }
   }
}
?>
