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
$query = "SELECT u.userId, u.name, u.profileImage , dl.deleted_at, dl.post_id, dl.reason
          FROM deletion_logs dl
          JOIN user u ON u.userId = dl.user_id
          WHERE  dl.user_id = $userId order by dl.deleted_at";

// Execute Query
$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(["error" => "Database query failed: " . mysqli_error($conn)]);
    exit;
}

// Fetch Results
$deletedPost = [];
while ($row = mysqli_fetch_assoc($result)) {
    $deletedPost[] = $row;
}

// Close Connection
mysqli_free_result($result);
mysqli_close($conn);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($deletedPost);
