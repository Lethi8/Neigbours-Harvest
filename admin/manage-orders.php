<?php include ('partials/menu.php');?>

<div class="main-content">
<div class="wrapper">

<h1>Manage Orders</h1>

<br><br>
<!-- Button to add orders-->
<a href="add-order.php" class="btn-primary">Add Order</a>
<br>
<?php

$sessionMessages = ['add', 'delete', 'update'];

foreach($sessionMessages as $message)
{
    if(isset($_SESSION[$message]))
    {
        echo $_SESSION[$message];
        unset($_SESSION[$message]);
    }
}

?>
<br>
<table class="tbl-full">

    <tr>
        <th>Order ID</th>
        <th>User ID</th>
        <th>Listing ID</th>
        <th>Address</th>
        <th>Status</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>Payment Method</th>
        <th>City</th>
        <th>Postal Code</th>
        <th>Actions</th>
    </tr>

<?php

$sql = "SELECT * FROM orders";

$res = mysqli_query($conn, $sql);

if($res == true)
{
    $count = mysqli_num_rows($res);

    if($count > 0)
    {
        while($rows = mysqli_fetch_assoc($res))
        {
            $orders_id = $rows['orders_id'];
            $user_Id = $rows['user_Id'];
            $listings_id = $rows['listings_id'];
            $address = $rows['address'];
            $status = $rows['status'];
            $quantity = $rows['quantity'];
            $total = $rows['total'];
            $pay_method = $rows['pay_method'];
            $city = $rows['city'];
            $postal_code = $rows['postal_code'];

?>

    <tr>
        <td><?php echo $orders_id; ?></td>
        <td><?php echo $user_Id; ?></td>
        <td><?php echo $listings_id; ?></td>
        <td><?php echo $address; ?></td>
        <td><?php echo $status; ?></td>
        <td><?php echo $quantity; ?></td>
        <td>R<?php echo $total; ?></td>
        <td><?php echo $pay_method; ?></td>
        <td><?php echo $city; ?></td>
        <td><?php echo $postal_code; ?></td>

        <td>
            <a href="<?php echo SITEURL; ?>admin/update-order.php?orders_id=<?php echo $orders_id; ?>" class="btn-secondary">
                Update Order
            </a>

            <a href="<?php echo SITEURL; ?>admin/delete-order.php?orders_id=<?php echo $orders_id; ?>" class="btn-danger">
                Delete Order
            </a>
        </td>
    </tr>

<?php
        }
    }
    else
    {
        echo "<tr><td colspan='11' class='error'>No Orders Found.</td></tr>";
    }
}
?>

</table>

</div>
</div>

<?php include('partials/footer.php');?>