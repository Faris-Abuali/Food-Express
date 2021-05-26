<?php include('partials/menu.php'); ?>


<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Dashboard</h1>
        <br>
        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        ?>


        <div class="col-4 text-center">
            <?php
            //SQL Query
            $sql = "SELECT * FROM tbl_category";
            //Execute Query
            $res = mysqli_query($conn, $sql);
            //Count the number of records in tbl_category
            $count = mysqli_num_rows($res);
            ?>
            <h1><?php echo $count; ?></h1>
            <br />
            Categories
        </div>

        <div class="col-4 text-center">
            <?php
            //SQL Query
            $sql2 = "SELECT * FROM tbl_food";
            //Execute Query
            $res2 = mysqli_query($conn, $sql2);
            //Count the number of records in tbl_food
            $count2 = mysqli_num_rows($res2);
            ?>
            <h1><?php echo $count2; ?></h1>
            <br />
            Food Items
        </div>

        <div class="col-4 text-center">
            <?php
            //SQL Query
            $sql3 = "SELECT * FROM tbl_order";
            //Execute Query
            $res3 = mysqli_query($conn, $sql3);
            //Count the number of records in tbl_order
            $count3 = mysqli_num_rows($res3);
            ?>
            <h1><?php echo $count3; ?></h1>
            <br />
            Orders
        </div>

        <div class="col-4 text-center">
            <?php
            //Create SQL query to get total revenue
            //Using Aggregate Function in SQL
            $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";

            //Execute Query
            $res4 = mysqli_query($conn, $sql4);

            //Get the value from the result set
            $row = mysqli_fetch_assoc($res4);

            //Get the total revenue
            $total_revenue = $row['Total'];
            ?>
            <h1>$<?php echo $total_revenue; ?></h1>
            <br />
            Revenue Generated
        </div>


        <div class="clearfix"></div>
    </div>

</div>
<!-- Main Content Section Ends  -->

<?php include('partials/footer.php'); ?>