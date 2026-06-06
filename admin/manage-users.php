<?php include('partials/menu.php');?>



<!-- Main Content Section Starts -->
<div class="main-content">
 <div class="wrapper">
        <h1>Manage Users</h1>

        <br><br>

        <?php 
        if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];//shows session message
                unset($_SESSION['add']); //removes seesion message
            }
            if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete'];
                    unset ($_SESSION['delete']);
                }

                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset ($_SESSION['update']);
                }


        ?>
        <br><br><br>
<!--button to add user -->
        <a href="add-user.php" class="btn-primary">Add User</a>

        <br><br>

        <table class="tbl-full">
        <tr>
            <th>User ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Username</th>
            <th>Actions</th>
        </tr>
        <?php 
//displays users from database
$sql = "SELECT * FROM users";

$res = mysqli_query($conn, $sql);

//checks query has been executed or not
if($res == true)
{
    //checks if there is data in the database
    $count = mysqli_num_rows($res);

    //checks num rows
    if($count > 0)
    {
        //in the case of having data
        while($rows = mysqli_fetch_assoc($res))
        {
            //gets individual data from database
            $user_Id= $rows['user_Id'];
            $full_name = $rows['full_name'];
            $username = $rows['username'];
            $email = $rows['email'];
?>

<tr> 
    <td><?php echo $rows['user_Id']; ?></td>
    <td><?php echo $full_name; ?></td>
    <td><?php echo $email; ?></td>
    <td><?php echo $username; ?></td>
    <td>
        <a href="<?php echo SITEURL; ?>admin/update-user.php?user_Id=<?php  echo $user_Id; ?>" class="btn-secondary">Update User</a>
        <a href="<?php echo SITEURL; ?>admin/delete-user.php?user_Id=<?php  echo $user_Id; ?>" class="btn-danger">Delete User</a>
    </td>
</tr>

<?php
        }
    }
}
?>
                

                
        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php');?>