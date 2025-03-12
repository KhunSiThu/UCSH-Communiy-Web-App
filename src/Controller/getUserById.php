<?php
header('Content-Type: application/json');

require_once("./dbConnect.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "User not logged in"]);
    exit();
}


$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? '';

// Prepare the SQL query to fetch the selected friend's details
$query = "select * from user where userId = $id";

// Execute the query
$result = mysqli_query($conn, $query);

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to execute SQL query: " . mysqli_error($conn)]);
    exit();
}

// Fetch results
$results = [];
while ($row = mysqli_fetch_assoc($result)) {
    $results[] = $row;
}

// Free resources
mysqli_free_result($result);
mysqli_close($conn);

// Return the results
echo json_encode($results);
?>
