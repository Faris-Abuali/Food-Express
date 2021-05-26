<?php
include('partials/menu.php');
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

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
            'Category Added',
            'success'
        )
    }

    function alertFailure() {
        // alert("Hello");
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong! Failed to Add Category',
            footer: '<a href="#">Try Again?</a>'
        })
    }
</script>


<div class="main-content">

    <div class="wrapper">


        <div class="row form-group">
            <h1>Add Category</h1>
        </div>

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


        <!-- Add Category Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data">
            <!-- Process the form in this same page -->


            <div class="form-group">
                <div class=" form-group">
                    <label for="title">Title</label><br />
                    <input type="text" name="title" id="title" required class="form-control" placeholder="category's title..">
                </div>
            </div>

            <div class="form-group">
                <div class=" form-group">
                    <label for="img">Select Image</label><br />
                    <input type="file" name="image" id="img" class="form-control-file">
                </div>
            </div>


            <div class="form-group">
                <legend>Featured?</legend>

                <div class=" form-check" style="display: inline-block; margin-right: 20px">
                    <input class="form-check-input" type="radio" name="featured" required id="f_yes" value="yes">
                    <label for="f_yes">yes</label>
                </div>

                <div class=" form-check" style="display: inline-block; margin-right: 20px">
                    <input class="form-check-input" type="radio" name="featured" required id="f_no" value="no">
                    <label for="f_no">no</label>
                </div>
            </div>


            <div class="form-group">
                <legend>Active?</legend>

                <div class=" form-check" style="display: inline-block; margin-right: 20px">
                    <input class="form-check-input" type="radio" name="active" required id="active_yes" value="yes">
                    <label for="active_yes">yes</label>
                </div>

                <div class=" form-check" style="display: inline-block; margin-right: 20px">
                    <input class="form-check-input" type="radio" name="active" required id="active_no" value="no">
                    <label for="active_no">no</label>
                </div>
            </div>

            <div class="form-actions">
                <input type="submit" name="submit" value="Add Category" class="btn btn-primary">
            </div>

        </form>
        <!-- Add Category Form Ends -->
    </div>
</div>


<?php
//Check wether the submit button is clicked or not
if (isset($_POST['submit'])) {


    $title = $_POST['title'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    //Check wether image is selected or not, and set the value for image name accordingly
    // print_r($_FILES['image']);

    if ($_FILES['image']['name'] != "") {

        //First of all I tried: if(isset($FILES['image']['name'])) but it seems always set!
        // So I came up with: if($_FILES['image']['name'] != "")

        //Upload the image   
        // In order to upload image, we need:
        // 1. Image name 2. source path  3. Destination path

        $image_name = $_FILES['image']['name'];

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
            header('location:' . SITE_URL . 'admin/add-category.php');
            //Stop the process, because if we failed to upload the image
            // then we don't want the data to be inserted into the DB
            die();
        }
    } else {
        //Don't upload image, and set the image name value as blank
        $image_name = "";
    }


    //Create SQL query to insert category into DB

    $sql = "INSERT INTO tbl_category SET
                title='$title',
                image_name='$image_name',
                featured='$featured',
                active='$active'
            ";

    $res = mysqli_query($conn, $sql);
    //$res is a boolean flag. If the query is executed successfully then it is true.

    //4. Check wheteher query is executed (Data is inserted) or not, and display appropriate message.
    if ($res == TRUE) {
        //then query executed and category added

        //Display a success message in manage-category.php

        $_SESSION['add'] = "<div class='success text-center'>Success! Category Added</div>";

        //SweetAlert2 Show success message
        echo '<script type="text/javascript">',
        'alertSuccess();',
        '</script>';

        //Redirect to manage-category.php
        //header("location:" . SITE_URL . "admin/manage-category.php");
        //header("refresh:1;url=" . SITE_URL . "admin/manage-category.php");
    } else {
        // failed to add category

        //Display a nerror message

        $_SESSION['add'] = "<div class='error text-center'>Error! Failed to add category</div>";

        //SweetAlert2 Show error message
        echo '<script type="text/javascript">',
        'alertFailure();',
        '</script>';

        //Redirect to add-category.php to try again
        //header("location:" . SITE_URL . "admin/add-category.php");
    }
}
?>

<?php
include('partials/footer.php');
?>