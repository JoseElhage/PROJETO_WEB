<?php
require_once '../config/database.php';
require_once '../config/auth.php';
require_once '../config/maps.php';
verificarLogin();

$chave_api = GOOGLE_MAPS_API_KEY;
$tem_chave = trim($chave_api) !== '';

$base = '../';
include '../includes/header.php';
?>

<h2>Mapa da sede da ETEC São José dos Campos</h2>

<p style="color: var(--texto-suave); margin-bottom: 1rem;">
    Localização da <strong>sede da ETEC São José dos Campos</strong> (Etec Profª Ilza Nascimento Pintus),
    exibida pela API do Google Maps. Endereço: <?= htmlspecialchars(ETEC_ENDERECO) ?>.
</p>

<div class="mapa-caixa">
    <?php if (!$tem_chave): ?>
        <div class="mensagem aviso">
            Chave da API do Google Maps ainda não configurada: o mapa está sendo exibido pelo modo
            de incorporação do Google. Para usar a API, coloque a sua chave em
            <code>config/maps.php</code>.
        </div>
    <?php endif; ?>

    <?php if ($tem_chave): ?>
        <div id="mapa"></div>
    <?php else: ?>
        <iframe
            class="mapa-iframe"
            src="https://maps.google.com/maps?q=<?= ETEC_LAT ?>,<?= ETEC_LNG ?>&z=16&output=embed"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            allowfullscreen
            title="Mapa da sede da ETEC São José dos Campos">
        </iframe>
    <?php endif; ?>
</div>

<div class="mapa-info">
    <div>
        <h3><?= htmlspecialchars(ETEC_NOME) ?></h3>
        <p><?= htmlspecialchars(ETEC_ENDERECO) ?></p>
        <p class="mapa-coordenadas">Coordenadas: <?= ETEC_LAT ?>, <?= ETEC_LNG ?></p>
    </div>
    <a class="btn-link btn-rotas"
       href="https://www.google.com/maps/dir/?api=1&destination=<?= ETEC_LAT ?>,<?= ETEC_LNG ?>"
       target="_blank" rel="noopener noreferrer">Como chegar</a>
</div>

<?php if ($tem_chave): ?>
<script>
    // Inicializa o mapa da API do Google Maps apontando a sede da ETEC
    function initMap() {
        const local = { lat: <?= ETEC_LAT ?>, lng: <?= ETEC_LNG ?> };
        const nome = <?= json_encode(ETEC_NOME) ?>;
        const endereco = <?= json_encode(ETEC_ENDERECO) ?>;

        const mapa = new google.maps.Map(document.getElementById('mapa'), {
            center: local,
            zoom: 16,
            mapTypeControl: true,
            streetViewControl: true,
            fullscreenControl: true
        });

        const marcador = new google.maps.Marker({
            position: local,
            map: mapa,
            title: nome
        });

        const janela = new google.maps.InfoWindow({
            content: '<div class="info-mapa"><strong>' + nome + '</strong><br>' + endereco + '</div>'
        });

        janela.open(mapa, marcador);
        marcador.addListener('click', function () {
            janela.open(mapa, marcador);
        });
    }
</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?= urlencode($chave_api) ?>&callback=initMap">
</script>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
