<?php
include('config/constants.php');

if (isset($_GET['cart_id'])) {

    $cart_id = (int) $_GET['cart_id'];

    $sql_get = "SELECT listings_id, quantity FROM cart WHERE cart_id = $cart_id";
    $res_get = mysqli_query($conn, $sql_get);

    if ($res_get && mysqli_num_rows($res_get) == 1) {

        $row = mysqli_fetch_assoc($res_get);

        $listings_id = (int) $row['listings_id'];
        $quantity = (int) $row['quantity'];

        $sql_update = "UPDATE listings 
                       SET quant = quant + $quantity 
                       WHERE listings_id = $listings_id";
        mysqli_query($conn, $sql_update);

        $sql_delete = "DELETE FROM cart WHERE cart_id = $cart_id";
        mysqli_query($conn, $sql_delete);
    }
}

header("location: cart.php");
exit();
?>
