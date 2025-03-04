<?php
header('Content-Type: application/json');
require_once("./dbConnect.php");
session_start();

// Check if the user is logged in and has a chosen recipient
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized access"]);
    exit();
}

$sendId = $_SESSION['user_id'];
$receiveId = $_SESSION['friendId'];

try {
    // Escape inputs for security
    $sendId = mysqli_real_escape_string($conn, $sendId);
    $receiveId = mysqli_real_escape_string($conn, $receiveId);

    // Prepare SQL query to fetch messages between two users
    $query = "SELECT messages.*, user.*, messages.createdAt 
              FROM messages 
              LEFT JOIN user ON user.userId = messages.send_id 
              WHERE (receive_id = '$receiveId' AND send_id = '$sendId') 
                 OR (receive_id = '$sendId' AND send_id = '$receiveId') 
              ORDER BY messages.message_id ASC";

    // Execute the query
    $result = mysqli_query($conn, $query);
    if (!$result) {
        throw new Exception("Failed to execute the SQL statement: " . mysqli_error($conn));
    }

    // Fetch all messages
    $messages = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Ensure 'images', 'files', and 'videos' are split into arrays if they exist
        $row['images'] = !empty($row['images']) ? explode(",", $row['images']) : [];
        $row['files'] = !empty($row['file']) ? explode(",", $row['file']) : [];
        $row['videos'] = !empty($row['videos']) ? explode(",", $row['videos']) : [];

        $messages[] = $row;
    }

    // Return the messages as JSON
    echo json_encode(["success" => true, "messages" => $messages]);
} catch (Exception $e) {
    // Handle errors
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
} finally {
    // Close the connection
    mysqli_close($conn);
}
?>