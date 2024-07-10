<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;
// Database credentials
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "greenefx_database";
$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Assuming $student_id is provided securely, e.g., from a POST request
$student_id = $_GET['id'];

// Query to fetch data from the database
$sql = "SELECT student_details.*, fees_log.*
        FROM student_details
        INNER JOIN fees_log ON student_details.ID = fees_log.STUDENT_DETAILS_ID
        WHERE fees_log.IID = ?";

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
    exit;
}

$num_rows = mysqli_num_rows($result);

if ($num_rows > 0) {
    $invoice_content = '';

    // Assuming usage of a library like Dompdf for PDF generation
    

    $dompdf = new Dompdf();

    while ($row = mysqli_fetch_assoc($result)) {
        $invoice_content .= "
        <div class='invoice' style='margin-top:5rem;'>
            <div class='details'>
                <p>Mobile: +91 9840289462</p>
                <p>GST No: CDSG0987654321</p>
            </div>
            <div class='img_container'>
                <img class='logo' src='asset/green_logo.png' alt='logo' />
                <p style='margin: 0'>
                    #508, 1st Floor R.T.O Road, Sathuvachari, <br />
                    Vellore-632009
                </p>
            </div>
            <div class='line'>
                <span><p>Bill No:</p><p>{$row['ID']}</p></span>
                <span><p>Date:</p><p>" . date('Y-m-d') . "</p></span>
            </div>
            <div class='line'>
                <span><p>Student Name:</p><p>{$row['C_NAME']}</p></span>
                <span><p>Student ID:</p><p>{$row['STUDENT_ID']}</p></span>
                <span><p>Course Name:</p><p>{$row['COURSE']}</p></span>
            </div>
            <table style='width: 90%; margin: auto'>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Amount (Rs)</th>
                    <th>Ps</th>
                </tr>
                <tr>
                    <td style='text-align: center; width: 5%'></td>
                    <td style='text-align: left; width: 40%'>Course Fees</td>
                    <td style='text-align: right; width: 40%'>{$row['FEES']}</td>
                    <td style='text-align: left; width: 5%; padding: 3px'>.00</td>
                </tr>
                <tr>
                    <td style='text-align: center; width: 5%'>{$row['F_DATE']}</td>
                    <td style='text-align: left; width: 40%'>{$row['COURSE']} Payment</td>
                    <td style='text-align: right; width: 40%'>{$row['FEES_UPDATE']}</td>
                    <td style='text-align: left; width: 5%; padding: 3px'>.00</td>
                </tr>
                <tr>
                    <td colspan='4'>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan='4'>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan='4'>&nbsp;</td>
                </tr>
                <tr>
                    <td style='text-align: center; width: 5%'></td>
                    <td style='text-align: left; width: 40%'>Balance</td>
                    <td style='text-align: right; width: 40%'>{$row['BALANCE']}</td>
                    <td style='text-align: left; width: 5%; padding: 3px'>.00</td>
                </tr>
            </table>
            <h3>Terms and Condition</h3>
            <ul>
                <li>Lorem ipsum dolor sit amet.</li>
                <li>Lorem ipsum dolor sit amet consectetur.</li>
                <li>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</li>
            </ul>
        </div>";
    }

    $dompdf->loadHtml($invoice_content);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("invoice.pdf", array("Attachment" => 1));
} else {
    echo "No records found.";
}

mysqli_close($con);

?>


