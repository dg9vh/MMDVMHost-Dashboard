  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading"><?php echo _("Currently TXing"); ?><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span></div>
  <div class="panel-body">
  <!-- Tabelle -->
  <div class="table-responsive">
  <table id="currtx" class="table curTx table-condensed table-striped table-hover">
   <thead>
    <tr>
      <th><?php echo _("Time"); ?> (<?php echo TIMEZONE;?>)</th>
      <th><?php echo _("Mode"); ?></th>
      <th><?php echo _("Callsign"); ?></th>
      <?php
      if (defined("ENABLEXTDLOOKUP")) {
      ?>
      <th><?php echo _("Name"); ?></th>
      <?php
      }
      if (defined("TALKERALIAS")) {
      ?>
      <th><?php echo _("Talker Alias"); ?></th>
      <?php
      }
      ?>
      <th><?php echo _("DSTAR-ID"); ?></th>
      <th><?php echo _("Target"); ?></th>
      <th><?php echo _("Source"); ?></th>
      <th><?php echo _("TX-Time"); ?></th>
    </tr>
   </thead>
   <tbody id="txline">
   </tbody>
  </table>
  </div>
</div>
</div>
<script>
function doXMLHTTPRequest(scriptname, elem) {
   var xmlhttp;
   if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
   } else {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   }
   xmlhttp.onreadystatechange=function() {
      if (xmlhttp.readyState==4 && xmlhttp.status==200) {
         document.getElementById(elem).innerHTML=xmlhttp.responseText;
      }
   }
   xmlhttp.open("GET",scriptname,true);
   xmlhttp.send();
}

function refreshMode() {
   doXMLHTTPRequest("ajax.php?section=mode","mode");
}

function refreshDstarLink() {
   doXMLHTTPRequest("ajax.php?section=dstarlink","dstarlink");
}

function refreshYSFLink() {
   doXMLHTTPRequest("ajax.php?section=ysflink","ysflink");
}

function refreshDMR1Link() {
   doXMLHTTPRequest("ajax.php?section=dmr1link","dmr1link");
}

function refreshDMR2Link() {
   doXMLHTTPRequest("ajax.php?section=dmr2link","dmr2link");
}

var transmitting = false;
function loadXMLDoc() {
   var xmlhttp;
   if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
   } else {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   }
   xmlhttp.onreadystatechange=function() {
      if (xmlhttp.readyState==4 && xmlhttp.status==200) {
         document.getElementById("txline").innerHTML=xmlhttp.responseText;
      }
   }
   xmlhttp.open("GET","txinfo.php",true);
   xmlhttp.send();

   var timeout = window.setTimeout("loadXMLDoc()", 1000);
   refreshMode();
<?php
  if (getEnabled("D-Star", $mmdvmconfigs) == 1) {
  ?>
   refreshDstarLink();
  <?php
  }
?>
<?php
  if (getEnabled("System Fusion", $mmdvmconfigs) == 1) {
  ?>refreshYSFLink();
  <?php
  }
?>
<?php
  if (getEnabled("DMR", $mmdvmconfigs) == 1) {
  ?>refreshDMR1Link();
  refreshDMR2Link();
  <?php
  }
?>
}
loadXMLDoc();
</script>
