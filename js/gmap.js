var fakeMarkers = [];
var goodMarkers = [];

function createFakeMarkers() {
    for (var index = 0; index < 10; index++) {
        var latitude = Math.random() * (50 - 49) + 49;
        var longitude = Math.random() * (7 - 5) + 5;
        fakeMarkers.push({ lat: latitude, lng: longitude });
    }
}

function fetchGPSCoords(theUrlParam) {
    $.ajax({
        url: 'https://localhost:85/Yelp/php/backend.php',
        data: "address=" + theUrlParam,
        method: "GET",
        dataType: "json",
        success: function (resp) {
            console.log(resp);
            goodMarkers.push(resp);
            coordsFound = true;
        },
        complete: function(){
            drawMarkers();
        }
    });
}


function drawMarkers() {
    theMarkersToDraw = goodMarkers;
    

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
    
    var testAddress = encodeURIComponent("69, rue du clopp Rodange Luxembourg");

    fetchGPSCoords(testAddress);
}