<?php
ob_start();
session_start();
include('partials/menu.php');

if(isset($_POST['submit']))
{
            $user_Id= $_POST['user_Id'];
            $listings_id= $_POST['listings_id'];
            $address= $_POST['address'];
            $status= $_POST['status'];
            $quantity = $_POST['quantity'];
            $total= $_POST['total'];
            $pay_method= $_POST['pay_method'];
            $city= $_POST['city'];
            $postal_code = $_POST['postal_code'];

    $sql = "INSERT INTO orders SET
        user_Id      = '$user_Id',
        listings_id  = '$listings_id',
        address      = '$address',
        status       = '$status',
        quantity     = '$quantity',
        total        = '$total',
        pay_method   = '$pay_method',
        city         = '$city',
        postal_code  = '$postal_code'
    ";

    $res = mysqli_query($conn, $sql);

    if($res)
    {
        $_SESSION['add'] = "<div class='success'>Order Added Successfully.</div>";
        header("location:".SITEURL.'admin/manage-orders.php');
        exit();
    }
    else
    {
        $_SESSION['add'] = "<div class='error'>Failed To Add Order.</div>";
        header("location:".SITEURL.'admin/add-order.php');
        exit();
    }
}
?>

<div class="main-content">
<div class="wrapper">

<h1>Add Order</h1>

<br><br>

<?php
if(isset($_SESSION['add']))
{
    echo $_SESSION['add'];
    unset($_SESSION['add']);
}
?>

<form action="" method="POST">
<table class="tbl-30">

    <tr>
        <td>User ID:</td>
        <td><input type="number" name="user_Id" required></td>
    </tr>

    <tr>
        <td>Listing ID:</td>
        <td><input type="number" name="listings_id" required></td>
    </tr>

    <tr>
        <td>Address:</td>
        <td><textarea name="address" cols="30" rows="3" required></textarea></td>
    </tr>

    <tr>
        <td>City:</td>
        <td><input type="text" name="city" required></td>
    </tr>

    <tr>
        <td>Postal Code:</td>
        <td><input type="number" name="postal_code" required></td>
    </tr>

    <tr>
        <td>Quantity:</td>
        <td><input type="number" name="quantity" required></td>
    </tr>

    <tr>
        <td>Total:</td>
        <td><input type="number" step="0.01" name="total" required></td>
    </tr>

    <tr>
        <td>Payment Method:</td>
        <td>
            <select name="pay_method" required>
                <option value="">-- Select Payment Method --</option>
                <option value="Card">Card</option>
                <option value="EFT">EFT</option>
                <option value="Cash on Delivery">Cash on Delivery</option>
            </select>
        </td>
    </tr>

    <tr>
        <td>Status:</td>
        <td>
            <select name="status" required>
                <option value="Pending">Pending</option>
                <option value="Processing">Processing</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
            </select>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <input type="submit" name="submit" value="Add Order" class="btn-secondary">
        </td>
    </tr>

</table>
</form>

</div>
</div>

<?php include('partials/footer.php'); ?>
