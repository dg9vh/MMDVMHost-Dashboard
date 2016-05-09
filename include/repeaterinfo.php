  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading">Repeater Info</div>
  <!--<div class="panel-body">
    <p>Some info about link states</p>
  </div>-->

  <!-- Tabelle -->
  <table class="table">
    <tr>
      <th>Actual Mode</th>
      <th>D-Star linked to</th>
      <th>DMR TS1 last linked to</th>
      <th>DMR TS2 last linked to</th>
    </tr>
<?php
	echo"<tr>";
	echo"<td>".getActualMode($logLines)."</td>";
	echo"<td>".getActualLink($logLines, "D-Star")."</td>";
	echo"<td>".getActualLink($logLines, "DMR Slot 1")."</td>";
	echo"<td>".getActualLink($logLines, "DMR Slot 2")."</td>";
	echo"</tr>\n";
?>
  </table>
</div>
