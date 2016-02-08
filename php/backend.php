<?php 
/*Fonction permettant de recuperer les coordonnées GPS à partir d'une adresse complète soumise au servce de Google Maps*/

function getGPSCoords($theAddress) {
    $myAPIKey = 'AIzaSyCH89EKdimLeM7wXrAfhbCvwOU6VBQbaYc';
    //$formattedAddress = urlencode($theAddress);
    $formattedAddress = $theAddress;
    
    //print_r($formattedAddress);
    
    $requestLink = "https://maps.googleapis.com/maps/api/geocode/json?address={$formattedAddress}&key={$myAPIKey}";
    $theAnswer = file_get_contents($requestLink);
    $gpsCoords = json_decode($theAnswer,TRUE)['results'][0]['geometry']['location'];
    $googleCoords = "lat:{$gpsCoords['lat']}, lng:{$gpsCoords['lng']}";
    //print_r($googleCoords);
    //return json_encode($gpsCoords);
    return $gpsCoords;
}

function getGPSCoordsArray($theAddresses) {
    $results = array();
    //print_r($theAddresses);
    foreach ($theAddresses as $location) {
        //print_r($location);
        $results[] = getGPSCoords($location);
    }
    //print_r(json_encode($results));
    return json_encode($results);
}

?>
<?php //echo getGPSCoords($_GET['address']); ?>
<?php //var_dump($_POST);
     echo getGPSCoordsArray($_POST['addresses']);
?>