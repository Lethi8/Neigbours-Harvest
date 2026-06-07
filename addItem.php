<?php
include('config/constants.php');

if(isset($_POST['submit']))
{
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quant = $_POST['quant'];
    $location = $_POST['location'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    // ensure user is logged in
    if(!isset($_SESSION['user_Id']))
    {
        header("location: admin/user-login.php");
        exit();
    }

    $user_Id = $_SESSION['user_Id'];

    $image_name = "";

    if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != "")
    {
        $image_name = $_FILES['image']['name'];

        $source_path = $_FILES['image']['tmp_name'];
        $destination_path = "images/" . $image_name;

        $upload = move_uploaded_file($source_path, $destination_path);

        if($upload == false)
        {
            $_SESSION['upload'] = "Failed to upload image";
            header("location:addItem.php");
            exit();
        }
    }

    $sql = "INSERT INTO listings SET
            image_name='$image_name',
            title='$title',
            description='$description',
            price='$price',
            quant='$quant',
            location='$location',
            featured='$featured',
            active='$active',
            user_Id='$user_Id'
        ";

    $res = mysqli_query($conn, $sql);

    if($res)
    {
        header("location:myshop.php");
        exit();
    }
    else
    {
        $_SESSION['submit'] = "<div class='error'>Failed To Add Listing.</div>";
        header("location:addItem.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container">

    <div class="logo">
        <a href="index.php">
            <img src="images/logo.png" class="img-responsive">
        </a>
    </div>

    <div class="clearfix"></div>

   <form method="post" action="" enctype="multipart/form-data" class="product-form">

    <h2 class="form-title">Add New Product</h2>
 
    <br><br>

    <div class="form-group">
        <label>Product Image</label>
        <input type="file" name="image" required>
    </div>

    <br><br>

    <div class="form-group">
        <label>Title:</label>
        <input type="text" name="title" required>
    </div>

    <br><br>

    <div class="form-group">
        <label>Description:</label>
        <textarea name="description" rows="4" required></textarea>
    </div>

     <br><br>

    <div class="form-row">
        <div class="form-group">
            <label>Price:</label>
            <input type="number" name="price" step="0.01" required>
        </div>

        <br><br>

        <div class="form-group">
            <label>Quantity:</label>
            <input type="number" name="quant" required>
        </div>

        <br><br>

         <div class="form-group">
            <label>Location:</label>
            <input type="text" name="location" required>
        </div>
    </div>

     <br><br>

    <div class="form-group">
        <label>Featured:</label>
        <label><input type="radio" name="featured" value="Yes" required> Yes</label>
        <label><input type="radio" name="featured" value="No"> No</label>
    </div>
    <br><br> 
    <div class="form-group">
        <label>Active:</label>
        <label><input type="radio" name="active" value="Yes" required> Yes</label>
        <label><input type="radio" name="active" value="No"> No</label>
    </div>

    <br><br>

    <button type="submit" name="submit"  class="btn contactSeller">
        List Product
    </button>

</form>
</div>

</body>
</html>
