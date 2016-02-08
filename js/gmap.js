var fakeMarkers = [];
var goodMarkers = [];

function createFakeMarkers() {
    for (var index = 0; index < 10; index++) {
        var latitude = Math.random() * (50 - 49) + 49;
        var longitude = Math.random() * (7 - 5) + 5;
        fakeMarkers.push({ lat: latitude, lng: longitude });
    }
}

function addToMarkerList(jsonAnswer) {
    console.log('going to fill markers list');
   /* for (var coords in jsonAnswer) {
        console.log(coords);
        goodMarkers.push(coords);
    }*/
    goodMarkers = jsonAnswer;
}

function fetchGPSCoordsForAddresses(addressesArray) {
    $.ajax({
        url: 'https://localhost:85/Yelp/php/backend.php',
        data: {'addresses[]':addressesArray},
        method: "POST",
        dataType: "json",
        success: function (resp) {
            addToMarkerList(resp);
        },
        error: function(e){
          console.log(e.responseText);  
        },
        complete: function () {
            drawMarkers();
        }
    });
}


function drawMarkers() {
    var theMarkersToDraw = goodMarkers;


    var theMap = new google.maps.Map(document.getElementById('gMap'), {
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

    fetchGPSCoordsForAddresses(testAddress);
}