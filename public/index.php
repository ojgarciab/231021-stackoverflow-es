<?php
/* Si hemos recibido el número de página por GET lo usamos */
if (empty($_GET['pag']) === false) {
    $pagina_actual = intval($_GET['pag']);
} else {
    $pagina_actual = 1;
}
$uri = 'https://sandbox-api.brewerydb.com/v2/beers?p='. $pagina_actual .'&key=a1dc1446191ebea66072bac6e03a13f6';
$reqPrefs['http']['method'] = 'GET';
$reqPrefs['http']['header'] = 'X-Auth-Token: 7c112489898843e6b4949f49284587ed';
$stream_context = stream_context_create($reqPrefs);
$response = file_get_contents($uri, false, $stream_context);
$cervezas = json_decode($response);
?><!doctype html>
<html lang="es">
  <head>
    <!-- Meta tags requeridos -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS de Bootstrap -->
 	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <title>Birras del mundo</title>
  </head>
  <body>
    <div class="container">
      <h1>Cervezas del mundo</h1>
      <ul>
        <?php foreach ($cervezas->data as $cerveza): ?>
        <li>
            <a href="verbirra.php?id=<?= htmlspecialchars($cerveza->id) ?>">
                <?= htmlspecialchars($cerveza->nameDisplay) ?>
            </a>
        </li>
        <?php endforeach; ?>
      </ul>
      <?php if ($cervezas->currentPage > 1): ?>
        <a class="btn btn-primary" href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>?pag=<?= htmlspecialchars($cervezas->currentPage - 1) ?>">Anterior</a>
      <?php else: ?>
        <button class="btn btn-secondary" disabled>Anterior</button>
      <?php endif; ?>
      <button class="btn btn-success" disabled><?= htmlspecialchars($cervezas->currentPage) ?></button>
      <?php if ($cervezas->currentPage < $cervezas->numberOfPages): ?>
        <a class="btn btn-primary" href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>?pag=<?= htmlspecialchars($cervezas->currentPage + 1) ?>">Siguiente</a>
      <?php else: ?>
        <button class="btn btn-secondary" disabled>Siguiente</button>
      <?php endif; ?>
    </div>

    <!-- JavaScript opcional -->
    <!-- Primero jQuery, después Popper.js y por último el JS de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  </body>
</html>