<?php


session_start();

session_unset();//clear data

session_destroy();//remove session


header('Location:login.php');
exit();
