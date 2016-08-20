<?php
include "config/config.php";
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
        <input type="text" value="<?php echo constant("MMDVMLOGPATH") ?>" name="MMDVMLOGPATH" class="form-control" placeholder="/var/log/mmdvm/" aria-describedby="MMDVMLOGPATH" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="MMDVMLOGPREFIX" style="width: 300px">Logfile-prefix</span>
        <input type="text" value="<?php echo constant("MMDVMLOGPREFIX") ?>" name="MMDVMLOGPREFIX" class="form-control" placeholder="MMDVM" aria-describedby="MMDVMLOGPREFIX" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="MMDVMINIPATH" style="width: 300px">Path to MMDVM.ini</span>
        <input type="text" value="<?php echo constant("MMDVMINIPATH") ?>" name="MMDVMINIPATH" class="form-control" placeholder="/etc/mmdvm/" aria-describedby="MMDVMINIPATH" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="MMDVMINIFILENAME" style="width: 300px">MMDVM.ini-filename</span>
        <input type="text" value="<?php echo constant("MMDVMINIFILENAME") ?>" name="MMDVMINIFILENAME" class="form-control" placeholder="MMDVM.ini" aria-describedby="MMDVMINIFILENAME" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="MMDVMHOSTPATH" style="width: 300px">Path to MMDVMHost-executable</span>
        <input type="text" value="<?php echo constant("MMDVMHOSTPATH") ?>" name="MMDVMHOSTPATH" class="form-control" placeholder="/usr/local/bin/" aria-describedby="MMDVMHOSTPATH" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="ENABLEXTDLOOKUP" style="width: 300px">Enable extended lookup (show names)</span>
        <div class="panel-body"><input type="checkbox" name="ENABLEXTDLOOKUP" <?php if (constant("ENABLEXTDLOOKUP")) echo "checked" ?>></div>
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="DMRIDDATPATH" style="width: 300px">Path to DMR-ID-Database-File</span>
        <input type="text" value="<?php echo constant("DMRIDDATPATH") ?>" name="DMRIDDATPATH" class="form-control" placeholder="/var/mmdvm/DMRIDs.dat" aria-describedby="DMRIDDATPATH">
      </div>
    </div>
    <div class="container">
      <h2>YSFGateway-Configuration</h2>
      <div class="input-group">
        <span class="input-group-addon" id="ENABLEYSFGATEWAY" style="width: 300px">Enable YSFGateway</span>
        <div class="panel-body"><input type="checkbox" name="ENABLEYSFGATEWAY" <?php if (constant("ENABLEYSFGATEWAY")) echo "checked" ?>></div>
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="YSFGATEWAYLOGPATH" style="width: 300px">Path to YSFGateway-logfile</span>
        <input type="text" value="<?php echo constant("YSFGATEWAYLOGPATH") ?>" name="YSFGATEWAYLOGPATH" class="form-control" placeholder="/var/log/YSFGateway/" aria-describedby="YSFGATEWAYLOGPATH">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="YSFGATEWAYLOGPREFIX" style="width: 300px">Logfile-prefix</span>
        <input type="text" value="<?php echo constant("YSFGATEWAYLOGPREFIX") ?>" name="YSFGATEWAYLOGPREFIX" class="form-control" placeholder="YSFGateway" aria-describedby="YSFGATEWAYLOGPREFIX">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="YSFGATEWAYINIPATH" style="width: 300px">Path to YSFGateway.ini</span>
        <input type="text" value="<?php echo constant("YSFGATEWAYINIPATH") ?>" name="YSFGATEWAYINIPATH" class="form-control" placeholder="/etc/YSFGateway/" aria-describedby="YSFGATEWAYINIPATH">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="YSFGATEWAYINIFILENAME" style="width: 300px">YSFGateway.ini-filename</span>
        <input type="text" value="<?php echo constant("YSFGATEWAYINIFILENAME") ?>" name="YSFGATEWAYINIFILENAME" class="form-control" placeholder="YSFGateway.ini" aria-describedby="YSFGATEWAYINIFILENAME">
      </div>
    </div>   
    <div class="container">
      <h2>ircddbgateway-Configuration</h2>
      <div class="input-group">
        <span class="input-group-addon" id="LINKLOGPATH" style="width: 300px">Path to Links.log</span>
        <input type="text" value="<?php echo constant("LINKLOGPATH") ?>" name="LINKLOGPATH" class="form-control" placeholder="/var/log/" aria-describedby="LINKLOGPATH">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="IRCDDBGATEWAY" style="width: 300px">Name of ircddbgateway-executeable</span>
        <input type="text" value="<?php echo constant("IRCDDBGATEWAY") ?>" name="IRCDDBGATEWAY" class="form-control" placeholder="ircddbgatewayd" aria-describedby="IRCDDBGATEWAY">
      </div>
    </div>
    <div class="container">
      <h2>Global Configuration</h2>
      <div class="input-group">
        <span class="input-group-addon" id="REFRESHAFTER" style="width: 300px">Refresh page after in seconds</span>
        <input type="text" value="<?php echo constant("REFRESHAFTER") ?>" name="REFRESHAFTER" class="form-control" placeholder="60" aria-describedby="REFRESHAFTER" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="SHOWPROGRESSBARS" style="width: 300px">Show progressbars</span>
        <div class="panel-body"><input type="checkbox" name="SHOWPROGRESSBARS" <?php if (constant("SHOWPROGRESSBARS")) echo "checked" ?>></div>
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="TEMPERATUREALERT" style="width: 300px">Enable CPU-temperature-warning</span>
        <div class="panel-body"><input type="checkbox" name="TEMPERATUREALERT" <?php if (constant("TEMPERATUREALERT")) echo "checked" ?>></div>
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="TEMPERATUREHIGHLEVEL" style="width: 300px">Warning temperature</span>
        <input type="text" value="<?php echo constant("TEMPERATUREHIGHLEVEL") ?>" name="TEMPERATUREHIGHLEVEL" class="form-control" placeholder="60" aria-describedby="TEMPERATUREHIGHLEVEL" required data-fv-notempty-message="Value is required">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="ENABLEMANAGEMENT" style="width: 300px">Enable Management-Functions below</span>
        <div class="panel-body"><input type="checkbox" name="ENABLEMANAGEMENT" <?php if (constant("ENABLEMANAGEMENT")) echo "checked" ?>></div>
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="REBOOTMMDVM" style="width: 300px">Reboot MMDVMHost command:</span>
        <input type="text" value="<?php echo constant("REBOOTMMDVM") ?>" name="REBOOTMMDVM" class="form-control" placeholder="sudo systemctl restart mmdvmhost.service" aria-describedby="REBOOTMMDVM">
      </div>	
      <div class="input-group">
        <span class="input-group-addon" id="REBOOTSYS" style="width: 300px">Reboot system command:</span>
        <input type="text" value="<?php echo constant("REBOOTSYS") ?>" name="REBOOTSYS" class="form-control" placeholder="sudo reboot" aria-describedby="REBOOTSYS">
      </div>	  
      <div class="input-group">
        <span class="input-group-addon" id="HALTSYS" style="width: 300px">Halt system command:</span>
        <input type="text" value="<?php echo constant("HALTSYS") ?>" name="HALTSYS" class="form-control" placeholder="sudo halt" aria-describedby="HALTSYS">
      </div>	  
      <div class="input-group">
        <span class="input-group-addon" id="SHOWPOWERSTATE" style="width: 300px">Show Powerstate (online or battery, wiringpi needed)</span>
        <div class="panel-body"><input type="checkbox" name="SHOWPOWERSTATE" <?php if (constant("SHOWPOWERSTATE")) echo "checked" ?>></div>
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="POWERONLINEPIN" style="width: 300px">GPIO pin to monitor:</span>
        <input type="text" value="<?php echo constant("POWERONLINEPIN") ?>" name="POWERONLINEPIN" class="form-control" placeholder="18" aria-describedby="POWERONLINEPIN">
      </div>
      <div class="input-group">
        <span class="input-group-addon" id="POWERONLINESTATE" style="width: 300px">State that signalizes online-state:</span>
        <input type="text" value="<?php echo constant("POWERONLINESTATE") ?>" name="POWERONLINESTATE" class="form-control" placeholder="1" aria-describedby="POWERONLINESTATE">
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
