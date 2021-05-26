<?php include("partials/menu.php"); ?>

<!-- BOOTSTRAP 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

<script type="text/javascript">
    function alertSuccess() {
        // alert("Hello");
        Swal.fire(
            'Success!',
            'Updated Order',
            'success'
        )
    }

    function alertFailure() {
        // alert("Hello");
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong! Failed to Update Order',
            footer: '<a href="#">Try Again?</a>'
        })
    }
</script>

<style>
    .main-content {
        /* margin: 1% 0; */
        background-color: #f1f2f6;
        padding: 3% 1%;
    }

    table.center {
        margin-left: auto;
        margin-right: auto;
    }

    table tr td {
        /* text-align: center; */
        font-weight: bold;
    }
</style>


<!-- The admin needs only to update "quantity" and "status" of the order-->

<div class="main-content">
    <!-- <div class="wrapper"> -->
    <h1 class="text-center">Update Order</h1>

    <br><br>
    <?php
    //Check wether the id is set or not
    if (isset($_GET['id'])) {
        //Get the id and all other data of the order
        $id = $_GET['id'];

        //Create SQL query to get all other details of this order
        $sql = "SELECT * FROM tbl_order WHERE id=$id";

        //Execute the query:
        $res = mysqli_query($conn, $sql);

        //Count the rows to check wether the id is valid or not
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            //Then we will get all the data of this record

            //Get all data
            $row = mysqli_fetch_assoc($res);

            $food = $row['food'];
            $price = $row['price'];
            $qty =  $row['qty'];
            // $total =  $row['total'];
            $status = $row['status'];
            $customer_name = $row['customer_name'];
            $customer_contact = $row['customer_contact'];
            $customer_email = $row['customer_email'];
            $customer_address = $row['customer_address'];
        } else {

            $_SESSION['no-order-found'] = "<div class='error text-center'>Error! Order Not Found</div>";

            // redirect to manage-order, because no such id in the table tbl_forder
            header("location:" . SITE_URL . "admin/manage-order.php");
        }
    } else {
        //redirect to manage-order
        header("location:" . SITE_URL . "admin/manage-order.php");
    }
    ?>


    <form action="" method="POST">

        <div class="table-responsive-lg">
            <div class="table-responsive-lg">
                <table class="table  center" style="width: 40%;">

                    <tr>
                        <td>Food Title</td>
                        <td><?php echo $food; ?></td>
                    </tr>

                    <tr>
                        <td>Price</td>
                        <td>$ <?php echo $price; ?></td>
                    </tr>

                    <tr>
                        <td>Quantity</td>
                        <td><input type="number" name="qty" value="<?php echo $qty; ?>" required min="0" max="10" class="form-control"></td>
                    </tr>

                    <tr>
                        <td>Status</td>
                        <td>
                            <select name="status" id="" class="form-select">
                                <option value="Ordered" <?php if ($status == "Ordered") {
                                                            echo "selected";
                                                        } ?>>Ordered</option>
                                <option value="On delivery" <?php if ($status == "On delivery") {
                                                                echo "selected";
                                                            } ?>>On delivery</option>
                                <option value="Delivered" <?php if ($status == "Delivered") {
                                                                echo "selected";
                                                            } ?>>Delivered</option>
                                <option value="Cancelled" <?php if ($status == "Cancelled") {
                                                                echo "selected";
                                                            } ?>>Cancelled</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Customer's Name</td>
                        <td>
                            <div class=" form-group">
                                <input type="text" name="customer_name" required class="form-control" value="<?php echo $customer_name; ?>">
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>Customer's Contact</td>
                        <td>
                            <div class=" form-group">
                                <input type="text" name="customer_contact" required class="form-control" value="<?php echo $customer_contact; ?>">
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>Customer's Email</td>
                        <td>
                            <div class=" form-group">
                                <input type="text" name="customer_email" required class="form-control" value="<?php echo $customer_email; ?>">
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>Customer's Address</td>
                        <td>
                            <div class="form-group">
                                <div class=" form-group">
                                    <textarea name="customer_address" rows="3" required class="form-control" style="white-space: pre-wrap;"><?php echo $customer_address; ?></textarea>
                                </div>
                            </div>
                        </td>
                    </tr>


                    <tr>
                        <td colspan="2" style="text-align: center;">
                            <!-- We need to "POST" the id and price of the order.
                                 Why id? to be able to identify which record to update in the tbl_order :)
                                 hy price? because wehn updating the quantity, the total will need to be updated.
                                So we have to know the price of this order -->
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="hidden" name="price" value="<?php echo $price; ?>">
                            <input type="submit" name="submit" value="Update Order" class="btn btn-outline-success">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </form>

    <?php
    //Check wether update button is clicked or not:

    if (isset($_POST['submit'])) {

        //Get all the order details from the form
        $id = $_POST['id'];
        $price = $_POST['price'];
        $qty = $_POST['qty'];

        $total = $price * $qty;

        $status = $_POST['status'];

        $customer_name = $_POST['customer_name'];
        $customer_contact = $_POST['customer_contact'];
        $customer_email = $_POST['customer_email'];
        $customer_address = $_POST['customer_address'];

        //Update the values
        $sql2 = "UPDATE tbl_order SET
        qty=$qty,
        total=$total,
        status='$status',
        customer_name='$customer_name',
        customer_contact='$customer_contact',
        customer_email='$customer_email',
        customer_address='$customer_address' WHERE id='$id'";

        //Execute query:
        $res2 = mysqli_query($conn, $sql2);

        //Check wether query is executed or not
        if ($res2 == TRUE) {
            // food updated
            $_SESSION['update'] = "<div class='success text-center'>Success! Order Updated</div>";

            //SweetAlert2 Show success message
            echo '<script type="text/javascript">',
            'alertSuccess();',
            '</script>';

            //Redirect to manage-order.php with message
            // header("location:" . SITE_URL . "admin/manage-order.php");
        } else {
            // Failed to update food
            $_SESSION['update'] = "<div class='error text-center'>Error! Failed to Update Order</div>";

            //SweetAlert2 Show error message
            echo '<script type="text/javascript">',
            'alertFailure();',
            '</script>';

            //Redirect to manage-order.php with message
            // header("location:" . SITE_URL . "admin/manage-order.php");
        }
    }
    ?>


    <!-- </div> -->
</div>

<?php include("partials/footer.php"); ?>