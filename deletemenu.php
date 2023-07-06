<?php
require_once 'config.php';

function deleteRestaurantById($restaurantId) {
    try {
        include ('config.php');
        $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "DELETE FROM parsed WHERE restaurant_id = :restaurant_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':restaurant_id', $restaurantId, PDO::PARAM_INT); // Bind parameter
        $result = $stmt->execute();

        $restaurantQuery = "DELETE FROM food WHERE id = :restaurant_id";
        $restaurantStmt = $pdo->prepare($restaurantQuery);
        $restaurantStmt->bindParam(':restaurant_id', $restaurantId, PDO::PARAM_INT);
        $restaurantStmt->execute();


    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to delete restaurant: ' . $e->getMessage()]);
    }
    return $result;
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if(isset($_GET['restaurantId'])){
        $restaurantId = $_GET['restaurantId'];
    } elseif(isset($_REQUEST['restaurantId'])) {
        $restaurantId = $_REQUEST['restaurantId'];
    }

    if (!isset($restaurantId)) {
        $response = array(
            'status' => 'error',
            'message' => 'Restaurant ID is missing'
        );
    } else {
        $result = deleteRestaurantById($restaurantId);

        if ($result) {
            $response = array(
                'status' => 'success',
                'message' => 'Restaurant deleted successfully'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Failed to delete restaurant'
            );
        }
    }
} elseif ($_POST['_method'] === 'DELETE') {
    $restaurantId = $_POST['restaurantId'];

    if (!isset($restaurantId)) {
        $response = array(
            'status' => 'error',
            'message' => 'Restaurant ID is missing'
        );
    } else {
        $result = deleteRestaurantById($restaurantId);

        if ($result) {
            $response = array(
                'status' => 'success',
                'message' => 'Restaurant deleted successfully'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Failed to delete restaurant'
            );
        }
    }
} else {
    $response = array(
        'status' => 'error',
        'message' => 'Invalid request method'
    );
}

$jsonResponse = json_encode($response);

header('Content-Type: application/json');
echo $jsonResponse;