# Linux Step-By-Step
This short howto describes step-by-step how to install the MMDVMHost-Dashboard on a Raspberry Pi (or similar) System using a Debian-Linux Distribution like Raspbian.

##Installation Steps
1. Actualize your Liux-system and package sources with the following command:

	>sudo apt-get update && sudo apt-get upgrade

2. Install a tiny webserver with

	>sudo apt-get install lighttpd

3. Now it's time to modify file-system-rights. Following steps would do it for you:

	>sudo groupadd www-data

	>sudo usermod -G www-data -a pi

	If you use a current Raspbian Jessie, use following commands:

	>sudo chown -R www-data:www-data /var/www/html

	>sudo chmod -R 775 /var/www/html

	If you use a Raspian Wheezy use:

	>sudo chown -R www-data:www-data /var/www

	>sudo chmod -R 775 /var/www

4. Next step would be to install PHP5 and enbale all necessary modules:

	>sudo apt-get install php5-common php5-cgi php5

	>sudo lighty-enable-mod fastcgi

	>sudo lighty-enable-mod fastcgi-php

	>sudo service lighttpd force-reload

5. To install the dashboard you should install git

	>sudo apt-get install git

6. Now you can clone the dashboard into your home-directory (`/home/pi`) with

	>git clone https://github.com/dg9vh/MMDVMHost-Dashboard.git

7. Now it's time to copy the files into the webroot:

	If you are using Raspbian Jessie, you do it with

	>cp -R /home/pi/MMDVMHost-Dashboard /var/www/html/	

	If you are using Raspbian Wheezy, you do it with

	>cp -R /home/pi/MMDVMHost-Dashboard /var/www/

8. To make sure that the dashboard is delivered by the webserver, remove the default "index.html" within the webroot-directory /var/www/html respective /var/www with

	>rm index.html

9. When this is done you should configure the dashboard by editing /var/www/html/config/config.php respective /var/www/config/config.php to your personal fits. 

10. Last step is to put www-user into sudoers by editing `/etc/sudoers` with

	>sudo nano /etc/sudoers

	and adding the line:

	>www-data ALL=(ALL) NOPASSWD: ALL

	at the end of the file.

After all is done the dashboard should be reachable via http://IP-OF-YOUR-HOTSPOT/

##Configuration Of Dashboard
When configuring the dashboard take care of the directories containing the logs etc. If here you are doing something wrong, no last-heard or other info would be shown in the dashboard!
