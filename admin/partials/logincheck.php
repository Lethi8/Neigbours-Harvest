<?php 

// check if user is NOT logged in
if(!isset($_SESSION['user'])){

    $_SESSION['no-login-message'] = "<div class='error'>Please login to access Admin Website.</div>";

    header('location:'.SITEURL.'admin/admin-login.php');
}
?>