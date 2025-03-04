<?php
require_once("./dbConnect.php");

session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

// Ensure groupId is available and valid
$groupId = $_SESSION['groupId'] ?? null;

if (is_null($groupId) || !is_numeric($groupId)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid or missing group ID"]);
    exit();
}

// Query to get all user data and the group membership
$sql = "SELECT * FROM groupMember WHERE groupId = $groupId";

$result = mysqli_query($conn, $sql);

if (!$result) {
    // Database query failed
    http_response_code(500);
    echo json_encode(["error" => "Database query execution failed"]);
    exit();
}

$members = [];

while ($row = mysqli_fetch_assoc($result)) {
    $members[] = $row;
}

// Close the result set
mysqli_free_result($result);

// Close the database connection
mysqli_close($conn);

// Return the members as JSON response
echo json_encode(["success" => true, "members" => $members]);
?>
