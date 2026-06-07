<?php
session_start();
include('config/constants.php');

if (!isset($_SESSION['user_Id'])) {
    header("Location: admin/user-login.php");
    exit();
}

$current_user = (int) $_SESSION['user_Id'];
$other_user = isset($_GET['user_id']) ? (int) $_GET['user_id'] : 0;
$listings_id = isset($_GET['listings_id']) ? (int) $_GET['listings_id'] : 0;

if ($other_user == 0 || $listings_id == 0) {
    die("Invalid chat request");
}

$sql = "SELECT * FROM messages
        WHERE listings_id = $listings_id
        AND (
            (user_Id = $current_user AND receiver_id = $other_user)
            OR
            (user_Id = $other_user AND receiver_id = $current_user)
        )
        ORDER BY created_at ASC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chat</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
<h2>Conversation</h2>

<div class="chat-box">

<?php while ($row = mysqli_fetch_assoc($result)) { ?>

    <div class="<?php echo ($row['user_Id'] == $current_user) ? 'my-msg' : 'their-msg'; ?>">
        <p><?php echo htmlspecialchars($row['message']); ?></p>
        <small><?php echo $row['created_at']; ?></small>
    </div>

<?php } ?>

</div>

<form action="insert-message.php" method="POST">
    <input type="hidden" name="listings_id" value="<?php echo $listings_id; ?>">
    <input type="hidden" name="receiver_id" value="<?php echo $other_user; ?>">

    <textarea name="message" required placeholder="Type reply..."></textarea>
    <button type="submit">Send</button>
</form>

</div>

</body>
</html>
