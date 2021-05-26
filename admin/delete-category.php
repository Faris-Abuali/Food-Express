<?php
//Inclue constants file:
include('../config/constants.php');

// Check wether the id and image_name are set or not:
//First of all, check wheter the $_GET['id'] and $_GET['image_name'] is set,
// meaning that whether the user has accessed this page by passing a category id and image_name
//to the url string or not.


if (isset($_GET['id']) && isset($_GET['image_name'])) {

    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //First, remove the physical image file if available:
    if ($image_name != "") {

        //then image is availabe, so remove it.
        $path = "../images/category/" . $image_name;
        //physically remove the image file from the folder
        $remove = unlink($path);

        if ($remove == FALSE) {
            //then failed to remove image. Show error messgae
            $_SESSION['remove'] = "<div class='error'>Error! Failed to remove category's image</div>";
            //redirect to manage-category page
            header("location:" . SITE_URL . "admin/manage-category.php");

            //Stop the process! Because we don't want to proceed to delete the category from DB
            die();
        }
    }
    //else if image_name = "" then this indicates that there's no image stored in the folder :)


    //Then delete the category from DB: 
    $sql = "DELETE FROM tbl_category WHERE id=$id";

    //Execute the query
    $res = mysqli_query($conn, $sql);

    //Check wether the data is deleted from DB or not:
    if ($res == TRUE) {

        //Set success message and redirect to manage-category:
        $_SESSION['delete'] = "<div class='success text-center'>Success! Category deleted</div>";

        header("location:" . SITE_URL . "admin/manage-category.php");
    } else {
        // Set error message and redirect to manage-category:

        $_SESSION['delete'] = "<div class='error text-center'>Error! Failed to delete category</div>";

        header("location:" . SITE_URL . "admin/manage-category.php");
    }

    //Then redirect to manage-category page with message:
} else {
    //Then this is not hte right way to delete an admin.
    //(this page "delete-category.php" was not accessed from the "manage-catrgory.php")
    // echo "Wrong Access!<br>";

    header("location:" . SITE_URL . "admin/manage-category.php");
}
