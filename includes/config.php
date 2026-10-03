<?php
/**
 * Application configuration.
 * All sensitive values are read from environment variables.
 * Copy .env.example to .env and fill in your values for local development.
 */
require_once __DIR__ . DIRECTORY_SEPARATOR . 'env_loader.php';
loadEnv();

// Database configuration
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'victordevelop');

// Contact information
define('CONTACT_EMAIL', getenv('CONTACT_EMAIL') ?: 'contacto@victordevelop.com');
define('CONTACT_PHONE', getenv('CONTACT_PHONE') ?: '+56 9 0000 0000');
define('CONTACT_WHATSAPP', getenv('CONTACT_WHATSAPP') ?: 'https://wa.me/00000000000');
define('CONTACT_INSTAGRAM', getenv('CONTACT_INSTAGRAM') ?: 'https://instagram.com/tu_usuario');
define('CONTACT_LOCATION', getenv('CONTACT_LOCATION') ?: 'Tu Ciudad, País');

// Site configuration
define('SITE_NAME', getenv('SITE_NAME') ?: 'VictorDevelop');
define('SITE_TITLE', getenv('SITE_TITLE') ?: 'VictorDevelop - PHP Web Template');
define('SITE_DESCRIPTION', getenv('SITE_DESCRIPTION') ?: 'Responsive PHP template with admin panel, portfolio catalog, contact form, and canvas mandala animation.');
