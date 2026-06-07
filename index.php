<?php
include('config/constants.php');
include('partials-frontend/menu.php');

$seller_Id = isset($_SESSION['user_Id']) ? (int)$_SESSION['user_Id'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Website</title>

   <style>
* {
    margin: 0;
    padding: 0;
    font-family: Arial, Helvetica, sans-serif;
    box-sizing: border-box;
}

.container {
    width: 80%;
    margin: 0 auto;
    padding: 1%;
    background-color: #ffffff;
}

.img-responsive { width: 100%; }
.img-curve { border-radius: 15px; }

.text-right { text-align: right; }
.text-center { text-align: center; }
.text-left { text-align: left; }

.clearfix { clear: both; }

a {
    color: #555;
    text-decoration: none;
}

a:hover {
    color: #000;
}

h2 {
    color: #2f3542;
    font-size: 2rem;
    margin-bottom: 2%;
}

.btn {
    padding: 8px 12px;
    border: none;
    font-size: 0.9rem;
    border-radius: 6px;
    cursor: pointer;
    margin-top: 6px;
    display: inline-block;
}

.btn-primary {
    background-color: #2e7d32;
    color: white;
}

.btn-primary:hover {
    background-color: #1b5e20;
}

.navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 20px;
    background-color: #fff;
    border-bottom: 1px solid #ddd;
}

.nav-container {
    width: 90%;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo img {
    height: 32px;
    width: auto;
    object-fit: contain;
}

.nav-links {
    display: flex;
    align-items: center;
    list-style: none;
    gap: 18px;
}

.nav-links li {
    display: flex;
    align-items: center;
}

.nav-links a {
    display: flex;
    align-items: center;
    padding: 6px 8px;
}

.nav-links a img {
    width: 22px;
    height: 22px;
}

.nav-links a:hover {
    background-color: rgba(0,0,0,0.05);
    border-radius: 5px;
}

.social {
    background-color: #f4f4f4;
    padding: 20px 0;
}

.social ul {
    list-style: none;
    display: flex;
    justify-content: center;
    gap: 15px;
}

.social img {
    width: 50px;
    height: 50px;
}

.footer {
    background-color: #222;
    padding: 15px 0;
}

.footer p {
    color: white;
    font-size: 0.9rem;
}

.produce-search {
    background-image: url(../images/BgImage.png);
    background-size: cover;
    background-position: center;
    padding: 7% 0;
}

.produce-search input[type="search"] {
    width: 50%;
    padding: 1%;
    border-radius: 5px;
    border: none;
}

.categories {
    padding: 4% 0;
}

.float-container {
    position: relative;
    overflow: hidden;
    border-radius: 15px;
}

.float-text {
    position: absolute;
    bottom: 10px;
    left: 12px;
    color: white;
    font-size: 1.4rem;
    font-weight: bold;
}

.box-3 {
    width: 28%;
    float: left;
    margin: 2%;
    border-radius: 15px;
    overflow: hidden;
}

.box-3 img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.produce-menu {
    background-color: #f4f4f4;
    padding: 4% 0;
}

.produce-menu-box {
    width: 43%;
    margin: 1%;
    padding: 2%;
    float: left;
    background: #fff;
    border-radius: 15px;
    border: 1px solid #ddd;
}

.produce-menu-img {
    width: 25%;
    float: left;
}

.produce-menu-img img {
    width: 100%;
    height: 90px;
    object-fit: cover;
    border-radius: 10px;
}

.produce-menu-desc {
    width: 70%;
    float: left;
    margin-left: 5%;
}

.productName {
    font-size: 1.1rem;
    font-weight: 600;
}

.produce-price {
    font-size: 1.2rem;
    font-weight: bold;
}

.chat-box {
    background: #fff;
    padding: 15px;
    border-radius: 15px;
}

.chat-messages {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 10px;
    min-height: 200px;
    max-height: 500px;
    overflow-y: auto;
    border: 1px solid #eee;
    border-radius: 10px;
    margin-bottom: 10px;
}

.sent {
    align-self: flex-end;
    background: #4CAF50;
    color: #fff;
    padding: 10px 14px;
    border-radius: 15px 15px 0 15px;
    max-width: 60%;
    word-wrap: break-word;
}

.received {
    align-self: flex-start;
    background: #e5e5e5;
    color: #333;
    padding: 10px 14px;
    border-radius: 15px 15px 15px 0;
    max-width: 60%;
    word-wrap: break-word;
}

.sent small,
.received small {
    display: block;
    font-size: 10px;
    margin-top: 5px;
    opacity: 0.7;
}

.msg-name {
    font-size: 11px;
    font-weight: 600;
    margin-bottom: 3px;
    opacity: 0.8;
}

.product-summary {
    display: flex;
    gap: 15px;
    align-items: center;
    margin-bottom: 20px;
}

.product-summary img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 10px;
}

.chat-input {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.chat-input input {
    flex: 1;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
}

.chat-input button {
    padding: 10px 15px;
    background: #2e7d32;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.chat-input button:hover {
    background: #1b5e20;
}

.no-messages {
    text-align: center;
    color: #aaa;
    font-size: 14px;
    padding: 30px 0;
}

        @media (max-width: 900px) {
    .container { width: 95%; }
    .box-3, .produce-menu-box {
        width: 100%;
        float: none;
        margin: 10px 0;
    }
}
        
@media (max-width: 768px) {
    .container {
        width: 95%;
    }

    .produce-search input[type="search"] {
        width: 90%;
    }

    .box-3,
    .produce-menu-box {
        width: 100%;
        float: none;
        margin: 10px 0;
    }

    .chat-input {
        flex-direction: column;
    }

    .chat-input button {
        width: 100%;
    }
}

@media (max-width: 480px) {
    h2 {
        font-size: 1.5rem;
    }

    .box-3 img {
        height: 120px;
    }
}
    </style>
</head>

<body>

<section class="produce-search text-center">
    <div class="container">
        <form id="searchForm">
            <input type="search" id="searchInput" placeholder="Search products or location">
            <br><br>
            <input type="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>

<section class="categories" id="exploreSection">
    <div class="container">
        <h2 class="text-center">Explore</h2>

        <div class="box-3 float-container">
            <img src="images/fruit_category.jfif" alt="Fruits">
            <h3 class="float-text">Fruits</h3>
        </div>

        <div class="box-3 float-container">
            <img src="images/veggie_category.jfif" alt="Veggies">
            <h3 class="float-text">Veggies</h3>
        </div>

        <div class="box-3 float-container">
            <img src="images/herbs.jfif" alt="Herbs">
            <h3 class="float-text">Herbs</h3>
        </div>

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
        $sql = "SELECT l.*, u.full_name
                FROM listings l
                INNER JOIN users u ON l.user_Id = u.user_Id
                WHERE l.user_Id != $seller_Id
                ORDER BY l.listings_id DESC";

        $res = mysqli_query($conn, $sql);

        if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
        ?>

        <div class="produce-menu-box productItem"
             data-title="<?php echo strtolower(htmlspecialchars($row['title'])); ?>"
             data-location="<?php echo strtolower(htmlspecialchars($row['location'])); ?>">

            <div class="produce-menu-img">
                <img src="<?php echo SITEURL; ?>images/<?php echo htmlspecialchars($row['image_name']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
            </div>

            <div class="produce-menu-desc">
                <h4 class="productName"><?php echo htmlspecialchars($row['title']); ?></h4>
                <p>Seller: <?php echo htmlspecialchars($row['full_name']); ?></p>
                <p>Location: <?php echo htmlspecialchars($row['location']); ?></p>
                <p class="produce-price">R<?php echo htmlspecialchars($row['price']); ?></p>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <p class="availability">
                    <?php
                    if ($row['quant'] > 0) {
                        echo "<span style='color:green;'>{$row['quant']} items left</span>";
                    } else {
                        echo "<span style='color:red;'>Out of stock</span>";
                    }
                    ?>
                </p>
                <a href="add-to-cart.php?listings_id=<?php echo (int)$row['listings_id']; ?>" class="btn btn-primary">Add to Cart</a>
                <a href="contact-seller.php?listings_id=<?php echo (int)$row['listings_id']; ?>" class="btn btn-primary">Contact Seller</a>
            </div>
        </div>

        <?php } } else { ?>
            <div class="error">No listings available.</div>
        <?php } ?>

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
        products.forEach(item => item.style.display = "block");
        return;
    }

    explore.style.display = "none";

    products.forEach(item => {
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

<section class="social">
    <div class="container text-center">
        <ul>
            <li>
                <a href="#"><img src="https://img.icons8.com/fluent/50/000000/facebook-new.png" alt="Facebook"/></a>
            </li>
            <li>
                <a href="#"><img src="https://img.icons8.com/fluent/48/000000/instagram-new.png" alt="Instagram"/></a>
            </li>
        </ul>
    </div>
</section>

<section class="footer">
    <div class="container text-center">
        <p><a href="admin/admin-login.php">Admin Login</a></p>
        <br>
        <p>Copyright &copy; Neighbours Harvest 2026. All rights reserved.</p>
    </div>
</section>

</body>
</html>
