<?php include("partials-front/menu.php"); ?>

<?php
//Check wether category_id is passed or not
if (isset($_GET['category_id'])) {
    //category_id is passed through the URL string
    $category_id = $_GET['category_id'];

    //Get the category title based on category_id
    $sql = "SELECT title from tbl_category WHERE id='$category_id'";

    //Execute the query
    $res = mysqli_query($conn, $sql);

    //Get the record 
    $row = mysqli_fetch_assoc($res);


    $category_title = $row['title'];
} else {
    //Redirect to homepage
    header("location:" . SITE_URL);
}
?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->



<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        //Create SQL query to get food items that belong to the category whose id is obtained
        //from  the URL using GET
        $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";

        //Execute the query
        $res2 = mysqli_query($conn, $sql2);

        //count the rows to check wether there are food records belonging to the
        //passed category_id
        $count = mysqli_num_rows($res2);

        if ($count > 0) {
            //get all food records from the result set and display them
            while ($row2 = mysqli_fetch_assoc($res2)) {

                $id = $row2['id'];
                $title = $row2['title'];
                $description = $row2['description'];
                $price = $row2['price'];
                $image_name = $row2['image_name'];
        ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">

                        <?php
                        if ($image_name == "") {
                            //then the food item has no image
                            echo "<div class='error text-center'>No Food Image</div>";
                        } else {
                            // the food item has an image
                        ?>
                            <img src="<?php echo SITE_URL ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $image_name; ?>" class="img-responsive img-curve" width="90" height="95">
                        <?php
                        }
                        ?>

                    </div>

                    <div class="food-menu-desc">
                        <h4><?php echo $title; ?></h4>
                        <p class="food-price">$<?php echo $price; ?></p>
                        <p class="food-detail">
                            <?php echo $description; ?>
                        </p>
                        <br>

                        <a href="<?php echo SITE_URL; ?>order.php?id=<?php echo $id; ?>" class="btn btn-primary btn-order-now">Order Now</a>
                    </div>
                </div>
        <?php

            }
        } else {
            //no food records matchig the category_id
            echo "<div class='error text-center'>No Food Items Matching The Passed Category_ID</div>";
        }

        ?>


        <!-- 
        <div class="food-menu-box">
            <div class="food-menu-img">
                <img src="images/menu-burger.jpg" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
            </div>

            <div class="food-menu-desc">
                <h4>Smoky Burger</h4>
                <p class="food-price">$2.3</p>
                <p class="food-detail">
                    Made with Italian Sauce, Chicken, and organice vegetables.
                </p>
                <br>

                <a href="#" class="btn btn-primary">Order Now</a>
            </div>
        </div>

        <div class="food-menu-box">
            <div class="food-menu-img">
                <img src="images/menu-burger.jpg" alt="Chicke Hawain Burger" class="img-responsive img-curve">
            </div>

            <div class="food-menu-desc">
                <h4>Nice Burger</h4>
                <p class="food-price">$2.3</p>
                <p class="food-detail">
                    Made with Italian Sauce, Chicken, and organice vegetables.
                </p>
                <br>

                <a href="#" class="btn btn-primary">Order Now</a>
            </div>
        </div>

        <div class="food-menu-box">
            <div class="food-menu-img">
                <img src="images/menu-pizza.jpg" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
            </div>

            <div class="food-menu-desc">
                <h4>Food Title</h4>
                <p class="food-price">$2.3</p>
                <p class="food-detail">
                    Made with Italian Sauce, Chicken, and organice vegetables.
                </p>
                <br>

                <a href="#" class="btn btn-primary">Order Now</a>
            </div>
        </div>

        <div class="food-menu-box">
            <div class="food-menu-img">
                <img src="images/menu-pizza.jpg" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
            </div>

            <div class="food-menu-desc">
                <h4>Food Title</h4>
                <p class="food-price">$2.3</p>
                <p class="food-detail">
                    Made with Italian Sauce, Chicken, and organice vegetables.
                </p>
                <br>

                <a href="#" class="btn btn-primary">Order Now</a>
            </div>
        </div>

        <div class="food-menu-box">
            <div class="food-menu-img">
                <img src="images/menu-momo.jpg" alt="Chicke Hawain Momo" class="img-responsive img-curve">
            </div>

            <div class="food-menu-desc">
                <h4>Chicken Steam Momo</h4>
                <p class="food-price">$2.3</p>
                <p class="food-detail">
                    Made with Italian Sauce, Chicken, and organice vegetables.
                </p>
                <br>

                <a href="#" class="btn btn-primary">Order Now</a>
            </div>
        </div> -->


        <div class="clearfix"></div>



    </div>

</section>
<!-- fOOD Menu Section Ends Here -->

<?php include("partials-front/footer.php"); ?>