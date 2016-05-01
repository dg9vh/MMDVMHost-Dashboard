<?php
date_default_timezone_set('UTC');
define("REPEATERCALLSIGN","DG9VH");
define("LOGPATH","/mnt/ramdisk/");
define("LOGPREFIX","MMDVM");
define("LOGFILE",LOGPATH . LOGPREFIX . "-" . date("Y-m-d") . ".log");
define("REFRESHAFTER","60");
define("TEMPERATUREALERT",true);
define("TEMPERATUREHIGHLEVEL", 60);
define("SHOWPROGRESSBARS", true);
define("LHLINES", 20);
?>