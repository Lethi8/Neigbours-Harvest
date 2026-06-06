<?php
include('config/constants.php');

//destoys the session
session_destroy();
// redirect to user login page
header('location:'.SITEURL.'index.php');
exit();
?>