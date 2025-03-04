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

$id = $data['id'] ?? '';
if (empty($id)) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Post ID is required']);
    exit();
}

// Validate and sanitize the input
$id = intval($id); // Ensure the ID is an integer
if ($id <= 0) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid Post ID']);
    exit();
}

// Check if the like already exists
$checkQuery = "SELECT * FROM postsLike WHERE post_id = $id AND user_id = $userId";
$checkResult = mysqli_query($conn, $checkQuery);

if (!$checkResult) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
    exit();
}

if (mysqli_num_rows($checkResult) > 0) {
    // Like exists, so delete it
    $deleteQuery = "DELETE FROM postsLike WHERE post_id = $id AND user_id = $userId";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if (!$deleteResult) {
        http_response_code(500); // Internal Server Error
        echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
        exit();
    }

    http_response_code(200); // OK
    echo json_encode(['success' => 'Post unliked successfully']);
} else {
    // Like does not exist, so insert it
    $insertQuery = "INSERT INTO postsLike (post_id, user_id) VALUES ($id, $userId)";
    $insertResult = mysqli_query($conn, $insertQuery);

    if (!$insertResult) {
        http_response_code(500); // Internal Server Error
        echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
        exit();
    }

    http_response_code(200); // OK
    echo json_encode(['success' => 'Post liked successfully']);
}

// Close the connection
mysqli_close($conn);