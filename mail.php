<?php
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
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: no-reply@ics22.com' . "\r\n";

    // Send the email
    if (mail($email, $subject, $message, $headers)) {
        echo "A welcome email has been sent to $email.";
    } else {
        echo "Failed to send the welcome email.";
        $error = error_get_last();
        echo 'Error: ' . $error['message'];
    }
} else {
    // Email is not valid
    echo 'Invalid email address.';
}
?>