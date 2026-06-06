<?php
include('config/constants.php');

if(!isset($_SESSION['user_Id'])){
    header("location: admin/user-login.php");
    exit();
}

$user_Id = $_SESSION['user_Id'];

$cartSql = "SELECT 
    c.listings_id,
    c.quantity,
    l.price
FROM cart c
JOIN listings l ON c.listings_id = l.listings_id
WHERE c.user_Id = $user_Id";


//checks if order exists
if(isset($_POST['placeOrder'])){

    $address = $_POST['address'];
    $city = $_POST['city'];
    $postal = $_POST['postal_code'];

    $cartSql = "SELECT c.listings_id, c.quantity, l.price
                FROM cart c
                JOIN listings l ON c.listings_id = l.listings_id
                WHERE c.user_Id = $user_Id";

    $cartRes = mysqli_query($conn, $cartSql);

    if(mysqli_num_rows($cartRes) == 0){
        header("location: cart.php");
        exit();
    }

    while($item = mysqli_fetch_assoc($cartRes)){

        $listings_id = $item['listings_id'];
        $quantity = $item['quantity'];
        $price = $item['price'];

        $total = $price * $quantity;

        $orderSql = "INSERT INTO orders SET
            user_Id = '$user_Id',
            listings_id = '$listings_id',
            quantity = '$quantity',
            total = '$total',
            address = '$address',
            city = '$city',
            postal_code = '$postal',
            status = 'Pending'
        ";

        mysqli_query($conn, $orderSql);
    }

    /* clears cart */
    mysqli_query($conn, "DELETE FROM cart WHERE user_Id = $user_Id");

    header("Location: order-success.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container">

    <h2>Checkout</h2>

    <form method="POST" action="">

        <label>Delivery Address:</label><br>
        <textarea name="address" required></textarea><br><br>

        <label>City:</label><br>
        <input type="text" name="city" required><br><br>

        <label>Postal Code:</label><br>
        <input type="text" name="postal_code" required><br><br>

        <br>
        <button type="submit" name="placeOrder" class="btn btn-primary">
            Place Order
        </button>
        <br>

    </form>

    <hr>

<br>
    <h3>Your Order Summary</h3>

    <br>
    <?php
    $cartRes2 = mysqli_query($conn, $cartSql);
    $grandTotal = 0;

    while($row = mysqli_fetch_assoc($cartRes2))
    {
        $subtotal = $row['price'] * $row['quantity'];
        $grandTotal += $subtotal;
        ?>

        <p>
            Item ID: <?php echo $row['listings_id']; ?> |
            Qty: <?php echo $row['quantity']; ?> |
            Subtotal: R<?php echo $subtotal; ?>
        </p>

        <br>
        <?php
    }
    ?>

    <h3>Total: R<?php echo $grandTotal; ?></h3>

</div>

</body>
</html>