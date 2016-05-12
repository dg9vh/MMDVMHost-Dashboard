<?php
date_default_timezone_set('UTC');
define("MMDVMLOGPATH", "/mnt/ramdisk/"); // hint: add trailing / !!!
define("MMDVMLOGPREFIX", "MMDVM");
define("MMDVMLOGFILE", MMDVMLOGPATH . MMDVMLOGPREFIX . "-" . date("Y-m-d") . ".log");
define("MMDVMINIPATH", "/etc/mmdvm/"); // hint: add trailing / !!!
define("MMDVMHOSTPATH", "/usr/local/bin/"); // hint: add trailing / !!!

// enter exact path to your log files.
// If your Linux is a MARYLAND-DSTAR-Image, this paths would work.

// Adjust to suit, uncomment correct line, if none of the given distributions fit, customize
// OTHER to suitable paths.

//define("DISTRIBUTION", "MARYLAND");
define("DISTRIBUTION", "WESTERN");
//define("DISTRIBUTION", "DL5DI_DEBIAN");
//define("DISTRIBUTION", "DL5DI_CENTOS");
//define("DISTRIBUTION", "OTHER");

switch (DISTRIBUTION) {
	case "MARYLAND":
// Configuration for Maryland-Dstar-Image
		define("LOGPATH", "/var/log");
		define("CONFIGPATH", "/etc/gateway");
		define("DSTARREPEATERLOGPATH", LOGPATH . "/dstarrepeater_1");
		define("DSTARREPEATERLOGFILENAME", "DStarRepeater_Repeater-1-");
		define("LINKLOGPATH", LOGPATH . "/gateway/Links.log");
		define("HRDLOGPATH", LOGPATH . "/gateway/Headers.log");
		break;
	case "WESTERN":
// Configuration for Western-Dstar-Image
		define("LOGPATH", "/var/log");
		define("CONFIGPATH", "/etc");
		define("DSTARREPEATERLOGPATH", LOGPATH . "/");
		define("DSTARREPEATERLOGFILENAME", "DStarRepeater-");
		define("LINKLOGPATH", LOGPATH . "/Links.log");
		define("HRDLOGPATH", LOGPATH . "/Headers.log");
		break;
	case "DL5DI_CENTOS":
// Configuration for DL5DI-Installation-packages on CENTOS
		define("LOGPATH", "/var/log/dstar");
		define("CONFIGPATH", "/etc");
		define("DSTARREPEATERLOGPATH", LOGPATH . "/");
		define("DSTARREPEATERLOGFILENAME", "DStarRepeater_1-");
		define("LINKLOGPATH", LOGPATH . "/Links.log");
		define("HRDLOGPATH", LOGPATH . "/Headers.log");
		break;
	case "DL5DI_DEBIAN":
// Configuration for DL5DI-Installation-packages on DEBIAN
		define("LOGPATH", "/var/log/opendv");
		define("CONFIGPATH", "/home/opendv/ircddbgateway");
		define("DSTARREPEATERLOGPATH", LOGPATH . "/");
		define("DSTARREPEATERLOGFILENAME", "DStarRepeater_1-");
		define("LINKLOGPATH", LOGPATH . "/Links.log");
		define("HRDLOGPATH", LOGPATH . "/Headers.log");
		break;
	case "OTHER":
// Configuration for all others, please customize
// if necessary
		define("LOGPATH", "/var/log");
		define("CONFIGPATH", "/etc");
		define("DSTARREPEATERLOGPATH", LOGPATH . "/");
		define("DSTARREPEATERLOGFILENAME", "DStarRepeater-");
		define("LINKLOGPATH", LOGPATH . "/Links.log");
		define("HRDLOGPATH", LOGPATH . "/Headers.log");
		break;
}


define("CONFIGFILENAME", "ircddbgateway");
define("GATEWAYCONFIGPATH", CONFIGPATH . "/" . CONFIGFILENAME);

// set time to refresh page
define("REFRESHAFTER", "60");

// enables CPU-temperature alert
define("TEMPERATUREALERT", true);

// defines temperature of warning
define("TEMPERATUREHIGHLEVEL", 60);

// enables progress-bars
define("SHOWPROGRESSBARS", true);

// defines number of lines in last heard list
define("LHLINES", 20);
?>