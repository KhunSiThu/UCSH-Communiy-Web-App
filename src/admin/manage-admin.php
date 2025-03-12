<?php include("widgets/header.php"); ?>

<div class="container">
<?php
        if (isset($_SESSION['noti'])) {
            echo $_SESSION['noti'];
            unset($_SESSION['noti']);
        }
        ?>
    <div class="row pt-4 pb-4 gt-3">

       

        <h2 class="mt-4 mb-3 admin-t">Manage Admin</h2>

        <!-- Admin table -->
        <div class="col-12">
            <a href="add-admin.php" class="btn btn-primary w-15 mb-3">Add Admin</a>

            <table class="table table-striped bg-white">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <!-- Rescrieve Data From Database -->
                <?php

                $sql = "SELECT * FROM admins";
                $res = mysqli_query($conn, $sql);

                if ($res) {
                    //count the numbers of rows from tables

                    $count = mysqli_num_rows($res);

                    if ($count == 0) {
                        echo "No Data";
                    } else {
                        $sn = 1;
                        while ($row = mysqli_fetch_array($res)) {
                            $id = $row['id'];
                            $name = $row['name'];
                            $email = $row['email'];
                ?>

                            <tr>
                                <th scope="row"><?= $id ?></th>
                                <td scope="row"><?= $name ?></td>
                                <td scope="row"><?= $email ?></td>
                                <td>
                                    <a href="./update-password.php?id=<?= $id ?>" class="bg-white p-2 rounded mx-1" title="update password">
                                        <i class="fa-solid fa-lock"></i>
                                    </a>

                                    <a href="./update-admin.php?id=<?= $id ?>" class="bg-white p-2 rounded mx-1" title="update admin">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <a href="./delete-admin.php?id=<?= $id ?>" class="bg-white p-2 rounded mx-1" title="delete admin">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>

                <?php
                            $sn++;
                        }
                    }
                }

                ?>
        </div>


    </div>
</div>