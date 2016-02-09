<?php
// Require connexion DB
require 'config.php';
?>
<html>
<head>
	<title>User sign in</title>
</head>
<body>
<pre><?php

// formulaire soumis
if (!empty($_POST)) {
	print_r($_POST);
	// Je récupère les données en POST
	$emailSignIn = isset($_POST['emailSignIn']) ? trim($_POST['emailSignIn']) : '';
	$passwordSignIn = isset($_POST['passwordSignIn']) ? $_POST['passwordSignIn'] : '';

	// Je fais les vérifications
	if (!empty($emailSignIn) && !empty($passwordSignIn)) {
		// J'utilise ma fonction qui vérifie un login/password
		if (checkUser($emailSignIn, $passwordSignIn)) {
			echo 'sign in ok<br />';
		}
		else {
			echo 'email and/or password are not valid<br />';
		}
	}
	else {
		echo 'email and/or password are empty<br />';
	}
}
?>
</pre>
<?php
// --- Je check le user en session ---
$sessionOk = false;
// Si j'ai les données en session
if (!empty($_SESSION['sess_login']) && !empty($_SESSION['sess_password'])) {
	// J'utilise ma fonction qui vérifie un login/password
	if (checkUser($_SESSION['sess_login'], $_SESSION['sess_password'], true)) {
		// Je déconnecte si demandé
		if (!empty($_GET['deconnexion'])) {
			session_destroy();
			echo 'logged off<br />';
		}
		else {
			$sessionOk = true;
			echo 'you are logged in<br />';
			echo '<a href="signin.php?deconnexion=1">Log off</a>';
		}
	}
}
// Sinon, j'affiche le formulaire de connexion
if (!$sessionOk) {
?>

<form id="formLogin" action="" method="post">
	<fieldset>
		<legend>User sign in</legend>
		<input type="email" name="emailSignIn" value="" placeholder="Email address" /><br />
		<input type="password" name="passwordSignIn" value="" placeholder="Your password" /><br />
		<input type="submit" value="Sign in"> <a href="#" class="switchBtn">Lost password ?</a><br />
	</fieldset>
</form>

<?php


// Si formulaire 'Password Lost' soumis
if (!empty($_POST['emailLostPassword'])) {
	// Je récupère la donnée en POST
	$email = isset($_POST['emailLostPassword']) ? trim($_POST['emailLostPassword']) : '';
	echo '$email : ' .$email.'<br/>';
	// Je check la validité des données
	if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
		$checkEmail = '
			SELECT usr_id, usr_password
			FROM usr
			WHERE usr_email = :email
		';
		$pdoStatement = $pdo->prepare($checkEmail);
		$pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);
		// J'exécute ma requete et je teste si j'ai des résultats
		if ($pdoStatement->execute() && $pdoStatement->rowCount() > 0) {
			// => L'email existe
			$res = $pdoStatement->fetch();
			// Je créé un token à partir des informations du user
			$token = md5($email.'sdfghr45f'.$res['usr_password']);

			$emailHTML = '<html>
			<head><title>Lost password</title></head>
			<body>
			Dear user,<br />
			<br />
			You\'ve asked to change your password.<br />
			<a href="'.ABSOLUTE_URL.'change_password.php?email='.$email.'&token='.$token.'">Click here to change your password</a>.<br />
			<br />
			Best regards,
			</body>
			</html>';
			$emailText = 'Go here : '.ABSOLUTE_URL.'change_password.php?email='.$email.'&token='.$token;
			$subject = 'Lost password on Our Website';
			// On envoie l'email
			if (autoMail($email, $subject, $emailHTML, $emailText)) {
				echo 'An email has been sent to '.$email.'<br />';
			}
			else {
				echo 'arf, email could not be sent<br />';
			}
		}
		else {
			// L'email n'existe pas
			echo 'Sorry, this email does not exists<br />';
		}
	}
	else {
		echo 'email is not valid<br />';
	}
}


?>

<form id="formLost" action="" method="post" style="display:none">
		<fieldset>
			<legend>Lost password</legend>
			<input type="email" name="emailLostPassword" value="" placeholder="Email address" /><br />
			<input type="submit" value="Change password"><br />
		</fieldset>
	</form>

<?php
}
?>

<!-- chargement du jQuery -->
    <script type="text/javascript" src="../js/jquery-2.2.0.min.js" ></script>
<script type="text/javascript"  src="../js/validation_email_pwd.js">
</script>

</body>
</html>