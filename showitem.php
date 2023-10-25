<?php

session_start();
$pagetitle='ShowItem';

include "init.php"; 




if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])){
            $itemid=intval($_GET['itemid']);
        }
        else{
            $itemid= 0;
        }

            $stm=$conn->prepare('select items.*,categories.name as category_name,users.username,users.userid from items 
                                inner join categories on categories.catid=items.cat_id
                                inner join users on users.userid=items.user_id
                                where  itemid = ? AND approve = 1 ');
            $stm->execute(array($itemid));
            $row=$stm->fetch();
            $count=$stm->rowCount();

            if($count > 0){ 
?>
                <h1 class="text-center"> <?php echo $row['name'];?> </h1>
                <div class="container"><!--start container-->
                    <div class="row">
                        <div class="col-md-3">
                            <img src="admin/uploads/avatars/items/<?php echo $row["avatar"];?>" class="img-responsive ing-thumbnail img-block">
                        </div>
                        <div class="col-md-9 item-info">
                            <h2>              <?php echo $row['name'];?> </h2>
                            <p>               <?php echo $row['description'];?>  <p>
                            <ul class="list-unstyled">
                                <li>
                                    <i class="fa fa-calendar fa-fw"></i>  
                                    <span> Added Date: </span> <?php echo $row['date'];?> 
                                </li>

                                <li>  
                                     <i class="fa fa-money fa-fw"></i>  
                                    <span>  Price: </span> <?php echo $row['price'];?> 
                                </li>

                                <li>  
                                     <i class="fa fa-building fa-fw"></i>  
                                    <span>  Made In: </span> <?php echo $row['country_made'];?> 
                                </li>

                                <li> 
                                    <i class="fa fa-tags fa-fw"></i>            
                                    <span>   Category: </span> <a href="categories.php?pageid=<?php echo $row['cat_id']?>"> 
                                            <?php echo $row['category_name'];?> </a>
                                </li>
                                
                                <li> 
                                    <i class="fa fa-user fa-fw"></i>  
                                    <span>   Added By: </span> <a href="profile.php?userid=<?php echo $row['userid'];?>"> 
                                            <?php echo $row['username'];?> </a>
                                </li>

                                <li> 
                                    <i class="fa fa-user fa-fw"></i>  
                                    <span>   Tags: </span> 
                                            <?php 
                                                $tags=explode(",",$row['tag']);

                                                foreach($tags as $tag ){ 
                                                    $lowertag=strtolower($tag);?>
                                                    <a href="tags.php?name=<?php echo $lowertag ;?>"> <?php echo $tag; ?></a>
                                                <?php }?>
                                </li>
                            </uL>                           
                        </div>
                    </div>

                    <hr class="custom-hr">

                    <?php if(isset($_SESSION['user'])){ ?>
                        <!--strat add comment-->
                        <div class="row">
                            <div class="col-md-offset-3">
                                <div class="add-comment">
                                    <h3> Add Your Comment</h3>
                                    <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $row['itemid'];?>" method="POST">
                                        <textarea name="comment" required></textarea>
                                        <input type="submit" class="btn btn-primary" value="Add">
                                    </form>

                                    <?php
                                        if($_SERVER['REQUEST_METHOD'] == 'POST'){
                                            
                                            $comment=filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
                                            $itemid=$row['itemid'];
                                            $userid=$_SESSION['uid'];
                                            //hena l user l da5el 3la item w by3ml comment 

                                            if(!empty($comment)){
                                                $stm=$conn->prepare('insert into comments(comment,approve,date,item_id,user_id) 
                                                                        values( ? , 0 , now() , ? , ?)');
                                                $stm->execute(array( $comment, $itemid, $userid));

                                                if($stm){
                                                    echo '<div class="alert alert-success">Comment Added</div>';

                                                }
                                            }
                                            else{
                                                echo '<div class="alert alert-danger">You Must Add Comment</div>';
                                                }

                                        }
                                    ?>
                                </div>
                            </div>                
                        </div>
                        <!--end add comment-->

                <?php }
                else{
                    echo "<a href='login.php'>Login/Or/Register</a>";
                }
                ?>
                    <hr class="custom-hr">

                    <?php
                        $stm=$conn->prepare('select comments.* , users.username,users.userid,users.avatar from comments inner join users on comments.user_id=users.userid
                                            where item_id = ? order by commid desc');
                        $stm->execute(array($row['itemid']));
                        $comments=$stm->fetchAll();

                        foreach($comments as $comment){ ?>
                            <div class="comment-box">
                                <div class="row">
                                    <div class="col-sm-2 text-center">
                                        <img src="admin/uploads/avatars/<?php echo $comment["avatar"];?>" class="img-responsive img-thumbnail img-circle center-block">
                                        <?php echo $comment['username'];?> 
                                    </div>
                                    <div class="col-sm-10">
                                        <p class="lead"> <?php echo $comment['comment'];?> </p>
                                    </div>
                                </div>
                                <hr class="custom-hr">
                            </div>
                <?php  }   ?>
                </div> <!--end container-->


    <?php   }
            else{
                echo "<div class='container'>";
                $mssg= '<div class="alert alert-danger"> There\'s So Such Id Or This Item Is Waiting Approval</div>';
                redirecthome($mssg,"back",3);                   
                echo "</div";
            }
    ?>

<?php include $temp."footer.php"; ?>