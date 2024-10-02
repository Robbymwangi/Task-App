<?php
require 'vendor/autoload.php'; // Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $username = $_POST['username'] ?? '';

    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Email is valid';
        // Email is valid, send a welcome email
        $subject = "Welcome to ICS 2.2! Account Verification";
        $message = "
            <html>
            <head>
                <title>Welcome to ICS 2.2!</title>
            </head>
            <body>
                <p>Hello $username,</p>
                <p>You requested an account on ICS 2.2.</p>
                <p>In order to use this account, you need to <a href='http://example.com/verify?email=" . urlencode($email) . "'>Click Here</a> to complete the registration process</p>
                <p>Best Regards,<br> Systems Admin <br> ICS 2.2</p>
            </body>
            </html>
        ";

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = 'robby.muhia@strathmore.edu'; // SMTP username
            $mail->Password = 'daua avci nucv rgul'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('robby.muhia@strathmore.edu', 'ICS 2.2 Admin');
            $mail->addAddress($email, $username);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            // Send the email
            $mail->send();
            echo "A welcome email has been sent to $email.";
        } catch (Exception $e) {
            echo "Failed to send the welcome email. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // Email is not valid
        echo 'Invalid email address.';
    }
} else {
    // Display the form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Test Mail</title>
    </head>
    <body>
        <form action="mail.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <input type="submit" value="Send Email">
        </form>
    </body>
    </html>
    <?php
}
?>