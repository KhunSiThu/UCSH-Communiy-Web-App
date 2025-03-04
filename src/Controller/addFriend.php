<?php

require_once("./dbConnect.php");

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$userId = $_SESSION['user_id'];

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid JSON input']);
    exit();
}

$friendId = $data['friendId'] ?? '';
if (empty($friendId)) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Friend ID is required']);
    exit();
}

// Validate and sanitize the input
$friendId = intval($friendId); // Ensure the ID is an integer
if ($friendId <= 0) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid Friend ID']);
    exit();
}

// Check if the friend relationship already exists
$checkQuery = "SELECT * FROM friendList WHERE friend_id = $friendId AND user_id = $userId";
$checkResult = mysqli_query($conn, $checkQuery);

if (!$checkResult) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
    exit();
}

if (mysqli_num_rows($checkResult) > 0) {
    http_response_code(200); // OK
    echo json_encode(['success' => 'Friend relationship already exists', 'friendId' => $friendId]);
    mysqli_close($conn);
    exit();
}

// Friend relationship does not exist, so insert it
$insertQuery = "INSERT INTO friendList (user_id, friend_id) VALUES ($userId, $friendId)";
$insertResult = mysqli_query($conn, $insertQuery);

$insertQuery = "INSERT INTO friendList (user_id, friend_id) VALUES ($friendId, $userId)";
$insertResult = mysqli_query($conn, $insertQuery);

if (!$insertResult) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
    exit();
}

http_response_code(200); // OK
echo json_encode(['success' => 'Friend relationship added successfully', 'friendId' => $friendId]);

// Close the connection
mysqli_close($conn);