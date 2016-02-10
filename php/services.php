<?php 

//clef Google de David
$myAPIKey = 'AIzaSyCH89EKdimLeM7wXrAfhbCvwOU6VBQbaYc';
$allPlaces = array();

//Fonction permettant de recuperer les coordonnées GPS à partir d'une adresse complète soumise au servce de Google Maps
function getGPSCoords($theAddress) {
    global $myAPIKey;
    //$formattedAddress = urlencode($theAddress); //Besoin d'encode l'adresse au format url?
    $formattedAddress = $theAddress;

    //print_r($formattedAddress);

    $requestLink = "https://maps.googleapis.com/maps/api/geocode/json?address={$formattedAddress}&key={$myAPIKey}"; // lien de l'api google dans lequel sont soumis l'adresse formatée et la clef d'api.
    $theAnswer = file_get_contents($requestLink); // recupere le resultat de la requete au service.
    $gpsCoords = json_decode($theAnswer, TRUE)['results'][0]['geometry']['location']; //Decode la reponse json, qui devient alors un tableau multidimensionnel.
    $googleCoords = "lat:{$gpsCoords['lat']}, lng:{$gpsCoords['lng']}"; // format la reponse pour etre insérée dans un marqueur google maps.
    //print_r($googleCoords);
    //return json_encode($gpsCoords); //renvoit les coordonnées directement formatées.
    return $gpsCoords; //renvoit les coords non formatées.
}


//Execute la fonction getGPSCoords sur un tableau d'adresses et renvoit un tableau de resultats.
function getGPSCoordsArray($theAddresses) {
    $results = array();
    //print_r($theAddresses);
    foreach($theAddresses as $location) {
        //print_r($location);
        $results[] = getGPSCoords($location);
    }
    //print_r(json_encode($results));
    return json_encode($results);
}

//implementation du service Places de google.
function getPlaces($searchedPlace, $placeType, $saveArray = false) {
    global $myAPIKey;
    $requestLink = "https://maps.googleapis.com/maps/api/place/textsearch/json?query={$searchedPlace}&type={$placeType}&key={$myAPIKey}";
    $theAnswer = file_get_contents($requestLink); // recupere le resultat de la requete au service.

    //echo $requestLink;
    //var_dump(json_decode($theAnswer));
    $results = json_decode($theAnswer, TRUE);
    $pageHasNextToken = $results['next_page_token'];
    var_dump($results);
    $gpsCoords = array();
    //var_dump($results);
    global $allPlaces;
    
    storePlaceInArray($results);
    
    if ($pageHasNextToken) {
        getPlacesWithToken($results['next_page_token']);
    }
    
    
    //print_r($allPlaces);
    file_put_contents('../data/places.json', json_encode($allPlaces));
}

function getPlacesWithToken($token) {
    global $myAPIKey;
    $requestLink = "https://maps.googleapis.com/maps/api/place/textsearch/json?pagetoken={$token}&key={$myAPIKey}";
    $theAnswer = file_get_contents($requestLink); // recupere le resultat de la requete au service.

    //echo $requestLink;
    //var_dump(json_decode($theAnswer));
    $results = json_decode($theAnswer, TRUE);
    $pageHasNextToken = isset($results['next_page_token']);
    global $allPlaces;
    
    storePlaceInArray($results);
    
    if ($pageHasNextToken) {
        getPlacesWithToken($results['next_page_token']);
    }
}


function storePlaceInArray($places) {
    global $allPlaces;

    foreach($places['results'] as $result) {
        $placeObj = array('id' => $result['id'], 
                          'name' => $result['name'], 
                          'rating' => isset($result['rating']) ? $result['rating'] : '', 
                          'photoRef' => isset($result['photos'][0]['photo_reference']) ? $result['photos'][0]['photo_reference'] : '', 
                          'place_id' => $result['place_id'], 
                          'types' => $result['types'], 
                          'location' => $result['geometry']['location'], 
                          'formatted_address' => $result['formatted_address']);
        $allPlaces[] = $placeObj;
    }
}



?> <?php // echo getGPSCoords($_GET['address']); ?> <?php // var_dump($_POST); ?> <?php 
//depending on a parameter, page executes a specific fonction:
//first post param = service desired, second post, an array

if (isset($_POST['service'])) {
    switch ($_POST['service']) {
        case 'gpsCoords':
            echo getGPSCoordsArray($_POST['params']); //print la reponse en fonction des adresses soumises en post.
            break;
        case 'places':
            echo getPlaces($_POST['params'][0], $_POST['params'][1], $_POST['params'][2]); //post[param][0] = query, [1] = type
            break;

        default:
            #code...
            break;
    }
} else {
    //echo 'nothing to show here';
}
?>