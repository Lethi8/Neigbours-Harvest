<?php include ('partials/menu.php');?> 

<div class="main-content">
<div class="wrapper"> 

<h1>Manage Listings</h1>

<br><br>

<!-- Button to add listing -->
<a href="add-listing.php" class="btn-primary">Add Listing</a>

<br><br>

<?php 

// Session messages
$sessionMessages = ['add', 'delete', 'upload', 'unauthorize', 'update'];

foreach($sessionMessages as $message)
{
    if(isset($_SESSION[$message]))
    {
        echo $_SESSION[$message];
        unset($_SESSION[$message]);
    }
}

?>

<table class="tbl-full">

    <tr>
        <th>ListingID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Image</th>
        <th>Featured</th>
        <th>Active</th>
        <th>UserID</th>
        <th>Actions</th>
    </tr>

<?php 

// Display listings from database
$sql = "SELECT * FROM listings";

$res = mysqli_query($conn, $sql);

// Check query execution
if($res == true)
{
    // Count rows
    $count = mysqli_num_rows($res);

    if($count > 0)
    {
        while($rows = mysqli_fetch_assoc($res))
        {
            // Get individual values
            $listings_id = $rows['listings_id'];
            $title = $rows['title'];
            $description = $rows['description'];
            $price = $rows['price'];
            $quant = $rows['quant'];
            $image_name = $rows['image_name'];
            $featured = $rows['featured'];
            $active = $rows['active'];
            $user_id = $rows['user_id'];

?>

    <tr>

        <td><?php echo $listings_id; ?></td>

        <td><?php echo $title; ?></td>

        <td><?php echo $description; ?></td>

        <td>R<?php echo $price; ?></td>

        <td><?php echo $quant; ?></td>

        <td>

            <?php 

            if($image_name == "")
            {
                echo "<div class='error'>Image Not Added</div>";
            } 
            else
            {
            ?>

                <img src="<?php echo SITEURL; ?>images/<?php echo $image_name; ?>" width="100px">

            <?php 
            }
            ?>

        </td>

        <td><?php echo $featured; ?></td>

        <td><?php echo $active; ?></td>

        <td><?php echo $user_id; ?></td>

        <td>

            <a href="<?php echo SITEURL; ?>admin/update-listing.php?listings_id=<?php echo $listings_id; ?>&image_name=<?php echo $image_name; ?>" class="btn-secondary">
                Update Listing
            </a>

            <a href="<?php echo SITEURL; ?>admin/delete-listing.php?listings_id=<?php echo $listings_id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">
                Delete Listing
            </a>

        </td>

    </tr>

<?php
        }
    }
    else
    {
        echo "<tr><td colspan='10' class='error'>No Listings Added.</td></tr>";
    }
}
?>

</table>

</div>
</div>

<?php include('partials/footer.php');?>