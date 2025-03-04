<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Constants for configuration
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'khunsithuaung65@gmail.com'); // Replace with your Gmail
define('SMTP_PASS', 'mytz cwjb wjgf sojn'); // Replace with your App Password
define('SMTP_PORT', 587);
define('SMTP_SECURE', PHPMailer::ENCRYPTION_STARTTLS);
define('SENDER_EMAIL', 'khunsithuaung65@gmail.com');
define('SENDER_NAME', 'Your Name');
define('RECIPIENT_EMAIL', 'khunsithuaung65@gmail.com'); // Replace with recipient email

// Generate OTP
function generateOTP() {
    $_SESSION['otp'] = rand(100000, 999999); // 6-digit OTP
    $_SESSION['otp_expiry'] = time() + 300; // 5 minutes expiry
    return $_SESSION['otp'];
}

// Send OTP via Email
function sendOTPEmail() {
    if (!isset($_SESSION['otp'])) {
        die("OTP not generated yet!");
    }

    $otp = $_SESSION['otp'];
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port = SMTP_PORT;

        // Recipients
        $mail->setFrom(SENDER_EMAIL, SENDER_NAME);
        $mail->addAddress(RECIPIENT_EMAIL);

        // Content
        $mail->isHTML(false); // Set email format to plain text
        $mail->Subject = 'Your OTP Code';
        $mail->Body = "Your OTP code is: $otp";

        $mail->send();
        echo "OTP sent successfully to " . RECIPIENT_EMAIL;
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}

// Main Logic
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    if ($_GET['action'] === 'generate') {
        generateOTP();
        echo "OTP Generated: " . $_SESSION['otp'];
    } elseif ($_GET['action'] === 'send_email') {
        sendOTPEmail();
    } else {
        echo "Invalid action!";
    }
} else {
    echo "No action specified!";
}
?>