<?php

Session_start();

//hena admin logined fa hyroo7 3la dashbord mash ay user y5osha fa byshoof l da5el mn url 3ltool direct fe session b asmoh law feh yeb2a admin
//law mafesh yeba2a mash admin user 3ady 
if(isset($_SESSION['name'])){

    $pagetitle='dashbord';    


    include "init.php"; 
    $usersnumber=5;
    $latestusers=getlatest('*','users','userid',$usersnumber);
    $itemnumber=5;
    $latestitems=getlatest('*','items','itemid',$itemnumber);
    $commentsnumber=2;
    ?>

    <!--start statistics-->
    <div class="statistics text-center">
        <h1>Dashbord</h1>
        <div class="container">
            <div class="row">

                <div class="col-md-3">
                    <div class="stats member">
                        <i class="fa fa-users"></i>
                        <div class="info">
                            Total Members
                            <span><a href="member.php"><?php echo getitemscount('userid','users','where groupid=0');?></a></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stats pending">
                        <i class="fa fa-user-plus"></i>
                        <div class="info">
                            Pending Members
                            <span><a href="member.php?do=manage&page=pending"><?php echo getitemscount('userid','users','where regstatus=0');?></a></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stats item">
                        <i class="fa fa-tag"></i>
                        <div class="info">
                            Pending Items
                            <span><a href="items.php"><?php echo getitemscount('itemid','items','where approve=0');?></a></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stats comment">
                        <i class="fa fa-comments"></i>
                        <div class="info">
                            Pending Comments
                            <span><a href="comment.php"><?php echo getitemscount('commid','comments');?></a></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--end statistics-->

    
    <!--start latest-->
    <div class="latest">
        <div class="container">
            <div class="row">

                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="info">
                                <i class="fa fa-users"></i>
                                Latest <?php echo $usersnumber;?> Registerd Users                            
                            </div>
                            <span class="pull-right toggle-info"> <i class="fa fa-plus fa-lg"></i> </span>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                                <?php
                                if(!empty($latestusers)){
                                    foreach($latestusers as $row){?><!--start foreach-->
                                        <li>
                                        <a href="member.php?do=edit&userid=<?php echo $row['userid'];?>"> <?php echo $row['username']."<br>";?> </a>
                                            <a href="member.php?do=edit&userid=<?php echo $row['userid'];?>" class="btn btn-success pull-right">
                                            <i class="fa fa-edit"></i>Edit</a>
                                            
                                            <?php 
                                                if($row['regstatus'] == 0){?><!--start if-->
                                                    <a href="member.php?do=activate&userid=<?php echo $row['userid'];?>" class="btn btn-info pull-right">
                                                    <i class="fa fa-check"></i>Activate</a> 
                                            <?php } ?><!--end if-->
                                        </li>
                            <?php   } /*end foreach*/
                                }//end if empty
                                else{
                                    echo '<div class="alert alert-info">There\'s No Users To Show</div>';
                                }                    
                        ?>
                            </ul>    
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="info">
                                <i class="fa fa-tag"></i>
                                Latest  <?php echo $itemnumber;?> Items
                            </div>
                           <span class="pull-right toggle-info"> <i class="fa fa-plus fa-lg"></i> </span>
                        </div>
                        <div class="panel-body">
                        <ul class="list-unstyled latest-users">
                                <?php
                                if(!empty($latestitems)){
                                    foreach($latestitems as $row){?><!--start foreach-->
                                        <li>
                                            <?php echo $row['name']."<br>";?>
                                            <a href="items.php?do=edit&item=<?php echo $row['itemid'];?>" class="btn btn-success pull-right">
                                            <i class="fa fa-edit"></i>Edit</a>
                                            
                                            <?php 
                                                if($row['approve'] == 0){?><!--start if-->
                                                    <a href="items.php?do=approve&itemid=<?php echo $row['itemid'];?>" class="btn btn-info pull-right">
                                                    <i class="fa fa-check"></i>Activate</a> 
                                            <?php } ?><!--end if-->
                                        </li>
                            <?php   } /*end foreach */             
                                }//end if empty
                                else{
                                    echo '<div class="alert alert-info">There\'s No Items To Show</div>';
                                }      
                            
                            
                            ?> <!--end foreach-->
                            </ul>    
                        </div>
                    </div>
                </div>
            </div>     

            <div class="row">
                               
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="info">
                                <i class="fa fa-comments"></i>
                                    Latest <?php echo $commentsnumber;?>Comments                            
                            </div>
                            <span class="pull-right toggle-info"> <i class="fa fa-plus fa-lg"></i> </span>
                        </div>
                        <div class="panel-body">
                                <?php
                                $stm=$conn->prepare("select comments.*, users.username as user_name from comments
                                inner join users on  users.userid=comments.user_id order by commid desc LIMIT $commentsnumber");
                                $stm->execute();
                                $rows=$stm->fetchAll();
            
                                if(!empty($rows)){
                                foreach($rows as $row){?><!--start foreach-->
                                        <div class="comment-box">
                                            <span class="member-n"> <?php echo $row['user_name'];?> </span>
                                            <p class="member-c"> <?php echo $row['comment'];?> </p>
                                        </div>
                                    

                        <?php   }  /*end foreach*/ 
                                }  /*enf if*/
                                else{
                                    echo '<div class="alert alert-info">There\'s No Items To Show</div>';
                                }   
                        
                        ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--end latest-->


<?php
    include $temp."footer.php";
}
else{
    echo "you have no authorized here";
    header('REFRESH:1;url=index.php');
}

?>