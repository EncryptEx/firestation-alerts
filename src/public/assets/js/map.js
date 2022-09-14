
// Script to load the map
function loadMap(lat, lng, elementId, style, zoom) {
    // Where you want to render the map.
    var element = document.getElementById(elementId);

    // Height has to be set. 
    element.style = style;

    // Create Leaflet map on map element.
    var map = L.map(element);

    // Add OSM tile layer to the Leaflet map.
    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Target's GPS coordinates.
    var target = L.latLng(lat, lng);

    // Set map's center to target with specified zoom.
    map.setView(target, zoom);

    // Place a marker on the same location.
    L.marker(target).addTo(map);
}
