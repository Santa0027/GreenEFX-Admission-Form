<?php

// Database connection details (replace with your credentials)
$db_server = "localhost";
$db_user = "root";
// Update with a strong password!
$db_pass = "";
$db_name = "greenefx_database";

// Establish connection
$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start(); // If not essential for this script, consider removing it




?>