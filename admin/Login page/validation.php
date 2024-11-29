<?php
header('Content-Type: application/json');

// Database connection details
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "greenefx_database";

// Establish connection
$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
if (!$con) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paid = $_POST['paid'];
    $id = $_POST["id"];
    $payment_mode = $_POST["paymentMode"];
    $payment_date = $_POST["paymentdate"];
    $today = date('Y-m-d');
    $thirty_days_ago = date('Y-m-d', strtotime('-30 days'));

    // Validate the payment date
    if ($payment_date > $today) {
        echo json_encode(['status' => 'error', 'message' => 'Future dates are not allowed.']);
        exit();
    }

    if ($payment_date < $thirty_days_ago) {
        echo json_encode(['status' => 'error', 'message' => 'Dates older than 30 days are not allowed.']);
        exit();
    }

    // Process form data (e.g., log to database, update records)
    // For this example, return a success message
    echo json_encode(['status' => 'success', 'message' => 'Payment details have been successfully submitted!']);
    exit();
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
?>
