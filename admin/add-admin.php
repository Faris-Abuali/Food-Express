<?php include('partials/menu.php'); ?>

<!-- In Case You Want to USe Bootstrap:
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    function alertSuccess() {
        // alert("Hello");
        Swal.fire(
            'Success!',
            'Admin Added Successfully!',
            'success'
        )
    }

    function alertFailure() {
        // alert("Hello");
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong! Failed to Add Admin',
            footer: '<a href="#">Try Again?</a>'
        })
    }
</script>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br /><br />

        <!-- Check wether the session is set or not -->
        <?php if (isset($_SESSION['add'])) {
            echo $_SESSION['add']; //display session message
            unset($_SESSION['add']); //will remove session message once the page is reloaded (refreshed)
        }
        ?>

        <form action="" method="POST">
            <!-- We will process the form in this same page -->
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" required placeholder="Enter your name..."></td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" required placeholder="Enter your username..."></td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" required placeholder="Enter a password..."></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>



<?php
//Process the form data and save it in database


//Check whether the submit button is clicked or not
if (isset($_POST['submit'])) {
    //submit button is clicked

    //1. Get the data from the form
    $full_name = $_POST['full_name'];
    $username  = $_POST['username'];
    $password  =  md5($_POST['password']); // Password Encryption with md5 one-way encryption

    //2. SQL Query to save the data into database:

    $sql = "INSERT INTO tbl_admin SET
              full_name = '$full_name',
              username = '$username',
              password = '$password'
            ";

    //3. Execute Query and Save Data into Database:
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    //$res is a boolean flag. If the query is executed successfully then it is true.

    //4. Check wheteher query is executed (Data is inserted) or not, and display appropriate message.
    if ($res == TRUE) {
        // echo "Data is inserted <br>";
        // Create a Session Variable to Display a Message
        $_SESSION['add'] = "<div class='success'>Admin Added Successfully</div>";


        //SweetAlert2 Show success message
        echo '<script type="text/javascript">',
        'alertSuccess();',
        '</script>';

        //Redirect Page to add-admin.php
        //header("location:" . SITE_URL . 'admin/add-admin.php');
        header("refresh:2;url=" . SITE_URL . "admin/manage-admin.php");
    } else {
        // echo "Failed to insert data<br>";

        // Create a Session Variable to Display a Message
        $_SESSION['add'] = "<div class='error'>Error! Failed to Add Admin!</div>";

        //SweetAlert2 Show failure message
        echo '<script type="text/javascript">',
        'alertFailure();',
        '</script>';

        //Redirect Page to add-admin.php again
        //header("location:" . SITE_URL . 'admin/add-admin.php');
        header("refresh:2;url=" . SITE_URL . "admin/add-admin.php");
    }
} else {
    //submit button is not clicked
}
?>

<?php include('partials/footer.php'); ?>