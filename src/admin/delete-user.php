<?php

require_once("../Controller/dbConnect.php");
session_start();


$id = $_GET['id'];

// Delete likes 
mysqli_query($conn, "DELETE FROM postsLike WHERE user_id = $id");

// Delete comments 
mysqli_query($conn, "DELETE FROM postsComment WHERE user_id = $id");

// Delete posts 
mysqli_query($conn, "DELETE FROM posts WHERE user_id = $id");


$sql = "DELETE FROM user WHERE userid = $id";
$res = mysqli_query($conn, $sql);

if ($res) {
    $_SESSION['noti'] = '<div class="alert alert-success" role="alert">
                            User deleted successfully along with posts, likes, and comments!
                          </div>';
} else {
    $_SESSION['noti'] = '<div class="alert alert-danger" role="alert">
                            Failed to delete user and related data!
                          </div>';
}

header('location:./manage-user.php');
