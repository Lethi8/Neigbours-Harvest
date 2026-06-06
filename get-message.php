<?php
include('config/constants.php');


$seller_Id = (int) $_SESSION['user_Id'];

$sql = "SELECT * FROM messages
        WHERE user_Id = $seller_Id
        OR receiver_id = $seller_Id
        ORDER BY created_at DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$seen = [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seller Inbox</title>
<link rel="stylesheet" href="css/style.css">

<style>
.chat-item {
    padding: 12px;
    border-bottom: 1px solid #ddd;
}

.chat-item h4 {
    margin: 0;
    font-size: 16px;
}

.chat-item p {
    margin: 5px 0;
    color: #555;
}

.chat-item small {
    color: gray;
    font-size: 12px;
}

.chat-link {
    text-decoration: none;
    color: inherit;
}
</style>
</head>

<body>

<div class="container">

    <h2>Messages</h2>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>

        <?php
        $other_user = ($row['user_Id'] == $seller_Id)
            ? $row['receiver_id']
            : $row['user_Id'];

        $chat_key = $row['listings_id'] . '-' . $other_user;

        if (isset($seen[$chat_key])) {
            continue;
        }

        $seen[$chat_key] = true;

        $user_sql = "SELECT username FROM users WHERE user_Id = $other_user LIMIT 1";
        $user_res = mysqli_query($conn, $user_sql);
        $user = mysqli_fetch_assoc($user_res);
        ?>

        <a class="chat-link"
           href="contact-seller.php?listings_id=<?php echo $row['listings_id']; ?>&user_id=<?php echo $other_user; ?>">

            <div class="chat-item">
                <h4><?php echo $user['username']; ?></h4>
                <p><?php echo htmlspecialchars($row['message']); ?></p>
                <small><?php echo $row['created_at']; ?></small>
            </div>

        </a>

    <?php } ?>

</div>

</body>
</html>