<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    public static function sendMail($to, $subject, $content) {
        $mail = new PHPMailer(true);
        try {
            // Cấu hình SMTP Server của Google
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; 
            $mail->SMTPAuth   = true;
            
            // BẠN CẦN SỬA 2 DÒNG DƯỚI ĐÂY:
            $mail->Username   = 'oopssanboy@gmail.com'; 
            $mail->Password   = 'woat vzlw zmvq rvyf'; 
            
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
            $mail->Port       = 465;

            // Thiết lập tiếng Việt
            $mail->CharSet = 'UTF-8';

            // Người gửi và người nhận
            $mail->setFrom('oopssanboy@gmail.com', 'Chapter One BookStore');
            $mail->addAddress($to);

            // Nội dung Email
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