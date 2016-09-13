  <div class="panel panel-default">
  <!-- Standard-Panel-Inhalt -->
  <div class="panel-heading">Currently TXing</div>
  <!-- Tabelle -->
  <div class="table-responsive">  
  <table id="currtx" class="table table-condensed table-striped table-hover">
   <thead>
    <tr>
      <th>Time (UTC)</th>
      <th>Mode</th>
      <th>Callsign</th>
      <?php
      if (defined("ENABLEXTDLOOKUP")) {
      ?>
      <th>Name</th>
      <?php
      }
      ?>
      <th>DSTAR-ID</th>
      <th>Target</th>
      <th>Source</th>
    </tr>
   </thead>
   <tbody id="txline">
    <!--<tr >
     <td></td>
     <td></td>
     <td></td>
      <?php
      if (defined("ENABLEXTDLOOKUP")) {
      ?>
     <td></td>
      <?php
      }
      ?>
     <td></td>
     <td></td>
     <td></td>
    </tr>-->
  </tbody>
  </table>
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

function refreshInQSOAndLastHeardList() {
	doXMLHTTPRequest("txinfo.php","txline");
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
}
loadXMLDoc();
</script>
