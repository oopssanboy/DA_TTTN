<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    public static function sendMail($to, $subject, $content) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; 
            $mail->SMTPAuth   = true;
            
            $mail->Username   = 'oopssanboy@gmail.com'; 
            $mail->Password   = 'woat vzlw zmvq rvyf'; 
            
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
            $mail->Port       = 465;

            $mail->CharSet = 'UTF-8';

            $mail->setFrom('oopssanboy@gmail.com', 'Chapter One BookStore');
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $content;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>