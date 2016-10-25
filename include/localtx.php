<?php
$localTXList = getHeardList($reverseLogLinesMMDVM, FALSE);

//array_multisort($localTXList,SORT_DESC);

?>
  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading">Today's local transmissions</div>
  <!-- Tabelle -->
<div class="table-responsive">  
  <table id="localTx" class="table table-condensed table-striped table-hover">
   <thead>
    <tr>
      <th>Time (UTC)</th>
      <th>Mode</th>
      <th>Callsign</th>
      <?php
      if (defined("ENABLEXTDLOOKUP")) {
      ?>
      <th>Name</th>
      <?php
      }
      ?>
      <th>DSTAR-ID</th>
      <th>Target</th>
      <th>Source</th>
      <th>Dur (s)</th>
      <th>Loss</th>
      <th>BER</th>
    </tr>
   </thead>
   <tbody>	
<?php
for ($i = 0; $i < count($localTXList); $i++) {
	$listElem = $localTXList[$i];		
	if ($listElem[6] == "RF" && ($listElem[1]=="D-Star" || startsWith($listElem[1], "DMR") || $listElem[1]=="YSF" || $listElem[1]=="P25")) {
		echo"<tr>";
		echo"<td nowrap>$listElem[0]</td>";
		echo"<td nowrap>$listElem[1]</td>";
		if ($listElem[2] !== "??????????") {
			if (!is_numeric($listElem[2])) {
				if (constant("SHOWQRZ")) {
					echo"<td nowrap><a target=\"_new\" href=\"https://qrz.com/db/$listElem[2]\">".str_replace("0","&Oslash;",$listElem[2])."</a></td>";
				} else {
					echo"<td nowrap><a target=\"_new\" href=\"http://dmr.darc.de/dmr-userreg.php?callsign=$listElem[2]\">".$listElem[2]."</td>";
				}
			} else {
				echo"<td nowrap><a target=\"_new\" href=\"http://dmr.darc.de/dmr-userreg.php?usrid=$listElem[2]\">".$listElem[2]."</td>";
			}
		}
		if (defined("ENABLEXTDLOOKUP")) {
			echo "<td class=\"nowrap\">$listElem[3]</td>";
		}
		echo"<td nowrap>$listElem[4]</td>";
		echo"<td nowrap>$listElem[5]</td>";
		echo"<td nowrap>$listElem[6]</td>";
		if ($listElem[6] == null) {
			echo'<td  nowrap>in TX</td><td></td><td></td>';
		} else if ($listElem[7] == "SMS") {
			echo'<td nowrap>sending or receiving SMS</td><td></td><td></td>';
		} else {
			echo"<td nowrap>$listElem[7]</td>";
			echo"<td nowrap>$listElem[8]</td>";
			echo"<td nowrap>$listElem[9]</td>";
		}
		echo"</tr>\n";
	}
}

?>
  </tbody>
  </table>
 </div>
</div>

