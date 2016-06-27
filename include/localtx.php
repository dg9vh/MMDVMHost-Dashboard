<?php

$localTXList = getHeardList($reverseLogLinesMMDVM);
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
$counter = 0;
for ($i = 0; $i < count($localTXList); $i++) {
		$listElem = $localTXList[$i];		
		if ($listElem[5] == "RF" && ($listElem[1]=="D-Star" || startsWith($listElem[1], "DMR") || $listElem[1]=="YSF")) {
			echo"<tr>";
			echo"<td nowrap>$listElem[0]</td>";
			echo"<td nowrap>$listElem[1]</td>";
			echo"<td nowrap>$listElem[2]</td>";
			echo"<td nowrap>$listElem[3]</td>";
			echo"<td nowrap>$listElem[4]</td>";
			echo"<td nowrap>$listElem[5]</td>";
			if ($listElem[6] == null) {
				echo'<td  nowrap>in TX</td><td></td><td></td>';
			} else if ($listElem[6] == "SMS") {
				echo'<td nowrap>sending or receiving SMS</td><td></td><td></td>';
			} else {
				echo"<td nowrap>$listElem[6]</td>";
				echo"<td nowrap>$listElem[7]</td>";
				echo"<td nowrap>$listElem[8]</td>";
			}
			echo"</tr>\n";
			$counter++;
		}
	}

?>
   
  </tbody>
  </table>
 </div>
</div>

