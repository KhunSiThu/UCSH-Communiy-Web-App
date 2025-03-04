<?php 

$conn = mysqli_connect("localhost","khun","khun","chattingDB");

if(!$conn) {
    echo mysqli_connect_error();
    die();
}



// $conn = mysqli_connect("sql213.infinityfree.com","if0_38229273","60fFYp1aozYP25a","if0_38229273_chattingDB");

// if(!$conn) {
//     echo mysqli_connect_error();
//     die();
// }