<!-- BOOTSTRAP 5 -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script> -->


<?php include("partials-front/menu.php"); ?>

<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php
        //Display all active categories from the DB (from tbl_category)

        $sql = "SELECT * FROM tbl_category WHERE active='yes'";

        //execute the query
        $res = mysqli_query($conn, $sql);

        //Count the rows of the result set
        $count = mysqli_num_rows($res);

        //Check wether ther are active categories or not
        if ($count > 0) {
            //there are active categories

            while ($row = mysqli_fetch_assoc($res)) {

                $id = $row['id'];
                $title = $row['title'];
                $image_name = $row['image_name'];

        ?>
                <a href="<?php echo SITE_URL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                    <div class="box-3 float-container">
                        <?php
                        if ($image_name == "") {
                            //the categpry has no image
                            echo "<div class='error'>No Image</div>";
                        } else {
                            //display the category's image
                        ?>
                            <img src="<?php echo SITE_URL; ?>images/category/<?php echo $image_name; ?>" alt="<?php echo $image_name ?>" class="img-responsive img-curve" width="283" height="354">
                        <?php
                        }
                        ?>


                        <h3 class="float-text text-white text-center"><?php echo $title; ?></h3>
                    </div>
                </a>

        <?php
            }
        } else {
            echo "<div class='error text-center'>No Active Categories</div>";
        }

        ?>
        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<?php include("partials-front/footer.php"); ?>