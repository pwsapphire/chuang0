<?php 
//Fonction permettant de recuperer les coordonnées GPS à partir d'une adresse complète soumise au servce de Google Maps
function getGPSCoords($theAddress) {
    $myAPIKey = 'AIzaSyCH89EKdimLeM7wXrAfhbCvwOU6VBQbaYc'; //clef Google de David
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

?> <?php //echo getGPSCoords($_GET['address']); ?> <?php //var_dump($_POST);
echo getGPSCoordsArray($_POST['addresses']); //print la reponse en fonction des adresses soumises en post.
?>