<?php
require_once ('config.php');
try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //$query = "SELECT * FROM person";
    $query = "SELECT * FROM food";
    $stmt = $db->query($query);
    $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $query2 = "SELECT * FROM parsed";
    $stmt = $db->query($query2);
    $foods = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo $e->getMessage();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit</title>
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

    <form action="updatefood.php" method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="foodID" class="form-label">Jedlo:</label>
                <select name="foodID" class="form-control">
                    <?php
                    foreach($foods as $food){
                        echo '<option value="' . $food["id"] . '">' . $food["food_name"] . "</option>";
                    }
                    ?>
                </select>
                <label for="newPrice" class="form-label">Nová cena:</label>
                <input type="number" class="form-control" name="newPrice" id="newPrice" required>
            </div>
            <input type="hidden" name="_method" value="PUT"> 
        </div>
        <button type="submit" class="btn btn-primary">Submit</button><br>
    </form>
    <br>

    <form action="deletemenu.php" method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <select name="restaurantId" class="form-control">
                    <?php
                    foreach($restaurants as $restaurant){
                        echo '<option value="' . $restaurant["id"] . '">' . $restaurant["name"] . "</option>";
                    }
                    ?>
                </select>
                <input type="hidden" name="_method" value="DELETE">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button><br>
    </form>
    <br>
    <div>
        <form action="addmenu.php" method="post" id="addMenuForm">
            <div class="form-row">
                <div class="form-group col-md-4">
                <label for="dishName" class="form-label">Dish Name:</label>
                <input type="text" class="form-control" name="dishName" id="dishName" required>
                </div>
                <div class="form-group col-md-4">
                <label for="restaurantId" class="form-label">Restaurant ID:</label>
                <input type="number" class="form-control" name="restaurantId" id="restaurantId" required>
                </div>
                <div class="form-group col-md-4">
                <label for="price" class="form-label">Price:</label>
                <input type="number" class="form-control" step="0.01" name="price" id="price" required>
                </div>
            </div>
            <input type="submit" class="btn btn-primary" value="Submit">
        </form>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tabulator/4.9.3/js/tabulator.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</body>
</html>