<?php include("../config/constants.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Ordering System</title>

    <link rel="stylesheet" href="../css/admin.css">

    <!-- Bootstrap 3 -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

    <!-- BOOTSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <style>
        body {
            font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
            background-color: #f0f0f2;

        }

        .text-center {
            text-align: center;
        }

        div.myFormDiv {
            width: 50%;
            margin: 5em auto 2em;
            padding: 2em 2em 10px 2em;
            background-color: #fdfdff;
            border-radius: 0.5em;
            box-shadow: 2px 3px 7px 2px rgba(0, 0, 0, 0.02);
        }

        .underline-none {
            text-decoration: none;
        }

        @media screen and (max-width: 600px) {
            div.myFormDiv {
                width: 100%;
            }
        }
    </style>

</head>

<body>
    <div class="alert alert-info alert-dismissible fade show text-center" role="alert">
        <strong>For test purposes:</strong> Login using this account: username = "f.h.abuali", password= "fares_2000"
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="myFormDiv">
        <h1 class="text-center">Login</h1>

        <br>

        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        if (isset($_SESSION['no-login-msg'])) {
            //this happens when "login-check.php" redirects the user to this "login.php" page
            echo $_SESSION['no-login-msg'];
            unset($_SESSION['no-login-msg']);
        }
        ?>
        <br>

        <!-- Login form starts here -->
        <form action="" method="POST" class="text-center">

            <div class="form-group">
                <label for="username">Username</label><br />
                <input type="text" name="username" id="username" required class="form-control" placeholder="Enter your username...">
            </div>
            <br>



            <div class="form-group">
                <label for="pwd">Password</label><br />
                <input type="password" name="password" id="pwd" required class="form-control" placeholder="Enter your password...">
            </div>
            <br>

            <input type="submit" name="submit" value="Login" class="btn btn-outline-primary">
            <hr>
            <div class="alert alert-danger" role="alert">
                <small><strong>Note: </strong> This login form will lead you to the admin control panel. This shall be accessible only by authorized people (e.g., restaurant's owner and kitchen staff).
                    <br>Return to <a href="<?php echo SITE_URL; ?>">Homepage</a></small>
            </div>
            <!-- <p class="text-center">Don't have an account? Go to <a class="" href="<?php echo SITE_URL; ?>admin/register.php">Register</a> </p> -->

        </form>
        <!-- Login form ends here -->
        <!-- <p class="text-center">Created By - <a href="#" class="underline-none">Fares Abuali</a></p> -->
    </div>
</body>

</html>

<?php

// Check wether the submit button is clicked.

if (isset($_POST['submit'])) {
    //We will process the login data form

    // 1. Get the data from login form
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    //2. SQL to check wether the username and password exist or not.
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    //3. Execute Query and Save Data into Database:
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    //$res is a boolean flag. If the query is executed successfully then it is true.

    //4. Check wheteher query is executed (Data is inserted) or not, and display appropriate message.
    if ($res == TRUE) {

        //count rows to check if the user exists or not
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            //Then user exists and the password is correct :)

            $_SESSION['login'] = "<div class='success text-center'>Login Susccessful</div>";

            // ---- AUTHORIZATION (ACCESS CONTROL): Now the followin session variable is important: 
            // This is to check wether the user is loged in or not.
            //We have already obtained the username from the user, so we will make a session
            // variable with this username. (Store their username in this session variable)
            $_SESSION['user'] = $username;
            //This session variable will not be unset unless the user click "Logout"


            //redirect to homepage
            header("location:" . SITE_URL . 'admin/');
        } else {
            // Then either the user does not exist, or the user exists but the password is not correct.

            //1. Check if the user exists.
            $sql2 = "SELECT * FROM tbl_admin WHERE username='$username'";

            $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

            if ($res2 == TRUE) {
                //count rows to check if the user exists or not
                $count2 = mysqli_num_rows($res2);

                if ($count2 == 1) {
                    // then the user exists. And the reason why the user couldn't login is that the password is incorrect
                    $_SESSION['login'] = "<div class='error text-center'>Username and password did not match!</div>";
                } else {
                    //then count = 0, this means that the user does not exist
                    $_SESSION['login'] = "<div class='error text-center'>This username deoesn't exist in the database</div>";
                }
            } else {
                $_SESSION['login'] = "<div class='error text-center'>Error! Database Query failed to execute</div>";
            }

            //redirect again to this page "login.php"
            header("location:" . SITE_URL . 'admin/login.php');
        }
    } else {
        $_SESSION['login'] = "<div class='error text-center'>Error! Database Query failed to execute</div>";
        //redirect again to this page "login.php"
        header("location:" . SITE_URL . 'admin/login.php');
    }
}

?>