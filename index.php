<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(isset($_POST['download'])){
    $url = "http://eatandmeet.sk/tyzdenne-menu";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    $str = "Eat&Meet";
    if(!checkName($str)){
        include('config.php');
        try{
            $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "INSERT INTO food (name,html) VALUES (:name, :html)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":name", $str, PDO::PARAM_STR);

            $stmt->bindParam(":html", $output, PDO::PARAM_STR);
            $stmt->execute();

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    } else
        echo "already exists";

    $url = "https://www.restauracia-drag.sk/denne-menu";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    $str = "Drag";

    if(!checkName($str)){
        include('config.php');
        try{
            $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "INSERT INTO food (name,html) VALUES (:name, :html)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":name", $str, PDO::PARAM_STR);

            $stmt->bindParam(":html", $output, PDO::PARAM_STR);
            $stmt->execute();

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    } else
        echo "already exists";


    $url = "https://www.novavenza.sk/tyzdenne-menu";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    $str = "Venza";

    if(!checkName($str)){
        include('config.php');
        try{
            include('config.php');
            try{
                $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = "INSERT INTO food (name,html) VALUES (:name, :html)";
                $stmt = $db->prepare($query);
                $stmt->bindParam(":name", $str, PDO::PARAM_STR);

                $stmt->bindParam(":html", $output, PDO::PARAM_STR);
                $stmt->execute();

            } catch(PDOException $e) {
                echo $e->getMessage();
            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    } else
        echo "already exists";

}

function checkName($name){

    include('config.php');
    $exist = false;
    try{
        $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT name FROM food WHERE name = :name";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $exist = true;
        }
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
    return $exist;
}

if(isset($_POST['parse'])){
    parseEat("Eat&Meet");
    parseDrag("Drag");
    parseVenza("Venza");
}

function putFoodInDb($restaurant_id, $day, $food_name, $price){
    if($price == 0){
        try{
            include('config.php');
            try{
                $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = "INSERT INTO parsed (restaurant_id,day,food_name) VALUES (:restaurant_id, :day,:food_name)";
                $stmt = $db->prepare($query);
                $stmt->bindParam(":restaurant_id",$restaurant_id, PDO::PARAM_INT);
                $stmt->bindParam(":day",$day, PDO::PARAM_STR);
                $stmt->bindParam(":food_name",$food_name, PDO::PARAM_STR);
                $stmt->execute();

            } catch(PDOException $e) {
                echo $e->getMessage();
            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        try {
            include('config.php');
            try {
                $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query = "INSERT INTO parsed (restaurant_id,day,food_name,price) VALUES (:restaurant_id, :day,:food_name,:price)";
                $stmt = $db->prepare($query);
                $stmt->bindParam(":restaurant_id", $restaurant_id, PDO::PARAM_INT);
                $stmt->bindParam(":day", $day, PDO::PARAM_STR);
                $stmt->bindParam(":food_name", $food_name, PDO::PARAM_STR);
                $stmt->bindParam(":price", $price, PDO::PARAM_STR);
                $stmt->execute();

            } catch (PDOException $e) {
                echo $e->getMessage();
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

function parseVenza($name){
    $restaurantName = $name;
    include('config.php');
    try {
        $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT html FROM food WHERE name = :name";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $html = $results[0]['html'];

    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    if (!empty($html)) {
        $dom->loadHTML($html);
    }

    $xpath = new DOMXPath($dom);
    $id = returnRestaurantId($restaurantName);
    //TODO change for sviatky
    for($i = 1; $i<6; $i++){
        //soups 2
        for($j = 1; $j<3; $j++){
            $soup1 = $xpath->query('//div[@id="day_'. $i .'"]/div[@class="menubar"]/div[@class="row"]/div[@class="col-lg-12 col-md-12"]/div/ul/li[position()='. $j .']/div[@class="leftbar"]/h5')->item(0);
            //var_dump($price);
            if($soup1 == null)
                continue;
            $price = $xpath->query('//div[@id="day_'. $i .'"]/div[@class="menubar"]/div[@class="row"]/div[@class="col-lg-12 col-md-12"]/div/ul/li[position()='. $j .']/div[@class="rightbar d-flex align-items-center"]/h5')->item(0);

            $soup1 = strip_tags($soup1->nodeValue);
            $soup1 = trim($soup1);
            $price = strip_tags($price->nodeValue);
            $price = substr($price, 0, -1);
            $price = trim($price);
            putFoodInDb($id,$i,$soup1,$price);
        }

        for($j = 1; $j<5; $j++){
            $main = $xpath->query('//div[@id="day_'. $i .'"]/div[@class="menubar"]/div[@class="row"]/div[@class="col-lg-6 col-md-12"][position()=1]/div[position()='. $j .']/ul/li/div[@class="leftbar"]/h5')->item(0);
            //var_dump($price);
            if($main == null)
                continue;
            $price = $xpath->query('//div[@id="day_'. $i .'"]/div[@class="menubar"]/div[@class="row"]/div[@class="col-lg-6 col-md-12"][position()=1]/div[position()='. $j .']/ul/li/div[@class="rightbar d-flex align-items-center"]/h5')->item(0);
            $main = strip_tags($main->nodeValue);
            $main = trim($main);
            $price = strip_tags($price->nodeValue);
            $price = substr($price, 0, -1);
            $price = trim($price);
            putFoodInDb($id,$i,$main,$price);
        }
        for($j = 1; $j<5; $j++){
            $main = $xpath->query('//div[@id="day_'. $i .'"]/div[@class="menubar"]/div[@class="row"]/div[@class="col-lg-6 col-md-12"][position()=2]/div[position()='. $j .']/ul/li/div[@class="leftbar"]/h5')->item(0);
            //var_dump($price);
            if($main == null)
                continue;
            $price = $xpath->query('//div[@id="day_'. $i .'"]/div[@class="menubar"]/div[@class="row"]/div[@class="col-lg-6 col-md-12"][position()=2]/div[position()='. $j .']/ul/li/div[@class="rightbar d-flex align-items-center"]/h5')->item(0);
            $main = strip_tags($main->nodeValue);
            $main = trim($main);

            $price = strip_tags($price->nodeValue);
            $price = substr($price, 0, -1);
            $price = trim($price);
            putFoodInDb($id,$i,$main,$price);
        }
    }
}

function parseDrag($name){
    $restaurantName = $name;
    include('config.php');
    try {
        $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT html FROM food WHERE name = :name";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $html = $results[0]['html'];

    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    if (!empty($html)) {
        $dom->loadHTML($html);
    }

    $xpath = new DOMXPath($dom);

    //TODO change for sviatky
    for($i = 1; $i<6; $i++){
        $id = returnRestaurantId($restaurantName);
        $soup = $xpath->query('//div[@class="content"]/section[@class="container_x1"]/div[@class="container"]/div[@class="vnutro"]/div[@class="row"]/div[@class="col-xs-12"][position()=2]/div[@class="tab-content"]/div[@class="tab-pane"][position()='. $i .']/b')->item(0);
        //var_dump($price);
        if($soup != null){
            $soup = strip_tags($soup->nodeValue);
            $soup = trim($soup);
            putFoodInDb($id,$i,$soup,0);
        }

        $main1 = $xpath->query('//div[@class="content"]/section[@class="container_x1"]/div[@class="container"]/div[@class="vnutro"]/div[@class="row"]/div[@class="col-xs-12"][position()=2]/div[@class="tab-content"]/div[@class="tab-pane"][position()='. $i .']/table/tbody/tr/td/b')->item(0);
        if($main1 != null){
            $main1 = strip_tags($main1->nodeValue);
            $main1 = trim($main1);
            $price1 = $xpath->query('//div[@class="content"]/section[@class="container_x1"]/div[@class="container"]/div[@class="vnutro"]/div[@class="row"]/div[@class="col-xs-12"][position()=2]/div[@class="tab-content"]/div[@class="tab-pane"][position()='. $i .']/table/tbody/tr/td[2]')->item(0);
            //var_dump($main1);
            $price1 = strip_tags($price1->nodeValue);
            $price1 = trim($price1);
            putFoodInDb($id,$i,$main1,$price1);
        }

        $main2 = $xpath->query('//div[@class="content"]/section[@class="container_x1"]/div[@class="container"]/div[@class="vnutro"]/div[@class="row"]/div[@class="col-xs-12"][position()=2]/div[@class="tab-content"]/div[@class="tab-pane"][position()='. $i .']/table/tbody/tr[2]/td/h4')->item(0);
        //var_dump($main1);
        if($main2 != null) {
            if($main2->nodeValue != ""){
                $main2 = strip_tags($main2->nodeValue);
                $main2 = trim($main2);
                $main2 = preg_replace('/\s+/', ' ', $main2);
                $price2 = $xpath->query('//div[@class="content"]/section[@class="container_x1"]/div[@class="container"]/div[@class="vnutro"]/div[@class="row"]/div[@class="col-xs-12"][position()=2]/div[@class="tab-content"]/div[@class="tab-pane"][position()=' . $i . ']/table/tbody/tr[2]/td[2]')->item(0);
                //var_dump($main1);
                $price2 = strip_tags($price2->nodeValue);
                $price2 = trim($price2);
                putFoodInDb($id, $i, $main2, $price2);
            }
        }
    }
}

function parseEat($name){
    $restaurantName = $name;
    include('config.php');
    try {
        $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT html FROM food WHERE name = :name";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $html = $results[0]['html'];

    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    if (!empty($html)) {
        $dom->loadHTML($html);
    }

    $xpath = new DOMXPath($dom);

    for($i = 1; $i<6; $i++){
        for($j=1;$j<10;$j++){
            $type = $xpath->query('//div[@id="day-'. $i .'"]/div[@class="col-lg-6 col-md-6 col-sm-6"][position()='. $j .']/div[@class="menu-body menu-left  menu-white "]/div[@class="menu-details"]/div[@class="menu-title clearfix"]/h4')->item(0);
            $name =$xpath->query('//div[@id="day-'. $i .'"]/div[@class="col-lg-6 col-md-6 col-sm-6"][position()='. $j .']/div[@class="menu-body menu-left  menu-white "]/div[@class="menu-details"]/div[@class="menu-description"]/p[@class="desc"]')->item(0);
            if($name == null)
                continue;
            $price = $xpath->query('//div[@id="day-'. $i .'"]/div[@class="col-lg-6 col-md-6 col-sm-6"][position()='. $j .']/div[@class="menu-body menu-left  menu-white "]/div[@class="menu-details"]/div[@class="menu-title clearfix"]/span[@class="price"]')->item(0);
            $price = strip_tags($price->nodeValue);
            $text = '';
            foreach ($name->childNodes as $child) {
                if ($child->nodeName == 'span') {
                    continue; // skip span elements
                }
                $text .= $child->textContent;
            }
            $id = returnRestaurantId($restaurantName);
            putFoodInDb($id,$i,$text,$price);
        }
    }
}

if(isset($_POST['delete'])){
    include('config.php');
    try {
        $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "DELETE FROM parsed";
        $stmt = $db->prepare($query);
        $stmt->execute();

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    try {
        $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "DELETE FROM food";
        $stmt = $db->prepare($query);
        $stmt->execute();

    } catch (PDOException $e) {
        echo $e->getMessage();
    }

}

function returnRestaurantId($name){
    include('config.php');
    try {
        $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT id FROM food WHERE name = :name";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // fetch first row of result set
        $id = $result['id']; // get the value of the 'id' column
        return $id; // return the ID value
    } catch(PDOException $e) {
        echo $e->getMessage();
        return null; // return null in case of error
    }
}

function get_text_from_dom($node, $text) {
    if (!is_null($node->childNodes)) {
        foreach ($node->childNodes as $node) {
            $text = get_text_from_dom($node, $text);
        }
    }
    else {
        return $text . $node->textContent . ' ';
    }
    return $text;
}
function get_inner_html( $node ) {
    $innerHTML= '';
    $children = $node->childNodes;
    foreach ($children as $child) {
        $innerHTML .= $child->ownerDocument->saveXML( $child );
    }

    return $innerHTML;
}
?>

<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Buttons</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class=" navbar-collapse justify-content-md-center" id="navbarsExample08">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="./menupage.php">Menu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./index.php">Buttons</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./editpage.php">Edit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./docu.php">Documentation</a>
            </li>
        </ul>
    </div>
    <div class="navbar-collapse justify-content-md-center" id="navbarsExample08">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="./menuday.php?day=1">Monday</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./menuday.php?day=2">Tuesday</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./menuday.php?day=3">Wednesday</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./menuday.php?day=4">Thursday</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./menuday.php?day=5">Friday</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-5">
    <div class="form-row">
        <div class="form-group col-md-4">
        <form method="post">
            <input type="submit" class="btn btn-primary" name="download" value="Stiahni">
        </form>
        </div>
        <div class="form-group col-md-4">
        <form method="post">
            <input type="submit" class="btn btn-primary" name="parse" value="Rozparsuj">
        </form>
        </div>
        <div class="form-group col-md-4">
        <form method="post">
            <input type="submit" class="btn btn-primary" name="delete" value="Vymaz">
        </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tabulator/4.9.3/js/tabulator.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</body>
</html>