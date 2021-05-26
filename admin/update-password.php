<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br /><br />

        <?php
        //1. Get the ID of Selected Admin
        //First of all, check wheter the $_GET['id'] is set, meaning that whether the user
        //has accessed this page by passing an admin id to the url string or not.
        if (isset($_GET['id'])) {

            $id = $_GET['id'];

        ?>

            <form action="" method="POST">
                <!-- We will process the form in this same page -->

                <table class="tbl-50">
                    <tr>
                        <td>Current Password: </td>
                        <td><input type="password" name="current_password" required placeholder="Current password..."></td>
                    </tr>

                    <tr>
                        <td>New Password: </td>
                        <td><input type="password" name="new_password" required placeholder="New password..."></td>
                    </tr>

                    <tr>
                        <td>Confirm Password: </td>
                        <td><input type="password" name="confirm_password" required placeholder="Type your new password again :)"></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                        </td>
                    </tr>
                </table>

            </form>
        <?php
        } else {
            //Then this is not tbe right way to update an admin.
            //(this page "update-password.php" was not accessed from the "manage-admin.php")
            echo "Wrong Access!<br>";
        }
        ?>
    </div>
</div>

<?php

//Check wether the submit button is clicked

if (isset($_POST['submit'])) {
    //submit button is clicked

    //1.Get the data from form 
    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);


    //2. Check wether the user exists or not

    $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

    //Notice that '$current_password' is put inside single quotes, because it's varchar
    //Meanwhile $id is without singl quotes because it's integer.

    //Execute the Query

    //Execute the Query:
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    //$res is a boolean flag. If the query is executed successfully then it is true.

    if ($res == TRUE) {

        //Check wether data is available

        //Count rows to check wether we have recordes in the admins table or not.
        $count = mysqli_num_rows($res); //function to get number of rows in the table

        if ($count == 1) {
            // There will only be one record with this id

            // echo "User Found";
            //User exists and password can be changed

            //Now we will check wether the new password mathes the confirm password

            if ($new_password == $confirm_password) {
                //Then update the password

                // echo "Password Match";

                $sql2 = "UPDATE tbl_admin SET password='$new_password' WHERE id=$id";

                //Execute the query

                $res2 = mysqli_query($conn, $sql2);

                //Check wether the query is executed or not
                if ($res2 == TRUE) {
                    //Display Success Message and redirect 
                    $_SESSION['change-pwd'] = "<div class='success'>Success! Password Changed</div>";
                    header("location:" . SITE_URL . 'admin/manage-admin.php');
                } else {
                    //Display Error Message
                    $_SESSION['change-pwd'] = "<div class='error'>Error! Failed to Change Password</div>";
                    header("location:" . SITE_URL . 'admin/manage-admin.php');
                }
            } else {
                // we will direct to manage-admin.php with error message

                $_SESSION['pwd-not-match'] = "<div class='error'>New Password and Confirm Password Did Not Match!</div>";
                header("location:" . SITE_URL . 'admin/manage-admin.php');
            }
        } else {
            //Set Message and redirect
            $_SESSION['user-not-found'] = "<div class='error'>The entered current password is incorrect</div>";
            header("location:" . SITE_URL . 'admin/manage-admin.php');
        }
    }

    //3. Check wheter the new password and the current password match.

    //4. Change password only if all above is true
}


?>

<?php include("partials/footer.php"); ?>