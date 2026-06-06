<?php
include('config/constants.php');

if(isset($_POST['orders_id']) && isset($_POST['status'])){

    $orders_id = (int) $_POST['orders_id'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $sql = "UPDATE orders 
            SET status = '$status' 
            WHERE orders_id = $orders_id";

    $res = mysqli_query($conn, $sql);

    if($res){
        header("Location: orders.php");
        exit();
    } else {
        echo "Failed to update status: " . mysqli_error($conn);
    }

} else {
    echo "Invalid request.";
}
?>