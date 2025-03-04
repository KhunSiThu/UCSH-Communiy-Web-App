<?php
header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require_once("./dbConnect.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

$userId = $_SESSION['user_id'];

if (!isset($_FILES['coverImage']) || $_FILES['coverImage']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'No image uploaded or an error occurred.']);
    exit;
}

$file = $_FILES['coverImage'];

// ** File Type & MIME Type Check (Allow All Image Types) ** //
$fileType = mime_content_type($file['tmp_name']);
if (!str_starts_with($fileType, 'image/')) {
    echo json_encode(['success' => false, 'message' => 'Invalid file type. Only images are allowed.']);
    exit;
}

// ** File Size Check (Max: 5MB) ** //
if ($file['size'] > 5 * 1024 * 1024) {
    echo json_encode(['success' => false, 'message' => 'Image size exceeds the limit of 5MB.']);
    exit;
}

// ** Upload Directory Setup ** //
$uploadDir = '../uploads/covers/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// ** Generate Unique Filename with Original Extension ** //
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$uniqueFilename = uniqid('cover_', true) . '.' . $extension;
$filePath = $uploadDir . $uniqueFilename;

// ** Move Uploaded File ** //
if (!move_uploaded_file($file['tmp_name'], $filePath)) {
    echo json_encode(['success' => false, 'message' => 'Failed to save uploaded file.']);
    exit;
}

// ** Sanitize Input ** //
$uniqueFilename = mysqli_real_escape_string($conn, $uniqueFilename);
$userId = mysqli_real_escape_string($conn, $userId);

// ** Save File Name to Database ** //
$sql = "UPDATE user SET coverImage = '$uniqueFilename' WHERE userId = '$userId'";
if (mysqli_query($conn, $sql)) {
    echo json_encode([
        'success' => true, 
        'message' => 'cover image uploaded successfully.', 
        'filePath' => $filePath
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database update failed: ' . mysqli_error($conn)]);
}

mysqli_close($conn);
?>