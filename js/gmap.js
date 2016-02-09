var fakeMarkers = [];
var goodMarkers = [];

//tableaux qui contiendront les adresses respectives aux type d'etablissement qu'ils representent ?.
var restaurants = [];
var bars = [];
var cinemas = [];


//Permet de créer des marqueurs google aleatoires dans une zone specifique.
//C'est une fonction utilisée a des fins de test lorsque nous n'avions pas de données.
//Dans notre cas, dans les environs du luxembourg.
//Ces marqueurs sont inseres dans la variable fakeMarkers.
function createFakeMarkers() {
    for (var index = 0; index < 10; index++) {
        var latitude = Math.random() * (50 - 49) + 49;
        var longitude = Math.random() * (7 - 5) + 5;
        fakeMarkers.push({ lat: latitude, lng: longitude });
    }
}



//Insere le resultat de la fonction fetchDataForServiceWithParams dans le tableau goodMarkers.
function addToMarkerList(jsonAnswer) {
    console.log('going to fill markers list');
   /* for (var coords in jsonAnswer) {
        console.log(coords);
        goodMarkers.push(coords);
    }*/
    goodMarkers = jsonAnswer;
}


//Récupere les données d'un service choisit avec des parametres.
function fetchDataForServiceWithParams(params, mapDiv, serviceWanted) {
    $.ajax({
        url: 'https://localhost:85/Yelp/php/services.php',
        data: {'service':serviceWanted,
               'params[]':params},
        method: "POST",
        dataType: "json",
        success: function (resp) {
            addToMarkerList(resp);
        },
        error: function(e){
          console.log(e.responseText);  
        },
        complete: function () {
            drawMarkers(mapDiv);
        }
    });
}

//Place les marqueurs sur la map spécifiée en parametre de fonction
function drawMarkers(theMap) {
    var theMarkersToDraw = goodMarkers;


    var theMap = new google.maps.Map(document.getElementById(theMap), {
        center: { lat: 49.501413, lng: 5.951193 },
        scrollwheel: true,
        zoom: 6
    });

    for (var gpsCoords in theMarkersToDraw) {
        new google.maps.Marker({
            position: theMarkersToDraw[gpsCoords],
            map: theMap,
            title: 'Test_' + theMarkersToDraw[gpsCoords],
        });
    }
}


function initGmap() {
    //createFakeMarkers();
    
    var testAddress = [encodeURIComponent("69, rue du clopp Rodange Luxembourg"),
        encodeURIComponent("7, Avenue du rock n' roll L-4361 Esch"),
        encodeURIComponent("86. rue jean mercatoris l-7237 helmsange luxembourg"),
        encodeURIComponent("9 avenue des haut fourneaux belval luxembourg"),
        encodeURIComponent("14, avenue du Rock 'n' roll L-4361 Esch-sur-Alzette"),
        encodeURIComponent("12 Place Chevert, 55100 Verdun, France"),
        encodeURIComponent("12 AVENUE DU ROCK'N'ROLL L-4361 ESCH-SUR-ALZETTE"),
        encodeURIComponent("132 ROUTE DE BASCHARAGE L-4513 NIEDERKORN")];
        
    //utilisation du service Maps de google:
    fetchDataForServiceWithParams(testAddress, 'gMap', 'gpsCoords');
    
    //utilisation du service Places de google:
    fetchDataForServiceWithParams(testAddress, 'gMapPlaces', 'places');
}