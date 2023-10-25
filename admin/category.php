<?php

session_start();


if(isset($_SESSION['name'])){
    include "init.php";

    $do='';
    if(isset($_GET['do'])){
        $do=$_GET['do'];
    }
    else{
        $do='manage';
    }


    if($do == 'manage'){//manage page

        $order="asc";

        $sortarray=array("asc","desc");

        if(isset($_GET['sort']) && in_array($_GET['sort'],$sortarray) ){
            $order=$_GET['sort'];
        }

        $stm=$conn->prepare("select * from categories where parent=0 order by ordering $order");
        $stm->execute();
        $cats=$stm->fetchAll();

        if(!empty($cats)){
    ?>
        
            <h1 class="text-center">Manage Category</h1>
            <div class="container categories">
                <div class="panel panel-default">
                    <div class="panel-heading links">
                        <h3 class="pull-left"><i class="fa fa-edit"></i>Manage Category</h3>
                        <div class="option pull-right">
                            <i class="fa fa-sort"></i>
                            Ordering:[
                            <a href="?sort=asc"  class="<?php if($order == 'asc'){ echo 'active';}?>">Asc</a> |
                            <a href="?sort=desc" class="<?php if($order == 'desc'){ echo 'active';}?>">Desc</a>]
                            <i class="fa fa-eye"></i>
                            View:[
                            <span class='active' data-value="full">Full</span> |
                            <span data-value="classic">Classic</span>] 

                        </div>
                    </div>
                    <div class="panel-body">
                        <?php foreach($cats as $row){ ?>
                            <div class="cat"><!--start cat-->
                                <div class="hidden-buttons">
                                    <a href="category.php?do=edit&catid=<?php echo $row['catid'];?>" class="btn btn-primary">
                                        <i class="fa fa-edit"></i>Edit
                                    </a>
                                    <a href="category.php?do=delete&catid=<?php echo $row['catid'];?>" class="btn btn-danger confirm">
                                        <i class="fa fa-close"></i>Delete
                                    </a>
                                </div>

                                <h3> <?php echo $row['name']?> </h3>
                                <div class="full-view">
                                    <p>
                                        <?php 
                                            if($row['description'] == ''){echo "this Category Has No Description";}
                                            else{echo $row['description'];}
                                        ?>
                                    </p>
                                    <?php
                                        if($row['visibility'] == 1){echo '<span class="visible cat-span"><i class="fa fa-eye"></i>Hidden</span>';}
                                        if($row['allow_comments'] == 1){echo '<span class="comment cat-span"><i class="fa fa-close"></i>Comment Disabled</span>';}
                                        if($row['allow_ads'] == 1){echo '<span class="advertise cat-span"><i class="fa fa-close"></i>Comment Disabled</span>';}
                                    ?>
                                </div>
                                <!--get sub category of these parent category-->
                                <?php
                                     $subcategory=getallfrom("*","categories","where parent = {$row['catid']}","","catid","asc");

                                    if(!empty($subcategory)){
                                        echo '<h3 class="child-head">Sub Category </h3>';
                                        echo  '<ul class="list-unstyled child-cats">';
                                        foreach($subcategory as $subcat){ ?>
                                            <li class="sub-cat"> 
                                                <a href="category.php?do=edit&catid=<?php echo $subcat['catid'];?>">
                                                    <?php echo $subcat['name']; ?>
                                                </a>
                                                <a href="category.php?do=delete&catid=<?php echo $subcat['catid'];?>" class="show-delete confirm">
                                                    Delete
                                                </a>
                                            </li>
                                        <?php  }
                                        echo '</ul>';
                                    }

                                    ?>
                                <hr>                        
                            </div><!--end cat-->
                        <?php  } ?>    
                    </div>
                </div>
                <a href='category.php?do=add' class="btn btn-primary add-category"><i class="fa fa-plus"></i>New Category</a>
            </div>

    <?php
    
        }//end if empty
        else{
            echo '<div class="container">';
            echo '<div class="alert alert-info">There\'s No Categories To Show</div>';
            echo '<a href="category.php?do=add" class="btn btn-primary add-category"><i class="fa fa-plus"></i>New Category</a>';
            echo '</div>';
        }
    
    }
    elseif($do == 'add'){//add page ?>

            <h1 class="text-center">Add New Category</h1>

            <div class="container"><!--start container-->

                <form class="form-horizontal" action="<?php $_SERVER['PHP_SELF']?>?do=insert" method="POST">
                    
                    <!--start catname field-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Category Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="name"  class="form-control" required="required" placeholder="Category Name">
                        </div>
                    </div>
                    <!--end catname field-->

                    <!--start description field-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="description" class="form-control" placeholder="Description Of Category">
                        </div>
                    </div>
                    <!--end description field-->

                    <!--start ordering field-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Ordering</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="order" class="form-control" placeholder="Order Of Category">
                        </div>
                    </div>
                    <!--end ordering field-->

                    <!--start parent field-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Parent</label>
                        <div class="col-sm-10 col-md-6">
                            <select name="parent">
                                <option value="0">None</option>
                                <?php
                                    $parentcategory=getallfrom("*","categories","where parent=0","","catid","asc");
                                    foreach($parentcategory as $cat){ ?>
                                        <option value="<?php echo $cat['catid'];?>"> <?php echo $cat['name'];?>  </option>
                                    <?php } ?>
                            </select>
                        </div>
                    </div>
                    <!--end parent field-->


                    <!--start visible field-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Allow Visibility</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input type="radio" name="visible" value="0" id="visible-yes" checked>
                                <label for="visible-yes">Yes</label>
                            </div>
                            <div>
                                <input type="radio" name="visible" value="1" id="visible-no">
                                <label for="visible-no">no</label>
                            </div>
                        </div>
                    </div>
                    <!--end visible field-->

                    
                    <!--start comment field-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Allow Comments</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input type="radio" name="comment" value="0" id="comment-yes" checked>
                                <label for="comment-yes">Yes</label>
                            </div>
                            <div>
                                <input type="radio" name="comment" value="1" id="comment-no">
                                <label for="comment-no">no</label>
                            </div>
                        </div>
                    </div>
                    <!--end comment field-->

                                        
                    <!--start advertise field-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Allow Advertises</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input type="radio" name="advertise" value="0" id="advertise-yes" checked>
                                <label for="advertise-yes">Yes</label>
                            </div>
                            <div>
                                <input type="radio" name="advertise" value="1" id="advertise-no">
                                <label for="advertise-no">no</label>
                            </div>
                        </div>
                    </div>
                    <!--end advertise field-->



                    <!--start submit field-->
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Add New Category" class="btn btn-primary btn-lg">
                        </div>
                    </div>
                    <!--end submit field-->

                </form>

            </div><!--end container-->




    <?php 
    }
    elseif($do == 'insert'){//insert page
                               
        if($_SERVER['REQUEST_METHOD'] == 'POST'){?>

            <h1 class="text-center">Add Category</h1>

            <div class="container">
            
                <?php
                //get data from Add form<!--name,description,order,visible,comment,advertise-->
                $name=$_POST['name'];
                $desc=$_POST['description'];
                $order=$_POST['order'];
                $parent=$_POST['parent'];
                $vis=$_POST['visible'];
                $comm=$_POST['comment'];
                $ads=$_POST['advertise'];



                //check if there is no error procced operation

                if(!empty($name)){

                    //check if username exist to avoid repetition

                    $check=checkitem("name","categories",$name);

                    if($check == 1){
                        $mssg="<div class='alert alert-danger'>sorry Category Name is exist try another one</div>";
                        redirecthome($mssg,"home");
                    }
                    else{

                        //insert data into database
                        $stm=$conn->prepare("insert into  categories(name,description,ordering,parent,visibility,allow_comments,allow_ads,date) 
                                                values(:zname , :zdesc , :zord , :zpar , :zvis , :zcomm , :zads , now() )");
                        $stm->execute(array(
                            "zname"  => $name,
                            "zdesc"  => $desc,
                            "zord"   => $order,
                            "zpar"   => $parent,
                            "zvis"   => $vis,
                            "zcomm"  => $comm,
                            "zads"   => $ads,
                        ));

                        //meassage recorded
                        $mssg= "<div class='alert alert-success'>" . $stm->rowCount()." Recorded inserted</div>";
                        redirecthome($mssg,"back");
                    }
                }
                else{
                    $mssg='Sorry Name Field Can\'t Be Empty';
                    redirecthome($mssg,'back');
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

    elseif($do == 'edit'){//edit page

        
            if(isset($_GET['catid']) && is_numeric($_GET['catid'])){
                $catid=intval($_GET['catid']);
            }
            else{
                $catid= 0;
            }

                $stm=$conn->prepare('select * from categories where catid = ? LIMIT 1');
                $stm->execute(array($catid));
                $row=$stm->fetch();
                $count=$stm->rowCount();

                if($count > 0){?>

                    
                    <h1 class="text-center">Edit Category</h1>

                    <div class="container"><!--start container-->


                        <form class="form-horizontal" action="<?php $_SERVER['PHP_SELF']?>?do=update" method="POST">

                            <input type="hidden" name="id" value="<?php echo $catid;?>">
                            <!--start catname field-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Category Name</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" name="name"  class="form-control" required="required" placeholder="Category Name" value="<?php echo $row['name']?>">
                                </div>
                            </div>
                            <!--end catname field-->

                            <!--start description field-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" name="description" class="form-control" placeholder="Description Of Category" value="<?php echo $row['description']?>">
                                </div>
                            </div>
                            <!--end description field-->

                            <!--start ordering field-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Ordering</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" name="order" class="form-control" placeholder="Order Of Category"  value="<?php echo $row['ordering']?>">
                                </div>
                            </div>
                            <!--end ordering field-->

                            <!--start parent field-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Parent</label>
                                <div class="col-sm-10 col-md-6">
                                    <select name="parent">
                                        <option value="0">None</option>
                                        <?php
                                            $parentcategory=getallfrom("*","categories","where parent=0","","catid","asc");
                                            foreach($parentcategory as $cat){ ?>
                                                <option value="<?php echo $cat['catid'];?>" <?php
                                                    if($row['parent'] == $cat['catid']){echo 'selected';}
                                                ?>> 
                                                    <?php echo $cat['name'];?>  
                                                </option>
                                            <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <!--end parent field-->


                            <!--start visible field-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Allow Visibility</label>
                                <div class="col-sm-10 col-md-6">
                                    <div>
                                        <input type="radio" name="visible" value="0" id="visible-yes"  <?php if($row['visibility'] == 0){echo 'checked';} ?> >
                                        <label for="visible-yes">Yes</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="visible" value="1" id="visible-no" <?php if($row['visibility'] == 1){echo 'checked';} ?>>
                                        <label for="visible-no">no</label>
                                    </div>
                                </div>
                            </div>
                            <!--end visible field-->

                            
                            <!--start comment field-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Allow Comments</label>
                                <div class="col-sm-10 col-md-6">
                                    <div>
                                        <input type="radio" name="comment" value="0" id="comment-yes" <?php if($row['allow_comments'] == 0){echo 'checked';} ?> >
                                        <label for="comment-yes">Yes</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="comment" value="1" id="comment-no" <?php if($row['allow_comments'] == 1){echo 'checked';} ?>>
                                        <label for="comment-no">no</label>
                                    </div>
                                </div>
                            </div>
                            <!--end comment field-->

                                                
                            <!--start advertise field-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Allow Advertises</label>
                                <div class="col-sm-10 col-md-6">
                                    <div>
                                        <input type="radio" name="advertise" value="0" id="advertise-yes" <?php if($row['allow_ads'] == 0){echo 'checked';} ?>>
                                        <label for="advertise-yes">Yes</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="advertise" value="1" id="advertise-no" <?php if($row['allow_ads'] == 1){echo 'checked';} ?>>
                                        <label for="advertise-no">no</label>
                                    </div>
                                </div>
                            </div>
                            <!--end advertise field-->



                            <!--start submit field-->
                            <div class="form-group form-group-lg">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="submit" value="Save" class="btn btn-primary btn-lg">
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
    elseif($do == 'update'){//update page

                  
        if($_SERVER['REQUEST_METHOD'] == 'POST'){?>

            <h1 class="text-center">Update Data</h1>

            <div class="container">
                
                <?php
                //get data from edit form
                $id=$_POST['id'];
                $name=$_POST['name'];
                $desc=$_POST['description'];
                $order=$_POST['order'];
                $parent=$_POST['parent'];
                $vis=$_POST['visible'];
                $comm=$_POST['comment'];
                $ads=$_POST['advertise'];

                //check if there is no error procced operation

                if(!empty($name)){

                //update data from database
                $stm=$conn->prepare('update categories set name = ? , description = ? , ordering= ? , parent= ? , visibility= ? , allow_comments = ? ,
                                     allow_ads  = ? where catid = ?');
                $stm->execute(array($name,$desc,$order,$parent,$vis,$comm,$ads,$id));

                //meassage recorded
                $mssg= "<div class='alert alert-success'>" . $stm->rowCount()." Recorded Updated </div>";
                redirecthome($mssg,"back");
                }
                else{
                    $mssg='sorry Field Name Can\'t Be Empty';
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
    elseif($do == 'delete'){//delete page

        if(isset($_GET['catid']) && is_numeric($_GET['catid'])){
            $id=intval($_GET['catid']);
        }
        else{
            $id=0;
        }
        ?>

        
        <h1 class="text-center">Delete Member</h1>
        <div class="container">
            <?php
            $check=checkitem('catid','categories',$id);

            if($check > 0){
                $stm=$conn->prepare('delete from categories where catid = ?');
                $stm->execute(array($id));

                $mssg='<div class="alert alert-success">'. $stm->rowCount() .' Recorded Deleted</div>';
                redirecthome($mssg,'back');

            }
            else{
                $mssg='<div class="alert alert-danger"> Sorry there\'s No Such ID</div>';
                redirecthome($mssg,'back');
            } ?>
         </div>   
            

<?php }
    include $temp."footer.php";

}
else{
    echo "you have no authorized here";
    header("REFRESH:1;url=index.php");
    exit();
}

