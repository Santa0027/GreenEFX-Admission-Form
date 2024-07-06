<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>fees page</title>
    <link rel="stylesheet" href="fees.css">
    <link rel="stylesheet" href="edit.css">
</head>

<body>
    <div class="container">

        <div class="se">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="form">
                <!-- <label for="search" >Search:</label> -->
                <input type="text" id="search" name="search_term" placeholder="Search :">
                <button type="submit" id="search-form" class="button"><img class="search_button"
                        src="asset/observation.png" alt=""></button>
            </form>
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
        <div id="ta">
            <table id="s" class="hidden">
                <?php
                session_start();

                // Database connection details (replace with your actual credentials)
                $db_server = "localhost";
                $db_user = "root";
                $db_pass = "";
                $db_name = "greenefx_database";

                // $editfee = false;
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
                    echo '<tr class = "head_row">';
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
                        echo '<a name="btnview" class="hrefs" href="view.php?id=' . $row['ID'] . '&editfee=true" name = "editfee" class="btn btn-success">invoice</a>';
                        echo '<br>';
                        echo '<a id="editbtn" class="editbtn hrefs" href="edit.php?id=' . $row['ID'] . '">Edit</a>';
                        echo '</tr>';
                    }
                }

                echo '</table>';
                echo '</div>';
                echo '<div id="flotform"></div>';




                ?>
            </table>
        </div>




        <a href="#"><svg class="top-arrow" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 320 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                <path fill="#ffffff"
                    d="M318 177.5c3.8-8.8 2-19-4.6-26l-136-144C172.9 2.7 166.6 0 160 0s-12.9 2.7-17.4 7.5l-136 144c-6.6 7-8.4 17.2-4.6 26S14.4 192 24 192H96l0 288c0 17.7 14.3 32 32 32h64c17.7 0 32-14.3 32-32l0-288h72c9.6 0 18.2-5.7 22-14.5z" />
            </svg></a>










        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const floatForm = document.getElementById("flotform");
                const editbtns = document.querySelectorAll(".editbtn");

                editbtns.forEach(editbtn => {
                    editbtn.addEventListener('click', function (e) {
                        e.preventDefault();

                        const url = this.href; // Get the href of the clicked link

                        var xhr = new XMLHttpRequest();
                        xhr.open('GET', url, true);
                        xhr.onload = function () {
                            if (xhr.status === 200) {
                                // Inject the returned HTML into the floatForm container
                                floatForm.innerHTML = xhr.responseText;
                                floatForm.style.display = "block";

                                // Add event listener to the cancel icon
                                const cancel = document.getElementById('cancelicon');

                                cancel.addEventListener('click', function () {
                                    floatForm.style.display = 'none';
                                });

                            } else {
                                console.error("Failed to load form.");
                            }
                        };
                        xhr.send();
                    });
                });
            });
        </script>
</body>


</html>