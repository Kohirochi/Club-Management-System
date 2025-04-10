<?php
session_start();
    
use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST['submit'])){
    // get the value from the form and store in a variable
    $name = trim($_POST['user-name']);
    $email = trim($_POST['email-address']);
    $contact = trim($_POST['contact-number']);
    $inquiry = trim($_POST['inquiry']);
    
    require_once "PHPMailer/PHPMailer.php";
    require_once "PHPMailer/SMTP.php";
    require_once "PHPMailer/Exception.php";

    $mail = new PHPMailer();

    // SMTP Settings
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "ellyis2002@gmail.com";
    $mail->Password = "apgtvmcxxmxubzdi";
    $mail->Port = "587"; // 465
    $mail->SMTPSecure = "tls"; // ssl

    // Email Settings
    $mail->setFrom($email, $name);
    $mail->addAddress(address: "kaibinyong2002@gmail.com");
    $mail->Subject = "ClubExpress Inquiry";
    $mail->Body = "Name: " . $name . "\nEmail: ". $email . "\nContact Number: ". $contact . "\nInquiry: " . $inquiry;

    // If email is sent
    if ($mail->send()) {
        $_SESSION['update'] = true;
        $_SESSION['message'] = "Email Sent Successfully";
    } else {
        $_SESSION['update'] = false;
        $_SESSION['message'] = "Failed to Send Email";
    }

    echo "<script> window.location.href='contact_us.php';</script>";

}
?>