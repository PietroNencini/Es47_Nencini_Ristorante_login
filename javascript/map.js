let maps = {};
function showMap(mapId, latit, longit, marker = true){  
    console.log(mapId);
    if(!maps[mapId]) {
        maps[mapId] = L.map(mapId);
    }
    maps[mapId].setView([latit, longit], 17);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 20,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(maps[mapId]);

    if(marker)
        L.marker([latit, longit]).addTo(maps[mapId]);
}

function moveToLocation(mapId, latit, longit) {
    maps[mapId].setView([latit, longit], 17);
}
