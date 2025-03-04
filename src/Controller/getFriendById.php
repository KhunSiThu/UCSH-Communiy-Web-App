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

// Get the input data
$data = json_decode(file_get_contents('php://input'), true);
$chooseId = $data['chooseId'] ?? null;

if (empty($chooseId) || !is_numeric($chooseId)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input: 'chooseId' is required and must be a number"]);
    exit();
}

$userId = $_SESSION['user_id'];
$_SESSION['friendId'] = $data['chooseId'];

// Prepare the SQL query to fetch the selected friend's details
$query = "select * from user where userId = $chooseId";

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
    $results[] = [
        'userId' => $row['userId'],
        'name' => $row['name'],
        'profileImage' => $row['profileImage'],
        'status' => $row['status']
    ];
}

// Free resources
mysqli_free_result($result);
mysqli_close($conn);

// Return the results
echo json_encode($results);
?>
