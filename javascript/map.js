const DEFAULT_ZOOM = 17

let maps = {};
let markerGroup = {};

//todo : Utilizzare al posto del PHP per prendere le coordinate
function getCoordinates(id_ristorante) {
    fetch("../php/scripts/get_coordinates.php?id_ristorante=" + id_ristorante, {
        method: GET,
    })
    .then(response => response.json())
    .then(() => {
        return 
    })
}

function showMap(mapId, latit, longit, marker = true, clickable = false){  
    console.log("ID mappa: " + mapId);
    if(!maps[mapId]) {
        maps[mapId] = {
            mapInstance: L.map(mapId),
            click: clickable
        };
        markerGroup[mapId] = L.layerGroup().addTo(maps[mapId].mapInstance);
    }
    maps[mapId].mapInstance.setView([latit, longit], DEFAULT_ZOOM);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 20,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(maps[mapId].mapInstance);

    if(marker)
        addMarker(mapId, latit, longit);

    if(maps[mapId].click) {
        maps[mapId].mapInstance.on("click", function(e) {
            manageMapClick(e, mapId)
        });    
    }
}

function moveToLocation(mapId, latit, longit) {
    maps[mapId].mapInstance.setView([latit, longit], DEFAULT_ZOOM);
}

function addMarker(mapId, latit, longit) {
    let marker = L.marker([latit, longit]); 
    markerGroup[mapId].addLayer(marker);
}

function manageMapClick(e, mapId) {
    var coords = e.latlng;
    let inputs = document.getElementsByClassName("latlng_input");
    markerGroup[mapId].clearLayers();
    let marker = L.marker([coords.lat, coords.lng]);
    markerGroup[mapId].addLayer(marker); 
    if(inputs.length >= 2) {
        inputs[0].value = coords.lat;
        inputs[1].value = coords.lng;
    } else  {
        console.log("ERRORE: Non ci sono abbastanza input, i valori non vengono assegnati");
    }
}
