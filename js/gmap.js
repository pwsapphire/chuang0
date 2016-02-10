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


//function debug qui print data
function print(data){
    console.log(data);
}

//Récupere les données d'un service choisit avec des parametres.
function fetchDataForServiceWithParams(params, mapDiv, serviceWanted, onSuccesFunction, onCompleteFunction) {
    $.ajax({
        url: 'https://localhost:85/Yelp/php/services.php',
        data: {'service':serviceWanted,
               'params[]':params},
        method: "POST",
        dataType: "json",
        success: function (resp) {
            onSuccesFunction(resp);
            //addToMarkerList(resp);
        },
        error: function(e){
          console.log(e.responseText);  
        },
        complete: function () {
            onCompleteFunction(mapDiv);
            //drawMarkers(mapDiv);
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
        //console.log(theMarkersToDraw[gpsCoords]);
        new google.maps.Marker({
            position: theMarkersToDraw[gpsCoords],
            map: theMap,
            title: 'Test_' + theMarkersToDraw[gpsCoords],
        });
    }
}


//créé les vignettes pour simuler un slider
function createSlider(container, data){
    //console.log(data);
    var tagsToAdd = '';
    tagsToAdd += '<ul>'
    for (var index = 0; index < data.length; index++) {
        //genere le code a ajouté au container
        tagsToAdd += '<li class=\"sliderThumb\"><img src=\"img/fakeResto.jpg\" alt=\"' + data[index]['id'] + '\"><a href=\"#\">' + data[index]['name'] + '</a></li>';
    }
    tagsToAdd += '</ul>';
    //ajoute le code html generé une fois la boucle terminée.
    //console.log(tagsToAdd);
    $(container).append(tagsToAdd);
}

//select x number of locations based on first id via ajax call to locations.php
function selectLocations(theId, howMany){
    var params = [0, 10]; //select 10 items a partir de l'item 0.
    
    $.ajax({
        url: 'https://localhost:85/Yelp/php/locations.php',
        data: {'service':'lastTen', //differents services fournis
               'params[]':params},
        method: "POST",
        dataType: "json",
        error: function(e){
          console.log(e.responseText);  //si marche pas, il affiche la cause.
        },
        complete: function (res) {
            createSlider('#theSlider', res.responseJSON);
        }
    });
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
    //fetchDataForServiceWithParams(testAddress, 'gMap', 'gpsCoords', addToMarkerList, drawMarkers);
    
    //utilisation du service Places de google:
    var params = [encodeURIComponent('restaurant from luxemburg'),encodeURIComponent('food|bar'),true];
    //fetchDataForServiceWithParams(params, 'gMapPlaces', 'places', addToMarkerList, drawMarkers);
    
    //test de la recup de locations:
    selectLocations(0, 10);
}