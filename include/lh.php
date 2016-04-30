<?php
$lastHeard = getLastHeard();
?>
  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading">Last Heard List</div>
  <div class="panel-body">
    <p>In the following table you find the last  heard callsigns on this repeater of the current day</p>
  </div>

  <!-- Tabelle -->
  <table class="table">
    <tr>
      <th>Time</th>
      <th>Mode</th>
      <th>Callsign</th>
      <th>DSTAR-ID</th>
      <th>Target</th>
    </tr>
<?php
foreach ($lastHeard as $listElem) {
		//$timestamp, $mode, $callsign, $id, $target
		echo"<tr>";
		echo"<td>$listElem[0]</td>";
		echo"<td>$listElem[1]</td>";
		echo"<td>$listElem[2]</td>";
		echo"<td>$listElem[3]</td>";
		echo"<td>$listElem[4]</td>";
		echo"</tr>";
	}

?>
  </table>
</div>