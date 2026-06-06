<?php
include('config/constants.php');
include('partials-frontend/menu.php');

$seller_Id = isset($_SESSION['user_Id']) ? (int)$_SESSION['user_Id'] : 0;
?>

<br>

<section class="produce-search text-center">
    <div class="container">

        <form id="searchForm">
            <input type="search" id="searchInput" placeholder="Search products or location">
            <br>
            <input type="submit" value="Search" class="btn contactSeller">
        </form>

    </div>
</section>

<section class="categories" id="exploreSection">
    <div class="container">

        <h2 class="text-center">Explore</h2>

        <a href="#">
            <div class="box-3 float-container">
                <img src="images/fruit_category.jfif" class="img-responsive img-curve">
                <h3 class="float-text text-white">Fruits</h3>
            </div>
        </a>

        <a href="#">
            <div class="box-3 float-container">
                <img src="images/veggie_category.jfif" class="img-responsive img-curve">
                <h3 class="float-text text-white">Veggies</h3>
            </div>
        </a>

        <a href="#">
            <div class="box-3 float-container">
                <img src="images/herbs.jfif" class="img-responsive img-curve">
                <h3 class="float-text text-white">Herbs</h3>
            </div>
        </a>

        <div class="clearfix"></div>

    </div>
</section>

<section class="produce-menu" id="produceSection">
    <div class="container">

        <h2 class="text-center">Produce</h2>

        <div id="noResults" class="error" style="display:none;">
            Product not listed.
        </div>

        <?php
        $sql = "SELECT
                    l.listings_id,
                    l.title,
                    l.description,
                    l.price,
                    l.image_name,
                    l.quant,
                    l.location,
                    l.user_Id,
                    u.username,
                    u.full_name
                FROM listings l
                INNER JOIN users u ON l.user_Id = u.user_Id
                WHERE l.user_Id != $seller_Id
                ORDER BY l.listings_id DESC";

        $res = mysqli_query($conn, $sql);

        if ($res && mysqli_num_rows($res) > 0)
        {
            while ($row = mysqli_fetch_assoc($res))
            {
        ?>

        <div class="produce-menu-box productItem"
             data-title="<?php echo strtolower($row['title']); ?>"
             data-location="<?php echo strtolower($row['location']); ?>">

            <div class="produce-menu-img">

                <?php
                if ($row['image_name'] == "")
                {
                    echo "<div class='error'>Image not available</div>";
                }
                else
                {
                ?>
                    <img src="<?php echo SITEURL; ?>images/<?php echo $row['image_name']; ?>"
                         class="img-responsive img-curve">
                <?php
                }
                ?>

            </div>

            <div class="produce-menu-desc">

                <h4 class="productName"><?php echo $row['title']; ?></h4>

                <p class="seller-desc">
                    Seller: <?php echo $row['full_name']; ?>
                </p>

                <p class="posted-time">
                    Location: <?php echo $row['location']; ?>
                </p>

                <p class="produce-price">
                    R<?php echo $row['price']; ?>
                </p>

                <p class="produce-detail">
                    <?php echo $row['description']; ?>
                </p>

                <p class="availability">
                    <?php
                    if ($row['quant'] > 0)
                    {
                        echo "<span style='color:green;'>{$row['quant']} items left</span>";
                    }
                    else
                    {
                        echo "<span style='color:red;'>Out of stock</span>";
                    }
                    ?>
                </p>

                <br>

                <?php if ($row['quant'] > 0) { ?>

                    <a href="add-to-cart.php?listings_id=<?php echo $row['listings_id']; ?>" class="btn button">
                        Add to Cart
                    </a>

                <?php } else { ?>

                    <a class="btn button">
                        Out of Stock
                    </a>

                <?php } ?>

                <a href="contact-seller.php?listings_id=<?php echo $row['listings_id']; ?>" class="btn button">
                    Contact Seller
                </a>

            </div>

        </div>

        <?php
            }
        }
        else
        {
            echo "<div class='error'>No listings available.</div>";
        }
        ?>

        <div class="clearfix"></div>

    </div>
</section>

<script>
document.getElementById("searchForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let searchValue = document.getElementById("searchInput").value.toLowerCase().trim();

    let products = document.querySelectorAll(".productItem");
    let explore = document.getElementById("exploreSection");
    let noResults = document.getElementById("noResults");

    let found = false;

    if (searchValue === "") {
        explore.style.display = "block";
        noResults.style.display = "none";

        products.forEach(function(item) {
            item.style.display = "block";
        });

        return;
    }

    explore.style.display = "none";

    products.forEach(function(item) {

        let title = item.dataset.title;
        let location = item.dataset.location;

        if (title.includes(searchValue) || location.includes(searchValue)) {
            item.style.display = "block";
            found = true;
        } else {
            item.style.display = "none";
        }

    });

    noResults.style.display = found ? "none" : "block";
});
</script>

<?php include('partials-frontend/footer.php'); ?>