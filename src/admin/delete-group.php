<?php

require_once("../Controller/dbConnect.php");
session_start();


if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: Group ID missing.");
}

$id = intval($_GET['id']);

$sql = "DELETE FROM `group` WHERE groupid = $id";
$res = mysqli_query($conn, $sql);

if ($res) {
    echo "Group deleted successfully. Redirecting...";
    $_SESSION['noti'] = ' <div class="alert alert-success" role="alert">
                            Group deleted Successfully...
                          </div>';
} else {
    echo "Error deleting group: " . mysqli_error($conn);
    $_SESSION['noti'] = '<div class="alert alert-danger" role="alert">
                            Failed to delete group!
                          </div>';
}

header('location:' . SITEURL . 'admin/manage-group.php');
exit();
