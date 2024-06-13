<?php

// database crediniate
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "greenefx_enquiry_details";
$con = "";
$con = mysqli_connect(
    $db_server,
    $db_user,
    $db_pass,
    $db_name
);



// Query to fetch data from the database
      $sql = "SELECT * FROM enquiry_data";
      $result = $con->query($sql);

      // Set headers for file download
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment; filename="data.xls"');

      // Open file handle
      $$excel_output = '';
      $excel_output .= "ID\tC_NAME\tEMAIL\tDOB\tPHONE_NO\tC_ADDRESS\tGENDER\tCURRENT_STATUS\tFEILD_OF_WORK\tCOURSE\tINTERESTED\tOTHER_COURSE\tREASON\tHEAR_US\tPROMATION\n"; // Excel column headers


      // Fetch and format data rows
      while ($row = $result->fetch_assoc()) {
        $excel_output .= $row['SI_NO'] . "\t" . $row['C_NAME'] . "\t" . $row['EMAIL'] . "\t" . $row['DOB'] . "\t" . $row['PHONE_NO']."\t". $row['C_ADDRESS'] . "\t" . $row['GENDER'] . "\t" . $row['CURRENT_STATUS'] . "\t" . $row['FEILD_OF_WORK'] . "\t" . $row['COURSE'] . "\t" . $row['INTERESTED'] . "\t" . $row['OTHER_COURSE'] . "\t" . $row['REASON'] . "\t" . $row['HEAR_US'] . "\t" . $row['PROMATION']."\n";
      }


  // Output Excel data
  echo $excel_output;

  $con->close();

?>