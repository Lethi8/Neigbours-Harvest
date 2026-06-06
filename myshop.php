<?php
include('config/constants.php');

if (!isset($_SESSION['user_Id'])) {
    header('Location: admin/user-login.php');
    exit();
}

$user_Id = (int) $_SESSION['user_Id'];

$sql_user = "SELECT username FROM users WHERE user_Id = $user_Id LIMIT 1";
$res_user = mysqli_query($conn, $sql_user);

$username = "My";

if ($res_user && mysqli_num_rows($res_user) > 0) {
    $row_user = mysqli_fetch_assoc($res_user);
    $username = $row_user['username'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <a href="index.php" title="Home">
                    <img src="images/logo.png" alt="Neighbours Harvest Logo" class="img-responsive">
                </a>
            </div>
            <ul class="nav-links">
                <li class="shop-icon">
                    <a href="orders.php" title="Orders">
                        <img src="images/order.png" alt="Orders">
                    </a>
                </li>
                <li class="icon-cart">
                    <a href="get-message.php" title="Chat">
                        <img src="images/message.png" alt="Chat">
                    </a>
                </li>
             
            </ul>
        </div>
    </nav>
    
    <br>
    
<h2 class="shop-title"><?php echo $username; ?>'s Shop</h2>
<section class="produce-menu">
    <div class="container">

        

        <?php
        $sql = "SELECT * FROM listings WHERE user_Id = $user_Id";
        $res = mysqli_query($conn, $sql);

        if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {

                $id = $row['listings_id'];
                $title = $row['title'];
                $image_name = $row['image_name'];
                $description = $row['description'];
                $price = $row['price'];
                $quant = $row['quant'];
                $location = $row['location'];
        ?>

        <div class="produce-menu-box">

            <div class="produce-menu-img">
                <?php if (!empty($image_name)) { ?>
                    <img src="images/<?php echo $image_name; ?>" class="img-responsive img-curve">
                <?php } else { ?>
                    <p>Image not available.</p>
                <?php } ?>
            </div>

            <div class="produce-menu-desc">
                <h4><?php echo $title; ?></h4>

                <p class="produce-price">R<?php echo $price; ?></p>

                <p class="produce-detail"><?php echo $description; ?></p>
                
                <p class="produce-detail">Quantity: <?php echo $quant; ?></p>
                
                <p class="produce-detail">Location: <?php echo $location; ?></p>

                <br>

                <a href="edit-product.php?id=<?php echo $id; ?>" class="btn button">Edit</a>

                <a href="delete-product.php?listings_id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>">Delete</a>
            </div>

        </div>

        <?php
            }
        } else {
            echo "<p>No listings found.</p>";
        }
        ?>

        <div class="clearfix"></div>

        <form action="addItem.php" method="get">
            <button type="submit" class="btn contactSeller">Add Item</button>
        </form>

    </div>
</section>

</body>
</html>