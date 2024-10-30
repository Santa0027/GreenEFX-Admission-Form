<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

// Database credentials
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "greenefx_database";
$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
// phpinfo();

if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

// Assuming $student_id is provided securely, e.g., from a GET request
$student_id = $_GET['id'];

// Query to fetch data from the database
$sql = "SELECT student_details.*, fees_log.*
        FROM student_details
        INNER JOIN fees_log ON student_details.ID = fees_log.STUDENT_DETAILS_ID
        WHERE fees_log.IID = ?";

// Prepare the statement (prevents SQL injection)
$stmt = mysqli_prepare($con, $sql);

if (!$stmt) {
  die("Statement preparation failed: " . mysqli_error($con));
}

// Bind the parameter (safe way to include user input)
mysqli_stmt_bind_param($stmt, "i", $student_id);

// Execute the prepared statement
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

// Check for errors
if (!$result) {
  die("Error in result: " . mysqli_error($con));
}

$num_rows = mysqli_num_rows($result);

if ($num_rows > 0) {
  $invoice_content = '';

  // Initialize DOMPDF
  $dompdf = new Dompdf();

  while ($row = mysqli_fetch_assoc($result)) {
    $date = date("Y-m-d"); // Assuming the current date for the invoice
    $img_path = 'data:image/png;base64,' . base64_encode(file_get_contents("asset/green_logo.png"));

    $invoice_content = "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <style>
                .invoice {
                    width: 100%;
                    font-family: Arial, sans-serif;
                }
                .details p {
                    padding: 0;
                    margin: 5px;
                    font-size: 0.8rem;
                }
                .img_container {
                    width: 50%;
                    margin: auto;
                    text-align: center;
                }
                .logo {
                    width: 60%;
                    position: relative;
                }
                .stu {
                    width: 100%;
                    display: flex;
                    font-size:0.8rem;
                    position:relative;
                    top:50%;
                    
                }
                .stu_id{
                width: 100%;

                   
                }
                .studentid2 {
                    width: 10rem;
                    position: relative;
                    left: 45%;
                }
                .studentid3 {
                    position: relative;
                    left: 80%;
                }
                table {
                    width: 100%;
                
                }
                th, td {
                    
                    padding: 8px;
                    text-align: left;
                    background-color: #f2f2f2;
                    
                }
                th {
                    background-color: #f2f2d2;
                }
                .terms {
                    margin-top: 20px;
                }
                .terms ul {
                    list-style-type: none;
                    padding: 0;
                }
                .terms ul li {
                    margin-bottom: 5px;
                }
            </style>
        </head>
        <body>
            <div class='invoice'>
                <div class='details'>
                    <p>Mobile: +91 9840289462</p>
                    <p>GST No: CDSG0987654321</p>
                </div>
                <div class='img_container'>
                    <img class='logo' src='" . $img_path . "' alt='logo' />
                    <p style='margin: 0'>
                        #508, 1st Floor R.T.O Road, Sathuvachari,<br />
                        Vellore-632009
                    </p>
                </div>
                <div class='stu_id' style='display:flex;'>
                    <span><p style='font-size:0.8rem; margin:0%; padding-top:0%;position: relative;top:5%'><b>Bill No:</b></p><p style='font-size:0.8rem; margin:0%; padding:0%; position:relative;top:8%'>" . $row['ID'] . "</p></span>
                    <span style='padding:0%; margin:0%; '><p style='font-size:0.8rem; margin:0%; padding:0%;position: relative;left:80%;top:5%'><b>Date:</b></p><p style='font-size:0.8rem; margin:0%; padding:0%; position:relative;top:8%;left:80%;'>" . $date . "</p></span>
                </div>
              <div class='stu' style='margin-right:1rem; margin-top:1.5rem;'>
    <span  ><p style='padding:0%; margin:0%; position: relative;top:20%;'><b>Student Name:</b> " . $row['C_NAME'] . "</p> <p style='padding:0%; margin:0%; position: relative;left: 35%; top:20%;'><b> Student ID:</b> " . $row['STUDENT_ID'] . "</p> <p style='padding:0%; margin:0%; position: relative;left: 65%;top:20%;'><b> Course: </b>" . $row['COURSE'] . "</p></span>
</div>
                <table style='padding-top:2rem;'>
                    <tr>
                        <th style='border: 3px solid red; padding: 8px; text-align: left;'>Date</th>
                        <th>Description</th>
                        <th>Amount (Rs)</th>
                        <th>PS</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td style='border: 3px solid red; padding: 8px; text-align: left;'>Course Fees</td>
                        <td style='text-align: right;'>" . $row['FEES'] . "</td>
                        <td>.00</td>
                    </tr>
                    <tr>
                        <td>" . $row['F_DATE'] . "</td>
                        <td style='text-align: left;'>" . $row['COURSE'] . " Payment</td>
                        <td style='text-align: right;'>" . $row['FEES_UPDATE'] . "</td>
                        <td>.00</td>
                    </tr>
                    <tr>
                        <td colspan='4'rowspan='3'></td>
                        
                    </tr>
                    <tr>
                        
                    </tr>
                    <tr>
                        
                    </tr>
                    <tr>
                        <td></td>
                        <td style='text-align: left;' rowspan=''>Balance</td>
                        <td style='text-align: right;'>" . $row['BALANCE'] . "</td>
                        <td>.00</td>
                    </tr>
                </table>
                <div class='terms'>
                    <h3>Terms and Conditions</h3>
                    <ul>
                        <li>Lorem ipsum dolor sit amet.</li>
                        <li>Lorem ipsum dolor sit amet consectetur.</li>
                        <li>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</li>
                    </ul>
                </div>
            </div>
        </body>
        </html>";
  }

  $dompdf->loadHtml($invoice_content);
  $dompdf->setPaper('A4', 'portrait');
  $dompdf->render();

  // Stream the PDF to the browser
  $dompdf->stream("invoice.pdf", array('Attachment' => 0));
} else {
  echo "No records found.";
}

mysqli_close($con);
?>