<?php
header('Content-Type: application/json');

require_once("./dbConnect.php");
session_start();

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Sanitize input data (to prevent SQL injection)
$username = $conn->real_escape_string($data['username']);
$role = $conn->real_escape_string($data['role']);
$year = $conn->real_escape_string($data['year']);
$address = $conn->real_escape_string($data['address']);
$phone = intval($data['phone']); // Ensure phone number is stored as an integer
$rollno = $conn->real_escape_string($data['rollno']);
$userId = $_SESSION['user_id']; // Assuming the user ID is stored in the session

// Prepare the SQL query
$sql = "UPDATE user SET 
        name = '$username', 
        role = '$role', 
        year = '$year', 
        address = '$address', 
        phoneNo = $phone, 
        rollNo = '$rollno' 
        WHERE userId = $userId";

// Execute the query
if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
}

$conn->close();
?>
