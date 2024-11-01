<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../index.html"); // Redirect to login page if not logged in
    exit();
}

// Check if `STUDENT_ID` is provided in the URL
if (!isset($_GET['search_term'])) {
    die("Student ID not provided.");
}

$student_id = $_GET['search_term'];

// Database connection
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "greenefx_database";
$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve student details
$sql = "SELECT * FROM student_details WHERE STUDENT_ID = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "s", $student_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    require('fpdf.php'); // Include FPDF library

    $pdf = new FPDF();
    $pdf->AddPage();

    // Title
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Student Report', 0, 1, 'C');

    // Student Details
    $pdf->SetFont('Arial', '', 12);
    $pdf->Ln(10);
    $pdf->Cell(40, 10, "Student ID: " . $row['STUDENT_ID']);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Name: " . $row['C_NAME']);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Father's Name: " . $row['F_NAME']);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Mother's Name: " . $row['M_NAME']);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Email: " . $row['EMAIL']);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Phone: " . $row['PHONE_NO']);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Address: " . $row['C_ADDRESS']);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Gender: " . $row['GENDER']);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Qualification: " . $row['QUALIFICATION']);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Field of Work/Study: " . $row['FEILD_OF_WORK']);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Course: " . $row['COURSE']);
    $pdf->Ln();

    // Output the PDF as a download
    $pdf->Output('D', 'Student_Report_' . $row['STUDENT_ID'] . '.pdf');

} else {
    echo "No data found for the provided Student ID.";
}

mysqli_close($con);
?>
