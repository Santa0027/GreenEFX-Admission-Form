<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view database</title>
    <link rel="stylesheet" href="style.css">
<script defer src="script.js"></script>
<link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
 

</head>
<body>
         <div class="container">
            
            <div class="logo">
                <img src="green_logo.png" class="img" alt="">
            </div>
            <div class="se">
                 <form method="POST"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="form">
                    <!-- <label for="search" >Search:</label> -->
                    <input type="text" id="search" name="search_term" placeholder="Search :">
                    <button type="submit" id="search-form" class="button"><img class="search_button" src="observation.png" alt=""></button>
                </form>
            </div>
            <div id="ta" >
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

                            // Define initial query (assuming you want all data initially)
                            $sql = "SELECT * FROM student_details";
                            
                            // Process search if submitted (use prepared statements for better security)
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    
                                        $search_term = mysqli_real_escape_string($con, $_POST["search_term"]);

                                        $stmt = mysqli_prepare($con, "SELECT * FROM student_details WHERE C_NAME LIKE ?");
                                        mysqli_stmt_bind_param($stmt, "s", $search_term);
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);
                                    
                            } else {
                                // No search submitted, execute initial query
                                $result = mysqli_query($con, $sql);
                            }

                            // Check if any results found
                    if (!empty($_POST["search_term"])) {
                        if ($result && mysqli_num_rows($result) > 0) {
                            echo '<div style=" border-radius: 10px;">';
                            echo '<table class="table">';
                            echo '<tr>';
                            echo '<th>ID</th>';
                            echo '<th>NAME</th>';
                            echo '<th>PHOTO';
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

                        } else {
                            echo "<tr><td colspan='2'>No records found</td></tr>";
                        }
                    }
                            // Close connection (optional, PHP automatically closes on script termination)
                            mysqli_close($con);






                        ?>
             </table>
             </div>
      





</body>
   
</html>