<?php

// Database credentials
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "greenefx_database";

// Create a connection
$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Include PhpSpreadsheet classes (for Composer install)
require 'vendor/autoload.php'; // Path to PhpSpreadsheet's autoload.php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// If the download button is clicked
if (isset($_POST['download_excel'])) {

    // Create a new Spreadsheet object
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set the header for the first row
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Name');
    $sheet->setCellValue('C1', 'Email');

    // Fetch data from the MySQL database
    $sql = "SELECT ID, C_NAME, EMAIL FROM student_details";  // Adjust the query based on your table
    $result = $con->query($sql);

    // If rows are returned, populate the Excel sheet
    if ($result->num_rows > 0) {
        $rowCount = 2;  // Start from the second row
        while ($row = $result->fetch_assoc()) {
            $sheet->setCellValue('A' . $rowCount, $row['ID']);
            $sheet->setCellValue('B' . $rowCount, $row['C_NAME']);
            $sheet->setCellValue('C' . $rowCount, $row['EMAIL']);
            $rowCount++;
        }
    }

    // Set the file name for download
    $fileName = "database_export.xlsx";

    // Send headers for the Excel file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');

    // Write the file to the output
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');  // This outputs the file for download

    // End the script
    exit;
}
?>
