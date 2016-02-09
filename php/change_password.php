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
			<input type="hidden" name="email" value="<?php echo $emailClient; ?>" />
			<input type="password" name="passwordToto1" value="" placeholder="Your password" /> (8 caractères minimum)<br />
			<input type="password" name="passwordToto2" value="" placeholder="Confirm your password" /><br />
			<input type="submit" value="Change password"><br />
		</fieldset>
	</form>
<?php
}
?>
</body>
</html>