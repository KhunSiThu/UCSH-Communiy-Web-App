<?php
header('Content-Type: application/json');

require_once("./dbConnect.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$userId = $_SESSION['user_id'];

$data = json_decode(file_get_contents('php://input'), true);
$searchText = $data['searchText'] ?? '';

if (empty($searchText)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input: 'searchText' is required"]);
    exit();
}

$searchText = mysqli_real_escape_string($conn, $searchText);

// Construct the query
$query = "SELECT * FROM user WHERE userId != '$userId' AND name LIKE '%$searchText%'";

$result = mysqli_query($conn, $query);

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to execute SQL query: " . mysqli_error($conn)]);
    exit();
}

$results = [];
while ($row = mysqli_fetch_assoc($result)) {
    $results[] = $row;
}

mysqli_free_result($result);
mysqli_close($conn);

echo json_encode($results);
?>