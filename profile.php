<?php



session_start();

$pagetitle='Profile';


include "init.php"; 

if(isset($_SESSION['user'])){//logined user

    //tb hena leh ma2drsh 2st5d l $usersession 3lshan bys2al 3la $usersession nafshoh mash kema l gwah fa lma yes2l 3leh hyl2eh
    // 7ata law kemtoh fadye hyd5o gwa l if
    //l fekra kolha an lma 7ad yd5ol direct 3la aya safa7a law ktb fe url profile.php aw ay safa7a tanyea w fe if bys2l 3la $usersession
    //hyl2eh fa hyd5ol w kemtoh fadyea l2noh assasn ma3mlsh login 3lshan yetft7loh session w ttesgl fe $usersession
    //fa l 27san an tes2l 3la session 3lshan ttdmn anoh ykoon 3aml lawel login
    //e3ny ay safa7a as2l 3la session 3lshan momkn yd5ol mn direct fe url w lma ye3dy mn session ma3nah anoh 3ml login fa gwa safa7a ba2a 22dr 
    //2st5dm $usersession

    $stm=$conn->prepare('select * from users where username = ?');
    $stm->execute(array($usersession));
    $info=$stm->fetch();
    $infouserid=$info['userid'];


    if(isset($_GET['do'])){
        $do=$_GET['do'];
    }
    else{
        $do='manage';
    }


    if($do == 'manage'){//start do condition


    ?>


            <h1 class="text-center">My Profile</h1>


            <div class="information block">
                <div class="container">
                    <div class="panel panel-primary">
                        <div class="panel-heading">My Information</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <ul class="list-unstyled">
                                        <li> 
                                        <i class="fa fa-unlock-alt fa-fw"></i>
                                        <span>Name</span>: <?php echo $info['username'];?>
                                        </li>
                                        <li> 
                                        <i class="fa fa-envelope-o fa-fw"></i>
                                        <span>Email</span>: <?php echo $info['email'];?>
                                        </li>
                                        <li> 
                                        <i class="fa fa-user fa-fw"></i>
                                        <span>Full Name</span>: <?php echo $info['fullname'];?>
                                        </li>
                                        <li> 
                                        <i class="fa fa-calendar fa-fw"></i>
                                        <span>Register Date</span>: <?php echo $info['date'];?>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="avatar">
                                        <img src="admin/uploads/avatars/<?php echo $info['avatar'];?>" class="img-responsive img-circle pull-right" 
                                                width="200px" height="150px">
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <a href="profile.php?do=edit&id=<?php echo $info['userid'];?>" class="btn btn-success">Edit information</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="my-Items" class="my-ads block">
                <div class="container">
                    <div class="panel panel-primary">
                        <div class="panel-heading">My Ads</div>
                        <div class="panel-body">
                                <?php 
                                    $rows=getallfrom("*","items","where user_id = $infouserid","","itemid");
                                    if(!empty($rows)){
                                        echo '<div class="row">';
                                            foreach($rows as $row){ ?>
                                                <div class="col-md-3 col-sm-6">
                                                        <div class="thumbnail item-box">
                                                            <?php if($row['approve']==0){echo "<span class='approve-status'>Waiting Approval</span>";}?>
                                                            <span class="price-tag">$<?php echo $row['price'];?></span>
                                                            <img src='admin/uploads/avatars/items/<?php echo $row["avatar"];?>' class="img-responsive">
                                                            <div class="caption content-box">
                                                                <h3><a href="showitem.php?itemid=<?php echo $row['itemid'];?>"> <?php echo $row['name'];?>
                                                                </a></h3>
                                                                <p> <?php echo $row['description'];?> </p>
                                                                <a href="new-ad.php?do=edit&itemid=<?php echo $row['itemid'];?>" class='btn btn-success'>
                                                                    Edit</a>
                                                                <span class='date'> <?php echo $row['date'];?> </span>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </div>
                                                    </div>  
                                            <?php }
                                        echo '</div>';
                                    }
                                    else{
                                            echo 'There\'s No Items To show,Create <a href="new-ad.php">New Ad</a>';
                                    }

                                    ?>
                        </div>        
                    </div>
                </div>
            </div>


            <div id="my-comments" class="my-comments block">
                <div class="container">
                    <div class="panel panel-primary">
                        <div class="panel-heading">My Comments</div>
                        <div class="panel-body">
                            <?php 

                                $rows=getallfrom("comment","comments","where user_id = {$info['userid']}","","commid");
                                //hena ana mast5dmtsh l variabl $infouserid zy l function l foo2 3lshan tshoof l tare2ten fe ketaba
                                if(!empty($rows)){
                                    foreach($rows as $row){ 
                                        echo '<p>' . $row['comment'] . '<p>';
                                    }
                                }
                                else{
                                    echo 'There\'s No Comments To show';
                                }
                            ?>                 
                        </div>
                    </div>
                </div>
            </div>



<?php
    }//end if condition

    elseif($do == 'edit'){


            if(isset($_GET['id']) && is_numeric($_GET['id'])){
                $id=intval($_GET['id']);
            }
            else{
                $id=0;
            }

                $stm=$conn->prepare('select * from users where userid = ? LIMIT 1');
                $stm->execute(array($id));
                $row=$stm->fetch();
                $count=$stm->rowCount();

                if($count > 0){ ?>

                    
                    <h1 class="text-center">Edit Profile</h1>

                    <div class="container"><!--start container-->

                        <form class="form-horizontal form-profile" action="<?php $_SERVER['PHP_SELF']?>?do=update" method="POST" enctype="multipart/form-data">

                            <input type="hidden" name="id" value="<?php echo $id;?>">
                            
                            <!--start username field-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">User Name</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" name="username" value="<?php echo $row['username'];?>" class="form-control" required="required" autocomplete="off">
                                </div>
                            </div>
                            <!--end username field-->

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
                                    <input type="file"  name="avatar" required="required" class="form-control" >
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
                redirecthome($mssg,'back',10);                   
                echo "</div";
                }


    }//end elseif edit

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

                    $avatarExtension =explode('.', $avatarName);//mynfa3sh t3mlhom fe satar wa7ed chhain e3ny 3lshan l php version bta3k adeem
                    $avatarExtension2= end($avatarExtension);
                    $avatarExtension3=strtolower($avatarExtension2);


                    //get data from edit form
                    $id=$_POST['id'];
                    $username=$_POST['username'];
                    $email=$_POST['email'];
                    $fullname=$_POST['fullname'];


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
                    foreach($formerror as $error){
                        echo $error;
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

                            move_uploaded_file($avatarTmp, "admin\uploads\avatars\\" . $avatar);//ba5od path bta3 l sora l user 7atha w b7otha 3ndy fe folder
                          

                            //update data from database
                            $stm=$conn->prepare('update users set username = ? , email= ? , fullname= ? , avatar= ? where userid = ?');
                            $stm->execute(array($username,$email,$fullname,$avatar,$id));

                                //meassage recorded
                                $mssg= "<div class='alert alert-success'>" . $stm->rowCount()." Recorded Updated </div>";
                                redirecthome($mssg,"back");
                            
                            


                        }
            echo "</div";

                    }

        }

        else{
            echo "<div class='container'>";
            $mssg= '<div class="alert alert-danger"> you can\'t access this page directly</div>';
            redirecthome($mssg);                   
            echo "</div";
            
        }
        

    }//end elseif update



}//end session condition

elseif(isset($_GET['userid']) && is_numeric($_GET['userid'])){//admin
    $id=intval($_GET['userid']);


    $stm=$conn->prepare('select * from users where userid = ?');
    $stm->execute(array($id));
    $info=$stm->fetch();
    $infouserid=$info['userid'];
    ?>
        
            <h1 class="text-center"><?php echo $info['username'];?></h1>


            <div class="information block">
                <div class="container">
                    <div class="panel panel-primary">
                        <div class="panel-heading">My Information</div>
                        <div class="panel-body">
                            <ul class="list-unstyled">
                                <li> 
                                <i class="fa fa-unlock-alt fa-fw"></i>
                                <span>Name</span>: <?php echo $info['username'];?>
                                </li>
                                <li> 
                                <i class="fa fa-envelope-o fa-fw"></i>
                                <span>Email</span>: <?php echo $info['email'];?>
                                </li>
                                <li> 
                                <i class="fa fa-user fa-fw"></i>
                                <span>Full Name</span>: <?php echo $info['fullname'];?>
                                </li>
                                <li> 
                                <i class="fa fa-calendar fa-fw"></i>
                                <span>Register Date</span>: <?php echo $info['date'];?>
                                </li>
                            </ul>                
                        </div>
                    </div>
                </div>
            </div>

            <div id="my-Items" class="my-ads block">
                <div class="container">
                    <div class="panel panel-primary">
                        <div class="panel-heading">My Ads</div>
                        <div class="panel-body">
                                <?php 
                                    $rows=getallfrom("*","items","where user_id = $infouserid","AND approve=1","itemid");
                                    if(!empty($rows)){
                                        echo '<div class="row">';
                                            foreach($rows as $row){ ?>
                                                <div class="col-md-3 col-sm-6">
                                                        <div class="thumbnail item-box">
                                                            <span class="price-tag">$<?php echo $row['price'];?></span>
                                                            <img src='img.png' class="img-responsive">
                                                            <div class="caption">
                                                                <h3><a href="showitem.php?itemid=<?php echo $row['itemid'];?>"> <?php echo $row['name'];?>
                                                                </a></h3>
                                                                <p> <?php echo $row['description'];?> </p>
                                                                <span class='date'> <?php echo $row['date'];?> </span>
                                                            </div>
                                                        </div>
                                                    </div>  
                                            <?php }
                                        echo '</div>';
                                    }
                                    else{
                                            echo 'There\'s No Items To show,Create <a href="new-ad.php">New Ad</a>';
                                    }

                                    ?>
                        </div>        
                    </div>
                </div>
            </div>



<?php }
else{
    header('Location:login.php');
    exit();
}
include $temp."footer.php"; ?>