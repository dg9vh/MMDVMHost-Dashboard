<?php

$localTXList = getHeardList($reverseLogLines);
//array_multisort($localTXList,SORT_DESC);

?>
  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading">Today's last 10 local transmissions.</div>
  <!-- Tabelle -->
  <table class="table">
    <tr>
      <th>Time (UTC)</th>
      <th>Mode</th>
      <th>Callsign</th>
      <th>DSTAR-ID</th>
      <th>Target</th>
      <th>Source</th>
      <th>Dur (s)</th>
      <th>Loss</th>
      <th>BER</th>
    </tr>
<?php
$counter = 0;
for ($i = 0; $i < count($localTXList); $i++) {
		$listElem = $localTXList[$i];
		if ($listElem[5] == "RF" && ($listElem[1]=="D-Star" || startsWith($listElem[1], "DMR") || $listElem[1]=="YSF")) {
			echo"<tr>";
			echo"<td>$listElem[0]</td>";
			echo"<td>$listElem[1]</td>";
			echo"<td>$listElem[2]</td>";
			echo"<td>$listElem[3]</td>";
			echo"<td>$listElem[4]</td>";
			echo"<td>$listElem[5]</td>";
			if ($listElem[6] == null) {
				echo'<td colspan="3">transmitting</td>';
			} else if ($listElem[6] == "SMS") {
				echo'<td colspan="3">sending or receiving SMS</td>';
			} else {
				echo"<td>$listElem[6]</td>";
				echo"<td>$listElem[7]</td>";
				echo"<td>$listElem[8]</td>";
			}
			echo"</tr>\n";
			$counter++;
			if ($counter == 10) {
				break;
			}
		}
	}

?>
  </table>
</div>
