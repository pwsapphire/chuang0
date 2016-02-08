var fakeMarkers = [];

function createFakeMarkers() {
    for (var index = 0; index < 10; index++) {
        var latitude = Math.random() * (50-49) + 49;
        var longitude = Math.random() * (7-5) + 5;
        fakeMarkers.push({ lat: latitude, lng: longitude });
    }
}


function initGmap() {
    createFakeMarkers();
    var theMap = new google.maps.Map(document.getElementById('gMap'), {
        center: { lat: 49.501413, lng: 5.951193 },
        scrollwheel: true,
        zoom: 6
    });

    for (var gpsCoords in fakeMarkers) {
        new google.maps.Marker({
            position: fakeMarkers[gpsCoords],
            map: theMap,
            title: 'Test_' + fakeMarkers[gpsCoords],
        });
    }
}