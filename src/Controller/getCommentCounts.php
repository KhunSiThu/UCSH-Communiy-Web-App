<?php

session_start();
require_once("./dbConnect.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

// Fetch comment counts for each post
$query = "SELECT p.post_id, COUNT(c.comment_id) AS comment_count
          FROM posts p
          LEFT JOIN postsComment c ON p.post_id = c.post_id
          GROUP BY p.post_id";

$result = mysqli_query($conn, $query);

if (!$result) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
    exit();
}

$commentData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $commentData[$row['post_id']] = (int)$row['comment_count'];
}

// Return the data as JSON
http_response_code(200);
echo json_encode(['comments' => $commentData]);

// Close the connection
mysqli_close($conn);
?>
