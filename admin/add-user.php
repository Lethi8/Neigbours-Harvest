<?php 
    ob_start();
session_start();
    include('partials/menu.php');?>
<div class="main-content"> 
    <div class="wrapper">
        <h1>Add User </h1>

        <br><br>

         <?php 
        if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];//shows session message
                unset($_SESSION['add']); //removes seesion message
            }
        ?>
        
     <form action="" method="POST">
        <table class="tbl-30">

    <tr>
        <td>Full Name:</td>
        <td>
            <input type="text" name="fname" placeholder="Enter full name">
        </td>
    </tr>

    <tr>
        <td>Username:</td>
        <td>
            <input type="text" name="uname" placeholder="Enter username">
        </td>
    </tr>

    <tr>
        <td>Email:</td>
        <td>
            <input type="email" name="email" placeholder="Enter email">
        </td>
    </tr>
    <tr>
        <td>Password:</td>
        <td>
            <input type="password" name="pword" placeholder="Enter password">
        </td>
    </tr>
<tr>
        <td colspan="2">
            <input type="submit" name="submit" value="Add User" class="btn-secondary">
        </td>
    </tr>

    </table>

    </form> 
    </div>
</div>


<?php include('partials/footer.php');?>

<?php  
//process the input from form and save into database
//check whether the button is clicked or not

if(isset($_POST['submit']))
    {
        //button clicked
        //echo"Button Clicked";

        //get data from from
        $full_name = $_POST['fname'];
        $username = $_POST['uname'];
        $email = $_POST['email'];
        $password = password_hash($_POST['pword'], PASSWORD_DEFAULT); //encypts password

        //sql query to save data into database
        $sql = "INSERT INTO users SET 
        full_name = '$full_name',
        username = '$username',
        email = '$email',
        password = '$password'
        ";

//executes query and saves data into database
         $res = mysqli_query($conn, $sql) or die(mysqli_error());

         //check data is inserted into database or not & display message
         if($res==true)
        {
            //create a session variable to display message
            $_SESSION['add'] = "User added sucessfully";
            //redirect page TO manage users page
         header("location:".SITEURL.'admin/manage-users.php');
            }
         else
        {

         //create a session variable to display message
            $_SESSION['add'] = "User not added";
            //redirect page TO add user
         header("location:".SITEURL.'admin/add-user.php');
         }
    }


?>
