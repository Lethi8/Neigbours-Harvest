<?php
include('config/constants.php');

if(!isset($_SESSION['user_Id']))
{
    header("location: admin/user-login.php");
    exit();
}

$user_Id = $_SESSION['user_Id'];

$sql = "SELECT 
    c.cart_id,
    c.quantity,
    l.title,
    l.price,
    l.image_name
FROM cart c
JOIN listings l ON c.listings_id = l.listings_id
WHERE c.user_Id = $user_Id";

$res = mysqli_query($conn, $sql);
$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<!-- Navbar -->
<section class="navbar">
    <div class="container">

        <div class="logo">
            <a href="index.php">
                <img src="images/logo.png" class="img-responsive">
            </a>
        </div>

        <div class="menu text-right">
            <ul>
                <li>
                    <a href="cart.php" class="icon-cart">
                        <img src="images/Shop cart.png" alt="Cart">
                    </a>
                </li>
            </ul>
        </div>

        <div class="clearfix"></div>
    </div>
</section>

<!-- Cart -->
<section class="cart-container">
    <div class="container">

        <h2>Your Cart</h2>

        <?php if(mysqli_num_rows($res) > 0) { ?>

            <?php while($row = mysqli_fetch_assoc($res)) { ?>

                <?php
                    $subtotal = $row['price'] * $row['quantity'];
                    $total += $subtotal;
                ?>

                <div class="cart-item">
                    
                    <span>
                        <?php echo $row['title']; ?> 
                        (x<?php echo $row['quantity']; ?>)
                    </span>

                    <span>R<?php echo $subtotal; ?></span>

                    <a href="delete_item_cart.php?cart_id=<?php echo $row['cart_id']; ?>" class="btn btn-primary">Remove</a>

                </div>

            <?php } ?>

        <?php } else { ?>
            <p>Your cart is empty.</p>
        <?php } ?>

        <br>
        <div class="cart-total">
            <h3>Total: R<?php echo $total; ?></h3>

            <?php if($total > 0) { ?>
                <a href="checkout.php">
                    <br>
                    <button class="btn btn-primary">Checkout</button>
                </a>
            <?php } ?>

        </div>

    </div>
</section>

</body>
</html>