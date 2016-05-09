<?php
$lastHeard = getLastHeard($logLines);
?>
  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading">Last Heard List of today's <?php echo LHLINES; ?> callsigns.</div>
  <!--<div class="panel-body">
    <p>In the following table you will find a maximum of the last <?php echo LHLINES; ?> callsigns heard on this repeater for the current day</p>
  </div>-->

  <!-- Tabelle -->
  <table class="table">
    <tr>
      <th>Time (UTC)</th>
      <th>Mode</th>
      <th>Callsign</th>
      <th>DSTAR-ID</th>
      <th>Target</th>
      <th>Source</th>
      <th>Duration (s)</th>
      <th>Loss</th>
      <th>BER</th>
    </tr>
<?php
for ($i = 0; ($i < LHLINES) AND ($i < count($lastHeard)); $i++) {
		$listElem = $lastHeard[$i];
		echo"<tr>";
		echo"<td>$listElem[0]</td>";
		echo"<td>$listElem[1]</td>";
		echo"<td>$listElem[2]</td>";
		echo"<td>$listElem[3]</td>";
		echo"<td>$listElem[4]</td>";
		echo"<td>$listElem[5]</td>";
		if ($listElem[6] == null) {
			echo'<td colspan="3">transmitting</td>';	
		} else {
			echo"<td>$listElem[6]</td>";
			echo"<td>$listElem[7]</td>";
			echo"<td>$listElem[8]</td>";
		}
		echo"</tr>\n";
	}

?>
  </table>
</div>
