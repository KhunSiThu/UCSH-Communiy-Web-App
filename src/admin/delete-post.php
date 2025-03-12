<?php
require_once("../Controller/dbConnect.php"); // Include your database connection file
session_start();

header('Content-Type: application/json');

// Validate and sanitize the input
$postId = isset($_POST['postId']) ? intval($_POST['postId']) : null;
$userId = isset($_POST['userId']) ? intval($_POST['userId']) : null; // Post owner's user_id
$deleteReason = isset($_POST['deleteReason']) ? trim($_POST['deleteReason']) : null;

if (!$postId || !$userId || !$deleteReason) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'Invalid or missing data']);
    exit();
}

// Begin a transaction to ensure atomicity
mysqli_begin_transaction($conn);

try {
    // Step 1: Log the deletion reason along with the post's user_id and the user who deleted it
    $logSql = "INSERT INTO deletion_logs (post_id, user_id, reason) VALUES ($postId, $userId, '$deleteReason')";
    if (!mysqli_query($conn, $logSql)) {
        throw new Exception("Failed to log deletion: " . mysqli_error($conn));
    }

    // Step 2: Delete the post from the database
    $deleteSql = "DELETE FROM posts WHERE post_id = $postId";
    if (!mysqli_query($conn, $deleteSql)) {
        throw new Exception("Failed to delete post: " . mysqli_error($conn));
    }

    // Commit the transaction if everything is successful
    mysqli_commit($conn);

    // Return success response
    echo json_encode(['success' => true, 'message' => 'Post deleted successfully']);
} catch (Exception $e) {
    // Rollback the transaction in case of any error
    mysqli_rollback($conn);

    http_response_code(500); // Internal Server Error
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    // Close the database connection
    mysqli_close($conn);
}
?>
