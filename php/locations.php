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
if (!empty($_SESSION)) {
    // je vérifie que le user est admin
    $checkRole = ' 
            SELECT usr_email, role_rol_id
            FROM usr
            WHERE usr_email = :email AND role_rol_id=2
        ';
    //exemple: $_SESSION['sess_login'] = maghnia.dib.pro@gmail.com
    $pdoStatement = $pdo->prepare($checkRole);
    $pdoStatement->bindValue(':email', $_SESSION['sess_login'], PDO::PARAM_STR);

    if ($pdoStatement->execute() && $pdoStatement->rowCount() > 0) {
        $List = $pdoStatement->fetchAll();

        // Si un formulaire a été soumis
        if (!empty($_POST)) {
            print_r($_POST);
            // Récupération et traitement des variables du formulaire d'ajout/
            $loc_id = isset($_POST['loc_id']) ? intval(trim($_POST['loc_id'])) : 0;
            $loc_name = isset($_POST['loc_name']) ? trim($_POST['loc_name']) : '';
            $loc_type = isset($_POST['loc_type']) ? trim($_POST['loc_type']) : '';
            $loc_adresse = isset($_POST['loc_adresse']) ? trim($_POST['loc_adresse']) : '';
            $loc_cp = isset($_POST['loc_cp']) ? trim($_POST['loc_cp']) : '';
            $loc_ville = isset($_POST['loc_ville']) ? trim($_POST['loc_ville']) : '';
            $loc_desc = isset($_POST['loc_desc']) ? trim($_POST['loc_desc']) : '';

            // si l'id dans le formulaire est > 0 => lieu existant => modification
            if ($loc_id > 0) {
                // J'écris ma requête dans une variable
                $updateSQL = '
                            UPDATE location
                            SET
                              loc_name = :name,
                              loc_type = :type,
                              loc_adresse = :adresse,
                              loc_cp= :cp,
                              loc_ville = :ville,
                              loc_description = :descr,
                              loc_gps_lat= :lat,
                              loc_gps_long= :lng
                            WHERE loc_id= :id';
                // Je prépare ma requête
                $pdoStatement = $pdo->prepare($updateSQL);
                // Je bind toutes les variables de requête
                $pdoStatement->bindValue(':name', $loc_name);
                $pdoStatement->bindValue(':type', $loc_type);
                $pdoStatement->bindValue(':adresse', $loc_adresse);
                $pdoStatement->bindValue(':cp', $loc_cp);
                $pdoStatement->bindValue(':ville', $loc_ville);
                $pdoStatement->bindValue(':descr', $loc_desc);
                $pdoStatement->bindValue(':lat', $loc_gps_lat);
                $pdoStatement->bindValue(':lng', $loc_gps_long);


            }
            // sinon Ajout 
            else {

                //appel fonction pour recuperer les coord GPS de l'adresse du lieu
                $adr_format = urlencode($loc_adresse.' '.$loc_cp.' '.$loc_ville);
                $tab_coords = getGPSCoords($adr_format);
                print_r($tab_coords);
                $loc_gps_lat = $tab_coords['lat'];
                $loc_gps_long = $tab_coords['lng'];
                //J'écris ma requête dans une variable

                $insertSQL = '
                     INSERT INTO location (loc_name , loc_type, loc_adresse, loc_cp, loc_ville, loc_description,loc_gps_lat,loc_gps_long)
                                VALUES (:name, :type, :adresse, :cp, :ville, :descr,:lat,:lng)
                                ';

                // Je prépare ma requête
                $pdoStatement = $pdo->prepare($insertSQL);
                // Je bind toutes les variables de requête
                $pdoStatement->bindValue(':name', $loc_name);
                $pdoStatement->bindValue(':type', $loc_type);
                $pdoStatement->bindValue(':adresse', $loc_adresse);
                $pdoStatement->bindValue(':cp', $loc_cp);
                $pdoStatement->bindValue(':ville', $loc_ville);
                $pdoStatement->bindValue(':descr', $loc_desc);
                $pdoStatement->bindValue(':lat', $loc_gps_lat);
                $pdoStatement->bindValue(':lng', $loc_gps_long);

            }
            // J'exécute la requête, (quelle soit insert ou update)
            if ($pdoStatement->execute()) {
                // Redirection après modif
                if ($loc_id > 0) {

                    header('Location: '.ABSOLUTE_URL.'locations.php?id='.$loc_id);
                    exit;
                }
                // Redirection après ajout
                else {
                    //On va d'abord récupérer l'ID créé
                    $loc_id = $pdo->lastInsertId();
                    header('Location: ?id='.$loc_id);
                    exit;
                }
            }
        }
    
// J'initialise les variables affichés (echo) dans le form pour éviter les "NOTICE"
            $currentId = 0;
            $adr_id = 0;
            $cp_id = 0;
             $ville_id = 0;
              $loc_id = 0;
             $loc_name =  '';
             $loc_type =  '';
              $loc_adresse =  '';
             $loc_cp =  '';
              $loc_ville =  '';
              $loc_desc = '';
              $loc_gps_lat =0.0;
              $loc_gps_long =0.0;


//je selectionne tous les lieux de la table location
// J'initialise ma variable de retour
    $locList = array();
    
    $sql = '
        SELECT loc_id, loc_name 
        FROM location
    ';
        $pdoStatement = $pdo->query($sql);
        if ($pdoStatement && $pdoStatement->rowCount() > 0) {
            $locList = $pdoStatement->fetchAll();
        };

        // Si l'id est passé en paramètre de l'URL : "locations.php?id=54" => $_GET['id'] a pour valeur 54
        if (isset($_GET['id'])) {
            // Je m'assure que la valeur est un integer
            $currentId = intval($_GET['id']);
            // J'écris ma requête dans une variable
            $sql = ' 
                            SELECT
                               loc_id,
                               loc_name,
                              loc_type,
                              loc_adresse,
                              loc_cp,
                              loc_ville,
                              loc_description
                              FROM
                                location
                            WHERE loc_id=  :loc_id
                            LIMIT 1 
                            ';

            $pdoStatement = $pdo->prepare($sql);
            $pdoStatement->bindValue(':loc_id', $currentId, PDO::PARAM_INT);
            if ($pdoStatement->execute()) {
                $resList = $pdoStatement->fetch();
                $loc_name = $resList['loc_name'];
                echo '<br/>name: '.$loc_name.'<br/>';
                $loc_type = $resList['loc_type'];
                $loc_adresse = $resList['loc_adresse'];
                $loc_cp = $resList['loc_cp'];
                echo '$loc_cp '.$loc_cp.'<br/>';
                $loc_ville = $resList['loc_ville'];
                $loc_desc = $resList['loc_description'];
            }
        }
        ?>
        <section class="subHeader">
        <h1>Gestion des Lieux</h1>
                <!-- je mets ce formulaire en method="get" car la donnée n'est pas à sécuriser
        et car on veut voir ?id=ID dans l'URL de la page pour la modification -->
        <form action="" method="get">
            <select name="id">
            <option value="0">ajouter un lieu</option>
                <!-- je parcours les lieux pour remplir le menu déroulant des lieux -->
                <?php foreach($locList as $curLoc): ?>
                <option value="<?php echo $curLoc['loc_id']; ?>"<?php echo $currentId == $curLoc['loc_id'] ? ' selected="selected"' : ''; ?>><?php echo $curLoc['loc_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="OK"/>
        </form>
        </section>
    <form action="" method="post">
        <fieldset>
                <input type="hidden" name="loc_id" value="<?php echo $currentId; ?>" />
                <table>
                    <tr>
                        <td>Nom :&nbsp;</td>
                        <td><input type="text" name="loc_name" value="<?php echo $loc_name; ?>"/></td>
                    </tr>
                    <tr>
                        <td>Type :&nbsp;</td>
                        <td><input type="text" name="loc_type" value="<?php echo $loc_type; ?>"/></td>
                    </tr>
                    <tr>
                        <td>Adresse :&nbsp;</td>
                        <td><input type="text" name="loc_adresse" value="<?php echo $loc_adresse; ?>"/></td>
                    </tr>
                    <tr>
                        <td>Code postal :&nbsp;</td>
                        <td><input type="text" name="loc_cp" value="<?php echo $loc_cp; ?>"/></td>
                    </tr>
                    <tr>
                        <td>Ville :&nbsp;</td>
                        <td><input type="text" name="loc_ville" value="<?php echo $loc_ville; ?>"/></td>
                    </tr>
                     <tr>
                        <td>Description :&nbsp;</td>
                        <td><textarea name="loc_desc"><?php echo $loc_desc; ?></textarea></td>
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

} else echo "vous devez vous logger .";
?>
    </body>
</html>