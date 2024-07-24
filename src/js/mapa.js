if(document.querySelector("#map")) {

    const lat = -33.4020843338133;
    const lng = -70.57244966583121;
    const zoom = 13;

    // Define el objeto map
    const map = L.map('map').setView([lat, lng], zoom);

    // Añade la capa de mosaico de OpenStreetMap
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    // Añade un marcador al mapa
    L.marker([lat, lng]).addTo(map)
        .bindPopup(`
            <h2 class="mapa__heading">DevWebCamp</h2>
            <p class="mapa__texto">Parque Araucano Las Condes</p>
        `)
        .openPopup();
}
