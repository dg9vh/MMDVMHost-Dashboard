  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading"><?php echo _("Enabled Modes"); ?><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span></div>
  <div class="panel-body">
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
    <?php showMode("NXDN", $mmdvmconfigs);?>
    <?php showMode("NXDN Network", $mmdvmconfigs);?>
    </tr>
  </table>
  </div>
  </div>
</div>
