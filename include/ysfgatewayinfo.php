<?php
?>
  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading">YSFGateway-Infos</div>
  <!-- Tabelle -->
  <table class="table">
    <tr>
    <td><span class="label <?php 
		if (isProcessRunning("YSFGateway")) {
			echo "label-success";	
			?>">YSFGateway Process is running</span></td><?php
		} else {
			echo "label-danger\" title=\"YSFGateway is down!";
			?>">YSFGateway Process is down!</span></td><?php
		}
    ?>
    </tr>
  </table>
</div>
  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading">YSFReflectors reported active last 2 hours</div>
  <!-- Tabelle -->
  <table class="table">

<?php
	
		$activeYSFReflectors = getActiveYSFReflectors($reverseLogLinesYSFGateway);
		if (count($activeYSFReflectors) > 0) {
		?>
			<tr>
				<th>No.</th>
				<th>Name</th>
				<th>Description</th>
				<th>ID</th>
				<th>Connections</th>
				<th>Last info of</th>
			</tr>
			<?php
			$counter = 1;
			foreach ($activeYSFReflectors as $reflector) {
				echo "<tr>";
				echo "<td>$counter</td>";
				for ($i = 0; $i < 5; $i++) {
					echo"<td>$reflector[$i]</td>";
				}
				echo "</tr>";
				$counter++;
			}
		}
?>
  </table>
</div>
