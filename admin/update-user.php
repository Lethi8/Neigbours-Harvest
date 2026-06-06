<?php include('partials/menu.php');?>

<div class="main-content">
 <div class="wrapper">
    <h1>Update User</h1>
 <br><br>

<?php
$user_Id=$_GET['user_Id'];

$sql ="SELECT * FROM users WHERE user_Id=$user_Id";

$res =mysqli_query($conn, $sql);

if($res == true)
{
    $count= mysqli_num_rows($res);

    if($count==1)
    {
        $row=mysqli_fetch_assoc($res);

        $full_name =$row['full_name'];
        $username= $row['username'];
        $email= $row['email'];
    }
    else
    {
       
        header("Location:".SITEURL.'admin/manage-users.php');
        
    }
}

?>

<form action="" method="POST">
    <table class="tbl-30">

    <tr>
        <td>Full name:</td>
        <td><input type="text" name="full_name" value="<?php echo $full_name; ?> "></td>
    </tr>

    <tr>
        <td>Username:</td>
        <td><input type="text" name="username"  value="<?php echo $username; ?>"></td>
    </tr>

    <tr>
        <td>Email:</td>
        <td><input type="text" name="email"  value="<?php echo $email; ?>"></td>
    </tr>

    <tr>
        <td colspan="2">
            <input type="hidden" name="user_Id" value="<?php echo $user_Id;?>">
            <input type="submit" name="submit" value="Update" class="btn-secondary">
        </td>
    </tr>

    </table>
</form>

 </div>
</div>

<?php 
//checks if update button is clicked or not
if(isset($_POST['submit']))
{
    $user_Id = $_POST['user_Id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    //create sql query
    $sql ="UPDATE users SET
    full_name = '$full_name',
    username = '$username',
    email = '$email'
    WHERE user_Id='$user_Id'
    
    ";


$res = mysqli_query($conn, $sql);

//CHECK QUERY IS successful or not
if($res == true)
    {

$_SESSION['update'] = "<div class='success'>User Updated Sucessfully.</div>";
   //redirect page TO user page
         header("location:".SITEURL.'admin/manage-users.php');
}

else{
 
$_SESSION['update'] = "<div class='error'>Failed to Update User.</div>";
   //redirect page TO user page
         header("location:".SITEURL.'admin/manage-users.php');


    }
}
?>

<?php include('partials/footer.php');?>