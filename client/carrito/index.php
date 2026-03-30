<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__, 2) . '/config/constants.php';
require_once dirname(__DIR__, 2) . '/config/database.php';
require_once dirname(__DIR__) . '/includes/require_cliente_auth.php';

$espacio_id = isset($_GET['espacio_id']) ? (int) $_GET['espacio_id'] : 0;
$espacio = null;

if ($espacio_id > 0) {
    try {
        $pdo = conectarDB();
        $stmt = $pdo->prepare(
            'SELECT id, nombre, precio_noche, foto_principal FROM espacios WHERE id = ? AND activo = 1 LIMIT 1'
        );
        $stmt->execute([$espacio_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (is_array($row)) {
            $espacio = $row;
        }
    } catch (Throwable $e) {
        error_log('carrito index: ' . $e->getMessage());
    }
}

$page_title = 'Reservar · Hotel Salitre';
$extra_stylesheets = ['assets/css/client/carrito.css'];

require dirname(__DIR__) . '/includes/header.php';

$base = BASE_URL;
$confirm_url = $base . 'client/carrito/confirmacion.php';
$catalogo = $base . 'client/espacios/';

$foto_url = '';
if ($espacio !== null && !empty($espacio['foto_principal'])) {
    $fp = (string) $espacio['foto_principal'];
    if (preg_match('#^https?://#i', $fp)) {
        $foto_url = $fp;
    } else {
        $foto_url = $base . ltrim($fp, '/');
    }
}

$precio_js = $espacio !== null ? (float) ($espacio['precio_noche'] ?? 0) : 0.0;
$precio_attr = htmlspecialchars((string) $precio_js, ENT_QUOTES, 'UTF-8');

$error_get = isset($_GET['error']) ? (string) $_GET['error'] : '';
$checkout_error = '';
if ($error_get === 'fechas') {
    $checkout_error = 'Las fechas no son válidas: la salida debe ser posterior a la entrada.';
} elseif ($error_get === 'noches') {
    $checkout_error = 'El número de noches supera el máximo permitido.';
}
?>
  <main id="contenido-principal" class="checkout-page">
<?php if ($espacio === null) : ?>
    <h1 class="checkout-page__title">Carrito</h1>
    <p class="checkout-empty">Selecciona un espacio desde el <a href="<?php echo htmlspecialchars($catalogo, ENT_QUOTES, 'UTF-8'); ?>">catálogo</a> o abre el enlace “Reservar” desde el detalle de un espacio.</p>
<?php else : ?>
    <h1 class="checkout-page__title">Checkout</h1>
    <p class="checkout-page__lead">Confirma las fechas de tu estancia en <?php echo htmlspecialchars((string) $espacio['nombre'], ENT_QUOTES, 'UTF-8'); ?>.</p>
<?php if ($checkout_error !== '') : ?>
    <p class="checkout-alert" role="alert"><?php echo htmlspecialchars($checkout_error, ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>

    <div class="checkout-espacio">
      <div class="checkout-espacio__media">
<?php if ($foto_url !== '') : ?>
        <img src="<?php echo htmlspecialchars($foto_url, ENT_QUOTES, 'UTF-8'); ?>" alt="">
<?php endif; ?>
      </div>
      <div class="checkout-espacio__body">
        <h2 class="checkout-espacio__name"><?php echo htmlspecialchars((string) $espacio['nombre'], ENT_QUOTES, 'UTF-8'); ?></h2>
        <p class="checkout-espacio__price">Precio por noche: <strong><?php echo htmlspecialchars(number_format((float) $espacio['precio_noche'], 2, ',', '.'), ENT_QUOTES, 'UTF-8'); ?> <?php echo htmlspecialchars(MONEDA, ENT_QUOTES, 'UTF-8'); ?></strong></p>
      </div>
    </div>

    <div
      id="checkout-root"
      class="checkout-form-wrap"
      data-precio-noche="<?php echo $precio_attr; ?>"
      data-moneda="<?php echo htmlspecialchars(MONEDA, ENT_QUOTES, 'UTF-8'); ?>"
    >
      <form class="checkout-form" method="post" action="<?php echo htmlspecialchars($confirm_url, ENT_QUOTES, 'UTF-8'); ?>">
        <input type="hidden" name="espacio_id" value="<?php echo (int) $espacio['id']; ?>">
        <div class="checkout-form__row">
          <label class="checkout-form__label" for="fecha_entrada">Fecha de entrada</label>
          <input class="checkout-form__input" type="date" id="fecha_entrada" name="fecha_entrada" required>
        </div>
        <div class="checkout-form__row">
          <label class="checkout-form__label" for="fecha_salida">Fecha de salida</label>
          <input class="checkout-form__input" type="date" id="fecha_salida" name="fecha_salida" required>
        </div>
        <div class="checkout-total">
          <p class="checkout-total__label">Total estimado</p>
          <p class="checkout-total__value" id="total-estimado">—</p>
          <p class="checkout-total__hint">El importe final se confirma al procesar la reserva (noches × precio por noche).</p>
        </div>
        <button class="checkout-form__submit" type="submit">Confirmar reserva</button>
      </form>
    </div>

    <script>
(function () {
  var root = document.getElementById('checkout-root');
  if (!root) return;
  var precio = parseFloat(root.getAttribute('data-precio-noche') || '0', 10);
  var moneda = root.getAttribute('data-moneda') || '';
  var inE = document.getElementById('fecha_entrada');
  var inS = document.getElementById('fecha_salida');
  var out = document.getElementById('total-estimado');
  function fmt(n) {
    return n.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  }
  function calc() {
    if (!inE || !inS || !out) return;
    var v1 = inE.value;
    var v2 = inS.value;
    if (!v1 || !v2) {
      out.textContent = '—';
      return;
    }
    var d1 = new Date(v1 + 'T12:00:00');
    var d2 = new Date(v2 + 'T12:00:00');
    var ms = d2.getTime() - d1.getTime();
    var nights = Math.floor(ms / 86400000);
    if (!isFinite(nights) || nights < 1) {
      out.textContent = '—';
      return;
    }
    var total = nights * precio;
    out.textContent = fmt(total) + ' ' + moneda;
  }
  inE.addEventListener('change', calc);
  inS.addEventListener('change', calc);
  inE.addEventListener('input', calc);
  inS.addEventListener('input', calc);
})();
    </script>
<?php endif; ?>
  </main>
<?php
require dirname(__DIR__) . '/includes/footer.php';
