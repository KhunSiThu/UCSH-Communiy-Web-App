<?php include("widgets/header.php"); ?>

<?php
$id = $_GET['id'];
$sql = "SELECT * FROM admins WHERE id=$id";

$res = mysqli_query($conn, $sql);

if ($res) {
    $count = mysqli_num_rows($res);

    if ($count == 1) {
        $row = mysqli_fetch_assoc($res);
        $name = $row['name'];
        $email = $row['email'];
    } else {
        $_SESSION['noti'] =  '<div class="alert alert-danger" role="alert">
            Fail To Updated Admin!!!
           </div>';
           header('Location: ./manage-admin.php');
    }
}
?>

<div class="container">
    <div class="row pt-4 pb-4 text-color gt-3">
        <?php
        if (isset($_SESSION['noti'])) {
            echo $_SESSION['noti'];
            unset($_SESSION['noti']);
        }
        ?>

        <h2 class="mt-4 mb-3 admin-t">Update Admin</h2>
        <!-- Add admin form -->
        <div class="col-mb-6">
            <div class="border p-3 round-3">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Name</label>
                        <input type="text" class="form-control" id="full-name" name="name" value="<?= $name ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="emal" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>" required>
                    </div>

                    <input type="hidden" value="<?= $id ?>" name="id">
                    <input type="submit" class="btn btn-primary" value="Update">
                </form>
            </div>
        </div>
    </div>
</div>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "UPDATE admins SET
                name = '$name',
                email = '$email'
                WHERE id = '$id'
        ";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        $_SESSION['noti'] = "<div class='alert alert-success' role='alert'>
            Admin Updated Successfully!
            </div>
            <script>
                window.location.href = './manage-admin.php'
            </script>
            ";

           
    } else {
        $_SESSION['noti'] =  "<div class='alert alert-danger' role='alert'>
              Fail To Updated Admin!!!
              </div>
              <script>
                window.location.href = './manage-admin.php'
                </script>
              ";
             
    }
}
?>

