<?php
include('config/constants.php');

if(isset($_GET['cart_id']))
{
    $cart_id = (int)$_GET['cart_id'];

    $sql = "DELETE FROM cart WHERE cart_id = $cart_id";
    mysqli_query($conn, $sql);
}

header("location: cart.php");
exit();
?>