<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>fees page</title>
    <link rel="stylesheet" href="fees.css">
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
                $sql = "SELECT ID,STUDENT_ID,C_NAME,COURSE,FEES,PAID_FEE,BALANCE_FEE FROM student_details";
                $result = mysqli_query($con, $sql);
                if (!$result) {
                    die("error" . mysqli_error($con));
                }
                if (mysqli_num_rows($result) > 0) {
                    echo '<div >';
                    echo '<table class="table">';
                    echo '<tr>';
                    echo '<th>ID</th>';
                    echo '<th>STUDENT_ID</th>';
                    echo '<th>NAME</th>';
                    echo '<th>COURSE</th>';
                    echo '<th>FEES</th>';
                    echo '<th>PAID FEES</th>';
                    echo '<th>BALANCE FEES</th>';
                    echo '<th>OPERATION</th>';
                    echo '</tr>';
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['ID']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['STUDENT_ID']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['C_NAME']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['COURSE']) . '</td>';
                        echo '<td id="fees-' . $row['ID'] . '">' . htmlspecialchars($row['FEES']) . '</td>'; // Target for editing fees
                        echo '<td id="paid-fees-' . $row['ID'] . '">' . htmlspecialchars($row['PAID_FEE']) . '</td>'; // Target for editing paid fees
                        echo '<td>' . htmlspecialchars($row['BALANCE_FEE']) . '</td>';
                        // Edit and View links can be combined if desired
                        echo '<td>';
                        echo '<a name="btnview" class="hrefs" href="view.php?id=' . $row['ID'] . '" class="btn btn-success">View</a>';
                        echo '<br>';
                        echo '<a name="btnedit" class="hrefs" href="edit.php?id=' . $row['ID'] . '">Edit</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                }

                    echo '</table>';
                    echo '</div>';

                    


                ?>
            </table>
        </div>






</body>
</html>