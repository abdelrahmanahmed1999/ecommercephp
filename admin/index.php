<?php

session_start();

$nonavbar='';//da l variable 3lshan may7otlesh navbar
$pagetitle='login';

//deh lm a sha5s admin mash user 3ady yesgl httft7loh seesion feha asmoh hena ba2a mafesh da3y tzhrloh l login form w hwa 3aml already login 
//da law admin da5el 5alas lesa hnshoof ll user han3ml eh 
if(isset($_SESSION['name'])){
    header('Location: dashbord.php');
}


include "init.php";

?>


<?php

//check if user coming from HTTP POST request
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username=$_POST['user'];
    $password=$_POST['pass'];
    $hashedpassword=sha1($password);

    //check if user exist in database
    $stm=$conn->prepare('select userid,username,password from users where username= ? AND password= ? AND groupid=1 LIMIT 1');//select admin person not user
    $stm->execute(array($username,$hashedpassword));
    $row=$stm->fetch(); //return data  //hyrg3lk data 3la hy2t array
    $count=$stm->rowCount();

    //if count gt 0 this means the database contains record about this name 
    if($count > 0){
        $_SESSION['name']=$username;    //if admin pesrson exist register session name
        $_SESSION['id']=$row['userid'];        //if admin pesrson exist register session id
        header('Location: dashbord.php');
        exit();
    }
    else{
        header('Location: ../login.php');
        exit();    }
}


?>




<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <h4 class="text-center">Admin Login</h4>
    <input type="text" class="form-control input-lg"     name="user" placeholder="Username" autocomplete="off">
    <input type="password" class="form-control input-lg" name="pass" placeholder="password" autocomplete="new-password">
    <input type="submit" class="btn btn-primary btn-block input-lg"  value="Login">

</form>

<?php include $temp."footer.php";?>