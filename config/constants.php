<?php
// Start Session:

session_start();

// Session will be started all over the website pages, because this file will be included
// whenver a page includes the menu.php file. And all pages will include the menu.php file.
// So, all pages will access this session.

define('SITE_URL', "http://localhost/food-order/");
// _______________________________________________________________
// Create Constants To Store Non-Repeating Values.
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'food-order');


// 3. Execute Query and Save Data in Database
//Database Connection:
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));

//Select the database name:
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));

date_default_timezone_set('Asia/Jerusalem');
