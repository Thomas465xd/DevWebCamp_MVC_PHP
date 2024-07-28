<h2 class="pagina__heading"><?php echo $titulo; ?></h2>
<p class="pgaina__descripcion">Elige hasta 5 eventos para asistir de forma presencial</p>

<div class="eventos-registro">
    <main class="eventos-registro__listado">
        <h3 class="eventos-registro__heading--conferencias">&lt;Conferencias /&gt</h3>
        <p class="eventos-registro__fecha">Viernes 2 de Agosto</p>

        <div class="eventos-registro__grid">
            <?php foreach($eventos["conferencias_viernes"] as $evento): ?>
                <?php include __DIR__ . '/evento.php'; ?>
            <?php endforeach; ?>
        </div>

        <p class="eventos-registro__fecha">Sábado 3 de Agosto</p>

        <div class="eventos-registro__grid">
            <?php foreach($eventos["conferencias_sabado"] as $evento): ?>
                <?php include __DIR__ . '/evento.php'; ?>
            <?php endforeach; ?>
        </div>

        <h3 class="eventos-registro__heading--workshops">&lt;Workshops /&gt</h3>
        <p class="eventos-registro__fecha">Viernes 2 de Agosto</p>

        <div class="eventos-registro__grid eventos--workshops">
            <?php foreach($eventos["workshops_viernes"] as $evento): ?>
                <?php include __DIR__ . '/evento.php'; ?>
            <?php endforeach; ?>
        </div>

        <p class="eventos-registro__fecha">Sábado 3 de Agosto</p>

        <div class="eventos-registro__grid eventos--workshops">
            <?php foreach($eventos["workshops_sabado"] as $evento): ?>
                <?php include __DIR__ . '/evento.php'; ?>
            <?php endforeach; ?>
        </div>
    </main>

    <aside class="registro">
        <h2 class="registro__heading">Tu Registro</h2>

        <div class="registro__resumen" id="registro-resumen"></div>

        <div class="registro__regalo">
            <label for="regalo" class="registro__label">Selecciona un Regalo</label>
            <select id="regalo" class="registro__select">
                <option value="" selected disabled>-- Selecciona tu Regalo --</option>
                <?php foreach($regalos as $regalo): ?>
                    <option value="<?php echo $regalo->id; ?>">
                        <?php echo $regalo->nombre; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <form id="registro" class="formulario">
            <div class="formulario__campo">
                <input type="submit" class="formulario__submit formulario__submit--full" value="Registrarme">
            </div>
        </form>
    </aside>
</div>