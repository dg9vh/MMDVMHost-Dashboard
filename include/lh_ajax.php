<?php
$totalLH = count($lastHeard);
if (defined("ENABLEXTDLOOKUP") && !defined("USESQLITE")) {
$TMP_CALL_NAME = "/tmp/Callsign_Name.txt";
exec("wc -l ".$TMP_CALL_NAME." | cut -f1 -d' '", $output);
exec("wc -l ".DMRIDDATPATH." | cut -f1 -d' '", $output2);
}
?>
  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading"><?php 
  echo _("Last Heard List of today's")." ".$totalLH." "._("callsigns.")." ";
  if (defined("ENABLEXTDLOOKUP") && !defined("USESQLITE")) {
     echo _("Cached")." (".$output[0]."/".$output2[0].")";
  }
  ?><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span></div>
  <div class="panel-body">
  <!-- Tabelle -->
  <div class="table-responsive">
  <table id="lastHeard" class="table lastHeard table-condensed table-striped table-hover">
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
            </tr>
        </thead>
    </table>
  </div>
  </div>
</div>
<script>
$(document).ready(function(){
  var lastHeardT = $('#lastHeard').dataTable( {
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
   "ajax": '<?php echo $request?>/ajax.php?section=lastHeard',
   "deferRender": true
  } );

<?php
   if (!isset($_GET['stoprefresh'])) {
?>
setInterval( function () {
    lastHeardT.api().ajax.reload( );
}, <?php echo REFRESHAFTER * 1000 ?> );
<?php
   }
?>
});
</script>
