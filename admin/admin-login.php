<?php 
include('../config/constants.php');
?>
<html>
<head>
<title> Admin Login Page</title>
<link rel="stylesheet" href="../css/admin.css">

</head>
 <body class="login-page">
<div class="login">
	<div class="form-box" id="login-form">
		<h1 class="text-center">Login</h1>
		<br><br>
	<?php
		if(isset($_SESSION['login'])){
		 echo $_SESSION['login'];
		 unset($_SESSION['login']);
		}

		if(isset($_SESSION['no-login-message'])){
			echo $_SESSION['no-login-message'];
			unset($_SESSION['no-login-message']);

		}
		?>
<br><br>
		<!--form start here-->
		<form method="POST" action="" class="text-center">

		<label for="username">Username: </label>
		<input type="text" id="username" name="username" required><br><br>
		
		<label for="password">Password: </label>
		<input type="password" id="password" name="password" required><br><br>
		<br>
		<button type="submit" name="login" class="btn-primary">Login</button>

		</form>
	</div>
</div>

 </body>


</html>

<?php 

//process the login
if(isset($_POST['login'])){
	$username = $_POST['username'];
	$password = $_POST['password'];

	//query to check if the user data exists
	$sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";

	//executes the query
	$res = mysqli_query($conn, $sql);

	//counts rows to check if the user exists
	$count = mysqli_num_rows($res);

	if($count == 1){
		$_SESSION['user'] = $username;
	$_SESSION['login'] ="<div class='success text-center' >Login Sucessful.</div>";
	header('location:'.SITEURL.'admin/');



	}else{

	$_SESSION['login'] ="<div class='error text-center '>Login Failed.</div>";
	header('location:'.SITEURL.'admin/admin-login.php');
	
	}
}

?>