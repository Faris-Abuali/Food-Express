<?php include('partials/menu.php'); ?>

<!-- BOOTSTRAP 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>


<script type="text/javascript">
    function alertSuccess() {
        // alert("Hello");
        Swal.fire(
            'Success!',
            'Admin Updated Successfully!',
            'success'
        )
    }

    function alertFailure() {
        // alert("Hello");
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong! Failed to Update Admin',
            footer: '<a href="#">Try Again?</a>'
        })
    }
</script>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br /><br />

        <?php
        //1. Get the ID of Selected Admin
        //First of all, check wheter the $_GET['id'] is set, meaning that whether the user
        //has accessed this page by passing an admin id to the url string or not.
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            //2. Create SQL Query to get the details
            $sql = "SELECT * FROM tbl_admin WHERE id=$id";

            //3. Execute the Query
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

            //4. Check wheteher query is executed (Data is inserted) or not, and display appropriate message.
            if ($res == TRUE) {
                //Check wether the data is available or not.

                $count = mysqli_num_rows($res); //function to get number of rows in the table

                if ($count == 1) {
                    // We will get the data of this reord.
                    $row = mysqli_fetch_assoc($res);

                    $full_name = $row['full_name'];
                    $username = $row['username'];
                } else {
                    // We will redirect to manage-admin.php. 
                    // This happens when someone tries to pass an arbitrary id to the url string
                    //like this: http://localhost/food-order/admin/update-admin.php?id=9912
                    //for example. So there's no admin with id = 9912
                    header("location:" . SITE_URL . 'admin/manage-admin.php');
                }
            } else {
            }
        ?>

            <form action="" method="POST">
                <!-- We will process the form in this same page -->


                <div class=" form-group">
                    <label for="id">ID</label><br />
                    <input type="text" name="id" class="form-control" value="<?php echo $id; ?>" readonly>
                </div>
                <br>

                <div class="form-group">
                    <label for="id">Full Name</label><br />
                    <input type="text" name="full_name" class="form-control" value="<?php echo $full_name; ?>">
                </div>
                <br>

                <div class="form-group">
                    <label for="id">Username</label><br />
                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                </div>
                <br>
                <!-- <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" required placeholder="Enter a password..."></td>
                </tr> -->

                <div class="form-actions">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Update Admin" class="btn btn-outline-success">
                </div>
            </form>

        <?php
        } else {
            //Then this is not tbe right way to update an admin.
            //(this page "update-admin.php" was not accessed from the "manage-admin.php")
            echo "Wrong Access!<br>";
        }

        ?>


    </div>
</div>

<?php


//Check whether the submit button is clicked or not
if (isset($_POST['submit'])) {
    //submit button is clicked


    //Get all input data from the above form:
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];

    //Create SQL query to update this admin
    $sql = "UPDATE tbl_admin SET full_name='$full_name', username='$username' WHERE id='$id'";


    //Execute the query:
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    //$res is a boolean flag. If the query is executed successfully then it is true.

    //4. Check wheteher query is executed (Data is inserted) or not, and display appropriate message.
    if ($res == TRUE) {
        ///Then query is executed and admin is updates.

        // Create a Session Variable to Display a Message
        $_SESSION['update'] = "<div class='success text-center'>Admin Updated Successfully</div>";


        //SweetAlert2 Show success message
        echo '<script type="text/javascript">',
        'alertSuccess();',
        '</script>';

        //Redirect Page to manage-admin.php
        // header("location:" . SITE_URL . 'admin/manage-admin.php');
        header("refresh:2;url=" . SITE_URL . "admin/manage-admin.php");
    } else {
        // echo "Failed to update admin<br>";

        // Create a Session Variable to Display a Message
        $_SESSION['update'] = "<div class='error text-center'>Error! Failed to Update Admin!</div>";

        //SweetAlert2 Show failure message
        echo '<script type="text/javascript">',
        'alertFailure();',
        '</script>';

        //Redirect Page to update-admin.php again
        //header("location:" . SITE_URL . 'admin/update-admin.php');
        header("refresh:2;url=" . SITE_URL . "admin/update-admin.php");
    }
} else {
    //submit button is NOT clicked.
}

?>

<?php include('partials/footer.php'); ?>