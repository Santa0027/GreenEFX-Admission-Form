<?php
// Database connection details (replace with your actual credentials)
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "greenefx_database";

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

    $sql = "SELECT * FROM admin WHERE USERNAME = ? AND PASSWORD = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
    if ($row) {

        if ($row["USERTYPE"] === "admin") {
            header("location:db_index.php");
        }
    } else {
        echo"invalid username or password";
    }
    mysqli_stmt_close($stmt);

}
?>