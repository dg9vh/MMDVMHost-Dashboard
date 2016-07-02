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
				$timestamp = $reflector[4];
				$timestamp2 = new DateTime($timestamp);
				$now =  new DateTime();
				$timestamp2->add(new DateInterval('PT60M'));
			    if ($now->format('U') >= $timestamp2->format('U')) {
					echo "<tr class=\"danger\">";
				} else {
					$timestamp2 = new DateTime($timestamp);
					$timestamp2->add(new DateInterval('PT30M'));
				    if ($now->format('U') >= $timestamp2->format('U')) {
						echo "<tr class=\"warning\">";
					} else {echo "<tr>";
					}
				}
				echo "<td>$counter</td>";
				for ($i = 0; $i < 5; $i++) {
					echo"<td>$reflector[$i]</td>";
				}
				echo "</tr>\n";
				$counter++;
			}
		}
?>
  </table>
</div>
