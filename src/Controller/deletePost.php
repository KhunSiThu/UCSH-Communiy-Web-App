<?php
header("Content-Type: application/json");

require_once("./dbConnect.php"); // Include your database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get JSON input
    $data = json_decode(file_get_contents("php://input"), true);
    $post_id = $data['post_id'] ?? null;

    if (!$post_id) {
        echo json_encode(["success" => false, "message" => "Missing post ID"]);
        exit;
    }

    // Delete post query
    $sql = "DELETE FROM posts WHERE post_id = $post_id";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete post"]);
    }

    mysqli_close($conn);
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
