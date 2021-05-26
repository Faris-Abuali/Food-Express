<?php include('partials/menu.php'); ?>

<!-- BOOTSTRAP 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

<style>
    .main-content {
        /* margin: 1% 0; */
        background-color: #f1f2f6;
        padding: 3% 1%;
    }

    table tr th {
        text-align: center;
    }

    .bold {
        font-weight: bold;
    }
</style>

<!-- Main Content Section Starts -->
<!-- <div class="main-content"> -->
<!-- <div class="wrapper"> -->


<div class="main-content">
    <h1 class="text-center">Manage Customers' Orders</h1>


    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            Filter Orders
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="<?php echo SITE_URL ?>admin/manage-order.php?filter=ordered">Ordered</a></li>
            <li><a class="dropdown-item" href="<?php echo SITE_URL ?>admin/manage-order.php?filter=on delivery">On delivey</a></li>
            <li><a class="dropdown-item" href="<?php echo SITE_URL ?>admin/manage-order.php?filter=delivered">Delivered</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="<?php echo SITE_URL ?>admin/manage-order.php?filter=cancelled">Cancelled</a></li>
        </ul>
    </div>


    <br /><br />

    <?php
    if (isset($_SESSION['update'])) {
        echo $_SESSION['update'];
        unset($_SESSION['update']);
    }
    if (isset($_SESSION['delete'])) {
        echo $_SESSION['delete'];
        unset($_SESSION['delete']);
    }
    ?>

    <br>

    <div class="table-responsive-lg">
        <table class="table table-hover table-bordered" style="text-align: center;">
            <tr style="background-color: #747d8c; color: #FFF;">
                <th>#</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty.</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th colspan="2">Actions</th>
            </tr>

            <?php
            if (isset($_GET['filter'])) {
                $filter = $_GET['filter'];
                $sql = "SELECT * FROM tbl_order WHERE status = '$filter' ORDER BY id DESC"; //Display latest orders first

            } else {
                //Get all the orders from DB (from tbl_order)
                $sql = "SELECT * FROM tbl_order ORDER BY id DESC"; //Display latest orders first
            }


            //Execute the query
            $res = mysqli_query($conn, $sql);

            //Count the rows of the result set
            $count = mysqli_num_rows($res);

            //Create a Serial Number variable
            $sn = 1;
            if ($count > 0) {
                //There are orders in the DB

                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $total = $row['total'];
                    $order_date = $row['order_date'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];
            ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $food; ?></td>
                        <td><?php echo $price; ?></td>
                        <td><?php echo $qty; ?></td>
                        <td><?php echo $total; ?></td>
                        <td><?php echo $order_date; ?></td>

                        <td>
                            <!-- Status [Ordered, On delivery, Delivered, Cancelled] -->
                            <div class="bold">
                                <?php
                                if ($status == "Ordered") {
                                    echo "<label>$status</label>";
                                } elseif ($status == "On delivery") {
                                    echo "<label style='color: orange'>$status</label>";
                                } elseif ($status == "Delivered") {
                                    echo "<label style='color: #2ed573'>$status</label>";
                                } elseif ($status == "Cancelled") {
                                    echo "<label style='color: #ff4757'>$status</label>";
                                }
                                ?>
                            </div>
                        </td>

                        <td><?php echo $customer_name; ?></td>
                        <td><?php echo $customer_contact; ?></td>
                        <td><?php echo $customer_email; ?></td>
                        <td><?php echo $customer_address; ?></td>
                        <td>
                            <a href="<?php echo SITE_URL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn btn-outline-info" style="width: 100%;">Update</a>

                        </td>
                        <td>
                            <a href="<?php echo SITE_URL; ?>admin/delete-order.php?id=<?php echo $id; ?>" class="btn btn-outline-danger" style="width: 100%;">Delete</a>
                        </td>
                    </tr>

                <?php
                }
            } else {
                //There are no orders in the DB
                ?>
                <div class="alert alert-warning">
                    <strong>Warning!</strong> No Orders Yet
                </div>
            <?php
            }

            ?>


        </table>
    </div>
</div>



<!-- </div> -->
<!-- </div> -->
<!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>