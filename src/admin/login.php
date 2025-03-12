<?php
require_once("../Controller/dbConnect.php");
session_start();


// Redirect if already logged in
if (isset($_SESSION['user'])) {
    header('location: ./admin-home.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($email) || empty($password)) {
        $_SESSION['noti'] = '<div class="alert alert-danger" role="alert">Please fill in all fields.</div>';
    } else {
        // Fetch admin from database
        $sql = "SELECT * FROM admins WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $admin = $result->fetch_assoc();

            // Compare plain-text password (INSECURE - only for demonstration)
            if ($password === $admin['password']) {
                $_SESSION['user'] = $email;
                $_SESSION['noti'] = '<div class="alert alert-success" role="alert">Login successful!</div>';
                header('location: ./admin-home.php');
                exit();
            } else {
                $_SESSION['noti'] = '<div class="alert alert-danger" role="alert">Invalid email or password.</div>';
            }
        } else {
            $_SESSION['noti'] = '<div class="alert alert-danger" role="alert">Invalid email or password.</div>';
        }
    }

    header('location: ./login.php');
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 pt-3 pb-3 mx-auto">
                <!-- Notification Messages -->
                <div class="h-25">
                    <?php
                    if (isset($_SESSION['noti'])) {
                        echo $_SESSION['noti'];
                        unset($_SESSION['noti']);
                    }
                    ?>
                </div><br><br>

                <!-- Login Form -->
                <form action="" method="POST">
                    <div class="border p-3 rounded-3">
                        <h2 style="text-align:center;font-style:italic">Admin Login</h2>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>