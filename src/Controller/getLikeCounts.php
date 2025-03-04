<?php

session_start();
require_once("./dbConnect.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user ID

// Fetch all posts with like counts and check if the current user liked each post
$query = "SELECT p.post_id, 
                 COUNT(pl.post_id) AS like_count, 
                 MAX(pl.user_id = $user_id) AS user_liked 
          FROM posts p 
          LEFT JOIN postsLike pl ON p.post_id = pl.post_id 
          GROUP BY p.post_id";

$result = mysqli_query($conn, $query);

if (!$result) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
    exit();
}

$likeData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $likeData[$row['post_id']] = [
        'like_count' => (int)$row['like_count'],
        'user_liked' => (bool)$row['user_liked'] // true if user liked, false otherwise
    ];
}

// Return the data as JSON
http_response_code(200);
echo json_encode(['likes' => $likeData]);

// Close the connection
mysqli_close($conn);
?>
