<?php
include "config/config.php";
if (!defined("LOCALE"))
   define("LOCALE", "en_GB");

include "locale/".LOCALE."/settings.php";
$codeset = "UTF8";
putenv('LANG='.LANG_LOCALE.'.'.$codeset);
putenv('LANGUAGE='.LANG_LOCALE.'.'.$codeset);
bind_textdomain_codeset('messages', $codeset);
bindtextdomain('messages', dirname(__FILE__).'/locale/');
setlocale(LC_ALL, LANG_LOCALE.'.'.$codeset);
textdomain('messages');
?>
<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <!-- Das neueste kompilierte und minimierte CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Optionales Theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!-- Das neueste kompilierte und minimierte JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <title>MMDVM-Dashboard by DG9VH - <?php echo _("Credits"); ?></title>
  </head>
  <body>
  <div class="page-header">
    <h1><small>MMDVM-Dashboard by DG9VH</small> <?php echo _("Credits"); ?></h1>
  </div>
  <div class="container">
    <p><?php echo _("I think, after all the time this dashboard is developed mainly by myself, it is time to say \"Thank you\" to all those, wo delivered some ideas or code into this project."); ?></p>
    <p><?php echo _("This are explicit named following persons:"); ?></p>
    <ul>
      <li>df2et</li>
      <li>dg1tal</li>
      <li>ayasystems</li>
      <li>on3yh</li>
      <li>g0wfv</li>
      <li>dg0cco</li>
      <li>sa7bnt</li>
      <li>ct2jay</li>
      <li>oe7jkt</li>
      <li>f0dei</li>
      <li>f1ptl</li>
      <li><?php echo _("and some others..."); ?></li>
    </ul>
   <p><?php echo _("Those, who felt forgotten, feel free to commit a change into github of this file."); ?></p>
   <p><?php echo _("Many thanks to you all!"); ?></p>
   <p><?php echo _("Best 73, Kim, DG9VH"); ?></p>
  </div>
  </body>
</html>
