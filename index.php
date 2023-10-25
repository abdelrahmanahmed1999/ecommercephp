<?php
session_start();

include "init.php";

?>


<div class="container">
    <div class="row">
        <?php $items=getallfrom('*','items','where approve = 1','','itemid');
             foreach($items as $item){ ?>
                <div class="col-md-3 col-sm-6">
                    <div class="thumbnail item-box">
                        <span class="price-tag"> $<?php echo $item['price'];?> </span>
                        <img src='admin/uploads/avatars/items/<?php echo $item["avatar"];?>' class="img-responsive">
                        <div class="caption content">
                            <h3><a href="showitem.php?itemid=<?php echo $item['itemid'];?>"> <?php echo $item['name']; ?> </a></h3>
                            <p>  <?php echo $item['description']; ?> </p>
                            <span>

                            <?php 
                                if(!empty($item['tag'])){
                                    $tags=explode(",",$item['tag']);
                                    echo 'Tags: ';
                                    foreach($tags as $tag ){ 
                                        $lowertag=strtolower($tag);?>
                                        <a href="tags.php?name=<?php echo $lowertag ;?>"> <?php echo $tag; ?></a>
                                    
                                <?php    } 
                                }
                                else{
                                    echo "This Item Has No tags";
                                }

                                ?>
                                </span>
                            <span class='date'> <?php echo $item['date'];?> </span>
                        </div>
                    </div>
                </div>  
        <?php } ?>
   </div>
</div>



<?php include $temp."footer.php"; ?>