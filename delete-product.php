<?php
include('config/constants.php');

if(isset($_GET['listings_id']) && isset($_GET['image_name']))
{
    $listings_id = $_GET['listings_id'];
    $image_name = $_GET['image_name'];

    if($image_name != "")
    {
        $path = "images/" . $image_name;

        if(file_exists($path))
        {
            $remove = unlink($path);

            if($remove == false)
            {
                $_SESSION['upload'] = "<div class='error'>Failed To Remove Image.</div>";
                header('location:'.SITEURL.'myshop.php');
                die();
            }
        }
    }

    $sql = "DELETE FROM listings WHERE listings_id='$listings_id'";

    $res = mysqli_query($conn, $sql);

    if(!$res)
    {
        die("Query Failed: " . mysqli_error($conn));
    }

    $_SESSION['delete'] = "<div class='success'>Listing Deleted Successfully.</div>";

    header('location:'.SITEURL.'myshop.php');
    exit();
}
else
{
    $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
    header('location:'.SITEURL.'myshop.php');
    exit();
}
?>