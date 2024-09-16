<?php
// Database connection
$servername = "localhost";
$username = "root";  // Your database username
$password = "";  // Your database password
$dbname = "your_database_name";  // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Get today's date
$today = date('m-d'); // Format for comparison

// SQL query to find customers with today's birthday
$sql = "SELECT name, email FROM customers WHERE DATE_FORMAT(birthday, '%m-%d') = '$today'";
$result = $conn->query($sql);

// Check if any customer has a birthday today
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $email = $row['email'];

        // Subject and message for the email
        $subject = "Happy Birthday, $name!";
        $message = "Dear $name,\n\nWe at [Your Company] wish you a very Happy Birthday! 🎉\n\nHave a wonderful day!\n\nBest Regards,\n[Your Company Name]";
        
        // Headers for the email
        $headers = "From: no-reply@yourcompany.com";

        // Send the email
        if(mail($email, $subject, $message, $headers)) {
            echo "Birthday wish sent to $name at $email\n";
        } else {
            echo "Failed to send birthday wish to $name\n";
        }
    }
} else {
    echo "No birthdays today.";
}

// Close the database connection
$conn->close();














?>
