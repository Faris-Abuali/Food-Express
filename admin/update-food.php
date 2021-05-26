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
            'Updated Food Item',
            'success'
        )
    }

    function alertFailure() {
        // alert("Hello");
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong! Failed to Update Food Item',
            footer: '<a href="#">Try Again?</a>'
        })
    }
</script>



<div class="main-content">

    <div class="wrapper">

        <div class="row form-group">
            <h1>Update Food</h1>
        </div>

        <br><br>

        <?php
        //Check wether the id is set or not
        if (isset($_GET['id'])) {
            //Get the id and all other data of the food item
            $id = $_GET['id'];

            //Create SQL query to get all other details of this category
            $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

            //Execute the query:
            $res2 = mysqli_query($conn, $sql2);

            //Count the rows to check wether the id is valid or not
            $count = mysqli_num_rows($res2);

            if ($count == 1) {
                //Then we will get all the data of this record

                //Get all data
                $row2 = mysqli_fetch_assoc($res2);

                $title = $row2['title'];
                $description = $row2['description'];
                $price = $row2['price'];
                $current_image = $row2['image_name'];
                $current_category = $row2['category_id'];
                $featured = $row2['featured'];
                $active = $row2['active'];
            } else {

                $_SESSION['no-food-found'] = "<div class='error text-center'>Error! Food Not Found</div>";

                // redirect to manage-food, because no such id in the table tbl_food
                header("location:" . SITE_URL . "admin/manage-food.php");
            }
        } else {
            //redirect to manage-food
            header("location:" . SITE_URL . "admin/manage-food.php");
        }
        ?>

        <!-- Update Food Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data" style="width:50%">
            <!-- Process the form in this same page -->

            <!-- Show the current image -->
            <div class="form-group">
                <label for="img">Current Image</label><br />
                <!-- <div class="img-thumbnail"> -->
                <?php
                if ($current_image != "") {
                    //display the image
                    $mySrc = SITE_URL . "images/food/$current_image";
                } else {
                    //display empty image
                    $mySrc = "https://via.placeholder.com/670x300";
                }
                ?>
                <img src="<?php echo $mySrc ?>" id="currImg" class="img-fluid img-thumbnail" alt="food_image" style="width:650px; height:300px">

                <!-- <div class="caption text-center" style="padding: 0px;">
                    <h3>This is title of food</h3>
                </div> -->
                <!-- </div> -->
            </div>


            <!-- Title -->
            <div class="form-group">
                <div class=" form-group">
                    <label for="title">Title</label><br />
                    <input type="text" name="title" id="title" required class="form-control" value="<?php echo $title; ?>">
                </div>
            </div>
            <br>

            <!-- Description -->
            <div class="form-group">
                <div class=" form-group">
                    <label for="description">Description</label><br />
                    <textarea name="description" rows="3" id="description" required class="form-control" style="white-space: pre-wrap;"><?php echo $description; ?></textarea>
                </div>
            </div>
            <br>


            <!-- Price -->
            <div class="form-group">
                <div class=" form-group">
                    <label for="price">Price</label><br />
                    <input type="number" name="price" id="price" class="form-control" min="0" step="0.01" value="<?php echo $price ?>">
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

                $sql = "SELECT * FROM tbl_category WHERE active='yes'";

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
                        <option value="<?php echo $id; ?>" <?php if ($current_category == $id) {
                                                                echo "selected";
                                                            } ?>><?php echo $title; ?></option>
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
                    <input class="form-check-input" type="radio" name="featured" required id="f_yes" value="yes" <?php if ($featured == "yes") {
                                                                                                                        echo "checked";
                                                                                                                    } ?>>
                    <label for="f_yes">yes</label>
                </div>

                <div class=" form-check" style="display: inline-block; margin-right: 20px">
                    <input class="form-check-input" type="radio" name="featured" required id="f_no" value="no" <?php if ($featured == "no") {
                                                                                                                    echo "checked";
                                                                                                                } ?>>
                    <label for="f_no">no</label>
                </div>
            </div>
            <br>

            <!-- Active -->
            <div class="form-group">
                <h6>Active?</h6>

                <div class=" form-check" style="display: inline-block; margin-right: 20px">
                    <input class="form-check-input" type="radio" name="active" required id="active_yes" value="yes" <?php if ($active == "yes") {
                                                                                                                        echo "checked";
                                                                                                                    } ?>>
                    <label for="active_yes">yes</label>
                </div>

                <div class=" form-check" style="display: inline-block; margin-right: 20px">
                    <input class="form-check-input" type="radio" name="active" required id="active_no" value="no" <?php if ($active == "no") {
                                                                                                                        echo "checked";
                                                                                                                    } ?>>
                    <label for="active_no">no</label>
                </div>
            </div>
            <br>

            <div class="form-actions">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                <input type="submit" name="submit" value="Update Food" class="btn btn-outline-success">
            </div>
        </form>
        <!-- Update Food Form Ends -->
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    //Update the food item to DB

    //1.  Get the data from the form
    $id = $_GET['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $current_image = $_POST['current_image'];
    $category = $_POST['category']; //category_id
    $featured = $_POST['featured'];
    $active = $_POST['active'];


    //2. Upload the image if selected
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

            $image_name = "Food_item_" . rand(000, 999) . '.' . $extension;

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
                $_SESSION['upload'] = "<div class='error text-center'>Failed to upload the new image of the food item</div>";

                //Redirect to update-food page
                header('location:' . SITE_URL . 'admin/manage-food.php');
                //Stop the process, because if we failed to upload the image
                // then we don't want the data to be inserted into the DB
                die();
            }
            //if the program continues until here then the upload of the new image was successful

            //B. Remove the current image IF THERE WAS A CURRENT_IMAGE, beause the category
            // could be with no image before the upgrade (image_name column in DB is blank)
            if ($current_image != "") {
                $remove_path = "../images/food/" . $current_image;
                //physically remove the image file from the folder
                $remove = unlink($remove_path);

                //Check wether current_image is removed successfully or not
                if ($remove == FALSE) {
                    //then failed to remove image. Show error messgae
                    $_SESSION['failed-remove'] = "<div class='error text-center'>Error! Failed to remove current food's image</div>";
                    //redirect to manage-category page
                    header("location:" . SITE_URL . "admin/manage-food.php");

                    //Stop the process! Because we don't want to proceed updating the category
                    die();
                }
            }
        } else {
            //What happens is that once you click on the button "choose file"
            //the input $_FILES['name'] will become set. Even if we still have not
            // uploaded a file (We clicked on "choose file" then "cancel")
            $image_name = $current_image;
        }
    } else {
        //Don't upload image, and set the image name to the $current_image name
        $image_name = $current_image;
    }

    //3. Update the tbl_food
    //Create sql to update data
    $sql_upd = "UPDATE tbl_food SET
             title='$title',
             description='$description',
             price='$price',
             image_name='$image_name',
             category_id='$category',
             featured='$featured',
             active='$active'
             WHERE id=$id;
            ";

    // Execute the query
    $res_upd = mysqli_query($conn,  $sql_upd);

    // 4. Redirect to manage-food with message

    //Check wether query is executed or not
    if ($res_upd == TRUE) {
        // food updated

        $_SESSION['update'] = "<div class='success text-center'>Success! Food item updated</div>";

        //SweetAlert2 Show success message
        echo '<script type="text/javascript">',
        'alertSuccess();',
        '</script>';

        //header("location:" . SITE_URL . "admin/manage-food.php");
    } else {
        // Failed to update food

        $_SESSION['update'] = "<div class='error text-center'>Error! Failed to update food item</div>";

        //SweetAlert2 Show error message
        echo '<script type="text/javascript">',
        'alertFailure();',
        '</script>';

        //header("location:" . SITE_URL . "admin/manage-food.php");
    }

    //4. Redirect with message to manage-food.php
}
?>


<?php include("partials/footer.php"); ?>