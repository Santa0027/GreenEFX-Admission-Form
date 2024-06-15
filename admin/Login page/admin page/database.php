<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>database</title>
    <link rel="stylesheet" href="database.css">
</head>
<body>
         <div class="container">
            
            <div class="se">
                 <form method="POST"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="form">
                <!-- <label for="search" >Search:</label> -->
                <input type="text" id="search" name="search_term" placeholder="Search :">
                <button type="submit" id="search-form" class="button"><img class="search_button"
                        src="asset/observation.png" alt=""></button>
            </form>
        </div>
        <div id="ta">
            <table id="s" class="hidden">
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
                $sql = "SELECT * FROM student_details";
                $result = mysqli_query($con, $sql);
                if (!$result) {
                    die("error" . mysqli_error($con));
                }
                if (mysqli_num_rows($result) > 0) {
                    echo '<div style=" border-radius: 10px;">';
                    echo '<table class="table">';
                    echo '<tr>';
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
                                echo "<td><img src='data:image;base64,{$value}' alt='Photo' height='100px' width='100px'></td>";
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






</body>
</html>