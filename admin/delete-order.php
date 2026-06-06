<?php

include('../config/constants.php');

// Check whether ID is set
if(isset($_GET['orders_id']))
{
    $orders_id = $_GET['orders_id'];

    // Delete order from database
    $sql = "DELETE FROM orders WHERE orders_id = $orders_id";

    $res = mysqli_query($conn, $sql);

    // Check execution
    if($res == true)
    {
        $_SESSION['delete'] = "<div class='success'>Order Deleted Successfully.</div>";

        header('Location:'.SITEURL.'admin/manage-orders.php');
        exit();
    }
    else
    {
        $_SESSION['delete'] = "<div class='error'>Failed To Delete Order.</div>";

        header('Location:'.SITEURL.'admin/manage-orders.php');
        exit();
    }
}
else
{
    // Unauthorized access
    $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";

    header('Location:'.SITEURL.'admin/manage-orders.php');
    exit();
}

?>