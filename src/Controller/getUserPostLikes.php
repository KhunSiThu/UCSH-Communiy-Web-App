<?php
session_start();
require_once("./dbConnect.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$userId = (int)$_SESSION['user_id']; // Ensure it's an integer to prevent injection

// SQL Query
$query = "SELECT u.userId, u.name, u.profileImage, p.post_id,pl.createdAt
          FROM postsLike pl
          JOIN user u ON u.userId = pl.user_id
          JOIN posts p ON p.post_id = pl.post_id
          WHERE p.user_id = $userId AND pl.user_id != $userId order by pl.createdAt";

// Execute Query
$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(["error" => "Database query failed: " . mysqli_error($conn)]);
    exit;
}

// Fetch Results
$likes = [];
while ($row = mysqli_fetch_assoc($result)) {
    $likes[] = $row;
}

// Close Connection
mysqli_free_result($result);
mysqli_close($conn);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($likes);
