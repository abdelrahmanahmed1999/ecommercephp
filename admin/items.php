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

        $stm=$conn->prepare("select items.*,categories.name as catgory_name,users.username from items
                            inner join users on  users.userid=items.user_id 
                            inner join categories on categories.catid=items.cat_id order by itemid desc");
        $stm->execute();
        $row=$stm->fetchAll();

        if(!empty($row)){
    ?>

            <h1 class="text-center">Manage Item</h1>

            <div class="container"><!--start container-->
                <div class="table-responsive">
                    <table class="table table-bordered text-center main-table">

                        <tr>
                            <td>#ID</td>
                            <td>Avatar</td>
                            <td>Name</td>
                            <td>Description</td>
                            <td>Price</td>
                            <td>Date</td>
                            <td>Catgory_name</td>
                            <td>User_name</td>
                            <td>Control</td>
                        </tr>
                            <?php
                            foreach($row as $data){ ?>
                                <tr>
                                    <td><?php echo $data['itemid'];?></td>
                                    <td><img src='uploads/avatars/items/<?php echo $data['avatar'];?>'</td>
                                    <td><?php echo $data['name'];?></td>
                                    <td><?php echo $data['description'];?></td>
                                    <td><?php echo $data['price'];?></td>
                                    <td><?php echo $data['date'];?></td>
                                    <td><?php echo $data['catgory_name'];?></td>
                                    <td><?php echo $data['username'];?></td>
                                    <td>
                                        <a href="items.php?do=edit&itemid=<?php echo $data['itemid']?>" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                                        <a href="items.php?do=delete&itemid=<?php echo $data['itemid']?>" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a>
                                        <?php if ($data['approve'] == 0){ ?>
                                            <a href="items.php?do=approve&itemid=<?php echo $data['itemid']?>" class="btn btn-info"><i class="fa fa-check"></i>Approve</a>
                                        <?php }?>
                                    
                                    </td>
                                </tr>
                        <?php }
                            ?>
                    </table>
                </div>

                <a href='items.php?do=add' class="btn btn-primary"><i class="fa fa-plus"></i>New Item</a>
            </div><!--end container-->


    <?php
        }//end if empty
        else{
        echo '<div class="container">';
        echo '<div class="alert alert-info">There\'s No Items To Show</div>';
        echo '<a href="items.php?do=add" class="btn btn-primary"><i class="fa fa-plus"></i>New Item</a>';
        echo '</div>';
        }    
    }
    
      

    elseif($do == "add"){ //add page ?>
                            
        <h1 class="text-center">Add New Item</h1>

        <div class="container"><!--start container-->

            <form class="form-horizontal" action="<?php $_SERVER['PHP_SELF']?>?do=insert" method="POST" enctype="multipart/form-data">
                
                <!--start name field-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Item Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name"  class="form-control" required="required" placeholder="Item Name" autocomplete="off">
                    </div>
                </div>
                <!--end name field-->

                <!--start description field-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="description" class="form-control password" required="required" placeholder="Description Of Item" autocomplete="new-password">
                    </div>
                </div>
                <!--end description field-->

                <!--start price field-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Price</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="price" class="form-control" required="required" placeholder="Price Of Item">
                    </div>
                </div>
                <!--end price field-->

                <!--start country field-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Country Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="country" class="form-control" required="required" placeholder="Production Country Name">
                    </div>
                </div>
                <!--end country field-->

                <!--start status field-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10 col-md-6">
                    <select name="status">
                        <option value="0">....</option>
                        <option value="1">New</option>
                        <option value="2">Like New</option>
                        <option value="3">Used</option>
                        <option value="4">Old</option>
                    </select>
                    </div>
                </div>
                <!--end status field-->


                <!--start member field-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Member</label>
                    <div class="col-sm-10 col-md-6">
                    <select name="member">
                        <option value="0">....</option>
                        <?php
                        $stm=$conn->prepare("select * from users");
                        $stm->execute();
                        $users=$stm->fetchAll();

                        foreach($users as $row){
                            echo "<option value='" . $row['userid'] ."'>" .$row['username'] . "</option>";
                        }
                        ?>
                    </select>
                    </div>
                </div>
                <!--end member field-->

                <!--start category field-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Category</label>
                    <div class="col-sm-10 col-md-6">
                    <select name="category">
                        <option value="0">....</option>
                        <?php
                        $stm=$conn->prepare("select * from categories where parent=0");
                        $stm->execute();
                        $cats=$stm->fetchAll();

                        foreach($cats as $row){
                            echo "<option value='" . $row['catid'] ."'>" .$row['name'] . "</option>";
                            $subcats=getallfrom("*","categories","where parent= {$row['catid']}","","catid","asc");
                            foreach($subcats as $subcat){
                                    echo "<option value='" . $subcat['catid'] ."'>---" .$subcat['name'] . "</option>";

                            }
                        }
                        ?>
                    </select>
                    </div>
                </div>
                <!--end category field-->

                <!--start tag field-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Tags</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="tag"  class="form-control"  placeholder="Seperate Betwwen Tags With Comma(,)" autocomplete="off">
                    </div>
                </div>
                <!--end tag field-->

                
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
                        <input type="submit" value="Add New Item" class="btn btn-primary btn-lg">
                    </div>
                </div>
                <!--end submit field-->

            </form>

        </div><!--end container-->



    <?php 
    
    }

    elseif($do == "insert"){//insert page 
                    
        if($_SERVER['REQUEST_METHOD'] == 'POST'){?>

        <h1 class="text-center">Add Item</h1>

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

                //get data from Add form
                $name=$_POST['name'];
                $desc=$_POST['description'];
                $price=$_POST['price'];
                $country=$_POST['country'];
                $status=$_POST['status'];
                $memb=$_POST['member'];
                $cat=$_POST['category'];
                $tag=$_POST['tag'];


                //check input validation at server side
                $formerror=array();
                if(empty($name)){
                    $formerror[]='Name can\'t be empty</div>';
                }
                
                if(empty($desc)){
                    $formerror[]='Description can\'t be Less Than 4 Characters';
                }
                if(empty($price)){
                    $formerror[]='Price can\'t be empty';
                }
                if(empty($country)){
                    $formerror[]='Country can\'t be empty';
                }

                if(empty($status)){
                    $formerror[]='Status can\'t be empty';
                }

                if(empty($memb)){
                    $formerror[]='Member can\'t be empty';
                }

                if(empty($cat)){
                    $formerror[]='Category can\'t be empty';
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

                    
                        
                    $avatar = rand(0, 10000000000) . '_' . $avatarName;

                    move_uploaded_file($avatarTmp, "uploads\avatars\items\\" . $avatar);


                    //insert data into database
                    $stm=$conn->prepare("insert into  items(name,description,price,date,country_made,status,cat_id,user_id,tag,avatar) 
                                            values(:zname , :zdesc , :zprice, now()  , :zcountry , :zstatus , :zcat , :zmemb , :ztag , :zavatar)");
                    $stm->execute(array(
                        "zname"     => $name,
                        "zdesc"     => $desc,
                        "zprice"    => $price,
                        "zcountry"  => $country,
                        "zstatus"   => $status,
                        "zcat"      => $cat,
                        "zmemb"     => $memb,
                        "ztag"      => $tag,
                        "zavatar"  => $avatar
                    ));

                    //meassage recorded
                    $mssg= "<div class='alert alert-success'>" . $stm->rowCount()." Recorded inserted</div>";
                    redirecthome($mssg,"back");
                    
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

        if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])){
            $itemid=intval($_GET['itemid']);
        }
        else{
            $itemid= 0;
        }

            $stm=$conn->prepare('select * from items where itemid = ?');
            $stm->execute(array($itemid));
            $row=$stm->fetch();
            $count=$stm->rowCount();

            if($count > 0){?>

                <h1 class="text-center">Edit Item</h1>

                <div class="container"><!--start container-->

                    <form class="form-horizontal" action="<?php $_SERVER['PHP_SELF']?>?do=update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="itemid" value="<?php echo $row['itemid'];?>"  class="form-control">
                        <!--start name field-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Item Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="name"  class="form-control" required="required" value="<?php echo $row['name'];?>"  autocomplete="off">
                            </div>
                        </div>
                        <!--end name field-->

                        <!--start description field-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">description</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="description" class="form-control password" required="required" value="<?php echo $row['description'];?>"  autocomplete="new-password">
                            </div>
                        </div>
                        <!--end description field-->

                        <!--start price field-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="price" class="form-control" required="required" value="<?php echo $row['price'];?>" >
                            </div>
                        </div>
                        <!--end price field-->

                        <!--start country field-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Country Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="country" class="form-control" required="required" value="<?php echo $row['country_made'];?>" >
                            </div>
                        </div>
                        <!--end country field-->

                        <!--start status field-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10 col-md-6">
                            <select name="status">
                                <option value="1" <?php if($row['status'] == 1)echo 'selected';?> >New</option>
                                <option value="2" <?php if($row['status'] == 2)echo 'selected';?> >Like New</option>
                                <option value="3" <?php if($row['status'] == 3)echo 'selected';?> >Used</option>
                                <option value="4" <?php if($row['status'] == 4)echo 'selected';?> >Old</option>
                            </select>
                            </div>
                        </div>
                        <!--end status field-->


                        <!--start member field-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Member</label>
                            <div class="col-sm-10 col-md-6">
                            <select name="member">
                                <?php
                                $stm=$conn->prepare("select * from users");
                                $stm->execute();
                                $users=$stm->fetchAll();

                                foreach($users as $user){ ?>
                                  <option value=" <?php echo $user['userid'];?>"  <?php if($user['userid'] == $row['user_id']) echo 'selected';?>>
                                   <?php echo $user['username'];?>  </option>;
                            <?php }
                                ?>
                            </select>
                            </div>
                        </div>
                        <!--end member field-->

                        <!--start category field-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-10 col-md-6">
                            <select name="category">
                                <?php
                                $stm=$conn->prepare("select * from categories");
                                $stm->execute();
                                $cats=$stm->fetchAll();

                                foreach($cats as $cat){ ?>
                                    <option value=" <?php echo $cat['catid'];?>"  <?php if($cat['catid'] == $row['cat_id']) echo 'selected';?>>
                                    <?php echo $cat['name'];?>  </option>
                             <?php }
                                 ?>
                            </select>
                            </div>
                        </div>
                        <!--end category field-->

                        <!--start tag field-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Tags</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="tag"  class="form-control"  value="<?php echo $row['tag'];?>" autocomplete="off">
                            </div>
                        </div>
                        <!--end tag-->

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
                                <input type="submit" value="Update Item" class="btn btn-primary btn-lg">
                            </div>
                        </div>
                        <!--end submit field-->

                    </form>

                    <?php   
                    $stm=$conn->prepare("select comments.*, users.username as user_name from comments
                                        inner join users on  users.userid=comments.user_id 
                                        where item_id = ? ");
                    $stm->execute(array($itemid));
                    $row=$stm->fetchAll();

                    if(!empty($row)){
                    ?>

                        <h1 class="text-center">Manage Comment</h1>

                        <div class="table-responsive">
                            <table class="table table-bordered text-center main-table">

                                <tr>
                                    <td>Comment</td>
                                    <td>User_Name</td>
                                    <td>Date</td>
                                    <td>Control</td>
                                </tr>
                                    <?php
                                    foreach($row as $data){ ?>
                                        <tr>
                                            <td><?php echo $data['comment'];?></td>
                                            <td><?php echo $data['user_name'];?></td>
                                            <td><?php echo $data['date'];?></td>
                                            <td>
                                                <a href="comment.php?do=edit&commid=<?php echo $data['commid']?>" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                                                <a href="comment.php?do=delete&commid=<?php echo $data['commid']?>" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a>
                                        
                                                <?php if ($data['approve'] == 0){ ?>
                                                <a href="comment.php?do=approve&commid=<?php echo $data['commid']?>" class="btn btn-info"><i class="fa fa-check"></i>Approve</a>;
                                            <?php }?>
                                        
                                            </td>
                                        </tr>
                                <?php }
                                    ?>
                            </table>
                        </div>

                    <?php }/*end if empty*/
                        else{
                            echo '<div class="alert alert-info">There\'s No Comments To Show</div>';
                        }
                    ?>

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

                    $avatarExtension =explode('.', $avatarName);//mynfa3sh t3mlhom fe satar wa7ed chhain e3ny 3lshan l php version bta3k adeem
                    $avatarExtension2= end($avatarExtension);
                    $avatarExtension3=strtolower($avatarExtension2);

                    //get data from edit form [itemid,name,description,price,country,status,member,category]
                    $id=$_POST['itemid'];
                    $name=$_POST['name'];
                    $desc=$_POST['description'];
                    $price=$_POST['price'];
                    $country=$_POST['country'];
                    $status=$_POST['status'];
                    $member=$_POST['member'];
                    $category=$_POST['category'];
                    $tag=$_POST['tag'];

                    
                    //check input validation at server side

                    $formerror=array();
                    if(empty($name)){
                        $formerror[]='Name can\'t be empty';
                    }
                    if(empty($desc)){
                        $formerror[]='Description can\'t be empty';
                    }
                    if(empty($price)){
                        $formerror[]='Price can\'t be empty';
                    }
                    if(empty($country)){
                        $formerror[]='Country can\'t be empty';
                    }
                    if(empty($status)){
                        $formerror[]='Status can\'t be empty';
                    }
                    if(empty($member)){
                        $formerror[]='Member can\'t be empty';
                    }                    
                    if(empty($category)){
                        $formerror[]='Category can\'t be empty';
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
                        echo '<div class="alert alert-danger">' . $error . '</div>';
                    }

                    //check if there is no error procced operation

                    if(empty($formerror)){
                        
                        $avatar = rand(0, 10000000000) . '_' . $avatarName;//hena b3ml asm l sora 3lshan mattkrrsh

                        move_uploaded_file($avatarTmp, "uploads\avatars\items\\" . $avatar);//ba5od path bta3 l sora l user 7atha w b7otha 3ndy fe folder


                    //update data from database
                    $stm=$conn->prepare('update items set name = ? , description = ? , price= ? , country_made= ?
                                         , status= ? , user_id= ? , cat_id= ? , tag= ? , avatar= ?  where itemid = ?');
                    $stm->execute(array($name,$desc,$price,$country,$status,$member, $category,$tag,$avatar,$id));

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
            
        }?>

        <?php

    }
    elseif($do == "delete"){ //delete page


        //check userid at url
        if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])){
            $itemid=intval($_GET['itemid']);
        }
        else{
            $itemid=0;
        }
                ?>

            <h1 class="text-center">Delete Item</h1>
            <div class="container">

                <?php
                
                $check=checkitem('itemid','items', $itemid);

                if($check > 0){ //check for id's data if exist
                    $stm=$conn->prepare('delete from items where itemid = :zitem');
                    $stm->bindParam(":zitem",$itemid);
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
    elseif($do == "approve"){//activate page
        if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])){
            $itemid=intval($_GET['itemid']);
        }
        else{
            $itemid=0;
        }


        $check=checkitem('itemid','items',$itemid);
        echo "<h1 class='text-center'>Activate Item</h1>";
        echo "<div class='container'>";
        if($check > 0){

                $stm=$conn->prepare('update items set approve = 1 where itemid = ?');
                $stm->execute(array($itemid));
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

