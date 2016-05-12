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
* entry in /etc/sudoers: 
  www-data ALL=(ALL) NOPASSWD: ALL


Installation
============
* Please ensure to not put loglevels at 0 in MMDVM.ini.
* Copy all files into your webroot and enjoy working with it.
* Edit config.php located in /config-folder in your web-folder.

Contact
=======
Feel free to contact the author via email: dg9vh@darc.de