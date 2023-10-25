<?php


//fe safa7a hena 3aml zay l Routes fl MVC lma bktb fe url gnbd asm l safa7a method=add bywadyeny l sfa7a add l gay hena nafs l fekra bas
// taba3n mafesh MVC
//$_GET[''] bta5od kema mn url page.php?do=add&fav=abdo   $_GET['do'] deh htrga3lk kema do l hyea add
//  $_GET['fav']deh htrga3lk kema do l hyea abdo


//Routes

$do='';

if(isset($_GET['do'])){
    $do=$_GET['do'];
}
else{
    $do='manage';
}




if($do == "manage"){
    echo "you are in manage page";
    echo "<a href='page.php?do=add'>add category</a>";
}
elseif($do == "add"){
    echo "you are in add page";
}
elseif($do == "delete"){
    echo "you are in delete page";
}
else{
    echo "there\'s no page with name like that";

}