<?php
 
include "connect.php";

$temp="includes/templates/"; //template directory
$lang="includes/languages/"; //languages directory
$func="includes/functions/";  //function directory
$css="layout/css/";          //css director
$js="layout/js/";            //js director



include $func."functions.php";
//lazm mlf l english ykoon fl awel keda 3lshan fe safa7at l navbar mesta5dm klmat mn english fa law ba3da mash hy2raha lazm tkoon ablha
include $lang."english.php";
include $temp."header.php";

//law fe safa7a mafesh l variable nonavbar lma a23mel inlude l init.php fe safa7a w mafesh variable $nonavbar mash hy7ot l navbar fe saf7a deh
//zy l login mash ma7tag 23eml frha navbar

//inlude navbar on all pages except page that doesnot have variable $nonavbar
if(!isset($nonavbar)){
    include $temp."navbar.php";
}


