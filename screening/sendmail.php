<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Adjust path if necessary

function sendEmail($to, $name, $subject, $body, $altBody) {
    try {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.ethereal.email';
        $mail->SMTPAuth = true;
        $mail->Username = 'marie39@ethereal.email';
        $mail->Password = 'Vv3qTqDV5yRwvjRK6H';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;


        //Recipients
        $mail->setFrom('ardith45@ethereal.email', 'Your Company Name');
        $mail->addAddress($to, $name);

        //Content
        $mail->isHTML(true);  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = $altBody;

        $mail->send();
        return true; // Indicate success
    } catch (Exception $e) {
        error_log("PHPMailer Error: " . $mail->ErrorInfo); // Log the error
        return false; // Indicate failure
    }
}
?>