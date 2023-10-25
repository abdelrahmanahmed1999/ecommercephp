
<nav class="navbar navbar-inverse">
    <div class="container">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav" aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashbord.php"><?php echo lang("home");?></a>


      <div class="collapse navbar-collapse" id="main-nav">
        <ul class="nav navbar-nav">
          <li><a href="category.php"><?php echo lang("category");?></a></li>
          <li><a href="items.php"><?php echo lang("items");?></a></li>
          <li><a href="member.php"><?php echo lang("members");?></a></li>
          <li><a href="comment.php"><?php echo lang("comments");?></a></li>
          <li><a href="#"><?php echo lang("statistics");?></a></li>
          <li><a href="#"><?php echo lang("logs");?></a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
             <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang("sevices");?> <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li> <a href="../index.php"><?php echo "Visit Shop";?></a> </li>
                    <li> <a href="member.php?do=edit&userid=<?php echo $_SESSION['id'];?>"><?php echo lang("edit profile");?></a> </li>
                    <li> <a href="#"><?php echo lang("setting");?></a> </li>
                    <li> <a href="logout.php"><?php echo lang("logout");?></a> </li>
                </ul>
            </li>
        </ul>

      </div>
    </div>
  </nav>
