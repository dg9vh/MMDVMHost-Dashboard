<?php

include "include/tools.php";
?>
<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <!-- Das neueste kompilierte und minimierte CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Optionales Theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!-- Das neueste kompilierte und minimierte JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <title>MMDVM-Dashboard by DG9VH - Setup</title>
  </head>
  <body>
<?php
	if ($_GET['cmd'] =="writeconfig") {
		if (!file_exists('./config')) {
		    if (!mkdir('./config', 0777, true)) {
?>
<div class="alert alert-danger" role="alert">You forgot to give write-permissions to your webserver-user, see point 3 in <a href="linux-step-by-step.md">linux-step-by-step.md</a>!</div>

<?php
		    }
		}
		$configfile = fopen("config/config.php", 'w');
		fwrite($configfile,"<?php\n");
		fwrite($configfile,"# This is an auto-generated config-file!\n");
		fwrite($configfile,"# Be careful, when manual editing this!\n\n");
		fwrite($configfile,"date_default_timezone_set('UTC');\n");
		fwrite($configfile, createConfigLines());
		fwrite($configfile,"?>\n");
		fclose($configfile);
?>
  <div class="page-header">
    <h1><small>MMDVM-Dashboard by DG9VH</small> Setup-Process</h1>
    <div class="alert alert-success" role="alert">Your config-file is written in config/config.php, please remove setup.php for security reasons!</div>
    <p><a href="index.php">Your dashboard is now available.</a></p>
  </div>
<?php
	} else {
?>
  <div class="page-header">
    <h1><small>MMDVM-Dashboard by DG9VH</small> Setup-Process</h1>
    <h4>Please give necessary information below</h4>
  </div>
  <form id="config" action="setup.php" method="get">
    <input type="hidden" name="cmd" value="writeconfig">
    <div class="container">
      <h2>MMDVMHost-Configuration</h2>
      <div class="input-group">
        <span class="input-group-addon" id="MMDVMLOGPATH" style="width: 300px">Path to MMDVMHost-logfile</span>
        <input type="text" name="MMDVMLOGPATH" class="form-control" placeholder="/var/log/mmdvm/" aria-describedby="MMDVMLOGPATH" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="MMDVMLOGPREFIX" style="width: 300px">Logfile-prefix</span>
        <input type="text" name="MMDVMLOGPREFIX" class="form-control" placeholder="MMDVM" aria-describedby="MMDVMLOGPREFIX" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="MMDVMINIPATH" style="width: 300px">Path to MMDVM.ini</span>
        <input type="text" name="MMDVMINIPATH" class="form-control" placeholder="/etc/mmdvm/" aria-describedby="MMDVMINIPATH" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="MMDVMINIFILENAME" style="width: 300px">MMDVM.ini-filename</span>
        <input type="text" name="MMDVMINIFILENAME" class="form-control" placeholder="MMDVM.ini" aria-describedby="MMDVMINIFILENAME" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="MMDVMHOSTPATH" style="width: 300px">Path to MMDVMHost-executable</span>
        <input type="text" name="MMDVMHOSTPATH" class="form-control" placeholder="/usr/local/bin/" aria-describedby="MMDVMHOSTPATH" required data-fv-notempty-message="Value is required">
      </div>
    </div>
    <div class="container">
      <h2>YSFGateway-Configuration</h2>
      
      <div class="input-group">
        <span class="input-group-addon" id="ENABLEYSFGATEWAY" style="width: 300px">Enable YSFGateway</span>
        <div class="panel-body"><input type="checkbox" name="ENABLEYSFGATEWAY"></div>
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="YSFGATEWAYLOGPATH" style="width: 300px">Path to YSFGateway-logfile</span>
        <input type="text" name="YSFGATEWAYLOGPATH" class="form-control" placeholder="/var/log/YSFGateway/" aria-describedby="YSFGATEWAYLOGPATH" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="YSFGATEWAYLOGPREFIX" style="width: 300px">Logfile-prefix</span>
        <input type="text" name="YSFGATEWAYLOGPREFIX" class="form-control" placeholder="YSFGateway" aria-describedby="YSFGATEWAYLOGPREFIX" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="YSFGATEWAYINIPATH" style="width: 300px">Path to YSFGateway.ini</span>
        <input type="text" name="YSFGATEWAYINIPATH" class="form-control" placeholder="/etc/YSFGateway/" aria-describedby="YSFGATEWAYINIPATH" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="YSFGATEWAYINIFILENAME" style="width: 300px">YSFGateway.ini-filename</span>
        <input type="text" name="YSFGATEWAYINIFILENAME" class="form-control" placeholder="YSFGateway.ini" aria-describedby="YSFGATEWAYINIFILENAME" required data-fv-notempty-message="Value is required">
      </div>
    </div>   
    <div class="container">
      <h2>ircddbgateway-Configuration</h2>
      <div class="input-group">
        <span class="input-group-addon" id="LINKLOGPATH" style="width: 300px">Path to Links.log</span>
        <input type="text" name="LINKLOGPATH" class="form-control" placeholder="/var/log/" aria-describedby="LINKLOGPATH" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="IRCDDBGATEWAY" style="width: 300px">Name of ircddbgateway-executeable</span>
        <input type="text" name="IRCDDBGATEWAY" class="form-control" placeholder="ircddbgatewayd" aria-describedby="IRCDDBGATEWAY" required data-fv-notempty-message="Value is required">
      </div>
    </div>
    <div class="container">
      <h2>Global Configuration</h2>
      <div class="input-group">
        <span class="input-group-addon" id="REFRESHAFTER" style="width: 300px">Refresh page after in seconds</span>
        <input type="text" name="REFRESHAFTER" class="form-control" placeholder="60" aria-describedby="REFRESHAFTER" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="SHOWPROGRESSBARS" style="width: 300px">Show progressbars</span>
        <div class="panel-body"><input type="checkbox" name="SHOWPROGRESSBARS"></div>
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="TEMPERATUREALERT" style="width: 300px">Enable CPU-temperature-warning</span>
        <div class="panel-body"><input type="checkbox" name="TEMPERATUREALERT"></div>
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="TEMPERATUREHIGHLEVEL" style="width: 300px">Warning temperature</span>
        <input type="text" name="TEMPERATUREHIGHLEVEL" class="form-control" placeholder="60" aria-describedby="TEMPERATUREHIGHLEVEL" required data-fv-notempty-message="Value is required">
      </div><!--
      <div class="input-group">
        <span class="input-group-addon" id="LHLINES" style="width: 300px">Last heard list lines:</span>
        <input type="text" name="LHLINES" class="form-control" placeholder="20" aria-describedby="LHLINES" required data-fv-notempty-message="Value is required">
      </div>-->
      <div class="input-group">
        <span class="input-group-addon" id="ENABLEMANAGEMENT" style="width: 300px">Enable Management-Functions below</span>
        <div class="panel-body"><input type="checkbox" name="ENABLEMANAGEMENT"></div>
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="REBOOTMMDVM" style="width: 300px">Reboot MMDVMHost command:</span>
        <input type="text" name="REBOOTMMDVM" class="form-control" placeholder="sudo systemctl restart mmdvmhost.service" aria-describedby="REBOOTMMDVM">
      </div>	
      <div class="input-group">
        <span class="input-group-addon" id="REBOOTSYS" style="width: 300px">Reboot system command:</span>
        <input type="text" name="REBOOTSYS" class="form-control" placeholder="sudo reboot" aria-describedby="REBOOTSYS">
      </div>	  
      <div class="input-group">
        <span class="input-group-addon" id="HALTSYS" style="width: 300px">Halt system command:</span>
        <input type="text" name="HALTSYS" class="form-control" placeholder="sudo halt" aria-describedby="HALTSYS">
      </div>	  
      <div class="input-group">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit" form="config">Save configuration</button>
      </span>      
      </div>
    </div>
  </form>
  <?php
	}
  ?>
  </body>
</html>
