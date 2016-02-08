var fakeMarkers = [];

function createFakeMarkers() {
    for (var index = 0; index < 5; index++) {
        var latitude = Math.random() * 90 - 90;
        var longitude = Math.random() * 360 - 180;
        fakeMarkers.push({ lat: latitude, lng: longitude });
    }
}


function initGmap() {
    createFakeMarkers();
    var theMap = new google.maps.Map(document.getElementById('gMap'), {
        center: { lat: -34.397, lng: 150.644 },
        scrollwheel: true,
        zoom: 8
    });

    for (var gpsCoords in fakeMarkers) {
        new google.maps.Marker({
            position: fakeMarkers[gpsCoords],
            map: theMap,
            title: 'Test_' + fakeMarkers[gpsCoords],
        });
    }
}