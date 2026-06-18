<?php
include('../config/constants.php');


if(isset($_POST['login']))
{
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $res = mysqli_query($conn, $sql);

    $count = mysqli_num_rows($res);

    if($count == 1)
    {
        $_SESSION['user'] = $username;
        $_SESSION['login'] = "Login Successful";
        header('location:'.SITEURL.'admin/');
        exit();
    }
    else
    {
        $_SESSION['login'] = "Login Failed";
        header('location:'.SITEURL.'admin/admin-login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login Page</title>
<link rel="stylesheet" href="../css/admin.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="login-page">

<div class="login">
    <div class="form-box" id="login-form">

        <h1 class="text-center">Login</h1>
        <br><br>

        <?php
        if(isset($_SESSION['login']))
        {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }

        if(isset($_SESSION['no-login-message']))
        {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }
        ?>

        <br><br>

        <form method="POST" action="" class="text-center">

            <label>Username:</label>
            <input type="text" name="username" required>
            <br><br>

            <label>Password:</label>
            <input type="password" name="password" required>
            <br><br>

            <button type="submit" name="login" class="btn-primary">Login</button>

        </form>

    </div>
</div>

</body>
</html>
