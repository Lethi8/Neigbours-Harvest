<?php
include('../config/constants.php');

$user_Id = $_GET['user_Id'];

$sql = "DELETE FROM users WHERE user_Id=$user_Id";

//execute query
$res = mysqli_query($conn, $sql);

//check whether the query worked or not
if($res==true){
    // echo "User Deleted";
    $_SESSION['delete'] = "<div class='success'>User Deleted Sucessfully.</div>";
    //redirect to mange users page
header('location:'.SITEURL.'admin/manage-users.php');
}
else{
    //echo "Failed to Delete User";
    $_SESSION['delete'] ="<div class='success'>Failed to  Delete User.</div>";
    header('location:'.SITEURL.'admin/manage-users.php');
}

?>