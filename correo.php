<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
session_start();

if ($_GET["enviar"] == "aprobar-solicitud") {
    include('views/mails/solicitudAprobada.php');
}

$body = (explode("@", $_GET["correo"])[1] == 'gmail.com') ? $text_message : $message;

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                   //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.minerven.com.ve';                 //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'glpiminerven@minerven.com.ve';         //SMTP username
    $mail->Password   = 'UL2M99JWJQ';                           //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('glpiminerven@minerven.com.ve', 'Soporte');
    $mail->addAddress($_POST['correo']);
    // $mail->addAddress('glpiminerven@minerven.com.ve');
    // $mail->addAddress('lmolina@minerven.com.ve', 'Luis Molina');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');

    //Content
    $mail->setLanguage('es', 'vendor/phpmailer/phpmailer/language/phpmailer.lang-es.php');
    $mail->isHTML(true); //Set email format to HTML
    $mail->Subject = 'Solicitud de Surtido Aprobada';
    $mail->Body    = $message;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();

    $_SESSION['alert'] = [
        'message' => 'Mensaje enviado a '. $_POST['correo'],
        'status' => 'success',
        'y' => 'top',
        'x' => 'right',
    ];
    header("location: /index.php");
} 
catch (Exception $e) {
    $_SESSION['alert'] = [
        'message' => 'No se pudo enviar el correo. intente nuevamente',
        'status' => 'danger',
        'y' => 'top',
        'x' => 'right',
    ];
    header("location: /index.php");
    error_log($mail->ErrorInfo);
}
?>