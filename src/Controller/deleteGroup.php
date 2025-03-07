<?php

require_once("./dbConnect.php");
session_start();

$groupId = $_SESSION['groupId'];

// Start a transaction to ensure both the group and group members are deleted
mysqli_begin_transaction($conn);

try {
    // First, delete the members of the group
    $sqlDeleteMembers = "DELETE FROM groupMember WHERE groupId = $groupId";
    $resultDeleteMembers = mysqli_query($conn, $sqlDeleteMembers);

    if (!$resultDeleteMembers || mysqli_affected_rows($conn) === 0) {
        throw new Exception("Failed to delete group members");
    }

    // Now, delete the group
    $sqlDeleteGroup = "DELETE FROM `group` WHERE groupId = $groupId";
    $resultDeleteGroup = mysqli_query($conn, $sqlDeleteGroup);

    if (!$resultDeleteGroup || mysqli_affected_rows($conn) === 0) {
        throw new Exception("Failed to delete group");
    }

    // Commit the transaction if both delete operations were successful
    mysqli_commit($conn);

    echo json_encode(["success" => true, "message" => "Group and its members deleted successfully"]);
} catch (Exception $e) {
    // Rollback the transaction if anything goes wrong
    mysqli_rollback($conn);

    http_response_code(500);
    echo json_encode(["error" => "Failed to delete group and members: " . $e->getMessage()]);
} finally {
    mysqli_close($conn);
}
?>
