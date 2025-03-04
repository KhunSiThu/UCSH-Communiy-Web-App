<?php

require_once("./dbConnect.php");

session_start();

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid JSON input']);
    exit();
}

// Validate input
$id = isset($data['id']) ? intval($data['id']) : null;

if (!$id) {
    http_response_code(400);
    echo json_encode(["error" => "Post ID is required"]);
    exit();
}

// Use mysqli_query() but prevent SQL Injection
$query = "SELECT postsComment.*,user.*,postsComment.createdAt FROM postsComment 
left join user on user.userId = postsComment.user_id WHERE postsComment.post_id = " . $id;
$result = mysqli_query($conn, $query);

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Database query failed"]);
    exit();
}

$comments = [];

while ($row = mysqli_fetch_assoc($result)) {
    $comments[] = $row; // Append each row to the array
}

// Return JSON response
echo json_encode(["success" => true, "comments" => $comments]);

?>
