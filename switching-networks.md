# Switching Networks
To make switching networks possible you have to fulfill following conditions:
1. add www-user to the sudoers file to be able to execute following commands: cp, killall, MMDVMHost

  You can do this for example with following line:
  
  www-data ALL=(ALL) NOPASSWD: /bin/cp,/usr/local/bin/MMDVMHost,/usr/bin/killall,/sbin/halt,/sbin/reboot

2. create two ini-files, one with the name DMRPLUS.ini and the other with the name BRANDMEISTER.ini within the same directory where your MMDVM.ini resists, that contains the configurations for the corresponding networks.

## Security Hint
It is absolutely not recommended to put ALL into the sudoers line! The commands above are heavy enougth!
It is strictly recommended to not make the Dashboard public available, if you are using the advanced management functions and the network switching!

## For Better Handling Of Heardlists
If you want to have only those contacts listed in the last-head-lists that where active in the corresponding network your system is logged in,
you can configure your .INI-Files to use separate LOG-Prefixes like BM-MMDVM and DMRPLUS-MMDVM for example.