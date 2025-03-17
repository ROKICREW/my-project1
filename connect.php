<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Twilio\Rest\Client;

require 'vendor/autoload.php';

// Database Connection
$servername = "localhost";
$username = "root";  
$password = "";      
$database = "dj_booking"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = $_POST['Name'] ?? '';  
    $Phone = $_POST['Phone'] ?? '';
    $Mail = $_POST['Mail'] ?? ''; // Client's email
    $Events = $_POST['Events'] ?? '';
    $Location = $_POST['Location'] ?? '';
    $Date = $_POST['Date'] ?? '';
    $Time = $_POST['Time'] ?? '';

    if (empty($Location) || empty($Mail)) {  
        die("Error: Location and Email fields are required!");
    }

    // Insert booking data into database
    $stmt = $conn->prepare("INSERT INTO booking (Name, Phone, Mail, Events, Location, Date, Time) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssss", $Name, $Phone, $Mail, $Events, $Location, $Date, $Time);

    if ($stmt->execute()) {
        // Email the DJ (Owner) after successful booking
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  
            $mail->SMTPAuth = true;
            $mail->Username = 'djraki2025@gmail.com'; // Your DJ email
            $mail->Password = 'jsqi yyqh joss wqcz'; // Use App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // **Set "From" as the client**
            $mail->setFrom($Mail, $Name); // Client's email as sender

            // **Send email to DJ (Owner)**
            $mail->addAddress('djraki2025@gmail.com');  
            $mail->addAddress('kishorekumar200316@gmail.com');  
            // Email content
            $mail->isHTML(true);
            $mail->Subject = "New DJ Booking Request from $Name";
            $mail->Body    = "
                <h3>New Booking Request</h3>
                <p><strong>Name:</strong> $Name</p>
                <p><strong>Phone:</strong> $Phone</p>
                <p><strong>Email:</strong> $Mail</p>
                <p><strong>Event:</strong> $Events</p>
                <p><strong>Location:</strong> $Location</p>
                <p><strong>Date:</strong> $Date</p>
                <p><strong>Time:</strong> $Time</p>
                <p>Please contact the client for confirmation.</p>
            ";

            if ($mail->send()) {
                echo "<script>
                        alert('Booking Successful! Notification sent to DJ.');
                        window.location.href='home.html'; 
                      </script>";
            } else {
                echo "Email could not be sent.";
            }
        } catch (Exception $e) {
            echo "Email error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error in booking.";
    }
}

?>

