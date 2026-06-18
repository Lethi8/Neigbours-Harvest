<?php
include('partials/menu.php');

if(isset($_POST['submit']))
{
    $listings_id = $_POST['listings_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $quant = $_POST['quant'];

    $featured = isset($_POST['featured']) ? $_POST['featured'] : 'No';
    $active = isset($_POST['active']) ? $_POST['active'] : 'No';

    $current_image = $_POST['current_image'];
    $image_name = $current_image;

    if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != "")
    {
        $image_name_new = $_FILES['image']['name'];

        $ext = pathinfo($image_name_new, PATHINFO_EXTENSION);

        $image_name = "Listing-".rand(1000,9999).".".$ext;

        $src_path = $_FILES['image']['tmp_name'];
        $destination_path = "../images/".$image_name;

        $upload = move_uploaded_file($src_path, $destination_path);

        if($upload == false)
        {
            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";

            echo "<script>
                    window.location.href='".SITEURL."admin/manage-listings.php';
                  </script>";
            exit();
        }

        if($current_image != "")
        {
            $remove_path = "../images/listings/".$current_image;

            if(file_exists($remove_path))
            {
                unlink($remove_path);
            }
        }
    }

    $sql3 = "UPDATE listings SET
                title='$title',
                description='$description',
                price='$price',
                quant='$quant',
                image_name='$image_name',
                featured='$featured',
                active='$active'
            WHERE listings_id='$listings_id'";

    $res3 = mysqli_query($conn, $sql3);

    if($res3)
    {
        $_SESSION['update'] = "<div class='success'>Listing Updated Successfully.</div>";
    }
    else
    {
        $_SESSION['update'] = "<div class='error'>Failed to Update Listing.</div>";
    }

    echo "<script>
            window.location.href='".SITEURL."admin/manage-listings.php';
          </script>";
    exit();
}

if(isset($_GET['listings_id']))
{
    $listings_id = $_GET['listings_id'];

    $sql2 = "SELECT * FROM listings WHERE listings_id='$listings_id'";
    $res2 = mysqli_query($conn, $sql2);

    if(mysqli_num_rows($res2) == 1)
    {
        $row2 = mysqli_fetch_assoc($res2);

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
        echo "<script>
                window.location.href='".SITEURL."admin/manage-listings.php';
              </script>";
        exit();
    }
}
else
{
    echo "<script>
            window.location.href='".SITEURL."admin/manage-listings.php';
          </script>";
    exit();
}
?>

<div class="main-content">
    <div class="wrapper">

        <h1>Update Listing</h1>

        <br><br>

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
                            <img src="<?php echo SITEURL; ?>images/listings/<?php echo $current_image; ?>" width="150">
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
                        <input
                            <?php if($featured == "Yes"){ echo "checked"; } ?>
                            type="radio"
                            name="featured"
                            value="Yes"> Yes

                        <input
                            <?php if($featured == "No"){ echo "checked"; } ?>
                            type="radio"
                            name="featured"
                            value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input
                            <?php if($active == "Yes"){ echo "checked"; } ?>
                            type="radio"
                            name="active"
                            value="Yes"> Yes

                        <input
                            <?php if($active == "No"){ echo "checked"; } ?>
                            type="radio"
                            name="active"
                            value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="listings_id" value="<?php echo $listings_id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                        <input
                            type="submit"
                            name="submit"
                            value="Update Listing"
                            class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

    </div>
</div>

<?php include('partials/footer.php'); ?>
