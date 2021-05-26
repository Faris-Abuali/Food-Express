<?php include('partials/menu.php'); ?>

<!-- BOOTSTRAP 5
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script> -->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>
    textarea {
        /* will prevent resizing horizontally */
        resize: vertical;
    }

    .container-fluid {
        background-color: #f1f2f6;
    }

    btn-block {
        width: 100%;
        font-size: 120%;
    }

    .btn-add-food:hover {
        color: #FFF;
        background: #28A745;
        /* background: #7bed9f; */
    }


    .thumbnail table {
        margin-bottom: 0;
    }

    .thumbnail table th,
    .thumbnail table td {
        border-bottom: none;
    }

    .paddingLeft {
        padding-left: 15px;
    }
</style>

<!-- Main Content Section Starts -->
<div class="container-fluid">

    <h1 class="text-center">Manage Food</h1>

    <br>

    <?php
    //This messgae will be displayed when we add category successfully.
    if (isset($_SESSION['add'])) {
        echo $_SESSION['add'];
        unset($_SESSION['add']);
    }
    if (isset($_SESSION['remove'])) {
        // remove means "remove" the food's image file from the folder
        echo $_SESSION['remove'];
        unset($_SESSION['remove']);
    }
    if (isset($_SESSION['delete'])) {
        // delete means "delete" the food's record from the DB tbl_food
        echo $_SESSION['delete'];
        unset($_SESSION['delete']);
    }
    if (isset($_SESSION['unauthorized'])) {
        // this happens when trying to enter the "delete-food.php" in a wrong way
        echo $_SESSION['unauthorized'];
        unset($_SESSION['unauthorized']);
    }
    // if (isset($_SESSION['no-category-found'])) {
    //     //then you are passing category id to "update-category" and this id is not found in the DB
    //     echo $_SESSION['no-category-found'];
    //     unset($_SESSION['no-category-found']);
    // }
    if (isset($_SESSION['update'])) {
        echo $_SESSION['update'];
        unset($_SESSION['update']);
    }
    if (isset($_SESSION['upload'])) {
        echo $_SESSION['upload'];
        unset($_SESSION['upload']);
    }
    if (isset($_SESSION['failed-remove'])) {
        echo $_SESSION['failed-remove'];
        unset($_SESSION['failed-remove']);
    }
    if (isset($_SESSION['no-food-found'])) {
        echo $_SESSION['no-food-found'];
        unset($_SESSION['no-food-found']);
    }
    ?>


    <!-- Button to Add Food -->
    <a href="<?php echo SITE_URL . "admin/add-food.php" ?>" class="btn btn-default btn-add-food" style="margin-left: 25px;">
        <h3 style="display: inline">Add Food</h3>
        <!-- <span class="glyphicon glyphicon-plus"></span> -->
    </a>




    <br /><br />


    <?php
    //Query to get all categories from DB
    $sql = "SELECT * FROM tbl_food";

    //Execute Query
    $res = mysqli_query($conn, $sql);

    //Count Rows
    $count = mysqli_num_rows($res);


    //Check wether we have data in DB or not.
    if ($count > 0) {
        // We have data in DB

        //Get the data and display it in table

        while ($row = mysqli_fetch_assoc($res)) {

            $id = $row['id'];
            $title = $row['title'];
            $description = $row['description'];
            $category_id = $row['category_id'];
            $price = $row['price'];
            $image_name = $row['image_name'];
            $featured = $row['featured'];
            $active = $row['active'];
    ?>

            <div class="col-xs-12 col-sm-6 col-md-4">

                <div class="thumbnail">

                    <?php
                    if ($image_name != "") {
                        //display the image

                        $mySrc = SITE_URL . "images/food/$image_name";
                    } else {
                        //display empty image
                        $mySrc = "https://via.placeholder.com/670x300";
                    }
                    ?>
                    <img src="<?php echo $mySrc; ?>" alt="food_image" style="width:670px; height:300px">

                    <div class="caption text-center" style="padding: 0px;">
                        <h3><?php echo $title; ?></h3>
                        <hr>
                    </div>
                    <p style="height: 100px; overflow:auto; white-space: pre-wrap; padding-left: 10px; padding-right: 3px"><?php echo $description; ?></p>
                    <!-- <textarea readonly name="" id="" style="width: 100%; height: 100px; border: none; padding-left: 10px; padding-right: 3px">//echo $description; </textarea> -->
                    <table class="table table-responsive">

                        <tr>
                            <th style="padding-left: 15px;">Featured:</th>
                            <td style="padding-left: 15px;"><?php echo $featured; ?></td>
                        </tr>

                        <tr>
                            <th style="padding-left: 15px;">Active:</th>
                            <td style="padding-left: 15px;"><?php echo $active; ?></td>
                        </tr>

                        <tr>
                            <th style="padding-left: 15px;">Price:</th>
                            <td style="padding-left: 15px;">$<?php echo $price; ?></td>
                            <!-- &#8362; is the 	new sheqel sign -->
                        </tr>

                        <tr>
                            <td><a href="<?php echo SITE_URL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn btn-block btn-warning">Update</a></td>
                            <td>
                                <a href="<?php echo SITE_URL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn btn-block btn-danger" onclick="return confirm('Are you sure you want to delete this food item: ' + '<?php echo $title; ?>' + ' ?');">Delete</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        <?php
        } // end while
    } // end if
    else {
        ?>
        <div class="alert alert-warning">
            <strong>Warning!</strong> No food items added
        </div>
    <?php
    }
    ?>

</div>

<!-- Main Content Section Ends -->


<?php include('partials/footer.php'); ?>