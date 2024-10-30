<?php
// Load PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Database connection
$servername = "localhost";
$username = "root";  // Your database username
$password = "";  // Your database password
$dbname = "greenefx_database";  // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get today's date
$today = date('m-d'); // Format for comparison

// SQL query to find customers with today's birthday
$sql = "SELECT name, email FROM student_details	 WHERE DATE_FORMAT(DOB, '%m-%d') = '$today'";
$result = $conn->query($sql);

// Check if any customer has a birthday today
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $email = $row['email'];

        // Create a new PHPMailer object
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();                                        // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';              // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                               // Enable SMTP authentication
            $mail->Username   = 'your-email@yourdomain.com';        // SMTP username
            $mail->Password   = 'your-email-password';              // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                // TCP port to connect to

            //Recipients
            $mail->setFrom('your-email@yourdomain.com', 'Your Company');
            $mail->addAddress($email, $name);                       // Add a recipient

            // Content
            $mail->isHTML(true);                                    // Set email format to HTML
            $mail->Subject = "Happy Birthday, $name!";
            $mail->Body    = "Dear $name,<br><br>We at <strong>Your Company</strong> wish you a very Happy Birthday! 🎉<br>Have a wonderful day!<br><br>Best Regards,<br>Your Company";
            $mail->AltBody = "Dear $name,\n\nWe at Your Company wish you a very Happy Birthday! 🎉\nHave a wonderful day!\n\nBest Regards,\nYour Company";

            // Send the email
            $mail->send();
            echo "Birthday wish sent to $name at $email\n";
        } catch (Exception $e) {
            echo "Failed to send birthday wish to $name. Mailer Error: {$mail->ErrorInfo}\n";
        }
    }
} else {
    echo "No birthdays today.";
}

// Close the database connection
$conn->close();
?>
