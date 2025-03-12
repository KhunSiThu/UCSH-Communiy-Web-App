<?php

require_once("../Controller/dbConnect.php");
session_start();


$id = $_GET['id'];

$sql = "DELETE FROM admins WHERE id =$id";

$res = mysqli_query($conn, $sql);

if ($res) {
    $_SESSION['noti'] = '<div class="alert alert-success" role="alert">
                            Admin deleted Successfully!
                            </div>';

    header('location: ./manage-admin.php');
} else {
    $_SESSION['noti'] =  '<div class="alert alert-danger" role="alert">
                              Fail To deleted Admin!!!
                              </div>';
    header('location: ./manage-admin.php');
}
