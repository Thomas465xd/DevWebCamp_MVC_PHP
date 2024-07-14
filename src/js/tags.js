(function () {

    const tagsInput = document.querySelector('#tags_input');

    if(tagsInput) {

        const tagsDiv = document.querySelector("#tags");
        const tagsInputHidden = document.querySelector("[name=tags]");

        let tags = [];

        // Escuchar los cambios en el input
        tagsInput.addEventListener('keypress', guardarTag);

        function guardarTag(evento) {

            if(evento.keyCode === 44) {

                // Evitar que se agreguen tags repetidos y vacios
                if(evento.target.value.trim() === "" || evento.target.value < 1 || tags.includes(evento.target.value.toLowerCase())) {
                    evento.preventDefault();
                    evento.target.value = "";
                    return;
                }

                evento.preventDefault();

                tags = [...tags, evento.target.value.trim()];

                tagsInput.value = "";

                //console.log(tags)
                mostrarTags();
            }

            function mostrarTags() {
                tagsDiv.textContent = "";

                tags.forEach(tag => {
                    const etiqueta = document.createElement("LI");
                    etiqueta.classList.add("formulario__tag");
                    etiqueta.textContent  = tag;
                    etiqueta.onclick = eliminarTag;
                    tagsDiv.appendChild(etiqueta);
                })
            }

            function eliminarTag(evento) {
                evento.target.remove();

                tags = tags.filter(tag => tag !== evento.target.textContent);
                console.log(tags);
            }

            function actualizarInputHidden() {
                tagsInputHidden.value = tags.toString();
            }

        }
    }
})()