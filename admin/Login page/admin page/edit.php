<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>updating </title>
    <link rel="stylesheet" href="edit.css">
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



            $sql="SELECT* FROM student_details WHERE ID='{$_GET["id"]}'";
            $result=mysqli_query($con,$sql);
            $row=mysqli_fetch_array($result);
            echo'
            <div class="form">
                <form action="update.php" method = "POST">
                <div class="details">
                    <div class="name">
                        <h5>' . $row["C_NAME"] . '</h5>
                        <hr style="margin:0">
                    </div>
                    <div class="stu_id">
                        <label for="stu_id">Student ID:</label>
                        <P>' . $row["STUDENT_ID"] . '</p>
                    </div>    
                    <div class="stu_id">
                        <label for="stu_id">Course:</label>
                        <P>' . $row["COURSE"] . '</p>
                    </div> 
                    <div class="stu_id fees">
                        <label for="stu_id">Fees:</label>
                        <input type="text" id="tr" value="'.$row['FEES'].'" name= "fees">
                    </div> 
                    <div class="stu_id paid">
                        <label for="stu_id">Fees Paid:</label>
                        <input type="text" id = "y" value="'.$row['PAID_FEE'].'" name="paid">
                    </div> 
                    <div class="stu_id balance">
                        <label for="stu_id">Fees Balance:</label>
                        <P>' . $row["BALANCE_FEE"] . '</p>
                    </div> 
                    <div class="btndiv">
                        <input type="hidden" name="id" value="' . $row['ID'] . '">
                        <button type="submit" class="hrefs btn">Submit</button>
                    </div>

                </div>
                </form>
            </div>
        

            ';





        ?>

<script>
    console.log(document.getElementById('tr').value);
    console.log(document.getElementById('y').value);
</script>

</body>
</html>