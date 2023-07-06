<?php

require_once ('config.php');

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

    if (!isset($_GET['day'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing day parameter']);
    } else {
        $day = $_GET['day'];

        $stmt = $pdo->prepare('SELECT parsed.*, food.name FROM parsed 
                               INNER JOIN food ON parsed.restaurant_id = food.id 
                               WHERE parsed.day = :day');
        $stmt->bindParam(':day', $day);
        $stmt->execute();
        $menu = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($menu);
    }
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}