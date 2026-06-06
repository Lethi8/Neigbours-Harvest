<?php
include('config/constants.php');

// Check if listing ID exists 
if(isset($_GET['id']))
{
    // Store the listing ID
    $id = $_GET['id'];

    // Get listing data from database
    $sql = "SELECT * FROM listings WHERE listings_id = $id";
    $res = mysqli_query($conn, $sql);

    // Check if listing exists
    if($res && mysqli_num_rows($res) == 1)
    {
        // Fetch listing details
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
        // Redirect if listing not found
        header("location: myshop.php");
        exit();
    }
}
else
{
    // Redirect if no ID provided
    header("location: myshop.php");
    exit();
}


// Handle form submission
if(isset($_POST['submit']))
{
    // Get updated form values
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quant = $_POST['quant'];
    $location = $_POST['location'];

    // Keep current image by default
    $updated_image = $image_name;

    // Check if user selected a new image
    if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != "")
    {
        // Get uploaded image name
        $updated_image = $_FILES['image']['name'];

        // Temporary image path
        $temp_image = $_FILES['image']['tmp_name'];

        // Destination folder
        $destination = "images/" . $updated_image;

        //uplaod the image
        $upload_image = move_uploaded_file($temp_image, $destination);

        
        if(!$upload_image)
        {
            echo "Image upload failed.";
            die();
        }
    }

    // Update listing in database
   $update_sql = "UPDATE listings SET
    title = '$title',
    description = '$description',
    price = '$price',
    quant = '$quant',
    location = '$location',
    image_name = '$updated_image'
WHERE listings_id = $id";

    // Execute update query
    $update_res = mysqli_query($conn, $update_sql);

    // Redirect after successful update
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