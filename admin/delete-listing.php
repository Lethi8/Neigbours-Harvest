<?php
include('../config/constants.php');

if(isset($_GET['listings_id']))
{
    $listings_id = (int) $_GET['listings_id'];
    $image_name = $_GET['image_name'] ?? "";

 
    if($image_name != "")
    {
        $image_name = basename($image_name);
        $path = "../images/listings/".$image_name;

        if(file_exists($path))
        {
            $remove = unlink($path);

            if($remove == false)
            {
                $_SESSION['upload'] = "Failed to remove image";
                header('Location:'.SITEURL.'admin/manage-listings.php');
                exit();
            }
        }
    }

  
    $sql = "DELETE FROM listings WHERE listings_id = $listings_id";
    $res = mysqli_query($conn, $sql);

    if($res)
    {
        $_SESSION['delete'] = "Listing deleted successfully";
    }
    else
    {
        $_SESSION['delete'] = "Failed to delete listing";
    }

    header('Location:'.SITEURL.'admin/manage-listings.php');
    exit();
}
else
{
    $_SESSION['unauthorize'] = "Unauthorized access";
    header('Location:'.SITEURL.'admin/manage-listings.php');
    exit();
}
?>
