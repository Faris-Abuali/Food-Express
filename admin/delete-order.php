<?php
//Inclue constants file:
include('../config/constants.php');

// Check wether the id is set or not:
//First of all, check wheter the $_GET['id'] is set,
// meaning that whether the user has accessed this page by passing an order id
//to the url string or not.


if (isset($_GET['id'])) {

    $id = $_GET['id'];

    //Then delete the order from DB: 
    $sql = "DELETE FROM tbl_order WHERE id=$id";

    //Execute the query
    $res = mysqli_query($conn, $sql);

    //Check wether the data is deleted from DB or not:
    if ($res == TRUE) {
        //Set success message and redirect to manage-order:
        $_SESSION['delete'] = "<div class='success text-center'>Success! Deleted Order</div>";
        header("location:" . SITE_URL . "admin/manage-order.php");
    } else {
        // Set error message and redirect to manage-order:

        $_SESSION['delete'] = "<div class='error text-center'>Error! Failed to Delete Order</div>";
        header("location:" . SITE_URL . "admin/manage-order.php");
    }
} else {
    //Then this is not the right way to delete an order.
    //(this page "delete-order.php" was not accessed from the "manage-order.php")
    // echo "Wrong Access!<br>";
    $_SESSION['unauthorized'] = "<div class='error text-center'>Unauthorized Delete!</div>";
    header("location:" . SITE_URL . "admin/manage-order.php");
}
