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

// Get the input data
$data = json_decode(file_get_contents('php://input'), true);
$chooseId = $data['chooseId'] ?? null;

$_SESSION['chooseId'] = $chooseId;
$_SESSION['groupId'] = $chooseId;

if (!$chooseId || !is_numeric($chooseId)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid or missing group ID"]);
    exit();
}

// Query to fetch group information
$groupQuery = "SELECT * FROM `group` WHERE groupId = $chooseId";
$groupResult = mysqli_query($conn, $groupQuery);

if (!$groupResult) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to fetch group data: " . mysqli_error($conn)]);
    exit();
}

if (mysqli_num_rows($groupResult) === 0) {
    http_response_code(404);
    echo json_encode(["error" => "Group not found"]);
    exit();
}

$groupData = mysqli_fetch_assoc($groupResult);

// Query to fetch all members of the group
$memberQuery = "
    SELECT u.userId, u.name, u.profileImage, u.status
    FROM groupMember gm
    JOIN user u ON gm.memberId = u.userId
    WHERE gm.groupId = $chooseId
";
$memberResult = mysqli_query($conn, $memberQuery);

if (!$memberResult) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to fetch group members: " . mysqli_error($conn)]);
    exit();
}

$members = [];
while ($row = mysqli_fetch_assoc($memberResult)) {
    $members[] = $row;
}

mysqli_close($conn);

// Return group and member data
echo json_encode([
    "success" => true,
    "group" => $groupData,
    "members" => $members
]);
?>
