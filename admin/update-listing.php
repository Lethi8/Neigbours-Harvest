<?php include('partials/menu.php'); ?>

<div class="main-content">
<div class="wrapper">

<h1>Update Listing</h1>

<br><br>

<?php

// Get listing details
if(isset($_GET['listings_id']))
{
    $listings_id = $_GET['listings_id'];

    $sql2 = "SELECT * FROM listings WHERE listings_id = $listings_id";

    // Execute query
    $res2 = mysqli_query($conn, $sql2);

    // Check rows
    if(mysqli_num_rows($res2) == 1)
    {
        $row2 = mysqli_fetch_assoc($res2);

        // Get values
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $quant = $row2['quant'];
        $current_image = $row2['image_name'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    }
    else
    {
        header("Location:".SITEURL.'admin/manage-listings.php');
        exit();
    }
}
else
{
    // Redirect
    header("Location:".SITEURL.'admin/manage-listings.php');
    exit();
}

?>

<form action="" method="POST" enctype="multipart/form-data">

<table class="tbl-30">

<tr>
    <td>Title:</td>

    <td>
        <input type="text" name="title" value="<?php echo $title; ?>" required>
    </td>
</tr>

<tr>
    <td>Description:</td>

    <td>
        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
    </td>
</tr>

<tr>
    <td>Price:</td>

    <td>
        <input type="number" step="0.01" name="price" value="<?php echo $price; ?>" required>
    </td>
</tr>

<tr>
    <td>Quantity:</td>

    <td>
        <input type="number" name="quant" value="<?php echo $quant; ?>" required>
    </td>
</tr>

<tr>
    <td>Current Image:</td>

    <td>

        <?php

        if($current_image == "")
        {
            echo "<div class='error'>Image Not Available.</div>";
        }
        else
        {
        ?>

        <img src="<?php echo SITEURL; ?>images/listings/<?php echo $current_image; ?>" width="150px">

        <?php
        }
        ?>

    </td>
</tr>

<tr>
    <td>New Image:</td>

    <td>
        <input type="file" name="image">
    </td>
</tr>

<tr>
    <td>Featured:</td>

    <td>
        <input <?php if($featured == "Yes"){ echo "checked"; } ?> type="radio" name="featured" value="Yes"> Yes

        <input <?php if($featured == "No"){ echo "checked"; } ?> type="radio" name="featured" value="No"> No
    </td>
</tr>

<tr>
    <td>Active:</td>

    <td>
        <input <?php if($active == "Yes"){ echo "checked"; } ?> type="radio" name="active" value="Yes"> Yes

        <input <?php if($active == "No"){ echo "checked"; } ?> type="radio" name="active" value="No"> No
    </td>
</tr>

<tr>
    <td colspan="2">

        <input type="hidden" name="listings_id" value="<?php echo $listings_id; ?>">

        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

        <input type="submit" name="submit" value="Update Listing" class="btn-secondary">

    </td>
</tr>

</table>

</form>

</div>
</div>

<?php

// Check submit
if(isset($_POST['submit']))
{
    $listings_id = $_POST['listings_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $quant = $_POST['quant'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    $current_image = $_POST['current_image'];

    // Default image
    $image_name = $current_image;

    // Check new image
    if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != "")
    {
        $image_name_new = $_FILES['image']['name'];

        // Get extension
        $ext = pathinfo($image_name_new, PATHINFO_EXTENSION);

        // Rename image
        $image_name = "Listing-".rand(0000,9999).".".$ext;

        // Paths
        $src_path = $_FILES['image']['tmp_name'];

        $destination_path = "../images/listings/".$image_name;

        // Upload
        $upload = move_uploaded_file($src_path, $destination_path);

        // Check upload
        if($upload == false)
        {
            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";

            header("Location:".SITEURL.'admin/manage-listings.php');
            exit();
        }

        // Remove old image
        if($current_image != "")
        {
            $remove_path = "../images/listings/".$current_image;

            unlink($remove_path);
        }
    }

    // Update query
    $sql3 = "UPDATE listings SET
        title = '$title',
        description = '$description',
        price = '$price',
        quant = '$quant',
        image_name = '$image_name',
        featured = '$featured',
        active = '$active'
        WHERE listings_id = '$listings_id'
    ";

    $res3 = mysqli_query($conn, $sql3);

    // Check query
    if($res3 == true)
    {
        $_SESSION['update'] = "<div class='success'>Listing Updated Successfully.</div>";

        header("Location:".SITEURL.'admin/manage-listings.php');
        exit();
    }
    else
    {
        $_SESSION['update'] = "<div class='error'>Failed to Update Listing.</div>";

        header("Location:".SITEURL.'admin/manage-listings.php');
        exit();
    }
}

?>

<?php include('partials/footer.php'); ?>