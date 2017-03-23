# Switching Networks
To make switching networks possible you have to fulfill following conditions:

* add www-user to the /etc/sudoers file to be able to execute following commands: cp, killall, MMDVMHost

  You can do this for example with following line:
  
  www-data ALL=(ALL) NOPASSWD: /bin/cp,/usr/local/bin/MMDVMHost,/usr/bin/killall,/sbin/halt,/sbin/reboot


HINT: PLEASE(!) only use visudo for editing the sudoers-file! This validates the file before writing it on the 
hard-disk. Otherwise there is heavy danger to damange your sudo-system, if you got any error/typo within the line!

* create two or more ini-files containing your configurations. If not using the new variant via /config/networks.php, create one with the name DMRPLUS.ini and the other with the name BRANDMEISTER.ini within the same directory where your MMDVM.ini resists, that contains the configurations for the corresponding networks. 

  If you want to use the new variant via /config/networks.php edit the file networks.php to fit your needs and refer to the created ini-files only by using the prefix and not the full name with .ini at the end!

## Security Hint
It is absolutely not recommended to put ALL into the sudoers line! The commands above are heavy enougth!
It is strictly recommended to not make the Dashboard public available, if you are using the advanced management functions and the network switching!

## For Better Handling Of Heardlists
If you want to have only those contacts listed in the last-head-lists that where active in the corresponding network your system is logged in,
you can configure your .INI-Files to use separate LOG-Prefixes like BM-MMDVM and DMRPLUS-MMDVM for example.