<?php

// session_start();
include("widgets/header.php");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Insert into database
    $sql = "INSERT INTO admins SET 
            name = '$name',
            email = '$email',
            password = '$password'
         ";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        $_SESSION['noti'] = '<div class="alert alert-success" role="alert">
                    Admin Added Successfully!
                    </div>';
        header('location: ./manage-admin.php');
        exit(); // Ensure no further code is executed after the redirect
    } else {
        $_SESSION['noti'] =  '<div class="alert alert-danger" role="alert">
                          Fail To Add Admin!!!
                          </div>';
        header('location:' . SITEURL . 'admin/add-admin.php');
        exit(); // Ensure no further code is executed after the redirect
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Admin</title>
</head>
<body>
<div class="container">
    <h1 class="mt-4 mb-3 admin-t">Add New Admins</h1>
    <div class="row pt-4 pb-4 text-color gt-3">
        <?php
        if (isset($_SESSION['noti'])) {
            echo $_SESSION['noti'];
            unset($_SESSION['noti']);
        }
        ?>
        
        <!-- Add admin form -->
        <div class="col-md-6">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="fullname" class="form-label">Name</label>
                    <input type="text" class="form-control" id="full-name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="user-email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="..............." required>
                </div>

                <input type="submit" class="btn btn-primary" value="Register">
            </form>
        </div>
    </div>
</div>
</body>
</html>