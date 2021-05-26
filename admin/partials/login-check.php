<!-- Remember: This page will be included inside "menu.php" file, and we know that
    "menu.php" is including the "config/constants.php"

    So no need to include "config/constants.php" again here.
-->
<?php
// AUTHORIZATION (Access Control):
// Check wehter the user is logged in or not:

if (!isset($_SESSION['user'])) {
    // This session variable is set only if the user has logged in.

    // So if this session variable is not set then don't allow him to view the page.
    // Redirect to "login.php" with messgae

    $_SESSION['no-login-msg'] = "<div class='error text-center'>Please login to access admin panel</div>";

    header("location:" . SITE_URL . "admin/login.php");
}

?>