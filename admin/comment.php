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


            $stm=$conn->prepare("select comments.*, users.username as user_name,items.name as item_name from comments
                                inner join users on users.userid=comments.user_id 
                                inner join items on items.itemid=comments.item_id
                                ORDER BY commid desc");
            $stm->execute();
            $row=$stm->fetchAll();

            if(! empty($row)){

        ?>

                <h1 class="text-center">Manage Comment</h1>

                <div class="container"><!--start container-->
                    <div class="table-responsive">
                        <table class="table table-bordered text-center main-table">

                            <tr>
                                <td>#ID</td>
                                <td>Comment</td>
                                <td>Item_Name</td>
                                <td>User_Name</td>
                                <td>Date</td>
                                <td>Control</td>
                            </tr>
                                <?php
                                foreach($row as $data){ ?>
                                    <tr>
                                        <td><?php echo $data['commid'];?></td>
                                        <td><?php echo $data['comment'];?></td>
                                        <td><?php echo $data['item_name'];?></td>
                                        <td><?php echo $data['user_name'];?></td>
                                        <td><?php echo $data['date'];?></td>
                                        <td>
                                            <a href="comment.php?do=edit&commid=<?php echo $data['commid']?>" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
                                            <a href="comment.php?do=delete&commid=<?php echo $data['commid']?>" class="btn btn-danger confirm"><i class="fa fa-close"></i>Delete</a>
                                    
                                            <?php if ($data['approve'] == 0){ ?>
                                            <a href="comment.php?do=approve&commid=<?php echo $data['commid']?>" class="btn btn-info"><i class="fa fa-check"></i>Approve</a>
                                        <?php }?>
                                    
                                        </td>
                                    </tr>
                            <?php }
                                ?>
                        </table>
                    </div>
                </div><!--end container-->

        <?php
            }//end if empty
            else{
                echo '<div class="container">';
                echo '<div class="alert alert-info">There\'s No Comments To Show</div>';
                echo '</div>';
            }
    
        }

        elseif($do == "edit"){//edit page

            if(isset($_GET['commid']) && is_numeric($_GET['commid'])){
                $commid=intval($_GET['commid']);
            }
            else{
                $commid= 0;
            }

                $stm=$conn->prepare('select * from comments where commid = ? LIMIT 1');
                $stm->execute(array($commid));
                $row=$stm->fetch();
                $count=$stm->rowCount();

                if($count > 0){?>

                    
                    <h1 class="text-center">Edit Comment</h1>

                    <div class="container"><!--start container-->

                        <form class="form-horizontal" action="<?php $_SERVER['PHP_SELF']?>?do=update" method="POST">

                            <input type="hidden" name="commid" value="<?php echo $commid;?>">
                            
                            <!--start username field-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Comment</label>
                                <div class="col-sm-10 col-md-6">
                                   <textarea name="comment" class="form-control">
                                        <?php echo $row['comment'];?>
                                </textarea>
                                </div>
                            </div>
                            <!--end username field-->

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
                        //get data from edit form
                        $commid=$_POST['commid'];
                        $comment=$_POST['comment'];

                        //update data from database
                        $stm=$conn->prepare('update comments set comment = ? where commid = ?');
                        $stm->execute(array($comment,$commid));

                        //meassage recorded
                        $mssg= "<div class='alert alert-success'>" . $stm->rowCount()." Recorded Updated </div>";
                        redirecthome($mssg,"back");

                    }
                    else{
                        echo "<div class='container'>";
                        $mssg= '<div class="alert alert-danger"> you can\'t access this page directly</div>';
                        redirecthome($mssg);                   
                        echo "</div";
                        
                    }?>

                </div>
            
            <?php

        }
        elseif($do == "delete"){ //delete page


            //check userid at url
            if(isset($_GET['commid']) && is_numeric($_GET['commid'])){
                $commid=intval($_GET['commid']);
            }
            else{
                $commid=0;
            }
                 ?>

                <h1 class="text-center">Delete Comment</h1>
                <div class="container">

                    <?php
                    
                    $check=checkitem('commid','comments', $commid);

                    if($check > 0){ //check for id's data if exist
                        $stm=$conn->prepare('delete from comments where commid = :zuser');
                        $stm->bindParam(":zuser",$commid);
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
            if(isset($_GET['commid']) && is_numeric($_GET['commid'])){
                $commid=intval($_GET['commid']);
            }
            else{
                $commid=0;
            }


            $check=checkitem('commid','comments', $commid);
            echo "<h1 class='text-center'>Activate Member</h1>";
            echo "<div class='container'>";
            if($check > 0){

                    $stm=$conn->prepare('update comments set approve = 1 where commid = ?');
                    $stm->execute(array($commid));
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

