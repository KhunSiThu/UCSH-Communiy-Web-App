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

$userId = $_SESSION['user_id'];
$groupId = $_SESSION['groupId'] ?? null;

// Ensure groupId is valid
if (is_null($groupId) || !is_numeric($groupId)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid or missing group ID"]);
    exit();
}

// Prepare the SQL query to fetch friends
$query = "SELECT * FROM user ORDER BY user.name";

$result = mysqli_query($conn, $query);

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to execute SQL query: " . mysqli_error($conn)]);
    exit();
}

// Query to get the group members to filter out users who are already in the group
$groupQuery = "SELECT memberId FROM groupMember WHERE groupId = $groupId";
$groupResult = mysqli_query($conn, $groupQuery);

if (!$groupResult) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to fetch group members: " . mysqli_error($conn)]);
    exit();
}

$groupMembers = [];
while ($row = mysqli_fetch_assoc($groupResult)) {
    $groupMembers[] = $row['memberId'];
}

mysqli_free_result($groupResult);

$results = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Skip if the user is already a member of the group
    if (in_array($row['userId'], $groupMembers)) {
        continue;
    }

    // Prepare the result
    $results[] = [
        'userId' => $row['userId'],
        'name' => $row['name'],
        'profileImage' => $row['profileImage'],
        'status' => $row['status'],
    ];
}

// Free resources
mysqli_free_result($result);
mysqli_close($conn);

// Return the results
echo json_encode($results);
?>
