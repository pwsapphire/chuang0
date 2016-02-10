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