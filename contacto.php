<?php include 'includes/header.php'; ?>

    <!-- Contenido Principal -->
    <main>
        <!-- Hero Section de Contacto -->
        <section class="hero contacto-hero">
            <h1>Contacto</h1>
            <p>¿Tienes un proyecto en mente? ¡Hablemos!</p>
        </section>

        <!-- Sección de Información de Contacto y Formulario -->
        <section class="contacto-contenido">
            <div class="contacto-info">
                <h2>Información de Contacto</h2>
                <p>Estoy aquí para ayudarte. Contáctame para discutir tu proyecto o cualquier consulta que tengas.</p>
                <ul>
                    <li><i class="fas fa-envelope"></i> <a href="mailto:<?php echo CONTACT_EMAIL; ?>"><?php echo CONTACT_EMAIL; ?></a></li>
                    <li><i class="fas fa-phone"></i> <a href="tel:<?php echo str_replace(' ', '', CONTACT_PHONE); ?>"><?php echo CONTACT_PHONE; ?></a></li>
                    <li><i class="fas fa-map-marker-alt"></i> <?php echo CONTACT_LOCATION; ?></li>
                </ul>
                <div class="redes-sociales">
                    <a href="<?php echo CONTACT_WHATSAPP; ?>" target="_blank" class="whatsapp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="<?php echo CONTACT_INSTAGRAM; ?>" target="_blank" class="instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>

            <!-- Formulario de Contacto -->
            <div class="contacto-formulario">
                <h2>Envíame un Mensaje</h2>

                <!-- Mostrar mensaje de éxito o error -->
                <?php if (isset($_GET['status'])): ?>
                    <?php if ($_GET['status'] === 'success'): ?>
                        <div class="alert alert-success">
                            <p>¡Mensaje enviado con éxito!</p>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-error">
                            <p>Hubo un error al enviar el mensaje. Inténtalo de nuevo.</p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <form action="procesar_contacto.php" method="POST">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="asunto">Asunto:</label>
                        <input type="text" id="asunto" name="asunto" required>
                    </div>
                    <div class="form-group">
                        <label for="mensaje">Mensaje:</label>
                        <textarea id="mensaje" name="mensaje" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn-enviar">Enviar Mensaje</button>
                </form>
            </div>
        </section>
    </main>

<?php include 'includes/footer.php'; ?>