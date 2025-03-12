<?php

require_once("../Controller/dbConnect.php");
session_start();


// number of users
$userQuery = "SELECT COUNT(*) as userCount FROM `user`";
$userResult = mysqli_query($conn, $userQuery);
$userRow = mysqli_fetch_assoc($userResult);
$userCount = $userRow['userCount'];

// number of posts
$postQuery = "SELECT COUNT(*) as postCount FROM `posts`";
$postResult = mysqli_query($conn, $postQuery);
$postRow = mysqli_fetch_assoc($postResult);
$postCount = $postRow['postCount'];

// number of groups
$groupQuery = "SELECT COUNT(*) as groupCount FROM `group`"; 
$groupResult = mysqli_query($conn, $groupQuery);
$groupRow = mysqli_fetch_assoc($groupResult);
$groupCount = $groupRow['groupCount'];
?>

<?php include("widgets/header.php"); ?>
<div>
    <?php
    if (isset($_SESSION['noti'])) {
        echo $_SESSION['noti'];
        unset($_SESSION['noti']);
    }
    ?>

    <div class="homeCotainer" style="display: flex;justify-content:space-evenly;margin-top:5%;">
        <a href="manage-user.php" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <p class="font-normal text-gray-700 dark:text-gray-400">USERS</p>
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><i class="fa-solid fa-user" style="text-align: center;"></i></h5>
            <small class="indicate"><?php echo $userCount; ?></small>
        </a>

        <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 title-a">
            <p class="font-normal text-gray-700 dark:text-gray-400 ">POSTS</p>
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white "><i class="fa-solid fa-upload  "></i></h5>
            <small class="indicate"><?php echo $postCount; ?></small>
        </a>

        <a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <p class="font-normal text-gray-700 dark:text-gray-400">GROUPS</p>
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><i class="fa-solid fa-people-group"></i></h5>
            <small class="indicate"><?php echo $groupCount; ?></small>
        </a>
    </div>
</div>