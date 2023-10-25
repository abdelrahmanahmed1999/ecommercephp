<?php


session_start();

session_unset();//clear data

session_destroy();//remove session


header('Location:index.php');
exit();//exit lazm ttktb ba3d ay header() 3lshan law fe 7aga ktbtha 8lt matzharsh
