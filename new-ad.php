<?php



session_start();

$pagetitle='create new ad';


include "init.php"; 





if(isset($_SESSION['user'])){

    
    if(isset($_GET['do'])){
        $do=$_GET['do'];
    }
    else{
        $do='add';
    }
    
    
        if($do =='add'){ ?>
                

            <h1 class="text-center">Create New Item</h1>


            <div class="create-ad block">
                <div class="container">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Create New Item</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8"><!--start col md 8-->
                                    
                                    <form class="form-horizontal" action="<?php $_SERVER['PHP_SELF']?>?do=insert" method="POST" enctype="multipart/form-data"  >
                                        
                                        <!--start name field-->
                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">Item Name</label>
                                            <div class="col-sm-10 col-md-9">
                                                <input  pattern=".{4,}" title="Username Must Be At Least 4 Characters" type="text" name="name"  
                                                class="form-control"   placeholder="Item Name" 
                                                autocomplete="off" data-class="live-name" required>
                                            </div>
                                        </div>
                                        <!--end name field-->

                                        <!--start description field-->
                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">Description</label>
                                            <div class="col-sm-10 col-md-9">
                                                <input pattern=".{10,}" title="Username Must Be At Least 10 Characters" type="text" name="description" 
                                                class="form-control" placeholder="Description Of Item" autocomplete="new-password" data-class="live-desc" required>
                                            </div>
                                        </div>
                                        <!--end description field-->

                                        <!--start price field-->
                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">Price</label>
                                            <div class="col-sm-10 col-md-9">
                                                <input type="text" name="price" class="form-control" placeholder="Price Of Item"
                                                data-class="live-price" required>
                                            </div>
                                        </div>
                                        <!--end price field-->

                                        <!--start country field-->
                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">Country</label>
                                            <div class="col-sm-10 col-md-9">
                                                <input type="text" name="country" class="form-control"
                                                placeholder="Production Country Name" required>
                                            </div>
                                        </div>
                                        <!--end country field-->

                                        <!--start status field-->
                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">Status</label>
                                            <div class="col-sm-10 col-md-9">
                                            <select name="status" required>
                                                <option value="">....</option>
                                                <option value="1">New</option>
                                                <option value="2">Like New</option>
                                                <option value="3">Used</option>
                                                <option value="4">Old</option>
                                            </select>
                                            </div>
                                        </div>
                                        <!--end status field-->

                                        <!--start category field-->
                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">Category</label>
                                            <div class="col-sm-10 col-md-9">
                                            <select name="category" required>
                                                <option value="">....</option>
                                                <?php
                                                $cats=getallfrom('*','categories','where parent=0','','catid');
                                                foreach($cats as $row){
                                                    echo "<option value='" . $row['catid'] ."'>" .$row['name'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            </div>
                                        </div>
                                        <!--end category field-->

                                        
                                        <!--start tag field-->
                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">Tags</label>
                                            <div class="col-sm-10 col-md-9">
                                                <input type="text" name="tag"  class="form-control"  placeholder="Seperate Betwwen Tags With Comma(,)" autocomplete="off">
                                            </div>
                                        </div>
                                        <!--end tag field-->

                                        <!--start avatar field-->
                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">Avatar</label>
                                            <div class="col-sm-10 col-md-9">
                                                <input type="file"  name="avatar" required="required" class="form-control" data-class="live-img">
                                            </div>
                                        </div>
                                        <!--end avatar field-->

                                        <!--start submit field-->
                                        <div class="form-group form-group-lg">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <input type="submit" value="Add New Item" class="btn btn-primary btn-lg">
                                            </div>
                                        </div>
                                        <!--end submit field-->

                                    </form>

                                </div><!--end col md 8-->

                                <div class="col-md-4"><!--start col md 4-->
                                    <div class="thumbnail item-box live-preview">
                                        <span class="price-tag">$<sapan class="live-price">0</span></span>
                                        <img src='img.png' class="img-responsive live-img">
                                        <div class="caption">
                                            <h3 class='live-name'> hello</h3>
                                            <p class='live-desc'> desc </p>
                                        </div>
                                    </div>
                                </div><!--end col md 4-->
                            </div>
                        </div><!--end panel body-->
                    </div>
                </div>
            </div>

    <?php }
    elseif($do == 'insert'){
            
        //check if user coming from HTTP POST request
        if($_SERVER['REQUEST_METHOD'] == 'POST'){



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

            $formserror=array();

            $name           =filter_var($_POST['name'],FILTER_SANITIZE_STRING);
            $description    =filter_var($_POST['description'],FILTER_SANITIZE_STRING);
            $price          =filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
            $country        =filter_var($_POST['country'],FILTER_SANITIZE_STRING);
            $status         =filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
            $category       =filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
            $tag            =filter_var($_POST['tag'],FILTER_SANITIZE_STRING);



            if( strlen($name) < 4){
                $formserror[]='Username Must Be Greater than 4  Characters';
            }

            if( strlen($description) < 10){
                $formserror[]='Description Must Be Greater than 4  Characters';
            }

            if( strlen($country) < 4){
                $formserror[]='Country Must Be Greater than 4  Characters';
            }

            if(empty($price)){
                $formserror[]='Price Can\'t Be Empty';
            }

            if(empty($status)){
                $formserror[]='Status Can\'t Be Empty';
            }
            
            if(empty($category)){
                $formserror[]='Category Can\'t Be Empty';
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

            if(empty($formserror)){
                                        
                                
                $avatar = rand(0, 10000000000) . '_' . $avatarName;//hena b3ml asm l sora 3lshan mattkrrsh

                move_uploaded_file($avatarTmp, "admin\uploads\avatars\items\\" . $avatar);//ba5od path bta3 l sora l user 7atha w b7otha 3ndy fe folder


                //insert data into database
                $stm=$conn->prepare("insert into  items(name,description,price,date,country_made,status,cat_id,user_id,tag,avatar) 
                                        values(:zname , :zdesc , :zprice, now()  , :zcountry , :zstatus , :zcat , :zmemb , :ztag , :zavatar)");
                $stm->execute(array(
                    "zname"     => $name,
                    "zdesc"     => $description,
                    "zprice"    => $price,
                    "zcountry"  => $country,
                    "zstatus"   => $status,
                    "zcat"      => $category,
                    "zmemb"     => $_SESSION['uid'],
                    "ztag"      => $tag,
                    "zavatar"   =>  $avatar
                ));



                    if(!empty($formserror)){
                        foreach($formserror as $error){
                            echo "<div class='container'>";
                            echo '<div class="alert alert-danger">' . $error . '</div>';
                            echo "</div>";
                        }
                    }
                    else{
                        //meassage recorded
                        echo "<div class='container'>";
                        $mssg= "<div class='alert alert-success'>" . $stm->rowCount()." Recorded inserted</div>";
                        redirecthome($mssg,"back");
                        echo "</div>";
                    }
            }
        }
    }//end insert

    elseif($do=='edit'){

        if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])){
            $id=intval($_GET['itemid']);
        } 
        else{
            $id=0;
        }




        
        $stm=$conn->prepare('select * from items where itemid = ? LIMIT 1');
        $stm->execute(array($id));
        $count=$stm->rowCount();

        if($count > 0){


            $stm=$conn->prepare("select * from items where itemid = ?");
            $stm->execute(array($id));
            $row=$stm->fetch();
        ?>

                                

            <h1 class="text-center">Edit Item</h1>


            <div class="create-ad block">
                <div class="container">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Edit Item</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-8"><!--start col md 8-->
                                    
                                    <form class="form-horizontal" action="<?php $_SERVER['PHP_SELF']?>?do=update" method="POST" enctype="multipart/form-data"  >
                                        <input type="hidden" name="itemid" value="<?php echo $row['itemid'];?>" class="form-control">
                                        <!--start name field-->
                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">Item Name</label>
                                            <div class="col-sm-10 col-md-9">
                                                <input  pattern=".{4,}" title="Username Must Be At Least 4 Characters" type="text" name="name"  
                                                class="form-control"   value="<?php echo $row['name'];?>" 
                                                autocomplete="off" data-class="live-name" required>
                                            </div>
                                        </div>
                                        <!--end name field-->

                                        <!--start description field-->
                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">Description</label>
                                            <div class="col-sm-10 col-md-9">
                                                <input pattern=".{10,}" title="Username Must Be At Least 10 Characters" type="text" name="description" 
                                                class="form-control" value="<?php echo $row['description'];?>" autocomplete="new-password" data-class="live-desc" required>
                                            </div>
                                        </div>
                                        <!--end description field-->

                                        <!--start price field-->
                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">Price</label>
                                            <div class="col-sm-10 col-md-9">
                                                <input type="text" name="price" class="form-control" value="<?php echo $row['price'];?>"
                                                data-class="live-price" required>
                                            </div>
                                        </div>
                                        <!--end price field-->

                                        <!--start country field-->
                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">Country</label>
                                            <div class="col-sm-10 col-md-9">
                                                <input type="text" name="country" class="form-control"
                                                value="<?php echo $row['country_made'];?>" required>
                                            </div>
                                        </div>
                                        <!--end country field-->

                                        <!--start status field-->
                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">Status</label>
                                            <div class="col-sm-10 col-md-9">
                                            <select name="status" required>
                                                <option <?php if($row['status'] == "1"){echo "selected";}?> value="1">New</option>
                                                <option <?php if($row['status'] == "2"){echo "selected";}?> value="2">Like New</option>
                                                <option <?php if($row['status'] == "3"){echo "selected";}?> value="3">Used</option>
                                                <option <?php if($row['status'] == "4"){echo "selected";}?> value="4">Old</option>
                                            </select>
                                            </div>
                                        </div>
                                        <!--end status field-->

                                        <!--start category field-->
                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">Category</label>
                                            <div class="col-sm-10 col-md-9">
                                            <select name="category" required>
                                                <?php

                                                    $stm=$conn->prepare("select * from categories where parent=0");
                                                    $stm->execute();
                                                    $cats=$stm->fetchAll();

                                                    foreach($cats as $cat){ ?>
                                                        <option value=" <?php echo $cat['catid'];?>"  <?php if($cat['catid'] == $row['cat_id']) echo 'selected';?>>
                                                            <?php echo $cat['name'];?>  
                                                        </option>



                                                <?php
                                                }
                                                ?>
                                            </select>
                                            </div>
                                        </div>
                                        <!--end category field-->

                                        
                                        <!--start tag field-->
                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">Tags</label>
                                            <div class="col-sm-10 col-md-9">
                                                <input type="text" name="tag"  class="form-control"  value="<?php echo $row['tag'];?>" autocomplete="off">
                                            </div>
                                        </div>
                                        <!--end tag field-->

                                        <!--start avatar field-->
                                        <div class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">Avatar</label>
                                            <div class="col-sm-10 col-md-9">
                                                <input type="file"  name="avatar" value="<?php echo $row['avatar'];?>" class="form-control" data-class="live-img">
                                            </div>
                                        </div>
                                        <!--end avatar field-->

                                        <!--start submit field-->
                                        <div class="form-group form-group-lg">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <input type="submit" value="Edit Item" class="btn btn-primary btn-lg">
                                            </div>
                                        </div>
                                        <!--end submit field-->

                                    </form>

                                </div><!--end col md 8-->

                                <div class="col-md-4"><!--start col md 4-->
                                    <div class="thumbnail item-box live-preview">
                                        <span class="price-tag">$<sapan class="live-price">0</span></span>
                                        <img src='img.png' class="img-responsive live-img">
                                        <div class="caption">
                                            <h3 class='live-name'> hello</h3>
                                            <p class='live-desc'> desc </p>
                                        </div>
                                    </div>
                                </div><!--end col md 4-->
                            </div>
                        </div><!--end panel body-->
                    </div>
                </div>
            </div>




<?php
        }//end if count>0
        else{
            echo "<div class='container'>";
            $mssg= '<div class="alert alert-danger"> there\'s no such id</div>';
            redirecthome($mssg,'back');                   
            echo "</div";
        }


    }//end edit

    elseif($do =='update'){

        
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

                    $avatarExtension =explode('.', $avatarName);
                    $avatarExtension2= end($avatarExtension);
                    $avatarExtension3=strtolower($avatarExtension2);

                    //get data from edit form [itemid,name,description,price,country,status,member,category]
                    $id=$_POST['itemid'];
                    $name=$_POST['name'];
                    $desc=$_POST['description'];
                    $price=$_POST['price'];
                    $country=$_POST['country'];
                    $status=$_POST['status'];
                    $category=$_POST['category'];
                    $tag=$_POST['tag'];

                    
                    //check input validation at server side

                    $formerror=array();
                    if(empty($name)){
                        $formerror[]='<div class="alert alert-danger">Name can\'t be empty</div>';
                    }
                    if(empty($desc)){
                        $formerror[]='<div class="alert alert-danger">Description can\'t be empty</div>';
                    }
                    if(empty($price)){
                        $formerror[]='<div class="alert alert-danger">Price can\'t be empty</div>';
                    }
                    if(empty($country)){
                        $formerror[]='<div class="alert alert-danger">Country can\'t be empty</div>';
                    }
                    if(empty($status)){
                        $formerror[]='<div class="alert alert-danger">Status can\'t be empty</div>';
                    }
                    if(empty($category)){
                        $formerror[]='<div class="alert alert-danger">Category can\'t be empty</div>';
                    }              
                    
                    if(! empty($avatarName) && ! in_array($avatarExtension3,$avatarAllowedExtension)){
                        $formerror[]='<div class="alert alert-danger">This Extension Is Not Allowed</div>';
                    }
                    if(empty($avatarName)){
                        $formerror[]='<div class="alert alert-danger">Avatar can\'t be empty</div>';
                    }
                    if($avatarSize > 4194304){
                        $formerror[]='<div class="alert alert-danger">Avatar Size Must Be Larger Than 4MB</div>';
                    }
                    

                    foreach($formerror as $error){
                        redirecthome($error,'back',3);
                    }

                    //check if there is no error procced operation

                    if(empty($formerror)){
                        
                        $avatar = rand(0, 10000000000) . '_' . $avatarName;

                        move_uploaded_file($avatarTmp, "admin\uploads\avatars\items\\" . $avatar);


                    //update data from database
                    $stm=$conn->prepare('update items set name = ? , description = ? , price= ? , country_made= ?
                                         , status= ? , user_id= ? , cat_id= ? , tag= ? , avatar= ?  where itemid = ?');
                    $stm->execute(array($name,$desc,$price,$country,$status,$_SESSION['uid'], $category,$tag,$avatar,$id));

                    //meassage recorded
                    $mssg= "<div class='alert alert-success'>" . $stm->rowCount()." Recorded Updated </div>";
                    redirecthome($mssg,"back");
                    }
            echo "</div>";        
        }
        else{
            echo "<div class='container'>";
            $mssg= '<div class="alert alert-danger"> you can\'t access this page directly</div>';
            redirecthome($mssg);                   
            echo "</div";
            
        }
    }//end update

}//end session
else{
    header('Location:login.php');
    exit();
}
include $temp."footer.php"; ?>