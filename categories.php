<?php 

session_start();
include 'init.php';
?>


<div class="container">
    <h1 class="text-center"> Show Category Items </h1>
    <div class="row">



        <?php 
        /*hena saf7a btwrek l items l gwa category*/
        if(isset($_GET['pageid']) && is_numeric($_GET['pageid'])){
            $itemid=intval($_GET['pageid']);
        
            $items=getallfrom("*","items","where cat_id = {$itemid}","AND approve=1","itemid");
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
            $mssg= '<div class="alert alert-danger"> there\'s no such id</div>';
            redirecthome($mssg);                   
            echo "</div";
            }
        ?>
   </div>
</div>





<?php include $temp.'footer.php'; ?>