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
    <style>
       * {
    margin: 0;
    padding: 0;
    font-family: Arial, Helvetica, sans-serif;
    box-sizing: border-box;
}

.container {
    width: 80%;
    margin: 0 auto;
    padding: 1%;
    background-color: #ffffff;
}

.img-responsive { width: 100%; }
.img-curve { border-radius: 15px; }

.text-right { text-align: right; }
.text-center { text-align: center; }
.text-left { text-align: left; }

.clearfix { clear: both; }

a {
    color: #555;
    text-decoration: none;
}

a:hover {
    color: #000;
}

h2 {
    color: #2f3542;
    font-size: 2rem;
    margin-bottom: 2%;
}

.btn {
    padding: 8px 12px;
    border: none;
    font-size: 0.9rem;
    border-radius: 6px;
    cursor: pointer;
    margin-top: 6px;
    display: inline-block;
}

.btn-primary {
    background-color: #2e7d32;
    color: white;
}

.btn-primary:hover {
    background-color: #1b5e20;
}

.navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 20px;
    background-color: #fff;
    border-bottom: 1px solid #ddd;
}

.nav-container {
    width: 90%;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo img {
    height: 32px;
    width: auto;
    object-fit: contain;
}

.nav-links {
    display: flex;
    align-items: center;
    list-style: none;
    gap: 18px;
}

.nav-links li {
    display: flex;
    align-items: center;
}

.nav-links a {
    display: flex;
    align-items: center;
    padding: 6px 8px;
}

.nav-links a img {
    width: 22px;
    height: 22px;
}

.nav-links a:hover {
    background-color: rgba(0,0,0,0.05);
    border-radius: 5px;
}

.social {
    background-color: #f4f4f4;
    padding: 20px 0;
}

.social ul {
    list-style: none;
    display: flex;
    justify-content: center;
    gap: 15px;
}

.social img {
    width: 50px;
    height: 50px;
}

.footer {
    background-color: #222;
    padding: 15px 0;
}

.footer p {
    color: white;
    font-size: 0.9rem;
}

.produce-search {
    background-image: url(../images/BgImage.png);
    background-size: cover;
    background-position: center;
    padding: 7% 0;
}

.produce-search input[type="search"] {
    width: 50%;
    padding: 1%;
    border-radius: 5px;
    border: none;
}

.categories {
    padding: 4% 0;
}

.float-container {
    position: relative;
    overflow: hidden;
    border-radius: 15px;
}

.float-text {
    position: absolute;
    bottom: 10px;
    left: 12px;
    color: white;
    font-size: 1.4rem;
    font-weight: bold;
}

.box-3 {
    width: 28%;
    float: left;
    margin: 2%;
    border-radius: 15px;
    overflow: hidden;
}

.box-3 img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.produce-menu {
    background-color: #f4f4f4;
    padding: 4% 0;
}

.produce-menu-box {
    width: 43%;
    margin: 1%;
    padding: 2%;
    float: left;
    background: #fff;
    border-radius: 15px;
    border: 1px solid #ddd;
}

.produce-menu-img {
    width: 25%;
    float: left;
}

.produce-menu-img img {
    width: 100%;
    height: 90px;
    object-fit: cover;
    border-radius: 10px;
}

.produce-menu-desc {
    width: 70%;
    float: left;
    margin-left: 5%;
}

.productName {
    font-size: 1.1rem;
    font-weight: 600;
}

.produce-price {
    font-size: 1.2rem;
    font-weight: bold;
}

.chat-box {
    background: #fff;
    padding: 15px;
    border-radius: 15px;
}

.chat-messages {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 10px;
}

.sent {
    align-self: flex-end;
    background: #4CAF50;
    color: #fff;
    padding: 10px 14px;
    border-radius: 15px 15px 0 15px;
    max-width: 60%;
    word-wrap: break-word;
}

.received {
    align-self: flex-start;
    background: #e5e5e5;
    color: #333;
    padding: 10px 14px;
    border-radius: 15px 15px 15px 0;
    max-width: 60%;
    word-wrap: break-word;
}

.sent small,
.received small {
    display: block;
    font-size: 10px;
    margin-top: 5px;
    opacity: 0.7;
}

.product-summary {
    display: flex;
    gap: 15px;
    align-items: center;
}

.product-summary img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 10px;
}

.chat-input {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.chat-input input {
    flex: 1;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
}

.chat-input button {
    padding: 10px 15px;
    background: #444;
    color: white;
    border: none;
    border-radius: 6px;
}

@media (max-width: 768px) {

    .container {
        width: 95%;
    }

    .produce-search input[type="search"] {
        width: 90%;
    }

    .box-3,
    .produce-menu-box {
        width: 100%;
        float: none;
        margin: 10px 0;
    }

    .chat-input {
        flex-direction: column;
    }

    .chat-input button {
        width: 100%;
    }
}

@media (max-width: 480px) {

    h2 {
        font-size: 1.5rem;
    }

    .box-3 img {
        height: 120px;
    }
}
    </style>
</head>

<body>

<!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <a href="index.php" title="Home">
                    <img src="images/Logo.png" alt="Neighbours Harvest Logo" class="img-responsive">
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
