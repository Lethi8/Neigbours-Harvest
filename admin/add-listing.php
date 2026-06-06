<?php include('partials/menu.php'); ?>

<div class="main-content"> 
<div class="wrapper">

<h1>Add Listing</h1>

<br><br>

<?php 
if(isset($_SESSION['upload']))
{
    echo $_SESSION['upload'];
    unset($_SESSION['upload']);
}
?>

<form action="" method="POST" enctype="multipart/form-data">
<table class="tbl-30">

    <tr>
        <td>User ID:</td>
        <td>
            <input type="number" name="user_id" required>
        </td>
    </tr>

    <tr>
        <td>Title:</td>
        <td>
            <input type="text" name="title" placeholder="Enter listing title" required>
        </td>
    </tr>

    <tr>
        <td>Description:</td>
        <td>
            <textarea name="description" cols="30" rows="5" placeholder="Enter details" required></textarea>
        </td>
    </tr>

    <tr>
        <td>Price:</td>
        <td>
            <input type="number" name="price" step="0.01" placeholder="Enter Price" required>
        </td>
    </tr>

    <tr>
        <td>Quantity:</td>
        <td>
            <input type="number" name="quant" placeholder="Enter quantity available" required>
        </td>
    </tr>

    <tr>
        <td>Image:</td>
        <td>
            <input type="file" name="image">
        </td>
    </tr>

    <tr>
        <td>Featured:</td>
        <td>
            <input type="radio" name="featured" value="Yes"> Yes
            <input type="radio" name="featured" value="No"> No
        </td>
    </tr>

    <tr>
        <td>Active:</td>
        <td>
            <input type="radio" name="active" value="Yes"> Yes
            <input type="radio" name="active" value="No"> No
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <input type="submit" name="submit" value="Add Listing" class="btn-secondary">
        </td>
    </tr>

</table>
</form>

</div>
</div>

<?php include('partials/footer.php'); ?>


<?php  

// Process form submission
if(isset($_POST['submit']))
{
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $user_id = $_POST['user_id'];
    $quant = $_POST['quant'];

    $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
    $active = isset($_POST['active']) ? $_POST['active'] : "No";

    $image_name = "";

    // Image upload
    if(isset($_FILES['image']['name']))
    {
        $image_name = $_FILES['image']['name'];

        if($image_name != "")
        {
            $ext = pathinfo($image_name, PATHINFO_EXTENSION);

            $image_name = "Listing-".rand(0000,9999).".".$ext;

            $src = $_FILES['image']['tmp_name'];
            $destination = "../images/listings/".$image_name;

            $upload = move_uploaded_file($src, $destination);

            if($upload == false)
            {
                $_SESSION['upload'] = "<div class='error'>Failed To Upload Image.</div>";
                header('location:'.SITEURL.'admin/add-listing.php');
                die();
            }
        }
    }

    // Insert into listings table
    $sql2 = "INSERT INTO listings SET
        title = '$title',
        description = '$description',
        price = '$price',
        quant = '$quant',
        image_name = '$image_name',
        featured = '$featured',
        active = '$active',
        user_id = '$user_id'
    ";

    $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

    if($res2 == true)
    {
        $_SESSION['add'] = "<div class='success'>Listing Added Successfully.</div>";
        header("location:".SITEURL.'admin/manage-listings.php');
    }
    else
    {
        $_SESSION['add'] = "<div class='error'>Failed to Add Listing.</div>";
        header("location:".SITEURL.'admin/add-listing.php');
    }
}
?>