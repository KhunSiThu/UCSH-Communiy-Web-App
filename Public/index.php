<?php

require_once("../src/Controller/dbConnect.php");
session_start();

$userId = $_SESSION['user_id'];

$sql = "SELECT * FROM user WHERE userId = '$userId'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $userData = mysqli_fetch_assoc($result);

    if ($userData['status'] == 'Online' && $userData['profileImage']) {
        header("Location: ../src/Views/MainPage.php");
        exit;
    } else if ($userData['status'] == 'Online' && !$userData['profileImage']) {
        header("Location: ../src/Views/UploadProfilePage.php");
        exit;
    } else {
        header("Location: ../src/Views/FormPage.php");
        exit;
    }
} else {
    header("Location: ../src/Views/FormPage.php");
    exit;
}
