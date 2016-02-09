<?php
// Require connexion DB
require 'config.php';
?>
<html>
<head>
	<title>User sign up</title>
</head>
<body>
<pre><?php


// si formulaire soumis
if (!empty($_POST)) {
	print_r($_POST);

	// Je récupère les données du post
	$email = isset($_POST['email']) ? trim($_POST['email']) : '';
	$password1 = isset($_POST['password1']) ? trim($_POST['password1']) : '';
	$password2 = isset($_POST['password2']) ? trim($_POST['password2']) : '';

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
		// Je teste si l'email existe déjà
		$checkEmail = '
			SELECT usr_email
			FROM usr
			WHERE usr_email = :email
		';
		$pdoStatement = $pdo->prepare($checkEmail);
		$pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);
		if ($pdoStatement->execute()
			&& $pdoStatement->rowCount() > 0) {
			echo $email.' already exists<br />';
		}
		else {
			// J'insère en DB
			$insertUser = '
				INSERT INTO usr (usr_email,  usr_password, role_rol_id, usr_date_of_creation)
				VALUES (:email, :password, 1, NOW())
			';
			// Je bind mes variables de requête
			$pdoStatement = $pdo->prepare($insertUser);
			$pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);
			// Je mets le password hashed dans une variable pour pouvoir la mettre en session
			$passwordHashed = password_hash($password1, PASSWORD_BCRYPT);
			$pdoStatement->bindValue(':password', $passwordHashed, PDO::PARAM_STR);

			// J'exécute
			if ($pdoStatement->execute()) {
				echo 'user signed up<br />';

				// On met les variables en session
				$_SESSION['sess_login'] = $email;
				$_SESSION['sess_password'] = $passwordHashed;
			}
			else {
				echo 'ouch<br />';
			}
		}
	}
}



?></pre>

<form action="" method="post">
	<fieldset>
		<legend>User sign up</legend>
		<input type="email" id="email_val" name="email" value="" placeholder="Email address"/><br />
		<p id="email_msg"></p>
		<input type="password" id="pwd_val" name="password1" value="" placeholder="Your password"/><br />
		<p id="pwd_msg"></p>
		<input type="password"  name="password2" value="" placeholder="Confirm your password" /><br />
		<input type="submit" value="Sign up">
	</fieldset>
</form>


 <!-- chargement du jQuery -->
    <script type="text/javascript" src="../js/jquery-2.2.0.min.js" ></script>
<script type="text/javascript"  src="../js/validation_email_pwd.js">
</script>

</body>
</html>