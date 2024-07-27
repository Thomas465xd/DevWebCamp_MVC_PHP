import Swal from "sweetalert2";

(function() {
    let eventos = [];

    const resumen = document.querySelector('#registro-resumen');

    if(resumen) {

        const eventosBoton = document.querySelectorAll('.evento__agregar');
        eventosBoton.forEach(boton => boton.addEventListener('click', seleccionarEvento));
    
        const formularioRegistro = document.querySelector('#registro');
        formularioRegistro.addEventListener('submit', submitForm);

        function seleccionarEvento(evento) {
    
            
            if(eventos.length < 5) {
                
                const { target } = evento;
        
                // Deshabilitar el evento 
                target.disabled = true;
        
                eventos = [...eventos, {
                    id: target.dataset.id,
                    titulo: target.parentElement.querySelector('.evento__nombre').textContent.trim()
                }]
    
                mostrarEventos();
            } else {
                Swal.fire({
                    title: '¡Ya no puedes agregar más eventos!',
                    text: 'Solo puedes agregar hasta 5 eventos por registro',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                })
            }
    
    
            //console.log(eventos);
        }
    
        function mostrarEventos() {
    
            // Limpiar el HTML
            limpiarEventos();
            
            if(eventos.length > 0) {
                eventos.forEach( evento => {
                    const eventoDOM = document.createElement("DIV")
                    eventoDOM.classList.add('registro__evento');
                    
                    const titulo = document.createElement('H3');
                    titulo.classList.add('registro__nombre');
                    titulo.textContent = evento.titulo;
                    
                    const botonEliminar = document.createElement("BUTTON");
                    botonEliminar.classList.add('registro__eliminar');
                    botonEliminar.innerHTML = `<i class="fa-solid fa-trash"></i>`;
                    botonEliminar.onclick = () => eliminarEvento(evento.id);
                    
                    // Renderizar en el HTML
                    eventoDOM.appendChild(titulo);
                    eventoDOM.appendChild(botonEliminar);
                    resumen.appendChild(eventoDOM);
                })
            }
        }
    
        function eliminarEvento(id) {
            //console.log(id)
            eventos = eventos.filter( evento => evento.id !== id );
            const botonAgregar = document.querySelector(`[data-id="${id}"]`);
            botonAgregar.disabled = false;
            mostrarEventos();
        }
    
        function limpiarEventos() {
            while(resumen.firstChild) {
                resumen.removeChild(resumen.firstChild);
            }
        }

        function submitForm(evento) {
            evento.preventDefault();
            //console.log(submit);

            // Obtener el Regalo
            const regaloId = document.querySelector('#regalo').value;
            //console.log(regaloId);

            const eventosId = eventos.map(evento => evento.id);
            //console.log(eventosId)

            if(eventosId.length === 0 || regaloId === '0') {
                Swal.fire({
                    title: 'Error',
                    text: 'Debes seleccionar un regalo y agregar al menos un evento',
                    icon: 'error',
                    confirmButtonText: 'OK'
                })
                return;
            }

            
        }
    }
})();