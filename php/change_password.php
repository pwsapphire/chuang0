<?php
// Require connexion DB
require 'config.php';
?><html>
<head>
	<title>Change Password</title>
</head>
<body>
<?php
$emailClient = isset($_GET['email']) ? trim($_GET['email']) : '';
$token = isset($_GET['token']) ? trim($_GET['token']) : '';

// J'initialise ma variable
$tokenOk = false;
// Token fourni
if (!empty($token)) {
	// Devrait etre mis dans une fonction car répété !!!!!!!
	$checkEmail = '
		SELECT usr_id, usr_password
		FROM usr
		WHERE usr_email = :email
	';
	$pdoStatement = $pdo->prepare($checkEmail);
	$pdoStatement->bindValue(':email', $emailClient, PDO::PARAM_STR);
	// J'exécute ma requete et je teste si j'ai des résultats
	if ($pdoStatement->execute() && $pdoStatement->rowCount() > 0) {
		// => L'email existe
		$res = $pdoStatement->fetch();
		// Je créé le token à partir des informations du user
		$tokenValid = md5($emailClient.'sdfghr45f'.$res['usr_password']);

		// Je teste le bon token généré avec le token fourni
		if ($tokenValid === $token) {
			$tokenOk = true;
		}
		else {
			echo 'token invalid<br />';
		}
	}
	else {
		echo 'email does not exists<br />';
	}
}
else {
	echo 'token empty<br />';
}



// On affiche le formulaire de changement de password que si le token est valide
if ($tokenOk) {
?>
	<form action="" method="post">
		<fieldset>
			<legend>Change password</legend>
			<input type="hidden" name="emailT" value="<?php echo $emailClient; ?>" />
			<input type="password" name="passwordT1" value="" placeholder="Your password" /> (at least 8 characters)<br />
			<input type="password" name="passwordT2" value="" placeholder="Confirm your password" /><br />
			<input type="submit" value="Change password"><br />
		</fieldset>
	</form>
<?php

// si formulaire soumis
if (!empty($_POST['emailT']) && !empty($_POST['passwordT1'])) {
	print_r($_POST);

	// Je récupère les données du post
	$email = isset($_POST['emailT']) ? trim($_POST['emailT']) : '';
	$password1 = isset($_POST['passwordT1']) ? trim($_POST['passwordT1']) : '';
	$password2 = isset($_POST['passwordT2']) ? trim($_POST['passwordT2']) : '';

	// Je fais les vérifications
	$formOk = true;
	if (empty($password1)) {
		echo 'password empty<br />';
		$formOk = false;
	}
	if ($password1 !== $password2) {
		echo 'passwords are different<br />';
		$formOk = false;
	}
	if(empty($email)) {
		echo 'email empty<br />';
		$formOk = false;
	}
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo 'email not valid<br />';
		$formOk = false;
	}
	if (strlen($password1) < 8) {
		echo 'password too short<br />';
		$formOk = false;
	}
	
	// Si vérifs ok
	if ($formOk) {
		
			// J'insère en DB
			$insertUser = '
				UPDATE usr 
				SET usr_password=:password
				WHERE usr_email = :email
			';
			// Je bind mes variables de requête
			$pdoStatement = $pdo->prepare($insertUser);
			$pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);
			// Je mets le password hashed dans une variable pour pouvoir la mettre en session
			$passwordHashed = password_hash($password1, PASSWORD_BCRYPT);
			$pdoStatement->bindValue(':password', $passwordHashed, PDO::PARAM_STR);

			// J'exécute
			if ($pdoStatement->execute()) {
				echo 'password changed successfully<br />';
				// On met les variables en session
				//$_SESSION['sess_login'] = $email;
				//$_SESSION['sess_password'] = $passwordHashed;
				
				header('Location: '.ABSOLUTE_URL.'signin.php');
				exit;


				
			}
			else {
				echo 'ouch<br />';
			}
		
	}
}

}
?>
</body>
</html>