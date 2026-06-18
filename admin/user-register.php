<?php
include('../config/constants.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $full_name = filter_input(INPUT_POST, "full_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $email    = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($full_name) || empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required";
    } else {

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (full_name, username, email, password)
                VALUES ('$full_name', '$username', '$email', '$hash')";

        try {
            mysqli_query($conn, $sql);

            // redirect to login page after successful registration
            header("Location: user-login.php");
            exit();

        } catch (mysqli_sql_exception $e) {
            $error = "That username or email is already taken";
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
<title>Register Page</title>
<link rel="stylesheet" href="../css/admin.css">
</head>

<body class="login-page">

<div class="login">
    <div class="form-box" id="login-form">

        <h1 class="text-center">Register</h1>
        <br><br>

        <!-- error message -->
        <?php if (!empty($error)) { echo "<p style='color:red;'>$error</p>"; } ?>

        <!-- form -->
        <form method="POST" action="" class="text-center">

            <label>Full name:</label>
            <input type="text" name="full_name" required><br><br>

            <label>Username:</label>
            <input type="text" name="username" required><br><br>

            <label>Email:</label>
            <input type="email" name="email" required><br><br>

            <label>Password:</label>
            <input type="password" name="password" required><br><br>

            <button type="submit" class="btn-primary">Register</button>

        </form>

        <br>

        <p class="text-center">
            Already have an account?
            <a href="user-login.php">Click Here</a>
        </p>

    </div>
</div>

</body>
</html>
