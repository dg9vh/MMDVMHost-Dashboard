  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading">Enabled Modes</div>
  <!-- Tabelle -->
  <div class="table-responsive">  
  <table class="table">
    <tr>
    <?php showMode("DMR", $mmdvmconfigs);?>
    <?php showMode("DMR Network", $mmdvmconfigs);?>
    <?php showMode("D-Star", $mmdvmconfigs);?>
    <?php showMode("D-Star Network", $mmdvmconfigs);?>
    <?php showMode("System Fusion", $mmdvmconfigs);?>
    <?php showMode("System Fusion Network", $mmdvmconfigs);?>
    <?php showMode("P25", $mmdvmconfigs);?>
    <?php showMode("P25 Network", $mmdvmconfigs);?>
    </tr>
  </table>
  </div>
</div>
