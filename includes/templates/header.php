<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getTitle();?></title>
    <link rel="stylesheet" href="<?php echo $css;?>font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $css;?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $css ?>jquery-ui.css" />
	<link rel="stylesheet" href="<?php echo $css ?>jquery.selectBoxIt.css" />
    <link rel="stylesheet" href="<?php echo $css;?>frontend.css">

</head>
<body>

    <?php if(isset($_SESSION['user'])){ 
      
      $stm=$conn->prepare('select * from users where username = ?');
      $stm->execute(array($usersession));
      $data=$stm->fetch();

      ?>

      
      <div class="upper-bar">
      <div class="container">

          <img class="img-thumbnail img-circle my-image" src="admin/uploads/avatars/<?php echo $data['avatar'];?>">
          <div class="btn-group my-info">
              <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <?php echo $usersession;?>
                <span class="caret"></span>
              </span>  
                <ul class="dropdown-menu">
                  <li> <a href="profile.php">My Profile</a> </li>
                  <li> <a href="new-ad.php">New Item</a> </li>
                  <li> <a href="profile.php#my-comments">My Comments</a> </li>
                  <li> <a href="profile.php#my-Items">My Items</a> </li>
                  <li> <a href="logout.php">Logout</a> </li>

                </ul>
              </span>
          </div>

          <?php
            $userstatus=checkuserstatus($usersession);


            //hena tb ana leh ma3mltsh fe if(isset($usersession)) 3lshan ana 3mloh asign fady fe init.php fa w hwwa m7toot fe if hyl2eh bas
            //kemat l session mash feh hyb2a fady w hyd5ol gwa l if w hy3rdlk profile-logout law 3ayz tgrb 7ot $usersesion fe isset()
            //w 23mel logout wroo7 3la login lesa mafesh session fa l mafrood myzhrlksh 7aga fe upperbar bas fe if bys2al 3la $userssession fa hyl2eha 
            //hy7otlk l kelmt progile-logout ma3 enk lesa ma3mltsh login w lma t3ml login httzbt bas tab3an mynfa3sh tas2l 3la $usersseion 
            //lma user ye3ml login w yt3mloh session 22der 2st5dm l $usersession la2n htkoon et7tet fe kemet session


            if($userstatus == 1){
              //not activated user
            }
            else{
              //activated user

            }

        echo '</div>';
        echo '</div>';
    }
    elseif(isset($_SESSION['name'])){

    }
    else{ ?>
          <div class="upper-bar">
            <div class="container">
              <div class="pull-right">
                  <a href="login.php">login/Signup</a>
              </div>
            </div>
          </div>

    <?php } ?>


    
<nav class="navbar navbar-inverse">
    <div class="container">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav" aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php if(isset($_SESSION['name'])){echo 'admin/index.php';} else{echo 'index.php';}?>"><?php echo lang("home");?></a>


      <div class="collapse navbar-collapse" id="main-nav">
        <ul class="nav navbar-nav navbar-right">

        
          <?php foreach(getallfrom('*','categories','where parent=0','','catid','asc') as $cat){?><!--'where parent=0 3lshan ygbly parent category mash sub category-->
            <li>
              <a href="categories.php?pageid=<?php echo $cat['catid'];?>"><?php echo $cat['name'];?>
              </a>
            </li>
           <?php } ?>
        </ul>


      </div>
    </div>
  </nav>



    
