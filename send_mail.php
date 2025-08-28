<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';


$name = $_POST['full_name'] ?? '';
$email = $_POST['email'] ?? '';
$mobile = $_POST['mobile_number'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

$mail = new PHPMailer(true);

try {
    
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; 
    $mail->SMTPAuth   = true;
    $mail->Username   = 'sorupr5@gmail.com'; 
    $mail->Password   = 'ucyyoctyariuapjr';    
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom($email, $name);
    $mail->addAddress('sorupr5@gmail.com', 'Sorup Rohan'); 

  
    $mail->isHTML(true);
    $mail->Subject = $subject ?: 'Contact Form Submission';
    $mail->Body    = "
        <b>Name:</b> $name<br>
        <b>Email:</b> $email<br>
        <b>Mobile:</b> $mobile<br>
        <b>Message:</b><br>" . nl2br(htmlspecialchars($message));

    $mail->send();
    echo "<script>alert('Message sent successfully!');window.location.href='index.php';</script>";
} catch (Exception $e) {
    echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');window.location.href='index.php';</script>";
}
?>