<?php

session_start();

$pagetitle='login';
$nonavbar='';
if(isset($_SESSION['user'])){
    header('Location: index.php');
}


include 'init.php'; 
?>

<?php 

//check if user coming from HTTP POST request
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['login'])){//if login form is submitted
        $user=$_POST['name'];
        $password=$_POST['password'];
        $hashedpassword=sha1($password);

        //check if user exist in database
        $stm=$conn->prepare('select userid,username,password from users where username= ? AND password= ?');//select all person admin&user
        $stm->execute(array($user,$hashedpassword));
        $row=$stm->fetch(); 
        $count=$stm->rowCount();

        if($count > 0){
            $_SESSION['user']=$row['username']; //if admin or pesrson exist register session name
            $_SESSION['uid']=$row['userid'];    //if admin or pesrson exist register session id
            header('Location: index.php');
            exit();
        }
        else{
            echo "your";
        }
    }
    else{//if signup form is submitted
        $formserror=array();

        $username=$_POST['name'];
        $password=$_POST['password'];
        $repassword=$_POST['repassword'];
        $email=$_POST['email'];

        if(isset($username)){
            $filtername=filter_var($username,FILTER_SANITIZE_STRING);
            if( strlen($filtername) < 4){
                $formserror[]='Username Must Be Greater than 4  Characters';
            }
        }

        if(isset($password) && isset($repassword)){
            if(empty($password)){
                $formserror[]='Passwords Can\'t Be Empty';
            }

            //tb ana leh ma3mltsh filter l password 3lshan ana h3mloh sha1 fa law katb tag script aw 7aga sha1 bt3ml hash 
            $pass1=sha1($password);
            $pass2=sha1($repassword);

            if( $pass1 !== $pass2){
                $formserror[]='Passwords Not Match';
            }
        }


        if(isset($email)){
            $filteremail=filter_var( $email,FILTER_SANITIZE_STRING);
            if( filter_var($filteremail,FILTER_VALIDATE_EMAIL) != true){
                $formserror[]='This Email Is Not Valid';
            }
        }

        if(empty($formserror)){

            //check if username exist to avoid repetition

            $check=checkitem("username","users",$username);

            if($check == 1){
                $formserror[]="sorry username is exist try another one";
            }
            else{

                //insert data into database
                $stm=$conn->prepare("insert into  users(username,password,email,regstatus,date) 
                                        values(:zuser , :zpass , :zemail , 0 , now() )");
                $stm->execute(array(
                    "zuser"  => $username,
                    "zpass"  => sha1($password),
                    "zemail" => $email,
                ));

                $successmssg= "Congratulations You Are Now Registered User";
            }
        }


    }
    
}


?>





<div class="login-page text-center">
    <div class="container">

        <h1>
            <span data-class="login" class="selected">Login</span> |
            <span data-class="signup">Signup</sapn>
        </h1>
        <!--start login form-->
        <form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="input-container">
                <input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Write Your Username">
            </div>
            <div class="input-container">
                <input type="password" name="password" class="form-control" autocomplete="new-password" required="required" placeholder="Write Your Password">
            </div>
            <input type="submit" name="login" value="Login" class="btn btn-primary btn-block" >
        </form>
        <!--end login form-->

        <!--start signup form-->
        <form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="input-container">
                <input pattern=".{4,}" title="Username Must Be At Least 4 Characters"
                 type="text" name="name" class="form-control" autocomplete="off"  required placeholder="Write Your Username">
            </div>
            <div class="input-container">
                <input minlength="4" type="password" name="password" class="form-control" autocomplete="new-password" required placeholder="Write Your Password">
            </div>
            <div class="input-container">
                <input minlength="4" type="password" name="repassword" class="form-control" autocomplete="new-password"  required placeholder="Re-Write Your Password">
            </div>
            <div class="input-container">
                <input type="email" name="email" class="form-control"  placeholder="Write Your Email">
            </div>
            <input type="submit" name="signup" value="Signup" class="btn btn-success btn-block" >
        </form>
        <!--end signup form-->
        <div class="the-errors">
                <?php 
                if(!empty($formserror)){
                    foreach($formserror as $error){
                        echo '<div class="alert alert-danger">' . $error . '</div>';
                    }
                }
                    
                    if(isset($successmssg)){
                    //variable dah mawgood fe wala la2 mawgood ma3nah an mafesh wala error w username mash bta3oh mash mawgood fa asmoh yenfa3
                    //mash metkrr e3ny w da5el 3mlt insert fe database
                        echo '<div class="alert alert-success">' . $successmssg. '</div>';
                    }
                ?>
        </div>

    </div>
</div>















<?php include $temp.'footer.php'; ?>