<?php
// Database connection details
include 'config.php';

// Establish connection
$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start(); // Start session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $paid = $_POST['paid'];
    $id = $_POST["id"];
    $payment_mode = $_POST["paymentMode"];
    $payment_date = $_POST["paymentdate"];
    $today = date('Y-m-d');

    // Validate the payment date
// Check if payment date is in the future
if ($payment_date > $today) {
    echo "<script type='text/javascript'>
            alert('Invalid date. You cannot select a future date.');
            window.history.back(); // Go back to the previous page
          </script>";
    exit(); // Stop further script execution
}

// Check if the payment date is more than 30 days in the past
$thirty_days_ago = date('Y-m-d', strtotime('-30 days'));
if ($payment_date < $thirty_days_ago) {
    echo "<script type='text/javascript'>
            alert('Invalid date. You cannot select a date older than 30 days.');
            window.history.back(); // Go back to the previous page
          </script>";
    exit(); // Stop further script execution
}

    // Fetch current paid fee from the database
    $fetch_sql = "SELECT PAID_FEE, FEES FROM student_details WHERE ID = ?";
    $stmt_fetch = mysqli_prepare($con, $fetch_sql);

    if ($stmt_fetch) {
        mysqli_stmt_bind_param($stmt_fetch, "i", $id);
        mysqli_stmt_execute($stmt_fetch);
        mysqli_stmt_bind_result($stmt_fetch, $current_paid_fee, $fees);
        mysqli_stmt_fetch($stmt_fetch);

        // Calculate new paid fee and balance fee
        $new_paid_fee = $current_paid_fee + $paid;
        $balance_fee = $fees - $new_paid_fee;

        // Close the fetch statement
        mysqli_stmt_close($stmt_fetch);

        // Check if the paid fee has changed
        if ($current_paid_fee != $new_paid_fee) {
            // Calculate fees update difference
            $fees_update = $new_paid_fee - $current_paid_fee;

            // Log payment details into fees_log
            $log_sql = "INSERT INTO fees_log (STUDENT_DETAILS_ID, FEES_UPDATE, BALANCE, PAYMENT_MODE, F_DATE) 
                        VALUES (?, ?, ?, ?, ?)";
            $stmt_log = $con->prepare($log_sql);

            if ($stmt_log) {
                // Bind parameters, now using the calculated $fees_update
                $stmt_log->bind_param("idiss", $id, $fees_update, $balance_fee, $payment_mode, $payment_date);

                // Execute the log insertion
                if ($stmt_log->execute()) {
                    // Proceed to update student details
                    $update_sql = "UPDATE student_details SET PAID_FEE = ?, BALANCE_FEE = ? WHERE ID = ?";
                    $stmt_update = mysqli_prepare($con, $update_sql);

                    if ($stmt_update) {
                        mysqli_stmt_bind_param($stmt_update, "ddi", $new_paid_fee, $balance_fee, $id);
                        $result = mysqli_stmt_execute($stmt_update);

                        if ($result) {
                            echo "<script> window.location.href = 'fee.php';</script>";
                        } else {
                            // Log error
                            error_log("Error updating student fees: " . mysqli_stmt_error($stmt_update));
                            echo "Error updating student fees: " . mysqli_stmt_error($stmt_update);
                        }

                        mysqli_stmt_close($stmt_update); // Close prepared statement
                    } else {
                        echo "Error preparing update statement: " . mysqli_error($con);
                    }
                } else {
                    echo "Error logging payment details: " . $stmt_log->error;
                }

                $stmt_log->close(); // Close the log statement
            } else {
                echo "Error preparing log statement: " . $con->error;
            }
        } else {
            echo "No change in paid fee. No log entry made.";
        }
    } else {
        echo "Error preparing fetch statement: " . mysqli_error($con);
    }
}

mysqli_close($con); // Close database connection
?>
