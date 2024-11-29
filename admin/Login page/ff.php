<?php




session_start();
include 'config.php';

// Set timeout period in seconds (e.g., 1800 seconds = 30 minutes)
$timeout_duration = 1800;

// Check if the timeout key exists in session
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: login.php"); // Redirect to login page
    exit();
}

// Update last activity time
$_SESSION['LAST_ACTIVITY'] = time();


// Database connection details


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
