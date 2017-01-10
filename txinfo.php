<?php
//session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
include "config/config.php";
include "include/tools.php";
include "include/functions.php";
$mmdvmconfigs = getMMDVMConfig();
if (!defined("MMDVMLOGPREFIX"))
   define("MMDVMLOGPREFIX", getConfigItem("Log", "FileRoot", $mmdvmconfigs));
if (!defined("TIMEZONE"))
   define("TIMEZONE", "UTC");
$logLinesMMDVM = getShortMMDVMLog();
$reverseLogLinesMMDVM = $logLinesMMDVM;
array_multisort($reverseLogLinesMMDVM,SORT_DESC);
$lastHeard = getLastHeard($reverseLogLinesMMDVM, True);
//$oldLastHeard = $_SESSION['lastHeard'];
echo"<!--";
var_dump($lastHeard);
echo"-->";
$counter = 0;
foreach ($lastHeard as $listElem) {
   $counter +=1;
   if (defined("ENABLEXTDLOOKUP") && $listElem[7] == null || !defined("ENABLEXTDLOOKUP") && $listElem[6] == null) {
      echo "<tr>";
      echo"<td nowrap>$listElem[0]</td>";
      echo"<td nowrap>$listElem[1]</td>";
      /*if ($listElem[2] !== "??????????") {
         if (!is_numeric($listElem[2])) {
            if (constant("SHOWQRZ")) {
               echo"<td nowrap><a target=\"_new\" href=\"https://qrz.com/db/$listElem[2]\">".str_replace("0","&Oslash;",$listElem[2])."</a></td>";
            } else {
               echo"<td nowrap><a target=\"_new\" href=\"http://dmr.darc.de/dmr-userreg.php?callsign=$listElem[2]\">".$listElem[2]."</td>";
            }
         } else {
            echo"<td nowrap><a target=\"_new\" href=\"http://dmr.darc.de/dmr-userreg.php?usrid=$listElem[2]\">".$listElem[2]."</td>";
         }
      }*/
      echo"<td nowrap>$listElem[2]</td>";

      if (defined("ENABLEXTDLOOKUP")) {
         //echo "<td nowrap>".getName($listElem[2])."</td>";
         echo"<td nowrap>$listElem[3]</td>";
         echo"<td nowrap>$listElem[4]</td>";
         echo"<td nowrap>$listElem[5]</td>";
         if ($listElem[6] == "RF"){
            echo "<td nowrap><span class=\"label label-success\">RF</span></td>";
         }else{
            echo"<td nowrap>$listElem[6]</td>";
         }
         $d1 = new DateTime($listElem[0], new DateTimeZone(TIMEZONE));
         $d2 = new DateTime('now', new DateTimeZone(TIMEZONE));
         $diff = $d2->getTimestamp() - $d1->getTimestamp();
         echo"<td nowrap>$diff s</td>";
      } else {
         echo"<td nowrap>$listElem[3]</td>";
         echo"<td nowrap>$listElem[4]</td>";
         if ($listElem[5] == "RF"){
            echo "<td nowrap><span class=\"label label-success\">RF</span></td>";
         }else{
            echo"<td nowrap>$listElem[5]</td>";
         }
         $tz = new DateTimeZone(TIMEZONE);
         $d1 = new DateTime($listElem[0], $tz);
         $d2 = new DateTime('now', $tz);
         $diff = $d2->getTimestamp() - $d1->getTimestamp();
         echo"<td nowrap>$diff s</td>";
      }
      echo "</tr>";
   } else {
      if ($counter == 1) {
         if (defined("ENABLEXTDLOOKUP")) {
            echo "<tr><td colspan='8'></td></tr>";
         } else {
            echo "<tr><td colspan='7'></td></tr>";
         }
      }
   }
}
?>
