<?php
$totalLH = count($lastHeard);
?>
  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading">Last Heard List of today's <?php echo $totalLH; ?> callsigns.</div>
  <!-- Tabelle -->
  <div class="table-responsive">  
  <table id="lastHeard" class="table table-condensed table-striped table-hover">
        <thead>
            <tr>
                <th>Time (UTC)</th>
      <th>Mode</th>
      <th>Callsign</th>
      <?php
      if (defined("ENABLEXTDLOOKUP")) {
      ?>
      <th>Name</th>
      <?php
      }
      ?>
      <th>DSTAR-ID</th>
      <th>Target</th>
      <th>Source</th>
      <th>Dur (s)</th>
      <th>Loss</th>
      <th>BER</th>
            </tr>
        </thead>
    </table>
  </div>  
</div>

