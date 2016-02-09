<?php
session_start();

// Connexion à la DB
$dsn = 'mysql:dbname=yelp;host=192.168.210.85;charset=UTF8';
$user = 'yelp';
$passwordDb = 'webforce3';
// Effectuer la connexion
$pdo = new PDO($dsn, $user, $passwordDb);

// Un define, une constante
define('ABSOLUTE_URL', 'http://localhost/chuang0/php/');

function checkUser($userEmail, $userPassword, $alreadyHashed=false) {
	global $pdo;
	// Je prépare ma requête
	$checkUser = '
		SELECT *
		FROM usr
		WHERE usr_email = :user
	';
	$pdoStatement = $pdo->prepare($checkUser);
	$pdoStatement->bindValue(':user', $userEmail, PDO::PARAM_STR);

	// J'exécute
	if ($pdoStatement->execute()) {
		if ($pdoStatement->rowCount() > 0) {
			// Je récupère le mot de passe
			$res = $pdoStatement->fetch();
			$passwordHashed = $res['usr_password'];
			$userRole = $res['role_rol_id'];

			// Si le mot de passe fourni est déjà haché
			if ($alreadyHashed) {
				if ($userPassword == $passwordHashed) {
					return true;
				}
			}
			// Je check le mot de passe haché
			else {
				if (password_verify($userPassword, $passwordHashed)) {
					// On mets les variables en session
					$_SESSION['sess_login'] = $userEmail;
					$_SESSION['sess_password'] = $passwordHashed;
					$_SESSION['sess_role'] = $userRole;

					return true;
				}
			}
		}
	}
	return false;
}

function autoMail($to, $subject, $messsageHTML, $messageText) {
	require_once 'PHPMailer-master/PHPMailerAutoload.php';

	$mail = new PHPMailer;

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.googlemail.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'yelp.website@gmail.com';                 // SMTP username
	$mail->Password = 'webforce3';  // SMTP password
	$mail->SMTPSecure = 'tls';
	$mail->Port = 587;                                    // TCP port to connect to

	$mail->setFrom('yelp.website@gmail.com', 'Yelp Website admin : password lost');
	$mail->addAddress($to);
	//$mail->addBCC('webmaster@monsite.lu');

	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = $subject;
	$mail->Body    = $messsageHTML;
	$mail->AltBody = $messageText;

	return $mail->send();
}