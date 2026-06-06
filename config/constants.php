<?php 

session_start();

// Website URL
define('SITEURL', 'http://localhost/neighbours-harvest/');

// Database credentials
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'neighbours-harvest');

// Database connection
$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if(!$conn)
{
    die("Connection Failed: " . mysqli_connect_error());
}

?>