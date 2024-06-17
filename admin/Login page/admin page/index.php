<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view database</title>
    <link rel="stylesheet" href="home.css">
<script defer src="index.js"></script>
<link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
 

</head>
<body>
  
         <div class="container">
            
            
            <div class="context  my-style">
                <div class="logo">
                    <img src="asset/green_logo.png" class="img" alt="">
                </div>
                <nav>
                    <div class="navbar">
                        <ul class="list">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="fees.php">Payments</a></li>
                            <li><a href="database.php">Total Details</a></li>
                        </ul>
                    </div>
                </nav>
                <div class="se">
                    <form method="POST"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="form">
                            <!-- <label for="search" >Search:</label> -->
                            <input type="text" id="search" name="search_term" placeholder="Search :">
                            <button type="submit" id="search-form" class="button"><img class="search_button" src="./asset/observation.png"
                                    alt=""></button>
                        </form>
                </div>
                     <hr>  
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
                            
                            echo '<div id = "successMessage" style= "
                            position: relative;
                            padding-top:10rem;
                            left:42.5%;
                            font-size: 2rem;
                            color: white;
                            "> Data Not Found
                            </div>';
                        }
                    }
                            // Close connection (optional, PHP automatically closes on script termination)
                            mysqli_close($con);






                        ?>
             </table>
             </div>
      



<!-- <script type="text/javascript">
        $(function() {
            function runEffect() {

                var selectedEffect = 'blind';

                var options = {};

                $("#successMessage").hide(selectedEffect, options, 5s);
            };

            $("#successMessageBtn").click(function() {
                runEffect();
                return false;
            });
        });
    </script> -->
<a href="#"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#ffffff" d="M318 177.5c3.8-8.8 2-19-4.6-26l-136-144C172.9 2.7 166.6 0 160 0s-12.9 2.7-17.4 7.5l-136 144c-6.6 7-8.4 17.2-4.6 26S14.4 192 24 192H96l0 288c0 17.7 14.3 32 32 32h64c17.7 0 32-14.3 32-32l0-288h72c9.6 0 18.2-5.7 22-14.5z"/></svg></a>
</body>
   
</html>