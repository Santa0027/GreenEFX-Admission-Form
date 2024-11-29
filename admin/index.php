<?php

// Validate that the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $db_server = "localhost";
  $db_user = "root";
  $db_pass = "";
  $db_name = "greenefx_database";
  // Connect to the database
  $con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

  // Check connection
  if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Sanitize and validate input data
  $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
  $lowercaseText = strtolower($first_name);
  $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
  $name = $first_name . ' ' . $last_name;
  $full_name = strtolower($name);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $date = mysqli_real_escape_string($con, $_POST['date']);
  $month = mysqli_real_escape_string($con, $_POST['month']);
  $year = mysqli_real_escape_string($con, $_POST['year']);
  $DOB = $date . "/" . $month . "/" . $year;
  $phone = mysqli_real_escape_string($con, $_POST['phone']);
  $addi_phone = mysqli_real_escape_string($con, $_POST['secound_phone']);
  $address = mysqli_real_escape_string($con, $_POST['address']);
  $f_name = mysqli_real_escape_string($con, $_POST['father_name']);
  $m_name = mysqli_real_escape_string($con, $_POST['mother_name']);
  $gender = mysqli_real_escape_string($con, $_POST['gender']);
  $qualification = mysqli_real_escape_string($con, $_POST['qualification']);
  $feild_status = mysqli_real_escape_string($con, $_POST['feild_status']);
  $course = mysqli_real_escape_string($con, trim($_POST['course']));

  // Print the course value for debugging


  // Convert course to lowercase for case-insensitive comparison
  $course = strtolower($course);

  // Current date
  $current_date = date("d/m/Y");

  // Determine fees based on the course
  $fees = "";
  switch ($course) {
    case "dtp":
    case "dca":
      $fees = "6000";
      break;
    case "pgdca":
    case "diploma in graphics designing":
    case "diploma in web designing":
    case "diploma in video editing":
    case "diploma in ui/ux designing":
      $fees = "12000";
      break;
    case "graphics crash course":
      $fees = "16000";
      break;
    case "diploma in 3d & vfx":
      $fees = "30000";
      break;
    case "advance diploma in 3d & vfx":
      $fees = "60000";
      break;
    case "specialized in advance houdini effects":
    case "specialized in advance digital crowd":
    case "specialized in advance character effects":
    case "specialized in advance character animation":
      $fees = "100000";
      break;
    default:
      $fees = "N/A";
  }

  // Print the fees value for debugging

  if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
    // Check the file size (max 3MB = 3 * 1024 * 1024 bytes)
    $maxFileSize = 3 * 1024 * 1024; // 3MB
    $fileSize = $_FILES['image']['size'];

    if ($fileSize > $maxFileSize) {
      die("Uploaded image size exceeds 3MB limit.");
    }

    // Read the image file and encode it to base64
    $image = file_get_contents($_FILES['image']['tmp_name']);
    $image = base64_encode($image);
  } else {
    $image = '';
  }

  // Insert a preliminary record without STUDENT_ID
  $stmt = $con->prepare("INSERT INTO student_details (C_NAME, PHOTO, A_DATE, EMAIL, DOB, PHONE_NO, PHONE_2, C_ADDRESS, F_NAME, M_NAME, GENDER, QUALIFICATION, FEILD_OF_WORK, COURSE, FEES) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssssssssssssss", $full_name, $image, $current_date, $email, $DOB, $phone, $addi_phone, $address, $f_name, $m_name, $gender, $qualification, $feild_status, $course, $fees);

  if ($stmt->execute()) {
    // Get the last inserted ID to generate a student ID
    $last_id = $con->insert_id;
    $student_id = generateStudentID($last_id);

    // Update the record with the generated student ID
    $update_stmt = $con->prepare("UPDATE student_details SET STUDENT_ID = ? WHERE id = ?");
    $update_stmt->bind_param("si", $student_id, $last_id);

    if ($update_stmt->execute()) {
      echo "successfully with Student ID: $student_id";
    } else {
      echo "Error updating record: " ;
    }

    $update_stmt->close();
  } else {
    echo "Error: " . $stmt->error;
  }

  // Close statement and connection
  $stmt->close();
  $con->close();
}

// Function to generate student ID
function generateStudentID($id)
{
  $prefix = "GFX_2K" . date("y")."_";
  return $prefix . $id;
}

?>


