<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Personal</legend>

    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre</label>
        <input 
            type="text" 
            id="nombre" 
            name="nombre" 
            placeholder="Nombre Ponente"
            class="formulario__input"
            value="<?php echo $ponente->nombre ?? ""; ?>"
        >
    </div>

    <div class="formulario__campo">
        <label for="apellido" class="formulario__label">Apellido</label>
        <input 
            type="text" 
            id="apellido" 
            name="apellido" 
            placeholder="Apellido Ponente"
            class="formulario__input"
            value="<?php echo $ponente->apellido ?? ""; ?>"
        >
    </div>

    <div class="formulario__campo">
        <label for="ciudad" class="formulario__label">Ciudad</label>
        <input 
            type="text" 
            id="ciudad" 
            name="ciudad" 
            placeholder="Ciudad Ponente"
            class="formulario__input"
            value="<?php echo $ponente->ciudad ?? ""; ?>"
        >
    </div>

    <div class="formulario__campo">
        <label for="pais" class="formulario__label">País</label>
        <input 
            type="text" 
            id="pais" 
            name="pais" 
            placeholder="País Ponente"
            class="formulario__input"
            value="<?php echo $ponente->pais ?? ""; ?>"
        >
    </div>

    <div class="formulario__campo">
        <label for="imagen" class="formulario__label">Imagen</label>
        <input 
            type="file" 
            id="imagen" 
            name="imagen" 
            class="formulario__input formulario__input--file"
        >
    </div>

    <?php if(isset($ponente->imagen_actual) ) { ?>
        <p class="formulario__texto">Imagen Actual: </p>
        <div class="formulario__imagen">
            <picture>
                <source srcset="<?php echo $_ENV["HOST"] . '/img/speakers/' . $ponente->imagen_actual; ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV["HOST"] . '/img/speakers/' . $ponente->imagen_actual; ?>.png" type="image/png">
                <img src="<?php echo $_ENV["HOST"] . '/img/speakers/' . $ponente->imagen_actual; ?>.png" alt="Imagen Ponente">
            </picture>
        </div>

    <?php } ?>
</fieldset>

<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Extra</legend>

    <div class="formulario__campo">
        <label for="tags_input" class="formulario__label">Áreas de Experiencia (separadas por coma)</label>
        <input 
            type="text" 
            id="tags_input"  
            placeholder="Ej. Node.js, PHP, React.js, Laravel, UX / UI"
            class="formulario__input"
        >
    </div>

    <div id="tags" class="formulario__listado"></div>
    <input type="hidden" name="tags" id="tags_hidden" value="<?php echo $ponente->tags ?? ""; ?>">
</fieldset>

<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Redes Sociales</legend>

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-facebook-f"></i>
            </div>
            <input 
                type="text" 
                id="facebook" 
                name="redes[facebook]" 
                placeholder="URL Facebook"
                class="formulario__input--sociales"
                value="<?php echo $redes->facebook ?? ""; ?>"
            >
        </div>
    </div>

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-x-twitter"></i>
            </div>
            <input 
                type="text" 
                id="twitter" 
                name="redes[twitter]" 
                placeholder="URL Twitter"
                class="formulario__input--sociales"
                value="<?php echo $redes->twitter ?? ""; ?>"
            >
        </div>
    </div>

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-youtube"></i>
            </div>
            <input 
                type="text" 
                id="youtube" 
                name="redes[youtube]" 
                placeholder="URL YouTube"
                class="formulario__input--sociales"
                value="<?php echo $redes->youtube ?? ""; ?>"
            >
        </div>
    </div>

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-instagram"></i>
            </div>
            <input 
                type="text" 
                id="instagram" 
                name="redes[instagram]" 
                placeholder="URL Instagram"
                class="formulario__input--sociales"
                value="<?php echo $redes->instagram ?? ""; ?>"
            >
        </div>
    </div>

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-tiktok"></i>
            </div>
            <input 
                type="text" 
                id="tiktok"
                name="redes[tiktok]"
                placeholder="URL Tiktok"
                class="formulario__input--sociales"
                value="<?php echo $redes->tiktok ?? ""; ?>"
            >
        </div>
    </div>

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-whatsapp"></i>
            </div>
            <input 
                type="text" 
                id="whatsapp" 
                name="redes[whatsapp]" 
                placeholder="WhatsApp"
                class="formulario__input--sociales"
                value="<?php echo $redes->whatsapp ?? ""; ?>"
            >
        </div>
    </div>

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-linkedin-in"></i>
            </div>
            <input 
                type="text" 
                id="linkedin" 
                name="redes[linkedin]" 
                placeholder="URL LinkedIn"
                class="formulario__input--sociales"
                value="<?php echo $redes->linkedin ?? ""; ?>"
            >
        </div>
    </div>

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-github"></i>
            </div>
            <input 
                type="text" 
                id="github" 
                name="redes[github]" 
                placeholder="URL GitHub"
                class="formulario__input--sociales"
                value="<?php echo $redes->github ?? ""; ?>"
            >
        </div>
    </div>

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-codepen"></i>
            </div>
            <input 
                type="text" 
                id="codepen" 
                name="redes[codepen]" 
                placeholder="URL Codepen"
                class="formulario__input--sociales"
                value="<?php echo $redes->codepen ?? ""; ?>"
            >
        </div>
    </div>

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-dribbble"></i>
            </div>
            <input 
                type="text" 
                id="dribbble" 
                name="redes[dribbble]" 
                placeholder="URL Dribbble"
                class="formulario__input--sociales"
                value="<?php echo $redes->dribbble ?? ""; ?>"
            >
        </div>
    </div>
</fieldset>

