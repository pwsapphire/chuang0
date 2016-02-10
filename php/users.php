<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <pre>
            <?php
           /* */
            // Require connexion DB
            require 'config.php';
            require 'services.php';
if(!empty($_SESSION)){
            // je vérifie que le user est admin
                $checkRole = ' 
            SELECT usr_email, role_rol_id
            FROM usr
            WHERE usr_email = :email AND role_rol_id=2
        ';
        //exemple: $_SESSION['sess_login'] = maghnia.dib.pro@gmail.com
        $pdoStatement = $pdo->prepare($checkRole);
        $pdoStatement->bindValue(':email', $_SESSION['sess_login'], PDO::PARAM_STR);
        
        if ($pdoStatement->execute()
            && $pdoStatement->rowCount() > 0) 
        { $List = $pdoStatement->fetchAll();

          // Si un formulaire a été soumis
              if (!empty($_POST)) {
                print_r($_POST);
                // Récupération et traitement des variables du formulaire d'ajout/
                $usr_id = isset($_POST['usr_id']) ? intval(trim($_POST['usr_id'])) : 0;
                $usr_email = isset($_POST['usr_email']) ? trim($_POST['usr_email']) : '';
                $usr_password = isset($_POST['usr_password']) ? trim($_POST['usr_password']) : '';
                $role_rol_id = isset($_POST['role_rol_id']) ? trim($_POST['role_rol_id']) : '';
                

                // si l'id dans le formulaire est > 0 => lieu existant => modification
                if ($usr_id > 0) {
                    // J'écris ma requête dans une variable
                    $updateSQL = '
                            UPDATE usr
                            SET
                              usr_email = :email,
                              usr_password = :password,
                              role_rol_id = :role,
                             WHERE usr_id= :id';
                    // Je prépare ma requête
                    $pdoStatement = $pdo->prepare($updateSQL);
                    // Je bind toutes les variables de requête
                    $pdoStatement->bindValue(':email', $usr_email);
                    $pdoStatement->bindValue(':password', $usr_password);
                    $pdoStatement->bindValue(':role', $role_rol_id);
                    
                   
                }
                // sinon Ajout 
                else {

                    //J'écris ma requête dans une variable

                     $insertSQL = '
                     INSERT INTO usr ( usr_email , usr_password, role_rol_id, usr_date_of_creation)
                                VALUES (:email, :password, :role, NOW())
                                ';

                     // Je prépare ma requête
                    $pdoStatement = $pdo->prepare($insertSQL);
                    // Je bind toutes les variables de requête
                    $pdoStatement->bindValue(':email', $usr_email);
                    $pdoStatement->bindValue(':password', $usr_password);
                    $pdoStatement->bindValue(':role', $role_rol_id);
                    

                } 
                    // J'exécute la requête, (quelle soit insert ou update)
                if ($pdoStatement->execute()) {
                   // Redirection après modif
                 if ($usr_id > 0) {
                    
                   header('Location: '.ABSOLUTE_URL.'users.php?id=' . $usr_id);
                    exit;
                }
                // Redirection après ajout
        else {
            //On va d'abord récupérer l'ID créé
            $usr_id = $pdo->lastInsertId();
            header('Location: ?id='.$usr_id);
            exit;
        }
    }
}
// J'initialise les variables affichés (echo) dans le form pour éviter les "NOTICE"
            $currentId = 0;
            $usr_email='';
            $usr_password='';
             $role_rol_id = 0;
              


//je selectionne tous les lieux de la table location
// J'initialise ma variable de retour
    $usrList = array();
    
    $sql = '
        SELECT usr_id, usr_email
        FROM usr
    ';
    $pdoStatement = $pdo->query($sql);
    if ($pdoStatement && $pdoStatement->rowCount() > 0) {
        $usrList = $pdoStatement->fetchAll();
        
    };
            
           // Si l'id est passé en paramètre de l'URL : "users.php?id=54" => $_GET['id'] a pour valeur 54
            if (isset($_GET['id'])) {
                // Je m'assure que la valeur est un integer
                $currentId = intval($_GET['id']);
                // J'écris ma requête dans une variable
                $sql = ' 
                            SELECT
                               usr_email , 
                               usr_password, 
                               role_rol_id, 
                               usr_date_of_creation
                              FROM
                                usr
                            WHERE usr_id=  :usr_id
                            LIMIT 1 
                            ';

               $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->bindValue(':usr_id', $currentId, PDO::PARAM_INT);
    if ($pdoStatement->execute()) {
        $resList = $pdoStatement->fetch();
        $usr_email = $resList['usr_email'];
        $usr_password = $resList['usr_password'];
        $role_rol_id = $resList['role_rol_id'];
         $usr_date_of_creation = $resList['usr_date_of_creation'];
         
    }
}
?>
        <section class="subHeader">
        <h1>Gestion des Users</h1>
                <!-- je mets ce formulaire en method="get" car la donnée n'est pas à sécuriser
        et car on veut voir ?id=ID dans l'URL de la page pour la modification -->
        <form action="" method="get">
            <select name="id">
            <option value="0">ajouter un user via email</option>
                <!-- je parcours les lieux pour remplir le menu déroulant des lieux -->
                <?php foreach ($usrList as $curUser) : ?>
                <option value="<?php echo $curUser['usr_id']; ?>"<?php echo $currentId == $curUser['usr_id'] ? ' selected="selected"' : ''; ?>><?php echo $curUser['usr_email']; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="OK"/>
        </form>
        </section>
    <form action="" method="post">
        <fieldset>
                <input type="hidden" name="usr_id" value="<?php echo $currentId; ?>" />
                <table>
                    <tr>
                        <td>Password :&nbsp;</td>
                        <td><input type="text" name="usr_password" value="<?php echo $usr_password; ?>"/></td>
                    </tr>
                    <tr>
                        <td>Rôle :&nbsp;</td>
                        <td><input type="text" name="role_rol_id" value="<?php echo $role_rol_id; ?>"/></td>
                    </tr>
                    
                    <tr>
                <td></td>
                <td><input type="submit" value="Valider"/></td>
            </tr>   
            </table>
        </fieldset>
    </form> 
<?php

}

}
else echo "vous devez vous logger .";
?>
    </body>
</html>



