<?php include('partials/menu.php'); ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<style>
    .text-center {
        text-align: center;
    }

    .no-margin {
        margin: 0;
    }

    .no-padding {
        padding: 0;
    }

    hr {
        margin-bottom: 3px;
        margin-top: 3px;
    }

    .btn-block {
        width: 100%;
        font-size: 120%;
    }

    .btn-add-category:hover {
        color: #FFF;
        background: #28A745;
        /* background: #7bed9f; */
    }

    .container-fluid {
        background-color: #f1f2f6;
    }
</style>
<!-- Main Content Section Starts -->
<div class="container-fluid">

    <h1 class="text-center">Manage Category</h1>

    <br>

    <?php

    //This messgae will be displayed when we add category successfully.
    if (isset($_SESSION['add'])) {
        echo $_SESSION['add'];
        unset($_SESSION['add']);
    }
    if (isset($_SESSION['remove'])) {
        // remove means "remove" the category's image file from the folder
        echo $_SESSION['remove'];
        unset($_SESSION['remove']);
    }
    if (isset($_SESSION['delete'])) {
        // delete means "delete" the category's record from the DB tbl_category
        echo $_SESSION['delete'];
        unset($_SESSION['delete']);
    }
    if (isset($_SESSION['no-category-found'])) {
        //then you are passing category id to "update-category" and this id is not found in the DB
        echo $_SESSION['no-category-found'];
        unset($_SESSION['no-category-found']);
    }
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
    ?>

    <br>

    <!-- Button to Add Category -->
    <a href="<?php echo SITE_URL . "admin/add-category.php" ?>" class="btn btn-default btn-add-category" style="margin-left: 25px;">
        <h3 style="display: inline">Add Category</h3>
        <!-- <span class="glyphicon glyphicon-plus"></span> -->
    </a>

    <br /><br />

    <?php
    //Query to get all categories from DB
    $sql = "SELECT * FROM tbl_category";

    //Execute Query
    $res = mysqli_query($conn, $sql);

    //Count Rows
    $count = mysqli_num_rows($res);

    //Create serial number variable
    $sn = 1;


    //Check wether we have data in DB or not.
    if ($count > 0) {
        // We have data in DB

        //Get the data and display it in table

        while ($row = mysqli_fetch_assoc($res)) {

            $id = $row['id'];
            $title = $row['title'];
            $image_name = $row['image_name'];
            $featured = $row['featured'];
            $active = $row['active'];
    ?>

            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">

                <div class="thumbnail">

                    <?php
                    if ($image_name != "") {
                        //display the image

                        $mySrc = SITE_URL . "images/category/$image_name";
                    } else {
                        //display empty image
                        $mySrc = "https://via.placeholder.com/650x300";
                    }
                    ?>
                    <img src="<?php echo $mySrc; ?>" alt="category_image" style="width:650px; height:300px">

                    <div class="caption text-center" style="padding: 0px;">
                        <h3><?php echo $title; ?></h3>
                    </div>

                    <table class="table table-responsive no-margin no-padding text-center">

                        <tr>
                            <td>Featured</td>
                            <td>Active</td>
                        </tr>

                        <tr>
                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                        </tr>

                        <tr>
                            <td><a href="<?php echo SITE_URL; ?>admin/update-category.php?id=<?php echo $id; ?>" class=" btn btn-block btn-warning">Update</a></td>
                            <td>
                                <a href="<?php echo SITE_URL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn btn-block btn-danger" onclick="return confirm('Are you sure you want to delete this category: ' + '<?php echo $title; ?>' + '?');">Delete</a>
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
            <strong>Warning!</strong> No categories added
        </div>
    <?php
    }
    ?>

</div>

<!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>