<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Admin</title>

    <!-- <link rel="stylesheet" href="../css/admin.css"> -->

    <!-- Script For Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        function alertSuccess() {
            // alert("Hello");
            Swal.fire(
                'Success!',
                'Admin Deleted Successfully!',
                'success'
            )
        }

        function alertFailure() {
            // alert("Hello");
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong! Failed to Delete Admin',
                footer: '<a href="#">Try Again?</a>'
            })
        }

        function confirmDeletion() {
            var flag = confirm("Are you sure you want to delete this admin?");
            return flag;
        }
    </script>

</head>

<body>
</body>

</html>
<!-- Big Note: There's no need for the HTML in this "delete-admin.php" page, but in order
        to use the "SweetAlert", I must put the js script inside HTML body or head.
        So this is the only reason why I have written HTML here.
-->

<?php
// include constants.php file here. This file resumes the session and connects to the DB.
include("../config/constants.php"); // No need to include "partials/menu.php" because no need for menu


// 1. Get the ID of the admin which is to be deleted.
//First of all, check wheter the $_GET['id'] is set, meaning that whether the user
//has accessed this page by passing an admin id to the url string or not.
if (isset($_GET['id'])) {

    $id = $_GET['id'];

    // 2. Create SQL Query to elete this admin.
    $sql = "DELETE FROM tbl_admin WHERE id = $id";

    //3. Execute Query:
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    //$res is a boolean flag. If the query is executed successfully then it is true.

    //4. Check wheteher query is executed (Data is inserted) or not, and display appropriate message.
    if ($res == TRUE) {
        //Query executed successfully (admin is deleted)
        // echo "Success Admin Deleted";

        // Create a Session Variable to Display a Message
        $_SESSION['delete'] = "<div class='success bold'>Admin Deleted Successfully</div>";


        //SweetAlert2 Show success message
        echo '<script type="text/javascript">',
        'alertSuccess();',
        '</script>';

        //Redirect Page to manage-admin.php
        // header("location:" . SITE_URL . 'admin/manage-admin.php');
        header("refresh:2;url=" . SITE_URL . "admin/manage-admin.php");
    } else {
        // Failed to delete admin
        // echo "Failed to delete Admin";

        // Create a Session Variable to Display a Message
        $_SESSION['add'] = "<div class='error bold'>Error! Failed to Delete Admin!</div>";

        //SweetAlert2 Show failure message
        echo '<script type="text/javascript">',
        'alertFailure();',
        '</script>';

        //Redirect Page to add-admin.php again
        //header("location:" . SITE_URL . 'admin/delete-admin.php');
        header("refresh:2;url=" . SITE_URL . "admin/delete-admin.php");
    }
} else {
    //Then this is not hte right way to delete an admin.
    //(this page "delete-admin.php" was not accessed from the "manage-admin.php")
    echo "Wrong Access!<br>";
}
