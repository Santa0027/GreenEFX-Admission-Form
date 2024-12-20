<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
  <style>
    .invoice {
      width: 50%;
      margin: auto;
      border: 1px solid black;
      padding: 3rem;
    }

    .details p {
      padding: 0;
      margin: 5px;
      font-size: 0.8rem;
    }

    .logo {
      width: 60%;
      position: relative;
    }

    .img_container {
      width: 50%;
      margin: auto;
      text-align: center;
      font-family: "Roboto Slab", serif;
      font-weight: 600;
      font-size: 0.9rem;
      text-transform: uppercase;
    }

    .line {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      width: 88%;
      margin: auto;
    }

    .line span {
      display: flex;
      flex-direction: row;
    }

    table,
    th {
      border: 1px solid black;
      border-collapse: collapse;
    }

    td {
      border-left: 1px solid black;
      border-right: 1px solid black;
      border-collapse: collapse;
      padding: 0.5rem 1rem;
    }
  </style>
</head>

<body>






  <?php
   include 'config.php';
  $date = date("d/m/Y");

  // Database connection details (replace with your actual credentials)



  // Establish connection
  $con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

  // Check connection status
  if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }


$sql = "SELECT student_details.*, fees_log.*
        FROM student_details
        INNER JOIN fees_log ON student_details.ID = fees_log.STUDENT_DETAILS_ID
        WHERE student_details.ID = ?";

// Prepare the statement (prevents SQL injection)
$stmt = mysqli_prepare($con, $sql);

// Bind the parameter (safe way to include user input)
mysqli_stmt_bind_param($stmt, "i", $student_id);

// Execute the prepared statement
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);


  // Check for errors
  if (!$result) {
    echo "Error in result: " . mysqli_error($con);
  } else {
    // Check for rows
    $num_rows = mysqli_num_rows($result);


    if ($num_rows > 0) {
      // Loop through results
      $invoice_content = '';

      while ($row = mysqli_fetch_assoc($result)) {

        echo '  <div class="invoice" style= "margin-top:5rem;">';
        echo '    <div class="details">';
        echo '      <p>Mobile : +91 9840289462</p>';
        echo '      <p>GST No : CDSG0987654321</p>';
        echo '    </div>';
        echo '    <div class="img_container">';
        echo '      <img class="logo" src="asset/green_logo.png" alt="logo" />';
        echo '      <p style="margin: 0">';
        echo '        #508, 1st Floor R.T.O Road, Sathuvachari, <br />';
        echo '        Vellore-632009';
        echo '      </p>';
        echo '    </div>';
  
        echo '    <div class="line">';
        echo '      <span';
        echo '        ><p>bill no :</p>';
        echo '        <p>'.$row['ID'].'</p></span';
        echo '      >';
        echo '      <span';
        echo '        ><p>date :</p>';
        echo '        <p>' . $date . '</p></span';
        echo '      >';
        echo '    </div>';
        echo '    <div class="line">';
        echo '      <span';
        echo '        ><p>student name :</p>';
        echo '        <p>' . $row['C_NAME'] . '</p></span';
        echo '      >';
        echo '      <span';
        echo '        ><p>student id :</p>';
        echo '        <p>' . $row['STUDENT_ID'] . '</p></span';
        echo '      >';
        echo '      <span';
        echo '        ><p>course name :</p>';
        echo '        <p>' . $row['COURSE'] . '</p></span';
        echo '      >';
        echo '    </div>';
        echo '    <table style="width: 90%; margin: auto">';
        echo '      <tr>';
        echo '        <th>Date</th>';
        echo '        <th>Description</th>';
        echo '        <th>Amount (Rs)</th>';
        echo '        <th>ps</th>';
        echo '      </tr>';
        echo '      <tr>';
        echo '        <td style="text-align: center; width: 5%"></td>';
        echo '        <td style="text-align: left; width: 40%">course fees</td>';
        echo '        <td style="text-align: right; width: 40%">' . $row['FEES'] . '</td>';
        echo '        <td style="text-align: left; width: 5%; padding: 3px">.00</td>';
        echo '      </tr>';
        echo '';


        echo '      <tr>';
        echo '        <td style="text-align: center; width: 5%">' . $row['F_DATE'] . '</td>';
        echo '        <td style="text-align: left; width: 40%">' . $row['COURSE'] . '  Payment</td>';
        echo '        <td style="text-align: right; width: 40%">' . $row['FEES_UPDATE'] . '</td>';
        echo '        <td style="text-align: left; width: 5%; padding: 3px">.00</td>';
        echo '      </tr>';

        echo '      <tr>';
        echo '        <td></td>';
        echo '        <td></td>';
        echo '        <td></td>';
        echo '      </tr>';
        echo '      <tr>';
        echo '        <td></td>';
        echo '        <td></td>';
        echo '        <td></td>';
        echo '      </tr>';
        echo '      <tr>';
        echo '        <td></td>';
        echo '        <td></td>';
        echo '        <td></td>';
        echo '      </tr>';
        echo '      <tr>';
        echo '        <td style="text-align: center; width: 5%"></td>';
        echo '        <td style="text-align: left; width: 40%">balance</td>';
        echo '        <td style="text-align: right; width: 40%">' . $row['BALANCE_FEE'] . '</td>';
        echo '        <td style="text-align: left; width: 5%; padding: 3px">.00</td>';
        echo '      </tr>';
        echo '    </table>';
        echo '';
        echo '    <h3>Terms and Condition</h3>';
        echo '    <ul>';
        echo '      <li>Lorem ipsum dolor sit amet.</li>';
        echo '      <li>Lorem ipsum dolor sit amet consectetur.</li>';
        echo '      <li>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</li>';
        echo '    </ul>';
        echo '<a href="pdf.php" class="btn btn-danger" target="_blank">Invoice PDF</a>';
        echo '  </div>';


       
      }
    }



  }




















  ?>
</body>

</html>