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
        echo "Welcome, " . $_SESSION["username"];
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
                        <img class="search_button" src="./asset/magnifier.png" alt="Search">
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
                        echo '<div class="head" style="display:flex; flex-direction:row; justify-content:space-evenly; align-items:center; padding-bottom:1rem">';
                        echo "<h1>Student Details</h1>";
                        echo '<img src="data:image;base64,' . $row['PHOTO'] . '" alt="Image Not Available" style="height:200px; width:150px">';
                        echo '</div>';
                        echo "<div>";
                        echo '<span><p class="label">1) Student ID </p> <p class="values">: ' . $row["STUDENT_ID"] . '</p></span>';
                        echo '<span><p class="label">2) Student Name </p> <p class="values">: ' . $row["C_NAME"] . '</p></span>';
                        echo '<span><p class="label">3) Father Name </p> <p class="values">: ' . $row["F_NAME"] . '</p></span>';
                        // echo '<span><p class="label">4) Mother Name </p> <p class="values">: ' . $row["M_NAME"] . '</p></span>';
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

                        echo "</div>";
                    echo '<button class="download-button" onclick="downloadReport(\'reportItem_' . $row['STUDENT_ID'] . '\')">Download Report</button>';

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
    // Get the entire content of the specific report
    const reportContent = document.getElementById(reportId).innerHTML;
    
    // Open a new window for printing
    const reportWindow = window.open('', 'PRINT', 'height=650,width=800');

    reportWindow.document.write(`
        <html>
        <head>
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
            <style>
                body { font-family: 'Poppins', sans-serif; background-color: #fff; margin: 0; padding: 10px; }
                .report-container { width: 90%; margin: auto; padding: 2rem; background-color: #fff; border-radius: 8px; 
                                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); }
                h1 { text-align: center; color: #333; margin-bottom: 20px; }
                img { display: block; margin: 0 auto 20px; padding: 0.7rem; border: 1px solid black; border-radius: 8px; 
                      height: 100px; width: 100px; }
                .detail-row { margin-bottom: 5px; width: 90%; margin: auto; }
                .label { font-weight: bold; color: #555; }
            
                span{     display: flex;
    flex-direction: row;
    justify-content: space-between;
    width: 80%;
    margin: auto;
    padding:0%;
    height:50;}
                .values {  width: 50%; padding-left:10px; color: rgb(3, 74, 51); text-transform: capitalize; }
            </style>
        </head>
        <body>
            <div class="report-container">
                
                ${reportContent} <!-- Inject the actual report HTML content here -->
            </div>
        </body>
        </html>
    `);

    reportWindow.document.close(); // Close the document for writing
    reportWindow.focus();          // Bring the print window to focus
    reportWindow.print();          // Trigger the print dialog
}


    </script>
</body>

</html>
