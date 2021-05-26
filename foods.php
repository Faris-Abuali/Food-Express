<?php include("partials-front/menu.php"); ?>


<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <form action="<?php echo SITE_URL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-search btn-primary">
        </form>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->



<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        // Diplay "active" foods from DB (from tbl_food)
        $sql = "SELECT * FROM tbl_food WHERE active='yes'";

        //Execute the query
        $res = mysqli_query($conn, $sql);

        //Count rows of the result set 
        $count = mysqli_num_rows($res);

        //check wether there are available food or not
        if ($count > 0) {
            //there are availabe "active" food
            //food available

            while ($row = mysqli_fetch_assoc($res)) {

                $id = $row['id'];
                $title = $row['title'];
                $description = $row['description'];
                $image_name = $row['image_name'];
                $price = $row['price'];
        ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php
                        //check wether this food has inage_name or not
                        if ($image_name == "") {
                            //no image for this food item
                            echo "<div class='error'>No Food Image</div>";
                        } else {
                        ?>
                            <img src="<?php echo SITE_URL; ?>images/food/<?php echo $image_name ?>" alt="<?php echo $image_name; ?>" class="img-responsive img-curve" width="90" height="95">

                        <?php
                        }
                        ?>
                    </div>

                    <div class=" food-menu-desc">
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
            echo "<div class='error text-center'>No Available Food Items</div>";
        }


        ?>

        <!-- <div class="food-menu-box">
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
        </div> -->
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