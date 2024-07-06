<?php

// Database connection details (replace with your credentials)
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "greenefx_database";

// Establish connection
$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start(); // Start session if not already started

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input (example using basic checks)

    $paid = $_POST['paid'];
    $id = $_POST["id"];

   

    // Fetch current paid fee from the database
    $fetch_sql = "SELECT PAID_FEE,FEES FROM student_details WHERE ID = ?";
    $stmt_fetch = mysqli_prepare($con, $fetch_sql);

    if ($stmt_fetch) {
        mysqli_stmt_bind_param($stmt_fetch, "i", $id);
        mysqli_stmt_execute($stmt_fetch);
        mysqli_stmt_bind_result($stmt_fetch, $current_paid_fee,$fees);
        mysqli_stmt_fetch($stmt_fetch);

        // Calculate new paid fee and balance fee
        $new_paid_fee = $current_paid_fee + $paid;
        $balance_fee = $fees - $new_paid_fee;

        // Close the fetch statement
        mysqli_stmt_close($stmt_fetch);

        // Update fees in the database
        $update_sql = "UPDATE student_details SET FEES = ?, PAID_FEE = ?, BALANCE_FEE = ? WHERE ID = ?";
        $stmt_update = mysqli_prepare($con, $update_sql);

        if ($stmt_update) {
            mysqli_stmt_bind_param($stmt_update, "dddi", $fees, $new_paid_fee, $balance_fee, $id);
            $result = mysqli_stmt_execute($stmt_update);

            if ($result) {
                echo "<script> window.location.href = 'fees.php';</script>";
            } else {
                // Enhanced error handling
                $error_message = mysqli_stmt_error($stmt_update);
                $error_code = mysqli_stmt_errno($stmt_update);

                // Log the error
                error_log("Error updating student fees (code: $error_code, message: $error_message)");

                echo "Error updating student fees: $error_message";
            }

            mysqli_stmt_close($stmt_update); // Close prepared statement for update
        } else {
            // Error preparing statement
            $error_message = mysqli_error($con);
            echo "Error preparing update statement: $error_message";
        }
    } else {
        // Error preparing statement
        $error_message = mysqli_error($con);
        echo "Error preparing fetch statement: $error_message";
    }
}

mysqli_close($con); // Close database connection
?>