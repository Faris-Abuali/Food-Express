<?php
// Include constans.php to reach SITEURL
include("../config/constants.php");

// 1. Destroy the session
session_unset();

session_destroy(); // unset $_SESSION['user]

// 2. Redirect to login page

header('location:' . SITE_URL . 'admin/login.php');
