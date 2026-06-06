<?php include('partials/menu.php'); ?>

<div class="main-content">
<div class="wrapper">

<h1>Add Order</h1>

<br><br>

<?php
if(isset($_SESSION['upload']))
{
    echo $_SESSION['upload'];
    unset($_SESSION['upload']);
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
        <td><input type="text" name="address" required></td>
    </tr>

    <tr>
        <td>Status:</td>
        <td><input type="text" name="status" required></td>
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
        <td><input type="text" name="pay_method" required></td>
    </tr>

    <tr>
        <td>City:</td>
        <td><input type="number" name="city" required></td>
    </tr>

    <tr>
        <td>Postal Code:</td>
        <td><input type="number" name="postal_code" required></td>
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


<?php
if(isset($_POST['submit']))
{
    $user_Id = mysqli_real_escape_string($conn, $_POST['user_Id']);
    $listings_id = mysqli_real_escape_string($conn, $_POST['listings_id']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $total = mysqli_real_escape_string($conn, $_POST['total']);
    $pay_method = mysqli_real_escape_string($conn, $_POST['pay_method']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $postal_code = mysqli_real_escape_string($conn, $_POST['postal_code']);

    $sql = "INSERT INTO orders SET
        user_Id = '$user_Id',
        listings_id = '$listings_id',
        address = '$address',
        status = '$status',
        quantity = '$quantity',
        total = '$total',
        pay_method = '$pay_method',
        city = '$city',
        postal_code = '$postal_code'
    ";

    $res = mysqli_query($conn, $sql);

    if($res == true)
    {
        $_SESSION['add'] = "<div class='success'>Order Added Successfully.</div>";
        header("location:".SITEURL.'admin/manage-orders.php');
    }
    else
    {
        $_SESSION['add'] = "<div class='error'>Failed to Add Order.</div>";
        header("location:".SITEURL.'admin/add-order.php');
    }
}
?>