<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "chattingdb");
define('SITEURL','http://localhost/Chatting Project/src/');

    session_destroy();
    header('location:' .SITEURL.'admin/login.php');
?> 