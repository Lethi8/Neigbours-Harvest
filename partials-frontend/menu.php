<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neighbours Harvest</title>
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
                    <a href="myshop.php" title="Shop">
                        <img src="images/Shop icon.png" alt="Shop">
                    </a>
                </li>
                <li class="icon-cart">
                    <a href="cart.php" title="Cart">
                        <img src="images/Shop cart.png" alt="Cart">
                        <span>0</span>
                    </a>
                </li>
                <li class="admin-icon">
                    <a href="admin/user-login.php" title="Account">
                        <img src="images/user-img.png" alt="User">
                    </a>
                </li>
               <?php if (isset($_SESSION['user_Id'])) { ?>
                <li class="admin-icon">
                    <a href="user-logout.php" title="Logout">
                        <img src="images/logout.png" alt="Logout">
                    </a>
                </li>
<?php } ?>
            </ul>
        </div>
    </nav>

</body>
</html>