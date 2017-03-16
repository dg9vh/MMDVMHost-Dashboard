# Internationalization
If you want to have the static-text-output in other languages than default 
(english), you have to do following steps:
* activate your locale with raspi-config, it must not be default
* restart your webserver for loading new locale-configuration
* set your locale within setup.php

# Be a part of translators!
To be a part of the translators-community, feel free to copy an existing 
locale-tree within the locale-directory to your own locale, modify the 
settings.php-file within this directory and modify the messages.po within
the LC_MESSAGES-directory. After this, you should generate a messages.mo
with the command 'msgfmt messages.po -o messages.mo'. The command is part
of the gettext-package to be installed before with 'apt-get install gettext'.

To get the translations for DataTables, take a look at
https://datatables.net/plug-ins/i18n/ - here you'll find links to translations
you can copy&paste into settings.php of the locale-directory.
