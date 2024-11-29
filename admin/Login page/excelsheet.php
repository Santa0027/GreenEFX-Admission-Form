<?php
 include 'config.php';
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database credentials



// Create a connection
$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Include PhpSpreadsheet classes (for Composer install)
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Check if the download button was clicked
if (isset($_POST['download_excel'])) {
    // Create a new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set headers for the Excel sheet
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Student ID');
    $sheet->setCellValue('C1', 'Name');
    $sheet->setCellValue('D1', 'Email');
    $sheet->setCellValue('E1', 'Date of Birth');
    $sheet->setCellValue('F1', 'Phone');
    $sheet->setCellValue('G1', 'Secondary Phone');
    $sheet->setCellValue('H1', 'Address');
    $sheet->setCellValue('I1', 'Father\'s Name');
    $sheet->setCellValue('J1', 'Mother\'s Name');
    $sheet->setCellValue('K1', 'Gender');
    $sheet->setCellValue('L1', 'Qualification');
    $sheet->setCellValue('M1', 'Field of Work');
    $sheet->setCellValue('N1', 'Course');
    $sheet->setCellValue('O1', 'Admission Date');
    $sheet->setCellValue('P1', 'Fees');
    $sheet->setCellValue('Q1', 'Paid Fee');
    $sheet->setCellValue('R1', 'Balance Fee');

    // Fetch data from the database
    $sql = "SELECT ID, STUDENT_ID, C_NAME, EMAIL, DOB, PHONE_NO, PHONE_2, C_ADDRESS, F_NAME, M_NAME, GENDER, QUALIFICATION, FEILD_OF_WORK, COURSE, A_DATE, FEES, PAID_FEE, BALANCE_FEE 
            FROM student_details";
    $result = $con->query($sql);

    if ($result && $result->num_rows > 0) {
        $rowCount = 2;  // Start from the second row
        while ($row = $result->fetch_assoc()) {
            $sheet->setCellValue('A' . $rowCount, $row['ID']);
            $sheet->setCellValue('B' . $rowCount, $row['STUDENT_ID']);
            $sheet->setCellValue('C' . $rowCount, $row['C_NAME']);
            $sheet->setCellValue('D' . $rowCount, $row['EMAIL']);
            $sheet->setCellValue('E' . $rowCount, $row['DOB']);
            $sheet->setCellValue('F' . $rowCount, $row['PHONE_NO']);
            $sheet->setCellValue('G' . $rowCount, $row['PHONE_2']);
            $sheet->setCellValue('H' . $rowCount, $row['C_ADDRESS']);
            $sheet->setCellValue('I' . $rowCount, $row['F_NAME']);
            $sheet->setCellValue('J' . $rowCount, $row['M_NAME']);
            $sheet->setCellValue('K' . $rowCount, $row['GENDER']);
            $sheet->setCellValue('L' . $rowCount, $row['QUALIFICATION']);
            $sheet->setCellValue('M' . $rowCount, $row['FEILD_OF_WORK']);
            $sheet->setCellValue('N' . $rowCount, $row['COURSE']);
            $sheet->setCellValue('O' . $rowCount, $row['A_DATE']);
            $sheet->setCellValue('P' . $rowCount, $row['FEES']);
            $sheet->setCellValue('Q' . $rowCount, $row['PAID_FEE']);
            $sheet->setCellValue('R' . $rowCount, $row['BALANCE_FEE']);
            $rowCount++;
        }
    } else {
        die("No data found or query failed: " . $con->error);
    }

    // Set the file name for download
    $fileName = "student_details_export.xlsx";

    // Set headers to prompt download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');

    // Output the Excel file to download
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    // End script to prevent additional output
    exit;
}

// Close the database connection
mysqli_close($con);
?>
