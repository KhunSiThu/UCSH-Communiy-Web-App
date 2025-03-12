<?php

require_once("../Controller/dbConnect.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.1/dist/flowbite.min.css" rel="stylesheet" />
   <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
   integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

   <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.23/dist/full.min.css" rel="stylesheet" type="text/css" />
   <!-- <link rel="stylesheet" href="../CSS/output.css"> -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
   <link rel="stylesheet" href="./style/admin.css">
   <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

   <nav class="bg-white border-gray-200 dark:bg-gray-900">
      <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl p-4">
         <a href="https://flowbite.com" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">UCSH(Hpa-an)</span>
         </a>
         <div class="flex items-center space-x-6 rtl:space-x-reverse">
            <a href="tel:5541251234" class="text-sm  text-gray-500 dark:text-white hover:underline">(555) 412-1234</a>
            <a href="logout.php" class="text-sm  text-blue-600 dark:text-blue-500 hover:underline">Logout</a>
         </div>
      </div>
   </nav>
   <nav class="bg-gray-50 dark:bg-gray-700">
      <div class="max-w-screen-xl px-4 py-3 mx-auto">
         <div class="flex items-center">
            <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
               <li>
                  <a href="admin-home.php" class="text-gray-900 dark:text-white hover:underline" aria-current="page">Home</a>
               </li>
               <li>
                  <a href="manage-admin.php" class="text-gray-900 dark:text-white hover:underline">Manage Admins</a>
               </li>
               <li>
                  <a href="manage-user.php" class="text-gray-900 dark:text-white hover:underline">Manage Users</a>
               </li>
               <li>
                  <a href="manage-group.php" class="text-gray-900 dark:text-white hover:underline">Manage Groups</a>
               </li>
               <li>
                  <a href="manage-post.php" class="text-gray-900 dark:text-white hover:underline">Manage Posts</a>
               </li>
            </ul>
         </div>
      </div>
   </nav>

   <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
   