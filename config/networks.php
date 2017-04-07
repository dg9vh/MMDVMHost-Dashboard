<?php
$networks_json = '{
          "DMRPLUS":{
            "label":"Multimode DMRplus",
          	"ini":"DMRPLUS",
          	"logo":"http://db0lm.de/wp-content/uploads/2015/10/DMR-Plus-300x109.png"
          },
          "BRANDMEISTER":{
            "label":"Multimode BrandMeister",
          	"ini":"BRANDMEISTER",
          	"logo":"https://s3.amazonaws.com/files.qrz.com/a/pd1ra/dmr_brandmeister.jpg"
          },
          "DSTAR":{
            "label":"Singlemode D-STAR",
          	"ini":"DSTAR",
          	"logo":""
          }
}';

$networks = json_decode($networks_json, true);
?>
