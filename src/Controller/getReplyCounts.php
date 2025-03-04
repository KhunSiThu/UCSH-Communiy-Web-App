<?php

session_start();
require_once("./dbConnect.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

// Fetch comment counts for each post
$query = "SELECT c.comment_id, COUNT(r.comment_id) AS reply_count
          FROM postsComment c
          LEFT JOIN replyComment r ON c.comment_id = r.comment_id
          GROUP BY c.comment_id";

$result = mysqli_query($conn, $query);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
    exit();
}

// Prepare reply data
$replyData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $replyData[$row['comment_id']] = (int) $row['reply_count'];
}

// Return JSON response
header('Content-Type: application/json');
http_response_code(200);
echo json_encode(['replies' => $replyData]);

// Close the database connection
mysqli_close($conn);
?>
