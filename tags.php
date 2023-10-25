<?php 

session_start();
include 'init.php';
?>


<div class="container">
    <div class="row">



        <?php 
        /*hena saf7a btwrek l items l moshtrkeen fl tag*/
        if(isset($_GET['name'])){
            $tagname=$_GET['name'];
            echo '<h1 class="text-center">' . $tagname . '</h1>';
            
            $items=getallfrom("*","items"," where tag like  '%$tagname%' ","AND approve=1","itemid");
                foreach($items as $item){ ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="thumbnail item-box">
                            <span class="price-tag"> <?php echo $item['price'];?> </span>
                            <img src='admin/uploads/avatars/items/<?php echo $item["avatar"];?>' class="img-responsive">
                            <div class="caption">
                                <h3><a href="showitem.php?itemid=<?php echo $item['itemid'];?>"> <?php echo $item['name']; ?> </a></h3>
                                <p>  <?php echo $item['description']; ?> </p>
                                <span class='date'> <?php echo $item['date'];?> </span>
                            </div>
                        </div>
                    </div>  
        <?php }
        }
        else{
            echo "<div class='container'>";
            $mssg= '<div class="alert alert-danger">You Must Write Tag Name</div>';
            redirecthome($mssg);                   
            echo "</div";
            }
        ?>
   </div>
</div>





<?php include $temp.'footer.php'; ?>