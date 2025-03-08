<?php
// Ensure session is started before any output
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not authenticated"]);
    exit;
}

require_once("./dbConnect.php");

$user_id = intval($_SESSION['user_id']);  // Ensure the user_id is an integer

// Prepare SQL query to get the total message count
$query = "
    SELECT COUNT(gm.messageId) AS total_messages
    FROM groupMessage gm
    JOIN groupMember gmbr ON gm.groupId = gmbr.groupId
    WHERE gmbr.memberId = ?
";

// Prepare and execute the query
$stmt = mysqli_prepare($conn, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if data is returned
    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode(["status" => "success", "message_count" => $row['total_messages']]);
    } else {
        echo json_encode(["status" => "success", "message_count" => 0]); // No messages, return count 0
    }
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["error" => "Query preparation failed"]);
}

// Close the database connection
mysqli_close($conn);
?>
