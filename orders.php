<?php
include('config/constants.php');

$user_Id = $_SESSION['user_Id'] ?? 0;

$sql = "SELECT 
    o.orders_id,
    o.status,
    o.city,
    o.total,
    o.pay_method,
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

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .orders-page {
            width: 90%;
            margin: 30px auto;
        }

        .orders-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .page-title {
            font-size: 2rem;
            font-weight: bold;
            color: #2f3542;
            position: relative;
        }

        .page-title::after {
            content: "";
            display: block;
            width: 60px;
            height: 4px;
            background: #2e7d32;
            margin-top: 6px;
            border-radius: 4px;
        }

        .shop-icon img {
            width: 24px;
            height: 24px;
        }

        .orders-table-wrapper {
            overflow-x: auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        .orders-table th {
            background: #2e7d32;
            color: white;
            padding: 12px;
            text-align: left;
        }

        .orders-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .orders-table {
            background: #fafafa;
        }

        .orders-table {
            background: #f1f1f1;
        }

        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: capitalize;
        }

        .status.pending {
            background: #fff3cd;
            color: #856404;
        }

        .status.completed {
            background: #d4edda;
            color: #155724;
        }

        .status.cancelled {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>

<div class="orders-page">

    <div class="orders-header">
        <a href="myshop.php" class="shop-icon">
            <img src="images/Shop icon.png" alt="Shop">
        </a>

        <h2>Orders</h2>
    </div>

    <div class="orders-table-wrapper">

        <table class="orders-table">
            <tr>
                <th>Order ID</th>
                <th>Buyer</th>
                <th>Product</th>
                <th>Total</th>
                <th>Pay Method</th>
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
                    <td><?php echo $row['pay_method']; ?></td>
                    <td>
    <form method="POST" action="update-order-status.php">
        <input type="hidden" name="orders_id" value="<?php echo $row['orders_id']; ?>">

        <select name="status" class="status-select">
            <option value="Pending" <?php if($row['status'] == "Pending") echo "selected"; ?>>
                Pending
            </option>

            <option value="Completed" <?php if($row['status'] == "Completed") echo "selected"; ?>>
                Completed
            </option>

            <option value="Cancelled" <?php if($row['status'] == "Cancelled") echo "selected"; ?>>
                Cancelled
            </option>
        </select>

        <button type="submit" class="status-btn">Update</button>
    </form>
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
