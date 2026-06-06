<?php
include('../config/constants.php');
?>
<html>
<head>
<title> Register Page</title>
<link rel="stylesheet" href="../css/admin.css">

</head>
 <body class="login-page">
<div class="login">
	<div class="form-box" id="login-form">
		<h1 class="text-center">Register</h1>
		<br><br>
		<!--form start here-->
		<form method="POST" action="" class="text-center">

	<label for="fullname">Full name: </label>
	<input type="text" id="full_name" name="full_name" required></input><br><br>

	<label for="username">Username: </label>
	<input type="text" id="username" name="username" required><br><br>
	
	<label for="email">Email: </label>
	<input type="email" id="email" name="email" required></input><br><br>

	<label for="password">Password: </label>
	<input type="password" id="password" name="password" required></input><br><br>
	
	<a href="admin/user-register.php">
	<button type="submit" name="Register" class="btn-primary">Register</button>
	</a>

	</form>
    <br>
	<p class="text-center">Already have an account?
	<a href="user-login.php">Click Here</a></p>
	</div>
	</div>
</div>
</body>

</html>
<?php 
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $full_name = filter_input(INPUT_POST, "full_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $email    = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);

    if(empty($full_name)){
      

    }elseif(empty($username)){
        

    }elseif(empty($email)){
        

    }elseif(empty($password)){
        

    }else{

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (full_name, username, email, password)
                VALUES ('$full_name', '$username', '$email', '$hash')";

        try{
            mysqli_query($conn, $sql);
            echo "You are now registered";
        }
        catch(mysqli_sql_exception){
            echo "That username or email is taken";
        }
    }
}

mysqli_close($conn);
?>