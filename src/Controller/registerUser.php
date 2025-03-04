<?php
require_once("./dbConnect.php");

session_start();

$response = array();

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $response["success"] = false;
        $response["message"] = "User already exists.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $insertSQL = "insert into user (name,email,password) values ('$name','$email','$hashed_password')";
        if (mysqli_query($conn, $insertSQL)) {
            $response["success"] = true;
            $response["message"] = "User registered successfully.";
        } else {
            $response["success"] = false;
            $response["message"] = "Failed to register user.";
        }
    }
} else {
    $response["success"] = false;
    $response["message"] = "Invalid input data.";
}

mysqli_close($conn);

echo json_encode($response);
?>
