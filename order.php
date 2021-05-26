<?php include("partials-front/menu.php"); ?>

<?php
//Check wether food_id is set or not
if (isset($_GET['id'])) {
    $food_id = $_GET['id'];

    //Then get the food id and all other details of this food
    $sql = "SELECT * FROM tbl_food WHERE id=$food_id";

    //Execute the query
    $res = mysqli_query($conn, $sql);

    //Count the rows of the result set
    $count = mysqli_num_rows($res);

    if ($count == 1) {
        //Then there is a food item matching this food_id

        //Get the data of this food item from DB (from tbl_food)
        $row = mysqli_fetch_assoc($res);

        $title = $row['title'];
        // $description = $row['description'];
        $price = $row['price'];
        $image_name = $row['image_name'];
    } else {
        //No food item available with this food_id

        //redirect to homepage because the passed food_id is wrong
        //header("location:" . SITE_URL);
    }
} else {
    //redirect to homepage
    header("location:" . SITE_URL);
}
?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search">
    <div class="container">

        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="" class="order" method="POST">
            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-menu-img">
                    <?php
                    //Check wether the food item has an image or not
                    if ($image_name == "") {
                        //then the food item has no image
                        echo "<div class='error text-center'>No Food Image</div>";
                    } else {
                    ?>
                        <img src="<?php echo SITE_URL ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $image_name; ?>" class="img-responsive img-curve" width="100" height=105>
                    <?php
                    }
                    ?>
                </div>

                <div class="food-menu-desc">
                    <h3><?php echo $title; ?></h3>
                    <input type="hidden" name="food" value="<?php echo $title; ?>">
                    <p class="food-price">$<?php echo $price; ?></p>
                    <input type="hidden" name="price" value="<?php echo $price; ?>">

                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required min="1" max="10">

                </div>

            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. Fares Abuali" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 059-256-6124" class="input-responsive" required pattern="[0-9]{10}">

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. fares@gmail.com" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>

        </form>

        <?php
        //Check wether submit button is clicked or not
        if (isset($_POST['submit'])) {
            //Then get all the details from the form:

            //Remember that we POSTED hidden inputs: (name=food "title") and (name=price)

            $food = $_POST['food'];
            $price = $_POST['price'];
            $qty =  $_POST['qty'];

            $total = $price * $qty; // total price = price * quantity

            $order_date = date("Y-m-d h:i:sa"); //order date (will get the current date and time)
            // Year - Month - Day Hour:Minute:Second AM/PM

            $status = "Ordered"; // [Ordered, On Delivery, Delivered, Cancelled]

            $customer_name = $_POST['full-name'];
            $customer_contact = $_POST['contact'];
            $customer_email = $_POST['email'];
            $customer_address = $_POST['address'];

            //Save the order in DB (in tbl_order)
            $sql2 = "INSERT INTO tbl_order SET
                food='$food',
                price=$price,
                qty=$qty,
                total=$total,
                order_date='$order_date',
                status='$status',
                customer_name='$customer_name',
                customer_contact='$customer_contact',
                customer_email='$customer_email',
                customer_address='$customer_address'
                ";


            //Execute the query
            $res2 = mysqli_query($conn, $sql2);

            //Check wether query executed successfully or not
            if ($res2 == TRUE) {
                //Then query executed (data inserted to tbl_category)
                $_SESSION['order'] = "<div class='success text-center'>Success! Order Confirmed</div>";

                //Redirect to homepage
                header("location:" . SITE_URL);
            } else {
                // failed to save order 
                $_SESSION['order'] = "<div class='error text-center'>Error! Order Failed</div>";
                //Redirect to homepage
                header("location:" . SITE_URL);
            }
        }
        ?>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<?php include("partials-front/footer.php"); ?>