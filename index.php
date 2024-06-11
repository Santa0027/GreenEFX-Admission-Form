<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {


  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $full_name = $first_name;
  $email = $_POST['email'];
  $date = $_POST['date'];
  $month = $_POST['month'];
  $year = $_POST['year'];
  $DOB = $date . "/" . $month . "/" . $year;
  $phone = $_POST['phone'];
  $addi_phone = $_POST['secound_phone'];
  $address = $_POST['address'];
  $f_name = $_POST['father_name'];
  $m_name = $_POST['mother_name'];
  $gender = $_POST['gender'];
  $qualification = $_POST['qualification'];
  $feild_status = $_POST['feild_status'];
  $course = $_POST['course'];


  // database crediniate
  $db_server = "localhost";
  $db_user = "root";
  $db_pass = "";
  $db_name = "greenefx_database";
  $con = "";
  $con = mysqli_connect(
    $db_server,
    $db_user,
    $db_pass,
    $db_name
  );
  if($con){
    echo"connected";
  }else{
    echo "disconnected";
  }


  if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {


    $image = $_FILES['image']['tmp_name'];
    $name = $_FILES['image']['name'];
    $image = file_get_contents($image);
    $image = base64_encode($image);
    
    $sql = "INSERT INTO student_details(C_NAME,PHOTO,EMAIL,DOB,PHONE_NO,PHONE_2,C_ADDRESS,F_NAME,M_NAME,GENDER,QUALIFICATION,FEILD_OF_WORK,COURSE)
              VALUE('$full_name','$image','$email','$DOB','$phone','$addi_phone','$address','$f_name','$m_name','$gender','$qualification','$feild_status','$course')";

  } else {
    // If no image was uploaded, insert data with an empty PHOTO field
    $sql = "INSERT INTO student_details(C_NAME,PHOTO,EMAIL,DOB,PHONE_NO,PHONE_2,C_ADDRESS,F_NAME,M_NAME,GENDER,QUALIFICATION,FEILD_OF_WORK,COURSE)
              VALUE('$full_name',' ','$email','$DOB','$phone','$addi_phone','$address','$f_name','$m_name','$gender','$qualification','$feild_status','$course')";
  }
  // Execute the SQL query (assuming proper error handling)
//  mysqli_query($con, $sql);

  if ($con->query($sql) === TRUE) {
    echo"inserted";
    $response = array("success" => true, "message" => "New record created successfully");
  } else {
    echo "not";
    $response = array("success" => false, "message" => "Error: " . $sql . "<br>" . $con->error);

    // ... (further processing based on the query result)
  }


  //   $result = mysqli_query($con, $sql);
  // if ($result) {
  //   echo "Data inserted successfully!";
  // } else {
  //   echo "Error inserting data: " . mysqli_error($con);
  // }































    // $image = empty( $_POST['image'] ) ? " ": $_POST['image'];
    // $name = empty( $_POST['name'] ) ? " ": $_POST['name'];
    // $image = file_get_contents($image);
    // $image = base64_encode($image);
    // // $sql="INSERT INTO img (NAME, IMAGE) VALUES ('$name', '$image')";
    // $sql = "INSERT INTO enquiry_data (C_NAME,PHOTO,EMAIL,DOB,PHONE_NO,ADD_NUMBER,C_ADDRESS,F_NAME,M_NAME,GENDER,QUALIFICATION,FEILD_OF_WORK,COURSE)
    //       VALUE('$full_name','$image','$email','$DOB','$phone','$addi_phone','$address','$f_name','$m_name','$gender','$qualification','$feild_status','$course')";








    // $full_cname =$other_course_input=$current_status_input=$hear_us_input= filter_input(INPUT_POST, "cname", FILTER_SANITIZE_SPECIAL_CHARS);
    // $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    // $address = filter_input(INPUT_POST, "caddress", FILTER_SANITIZE_SPECIAL_CHARS);
    // $phone = filter_input(INPUT_POST, "zip", FILTER_SANITIZE_NUMBER_INT);

    // $new_variable1= empty($_POST['current']) ? $current_status : $current_status_input;

    // $new_variable2= empty($_POST['other_course_input']) ? $other_course : $other_course_input;

    // $new_variable3 = !empty($_POST['cc']) ? $input : $hear_us;

    // echo "/variable 1: \n $new_variable1";
    // echo "/variable 2: \n $new_variable2";
    // echo "/variable 3: \n $new_variable3";



    //     // database crediniate
//     $db_server = "localhost";
//     $db_user = "root";
//     $db_pass = "";
//     $db_name = "greenefx_enquiry_details";
//     $con = "";
//     $con = mysqli_connect(
//         $db_server,
//         $db_user,
//         $db_pass,
//         $db_name
//     );

    //     $sql = "INSERT INTO enquiry_data (C_NAME,EMAIL,DOB,PHONE_NO,ADD_NUMBER,C_ADDRESS,F_NAME,M_NAME,GENDER,QUALIFICATION,FEILD_OF_WORK,COURSE)
//      VALUE()";
//     if ($con->ping()) {
//       echo "Successful connection to MySQL!";
//     } else {
//       echo "Error: Connection failed (" . $con->connect_errno . ") " . $con->connect_error;
//     }

    // }

  }


?>