<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
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
    $sql = "SELECT ID,STUDENT_ID,C_NAME,COURSE,FEES,PAID_FEE,BALANCE_FEE FROM student_details";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        die("error" . mysqli_error($con));
    }
    $row = mysqli_fetch_array($result);

    if (isset($_["ID"])) {
        echo "the student id:" . $row["STUDENT_ID"] . "and name" . $row["C_NAME"];
    }



    ?>
</body>
</html>