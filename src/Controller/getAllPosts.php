<?php

require_once("./dbConnect.php");

session_start();

header('Content-Type: application/json');

$sql = "SELECT posts.*,user.*
        FROM posts 
        JOIN user ON posts.user_id = user.userId 
        ORDER BY posts.createdAt DESC";

$res = mysqli_query($conn, $sql);

$posts = [];

if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $row['images'] = !empty($row['images']) ? explode(",", $row['images']) : [];
        $row['files'] = !empty($row['files']) ? explode(",", $row['files']) : [];
        $row['videos'] = !empty($row['videos']) ? explode(",", $row['videos']) : [];
        $posts[] = $row;
    }
}

echo json_encode($posts);
?>