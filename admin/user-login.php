<?php 
include('../config/constants.php');
?>
<html>
<head>
<title> User Login Page</title>
<link rel="stylesheet" href="../css/admin.css">

</head>
 <body class="login-page">
<div class="login">
	<div class="form-box" id="login-form">
		<h1 class="text-center">Login</h1>
		<br><br>
		<!--form start here-->
		<form method="POST" action="" class="text-center">

		<label for="username">Username: </label>
		<input type="text" id="username" name="username" required><br><br>
		
		<label for="password">Password: </label>
		<input type="password" id="password" name="password" required><br><br>
		<br>
		<button type="submit" name="login" class="btn-primary">Login</button><br>
		</form>
	</div>
</div>

 </body>


</html>

<?php

if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) == 1) {

        $row = mysqli_fetch_assoc($res);

        if (password_verify($password, $row['password'])) {


            $_SESSION['user_Id'] = $row['user_Id'];

            $_SESSION['user'] = $username;

            header('Location: ' . SITEURL . 'index.php');
            exit();

        } else {
            $_SESSION['login'] = "Invalid Password";
            header('Location: ' . SITEURL . 'admin/user-login.php');
            exit();
        }

    } else {
        $_SESSION['login'] = "User Not Found";
        header('Location: ' . SITEURL . 'admin/user-register.php');
        exit();
    }
}
?>
