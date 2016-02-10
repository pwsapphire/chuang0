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
        print_r($List);

            // Si un formulaire a été soumis
          
            if (!empty($_POST)) {
                print_r($_POST);
                // Récupération et traitement des variables du formulaire d'ajout/
                $loc_id = isset($_POST['loc_id']) ? intval(trim($_POST['loc_id'])) : 0;
                $loc_name = isset($_POST['loc_name']) ? trim($_POST['loc_name']) : '';
                $loc_type = isset($_POST['loc_type']) ? trim($_POST['loc_type']) : '';
                $loc_adresse = isset($_POST['loc_adresse']) ? trim($_POST['loc_adresse']) : '';
                $loc_cp = isset($_POST['loc_cp']) ? intval(trim($_POST['loc_cp'])) : '';
                $loc_ville = isset($_POST['loc_ville']) ? trim($_POST['loc_ville']) : '';
                $loc_desc = isset($_POST['loc_desc']) ? intval(trim($_POST['loc_desc'])) : '';

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
                              loc_description = :descr
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
                    
                    // J'exécute la requête, et ça me renvoi true ou false
                    if ($pdoStatement->execute()) {
                        // Je redirige sur la même page
                        // Pas de formulaire soumis sur la page de redirection => pas de POST
                        header('Location: '.ABSOLUTE_URL.'gestion_des_lieux.php?id=' . $loc_id);
                        exit;
                    }
                }
                // sinon Ajout 
                else {
                    // J'écris ma requête dans une variable

                     $insertSQL = '
                     INSERT INTO location (loc_name , loc_type, loc_adresse, loc_cp, loc_ville, loc_description)
                                VALUES (:name, :type, :adresse, :cp, :ville, :descr)
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

                    
                    // J'exécute la requête, et ça me renvoi true ou false
                if ($pdoStatement->execute()) {
                    
                    $newId = $pdo->lastInsertId();
                    // Je redirige sur la même page, à laquelle j'ajoute l'id du lieu créé => modification
                    // Pas de formulaire soumis sur la page de redirection => pas de POST
                   header('Location: '.ABSOLUTE_URL.'gestion_des_lieux.php?id=' . $newId);
                    exit;
                }
                }
            }
// J'initialise mes variables pour l'affichage du formulaire/de la page
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
            
           // Si l'id est passé en paramètre de l'URL : "gestion_des_lieux.php?id=54" => $_GET['id'] a pour valeur 54
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
                            WHERE loc_id= ' . $currentId;

                // J'envoi ma requête à MySQL et je récupère le Statement
                $pdoStatement = $pdo->query($sql);
                // Si la requête a fonctionnée et qu'on a au moins une ligne de résultat
                if ($pdoStatement && $pdoStatement->rowCount() > 0) {
                    // Je "fetch" les données de la première ligne de résultat dans $resList
                    $resList = $pdoStatement->fetch();
                    // Je récupère toutes les valeurs que j'affecte dans les variables destinées à l'affichage du formulaire
                    // => ça me permet de pré-remplir le formulaire
                   $loc_name = $resList['loc_name'];
                    $loc_type = $resList['loc_type'];
                    $loc_adresse = $resList['loc_adresse'];
                    $loc_cp = $resList['loc_cp'];
                    $loc_ville = $resList['loc_ville'];
                    $loc_desc = $resList['loc_description'];

                }
            }
            

// Récupère toutes les adresses pour générer le menu déroulant des adresses
$sql = '
    
    SELECT loc_adresse FROM location
';
$pdoStatement = $pdo->query($sql);
if ($pdoStatement && $pdoStatement->rowCount() > 0) {
    $adresseList = $pdoStatement->fetchAll();
   
}

// Récupère tous les codes postaux pour générer le menu déroulant des cp
$sql = '
    
    SELECT loc_cp FROM location
';
$pdoStatement = $pdo->query($sql);
if ($pdoStatement && $pdoStatement->rowCount() > 0) {
    $cpList = $pdoStatement->fetchAll();
    
}

// Récupère toutes les villes pour générer le menu déroulant des villes
$sql = '
    
    SELECT loc_ville FROM location
';
$pdoStatement = $pdo->query($sql);
if ($pdoStatement && $pdoStatement->rowCount() > 0) {
    $villeList = $pdoStatement->fetchAll();
}
            ?>
        </pre>
        <form action="" method="post">
            <fieldset>
                <legend>Gestion des Lieux</legend>
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
                        <td><select name="adr_id">
                    <option value="">choisissez</option>
                    <?php foreach ($adresseList as $curAdresse) : ?>
                  <option value="<?php echo $curAdresse['loc_adresse']; ?>"<?php echo $adr_id == $curAdresse['loc_adresse'] ? ' selected="selected"' : ''; ?>><?php echo $curAdresse['loc_adresse']; ?></option>
                   <?php endforeach;
                    ?>
                   
                </select></td>
                    </tr>
                    <tr>
                        <td>Code postal :&nbsp;</td>
                        <td><select name="cp_id">
                    <option value="">choisissez</option>
                    <?php foreach ($cpList as $curCp) : ?>
                    <option value="<?php echo $curCp['loc_cp']; ?>"<?php echo $cp_id == $curCp['loc_cp'] ? ' selected="selected"' : ''; ?>><?php echo $curCp['loc_cp']; ?></option>
                    <?php endforeach; ?>
                </select></td>
                    </tr>
                    <tr>
                        <td>Ville :&nbsp;</td>
                        <td><select name="ville_id">
                    <option value="">choisissez</option>
                    <?php foreach ($villeList as $curVille) : ?>
                    <option value="<?php echo $curVille['loc_ville']; ?>"<?php echo $ville_id == $curVille['loc_ville'] ? ' selected="selected"' : ''; ?>><?php echo $curVille['loc_ville']; ?></option>
                    <?php endforeach; ?>
                </select></td>
                    </tr>
                    <tr>
                        <td>Description :&nbsp;</td>
                        <td><textarea name="loc_desc" value="<?php echo $loc_desc; ?>"/></textarea></td>
                    </tr>

                    
                    <tr>
                        <td></td>
                        <td><input type="submit" value="<?php
                            if ($currentId > 0) {
                                echo 'Modifier';
                            } else {
                                echo 'Ajouter';
                            }
                            ?>"/></td>
                    </tr>	
                </table>

            </fieldset>
        </form>
<?php
//appel fonction pour recuperer les coord GPS de l'adresse du lieu
                //$tab_coords=getGPSCoords($_POST['loc_adresse']);
               // print_r($tab_coords);
                //$loc_gps_lat=$tab_coords['lat'];
                //$loc_gps_lng=$tab_coords['lng'];
}
?>
    </body>
</html>

<?php 

//renvoit x locations a partir de l'id y.
function getLocations($idToGet, $howMuch = null) {

    //database pas encore operationnelle, j'utilise les données json contenues dans data/places.json
    $data = json_decode(file_get_contents('../data/places_First20.json'));
    //print_r($data);

    /*le fichier contient reelement 20 places, mais je n'en selectionne que 10
      idToGet est simulé. Ici juste un index dans un tableau*/
    $data = array_splice($data, $idToGet, isset($howMuch) ? $howMuch : 0);
    //print_r($data);

    return json_encode($data);
}


if (isset($_POST['service'])) {
    switch ($_POST['service']) {
        
        //return les 10 dernieres
        case 'lastTen':
            echo getLocations($_POST['params'][0], $_POST['params'][1]);
            break;
            //return celle avec id specific
        case 'specific':
            echo getLocations($_POST['params'][0]);
            break;

        default:
            #code...
            break;
    }
} else {
    echo 'nothing to show here';
}

?>