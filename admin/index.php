
<?php 

include ('partials/menu.php');
include ('partials/logincheck.php');

?> 

<!-- Main Content Section Starts -->
<div class="main-content">
 <div class="wrapper">
        <h1> DASHBOARD </h1>
      <br><br>
         <?php
         if(isset($_SESSION['login'])){
         echo $_SESSION['login'];
         unset($_SESSION['login']);
         }
         ?>
         <Br><br>

     <div class="col-4 text-center">
         
         <?php
         //sql query
         $sql = "SELECT * FROM users";
         
         //execute query
         $res = mysqli_query($conn, $sql);
         
         //counts rows of users
         $count = mysqli_num_rows($res);
         ?>
        <h1><?php echo $count; ?></h1>
        <br>
        Total Users
        </div>

     <div class="col-4 text-center">
         
         <?php
         //sql query
         $sql2 = "SELECT * FROM listings";
         
         //execute query
         $res2 = mysqli_query($conn, $sql2);
         
         //counts rows of listings
         $count2 = mysqli_num_rows($res2);
         ?>
         
        <h1><?php echo $count2; ?></h1>
        <br>
        Total Listings
        </div>

     <div class="col-4 text-center">
         
          <?php
         //sql query
         $sql3 = "SELECT * FROM orders";
         
         //execute query
         $res3 = mysqli_query($conn, $sql3);
         
         //counts rows of listings
         $count3 = mysqli_num_rows($res3);
         ?>
        <h1><?php echo $count3; ?></h1>
        <br>
        Total Orders
        </div>

     <div class="col-4 text-center">
          <?php
         //sql query
         $sql4 = "SELECT * FROM orders WHERE status = 'Completed'";
         
         //execute query
         $res4 = mysqli_query($conn, $sql4);
         
         //counts rows of listings
         $count4 = mysqli_num_rows($res4);
         ?>
        
         
        <h1><?php echo $count4; ?></h1>
        <br>
        Completed Orders
        </div>
    </div>

    <div class="clearfix"></div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php');?>