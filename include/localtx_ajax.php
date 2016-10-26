<?php
$totalLH = count($lastHeard);
?>
  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading">Today's local transmissions</div>
  <!-- Tabelle -->
  <div class="table-responsive">
<table id="localTx" class="table table-condensed table-striped table-hover">
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
<script>
$(document).ready(function(){
	var localTxT = $('#localTx').dataTable( {
    "aaSorting": [[0,'desc']],

	<?php $request = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$_SERVER['REQUEST_URI']}";
	if (strpos($request,"index.php")> 0) {
		$request = substr($request,0,strpos($request,"index.php"));
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
