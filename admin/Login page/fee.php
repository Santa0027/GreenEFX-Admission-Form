<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>fees page</title>
    <link rel="stylesheet" href="fees.css">
    <link rel="stylesheet" href="edit.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="container" id="container">
        <div id="main">

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
                        <li><a href="fee.php">Payments</a></li>
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
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {

                        $search_term = mysqli_real_escape_string($con, $_POST["search_term"]);

                        $stmt = mysqli_prepare($con, "SELECT * FROM student_details WHERE C_NAME LIKE ? OR STUDENT_ID LIKE ?");
                        mysqli_stmt_bind_param($stmt, "ss", $search_term, $search_term);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                    }
                    if (!empty($_POST["search_term"])) {
                        if ($result && mysqli_num_rows($result) > 0) {

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
                                    echo '<td>' . $row['ID'] . '</td>';
                                    echo '<td>' . $row['STUDENT_ID'] . '</td>';
                                    echo '<td>' . $row['C_NAME'] . '</td>';
                                    echo '<td>' . $row['COURSE'] . '</td>';
                                    echo '<td id="fees-' . $row['ID'] . '">' .$row['FEES'] . '</td>'; // Target for editing fees
                                    echo '<td id="paid-fees-' . $row['ID'] . '">' . $row['PAID_FEE'] . '</td>'; // Target for editing paid fees
                                    echo '<td>' . $row['BALANCE_FEE'] . '</td>';
                                    // Edit and View links can be combined if desired
                                    echo '<td>';
                                    echo '<a name="btnview" class="hrefs" href="invoice.php?id=' . $row['ID'] . '" name = "editfee" class="btn btn-success">invoice</a>';
                                    echo '<br>';
                                    echo '<a id="myLink" class="editbtn hrefs" data-id = "' . $row['ID'] . '" href="edit.php?id=' . $row['ID'] . '">Edit</a>';
                                    echo '</tr>';
                                }
                            }

                            echo '</table>';

                            echo '<div id="flotform"></div>';





                        }
                        else{

                        $sql_all = "SELECT ID,STUDENT_ID,C_NAME,COURSE,FEES,PAID_FEE,BALANCE_FEE FROM student_details"; 
                        $result_all = mysqli_query($con, $sql_all);
                        if (!$result_all) {
                            die("error" . mysqli_error($con));
                        }
                        if (mysqli_num_rows($result_all) > 0) {
                    
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
                            while ($row = mysqli_fetch_assoc($result_all)) {
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
                                echo '<a name="btnview" class="hrefs" href="invoice.php?id=' . $row['ID'] . '" name = "editfee" class="btn btn-success">invoice</a>';
                                echo '<br>';
                                echo '<a id="myLink" class="editbtn hrefs" data-id = "' . $row['ID'] . '" href="edit.php?id=' . $row['ID'] . '">Edit</a>';
                                echo '</tr>';
                            }
                        }
                    
                        echo '</table>';
                    
                        echo '<div id="flotform"></div>';

                        }
                    
                    // $sql = "SELECT ID,STUDENT_ID,C_NAME,COURSE,FEES,PAID_FEE,BALANCE_FEE FROM student_details";
                    // $result = mysqli_query($con, $sql);
                    // if (!$result) {
                    //     die("error" . mysqli_error($con));
                    // }
                    // if (mysqli_num_rows($result) > 0) {

                    //     echo '<table class="table">';
                    //     echo '<tr class = "head_row">';
                    //     echo '<th>ID</th>';
                    //     echo '<th>STUDENT_ID</th>';
                    //     echo '<th>NAME</th>';
                    //     echo '<th>COURSE</th>';
                    //     echo '<th>FEES</th>';
                    //     echo '<th>PAID FEES</th>';
                    //     echo '<th>BALANCE FEES</th>';
                    //     echo '<th>OPERATION</th>';
                    //     echo '</tr>';
                    //     while ($row = mysqli_fetch_assoc($result)) {
                    //         echo '<tr>';
                    //         echo '<td>' . htmlspecialchars($row['ID']) . '</td>';
                    //         echo '<td>' . htmlspecialchars($row['STUDENT_ID']) . '</td>';
                    //         echo '<td>' . htmlspecialchars($row['C_NAME']) . '</td>';
                    //         echo '<td>' . htmlspecialchars($row['COURSE']) . '</td>';
                    //         echo '<td id="fees-' . $row['ID'] . '">' . htmlspecialchars($row['FEES']) . '</td>'; // Target for editing fees
                    //         echo '<td id="paid-fees-' . $row['ID'] . '">' . htmlspecialchars($row['PAID_FEE']) . '</td>'; // Target for editing paid fees
                    //         echo '<td>' . htmlspecialchars($row['BALANCE_FEE']) . '</td>';
                    //         // Edit and View links can be combined if desired
                    //         echo '<td>';
                    //         echo '<a name="btnview" class="hrefs" href="invoice.php?id=' . $row['ID'] . '" name = "editfee" class="btn btn-success">invoice</a>';
                    //         echo '<br>';
                    //         echo '<a id="myLink" class="editbtn hrefs" data-id = "' . $row['ID'] . '" href="edit.php?id=' . $row['ID'] . '">Edit</a>';
                    //         echo '</tr>';
                    //     }
                    // }

                    // echo '</table>';

                    // echo '<div id="flotform"></div>';


                    ?>
                </table>
            </div>
        </div>
    </div>





    <a href="#"><svg class="top-arrow" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 320 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
            <path fill="#ffffff"
                d="M318 177.5c3.8-8.8 2-19-4.6-26l-136-144C172.9 2.7 166.6 0 160 0s-12.9 2.7-17.4 7.5l-136 144c-6.6 7-8.4 17.2-4.6 26S14.4 192 24 192H96l0 288c0 17.7 14.3 32 32 32h64c17.7 0 32-14.3 32-32l0-288h72c9.6 0 18.2-5.7 22-14.5z" />
        </svg></a>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const floatForm = document.getElementById("flotform");
            const container = document.getElementById("form");
            const editBtns = document.querySelectorAll(".editbtn");


            editBtns.forEach(editBtn => {
                editBtn.addEventListener('click', function (e) {
                    e.preventDefault();

                    // container.style.display = "none";
                    const id = this.getAttribute("data-id");
                    fetch('edit.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ href: id })
                    })
                        .then(response => response.text())
                        .then(data => {

                            console.log(data);
                            floatForm.innerHTML = data;
                            floatForm.style.display = 'block';

                            addFormEventListeners();

                        })

                    // .catch(error => console.error('Error:', error));
                });
            });
            // document.addEventListener('click', function(event) {
            // const floatForm = document.getElementById("flotform");
            // if (event.target !== floatForm && !floatForm.contains(event.target)) {
            //     // Clicked outside the form, close it
            //     floatForm.style.display = 'none';
            // }
            // // ... your existing code here
            // });
            function addFormEventListeners() {

                const feesubmit = document.getElementById("feesubmit");
                const avoidid = document.getElementById("avoid");
                const paidfee = document.getElementById("paidfee");
                const editfee = document.getElementById("editfee");
                const feeinput = document.getElementById("feeinput");
                editfee.addEventListener('click', function () {
                    feeinput.style.display = "block";
                    avoidid.style.display = "none";
                    feesubmit.style.display = "block";
                    editfee.style.display = "none";
                    paidfee.style.display = "none";
                })
                avoidid.style.display = "block";
                $(document).ready(function () {
                    $("#feesubmit").click(function (event) {
                        event.preventDefault(); // Prevent default form submission

                        // Get form data
                        var fee_id = $("#feeid").val();
                        var new_fee = $("#feeinput").val();

                        // Send AJAX request
                        $.ajax({
                            type: "POST",
                            url: "ff.php",  // Replace with your PHP file name
                            data: {
                                fee_id: fee_id,
                                new_fee: new_fee
                            },
                            success: function (response) {
                                $("#result").html(response);
                                feeinput.style.display = "none";
                                avoidid.style.display = "none";
                                feesubmit.style.display = "none";
                                editfee.style.display = "block";
                                paidfee.style.display = "none";

                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                console.error("AJAX Error:", textStatus, errorThrown);
                                $("#result").html("Error updating fee!");
                            }
                        });
                    });
                });

                const cancelIcon = document.getElementById('cancel-icon');
                if (cancelIcon) {
                    cancelIcon.addEventListener('click', function () {
                        container.style.display = "block";
                        floatForm.style.display = 'none';
                    });
                } else {
                    console.error("Cancel icon element not found.");
                }

                const mySubmit = document.getElementById('MYsubmit');
                if (mySubmit) {
                    mySubmit.addEventListener('click', function (e) {
                        const paidInput = document.getElementById('paidInput');
                        const paidfee = document.getElementById('paidfee').innerText;
                        const fee = document.getElementById('avoid').innerText;
                        const paying = parseFloat(paidInput.value);
                        const feeamount = parseFloat(fee);
                        const paidAmount = parseFloat(paidfee);
                        const total = paying + paidAmount;

                        console.log(paidAmount);
                        if (feeamount >= total) {
                            document.getElementById('feeWarning').style.display = 'none';
                        }    
                        else {
                            e.preventDefault();
                            document.getElementById('feeWarning').style.display = 'block';
                        }
                    

                    });
                
                }
            }
        });
        
    </script>

</body>


</html>