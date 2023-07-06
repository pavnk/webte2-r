<?php

require_once ('config.php');

function updateMenuDishPrice($id, $price) {
    try {
        include ('config.php');
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

        $stmt = $pdo->prepare('UPDATE parsed SET price = :price WHERE id = :id');
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        echo json_encode(['message' => 'Menu dish price updated successfully']);
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to update menu dish price: ' . $e->getMessage()]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $putData);

    if (!isset($putData['foodID'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing id parameter']);
    } else {
        $id = $putData['foodID'];

        if (!isset($putData['newPrice'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing price parameter']);
            exit();
        }

        $price = $putData['newPrice'];
        updateMenuDishPrice($id, $price);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['foodID'] ?? '';
    $price = $_POST['newPrice'] ?? '';


    if (empty($id) || empty($price)) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing id or price parameter']);
        exit();
    }

    updateMenuDishPrice($id, $price);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request method']);
}