(function() {
    const horas = document.querySelector("#horas");

    if (horas) {
        const categoria = document.querySelector('[name="categoria_id"]');
        const dias = document.querySelectorAll('[name="dia"]');
        const inputHiddenDia = document.querySelector('[name="dia_id"]');
        const inputHiddenHora = document.querySelector('[name="hora_id"]');

        
        categoria.addEventListener("change", terminoBusqueda);
        dias.forEach(dia => dia.addEventListener("change", terminoBusqueda));
        
        let busqueda = {
            categoria_id: +categoria.value || '',
            dia: +inputHiddenDia.value || ''
        }

        // Verifica que ambos valores de búsqueda estén completos
        if (!Object.values(busqueda).includes('')) {

            async function iniciarApp() {
                //console.log("Contienen Datos");
                await busquedaEventos();
    
                const id = inputHiddenHora.value;
    
                // Resaltar la hora actual
                const horaSeleccionada = document.querySelector(`[data-hora-id="${id}"]`);
    
                horaSeleccionada.classList.remove("horas__hora--deshabilitada");
                horaSeleccionada.classList.add("horas__hora--seleccionada");
            }

            iniciarApp();
        }

        function terminoBusqueda(evento) {
            busqueda[evento.target.name] = evento.target.value;

            // Reiniciar campos ocultos y el selector de hjoras
            inputHiddenHora.value = "";
            inputHiddenDia.value = "";

            // Deseleccionar la hora previa, si hay un nuevo click
            const horaPrevia = document.querySelector(".horas__hora--seleccionada");

            if (horaPrevia) {
                horaPrevia.classList.remove("horas__hora--seleccionada");
            }

            // Verifica que ambos valores de búsqueda estén completos
            if (Object.values(busqueda).includes('')) {
                //console.log("Faltan datos");
                return;
            }

            //console.log(busqueda);

            busquedaEventos();
        }

        async function busquedaEventos() {
            const { dia, categoria_id } = busqueda;
            const url = `/api/eventos-horario?dia_id=${dia}&categoria_id=${categoria_id}`;

            //console.log(url);

            try {
                const resultado = await fetch(url);
                const eventos = await resultado.json();

                //console.log(eventos);

                obtenerHorasDisponibles(eventos);
            } catch (error) {
                console.error('Error al obtener eventos:', error);
            }
        }

        function obtenerHorasDisponibles(eventos) {

            // Reiniciar las horas
            const listadoHoras = document.querySelectorAll("#horas li");
            listadoHoras.forEach(li => li.classList.add("horas__hora--deshabilitada"));


            // Comprobar eventos ya tomados
            const horasTomadas = eventos.map(evento => evento.hora_id);
            const listadoHorasArray = Array.from(listadoHoras);

            // habilitar solo las horas disponibles
            const resultado = listadoHorasArray.filter(li => !horasTomadas.includes(li.dataset.horaId));
            resultado.forEach(li => li.classList.remove("horas__hora--deshabilitada"));

            //console.log(resultado);
            //console.log(listadoHoras)
            //console.log(horasTomadas);

            const horasDisponibles = document.querySelectorAll("#horas li:not(.horas__hora--deshabilitada)");

            const horasNoDisponibles = document.querySelectorAll('.horas__hora--deshabilitada');
            Array.from(horasNoDisponibles).map(hora => {
                hora.removeEventListener('click', seleccionarHora);
            })  

            horasDisponibles.forEach(hora => hora.addEventListener("click", seleccionarHora));
        }

        function seleccionarHora(evento) {
            // Deseleccionar la hora previa, si hay un nuevo click
            const horaPrevia = document.querySelector(".horas__hora--seleccionada");
            if (horaPrevia) {
                horaPrevia.classList.remove("horas__hora--seleccionada");
            }

            // Agregar clase de seleccionado
            evento.target.classList.add("horas__hora--seleccionada");

            inputHiddenHora.value = evento.target.dataset.horaId;
            //console.log(evento.target.dataset.horaId);

            // Llenar el campo oculto de día
            inputHiddenDia.value = document.querySelector('[name="dia"]:checked').value;
        }
    }
})();
