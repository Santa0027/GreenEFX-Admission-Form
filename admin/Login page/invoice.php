<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice</title>
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
        .fotter{
            display:flex;
            flex-direction:row;
            justify-content:space-between;
            
        }
    </style>
</head>

<body>

    <?php
     include 'config.php';

    $date = date("d/m/Y");

 
    $student_id = $_GET["id"];

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

                echo '  <div class="invoice" style="margin-top:5rem;">';
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
                echo '      <span><p>bill no :</p><p>' . $row['IID'] . '</p></span>';
                echo '      <span><p>date :</p><p>' . $date . '</p></span>';
                echo '    </div>';
                echo '    <div class="line">';
                echo '      <span><p>student name :</p><p>' . $row['C_NAME'] . '</p></span>';
                echo '      <span><p>student id :</p><p>' . $row['STUDENT_ID'] . '</p></span>';
                echo '      <span><p>course name :</p><p>' . $row['COURSE'] . '</p></span>';
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

                echo '      <tr>';
                echo '        <td style="text-align: center; width: 5%">' . $row['F_DATE'] . '</td>';
                echo '        <td style="text-align: left; width: 40%">Payment (' . $row['PAYMENT_MODE'] . ')</td>';
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
                echo '        <td style="text-align: right; width: 40%">' . $row['BALANCE'] . '</td>';
                echo '        <td style="text-align: left; width: 5%; padding: 3px">.00</td>';
                echo '      </tr>';
                echo '    </table>';
                echo '';
                echo '    <h3>Terms and Condition</h3>';
                echo '    <ul>';
                echo '      <li>By enrolling in the course, you agree to comply with these terms.</li>';
                echo '      <li>Payment must be completed before the start of the course. </li>';
                echo '      <li>No refunds will be provided once the course has commenced.</li>';
                echo '      <li>Late payments may incur additional charges or result in enrollment cancellation.</li>';
                echo '    </ul>';
                echo '     <div class="fotter">';
                echo '<a href="download.php?id=' . $row['IID'] . '" class="btn btn-danger" target="download.php">Print Invoice</a>';
                echo '<a>this is a computer generated invoice and requires no signature</a>';
                echo '</divs>';
                echo '  </div>';
            }
        } else {
            echo '<div class="report">Data Not Found</div>';
        }
    }

    ?>

</body>

</html>
