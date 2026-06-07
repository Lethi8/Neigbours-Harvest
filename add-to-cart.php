<?php
session_start();
include('config/constants.php');

if (!isset($_SESSION['user_Id'])) {
    header("location: admin/user-login.php");
    exit();
}

$user_Id = (int)$_SESSION['user_Id'];

if (!isset($_GET['listings_id'])) {
    header("location: produce.php");
    exit();
}

$listings_id = (int)$_GET['listings_id'];

$sql = "SELECT quant FROM listings WHERE listings_id = $listings_id";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($res);

$currentStock = (int)$row['quant'];

if ($currentStock <= 0) {
    header("location: produce.php?error=outofstock");
    exit();
}

$newStock = $currentStock - 1;

mysqli_query($conn, "UPDATE listings SET quant = $newStock WHERE listings_id = $listings_id");

$checkSql = "SELECT cart_id, quantity 
             FROM cart 
             WHERE user_Id = $user_Id 
             AND listings_id = $listings_id
             LIMIT 1";

$checkRes = mysqli_query($conn, $checkSql);

if ($checkRes && mysqli_num_rows($checkRes) > 0) {

    $row = mysqli_fetch_assoc($checkRes);
    $newQty = (int)$row['quantity'] + 1;

    mysqli_query($conn, "UPDATE cart 
                          SET quantity = $newQty 
                          WHERE cart_id = {$row['cart_id']}");

} else {

    mysqli_query($conn, "INSERT INTO cart (user_Id, listings_id, quantity)
                         VALUES ($user_Id, $listings_id, 1)");
}

header("Location: cart.php");
exit();
?>
