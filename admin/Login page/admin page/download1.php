<?php
require ("fpdf/fpdf.php");

// Database credentials
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "greenefx_database";
$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

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

    while ($row = mysqli_fetch_assoc($result)) {
        $date = date("Y-m-d"); // Assuming the current date for the invoice

        //customer and invoice details
        $info = [
            "customer" => $row['C_NAME'],
            "address" => $row['C_ADDRESS'],
            "invoice_no" => $row['IID'],
            "invoice_date" => $date,
            "balance"=>$row['BALANCE_FEE']
            

        ];


        //invoice Products
        $products_info = [
            [
                "course fees"=>"course fee",
                "course fee"=> $row['FEES'],
            ],
         
        ];

        class PDF extends FPDF
        {
            function Header()
            {

                //Display Company Info
                $this->SetFont('Arial', 'B', 14);
                $this->Cell(50, 10, "ABC COMPUTERS", 0, 1);
                $this->SetFont('Arial', '', 14);
                $this->Cell(50, 7, "West Street,", 0, 1);
                $this->Cell(50, 7, "Salem 636002.", 0, 1);
                $this->Cell(50, 7, "PH : 8778731770", 0, 1);

                //Display INVOICE text
                $this->SetY(15);
                $this->SetX(-40);
                $this->SetFont('Arial', 'B', 18);
                $this->Cell(50, 10, "INVOICE", 0, 1);

                //Display Horizontal line
                $this->Line(0, 48, 210, 48);
            }

            function body($info, $products_info)
            {

                //Billing Details
                $this->SetY(55);
                $this->SetX(10);
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(50, 10, "Bill To: ", 0, 1);
                $this->SetFont('Arial', '', 12);
                $this->Cell(50, 7, $info["customer"], 0, 1);
                $this->Cell(50, 7, $info["address"], 0, 1);

                //Display Invoice no
                $this->SetY(55);
                $this->SetX(-60);
                $this->Cell(50, 7, "Invoice No : " . $info["invoice_no"]);

                //Display Invoice date
                $this->SetY(63);
                $this->SetX(-60);
                $this->Cell(50, 7, "Invoice Date : " . $info["invoice_date"]);

                //Display Table headings
                $this->SetY(95);
                $this->SetX(10);
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(80, 9, "DESCRIPTION", 1, 0);
                $this->Cell(40, 9, "PRICE", 1, 0, "C");

                $this->Cell(40, 9, "TOTAL", 1, 1, "C");
                $this->SetFont('Arial', '', 12);

                //Display table product rows
                foreach ($products_info as $row) {
                    $this->Cell(80, 9, $row["course fees"], "LR", 0);
                    $this->Cell(40, 9, $row["course fee"], "R", 0, "R");
                    // $this->Cell(40, 9, $row["total"], "R", 1, "R");
                }
                //Display table empty rows
                for ($i = 0; $i < 12 - count($products_info); $i++) {
                    $this->Cell(80, 9, "", "LR", 0);
                    $this->Cell(40, 9, "", "R", 0, "R");
                    $this->Cell(30, 9, "", "R", 0, "C");
                    $this->Cell(40, 9, "", "R", 1, "R");
                }
                //Display table total row
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(150, 9, "BALANCE", 1, 0, "R");
                $this->Cell(40, 9, $info["balance"], 1, 1, "R");

            }
            function Footer()
            {

                //set footer position
                $this->SetY(-50);
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(0, 10, "for ABC COMPUTERS", 0, 1, "R");
                $this->Ln(15);
                $this->SetFont('Arial', '', 12);
                $this->Cell(0, 10, "Authorized Signature", 0, 1, "R");
                $this->SetFont('Arial', '', 10);

                //Display Footer Text
                $this->Cell(0, 10, "This is a computer generated invoice", 0, 1, "C");

            }

        }

    }
}

//Create A4 Page with Portrait 
$pdf = new PDF("P", "mm", "A4");
$pdf->AddPage();
$pdf->body($info, $products_info);
$pdf->Output();
?>