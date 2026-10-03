<?php include 'includes/header.php'; ?>

    <!-- Contenido Principal -->
    <main>
        <!-- Hero Section -->
        <section class="hero">
            <h1>Bienvenido a VictorDevelop</h1>
            <p class="slogan">Transformamos tus ideas en <strong>realidad digital</strong>.</p>
            <p class="sub-slogan">Diseño web profesional, rápido y a medida para tu negocio.</p>
            <div class="cta-buttons">
                <a href="catalogo.php" class="btn-catalogo">Ver Catálogo</a>
                <a href="contacto.php" class="btn-contacto">¡Contáctame!</a>
            </div>
        </section>

        <!-- Sección del Mandala -->
        <div class="mandala-section">
            <canvas id="mandalaCanvas" title="Arte Generativo con javascript"></canvas>
        </div>

        <!-- Frases Publicitarias -->
        <section class="frases-publicitarias">
            <div class="frase">
                <i class="fas fa-rocket"></i>
                <p>Llevamos tu negocio al <strong>siguiente nivel</strong> con soluciones web innovadoras.</p>
            </div>
            <div class="frase">
                <i class="fas fa-mobile-alt"></i>
                <p>Diseños <strong>100% responsive</strong> que se adaptan a cualquier dispositivo.</p>
            </div>
            <div class="frase">
                <i class="fas fa-handshake"></i>
                <p>Trabajamos contigo en cada paso para garantizar tu <strong>satisfacción</strong>.</p>
            </div>
        </section>

        <!-- Llamado a la Acción (CTA) Final -->
        <section class="cta-final">
            <h2>¿Listo para comenzar?</h2>
            <p>Contáctame hoy mismo y lleva tu negocio al siguiente nivel.</p>
            <a href="contacto.php" class="btn-cta">¡Contáctame!</a>
        </section>
    </main>

    <!-- Script del Mandala -->
    <script src="assets/js/mandala.js"></script>

<?php include 'includes/footer.php'; ?>