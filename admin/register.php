<?php include("../config/constants.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../css/admin.css">


    <!-- Bootstrap 3 -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

    <!-- BOOTSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>


    <title>Create Account</title>


    <style>
        body {
            font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
            background-color: #f0f0f2;

        }

        div.myFormDiv {
            width: 600px;
            margin: 5em auto;
            padding: 2em;
            background-color: #fdfdff;
            border-radius: 0.5em;
            box-shadow: 2px 3px 7px 2px rgba(0, 0, 0, 0.02);
        }
    </style>
</head>

<body>

    <div class="myFormDiv">

        <div class="container-fluid" style="width:100%;">

            <div align="Center">

                <div class="row form-group">
                    <h1>Create Account</h1>
                </div>
                <br>

                <?php
                if (isset($_SESSION['register'])) {
                    echo $_SESSION['register'];
                    unset($_SESSION['register']);
                }
                ?>


                <form action="" method="POST">

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" placeholder="Enter username" name="username" id="username" required>
                        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                    </div>
                    <br>

                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" placeholder="Enter username" name="full_name" id="full_name" required>
                        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                    </div>
                    <br>

                    <div class="form-group">
                        <label for="pass">Password</label>
                        <input type="password" class="form-control" name="password" id="pass" placeholder="Password" required>
                    </div>
                    <br>

                    <!-- <div class="form-group">
                    <label for="exampleFormControlSelect1">Example select</label>
                    <select class="form-control" id="exampleFormControlSelect1">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                    </div> -->

                    <div class="form-actions">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>


                <hr>
                <medium>Already have an account? Go to <a class="" href="<?php echo SITE_URL; ?>admin/login.php">Login</a> </medium>
            </div>

            <?php
            if (isset($_POST['submit'])) {
                //We will process the login data form

                // 1. Get the data from login form
                $username = $_POST['username'];
                $full_name = $_POST['full_name'];
                $password = md5($_POST['password']);

                //2. SQL to insert user to tbl_admin
                $sql = "INSERT INTO tbl_admin SET
                        username='$username',
                        full_name='$full_name',
                        password='$password'
                        ";

                //3. Execute Query and Save Data into Database:
                $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                //$res is a boolean flag. If the query is executed successfully then it is true.


                //4. Check wheteher query is executed (Data is inserted) or not, and display appropriate message.
                if ($res == TRUE) {
                    $_SESSION['register'] = "<div class='success text-center'>Success! Account Has Been Created</div>";
                } else {
                    $_SESSION['register'] = "<div class='error text-center'>Error! Failed to Create Account</div>";
                }

                //redirect to this page "register.php"
                header("location:" . SITE_URL . 'admin/register.php');
            }
            ?>
        </div>
    </div>


</body>

</html>