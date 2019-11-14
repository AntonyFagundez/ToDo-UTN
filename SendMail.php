<?php 
// PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception;

// Base files 
require 'C:\xampp\htdocs\UTN\vendor\phpmailer\phpmailer\src\Exception.php';
require 'C:\xampp\htdocs\UTN\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\UTN\vendor\phpmailer\phpmailer\src\SMTP.php';

$mailUserName = 'tucorreo@correo.com';
$mailPassword = 'tucontrasenia';

class SendMail{

    public function sendWelcome($email, $name){
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP(); // using SMTP protocol
            $mail->Host = 'smtp.gmail.com'; // SMTP host as gmail 
            $mail->SMTPAuth = true;  // enable smtp authentication
            $mail->Username = $mailUserName;  // sender gmail host
            $mail->Password = $mailPassword; // sender gmail host password
            $mail->SMTPSecure = 'tls';  // for encrypted connection                           
            $mail->Port = 587;   // port for SMTP     
            $mail->CharSet = 'UTF-8';
            $mail->AddReplyTo('no-replyto@email.com', 'Tareas');
            $mail->setFrom('tareaslistadolamejorapp@gmail.com', "Tareas la mejor App"); // sender's email and name
            $mail->addAddress($email, "$name");  // receiver's email and name
            $mail->Subject = 'Tareas App - Bienvenida';
            $mail->Body = "Bienvenido a la mejor Aplicacion de Tareas";
            $mail->send();
            $mail->Body = null;
            $mail = null;
            header('Location: main.php');
        } catch (Exception $e) { // handle error.
        //header('Location: main.php');
        }
    }


    public function sendInvitation($email, $name, $message){
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP(); // using SMTP protocol
            $mail->Host = 'smtp.gmail.com'; // SMTP host as gmail 
            $mail->SMTPAuth = true;  // enable smtp authentication
            $mail->Username = $mailUserName;  // sender gmail host
            $mail->Password = $mailPassword; // sender gmail host password
            $mail->SMTPSecure = 'tls';  // for encrypted connection                           
            $mail->Port = 587;   // port for SMTP     
            $mail->CharSet = 'UTF-8';
            $mail->AddReplyTo('no-replyto@email.com', 'Tareas');
            $mail->setFrom('tareaslistadolamejorapp@gmail.com', "Tareas la mejor App");
            $mail->addAddress($email, "$name");  // receiver's email and name
            $mail->Subject = 'Tareas App - Invitación';
            $mail->Body = "$message";
            $mail->send();
            $mail = null;
            $_SESSION['message'] ="Invitación enviada a $name!";
            header('Location: main.php');
    
        } catch (Exception $e) { 
            $_SESSION['message'] ="Ups, algo ocurrió, intentalo más tarde!";
            header('Location: main.php');
        }

    }

}
?>