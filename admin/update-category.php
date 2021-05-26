<?php include("partials/menu.php"); ?>

<!-- Bootstrap 3 -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->

<!-- BOOTSTRAP 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>


<style>
    .tbl-30 {
        width: 30%;
    }
</style>

<script type="text/javascript">
    function alertSuccess() {
        // alert("Hello");
        Swal.fire(
            'Success!',
            'Category Updated',
            'success'
        )
    }

    function alertFailure() {
        // alert("Hello");
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong! Failed to Update Category',
            footer: '<a href="#">Try Again?</a>'
        })
    }
</script>

<div class="main-content">

    <div class="wrapper">

        <div class="row form-group">
            <h1>Update Category</h1>
        </div>

        <br><br>

        <?php
        //Check wether the id is set or not
        if (isset($_GET['id'])) {
            //Get the id and all other 
            $id = $_GET['id'];

            //Create SQL query to get all other details of this category
            $sql = "SELECT * FROM tbl_category WHERE id=$id";

            //Execute the query:
            $res = mysqli_query($conn, $sql);

            //Count the rows to check wether the id is valid or not
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                //Then we will get all the data of this record

                //Get all data
                $row = mysqli_fetch_assoc($res);

                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            } else {

                $_SESSION['no-category-found'] = "<div class='error text-center'>Error! Category Not Found</div>";

                // redirect to manage-category, because no such id in the table tbl_category
                header("location:" . SITE_URL . "admin/manage-category.php");
            }
        } else {
            //redirect to manage-category
            header("location:" . SITE_URL . "admin/manage-category.php");
        }
        ?>

        <!-- Add Category Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data" style="width:50%">
            <!-- Process the form in this same page -->

            <div class="form-group">
                <label for="img">Current Image and Title</label><br />
                <div class="img-thumbnail">
                    <?php
                    if ($current_image != "") {
                        //display the image

                        $mySrc = SITE_URL . "images/category/$current_image";
                    } else {
                        //display empty image
                        $mySrc = "https://via.placeholder.com/650x300";
                    }
                    ?>
                    <img src="<?php echo $mySrc ?>" class="img-thumbnail" id="categoImg" alt="category_image" style="width:650px; height:300px">

                    <div class="caption text-center" style="padding: 0px;">
                        <h3><?php echo $title ?></h3>
                    </div>
                </div>
            </div>

            <br>
            <div class="form-group">
                <div class=" form-group">
                    <label for="title">Title</label><br>
                    <input type="text" name="title" id="title" required class="form-control" value='<?php echo $title; ?>'>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class=" form-group">
                    <label for="img">Select New Image</label><br />
                    <input type="file" name="image" id="img" class="form-control-file">
                </div>
            </div>
            <br>

            <div class="form-group">
                <h6>Featured?</h6>
                <div class="form-group">
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
            </div>
            <br>

            <div class="form-group">
                <h6>Active?</h6>
                <div class="form-group">
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
            </div>
            <br>


            <div class="form-actions">
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" name="submit" value="Update Category" class="btn btn-outline-success">
            </div>
        </form>
        <!-- Add Category Form Ends -->
    </div>
</div>

<?php
if (isset($_POST['submit'])) {

    // 1.Get all the values from the form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $current_image = $_POST['current_image'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    // 2. Updating new image if selected
    //Check wether the image is selected or not

    if (isset($_FILES['image']['name'])) {

        //Get the image details
        $image_name = $_FILES['image']['name'];

        //Check wether image is available or not:
        if ($image_name != "") {
            //Image Availabe

            //A. Uploead the new image

            //Auto-Rename the image
            $separator = ".";
            //Get extension of the img (.jpg, .png, .gif, etc...)
            $arr = explode($separator, $image_name);
            $extension = end($arr);

            //Rename the image
            $image_name = "Food_Category_" . rand(000, 999) . '.' . $extension;


            $source_path = $_FILES['image']['tmp_name'];

            //We need to get out of "admin" folder, then enter "images" folder, 
            //then inside it will be "category" folder
            $destination_path = "../images/category/" . $image_name;

            //Finally upload the image

            $upload = move_uploaded_file($source_path, $destination_path);

            //Check wether the image is uploaded or not:
            //if the image is not uploaded then we will stop the process and
            // redirect with error message

            if ($upload == FALSE) {

                //Set error message
                $_SESSION['upload'] = "<div class='error text-center'>Failed to upload image</div>";

                //Redirect to add-category page
                header('location:' . SITE_URL . 'admin/manage-category.php');
                //Stop the process, because if we failed to upload the image
                // then we don't want the data to be inserted into the DB
                die();
            }

            //B. Remove the current image IF THERE WAS A CURRENT_IMAGE, beause the category
            // could be with no image before the upgrade (image_name column in DB is blank)
            if ($current_image != "") {

                $remove_path = "../images/category/" . $current_image;
                //physically remove the image file from the folder
                $remove = unlink($remove_path);

                //Check wether current_image is removed successfully or not
                if ($remove == FALSE) {
                    //then failed to remove image. Show error messgae
                    $_SESSION['failed-remove'] = "<div class='error text-center'>Error! Failed to remove current category's image</div>";
                    //redirect to manage-category page
                    header("location:" . SITE_URL . "admin/manage-category.php");

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
        $image_name = $current_image;
    }


    // 3. Update the DB
    $sql2 = "UPDATE tbl_category SET
             title='$title',
             image_name='$image_name',
             featured='$featured',
             active='$active'
             WHERE id=$id;
    ";

    // Execute the query
    $res2 = mysqli_query($conn, $sql2);

    // 4. Redirect to manage-category with message

    //Check wether query is executed or not
    if ($res == TRUE) {
        // Category updated

        $_SESSION['update'] = "<div class='success text-center'>Success! Category Updated</div>";

        //SweetAlert2 Show success message
        echo '<script type="text/javascript">',
        'alertSuccess();',
        '</script>';

        //header("location:" . SITE_URL . "admin/manage-category.php");
    } else {
        // Faile to update category

        $_SESSION['update'] = "<div class='error text-center'>Error! Failed to update category</div>";

        //SweetAlert2 Show error message
        echo '<script type="text/javascript">',
        'alertFailure();',
        '</script>';

        //header("location:" . SITE_URL . "admin/manage-category.php");
    }
}
?>



<?php include("partials/footer.php"); ?>