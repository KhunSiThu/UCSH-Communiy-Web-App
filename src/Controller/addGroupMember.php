<?php

require_once("./dbConnect.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

// Only allow POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
    exit();
}

$groupId = $_SESSION['groupId'];

// Fetch groupId from the database
$groupQuery = "SELECT groupId FROM `group` WHERE groupId = $groupId";
$result = mysqli_query($conn, $groupQuery);

if (!$result || mysqli_num_rows($result) === 0) {
    http_response_code(404);
    echo json_encode(["error" => "Group not found"]);
    exit();
}

$groupRow = mysqli_fetch_assoc($result);
$groupId = $groupRow['groupId'];

mysqli_free_result($result);

// Receive JSON Data
$data = json_decode(file_get_contents("php://input"), true);
$memberId = $data['addId'] ?? null;

if (!$memberId || !$groupId) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid Data"]);
    exit();
}

// Check if member is already in the group
$checkSql = "SELECT * FROM groupMember WHERE groupId = $groupId AND memberId = $memberId";
$checkResult = mysqli_query($conn, $checkSql);

if ($checkResult && mysqli_num_rows($checkResult) > 0) {
    echo json_encode(["error" => "Member is already in the group"]);
    exit();
}

mysqli_free_result($checkResult);

// Insert into groupMember table
$insertSql = "INSERT INTO groupMember (groupId, memberId) VALUES ($groupId, $memberId)";
if (mysqli_query($conn, $insertSql)) {
    echo json_encode(["success" => true, "message" => "Member added successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . mysqli_error($conn)]);
}

mysqli_close($conn);
?>
