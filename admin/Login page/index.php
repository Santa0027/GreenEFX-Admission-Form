<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Database</title>
    <link rel="stylesheet" href="home.css">
    <script defer src="index.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
</head>
<body>
    <?php
    session_start();

    // Redirect to login page if not logged in
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header("Location: ../../index.html");
        exit();
    }

    // Database connection details
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "greenefx_database";

    // Establish connection
    $con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare SQL query
    $sql = "SELECT * FROM student_details";
    $result = null;

    // Handle search functionality
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["search_term"])) {
        $search = strtolower(trim($_POST["search_term"]));
        $search_term = mysqli_real_escape_string($con, $search);
        
        $stmt = mysqli_prepare($con, "SELECT * FROM student_details WHERE C_NAME LIKE ? OR STUDENT_ID LIKE ?");
        mysqli_stmt_bind_param($stmt, "ss", $search_term, $search_term);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }
    ?>

    <div class="container">
        <div class="context my-style">
            <div class="logo">
                <img src="asset/green_logo.png" class="img" alt="Logo">
            </div>
            <nav>
                <div class="navbar">
                    <ul class="list">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="fee.php">Payments</a></li>
                        <li><a href="database.php">Total Details</a></li>
                    </ul>
                </div>
            </nav>
            <div class="se">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="form">
                    <input type="text" id="search" name="search_term" placeholder="Search :">
                    <button type="submit" id="search-form" class="button">
                        <img class="search_button" src="./asset/observation.png" alt="Search">
                    </button>
                </form>
            </div>
            <hr>
        </div>

        <div id="ta">
            <div id="s">
                <?php
                // Only display results if search was performed
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='report' id='reportItem_" . $row['STUDENT_ID'] . "'>";
                        echo '<div class="" style="display:flex; flex-direction:row; justify-content:space-evenly; align-items:center; padding-bottom:1rem">';
                        echo "<h1>Student Details</h1>";
                        echo '<img src="data:image;base64,' . $row['PHOTO'] . '" alt="Image Not Available" style="height:200px; width:150px">';
                        echo '</div>';
                        echo "<div>";
                        echo '<span><p class="label">1) Student ID </p> <p class="values">: ' . $row["STUDENT_ID"] . '</p></span>';
                        echo '<span><p class="label">2) Student Name </p> <p class="values">: ' . $row["C_NAME"] . '</p></span>';
                        echo '<span><p class="label">3) Father Name </p> <p class="values">: ' . $row["F_NAME"] . '</p></span>';
                        echo '<span><p class="label">4) Mother Name </p> <p class="values">: ' . $row["M_NAME"] . '</p></span>';
                        echo '<span><p class="label">5) Email </p> <p class="values" style="text-transform:lowercase">: ' . $row["EMAIL"] . '</p></span>';
                        echo '<span><p class="label">6) Phone Number </p> <p class="values">: ' . $row["PHONE_NO"] . '</p></span>';
                        echo '<span><p class="label">7) Additional Phone Number </p> <p class="values">: ' . $row["PHONE_2"] . '</p></span>';
                        echo '<span><p class="label">8) Address </p> <p class="values">: ' . $row["C_ADDRESS"] . '</p></span>';
                        echo '<span><p class="label">9) Gender </p> <p class="values">: ' . $row["GENDER"] . '</p></span>';
                        echo '<span><p class="label">10) Qualification </p> <p class="values">: ' . $row["QUALIFICATION"] . '</p></span>';
                        echo '<span><p class="label">11) Field of Work / Study </p> <p class="values">: ' . $row["FEILD_OF_WORK"] . '</p></span>';
                        echo '<span><p class="label">12) Course </p> <p class="values">: ' . $row["COURSE"] . '</p></span>';
                        echo "</div>";
                        // Add a download button for each student
                        echo '<button class="download-button" onclick="downloadReport(\'reportItem_' . $row['STUDENT_ID'] . '\')">Download Report</button>';
                        echo "</div>";
                    }
                } else {
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        echo '<div class="report">Data Not Found</div>';
                    }
                }

                // Close connection
                mysqli_close($con);
                ?>
            </div>
        </div>
    </div>

    <script>
        function downloadReport(reportId) {
            const reportContent = document.getElementById(reportId).innerHTML;
            const reportWindow = window.open('', 'PRINT', 'height=600,width=800');
            reportWindow.document.write('<html><head><title>Student Report</title>');
            reportWindow.document.write('<link rel="stylesheet" href="report.css">'); // Include CSS for styling
            reportWindow.document.write('</head><body>');
            reportWindow.document.write(reportContent);
            reportWindow.document.write('</body></html>');
            reportWindow.document.close();
            reportWindow.print();
        }
    </script>
</body>

</html>
