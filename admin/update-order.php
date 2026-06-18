<?php 
     ob_start();
include('partials/menu.php');

?>

<div class="main-content">
<div class="wrapper">

<h1>Update Order</h1>

<br><br>

<?php

if(isset($_GET['orders_id']))
{
    $orders_id = $_GET['orders_id'];

    $sql = "SELECT * FROM orders WHERE orders_id = $orders_id";

    $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res) == 1)
    {
        $row = mysqli_fetch_assoc($res);

        $user_Id = $row['user_Id'];
        $listings_id = $row['listings_id'];
        $address = $row['address'];
        $city = $row['city'];
        $postal_code = $row['postal_code'];
        $quantity = $row['quantity'];
        $total = $row['total'];
        $pay_method = $row['pay_method'];
        $status = $row['status'];
    }
    else
    {
        header("Location:".SITEURL.'admin/manage-orders.php');
        exit();
    }
}
else
{
    header("Location:".SITEURL.'admin/manage-orders.php');
    exit();
}

?>

<form action="" method="POST">

<table class="tbl-30">

<tr>
    <td>User ID:</td>
    <td>
        <input type="number" name="user_Id" value="<?php echo $user_Id; ?>" required>
    </td>
</tr>

<tr>
    <td>Listing ID:</td>
    <td>
        <input type="number" name="listings_id" value="<?php echo $listings_id; ?>" required>
    </td>
</tr>

<tr>
    <td>Address:</td>
    <td>
        <textarea name="address" cols="30" rows="5" required><?php echo $address; ?></textarea>
    </td>
</tr>

<tr>
    <td>City:</td>
    <td>
        <input type="text" name="city" value="<?php echo $city; ?>" required>
    </td>
</tr>

<tr>
    <td>Postal Code:</td>
    <td>
        <input type="number" name="postal_code" value="<?php echo $postal_code; ?>" required>
    </td>
</tr>

<tr>
    <td>Quantity:</td>
    <td>
        <input type="number" name="quantity" value="<?php echo $quantity; ?>" required>
    </td>
</tr>

<tr>
    <td>Total:</td>
    <td>
        <input type="number" step="0.01" name="total" value="<?php echo $total; ?>" required>
    </td>
</tr>

<tr>
    <td>Payment Method:</td>
    <td>
        <select name="pay_method" required>

            <option value="Card"
            <?php if($pay_method == "Card"){ echo "selected"; } ?>>
                Card
            </option>

            <option value="EFT"
            <?php if($pay_method == "EFT"){ echo "selected"; } ?>>
                EFT
            </option>

            <option value="Cash on Delivery"
            <?php if($pay_method == "Cash on Delivery"){ echo "selected"; } ?>>
                Cash on Delivery
            </option>

        </select>
    </td>
</tr>

<tr>
    <td>Status:</td>
    <td>
        <select name="status" required>

            <option value="Pending"
            <?php if($status == "Pending"){ echo "selected"; } ?>>
                Pending
            </option>

            <option value="Processing"
            <?php if($status == "Processing"){ echo "selected"; } ?>>
                Processing
            </option>

            <option value="Completed"
            <?php if($status == "Completed"){ echo "selected"; } ?>>
                Completed
            </option>

            <option value="Cancelled"
            <?php if($status == "Cancelled"){ echo "selected"; } ?>>
                Cancelled
            </option>

        </select>
    </td>
</tr>

<tr>
    <td colspan="2">

        <input type="hidden" name="orders_id" value="<?php echo $orders_id; ?>">

        <input type="submit" name="submit" value="Update Order" class="btn-secondary">

    </td>
</tr>

</table>

</form>

</div>
</div>

<?php

if(isset($_POST['submit']))
{
    $orders_id = $_POST['orders_id'];
    $user_Id = $_POST['user_Id'];
    $listings_id = $_POST['listings_id'];

    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);

    $postal_code = $_POST['postal_code'];
    $quantity = $_POST['quantity'];
    $total = $_POST['total'];
    $pay_method = $_POST['pay_method'];
    $status = $_POST['status'];

    $sql2 = "UPDATE orders SET
        user_Id = '$user_Id',
        listings_id = '$listings_id',
        address = '$address',
        city = '$city',
        postal_code = '$postal_code',
        quantity = '$quantity',
        total = '$total',
        pay_method = '$pay_method',
        status = '$status'
        WHERE orders_id = '$orders_id'
    ";

    $res2 = mysqli_query($conn, $sql2);

    if($res2 == true)
    {
        $_SESSION['update'] = "<div class='success'>Order Updated Successfully.</div>";

        header("Location:".SITEURL.'admin/manage-orders.php');
        exit();
    }
    else
    {
        $_SESSION['update'] = "<div class='error'>Failed To Update Order.</div>";

        header("Location:".SITEURL.'admin/manage-orders.php');
        exit();
    }
}

?>

<?php include('partials/footer.php'); ?>
