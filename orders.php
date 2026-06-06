<?php
include('config/constants.php');

$user_Id = $_SESSION['user_Id'] ?? 0;

$sql = "SELECT 
    o.orders_id,
    o.status,
    o.city,
    o.total,
    
    u.username AS buyer_name,
    l.title AS product_name

FROM orders o
JOIN users u ON o.user_Id = u.user_Id
JOIN listings l ON o.listings_id = l.listings_id

WHERE l.user_Id = $user_Id";

$res = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="orders-page">

    <!-- Header -->
    <div class="orders-header">
        <a href="myshop.php" class="shop-icon">
            <img src="images/Shop icon.png" alt="Shop">
        </a>

        <h2 class="page-title">Orders</h2>
    </div>

    <!-- orders page -->
    <div class="orders-table-wrapper">

        <table class="orders-table">
            <tr>
                <th>Order ID</th>
                <th>Buyer</th>
                <th>Product</th>
                <th>Total</th>
                <th>Status</th>
                <th>City</th>
            </tr>

            <?php
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
            ?>
                <tr>
                    <td><?php echo $row['orders_id']; ?></td>
                    <td><?php echo $row['buyer_name']; ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td>R<?php echo $row['total']; ?></td>
                    <td>
                        <span class="status <?php echo strtolower($row['status']); ?>">
                            <?php echo $row['status']; ?>
                        </span>
                    </td>
                    <td><?php echo $row['city']; ?></td>
                </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='6'>No orders found</td></tr>";
            }
            ?>

        </table>

    </div>

</div>

</body>
</html>