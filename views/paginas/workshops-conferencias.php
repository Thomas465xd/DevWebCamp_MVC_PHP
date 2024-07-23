<main class="agenda">
    <h2 class="agenda__heading"><?php echo $titulo; ?></h2>
    <p class="agenda__descripcion">Talleres y Conferencias dictados por Expertos en Desarrollo Web</p>

    <div class="eventos">
        <h3 class="eventos__heading">&lt;Conferencias /&gt</h3>
        <p class="eventos__fecha">Viernes 2 de Agosto</p>

        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper">
                <?php foreach($eventos["conferencias_viernes"] as $evento): ?>
                    <?php include __DIR__ . '../../templates/evento.php'; ?>
                <?php endforeach; ?>
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <p class="eventos__fecha">Sabado 3 de Agosto</p>

        <div class="eventos">
        <h3 class="eventos__heading">&lt;Conferencias /&gt</h3>
        <p class="eventos__fecha">Viernes 2 de Agosto</p>

        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper">
                <?php foreach($eventos["conferencias_sabado"] as $evento): ?>
                    <?php include __DIR__ . '../../templates/evento.php'; ?>
                <?php endforeach; ?>
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>

    <div class="eventos eventos--workshops">
        <h3 class="eventos__heading">&lt;Workshops /&gt</h3>
        <p class="eventos__fecha">Sabado 2 de Agosto</p>

        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper">
                <?php foreach($eventos["workshops_viernes"] as $evento): ?>
                    <?php include __DIR__ . '../../templates/evento.php'; ?>
                <?php endforeach; ?>
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <p class="eventos__fecha">Sabado 3 de Agosto</p>

        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper">
                <?php foreach($eventos["workshops_sabado"] as $evento): ?>
                    <?php include __DIR__ . '../../templates/evento.php'; ?>
                <?php endforeach; ?>
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</main>