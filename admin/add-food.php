<?php include("partials/menu.php"); ?>

<!-- BOOTSTRAP 3 -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->

<!-- BOOTSTRAP 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

<script type="text/javascript">
    function alertSuccess() {
        // alert("Hello");
        Swal.fire(
            'Success!',
            'Added Food Item',
            'success'
        )
    }

    function alertFailure() {
        // alert("Hello");
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong! Failed to Add Food Item',
            footer: '<a href="#">Try Again?</a>'
        })
    }
</script>


<div class="main-content">

    <div class="wrapper">


        <div class="row form-group">
            <h1>Add Food</h1>
        </div>

        <br>
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <!-- Add Food Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data">
            <!-- Process the form in this same page -->


            <!-- Title -->
            <div class="form-group">
                <div class=" form-group">
                    <label for="title">Title</label><br />
                    <input type="text" name="title" id="title" required class="form-control" placeholder="give a title for this food item..">
                </div>
            </div>
            <br>

            <!-- Description -->
            <div class="form-group">
                <div class=" form-group">
                    <label for="description">Description</label><br />
                    <textarea name="description" rows="3" id="description" required class="form-control" placeholder="Describe this food item.."></textarea>
                </div>
            </div>
            <br>


            <!-- Price -->
            <div class="form-group">
                <div class=" form-group">
                    <label for="price">Price</label><br />
                    <input type="number" name="price" id="price" class="form-control" min="0" step="0.01">
                </div>
            </div>
            <br>

            <!-- image_name -->
            <div class="form-group">
                <div class=" form-group">
                    <label for="img">Select Image</label><br />
                    <input type="file" name="image" id="img" class="form-control-file">
                </div>
            </div>
            <br>

            <!-- Category_id -->
            <label for="category">Select Category</label><br />
            <select name="category" class="form-select">
                <?php
                //Display only active categories from table "tbl_categories"

                $sql = "SELECT * FROM tbl_category WHERE active='yes' ORDER BY title ASC";

                //Execute the query:
                $res = mysqli_query($conn, $sql);


                //Count the rows to chexk wether we have categories or not:
                $count = mysqli_num_rows($res);

                if ($count > 0) {
                    //Then tere are "active" categories available in the DB (in tbl_category)
                    while ($row = mysqli_fetch_assoc($res)) {

                        //get the details of this category record
                        $id = $row['id'];
                        $title = $row['title'];
                ?>
                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                    <?php
                    }
                } else {
                    //then there are no "active" categories availabe in the DB (in tbl_category)
                    ?>
                    <option value="0">No Active Categories Available</option>
                <?php
                }
                ?>
            </select>
            <br>

            <!-- Featured -->
            <div class="form-group">
                <h6>Featured?</h6>

                <div class=" form-check" style="display: inline-block; margin-right: 20px">
                    <input class="form-check-input" type="radio" name="featured" required id="f_yes" value="yes">
                    <label for="f_yes">yes</label>
                </div>

                <div class=" form-check" style="display: inline-block; margin-right: 20px">
                    <input class="form-check-input" type="radio" name="featured" required id="f_no" value="no">
                    <label for="f_no">no</label>
                </div>
            </div>
            <br>

            <!-- Active -->
            <div class="form-group">
                <h6>Active?</h6>

                <div class=" form-check" style="display: inline-block; margin-right: 20px">
                    <input class="form-check-input" type="radio" name="active" required id="active_yes" value="yes">
                    <label for="active_yes">yes</label>
                </div>

                <div class=" form-check" style="display: inline-block; margin-right: 20px">
                    <input class="form-check-input" type="radio" name="active" required id="active_no" value="no">
                    <label for="active_no">no</label>
                </div>
            </div>
            <br>

            <div class="form-actions">
                <input type="submit" name="submit" value="Add Food" class="btn btn-outline-success">
            </div>
        </form>
        <!-- Add Food Form Ends -->


        <?php

        if (isset($_POST['submit'])) {
            //Add the food item to DB

            //1.  Get the data from the form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];


            //2. Upload the image if selecte
            //Check wether the "select image" is clicked or not
            if (isset($_FILES['image']['name'])) {

                //Get the details of the selected image
                $image_name = $_FILES['image']['name'];
                //Check wether image is selected or not, because clicking the button
                // called "choose image" and then clickin "cancel" will set the 
                //$_FILES['image']['name'] but the name will be blank string!

                if ($image_name != "") {
                    //Then now I am 100% sure that the user has chosen a file without canelling

                    //A. Rename the image
                    $separator = ".";
                    //Get extension of the img (.jpg, .png, .gif, etc...)
                    $arr = explode($separator, $image_name);
                    $extension = end($arr);

                    $image_name = "Food_Item_" . rand(000, 999) . '.' . $extension;

                    //B. upload the image
                    $source_path = $_FILES['image']['tmp_name']; //the current location of the image

                    //We need to get out of "admin" folder, then enter "images" folder, 
                    //then inside it will be "food" folder
                    $destination_path = "../images/food/" . $image_name;

                    //Finally upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    //Check wether the image is uploaded or not:
                    //if the image is not uploaded then we will stop the process and
                    // redirect with error message

                    if ($upload == FALSE) {

                        //Set error message
                        $_SESSION['upload'] = "<div class='error text-center'>Failed to upload image</div>";

                        //Redirect to add-category page
                        header('location:' . SITE_URL . 'admin/add-food.php');
                        //Stop the process, because if we failed to upload the image
                        // then we don't want the data to be inserted into the DB
                        die();
                    }
                }
            } else {
                //Don't upload image, and set the image name value as blank
                $image_name = "";
            }

            //3. Insert into DB
            //Create sql to insert data into tbl_food
            $sql2 = "INSERT INTO tbl_food SET
             title='$title',
             description='$description',
             price=$price,
             image_name='$image_name',
             category_id='$category',
             featured='$featured',
             active='$active'
             ";

            //Exequte the query
            $res2 = mysqli_query($conn, $sql2);

            //Check wether data is inserted successfully
            if ($res2 == TRUE) {
                //data inserted sucessfully

                //Display a success message in manage-category.php

                $_SESSION['add'] = "<div class='success text-center'>Success! Food Item Added</div>";

                // //SweetAlert2 Show success message
                echo '<script type="text/javascript">',
                'alertSuccess();',
                '</script>';


                //Redirect to manage-food.php
                //header("location:" . SITE_URL . "admin/manage-food.php");
                //header("refresh:1;url=" . SITE_URL . "admin/manage-category.php");
            } else {
                // failed to add category

                //Display a nerror message

                $_SESSION['add'] = "<div class='error text-center'>Error! Failed to add food item</div>";

                //SweetAlert2 Show error message
                echo '<script type="text/javascript">',
                'alertFailure();',
                '</script>';

                //Redirect to manage-food.php 
                //header("location:" . SITE_URL . "admin/manage-food.php");
            }

            //4. Redirect with message to manage-food.php
        }
        ?>

    </div>
</div>


<?php include("partials/footer.php"); ?>