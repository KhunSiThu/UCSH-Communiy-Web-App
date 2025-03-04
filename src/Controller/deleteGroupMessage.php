<?php
header('Content-Type: application/json');
require_once("./dbConnect.php");

session_start();

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if (!$id) {
    echo json_encode(["success" => false, "message" => "Invalid message ID"]);
    exit;
}

$query = "DELETE FROM groupMessage WHERE messageId = $id";
$result = mysqli_query($conn, $query);

if ($result) {
    $response["success"] = true;
} else {
    $response["success"] = false;
}

mysqli_close($conn);
echo json_encode($response);
?>