<?php
    
    ini_set('display_errors','on');
    error_reporting(E_ALL);

include "admin/connect.php";



$usersession='';
if(isset($_SESSION['user'])){
    $usersession=$_SESSION['user'];
    //kemet l session htt5zn fe $usersession ael ma ye3ml login leh l2n fe login.php ht3mloh session w ana mnady 
    //init.php henak fe hy7ot kema fe $usersession
}

$temp="includes/templates/"; //template directory
$lang="includes/languages/"; //languages directory
$func="includes/functions/";  //function directory
$css="layout/css/";          //css director
$js="layout/js/";            //js director



include $func."functions.php";
include $lang."english.php";
include $temp."header.php";




