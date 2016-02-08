<?php

function autoMail($to, $subject, $messageHTML, $messageText){
	require_once 'PHPMailer-master/PHPMailerAutoload.php';

	$mail = new PHPMailer;

	//$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'server mail de fournisseur ex: smtp.live.com ';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'adresse email admin ici';                 // SMTP username
	$mail->Password = 'mdp de adresse admin ici';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    // TCP port to connect to

	$mail->setFrom('adresse email admin ici', 'pseudo ici');
	$mail->addAddress($to);     // Add a recipient
	//$mail->addAddress('ellen@example.com');               // Name is optional
	//$mail->addReplyTo('info@example.com', 'Information');
	//$mail->addCC('cc@example.com');
	//$mail->addBCC('bcc@example.com');

	//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = $subject;
	$mail->Body    = $messageHTML;
	$mail->AltBody = $messageText;

	return $mail->send();

	//if(!$mail->send()) {
	//    return
	//} else {
	//    echo 'Message has been sent';
	//}
}

if (autoMail('williampan1981@gmail.com', 'test2', 'contenu <b>html</b>', 'contenu text')) {
	echo 'sent</br>';
}

