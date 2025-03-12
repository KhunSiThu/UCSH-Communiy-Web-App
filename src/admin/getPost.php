<?php

require_once("../Controller/dbConnect.php");
session_start();

header('Content-Type: application/json');

// Validate and sanitize the input
$id = isset($_GET['id']) ? intval($_GET['id']) : null; // Use GET instead of JSON input for simplicity

if (!$id) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid or missing ID']);
    exit();
}

// Use prepared statements to prevent SQL injection
$sql = "SELECT posts.*, user.*
        FROM posts 
        JOIN user ON posts.user_id = user.userId 
        WHERE posts.post_id = ?
        ORDER BY posts.createdAt DESC";

$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database error']);
    exit();
}

mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

$posts = [];

if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $row['images'] = !empty($row['images']) ? explode(",", $row['images']) : [];
        $row['files'] = !empty($row['files']) ? explode(",", $row['files']) : [];
        $row['videos'] = !empty($row['videos']) ? explode(",", $row['videos']) : [];
        $posts[] = $row;
    }
}

echo json_encode($posts);

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>