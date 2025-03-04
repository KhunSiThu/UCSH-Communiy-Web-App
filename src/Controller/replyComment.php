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
    echo json_encode(['error' => 'Missing required fields']);
    exit();
}

// Insert comment using prepared statements
$insertQuery = "INSERT INTO replyComment (comment_id, user_id, comment) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $insertQuery);

if ($stmt === false) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Failed to prepare the SQL statement']);
    exit();
}

mysqli_stmt_bind_param($stmt, 'iis', $id, $userId, $comment);
$insertResult = mysqli_stmt_execute($stmt);

if ($insertResult === false) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Failed to insert the comment']);
    exit();
}

// Success response
http_response_code(201); // Created
echo json_encode(['success' => 'Comment inserted successfully']);

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);