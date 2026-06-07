<?php
include('config/constants.php');

if(isset($_GET['id']))
{
 
    $id = $_GET['id'];

    $sql = "SELECT * FROM listings WHERE listings_id = $id";
    $res = mysqli_query($conn, $sql);


    if($res && mysqli_num_rows($res) == 1)
    {
     
        $row = mysqli_fetch_assoc($res);

        $image_name = $row['image_name'];
        $title = $row['title'];
        $description = $row['description'];
        $price = $row['price'];
        $quant = $row['quant'];
        $location = $row['location'];
    }
    else
    {
        header("location: myshop.php");
        exit();
    }
}
else
{

    header("location: myshop.php");
    exit();
}


if(isset($_POST['submit']))
{
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quant = $_POST['quant'];
    $location = $_POST['location'];

    
    $updated_image = $image_name;


    if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != "")
    {
        
        $updated_image = $_FILES['image']['name'];

     
        $temp_image = $_FILES['image']['tmp_name'];

    
        $destination = "images/" . $updated_image;

       
        $upload_image = move_uploaded_file($temp_image, $destination);

        
        if(!$upload_image)
        {
            echo "Image upload failed.";
            die();
        }
    }

   $update_sql = "UPDATE listings SET
    title = '$title',
    description = '$description',
    price = '$price',
    quant = '$quant',
    location = '$location',
    image_name = '$updated_image'
WHERE listings_id = $id";


    $update_res = mysqli_query($conn, $update_sql);

e
    if($update_res)
    {
        header("location: myshop.php");
        exit();
    }
    else
    {
        echo "Failed to update listing.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container">

    <h2 class="text-center">Edit Product</h2>

    <form method="POST" action="" enctype="multipart/form-data">

        <!-- Product Image Section -->
        <fieldset>

            <legend>Product Image</legend>

            <?php
            // Display current image if available
            if($image_name != "")
            {
            ?>
                <img src="images/<?php echo $image_name; ?>" width="150">
            <?php
            }
            else
            {
                echo "<p>No image available</p>";
            }
            ?>

            <br><br>

            <label>Change Image</label><br>
            <input type="file" name="image">

        </fieldset>

        <br>

        <!-- Product Details Section -->
        <fieldset>

            <legend>Product Details</legend>

            <label>Title</label><br>
            <input 
                type="text" 
                name="title" 
                value="<?php echo $title; ?>" 
                required
            >

            <br><br>

            <label>Description</label><br>
            <textarea 
                name="description" 
                rows="4" 
                required
            ><?php echo $description; ?></textarea>

            <br><br>

            <label>Price</label><br>
            <input 
                type="number" 
                name="price" 
                step="0.01" 
                value="<?php echo $price; ?>" 
                required
            >

            <br><br>
             <label>Quantity</label><br>
            <input 
                type="number" 
                name="quant" 
                value="<?php echo $quant; ?>" 
                required
            > <br><br>

             <label>Location</label><br>
            <input 
                type="text" 
                name="location" 
                value="<?php echo $location; ?>" 
                required
            >


        </fieldset>

        <br>

        <!-- Buttons -->
        <button 
            class="btn btn-primary" 
            type="submit" 
            name="submit"
        >
            Save Changes
        </button>

        <a href="myshop.php" class="btn contactSeller">
            Cancel
        </a>

    </form>

</div>

</body>
</html>
