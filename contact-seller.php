<?php
include('config/constants.php');

$current_user_id = isset($_SESSION['user_Id']) ? (int)$_SESSION['user_Id'] : 0;

if ($current_user_id === 0) {
    header("location: login.php");
    exit();
}

if (!isset($_GET['listings_id'])) {
    header("location: index.php");
    exit();
}

$listings_id = (int)$_GET['listings_id'];

// Send message
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message     = mysqli_real_escape_string($conn, trim($_POST['message']));
    $receiver_id = (int)$_POST['receiver_id'];

    mysqli_query($conn, "INSERT INTO messages (listings_id, user_Id, receiver_id, message, created_at)
                         VALUES ($listings_id, $current_user_id, $receiver_id, '$message', NOW())");

    header("location: contact-seller.php?listings_id=$listings_id");
    exit();
}

// Get listing and seller
$res     = mysqli_query($conn, "SELECT l.*, u.user_Id AS seller_id, u.full_name
                                FROM listings l
                                INNER JOIN users u ON l.user_Id = u.user_Id
                                WHERE l.listings_id = $listings_id");
$listing = mysqli_fetch_assoc($res);
$seller_id = (int)$listing['seller_id'];

// Get messages
$res2     = mysqli_query($conn, "SELECT m.*, u.full_name
                                 FROM messages m
                                 INNER JOIN users u ON m.user_Id = u.user_Id
                                 WHERE m.listings_id = $listings_id
                                 ORDER BY m.created_at ASC");
$messages = [];
while ($row = mysqli_fetch_assoc($res2)) {
    $messages[] = $row;
}

include('partials-frontend/menu.php');
?>

<div class="container">

    <div class="seller-desc">
        <h2><?php echo $listing['full_name']; ?></h2>
        <p><?php echo $listing['location']; ?></p>
    </div>

    <div class="product-summary">
        <img src="<?php echo SITEURL; ?>images/<?php echo $listing['image_name']; ?>" alt="Product" class="product-summary">
        <div>
            <h3><?php echo $listing['title']; ?></h3>
            <p><strong>R<?php echo $listing['price']; ?></strong></p>
            <p><?php echo $listing['quant'] > 0 ? $listing['quant']." items available" : "Out of stock"; ?></p>
        </div>
    </div>

    <div class="chat-box">

        <div class="chat-messages">
            <?php if (empty($messages)): ?>
            
            <?php else: ?>
                <?php foreach ($messages as $msg): ?>
                    <div class="<?php echo $msg['user_Id'] == $current_user_id ? 'sent' : 'received'; ?>">
                        <?php echo $msg['message']; ?>
                        <small><?php echo date('d M Y H:i', strtotime($msg['created_at'])); ?></small>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <form method="POST">
            <input type="hidden" name="receiver_id" value="<?php echo $seller_id; ?>">
            <div class="quick-actions">
                <input type="text" name="message" placeholder="Type a message..." required>
                <button type="submit" class="btn">Send</button>
            </div>
        </form>

    </div>

</div>
