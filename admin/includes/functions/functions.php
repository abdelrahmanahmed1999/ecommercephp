<?php





/*
**get all table
*/

function getallfrom($select,$table,$where=NULL,$and=NULL,$order,$arrange='desc'){
    global $conn;
    $statement=$conn->prepare("select $select from $table $where $and order by $order $arrange");
    $statement->execute();
    $rows=$statement->fetchAll();
    return $rows;
}






/*
**get page title in case of these page has variable $pagetitle
*/


//function to add page title

function getTitle(){
    global $pagetitle;//global 3lshan 23rf 2s2l 3la variable l mawgood fe safa7at

    if(isset($pagetitle)){
        echo $pagetitle;
    }
    else{
        echo "default";
    }
}


/*
****home redirect function
****print error message
****print seconds you want
*/

//hena lma by5ls insert,delete,update aw ay function tanyea by2olo succes w yerg3o l safa7a bta3at insert,delete,update aw ay function tanyea
//ana ba7dad l mssg ba3d function w l url $_SERVER['HTTP_REFERER'] deh l btrg3ny 3la safa7a l 2bleha tb efrd wa7ed da5el mn url direct
//fa w ana bnady function maba3tsh l url leh 3lshan hena hewady 3la homepage

function redirecthome($message,$url=null,$seconds=2){

    if($url === null){
        $url="index.php";
        $link="Homepage";
    }
    else{
        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
            $url=$_SERVER['HTTP_REFERER'];
            $link="Previous Page";
        }
        else{
            $url="index.php";
            $link="Homepage";
        }
    }
    
    echo $message ;
    echo "<div class='alert alert-info'>You Will Be Redirect To $link After  $seconds  Seconds</div>";
    header("REFRESH:$seconds;url=$url");
}



/*
** Function to Check Item In Database [ Function Accept Parameters ]
** $item = The Item To Select [ Example: user, item, category ]
** $table = The Table To Select From [ Example: users, items, categories ]
** $value = The Value Of Select [ Example: Osama, Box, Electronics ]
*/



function checkitem($item,$table,$value){
    global $conn;

    $statement=$conn->prepare("select $item from $table where $item = ? ");
    $statement->execute(array($value));
    $count=$statement->rowCount();
    return $count;
}



/*
***function to return count users
*/

function getitemscount($item,$table,$cond=''){
    global $conn;

    $statement=$conn->prepare("select count($item) from $table $cond");
    $statement->execute();
    return $statement->fetchColumn();
}




/*
**get latest things[users,comments,items]
*/

function getlatest($select,$table,$order,$limit=4){
    global $conn;
    $statement=$conn->prepare("select $select  from $table order by $order desc LIMIT $limit");
    $statement->execute();
    $rows=$statement->fetchAll();
    return $rows;
}



