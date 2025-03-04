<?php
header("Content-Type: application/json");
require_once("./dbConnect.php");

// Ensure the request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit;
}

// Get the raw JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Validate input data
if (!isset($data['post_id']) || !isset($data['caption'])) {
    echo json_encode(["success" => false, "message" => "Missing parameters"]);
    exit;
}

$post_id = intval($data['post_id']);
$caption = trim($data['caption']);

// Escape caption to prevent SQL injection
$caption = mysqli_real_escape_string($conn, $caption);

// Construct and execute the update query
$query = "UPDATE posts SET caption = '$caption' WHERE post_id = $post_id";
$result = mysqli_query($conn, $query);

if ($result) {
    echo json_encode(["success" => true, "message" => "Post updated successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update post"]);
}

// Close database connection
mysqli_close($conn);
?>
