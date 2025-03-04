<?php
require_once("./dbConnect.php");
session_start();

$response = array();

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT userId, email, password FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $userData = mysqli_fetch_assoc($result);

        if (password_verify($password, $userData['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $userData['userId'];
            $_SESSION['user_email'] = $userData['email'];

            // Update user status to active
            $updateSql = "UPDATE user SET status = 'Online' WHERE email = '$email'";
            mysqli_query($conn, $updateSql);

            $response["success"] = true;
            $response["message"] = "Login successful.";
        } else {
            $response["success"] = false;
            $response["message"] = "Incorrect password.";
        }
    } else {
        $response["success"] = false;
        $response["message"] = "User not found!";
    }
} else {
    $response["success"] = false;
    $response["message"] = "Invalid input data.";
}

mysqli_close($conn);
echo json_encode($response);
?>
