<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    require_once ('config.php');
    $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $stmt = $pdo->prepare('SELECT parsed.*, food.name 
                               FROM parsed 
                               JOIN food ON parsed.restaurant_id = food.id');
        $stmt->execute();
        $menu = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($menu);
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
    }
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
