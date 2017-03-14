 <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading"><?php echo _("System Info"); ?><span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-up"></i></span></div>
  <div class="panel-body">
  <!-- Tabelle -->
   <div class="table-responsive">
      <table id="sysinfo" class="table sysinfo table-condensed">
      </table>
   </div>
   </div>
 </div>
<script>
function loadXMLDocSysinfo() {
   var xmlhttp;
   if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
   } else {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   }
   xmlhttp.onreadystatechange=function() {
      if (xmlhttp.readyState==4 && xmlhttp.status==200) {
         document.getElementById("sysinfo").innerHTML=xmlhttp.responseText;
      }
   }
   xmlhttp.open("GET","ajax.php?section=sysinfo",true);
   xmlhttp.send();

   var timeout = window.setTimeout("loadXMLDocSysinfo()", 20000);
}
loadXMLDocSysinfo();
</script>
