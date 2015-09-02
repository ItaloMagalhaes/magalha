<?php
    require 'PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'contatosecompufsj@gmail.com';                 // SMTP username
    $mail->Password = 'l!nk3d37';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to
    $mail->From = 'contatosecompufsj@gmail.com';
    $mail->FromName = 'IV SECOMP';
    $mail->addAddress('gleybersonandrade@gmail.com', 'Gleyberson');     // Add a recipient
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Informe Teste';
    $mail->Body    = 'Mensagem em texto';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    if ($mail->send()){
        echo "Enviado" ;        
    } else {
        echo "Não enviado ";
    }
?>