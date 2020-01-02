# Linux Step-By-Step
This short howto describes step-by-step how to install the MMDVMHost-Dashboard on a Raspberry Pi (or similar) system using a Debian Linux distribution like Raspbian.

##Installation Steps
1. Update your system:

	>sudo apt-get update && sudo apt-get upgrade

2. Install a lightweight webserver:

	>sudo apt-get install lighttpd

3. Create a group for the webserver and add yourself to it:

	>sudo groupadd www-data

	>sudo usermod -G www-data -a pi
	
4. Set permissions so you and the webserver have full access to the files:

	If you use a current Raspbian Jessie and Raspian Stretch, use following commands:

	>sudo chown -R www-data:www-data /var/www/html

	>sudo chmod -R 775 /var/www/html

	If you use a Raspian Wheezy use:

	>sudo chown -R www-data:www-data /var/www

	>sudo chmod -R 775 /var/www

5. Install PHP and enable the required modules:
	
	If you use a Raspian Wheezy and Raspbian Jessie use:

	>sudo apt-get install php5-common php5-cgi php5
	
	If you use a Raspian Stretch use:
	
	>sudo apt-get install php7.3-common php7.3-cgi php

if you want to use the sqlite3-database based resolving of the operator-names you need following, too Raspian Wheezy and Raspbian Jessie:

	>sudo apt-get install sqlite3 php5-sqlite
	
Raspian Stretch:

	>sudo apt-get install sqlite3 php7.0-sqlite

Now continue with:

	>sudo lighty-enable-mod fastcgi

	>sudo lighty-enable-mod fastcgi-php

	>sudo service lighttpd force-reload

6. To install the dashboard you should use git for easy updates:

	>sudo apt-get install git

7. Now you can clone the dashboard into your home directory:

	>cd ~
	
	>git clone https://github.com/dg9vh/MMDVMHost-Dashboard.git

8. Next, you need to copy the files into the webroot so they can be served by lighttpd:

	If you are using Raspbian Jessie and Raspian Stretch, run:

	>sudo cp -R /home/pi/MMDVMHost-Dashboard/* /var/www/html/	

	If you are using Raspbian Wheezy, run:

	>sudo cp -R /home/pi/MMDVMHost-Dashboard/* /var/www/

9. To make sure the dashboard is served instead of the default "index.html", cd into the webroot /var/www/html respectively /var/www and remove that file:

	>sudo rm index.html

10. Finally, you need to configure the dashboard by pointing your browser to http://IP-OF-YOUR-HOTSPOT/setup.php . This will create /var/www/html/config/config.php respectively /var/www/config/config.php which contains your custom settings. 

Now the dashboard should be reachable via http://IP-OF-YOUR-HOTSPOT/

##Configuration Of Dashboard
When configuring the dashboard, make sure to set the correct paths for logs etc. If they are wrong, no last-heard or similar information will be shown on the dashboard!
