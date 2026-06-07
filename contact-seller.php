<?php
include('config/constants.php');

if (!isset($_SESSION['user_Id'])) {
    header("location: login.php");
    exit();
}

if (!isset($_GET['listings_id'])) {
    header("location: index.php");
    exit();
}

$current_user = (int)$_SESSION['user_Id'];
$listing_id = (int)$_GET['listings_id'];
$other_user = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $message = mysqli_real_escape_string($conn, trim($_POST['message']));
    $receiver_id = (int)$_POST['receiver_id'];

    $sql = "INSERT INTO messages
            (listings_id, user_Id, receiver_id, message, created_at)
            VALUES
            ($listing_id, $current_user, $receiver_id, '$message', NOW())";

    mysqli_query($conn, $sql);

    header("location: contact-seller.php?listings_id=$listing_id&user_id=$other_user");
    exit();
}

$sql = "
SELECT l.*, u.user_Id AS seller_id, u.full_name
FROM listings l
JOIN users u ON l.user_Id = u.user_Id
WHERE l.listings_id = $listing_id
";

$res = mysqli_query($conn, $sql);
$listing = mysqli_fetch_assoc($res);

$seller_id = $listing['seller_id'];

if ($other_user == 0) {
    $other_user = $seller_id;
}

$sql = "
SELECT m.*, u.full_name
FROM messages m
JOIN users u ON m.user_Id = u.user_Id
WHERE m.listings_id = $listing_id
AND (
    (m.user_Id = $current_user AND m.receiver_id = $other_user)
    OR
    (m.user_Id = $other_user AND m.receiver_id = $current_user)
)
ORDER BY m.created_at ASC
";

$messages = mysqli_query($conn, $sql);

include('partials-frontend/menu.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chat</title>

<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }
 
        .container {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
        }
 
        .seller-name {
            font-size: 1.4rem;
            font-weight: bold;
            color: #2f3542;
        }
 
        .seller-location {
            color: #777;
            margin-bottom: 15px;
        }
 
        .product-summary {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #eee;
            border-radius: 10px;
        }
 
        .product-summary img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
 
        .product-summary h3 {
            margin-bottom: 5px;
        }
 
        .chat-messages {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 10px;
            min-height: 200px;
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #eee;
            border-radius: 10px;
            margin-bottom: 10px;
        }
 
        .sent {
            align-self: flex-end;
            background: #4CAF50;
            color: #fff;
            padding: 10px 14px;
            border-radius: 15px 15px 0 15px;
            max-width: 65%;
            word-wrap: break-word;
        }
 
        .received {
            align-self: flex-start;
            background: #f0f0f0;
            color: #333;
            padding: 10px 14px;
            border-radius: 15px 15px 15px 0;
            max-width: 65%;
            word-wrap: break-word;
        }
 
        .msg-name {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 4px;
            opacity: 0.8;
        }
 
        .msg-time {
            display: block;
            font-size: 10px;
            margin-top: 4px;
            opacity: 0.6;
            text-align: right;
        }
 
        .no-messages {
            text-align: center;
            color: #aaa;
            padding: 30px 0;
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
            font-size: 0.95rem;
        }
 
        .chat-input button {
            padding: 10px 20px;
            background: #2e7d32;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.95rem;
        }
 
        .chat-input button:hover {
            background: #1b5e20;
        }
 
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }
 
            .chat-input {
                flex-direction: column;
            }
 
            .chat-input button {
                width: 100%;
            }
 
            .product-summary img {
                width: 80px;
                height: 80px;
            }
        }
    </style>

</head>
<body>

<div class="container">

    <div class="seller-desc">
        <h2><?php echo htmlspecialchars($listing['full_name']); ?></h2>
        <p><?php echo htmlspecialchars($listing['location']); ?></p>
    </div>

    <div class="product-summary">
        <img src="<?php echo SITEURL; ?>images/<?php echo $listing['image_name']; ?>" alt="Product">

        <div>
            <h3><?php echo htmlspecialchars($listing['title']); ?></h3>

            <p>
                <strong>R<?php echo $listing['price']; ?></strong>
            </p>

            <p>
                <?php
                if ($listing['quant'] > 0) {
                    echo $listing['quant'] . " items available";
                } else {
                    echo "Out of stock";
                }
                ?>
            </p>
        </div>
    </div>

    <div class="chat-box">

        <div class="chat-messages" id="chat-messages">

            <?php
            if (mysqli_num_rows($messages) > 0) {

                while ($msg = mysqli_fetch_assoc($messages)) {

                    $class = ($msg['user_Id'] == $current_user)
                        
                        ? 'sent'
                        : 'received';
            ?>

                <div class="<?php echo $class; ?>">

                    <div class="msg-name">
                        <?php echo htmlspecialchars($msg['full_name']); ?>
                    </div>

                    <?php echo htmlspecialchars($msg['message']); ?>

                    <small>
                        <?php echo date('d M Y H:i', strtotime($msg['created_at'])); ?>
                    </small>

                </div>

            <?php
                }
            } else {
                echo '<p class="no-messages">No messages yet. Start the conversation!</p>';
            }
            ?>

        </div>

        <form method="POST">

            <input
                type="hidden"
                name="receiver_id"
                value="<?php echo $other_user; ?>"
            >

            <div class="chat-input">

                <input
                    type="text"
                    name="message"
                    placeholder="Type a message..."
                    required
                >

                <button type="submit">
                    Send
                </button>

            </div>

        </form>

    </div>

</div>

<script>
const chatBox = document.getElementById("chat-messages");
chatBox.scrollTop = chatBox.scrollHeight;
</script>

</body>
</html>
