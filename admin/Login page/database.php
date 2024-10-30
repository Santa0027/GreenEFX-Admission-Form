<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>database</title>
    <link rel="stylesheet" href="database.css">
</head>
<body>
<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../index.html");// Redirect to login page if not logged in
    exit();
}

// Your protected content here
echo "Welcome, " . $_SESSION['username'];
?>


         <div class="container">
            
            <div class="se">
                 <form method="POST"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="form">
                <!-- <label for="search" >Search:</label> -->
                <input type="text" id="search" name="search_term" placeholder="Search :">
                <button type="submit" id="search-form" class="button"><img class="search_button"
                        src="asset/observation.png" alt=""></button>
            </form>
        </div>
         <div class="navbar">
                        <ul class="list">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="fee.php">Payments</a></li>
                            <li><a href="database.php">Total Details</a></li>
                            <!-- <li><a href="excelsheet.php" name="download_excel">download</a></li> -->
                        </ul>
                    </div>
                </nav>
        <div id="ta">
            <table id="s" class="hidden">
                <?php
              
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
                $sql = "SELECT * FROM student_details";
                $result = mysqli_query($con, $sql);
                if (!$result) {
                    die("error" . mysqli_error($con));
                }
                if (mysqli_num_rows($result) > 0) {
                    echo '<div style=" border-radius: 10px;">';
                    echo '<table class="table">';
                    echo '<tr class = "head_row">';
                    echo '<th>ID</th>';
                    echo '<th>STUDENT_ID</th>';
                    echo '<th>NAME</th>';
                    echo '<th>PHOTO';
                    echo '<th>DATE</th>';
                    echo '<th>EMAIL</th>';
                    echo '<th>DOB</th>';
                    echo '<th>PHONE-NO</th>';
                    echo '<th>ADDITIONAL NUMBER</th>';
                    echo '<th>ADDERSS</th>';
                    echo '<th>FATHER NAME</th>';
                    echo '<th>MOTHER NAME</th>';
                    echo '<th>GENDER</th>';
                    echo '<th>QUALIFICATION</th>';
                    echo '<th>FEILD OF WORK</th>';
                    echo '<th>COURSE</th>';
                    echo '<th>FEES</th>';
                    echo '<th>FEES PAID</th>';
                    echo '<th>BALANCE FEES</th>';
                    
                    echo '</tr>';
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        foreach ($row as $key => $value) {
                            if ($key === 'PHOTO') {
                                echo "<td><img src='data:image;base64,{$value}' alt='Not available' height='100px' width='100px'></td>";
                            } else {
                                echo "<td>" . htmlspecialchars($value) . "</td>";
                            }
                        }
                        echo '</tr>';
                    }

                    echo '</table>';
                    echo '</div>';

                }





                ?>
            </table>
            
        </div>
<a href="#"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#ffffff" d="M318 177.5c3.8-8.8 2-19-4.6-26l-136-144C172.9 2.7 166.6 0 160 0s-12.9 2.7-17.4 7.5l-136 144c-6.6 7-8.4 17.2-4.6 26S14.4 192 24 192H96l0 288c0 17.7 14.3 32 32 32h64c17.7 0 32-14.3 32-32l0-288h72c9.6 0 18.2-5.7 22-14.5z"/></svg></a>

<form method="post" action="excelsheet.php">
    <button type="submit" name="download_excel" id ="downloadLink">Download Excel</button>
</form>

<a href="logout.php">Logout</a>



<!-- CSS for Styling -->
<style>
    #downloadLink {
        margin-top:2rem;
        display: inline-block;
        padding: 10px 20px;
        background-color: #4CAF50; /* Green color */
        color: white;
        text-decoration: none;
        font-size: 16px;
        font-weight: bold;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    #downloadLink:hover {
        background-color: #45a049; /* Darker green on hover */
    }

    #downloadLink:active {
        background-color: #3e8e41; /* Even darker green when clicked */
    }
</style>




</body>
</html>