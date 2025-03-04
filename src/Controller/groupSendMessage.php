<?php
header('Content-Type: application/json');
require_once("./dbConnect.php");
session_start();

$allowedExtensions = [
    // Document extensions
    'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'pdf',

    // Image extensions
    'jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'webp', 'svg',

    // Video extensions
    'mp4', 'mov', 'avi', 'mkv', 'flv', 'wmv', 'webm', 'ogv', '3gp', 'mpeg'
];

if (!isset($_SESSION['user_id']) || !isset($_SESSION['chooseId'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized access"]);
    exit();
}

$userId = $_SESSION['user_id'];
$groupId = $_SESSION['groupId'];
$sendMessage = $_POST['message'] ?? '';

try {
    mysqli_begin_transaction($conn);

    // Escape inputs for security
    $groupId = mysqli_real_escape_string($conn, $groupId);
    $userId = mysqli_real_escape_string($conn, $userId);
    $sendMessage = mysqli_real_escape_string($conn, $sendMessage);

    // Insert message into the database
    $query = "INSERT INTO groupMessage (groupId, sendId, message, createdAt) 
              VALUES ('$groupId', '$userId', '$sendMessage', NOW())";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        throw new Exception("Failed to send message: " . mysqli_error($conn));
    }

    $messageId = mysqli_insert_id($conn);

    // File upload handling
    $uploads = [
        'image_files' => '../uploads/images/',
        'document_files' => '../uploads/documents/',
        'video_files' => '../uploads/videos/'
    ];

    $filesData = ['image_files' => [], 'document_files' => [], 'video_files' => []];

    foreach ($uploads as $inputName => $uploadPath) {
        if (!empty($_FILES[$inputName]['name'][0])) {
            foreach ($_FILES[$inputName]['tmp_name'] as $index => $tmpName) {
                $fileName = $_FILES[$inputName]['name'][$index];
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                if (!in_array($fileExt, $allowedExtensions)) {
                    continue;
                }

                $newFileName = "{$inputName}_{$messageId}_{$index}.{$fileExt}";
                $destination = $uploadPath . $newFileName;

                if (move_uploaded_file($tmpName, $destination)) {
                    $filesData[$inputName][] = $newFileName;
                }
            }
        }
    }

    // Update message with file paths
    $images = implode(",", $filesData['image_files']);
    $documents = implode(",", $filesData['document_files']);
    $videos = implode(",", $filesData['video_files']);

    // Escape file paths for security
    $images = mysqli_real_escape_string($conn, $images);
    $documents = mysqli_real_escape_string($conn, $documents);
    $videos = mysqli_real_escape_string($conn, $videos);

    $query = "UPDATE groupMessage 
              SET images = '$images', file = '$documents', videos = '$videos' 
              WHERE messageId = '$messageId'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        throw new Exception("Failed to update message: " . mysqli_error($conn));
    }

    mysqli_commit($conn);
    echo json_encode(["success" => true]);
} catch (Exception $e) {
    mysqli_rollback($conn);
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
} finally {
    mysqli_close($conn);
}
?>