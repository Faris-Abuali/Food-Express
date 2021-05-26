<?php include("config/constants.php"); ?>
<!-- Remember that this "menu.php" is included in all pages :index,foods,food-search,categories,
category-foods,order. So we need to only enter the "config" folder then we will see the 
"constants.php" file -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="<?php echo SITE_URL; ?>" title="Logo">
                    <img src="images/logo.png" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>

            <div class="menu text-right">
                <ul>
                    <li>
                        <a href="<?php echo SITE_URL; ?>">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo SITE_URL; ?>categories.php">Categories</a>
                    </li>
                    <li>
                        <a href="<?php echo SITE_URL; ?>foods.php">Foods</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                    <li>
                        <a href="<?php echo SITE_URL ?>admin/">Admin Panel</a>
                    </li>
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->