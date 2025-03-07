<?php
// Enable error reporting (for debugging only, remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("./dbConnect.php"); // Ensure correct path

session_start();

header('Content-Type: application/json'); // Ensure JSON response

$response = ["status" => "error", "message" => "Something went wrong"];

if (isset($_SESSION['user_id'])) {
    $user_id = (int) $_SESSION['user_id']; // Ensure integer

    $sql = "SELECT COUNT(*) as message_count FROM messages WHERE receive_id = ? OR send_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            $response = [
                "status" => "success",
                "message_count" => (int) $row['message_count']
            ];
        } else {
            $response["message"] = "Database query failed";
        }

        mysqli_stmt_close($stmt);
    } else {
        $response["message"] = "Query preparation failed";
    }
} else {
    $response["message"] = "User not logged in";
}

// Close database connection
mysqli_close($conn);
echo json_encode($response);
