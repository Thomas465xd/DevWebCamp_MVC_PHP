(function() {
    const grafica = document.querySelector("#regalos-grafica");
    if (grafica) {

        obtenerDatos();

        async function obtenerDatos() {
            const url = '/api/regalos';
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();

            const ctx = grafica.getContext('2d');
        
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: resultado.map(regalo => regalo.nombre),
                    datasets: [{
                        label: '',
                        data: resultado.map(regalo => regalo.total),
                        borderWidth: 5,
                        backgroundColor: [
                            '#ea580c',
                            '#84cc16',
                            '#22d3ee',
                            '#a855f7',
                            '#ef4444',
                            '#14b8a6',
                            '#db2777',
                            '#e11d48',
                            '#7e22ce'
                        ],
                        borderColor: [
                            '#c64d0b', // Más oscuro que #ea580c
                            '#6fae14', // Más oscuro que #84cc16
                            '#1bb5c9', // Más oscuro que #22d3ee
                            '#8e46d7', // Más oscuro que #a855f7
                            '#cc3939', // Más oscuro que #ef4444
                            '#119588', // Más oscuro que #14b8a6
                            '#b31e67', // Más oscuro que #db2777
                            '#be173d', // Más oscuro que #e11d48
                            '#691cb0'  // Más oscuro que #7e22ce
                        ],
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
        }

})();
