(function() {
    const ponentesInput = document.querySelector('#ponentes');

    if(ponentesInput) {
        let ponentes = [];
        let ponentesFiltrados = [];

        const listadoPonentes = document.querySelector('#listado-ponentes');
        const ponenteHidden = document.querySelector('[name="ponente_id"]');

        obtenerPonentes();
        ponentesInput.addEventListener("input", buscarPonentes);

        if(ponenteHidden.value) {
            (async () => {
                const ponente = await obtenerPonente(ponenteHidden.value);

                const { nombre, apellido } = ponente;

                // Insertar en el HTML
                const ponenteDOM = document.createElement("LI");
                ponenteDOM.classList.add("listado-ponentes__ponente", "listado-ponentes__ponente--seleccionado");
                ponenteDOM.textContent = `${nombre} ${apellido}`;

                // Inyectar en el HTML
                listadoPonentes.appendChild(ponenteDOM);
            })();
        }
        
        async function obtenerPonentes() {
            const url = `/api/ponentes`;

            const respuesta = await fetch(url);
            const resultado = await respuesta.json();

            //console.log(resultado);
            formatearPonentes(resultado);
        }

        async function obtenerPonente(id) {
            const url = `/api/ponente?id=${id}`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();

            return resultado;
        }

        function formatearPonentes(arrayPonentes = []) {
            ponentes = arrayPonentes.map(ponente => {
                return {
                    nombre: `${ponente.nombre.trim()} ${ponente.apellido.trim()}`,
                    id: ponente.id
                }
            })

            //console.log(ponentes) 
        }

        function buscarPonentes(evento) {
            const busqueda = evento.target.value;
            //console.log(evento.target.value);

            if(busqueda.length > 3) {

                // Normalizar la búsqueda y eliminar las marcas diacríticas
                const busquedaNormalizada = busqueda.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
                const expresion = new RegExp(busquedaNormalizada, 'i');

                ponentesFiltrados = ponentes.filter(ponente => {
                    const nombreNormalizado = ponente.nombre.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
                    if(nombreNormalizado.search(expresion) !== -1) {
                        return ponente;
                    }

                    //console.log(ponentesFiltrados);
                })
            } else {
                ponentesFiltrados = [];
            }

            mostrarPonentes();
        }

        function mostrarPonentes() {

            //Mala solucion
            //listadoPonentes.innerHTML = '';

            while(listadoPonentes.firstChild) {
                listadoPonentes.removeChild(listadoPonentes.firstChild);
            }



            if(ponentesFiltrados.length > 0) {
                ponentesFiltrados.forEach(ponente => {
                    const ponenteHTML = document.createElement('LI');
                    ponenteHTML.classList.add('listado-ponentes__ponente');
                    ponenteHTML.textContent = ponente.nombre;
                    ponenteHTML.dataset.ponenteId = ponente.id;

                    ponenteHTML.onclick = seleccionarPonente;

                    // Añadir al DOM
                    listadoPonentes.appendChild(ponenteHTML);
                })
            } else {
                if(ponentesInput.value.length >=3) {
                    const noEncontrado = document.createElement('P');
                    noEncontrado.classList.add('listado-ponentes__no-encontrado');
                    noEncontrado.textContent = 'No hay resultados para tu búsqueda';
                    listadoPonentes.appendChild(noEncontrado);
                }
                ponenteHidden.value = "";           //IMPORTANTE
            }
        }

        function seleccionarPonente(evento) {

            // Seleccionar el ponente
            const ponente = evento.target;

            // Deseleccionar la clase previa
            const ponentePrevio = document.querySelector('.listado-ponentes__ponente--seleccionado');
            if(ponentePrevio) {
                ponentePrevio.classList.remove("listado-ponentes__ponente--seleccionado");
            }

            // Añadir la clase de seleccionado
            ponente.classList.add('listado-ponentes__ponente--seleccionado');

            ponenteHidden.value = ponente.dataset.ponenteId;
        }
    }
})();