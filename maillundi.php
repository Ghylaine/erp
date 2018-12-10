<?php
require 'PHPMailerAutoload.php';
include "class.phpmailer.php";
///require_once 'Vendor/autoload.php';
// require 'credential.php';

$mail = new PHPMailer;

$mail->SMTPDebug = 3;                               // Enable verbose debug


$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->Username = 'bigighylaine@gmail.com';                 // SMTP username
$mail->Password = '24091994mer'; 
// $mail->Host = 'smtp.sopami.com';  // Specify main and backup SMTP servers
// $mail->Username = 'support@sopami.com';                 // SMTP username
// $mail->Password = 'technology@SOPAMI.2013';                          // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to
$mail->SMTPAuth = true;                               // Enable SMTP authentication

$mail->setFrom('bigighylaine@gmail.com','AGAHARAWE');
$mail->addAddress('bigighylaine@gmail.com');     // Add a recipient
$mail->addReplyTo('bigighylaine@gmail.com');
//$file_name=$_FILE["file"]["fichier"];
//move_uploaded_file($_FILE["file"]["tmp_name"],$file_name);
// Optional name
//header("Content-Type: application/vnd.ms-excel");
//header("Content-Disposition:filename=$fichier.xls");
//$mail->Send();
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = 'Rapport';
$mail->Body    = '<h1>Ceci est rapport excel journalier fait manuellement</h1>';
//$mail->addAttachment('$file_name');    
//$mail->AltBody = $_POST['message'];
//$my_path=($_SERVER['DOCUMENT_ROOT'].'C:\Users\zebra\Downloads\fichier');

$mail->AddAttachment(
    'C:\Users\zebra\Downloads\fichier.xls',
    'rapport.xls',
    'base64',
    'mime/type'
);

//$mail->AddAttachment('C:\Users\zebra\Downloads\fichier', "fichier.xls");

if(!$mail->send()) {
    echo 'rapport excel envoye avec succes.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message envoye';
}