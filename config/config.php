<?php
date_default_timezone_set('UTC');
define("REPEATERCALLSIGN","DG9VH");
define("MMDVMLOGPATH","/mnt/ramdisk/"); // hint: add trailing / !!!
define("MMDVMLOGPREFIX","MMDVM");
define("MMDVMLOGFILE",MMDVMLOGPATH . MMDVMLOGPREFIX . "-" . date("Y-m-d") . ".log");

// enter exact path to your log files.
// If your Linux is a MARYLAND-DSTAR-Image, this paths would work.

// Adjust to suit, uncomment correct line, if no line is uncommented, customize
// else-path to suitable paths.

define("DISTRIBUTION","MARYLAND");
//define("DISTRIBUTION","WESTERN");
//define("DISTRIBUTION","DL5DI_DEBIAN");
//define("DISTRIBUTION","DL5DI_CENTOS");
//define("DISTRIBUTION","OTHER");

switch (DISTRIBUTION) {
	case "MARYLAND":
// Configuration for Maryland-Dstar-Image
		define("LOGPATH", "/var/log");
		define("CONFIGPATH", "/etc/gateway");
		define("DSTARREPEATERLOGPATH", LOGPATH. "/dstarrepeater_1");
		define("DSTARREPEATERLOGFILENAME", "DStarRepeater_Repeater-1-");
		define("LINKLOGPATH", LOGPATH . "/gateway/Links.log");
		define("HRDLOGPATH", LOGPATH . "/gateway/Headers.log");
		break;
	case "WESTERN":
// Configuration for Western-Dstar-Image
		define("LOGPATH", "/var/log");
		define("CONFIGPATH", "/etc");
		define("DSTARREPEATERLOGPATH", LOGPATH. "/");
		define("DSTARREPEATERLOGFILENAME", "DStarRepeater-");
		define("LINKLOGPATH", LOGPATH . "/Links.log");
		define("HRDLOGPATH", LOGPATH . "/Headers.log");
		break;
	case "DL5DI_CENTOS":
// Configuration for DL5DI-Installation-packages on CENTOS
		define("LOGPATH", "/var/log/dstar");
		define("CONFIGPATH", "/etc");
	        define("DSTARREPEATERLOGPATH", LOGPATH. "/");
	        define("DSTARREPEATERLOGFILENAME", "DStarRepeater_1-");
	        define("LINKLOGPATH", LOGPATH . "/Links.log");
	        define("HRDLOGPATH", LOGPATH . "/Headers.log");
		break;
	case "DL5DI_DEBIAN":
// Configuration for DL5DI-Installation-packages on DEBIAN
		define("LOGPATH", "/var/log/opendv");
		define("CONFIGPATH", "/home/opendv/ircddbgateway");
	        define("DSTARREPEATERLOGPATH", LOGPATH. "/");
	        define("DSTARREPEATERLOGFILENAME", "DStarRepeater_1-");
	        define("LINKLOGPATH", LOGPATH . "/Links.log");
	        define("HRDLOGPATH", LOGPATH . "/Headers.log");
		break;
	case "OTHER":
// Configuration for all others, please customize
// if necessary
		define("LOGPATH", "/var/log");
		define("CONFIGPATH", "/etc");
		define("DSTARREPEATERLOGPATH", LOGPATH. "/");
		define("DSTARREPEATERLOGFILENAME", "DStarRepeater-");
		define("LINKLOGPATH", LOGPATH . "/Links.log");
		define("HRDLOGPATH", LOGPATH . "/Headers.log");
		break;
}


define("CONFIGFILENAME","ircddbgateway");
define("GATEWAYCONFIGPATH", CONFIGPATH."/".CONFIGFILENAME);

define("REFRESHAFTER","60");
define("TEMPERATUREALERT",true);
define("TEMPERATUREHIGHLEVEL", 60);
define("SHOWPROGRESSBARS", true);
define("LHLINES", 20);
?>