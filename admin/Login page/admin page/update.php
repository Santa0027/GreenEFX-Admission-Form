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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input (example using basic checks)
    $fees = $_POST['fees'];
    $paid = $_POST['paid'];


    if (!$fees || !$paid) {
        echo "Invalid fees or paid amount. Please enter positive numeric values.";
        exit();
    }

    // Calculate balance
    $balance = $fees - $paid;

    // Check if ID parameter exists
    
    $id = $_POST["id"];// Assuming ID is retrieved from GET request
    echo 'sd'.$id;
    // Prepare and execute SQL statement (prevent SQL injection)
    $sql = "UPDATE student_details SET FEES = ?, PAID_FEE = ?, BALANCE_FEE = ? WHERE ID = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $fees, $paid, $balance, $id);
    $result = mysqli_stmt_execute($stmt);
    
    if ($result) {
        echo "Student fees updated successfully!";
    } else {
        // Enhanced error handling
        $error_message = mysqli_stmt_error($stmt);
        $error_code = mysqli_stmt_errno($stmt);

        // Log the error
        error_log("Error updating student fees (code: $error_code, message: $error_message)");

        echo "Error updating student fees: $error_message";
    }

    mysqli_stmt_close($stmt); // Close prepared statement
}
mysqli_close($con); // Close database connection

?>
