  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading"><?php echo _("Repeater Info"); ?><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span></div>
  <div class="panel-body">
  <!-- Tabelle -->
  <div class="table-responsive">
  <table class="table repeaterinfo">
    <tr>
      <th><?php echo _("Current Mode"); ?></th>
<?php
   if (getEnabled("D-Star", $mmdvmconfigs) == 1) {
?>
      <th><?php echo _("D-Star linked to"); ?></th>
<?php
   }
   if (getEnabled("System Fusion", $mmdvmconfigs) == 1) {
?>
      <th><?php echo _("YSF linked to"); ?></th>
<?php
   }
   if (getEnabled("DMR", $mmdvmconfigs) == 1) {
     if (getConfigItem("DMR Network", "Slot1", $mmdvmconfigs) == "1") {
?>
      <th><?php echo _("DMR TS1 last linked to"); ?></th>
<?php
     }
?>
      <th><?php echo _("DMR TS2 last linked to"); ?></th>
<?php
   }
?>
    </tr>
<?php
   echo"<tr>";
   echo"<td id=\"mode\">".getActualMode($lastHeard, $mmdvmconfigs)."</td>";
   if (getEnabled("D-Star", $mmdvmconfigs) == 1) {
     echo"<td id=\"dstarlink\">".getActualLink($reverseLogLinesMMDVM, "D-Star")."</td>";
   }
   if (getEnabled("System Fusion", $mmdvmconfigs) == 1) {
     echo"<td id=\"ysflink\">".getActualLink($reverseLogLinesYSFGateway, "YSF")."</td>";
   }
   if (getEnabled("DMR", $mmdvmconfigs) == 1) {
     if (getConfigItem("DMR Network", "Slot1", $mmdvmconfigs) == "1") {
       echo"<td id=\"dmr1link\">".getActualLink($reverseLogLinesMMDVM, "DMR Slot 1")."</td>";
     }
     echo"<td id=\"dmr2link\">".getActualLink($reverseLogLinesMMDVM, "DMR Slot 2")."/". getActualReflector($reverseLogLinesMMDVM, "DMR Slot 2") ."</td>";
   }
   echo"</tr>\n";
?>
    <tr>
      <td colspan="5">
        <table class="table">
          <tr>
            <th><?php echo _("Location"); ?></th>
            <th><?php echo _("TX-Freq."); ?></th>
            <th><?php echo _("RX-Freq."); ?></th>
<?php
   if (getEnabled("System Fusion Network", $mmdvmconfigs) == 1) {
?>
            <th><?php echo _("YSFGateway"); ?></th>
<?php
   }
   if (getEnabled("DMR", $mmdvmconfigs) == 1) {
?>
            <th><?php echo _("DMR CC"); ?></th>
<?php
      if (getEnabled("DMR Network", $mmdvmconfigs) == 1) {
?>
            <th><?php echo _("DMR-Master"); ?></th>
            <th><?php echo _("TS1"); ?></th>
            <th><?php echo _("TS2"); ?></th>
<?php
      }
   }
?>
          </tr>
<?php
   echo"<tr>";
   echo"<td>".getConfigItem("Info", "Location", $mmdvmconfigs)."</td>";
   echo"<td>".getMHZ(getConfigItem("Info", "TXFrequency", $mmdvmconfigs))."</td>";
   echo"<td>".getMHZ(getConfigItem("Info", "RXFrequency", $mmdvmconfigs))."</td>";
   if (getEnabled("System Fusion Network", $mmdvmconfigs) == 1) {
      echo"<td>".getConfigItem("System Fusion Network", "GatewayAddress", $mmdvmconfigs)."</td>";
   }
   if (getEnabled("DMR", $mmdvmconfigs) == 1) {
      echo"<td>".getConfigItem("DMR", "ColorCode", $mmdvmconfigs)."</td>";
      if (getEnabled("DMR Network", $mmdvmconfigs) == 1) {
         echo"<td>";
         if (getDMRMasterState()) {
            echo "<span class=\"badge badge-success\" title=\"Master connected\">";
         } else {
            echo "<span class=\"badge badge-danger\" title=\"Master not connected\">";
         }
         echo getConfigItem("DMR Network", "Address", $mmdvmconfigs);
         if (strlen(getDMRNetwork()) > 0 ) {
            echo " (".getDMRNetwork().")";
         }
?>
         </span>
         </td>
            <td><span class="badge <?php
         if (getConfigItem("DMR Network", "Slot1", $mmdvmconfigs) == 1) {
            echo 'badge-success">'._("enabled");
         } else {
            echo 'badge-default">'._("disabled");
          }
    ?></span></td>
            <td><span class="badge <?php
         if (getConfigItem("DMR Network", "Slot2", $mmdvmconfigs) == 1) {
            echo 'badge-success">'._("enabled");
         } else {
            echo 'badge-default">'._("disabled");
          }
    ?></span></td>
<?php
      }
   }
?>
        </tr>
        </table>
      </td>
    </tr>
  </table>
  </div>
  </div>
</div>
