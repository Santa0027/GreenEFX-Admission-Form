<?php

// Database connection details
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "greenefx_database";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fee_id = $_POST['fee_id'];
  $new_fee = $_POST['new_fee'];

  // Establish connection
  $con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

  // Check connection
  if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Prepare SQL query to get the current FEES for the specific student
  $sql = "SELECT FEES FROM student_details WHERE id = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "i", $fee_id); // Bind the student ID as an integer
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $actual_fees);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);

  // Check if the new fee is less than the current fee
  if ($new_fee < $actual_fees) {
    echo "<script>alert('error');</script>";
  } else {
    // Prepare and execute the update query with placeholders
    $sql = "UPDATE student_details SET FEES = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "di", $new_fee, $fee_id);
    
    if (mysqli_stmt_execute($stmt)) {
      echo  $new_fee;
    } else {
      echo "Error updating fee.";
    }

    mysqli_stmt_close($stmt);
  }

  mysqli_close($con); // Close the connection
} else {
  echo "Invalid request method."; // Handle invalid requests
}

?>
