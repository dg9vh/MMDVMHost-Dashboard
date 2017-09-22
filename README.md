# MMDVMHost-Dashboard
Dashboard for MMDVMHost (by G4KLX)
==================================

About
=====
MMDVMHost-Dashboard is a web-dashboard for visualization of different data like
system temperatur, cpu-load ... and it shows a last-heard-list.

It relies on MMDVMHost by G4KLX (see https://github.com/g4klx/MMDVMHost). At 
this place a big thank you to Jonathan for his great work he did with this 
software.

Based on G4KLX code, mod by EA4GKQ

Required are
============
* Webserver like lighttpd or similar
* php5
* if using sqlite3-database name resolving sqlite3 and php5-sqlite also needed

Installation
============
* Please ensure to not put loglevels at 0 in MMDVM.ini.
* Copy all files into your webroot and enjoy working with it.
* Create a config/config.php by calling setup.php and giving suitable values
* If Dashboard is working, remove setup.php from your webroot

For detailled installation see `linux-step-by-step.md` within this repository.

Usage
=====
To use the dashboard simply call the corresponding address in a webbrowser. The webbrowser has to be javascript-enabled because of the usage of DataTables, that would only be functional with Javascript enabled for this site!

Features
========
At the moment there are several information-sections shown:
* System Info: 
  Here you'll find live info about the host-system itself like CPU-freq, temperature, system-load, cpu-usage, uptime and cpu-idle-time.
* Repeater Info:
  Here are some basic repeater info and link-states
* Enabled Modes
  This is a list of enabled modes. If green, it's enabled, if grey, it's disabled. If it is red, there is an error-state with MMDVMHost or ircddbgateway.
* Last Heard List of today's x callsigns:
  This is a list of the last x callsigns heard in general in the system over all modes and directions. X is to be configured in /config/config.php
* Today's last 10 local transmissions:
  For better debugging/calibrating etc. the last 10 local transmissions (RF-side of the repeater) are listed.

New features by EA4GKQ
======================
* Buttons toolbar, security-hint: to make this function secure, please enable htpasswd-function for folder "scripts"!
* LastHeard table are sorted 
* Some mods to improve mobile experience

Cronjob for updating DMR IDs
============================
You can use the included script to update the DMR IDs periodically. Copy the files updateDMRIDs to /etc/cron.d/ and updateDMRIDs.sh to /var/www from the cron folder in this repo. The paths may have to be aligned to your system architecture. The Update script will then be executed once every 24 hours at 3:30. For security considerations please make sure that the cron folder is not copied to your web server's www root directory.

If you are using the sqlite3-database, in the database-folder you can find a update-script that updates the database from MARC-database.


Contact
=======
Feel free to contact the author via email: dg9vh[@]darc.de

Feel free to contact the mod author via email: ea4gkq[@]ure.es
