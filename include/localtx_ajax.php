<?php
$totalLH = count($lastHeard);
?>
  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading"><?php echo _("Today's local transmissions"); ?><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span></div>
  <div class="panel-body">
  <!-- Tabelle -->
  <div class="table-responsive">
  <table id="localTx" class="table localTx table-condensed table-striped table-hover">
        <thead>
            <tr>
      <th><?php echo _("Time"); ?> (<?php echo TIMEZONE;?>)</th>
      <th><?php echo _("Mode"); ?></th>
      <th><?php echo _("Callsign"); ?></th>
      <?php
      if (defined("ENABLEXTDLOOKUP")) {
      ?>
      <th><?php echo _("Name"); ?></th>
      <?php
      }
      ?>
      <th><?php echo _("DSTAR-ID"); ?></th>
      <th><?php echo _("Target"); ?></th>
      <th><?php echo _("Source"); ?></th>
      <th><?php echo _("Dur (s)"); ?></th>
      <th><?php echo _("Loss"); ?></th>
      <th><?php echo _("BER"); ?></th>
      <?php
      if (constant("RSSI") == "min") echo "<th>"._("RSSI (min)")."</th>";
      else if (constant("RSSI") == "max") echo "<th>"._("RSSI (max)")."</th>";
      else if (constant("RSSI") == "avg") echo "<th>"._("RSSI (avg)")."</th>";
      else if (constant("RSSI") == "all") echo "<th>"._("RSSI (min/max/avg)")."</th>";
      else echo "<th>"._("RSSI (avg)")."</th>"; 
      ?>
            </tr>
        </thead>
    </table>
  </div>
  </div>
</div>
<script>
$(document).ready(function(){
   var localTxT = $('#localTx').dataTable( {
    "language": <?php echo DATATABLESTRANSLATION; ?>,
    "aaSorting": [[0,'desc']],

   <?php $request = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$_SERVER['REQUEST_URI']}";
   if (strpos($request,"index.php")> 0) {
      $request = substr($request,0,strpos($request,"index.php"));
   }
   if (strpos($request,"?stoprefresh")> 0) {
      $request = substr($request,0,strpos($request,"?stoprefresh"));
   }
   ?>
   "ajax": '<?php echo $request?>/ajax.php?section=localTx',
   "deferRender": true
  } );

<?php
   if (!isset($_GET['stoprefresh'])) {
?>
setInterval( function () {
    localTxT.api().ajax.reload( );
}, <?php echo REFRESHAFTER * 1000 ?> );
<?php
   }
?>
});
</script>
