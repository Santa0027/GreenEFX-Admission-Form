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
        <div
      style='width: 50%; margin: auto; border: 1px solid black; padding: 3rem'
    >
      <div>
        <p style='padding: 0; margin: 5px; font-size: 0.8rem'>
          Mobile : +91 9840289462
        </p>
        <p style='padding: 0; margin: 5px; font-size: 0.8rem'>
          GST No : CDSG0987654321
        </p>
      </div>
      <div style='width: 50%; margin: auto; text-align: center'>
        <img
          style='width: 60%; position: relative'
          src='assert/green_logo.png'
          alt='logo'
        />
        <p>
          #508, 1st Floor R.T.O Road, Sathuvachari, <br />
          Vellore-632009
        </p>
      </div>
      <div class='line'>
        <span
          ><p>bill no :</p>
          <p>1230</p></span
        >
        <span
          ><p>date :</p>
          <p>1/1/2000</p></span
        >
      </div>
      <div
        style='
          display: flex;
          flex-direction: row;
          justify-content: space-between;
          width: 88%;
          margin: auto;
        '
      >
        <span style='display: flex; flex-direction: row'
          ><p>student name :</p>
          <p>shans</p></span
        >
        <span style='display: flex; flex-direction: row'
          ><p>student id :</p>
          <p>12345</p></span
        >
        <span style='display: flex; flex-direction: row'
          ><p>course name :</p>
          <p>3d & vfx</p></span
        >
      </div>
      <table
        style='
          width: 90%;
          margin: auto;
          border: 1px solid black;
          border-collapse: collapse;
        '
      >
        <tr>
          <th style='border: 1px solid black; border-collapse: collapse'>
            Date
          </th>
          <th style='border: 1px solid black; border-collapse: collapse'>
            Description
          </th>
          <th style='border: 1px solid black; border-collapse: collapse'>
            Amount (Rs)
          </th>
          <th style='border: 1px solid black; border-collapse: collapse'>ps</th>
        </tr>
        <tr>
          <td
            style='
              text-align: center;
              width: 5%;
              border-left: 1px solid black;
              border-right: 1px solid black;
              border-collapse: collapse;
              padding: 0.5rem 1rem;
            '
          ></td>
          <td
            style='
              text-align: left;
              width: 40%;
              border-left: 1px solid black;
              border-right: 1px solid black;
              border-collapse: collapse;
              padding: 0.5rem 1rem;
            '
          >
            course fees
          </td>
          <td
            style='
              text-align: right;
              width: 40%;
              border-left: 1px solid black;
              border-right: 1px solid black;
              border-collapse: collapse;
              padding: 0.5rem 1rem;
            '
          >
            12,000
          </td>
          <td
            style='
              text-align: left;
              width: 5%;
              padding: 3px;
              border-left: 1px solid black;
              border-right: 1px solid black;
              border-collapse: collapse;
              padding: 0.5rem 1rem;
            '
          >
            .00
          </td>
        </tr>

        <tr>
          <td
            style='
              text-align: center;
              width: 5%;
              border-left: 1px solid black;
              border-right: 1px solid black;
              border-collapse: collapse;
              padding: 0.5rem 1rem;
            '
          >
            1/1/2000
          </td>
          <td
            style='
              text-align: left;
              width: 40%;
              border-left: 1px solid black;
              border-right: 1px solid black;
              border-collapse: collapse;
              padding: 0.5rem 1rem;
            '
          >
            first payment
          </td>
          <td
            style='
              text-align: right;
              width: 40%;
              border-left: 1px solid black;
              border-right: 1px solid black;
              border-collapse: collapse;
              padding: 0.5rem 1rem;
            '
          >
            5,000
          </td>
          <td
            style='
              text-align: left;
              width: 5%;
              padding: 3px;
              border-left: 1px solid black;
              border-right: 1px solid black;
              border-collapse: collapse;
              padding: 0.5rem 1rem;
            '
          >
            .00
          </td>
        </tr>
        <tr>
          <td
            style='
              text-align: center;
              width: 5%;
              border-left: 1px solid black;
              border-right: 1px solid black;
              border-collapse: collapse;
              padding: 0.5rem 1rem;
            '
          ></td>
          <td
            style='
              text-align: center;
              width: 5%;
              border-left: 1px solid black;
              border-right: 1px solid black;
              border-collapse: collapse;
              padding: 0.5rem 1rem;
            '
          ></td>
          <td
            style='
              text-align: center;
              width: 5%;
              border-left: 1px solid black;
              border-right: 1px solid black;
              border-collapse: collapse;
              padding: 0.5rem 1rem;
            '
          ></td>
        </tr>
        <tr>
          <td
            style='
              text-align: center;
              width: 5%;
              border-left: 1px solid black;
              border-right: 1px solid black;
              border-collapse: collapse;
              padding: 0.5rem 1rem;
            '
          ></td>
          <td
            style='
              text-align: center;
              width: 5%;
              border-left: 1px solid black;
              border-right: 1px solid black;
              border-collapse: collapse;
              padding: 0.5rem 1rem;
            '
          ></td>
          <td
            style='
              text-align: center;
              width: 5%;
              border-left: 1px solid black;
              border-right: 1px solid black;
              border-collapse: collapse;
              padding: 0.5rem 1rem;
            '
          ></td>
        </tr>
        <tr>
          <td
            style='
              text-align: center;

              border-left: 1px solid black;
              border-right: 1px solid black;
              border-collapse: collapse;
              padding: 0.5rem 1rem;
            '
          ></td>
          <td
            style='
              text-align: center;

              border-left: 1px solid black;
              border-right: 1px solid black;
              border-collapse: collapse;
              padding: 0.5rem 1rem;
            '
          ></td>
          <td
            style='
              text-align: center;

              border-left: 1px solid black;
              border-right: 1px solid black;
              border-collapse: collapse;
              padding: 0.5rem 1rem;
            '
          ></td>
        </tr>
        <tr>
          <td
            style='
              text-align: center;
              width: 5%;
              border-left: 1px solid black;
              border-right: 1px solid black;
            '
          ></td>
          <td
            style='
              text-align: left;
              width: 40%;
              border-right: 1px solid black;
              padding: 0.5rem 1rem;
            '
          >
            balance
          </td>
          <td
            style='
              text-align: right;
              width: 40%;
              border-collapse: collapse;
              border-right: 1px solid black;
              padding: 0.5rem 1rem;
            '
          >
            5,000
          </td>
          <td
            style='
              text-align: left;
              width: 5%;
              padding: 3px;
              padding: 0.5rem 1rem;
            '
          >
            .00
          </td>
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


