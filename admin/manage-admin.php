<?php include('partials/menu.php'); ?>

<!-- <link rel="stylesheet" href="../css/admin.css"> -->
<!-- BOOTSTRAP 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

<style>
    table tr th {
        text-align: center;
    }
</style>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>

        <br />

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add']; //display session message
            unset($_SESSION['add']); //will remove session message once the page is reloaded (refreshed)
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete']; //display session message
            unset($_SESSION['delete']); //will remove session message once the page is reloaded (refreshed)
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update']; //display session message
            unset($_SESSION['update']); //will remove session message once the page is reloaded (refreshed)
        }
        if (isset($_SESSION['user-not-found'])) {
            echo $_SESSION['user-not-found']; //display session message
            unset($_SESSION['user-not-found']); //will remove session message once the page is reloaded (refreshed)
        }
        if (isset($_SESSION['pwd-not-match'])) {
            echo $_SESSION['pwd-not-match']; //display session message
            unset($_SESSION['pwd-not-match']); //will remove session message once the page is reloaded (refreshed)
        }
        if (isset($_SESSION['change-pwd'])) {
            echo $_SESSION['change-pwd']; //display session message
            unset($_SESSION['change-pwd']); //will remove session message once the page is reloaded (refreshed)
        }
        ?>

        <br />

        <!-- Button to Add Admin -->
        <a href="add-admin.php" class="btn btn-outline-primary">Add Admin</a>

        <br /><br />

        <table class="table table-hover" style="text-align:center">

            <tr>
                <th>Serial #</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php

            //Query to get all admins from database:
            $sql = "SELECT * FROM tbl_admin";

            //Execute the Query:
            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            //$res is a boolean flag. If the query is executed successfully then it is true.

            //4. Check wheteher query is executed (Data is inserted) or not, and display appropriate message.

            if ($res == TRUE) {
                //Count rows to check wether we have recordes in the admins table or not.
                $count = mysqli_num_rows($res); //function to get number of rows in the table

                $sn = 1; // variable called: Serial Number

                if ($count > 0) {
                    //then we have records in the table called tbl_admin
                    //fetch record by record and store it in assoc aray called $rows 

                    while ($rows = mysqli_fetch_assoc($res)) {

                        //Get individual Record each iteration:
                        $id = $rows['id'];
                        $full_name = $rows['full_name'];
                        $username = $rows['username'];

                        //Display the record in our HTML table. Break the php now:
            ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <!-- print a serial number ($sn) that represents the 
                            admin's place in this HTMl table -->
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $username; ?></td>
                            <td>

                                <a href="<?php echo SITE_URL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn btn-outline-warning">Update Admin</a>
                                <a onclick="return confirm('Are you sure you want to delete this admin: ' + '<?php echo $full_name ?>' + '?');" href="<?php echo SITE_URL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn btn-outline-danger">Delete Admin</a>
                                <a href="<?php echo SITE_URL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn btn-outline-secondary">Change Password</a>
                                <!-- Notice that each record will have its delete button that has a href
                                that when clicked, it directs us to a the delete-admin.php but passes the id
                                of this current admin usin GET method-->

                            </td>
                        </tr>
            <?php

                    }
                } else {
                    //then there're no records in the table called tbl_admin
                }
            } else {
                //Failed to execute the query
            }

            ?>

        </table>
    </div>
</div>
<!-- Main Content Section Ends  -->

<?php include('partials/footer.php'); ?>