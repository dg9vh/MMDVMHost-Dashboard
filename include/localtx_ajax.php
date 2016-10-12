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
	"ajax": '<?php
	$protocol = "http";
	if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) 
  		$protocol = "https";
  	echo $protocol."://";
	$base_dir  = __DIR__; // Absolute path to your installation, ex: /var/www/mywebsite
	$base_dir = substr($basedir,0,strpos($basedir,"include"));
	$doc_root  = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']); # ex: /var/www
	echo $_SERVER['HTTP_HOST'].preg_replace("!^${doc_root}!", '', $base_dir) ?>/ajax.php?section=localTx',
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
