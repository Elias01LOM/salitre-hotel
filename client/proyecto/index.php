<?php
session_start();
require_once dirname(__DIR__) . "/../config/constants.php";

$page_title = "El Proyecto — Hotel Salitre";
$extra_stylesheets = ["assets/css/client/proyecto.css"];

require_once dirname(__DIR__) . "/includes/header.php";
require_once dirname(__DIR__) . "/includes/nav.php";
?>

<div class="page-offset"></div>

<!-- A. #intro -->
<section id="intro" class="proyecto-intro text-center">
    <div class="container container--narrow fade-in">
        <h1 class="section-title">Sal de la oficina. <span class="text-accent">No del trabajo.</span></h1>
        <p class="text-muted text-lg mt-4 mb-8">
            Diseñamos <strong>Hotel Salitre</strong> pensando en aquellos que llevan su productividad en la mochila. 
            No somos simplemente un resort frente a la costa del Pacífico, somos un oasis remoto con internet simétrico, 
            sillas ergonómicas y un diseño minimalista concebido para la profunda concentración y la desconexión ideal.
        </p>
        
        <div class="img-placeholder" style="width:100%; height:400px; border-radius:var(--radius-lg); background:var(--color-bg); display:grid; place-items:center; border: 1px dashed var(--color-border); color:var(--color-text-muted);">
            [ Imagen / Ilustración del concepto Salitre ]
        </div>
    </div>
</section>

<!-- B. #conocenos -->
<section id="conocenos" class="proyecto-pillars" style="background:var(--color-surface); padding:var(--space-12) 0;">
    <div class="container text-center mb-10 fade-in">
        <h2 class="section-title">Conócenos</h2>
        <p class="text-muted text-lg max-w-2xl mx-auto">Los tres pilares de nuestra filosofía hostilera.</p>
    </div>
    
    <div class="container grid gap-8" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
        
        <article class="pillar-card fade-in text-center p-6 border-radius shadow-sm bg-white" data-delay="0">
            <div class="pillar-icon mb-4" style="color:var(--color-accent); display:flex; justify-content:center;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>
            </div>
            <h3 class="fw-700 text-lg mb-2">Conectividad 10/10</h3>
            <p class="text-sm text-muted">Red redundante de fibra óptica simétrica garantizada en cada metro cuadrado, hasta en la hamaca de la playa.</p>
        </article>

        <article class="pillar-card fade-in text-center p-6 border-radius shadow-sm bg-white" data-delay="100">
            <div class="pillar-icon mb-4" style="color:var(--color-accent); display:flex; justify-content:center;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/><path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z"/></svg>
            </div>
            <h3 class="fw-700 text-lg mb-2">Ergonomía Total</h3>
            <p class="text-sm text-muted">Estaciones de trabajo de pie, sillas Herman Miller y monitores ultrawide disponibles bajo demanda para no comprometer tu postura.</p>
        </article>

        <article class="pillar-card fade-in text-center p-6 border-radius shadow-sm bg-white" data-delay="200">
            <div class="pillar-icon mb-4" style="color:var(--color-accent); display:flex; justify-content:center;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20"/><path d="m17 5-5-3-5 3"/><path d="m7 19 5 3 5-3"/></svg>
            </div>
            <h3 class="fw-700 text-lg mb-2">Diseño y Flujo</h3>
            <p class="text-sm text-muted">Aislamiento acústico de primera, grandes ventanales y luz natural controlada que favorecen tanto el descanso como los estados de Deep Work.</p>
        </article>

    </div>
</section>

<!-- C. #ubicacion -->
<section id="ubicacion" class="proyecto-ubicacion section-pad">
    <div class="container container--narrow fade-in text-center mb-8">
        <h2 class="section-title">Ubicación</h2>
        <p class="text-muted text-lg mt-2">
            Dejamos el ruido de la ciudad atrás. Nos encuentras frente al mar.
        </p>
    </div>
    <div class="container fade-in" data-delay="100">
        <div class="map-wrapper shadow-lg" style="border-radius:var(--radius-lg); overflow:hidden; border:1px solid var(--color-border); background:var(--color-surface); display:flex; flex-direction:column;">
            
            <div class="img-placeholder" style="width:100%; height:450px; display:grid; place-items:center; background:var(--color-bg); font-weight:600; color:var(--color-text-muted);">
                [ Iframe Google Maps Embebido - Costa Pacífico, México ]
            </div>

            <div class="map-info p-6 text-center" style="background:var(--color-surface);">
                <p class="fw-700 text-lg">Hotel Salitre — Costa Pacífico, México</p>
                <p class="text-muted text-sm mt-1">Av. Las Olas 123, Corredor Costero, CP 20394</p>
                <p class="text-muted text-xs mt-1" style="font-family:monospace;">Lat: 15.8694° N, Long: -97.0768° W</p>
            </div>
        </div>
    </div>
</section>

<?php require_once dirname(__DIR__) . "/includes/footer.php"; ?>
