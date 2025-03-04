<?php
header('Content-Type: application/json');
require_once("./dbConnect.php");
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in and has a chosen group
if (!isset($_SESSION['user_id']) || !isset($_SESSION['chooseId'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized access"]);
    exit();
}

$groupId = $_SESSION['groupId'];

try {
    // Escape the group ID for security
    $groupId = mysqli_real_escape_string($conn, $groupId);

    // Prepare SQL query to fetch messages for the group
    $query = "SELECT groupMessage.*, user.name, user.profileImage 
              FROM groupMessage 
              LEFT JOIN user ON user.userId = groupMessage.sendId 
              WHERE groupMessage.groupId = '$groupId' 
              ORDER BY groupMessage.messageId ASC";

    // Execute the query
    $result = mysqli_query($conn, $query);
    if (!$result) {
        throw new Exception("Failed to execute the SQL statement: " . mysqli_error($conn));
    }

    // Fetch all messages
    $messages = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Split images into an array if they exist
        $row['images'] = !empty($row['images']) ? explode(",", $row['images']) : [];

        // Split file attachments into an array if they exist
        $row['files'] = !empty($row['file']) ? explode(",", $row['file']) : [];

        // Split videos into an array if they exist
        $row['videos'] = !empty($row['videos']) ? explode(",", $row['videos']) : [];

        $messages[] = $row;
    }

    // Return the messages as JSON
    echo json_encode(["success" => true, "messages" => $messages]);
} catch (Exception $e) {
    // Log the error for debugging
    error_log("Error in getGroupMessage.php: " . $e->getMessage());

    // Return a detailed error message
    http_response_code(500);
    echo json_encode(["error" => "Internal server error: " . $e->getMessage()]);
} finally {
    // Close the connection
    mysqli_close($conn);
}
?>