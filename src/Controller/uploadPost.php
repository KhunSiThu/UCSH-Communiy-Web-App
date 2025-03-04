<?php
header('Content-Type: application/json');
require_once("./dbConnect.php");
session_start();

$allowedExtensions = [
    'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'pdf',  // Documents
    'jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'webp', 'svg',  // Images
    'mp4', 'mov', 'avi', 'mkv', 'flv', 'wmv', 'webm', 'ogv', '3gp', 'mpeg'  // Videos
];

$userId = $_SESSION['user_id'] ?? null;
$caption = $_POST['caption'] ?? '';
$type = $_POST['type'] ?? '';

if (!$userId) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized access."]);
    exit;
}

try {
    mysqli_begin_transaction($conn);

    // Insert post into the database using prepared statements
    $sql = "INSERT INTO posts (user_id, caption, createdAt) VALUES (?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "is", $userId, $caption);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Failed to insert post: " . mysqli_error($conn));
    }

    $postId = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);

    // File upload handling
    $uploads = [
        'image_files' => '../posts/images/',
        'document_files' => '../posts/documents/',
        'video_files' => '../posts/videos/'
    ];

    $filesData = ['image_files' => [], 'document_files' => [], 'video_files' => []];

    foreach ($uploads as $inputName => $uploadPath) {
        if (!empty($_FILES[$inputName]['name'][0])) {
            foreach ($_FILES[$inputName]['tmp_name'] as $index => $tmpName) {
                $fileName = $_FILES[$inputName]['name'][$index];
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                // Validate file type
                if (!in_array($fileExt, $allowedExtensions)) {
                    http_response_code(400);
                    echo json_encode(["error" => "File type '$fileExt' is not allowed"]);
                    exit();
                }

                // Secure file name
                $newFileName = "{$inputName}_{$postId}_{$index}." . $fileExt;
                $destination = $uploadPath . $newFileName;

                // Move uploaded file securely
                if (!move_uploaded_file($tmpName, $destination)) {
                    throw new Exception("Failed to upload file: $fileName");
                }

                $filesData[$inputName][] = $newFileName;
            }
        }
    }

    // Convert arrays to comma-separated strings
    $images = implode(",", $filesData['image_files']);
    $documents = implode(",", $filesData['document_files']);
    $videos = implode(",", $filesData['video_files']);

    // Update post with file paths using prepared statements
    $sqlUpdate = "UPDATE posts SET images = ?, files = ?, videos = ?, type = ? WHERE post_id = ?";
    $stmtUpdate = mysqli_prepare($conn, $sqlUpdate);
    mysqli_stmt_bind_param($stmtUpdate, "ssssi", $images, $documents, $videos, $type, $postId);

    if (!mysqli_stmt_execute($stmtUpdate)) {
        throw new Exception("Failed to update post: " . mysqli_error($conn));
    }

    mysqli_stmt_close($stmtUpdate);
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
