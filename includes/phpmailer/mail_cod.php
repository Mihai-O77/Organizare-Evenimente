<?php

if($send === "yes"){
  

//sursa: https://github.com/PHPMailer/PHPMailer
//tutorial: https://alexwebdevelop.com/phpmailer-tutorial/
//Gmail restriction: https://support.google.com/mail/answer/22370?hl=en

require_once('class.phpmailer.php');
require_once('mail_config.php');

// Mesajul
$message = $mesaj;

// În caz că vre-un rând depășește N caractere, trebuie să utilizăm
// wordwrap()
$message = wordwrap($message, 80, "<br />\n");


$mail = new PHPMailer(true); 

$mail->IsSMTP();

try {
 
  $mail->SMTPDebug  = 3;                     
  $mail->SMTPAuth   = true; 

  $to=$email;
  $nume=$usernameul;

  $mail->SMTPSecure = "ssl";                 
  $mail->Host       = "smtp.gmail.com";      
  $mail->Port       = 465;                   
  $mail->Username   = $username;  			// GMAIL username
  $mail->Password   = $password;            // GMAIL password
  $mail->AddReplyTo($fromm, $namefrom);
  $mail->AddAddress($to, $nume);
 
  $mail->SetFrom($fromm, $namefrom);
  $mail->Subject = $subiect;
  if($attach){
    $mail->AddAttachment($path);
  }
  $mail->AltBody = 'To view this post you need a compatible HTML viewer!'; 
  $mail->MsgHTML($message);
  $mail->Send();
  echo "Message Sent OK</p>\n";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //error from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //error from anything else!
}
$send = "no";
}
?>
