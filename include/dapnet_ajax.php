<?php
?>
  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading"><?php echo _("DAPNET transmissions"); ?><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span></div>
  <div class="panel-body">
  <!-- Tabelle -->
  <div class="table-responsive">
  <table id="DAPNETTx" class="table DAPNETTx table-condensed table-striped table-hover">
        <thead>
            <tr>
                <th><?php echo _("Time"); ?> (<?php echo TIMEZONE;?>)</th>
                <th><?php echo _("Slot"); ?></th>
                <th><?php echo _("Target"); ?></th>
                <th><?php echo _("Message"); ?></th>
            </tr>
        </thead>
    </table>
  </div>
  </div>
</div>
<script>
$(document).ready(function(){
   var DAPNETTxT = $('#DAPNETTx').dataTable( {
    "language": <?php echo DATATABLESTRANSLATION; ?>,
    "aaSorting": [[0,'desc']],

   <?php $request = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['SERVER_NAME']}:{$_SERVER['SERVER_PORT']}/{$_SERVER['REQUEST_URI']}";
   if (strpos($request,"index.php")> 0) {
      $request = substr($request,0,strpos($request,"index.php"));
   }
   if (strpos($request,"?stoprefresh")> 0) {
      $request = substr($request,0,strpos($request,"?stoprefresh"));
   }
   ?>
   "ajax": '<?php echo $request?>/ajax.php?section=DAPNETTx',
   "deferRender": true
  } );

<?php
   if (!isset($_GET['stoprefresh'])) {
?>
setInterval( function () {
    DAPNETTxT.api().ajax.reload( );
}, <?php echo REFRESHAFTER * 1000 ?> );
<?php
   }
?>
});
</script>
