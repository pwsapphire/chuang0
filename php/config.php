<?php 
session_start();

// Connexion à la DB
$yuyuIp = '192.168.210.85';
$dsn = 'mysql:dbname=yelp;host={$yuyuIp};charset=UTF8';
$user = 'yelp';
$passwordDb = 'webforce3';
// Effectuer la connexion
$pdo = new PDO($dsn, $user, $passwordDb);

// Un define, une constante
define('ABSOLUTE_URL', 'http://localhost/proj1/');

function checkUser($userEmail, $userPassword, $alreadyHashed = false) {
    global $pdo;
    // Je prépare ma requête
    $checkUser = '
		SELECT *
		FROM usr
		WHERE usr_email = :usr
	';
    $pdoStatement = $pdo->prepare($checkUser);
    $pdoStatement->bindValue(':usr', $userEmail, PDO::PARAM_STR);

    // J'exécute
    if ($pdoStatement->execute()) {
        if ($pdoStatement->rowCount() > 0) {
            // Je récupère le mot de passe
            $res = $pdoStatement->fetch();
            $passwordHashed = $res['usr_password'];
            $userRole = $res['usr_role'];

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