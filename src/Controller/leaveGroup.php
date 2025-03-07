<?php

require_once("./dbConnect.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$userId = $_SESSION['user_id'];
$groupId = $_SESSION['group_id'];

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
    exit();
}

// Get JSON data
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['action']) || $data['action'] !== "leave") {
    http_response_code(400);
    echo json_encode(["error" => "Invalid request"]);
    exit();
}

// Escape the user ID to prevent SQL injection
$userId = $conn->real_escape_string($userId);

// Remove the user from the group
$sql = "DELETE FROM `groupMember` WHERE memberId = '$userId' and groupId = '$groupId'";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo json_encode(["success" => true, "message" => "You have left the group"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to leave the group: " . mysqli_error($conn)]);
}

mysqli_close($conn);
?>