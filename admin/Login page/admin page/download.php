<?php

// database crediniate
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "greenefx_database";
$con = "";
$con = mysqli_connect(
    $db_server,
    $db_user,
    $db_pass,
    $db_name
);



// Query to fetch data from the database
      $sql = "SELECT * FROM student_details";
      $result = $con->query($sql);

      header('Content-Type: application/pdf'); // Set content type as PDF
      header('Content-Disposition: attachment;filename=invoice.pdf'); // Set filename and download behavior

// Open file handle
      $$excel_output = '';
      $excel_output .= "ID\tC_NAME\tEMAIL\tDOB\tPHONE_NO\tC_ADDRESS\tGENDER\tCURRENT_STATUS\tFEILD_OF_WORK\tCOURSE\tINTERESTED\tOTHER_COURSE\tREASON\tHEAR_US\tPROMATION\n"; // Excel column headers

  // Output Excel data
  echo $excel_output;

  $con->close();

?>