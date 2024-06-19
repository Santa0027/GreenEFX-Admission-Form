<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <style>

      .invoice {
    width: 50%;
       
 margin: auto;
      }
      .line {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
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
    
    $date = date("d-m-Y");
    session_start();

    // Database connection details (replace with your actual credentials)
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "greenefx_database";

    // Establish connection
    $con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

    // Check connection status
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $sql = "SELECT student_details.C_NAME, student_details.STUDENT_ID, student_details.COURSE, update_log.new_value, update_log.updated_at, update_log.ID, student_details.ID, student_details.BALANCE_FEE
        FROM student_details
        INNER JOIN update_log ON student_details.ID = update_log.ID
        WHERE student_details.ID = '$id'";

    $result = mysqli_query($con, $sql);
    if (!$result) {
        die("error" . mysqli_error($con));
    }
//  INNER JOIN table2 ON table1.common_column = table2.common_column
    
    if (mysqli_num_rows($result) > 0) {
        // Output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row['C_NAME'] . ', ' . $row['STUDENT_ID'] . ', ' . $row['COURSE'] . '<br>';
            // Example of accessing fields, adjust based on your actual column names
        }
    } else {
        echo "No results found for ID: " . $id;
    }



    ?>
    <?php 
    // $date = date("d/m/Y");

    // if (mysqli_num_rows($result) > 0) {
    //     echo ' <div class="invoice">';
    //     echo '   <div class="line">';
    //     echo '     <span';
    //     echo '       ><p>bill no :</p>';
    //     echo '       <p>1230</p></span>';
    //     echo '     <span';
    //     echo '       ><p>date :</p>';
    //     echo '       <p>' . $date . '</p></span';
    //     echo '     >';
    //     echo '   </div>';
    //     echo '   <div class="line">';
    //     echo '     <span';
    //     echo '       ><p>' . $row["C_NAME"] . ' :</p>';
    //     echo '       <p></p></span';
    //     echo '     >';
    //     echo '     <span';
    //     echo '       ><p>student id :</p>';
    //     echo '       <p>12345</p></span';
    //     echo '     >';
    //     echo '     <span';
    //     echo '       ><p>course name :</p>';
    //     echo '       <p>3d & vfx</p></span';
    //     echo '     >';
    //     echo '   </div>';
    //     echo '   <table style="width: 90%; margin: auto">';
    //     echo '     <tr>';
    //     echo '       <th>Date</th>';
    //     echo '       <th>Description</th>';
    //     echo '       <th>Amount (Rs)</th>';
    //     echo '       <th>ps</th>';
    //     echo '     </tr>';
    //     echo '     <tr>';
    //     echo '       <td style="text-align: center; width: 5%"></td>';
    //     echo '       <td style="text-align: left; width: 40%">course fees</td>';
    //     echo '       <td style="text-align: right; width: 40%">12,000</td>';
    //     echo '       <td style="text-align: right; width: 5%; padding: 0;">.00</td>';
    //     echo '     </tr>';
    //     echo '';
    //     echo '     <tr>';
    //     echo '       <td style="text-align: center; width: 5%">1/1/2000</td>';
    //     echo '       <td style="text-align: left; width: 40%">first payment</td>';
    //     echo '       <td style="text-align: right; width: 40%">5,000</td>';
    //     echo '       <td style="text-align: right; width: 5%">.00</td>';
    //     echo '     </tr>';
    //     echo '     <tr>';
    //     echo '       <td style="text-align: center; width: 5%"></td>';
    //     echo '       <td style="text-align: left; width: 40%">balnce</td>';
    //     echo '       <td style="text-align: right; width: 40%">5,000</td>';
    //     echo '       <td style="text-align: right; width: 5%">.00</td>';
    //     echo '     </tr>';
    //     echo '   </table>';
    //     echo ' </div>';
    // }
    ?>
  </body>
</html>