<?php
require_once('vendor/autoload.php');
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.hostinger.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'info@tastejamica.devproedge.com';                 // SMTP username
    $mail->Password = '@1Tastejamica.devproedge.com';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to
    // $mail->Port = 465;                                    // TCP port to connect to

    //Recipients
    // $to='crknowledge1@gmail.com';
    $mail->setFrom('info@tastejamica.devproedge.com', 'tastejamaica');
    $mail->addAddress($to, $name);     // Add a recipient
    $mail->addAddress('info@tastejamica.devproedge.com');               // Name is optional
    $mail->addReplyTo($to, 'Information');
    $mail->addCC($to);
    $mail->addBCC($to);

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $subject = $notification_subject;
    $mail->Subject = $subject;
    ob_start();
    include $notification_file; // Replace with the actual path to your PHP file
    $htmlContent = ob_get_clean();

    $mail->Body = $htmlContent;

    $mail->send();
    echo 'Email sent successfully';
    //  $mail->Subject = $subject;
    //  $mail->Body    = $htmlContent;
    //  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    //  $mail->send();
    //  echo 'ok';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
