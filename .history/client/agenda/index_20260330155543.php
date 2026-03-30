<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    }
    
    require_once dirname(__DIR__, 2) . '/config/constants.php';
    require_once dirname(__DIR__, 2) . '/config/database.php';
    
    $eventos = [];
    
    try {
      $pdo = conectarDB();
      $stmt = $pdo->prepare(
        'SELECT id, titulo, descripcion, fecha_evento, hora_inicio, hora_fin, cupo
        FROM eventos
        WHERE activo = 1 AND fecha_evento >= CURDATE()
        ORDER BY fecha_evento ASC, hora_inicio ASC'
        );
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (is_array($rows)) {
          $eventos = $rows;
          }
          } catch (Throwable $e) {
            error_log('Agenda eventos: ' . $e->getMessage());
            $eventos = [];
            }
            
            $page_title = 'Agenda de eventos · Hotel Salitre';
            $extra_stylesheets = ['assets/css/client/agenda.css'];
            require dirname(__DIR__) . '/includes/header.php';
            $base = BASE_URL; ?>
            
            <main id="contenido-principal" class="agenda-page">
              <header class="agenda-page__header fade-in">
                <h1 class="agenda-page__title">Agenda</h1>
                <p class="agenda-page__lead">Experiencias y encuentros próximos en Hotel Salitre.</p>
              </header>
              
              <div class="agenda-grid">
                <?php foreach ($eventos as $ev) :
                $fecha_raw = (string) ($ev['fecha_evento'] ?? '');
                $fecha_fmt = $fecha_raw;
                if ($fecha_raw !== '') {
                  $dt = DateTime::createFromFormat('Y-m-d', $fecha_raw);
                  if ($dt instanceof DateTime) {
                    $fecha_fmt = $dt->format('d/m/Y');
                    }
                    }
                    $hora_ini = $ev['hora_inicio'] ?? null;
                    $hora_fmt = '—';
                    if ($hora_ini !== null && $hora_ini !== '') {
                      $th = DateTime::createFromFormat('H:i:s', (string) $hora_ini)
                      ?: DateTime::createFromFormat('H:i', (string) $hora_ini);
                      if ($th instanceof DateTime) {
                        $hora_fmt = $th->format('H:i');
                        } else {
                          $hora_fmt = substr((string) $hora_ini, 0, 5);
                          }
                          }
                          $cupo = $ev['cupo'] ?? null;
                          $cupo_txt = ($cupo === null || $cupo === '') ? 'Sin límite publicado' : (string) (int) $cupo . ' plazas'; ?>
                          <article class="event-card fade-in">
                            <div class="event-card__date">
                              <span class="event-card__date-label">Fecha</span>
                              <span class="event-card__date-value"><?php echo htmlspecialchars($fecha_fmt, ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                            <div class="event-card__body">
                              <h2 class="event-card__title"><?php echo htmlspecialchars((string) ($ev['titulo'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></h2>
                              <?php if (!empty($ev['descripcion'])) : ?>
                                <p class="event-card__desc"><?php echo htmlspecialchars((string) $ev['descripcion'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <?php endif; ?>
                                <dl class="event-card__meta">
                                  <div class="event-card__meta-row">
                                    <dt>Hora de inicio</dt>
                                    <dd><?php echo htmlspecialchars($hora_fmt, ENT_QUOTES, 'UTF-8'); ?></dd>
                                  </div>
                                  <div class="event-card__meta-row">
                                    <dt>Cupo</dt>
                                    <dd><?php echo htmlspecialchars($cupo_txt, ENT_QUOTES, 'UTF-8'); ?></dd>
                                  </div>
          </dl>
        </div>
      </article>
<?php endforeach; ?>
    </div>

<?php if (count($eventos) === 0) : ?>
    <p class="agenda-page__empty fade-in" role="status">No hay eventos programados a partir de hoy. Vuelve pronto.</p>
<?php endif; ?>
  </main>
<?php
require dirname(__DIR__) . '/includes/footer.php';
