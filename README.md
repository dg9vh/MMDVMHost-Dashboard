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

Required are
============
* Webserver like 
* lighttpd
* php5


Installation
============
* Please ensure to not put loglevels at 0 in MMDVM.ini.
* Copy all files into your webroot and enjoy working with it.
* Create a config/config.php by calling setup.php and giving suitable values
* If Dashboard is working, remove setup.php from your webroot

For detailled installation see `linux-step-by-step.md` within this repository.

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

Contact
=======
Feel free to contact the author via email: dg9vh@darc.de
