<?php

session_start();


if(isset($_SESSION['name'])){

            include 'init.php';
            $do='';

        if(isset($_GET['do'])){
            $do=$_GET['do'];
        }
        else{
            $do='manage';
        }



        if($do == "manage"){//manage page 

            //talat stoor dool 3lshan 2zahr l user 3la mastneen ye3mlhom activate  bas yezhrhom fe 7alat any gat mn page dashbord
            $query='';
            if(isset($_GET['page']) && $_GET['page']=='pending'){
                $query="AND regstatus= 0";
            }

            $stm=$conn->prepare("select * from users where groupid != 1 $query order by userid desc");
            $stm->execute();
            $row=$stm->fetchAll();

            if(! empty($row)){
        ?>

                <h1 class="text-center">Manage Member</h1>

                <div class="container"><!--start container-->
                    <div class="table-responsive">
                        <table class="table table-bordered text-center main-table">

                            <tr>
                                <td>#ID</td>
                                <td>Picture</td>
                                <td>Username</td>
                                <td>Email</td>
                                <td>Fullname</td>
                                <td>Registred Date</td>
                                <td>Control</td>
                            </tr>
                                <?php
                                foreach($row as $data){ ?>
                                    <tr>
                                        <td><?php echo $data['userid'];?></td>
                                        <td>
                                            <?php 
                                                if(!empty($data['avatar'])){
                                                    echo "<img class='img-thumbnail img-responsive' 
                                                    src='uploads/avatars/" . $data['avatar'] . "' alt='' />";
                                                }
                                                else{
                                                    echo '<img src="img.png">';
                                                }
                                            ?>

                                        </td>
                                        <td><?php echo $data['username'];?></td>
                                        <td><?php echo $data['email'];?></td>
                                        <td><?php echo $data['fullname'];?></td>
                                        <td><?php echo $data['date'];?></td>
                                        <td>
                                            <a href="member.php?do=edit&userid=<?php echo $data['userid']?>" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                                            <a href="member.php?do=delete&userid=<?php echo $data['userid']?>" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a>
                                    
                                            <?php if ($data['regstatus'] == 0){ ?>
                                            <a href="member.php?do=activate&userid=<?php echo $data['userid']?>" class="btn btn-info"><i class="fa fa-check"></i>Activate</a>
                                        <?php }?>
                                    
                                        </td>
                                    </tr>
                            <?php }
                                ?>
                        </table>
                    </div>

                    <a href='member.php?do=add' class="btn btn-primary"><i class="fa fa-plus"></i>New Member</a>
                </div><!--end container-->


        <?php 
            }//end if empty
            else{
                echo '<div class="container">';
                echo '<div class="alert alert-info">There\'s No Members To Show</div>';
                echo '<a href="member.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i>New Member</a>';
                echo '</div>';

            }
    
        }

        elseif($do == "add"){ //add page ?>
                              
                <h1 class="text-center">Add New Member</h1>

                <div class="container"><!--start container-->

                    <form class="form-horizontal" action="<?php $_SERVER['PHP_SELF']?>?do=insert" method="POST" enctype="multipart/form-data">
                        
                        <!--start username field-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">User Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="username"  class="form-control" required="required" placeholder="Username To Login" autocomplete="off">
                            </div>
                        </div>
                        <!--end username field-->

                        <!--start password field-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="password" name="password" class="form-control password" required="required" placeholder="Password To Login" autocomplete="new-password">
                                <i class="show-password fa fa-eye fa-2x"></i>
                            </div>
                        </div>
                        <!--end password field-->

                        <!--start email field-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="email" name="email" class="form-control" required="required" placeholder="Email To Login">
                            </div>
                        </div>
                        <!--end email field-->

                        <!--start fullname field-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Full Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="fullname" class="form-control" required="required" placeholder="Fullname To Login">
                            </div>
                        </div>
                        <!--end fullname field-->

                        <!--start avatar field-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">User Avatar</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="file" name="avatar" required="required" class="form-control" >
                            </div>
                        </div>
                        <!--end avatar field-->

                        <!--start submit field-->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Add New Member" class="btn btn-primary btn-lg">
                            </div>
                        </div>
                        <!--end submit field-->

                    </form>

                </div><!--end container-->



        <?php 
        
        }

        elseif($do == "insert"){//insert page 
                       
            if($_SERVER['REQUEST_METHOD'] == 'POST'){?>

            <h1 class="text-center">Add Data</h1>

            <div class="container">
                
                    <?php
                    
                    /*$avatar=$_FILES['avatar'];//FILES btrga3lk details bta3t l sora fe array adad@sas.com 
                    print_r($avatar);*/


                    // Upload Variables

                    $avatarName = $_FILES['avatar']['name'];
                    $avatarSize = $_FILES['avatar']['size'];
                    $avatarTmp	= $_FILES['avatar']['tmp_name'];
                    $avatarType = $_FILES['avatar']['type'];

                    // List Of Allowed File Typed To Upload

                    $avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

                    // Get Avatar Extension

                    $avatarExtension =explode('.', $avatarName);//mynfa3sh t3mlhom fe satar wa7ed chhain e3ny 3lshan l php version bta3k adeem
                    $avatarExtension2= end($avatarExtension);
                    $avatarExtension3=strtolower($avatarExtension2);


                    //get data from Add form
                    $username=$_POST['username'];
                    $pass=$_POST['password'];
                    $email=$_POST['email'];
                    $fullname=$_POST['fullname'];

                    $hashedpass=sha1($_POST['password']);


                    //check input validation at server side

                    $formerror=array();
                    if(empty($username)){
                        $formerror[]='Username can\'t be empty</div>';
                    }
                    if(strlen($username) < 4 ){
                        $formerror[]='Username can\'t be Less Than 4 Characters';
                    }
                    
                    if(empty($pass)){
                        $formerror[]='Password can\'t be Less Than 4 Characters';
                    }
                    if(empty($email)){
                        $formerror[]='Email can\'t be empty';
                    }
                    if(empty($fullname)){
                        $formerror[]='Fullname can\'t be empty';
                    }
                    if(! empty($avatarName) && ! in_array($avatarExtension3,$avatarAllowedExtension)){
                        $formerror[]='This Extension Is Not Allowed';
                    }
                    if(empty($avatarName)){
                        $formerror[]='Avatar can\'t be empty';
                    }
                    if($avatarSize > 4194304){
                        $formerror[]='Avatar Size Must Be Larger Than 4MB';
                    }

                    foreach($formerror as $error){
                        echo "<div class='alert alert-danger'>".$error."</div>";
                    }

                    //check if there is no error procced operation

                    if(empty($formerror)){

                        
                        $avatar = rand(0, 10000000000) . '_' . $avatarName;//hena b3ml asm l sora 3lshan mattkrrsh

                        move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatar);//ba5od path bta3 l sora l user 7atha w b7otha 3ndy fe folder

                        //check if username exist to avoid repetition

                        $check=checkitem("username","users",$username);

                        if($check == 1){
                            $mssg="<div class='alert alert-danger'>sorry username is exist try another one</div>";
                            redirecthome($mssg,"home");
                        }
                        else{

                            //insert data into database
                            $stm=$conn->prepare("insert into  users(username,password,email,fullname,regstatus,date,avatar) 
                                                    values(:zuser , :zpass , :zemail , :zfull , 1 , now() , :zavatar)");
                            $stm->execute(array(
                                "zuser"  => $username,
                                "zpass"  => $hashedpass,
                                "zemail" => $email,
                                "zfull"  => $fullname,
                                "zavatar"  => $avatar
                            ));

                            //meassage recorded
                            $mssg= "<div class='alert alert-success'>" . $stm->rowCount()." Recorded inserted</div>";
                            redirecthome($mssg,"back");
                        }
                    }

                }
                else{
                    echo "<div class='container'>";
                    $mssg= '<div class="alert alert-danger"> you can\'t access this page directly</div>';
                    redirecthome($mssg);                   
                    echo "</div";
                }?>

            </div>




        <?php }



        elseif($do == "edit"){//edit page

            //hena b3ml secure 3lshan law admin fe url katb id mash rakm aw maktbsh aslan
            if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
                $userid=intval($_GET['userid']);
            }
            else{
                $userid= 0;
            }

                $stm=$conn->prepare('select * from users where userid = ? LIMIT 1');
                $stm->execute(array($userid));
                $row=$stm->fetch();
                $count=$stm->rowCount();

                if($count > 0){?>

                    
                    <h1 class="text-center">Edit Profile</h1>

                    <div class="container"><!--start container-->

                        <form class="form-horizontal" action="<?php $_SERVER['PHP_SELF']?>?do=update" method="POST" enctype="multipart/form-data">

                            <input type="hidden" name="id" value="<?php echo $userid;?>">
                            
                            <!--start username field-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">User Name</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" name="username" value="<?php echo $row['username'];?>" class="form-control" required="required" autocomplete="off">
                                </div>
                            </div>
                            <!--end username field-->

                            <!--start password field-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-10 col-md-6">
                                <input type="hidden" name="oldpassword" value="<?php echo $row['password'];?>">
                                <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Dont Want to Change">
                                </div>
                            </div>
                            <!--end password field-->

                            <!--start email field-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="email" name="email" value="<?php echo $row['email'];?>" class="form-control" required="required">
                                </div>
                            </div>
                            <!--end email field-->

                            <!--start fullname field-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Full Name</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" name="fullname" value="<?php echo $row['fullname'];?>" class="form-control" required="required">
                                </div>
                            </div>
                            <!--end fullname field-->

                                
                            <!--start avatar field-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">User Avatar</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="file"  name="avatar"  class="form-control" >
                                </div>
                            </div>
                            <!--end avatar field-->

                            <!--start submit field-->
                            <div class="form-group form-group-lg">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="submit" value="save" class="btn btn-primary btn-lg">
                                </div>
                            </div>
                            <!--end submit field-->

                        </form>

                    </div><!--end container-->



                <?php
                }
                else{
                echo "<div class='container'>";
                $mssg= '<div class="alert alert-danger"> there\'s no such id</div>';
                redirecthome($mssg);                   
                echo "</div";
                }

        }
        elseif($do == "update"){//update page
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){?>

                <h1 class="text-center">Update Data</h1>

                <div class="container">
                    
                        <?php



                    // Upload Variables

                    $avatarName = $_FILES['avatar']['name'];
                    $avatarSize = $_FILES['avatar']['size'];
                    $avatarTmp	= $_FILES['avatar']['tmp_name'];
                    $avatarType = $_FILES['avatar']['type'];

                    // List Of Allowed File Typed To Upload

                    $avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

                    // Get Avatar Extension

                    $avatarExtension =explode('.', $avatarName);//mynfa3sh t3mlhom fe satar wa7ed chain e3ny 3lshan l php version bta3k adeem
                    $avatarExtension2= end($avatarExtension);
                    $avatarExtension3=strtolower($avatarExtension2);


                        //get data from edit form
                        $id=$_POST['id'];
                        $username=$_POST['username'];
                        $email=$_POST['email'];
                        $fullname=$_POST['fullname'];
                        $pass='';
                        
                        if(empty($_POST['newpassword'])){
                            $pass=$_POST['oldpassword'];
                        }
                        else{
                            $pass=sha1($_POST['newpassword']);
                        }


                        //check input validation at server side

                        $formerror=array();
                        if(empty($username)){
                            $formerror[]='<div class="alert alert-danger">Username can\'t be empty</div>';
                        }
                        if(strlen($username) < 4 ){
                            $formerror[]='<div class="alert alert-danger">Username can\'t be Less Than 4 Characters</div>';
                        }
                        if(empty($email)){
                            $formerror[]='<div class="alert alert-danger">Email can\'t be empty</div>';
                        }
                        if(empty($fullname)){
                            $formerror[]='<div class="alert alert-danger">Fullname can\'t be empty</div>';
                        }
/*                        foreach($formerror as $error){
                            echo $error;
                        }*/
                        /*
                        if(! empty($avatarName) && ! in_array($avatarExtension3,$avatarAllowedExtension)){
                            $formerror[]='<div class="alert alert-danger">This Extension Is Not Allowed</div>';
                        }
                        if(empty($avatarName)){
                            $formerror[]='<div class="alert alert-danger">Avatar can\'t be empty</div>';
                        }
                        if($avatarSize > 4194304){
                            $formerror[]='<div class="alert alert-danger">Avatar Size Must Be Larger Than 4MB</div>';
                        }
                        */

                        //check if there is no error procced operation

                        if(empty($formerror)){
                                //if($count == 1) deh 3lshan w user by3ml update 2 8er l username basm mawgood w dah maynfa3sh fa deh bt3ml check
                            
                            
                            $stm2=$conn->prepare("select * from users where username = ? AND userid != ? ");
                            $stm2->execute(array($username,$id));
                            $count=$stm2->rowCount();

                            if($count == 1){
                                $mssg= "<div class='alert alert-danger'>Sorry This User Is exist</div>";
                                redirecthome($mssg,"back");
                            }
                            else{

                                
                        
                                $avatar = rand(0, 10000000000) . '_' . $avatarName;//hena b3ml asm l sora 3lshan mattkrrsh

                                move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatar);//ba5od path bta3 l sora l user 7atha w b7otha 3ndy fe folder


                                //update data from database
                                $stm=$conn->prepare('update users set username = ? , password = ? , email= ? , fullname= ? , avatar= ? where userid = ?');
                                $stm->execute(array($username,$pass,$email,$fullname,$avatar,$id));

                                //meassage recorded
                                $mssg= "<div class='alert alert-success'>" . $stm->rowCount()." Recorded Updated </div>";
                                redirecthome($mssg,"back");

                            }
                echo "</div";

                        }
                        else{
                            foreach($formerror as $error){
                                redirecthome($error,'back',3);
                            }
                        }

            }
            else{
                echo "<div class='container'>";
                $mssg= '<div class="alert alert-danger"> you can\'t access this page directly</div>';
                redirecthome($mssg);                   
                echo "</div";
                
            }?>
            
            <?php

        }
        elseif($do == "delete"){ //delete page


            //check userid at url
            if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
                $userid=intval($_GET['userid']);
            }
            else{
                $userid=0;
            }
                 ?>

                <h1 class="text-center">Delete Member</h1>
                <div class="container">

                    <?php
                    
                    $check=checkitem('userid','users', $userid);

                    if($check > 0){ //check for id's data if exist
                        $stm=$conn->prepare('delete from users where userid = :zuser');
                        $stm->bindParam(":zuser",$userid);
                        $stm->execute();

                        $mssg= "<div class='alert alert-success'>". $stm->rowCount() . " recorded Deleted</div>";
                        redirecthome($mssg,"back");
                    }
                    else{
                        
                        $mssg= '<div class="alert alert-danger"> there\'s no such id</div>';
                        redirecthome($mssg);                                           
                    }
                    ?>


                </div>


            <?Php 
        }
        elseif($do == "activate"){//activate page
            if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
                $userid=intval($_GET['userid']);
            }
            else{
                $userid=0;
            }


            $check=checkitem('userid','users',$userid);
            echo "<h1 class='text-center'>Activate Member</h1>";
            echo "<div class='container'>";
            if($check > 0){

                    $stm=$conn->prepare('update users set regstatus = 1 where userid = ?');
                    $stm->execute(array($userid));
                    $mssg= "<div class='alert alert-success'>". $stm->rowCount() . " Recorded Updated</div>";
                    redirecthome($mssg,'back'); 
            }
            else{
                $mssg= '<div class="alert alert-danger"> there\'s no such id</div>';
                redirecthome($mssg);   
            }


                echo "</div>";
        }

        include $temp.'footer.php';
}
else{
    echo "you have no authorized here";
    header("REFRESH:1;url=index.php");
    exit();
}

?>

