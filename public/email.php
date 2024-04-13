<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once('vendor/autoload.php');
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'email-smtp.us-east-1.amazonaws.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'AKIAS3MFIPOUGOH4EF4O';                 // SMTP username
    $mail->Password = 'BFFMaVwjAk74e1wd00L4fAEQGt7tcp7VLiZg/Qp5hgru';                           // SMTP password  
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to
    // $mail->Port = 465;                                    // TCP port to connect to

    //Recipients
    // $mail->setFrom($user_email, 'Taste Jamaica');
    $user_email='mohsinmalik866@gmail.com';
    $to=$user_email;
    $mail->setFrom('info@tastejamaica.com', 'Taste Jamaica');
    $mail->addAddress('sobankhan252@gmail.com', 'tastejamaica user');     // Add a recipient
    $mail->addAddress('sobankhan252@gmail.com','');               // Name is optional
    $mail->addReplyTo('sobankhan252@gmail.com', 'forget password');
    $mail->addCC('sobankhan252@gmail.com');
    $mail->addBCC('sobankhan252@gmail.com');

 //Content
 $subject='xyz';
 $htmlContent='testing';
 $mail->isHTML(true);                                  // Set email format to HTML
 $mail->Subject = $subject;
 $mail->Body    = $htmlContent;
//  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

 $mail->send();
 echo 'ok';
} catch (Exception $e) {
 echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
//  die();
}

?>