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

// Validate input
$id = $data['id'] ?? null;
$comment = $data['comment'] ?? '';

if (empty($id) || empty($comment)) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Post ID and comment are required']);
    exit();
}

// Escape inputs to prevent SQL Injection
$id = mysqli_real_escape_string($conn, $id);
$comment = mysqli_real_escape_string($conn, $comment);

// Insert comment
$insertQuery = "INSERT INTO postsComment (post_id, user_id, comment) VALUES ('$id', '$userId', '$comment')";
$insertResult = mysqli_query($conn, $insertQuery);

if (!$insertResult) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
    exit();
}

http_response_code(200); // OK
echo json_encode(['success' => 'Post commented successfully']);

mysqli_close($conn);
