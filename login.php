<?php
// Database connection details (replace with your actual credentials)
include 'config.php';
header('Content-Type: application/json; charset=utf-8');
session_start();  
$row='';
// Establish connection
$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
if ($con === false) {
    die("invalid error:". mysqli_connect_error());
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($con, $_POST["username"]);
    $password = mysqli_real_escape_string($con, $_POST["password"]);

    $sql = "SELECT * FROM admin WHERE USERNAME = '$username'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if ($row["PASSWORD"] === $password) { // Use lowercase for case-insensitive comparison
           
            $_SESSION['username'] = $username;
            $_SESSION['logged_in'] = true;
            
            $response = "OK";

        } else {
            $response ="Invalid username or password";
        }
    }else{
        $response = "Invalid username or password";
    }
    echo json_encode($response);
    $con->close(); 
}
?>