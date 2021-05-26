<?php include("partials-front/menu.php"); ?>


<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <?php
        if (isset($_POST['submit'])) {
            //Get the search keyword
            $search = $_POST['search'];
            $search = strtolower($search);
        } else {
            //redirect to "food.php" because this is not the right way to enter the "food-seach.php" page
            header("location:" . SITE_URL . "foods.php");
        }
        ?>

        <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->



<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        //SQL query to get food based on search keyword
        $sql = "SELECT * FROM tbl_food WHERE LOWER(title) LIKE '%$search%' OR LOWER(description) LIKE '%$search%'";

        //Execute the query
        $res = mysqli_query($conn, $sql);

        //Count rows to check wether there are records returned from the result set or the result set is empty
        $count = mysqli_num_rows($res);

        if ($count > 0) {
            //there are food records matching the search keyword

            while ($row = mysqli_fetch_assoc($res)) {

                //Get the details of this food record
                $id = $row['id'];
                $title = $row['title'];
                $description = $row['description'];
                $price = $row['price'];
                $image_name = $row['image_name'];

        ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">

                        <?php
                        //Check wether this food item has image or not
                        if ($image_name == "") {
                            //food item has no image
                            echo "<div class='error'>No Food Image</div>";
                        } else {
                            //image available
                        ?>
                            <img src="<?php echo SITE_URL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $image_name; ?>" class="img-responsive img-curve" width="90" height="95">

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

                        <a href="<?php echo SITE_URL; ?>order.php?id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                    </div>
                </div>
        <?php
            }
        } else {
            //no food records mathcing the searh keyword
            echo "<div class='error text-center'>No Food Items Mathing The Seach Keyword</div>";
        }

        ?>


        <!-- <div class="food-menu-box">
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
            </div> -->
    </div>


    <div class="clearfix"></div>



    </div>

</section>
<!-- fOOD Menu Section Ends Here -->

<?php include("partials-front/footer.php"); ?>