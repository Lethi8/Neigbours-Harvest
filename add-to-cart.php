<?php
include('config/constants.php');

if(!isset($_SESSION['user_Id'])){
    header("location: admin/user-login.php");
    exit();
}

$user_Id = $_SESSION['user_Id'];
$listings_id = $_GET['listings_id'];

// check if item already in cart
$checkSql = "SELECT * FROM cart 
             WHERE user_Id = $user_Id 
             AND listings_id = $listings_id";

$checkRes = mysqli_query($conn, $checkSql);

if(mysqli_num_rows($checkRes) > 0){
    // update quantity
    $updateSql = "UPDATE cart 
                  SET quantity = quantity + 1 
                  WHERE user_Id = $user_Id 
                  AND listings_id = $listings_id";
    mysqli_query($conn, $updateSql);

} else {
    // insert new item
    $insertSql = "INSERT INTO cart (user_Id, listings_id, quantity)
                  VALUES ($user_Id, $listings_id, 1)";
    mysqli_query($conn, $insertSql);
}

header("location: cart.php");
exit();
?>