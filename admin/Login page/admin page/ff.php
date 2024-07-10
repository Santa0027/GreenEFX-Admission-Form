<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fee_id = $_POST['fee_id'];
  $new_fee = $_POST['new_fee'];

// Database connection details (replace with your actual credentials)
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "greenefx_database";
 // Get the student ID from POST data

// Establish connection
$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);


  // Prepare and execute the update query with placeholders
  $sql = "UPDATE student_details SET FEES = ? WHERE id = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "di", $new_fee, $fee_id);
  if (mysqli_stmt_execute($stmt)) {
    $message = $new_fee;
  } else {
    $message = "Error";
  }

  mysqli_stmt_close($stmt);
  mysqli_close($con);

  echo $message; // Send response back to JavaScript
} else {
  echo "Invalid request method."; // Handle invalid requests
}
 // Send the fee data back to the AJAX request



// echo"<script>alert("$fee")</script>";


?>