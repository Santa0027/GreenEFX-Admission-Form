<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="fees.css">
    <link rel="stylesheet" href="edit.css">
</head>

<body>
    <?php

    // Database connection details (replace with your actual credentials)
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "greenefx_database";




    // Establish connection
    $con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

    $id = $_GET['id']; 
    $sql = "SELECT* FROM student_details WHERE ID='$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    echo '
            <div class="form" id= "flotform" style = " z-index:0;">
                <form id=Myform action="update.php" method = "POST">
                <div class="details">
                    <div class="name">
                        <h5>' . $row["C_NAME"] . '</h5>
        
    <a id="cancel-icon" class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
        <path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg></a>

                    </div>
                    <div class="stu_id">
                        <label for="stu_id">Student ID:</label>
                        <P>' . $row["STUDENT_ID"] . '</p>
                    </div>    
                    <div class="stu_id">
                        <label for="stu_id">Course:</label>
                        <P>' . $row["COURSE"] . '</p>
                    </div> 
                    <div class="fees">
                        <label for="">Fees:</label>
                       <div class=" fee">
                       <p>' . $row['FEES'] . '</p>
                         <a id="editbtn" href="fixedfee.php?id=' . $_GET['id'] . '&edit=true">
                        <svg
                        style="height:1rem;width:1rem;margin:0%;padding:0%;"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V299.6l-94.7 94.7c-8.2 8.2-14 18.5-16.8 29.7l-15 60.1c-2.3 9.4-1.8 19 1.4 27.8H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM549.8 235.7l14.4 14.4c15.6 15.6 15.6 40.9 0 56.6l-29.4 29.4-71-71 29.4-29.4c15.6-15.6 40.9-15.6 56.6 0zM311.9 417L441.1 287.8l71 71L382.9 487.9c-4.1 4.1-9.2 7-14.9 8.4l-60.1 15c-5.5 1.4-11.2-.2-15.2-4.2s-5.6-9.7-4.2-15.2l15-60.1c1.4-5.6 4.3-10.8 8.4-14.9z"/></svg></a> 
                       </div>
                    </div> 
                    <div class="stu_id paid">
                        <label for="stu_id">Fees Paid:</label>
                        <input type="text" id = "paidInput" value="" placeholder="0" name="paid">
                    </div> 
                    <div class="stu_id balance">
                        <label for="stu_id">Fees Balance:</label>
                        <P>' . $row["BALANCE_FEE"] . '</p>
                    </div> 
                    <div class="warning" id="feeWarning" style="color: red; display: none;">
                        Paid fees cannot exceed the balance.
                    </div>
                    <div class="btndiv">
                        <input type="hidden" name="id" value="' . $row['ID'] . '">
                         <button type="submit" name="submit" class="hrefs btn" id="MYsubmit">Submit</button>
                    </div>

                </div>
                </form>
            </div>
        <div id = "response"></div>

            

';
    ?>





   
    <script>
          function addFormEventListeners() {
                    const cancelIcon = document.getElementById('cancel-icon');
                    if (cancelIcon) {
                        cancelIcon.addEventListener('click', function () {
                            container.style.display="block";
                            floatForm.style.display = 'none';
                        });
                    } else {
                        console.error("Cancel icon element not found.");
                    }

                    const mySubmit = document.getElementById('MYsubmit');
                    if (mySubmit) {
                        mySubmit.addEventListener('click', function (e) {
                            const paidInput = document.getElementById('paidInput');
                            const balance = document.querySelector('.balance p').innerText;
                            const paidAmount = parseFloat(paidInput.value);
                            const balanceAmount = parseFloat(balance);
                            if (paidAmount > balanceAmount) {
                                e.preventDefault();
                                document.getElementById('feeWarning').style.display = 'block';
                            } else {
                                document.getElementById('feeWarning').style.display = 'none';
                            }
                        });
                    }
                }
          

        // console.log("Before adding event listener"); // Check if this line logs correctly
        // // const feeform = document.getElementById("feeform"); 

        // document.addEventListener("DOMContentLoaded", function () {
        //     console.log("DOM Loaded"); // Check if DOMContentLoaded event fires correctly

        //     document.getElementById("editbtn").addEventListener("click", function (event) {
        //         event.preventDefault(); // Prevent the default form submission
        //         console.log("asad");

        //         var xhr = new XMLHttpRequest();
        //         xhr.open("POST", "fixedfee.php", true);
        //         console.log(xhr);
                                 
        //         xhr.onload = function () {
        //             if (xhr.status === 200) {
        //                 document.getElementById("response").innerHTML = xhr.responseText;

        //             } else {
        //                 // document.getElementById("response").innerHTML = "Error: " + xhr.statusText;
        //             }
        //         };

        //         xhr.onerror = function () {
        //             document.getElementById("response").textContent = "An error occurred during the request.";
        //         };

        //         xhr.send(); // Send the form data
        //     });
        // });
        // function validateForm() {
        //     var paidInput = document.getElementById("paidInput").value.trim();
            // var balance =; // Fetch balance fee from PHP

        //     var paidAmount = parseFloat(paidInput);
        //     var balanceAmount = parseFloat(balance);

        //     if (paidAmount > balanceAmount) {
        //         document.getElementById("feeWarning").style.display = "block";
        //         document.getElementById("MYsubmit").disabled = true; // Disable submit button if fee is invalid
        //     } else {
        //         document.getElementById("feeWarning").style.display = "none";
        //         document.getElementById("MYsubmit").disabled = false; // Enable submit button if fee is valid
        //     }
        // }
    </script>




    <!-- <p>' . $row['FEES'] . '</p>
                         <a href="edit.php?id=' . $_GET["id"] . '&edit=true">
                        <svg
                        style="height:1rem;width:1rem;margin:0%;padding:0%;"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V299.6l-94.7 94.7c-8.2 8.2-14 18.5-16.8 29.7l-15 60.1c-2.3 9.4-1.8 19 1.4 27.8H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM549.8 235.7l14.4 14.4c15.6 15.6 15.6 40.9 0 56.6l-29.4 29.4-71-71 29.4-29.4c15.6-15.6 40.9-15.6 56.6 0zM311.9 417L441.1 287.8l71 71L382.9 487.9c-4.1 4.1-9.2 7-14.9 8.4l-60.1 15c-5.5 1.4-11.2-.2-15.2-4.2s-5.6-9.7-4.2-15.2l15-60.1c1.4-5.6 4.3-10.8 8.4-14.9z"/></svg></a> -->
</body>


</html>