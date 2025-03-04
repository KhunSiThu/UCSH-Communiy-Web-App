<?php
header('Content-Type: application/json');

require_once("./dbConnect.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$userId = $_SESSION['user_id'];

// Correct SQL syntax
$sql = "UPDATE user SET status = 'Offline' WHERE userId = $userId";

$update = mysqli_query($conn, $sql);

if ($update) {
    // Destroy the session
    session_destroy();
    
    // Return a success response
    echo json_encode(["success" => true]);
} else {
    // Return an error response
    http_response_code(500);
    echo json_encode(["error" => "Failed to update user status"]);
}

mysqli_close($conn);
?>