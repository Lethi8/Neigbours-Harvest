<?php

include('../config/constants.php');

// Check whether ID and image name are set
if(isset($_GET['listings_id']) && isset($_GET['image_name']))
{
    $listings_id = $_GET['listings_id'];

    $image_name = $_GET['image_name'];

    // Remove image if available
    if($image_name != "")
{
    $path = "../images/listings/".$image_name;

    if(file_exists($path))
    {
        $remove = unlink($path);

        if($remove == false)
        {
            $_SESSION['upload'] = "<div class='error'>Failed To Remove Image.</div>";
            header('Location:'.SITEURL.'admin/manage-listings.php');
            exit();
        }
    }
}

    // Delete listing from database
    $sql = "DELETE FROM listings WHERE listings_id = $listings_id";

    // Execute query
    $res = mysqli_query($conn, $sql);

    // Check query executed properly
    if($res == true)
    {
        $_SESSION['delete'] = "<div class='success'>Listing Deleted Successfully.</div>";

        header('Location:'.SITEURL.'admin/manage-listings.php');

        exit();
    }
    else
    {
        $_SESSION['delete'] = "<div class='error'>Failed To Delete Listing.</div>";

        header('Location:'.SITEURL.'admin/manage-listings.php');

        exit();
    }
}
else
{
    // Unauthorized access
    $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";

    header('Location:'.SITEURL.'admin/manage-listings.php');

    exit();
}

?>