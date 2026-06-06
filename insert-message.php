<?php
session_start();
include('config/constants.php');

if (!isset($_SESSION['user_Id'])) {
    header("Location: admin/user-login.php");
    exit();
}

$user_id = (int) $_SESSION['user_Id'];
$receiver_id = (int) $_POST['receiver_id'];
$listings_id = (int) $_POST['listings_id'];
$message = mysqli_real_escape_string($conn, $_POST['message']);

$sql = "INSERT INTO messages (user_Id, receiver_id, listings_id, message, created_at)
        VALUES ($user_id, $receiver_id, $listings_id, '$message', NOW())";

mysqli_query($conn, $sql);

header("Location: send-message.php?listings_id=$listings_id&user_id=$receiver_id");
exit();
?>