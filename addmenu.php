<?php

require_once 'config.php';

function insertDishIntoMenu($dishName, $restaurantId, $price) {
    try {
        include ('config.php');
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "INSERT INTO parsed (food_name, restaurant_id, price, day) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);

        // Insert dish for each day of the week
        for ($day = 1; $day <= 5; $day++) {
            $stmt->bindParam(1, $dishName);
            $stmt->bindParam(2, $restaurantId);
            $stmt->bindParam(3, $price);
            $stmt->bindParam(4, $day);
            $result = $stmt->execute();
        }

        return $result;
    } catch (PDOException $e) {
        return false;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dishName = $_POST['dishName'];
    $restaurantId = $_POST['restaurantId'];
    $price = $_POST['price'];

    $result = insertDishIntoMenu($dishName, $restaurantId, $price);

    if ($result) {
        $response = array(
            'status' => 'success',
            'message' => 'Dish added to menu successfully'
        );
    } else {
        $response = array(
            'status' => 'error',
            'message' => 'Failed to add dish to menu'
        );
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request method. Only POST requests are allowed.'
    );
}

$jsonResponse = json_encode($response);

header('Content-Type: application/json');
echo $jsonResponse;
