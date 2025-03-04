<?php

require_once("./dbConnect.php");

session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
    exit();
}

$groupId = $_POST['groupId'] ?? '';
$groupName = $_POST['groupName'] ?? '';

if (empty($groupId) || empty($groupName)) {
    http_response_code(400);
    echo json_encode(["error" => "Group ID and name are required"]);
    exit();
}

$newFileName = null;
$uploadDir = "../uploads/profiles/";

if (isset($_FILES['groupProfileImage']) && $_FILES['groupProfileImage']['error'] === UPLOAD_ERR_OK) {
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $file = $_FILES['groupProfileImage'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg', 'tiff', 'ico', 'avif'];

    if (!in_array($fileExtension, $allowedExtensions)) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid file type"]);
        exit();
    }

    $newFileName = uniqid('group_', true) . "." . $fileExtension;
    $uploadPath = $uploadDir . $newFileName;

    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        http_response_code(500);
        echo json_encode(["error" => "Failed to upload file"]);
        exit();
    }
}

// Escape inputs for security
$groupId = mysqli_real_escape_string($conn, $groupId);
$groupName = mysqli_real_escape_string($conn, $groupName);
$newFileName = $newFileName ? mysqli_real_escape_string($conn, $newFileName) : null;

if ($newFileName) {
    $sql = "UPDATE `group` 
            SET groupName = '$groupName', groupProfile = '$newFileName' 
            WHERE groupId = '$groupId'";
} else {
    $sql = "UPDATE `group` 
            SET groupName = '$groupName' 
            WHERE groupId = '$groupId'";
}

$result = mysqli_query($conn, $sql);

if ($result) {
    echo json_encode(["success" => true, "message" => "Group updated successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . mysqli_error($conn)]);
}

mysqli_close($conn);
?>