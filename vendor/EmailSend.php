<?php

/** Codigo cortesia del git oficial de PHPMailer :) **/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require 'autoload.php';
function enviarMail($EMAIL){
    $mail = new PHPMailer();
    $mail->isSMTP();

//Enable SMTP debugging
//SMTP::DEBUG_OFF = off (for production use)
//SMTP::DEBUG_CLIENT = client messages
//SMTP::DEBUG_SERVER = client and server messages
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
//aca tuvimos que investigar el smtp de outlook, google ya no funciona pero podria si lo permitis desde tu cuenta de google
    $mail->Host = 'smtp-mail.outlook.com';

// - SMTPS (implicit TLS on port 465) or
// - STARTTLS (explicit TLS on port 587)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPAuth = true;
    $mail->Username = 'pingponggame.unlam@outlook.com';
    $mail->Password = 'Argentina2023'; // asi harcodeado :'(
    $mail->setFrom('pingponggame.unlam@outlook.com', 'Ping Pong Game');
    $mail->addAddress($EMAIL, 'Bienvenido');
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject="¡Bienvenido a PingPong!";
    $url = 'http://localhost/index.php?module=user&method=validate&email='.$EMAIL;
    $logo = "https://i.postimg.cc/Zq2SGxjf/logo-pingpong.png";
    $mail->Body = '<div style="color: white; background-color: darkgreen; font-size: larger;">
  <center>
    <img src="'.$logo.'" alt="Logo">
  </center>
  <center>
    <h1>Bienvenido a PingPong</h1>
  </center>
  <br>
  <center>
    Por favor verifica tu cuenta con el siguiente link
    <br>
    <center>
      <h2>
        <a href="' . $url . '" style="text-decoration: none; background-color: 29c34a; color: black; padding: 2em;">Validar Email</a>
      </h2>
    </center>
    <br>
    <br>
  </center>
</div>';
    $mail->AltBody = 'Ping Pong Game, una aplicación divertida';
    $mail->AltBody = 'No se que poner acá :-(';

    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message sent!';

    }
}

function save_mail($mail)
{
    //You can change 'Sent Mail' to any other folder or tag
    $path = '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail';

    //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
    $imapStream = imap_open($path, $mail->Username, $mail->Password);

    $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
    imap_close($imapStream);

    return $result;
}