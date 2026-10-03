# VictorDevelop

A responsive PHP website template for a web development business. Features a dynamic canvas mandala animation, a portfolio/catalog system with image carousels, a contact form, and an admin panel for managing publications.

## Features

- **Responsive Design** — Built with Bootstrap 5, fully mobile-friendly
- **Generative Art** — Interactive mandala animation rendered on HTML5 Canvas
- **Portfolio Catalog** — Display web projects with image carousels
- **Contact Form** — Visitors can send messages, stored in the database
- **Admin Panel** — Secure login, publication management, image uploads
- **Environment-Based Configuration** — No secrets in source code

## Requirements

- PHP 7.4+ (tested on PHP 8.x)
- MySQL 5.7+ or MariaDB 10.3+
- A web server (Apache, Nginx, or PHP built-in server)

### PHP Extensions

- `pdo_mysql`
- `mbstring`

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/tu-usuario/victordevelop.git
   cd victordevelop
   ```

2. **Create a `.env` file** from the template:

   ```bash
   cp .env.example .env
   ```

   Edit `.env` and fill in your database credentials and contact information.

3. **Import the database schema:**

   ```bash
   mysql -u root -p < database/schema.sql
   ```

4. **(For Apache) Ensure the `admin/uploads/` directory is writable:**

   ```bash
   mkdir -p admin/uploads
   chmod 755 admin/uploads
   ```

5. **Start the development server:**

   ```bash
   php -S localhost:8000
   ```

   Then visit `http://localhost:8000` in your browser.

6. **Create an admin user:**

   Visit `admin/register.php` in your browser and register your first admin account, or insert directly via SQL:

   ```sql
   INSERT INTO usuarios (username, password_hash)
   VALUES ('admin', '$2y$10$your_bcrypt_hash_here');
   ```

   Use `password_hash('your_password', PASSWORD_BCRYPT)` in PHP to generate the hash.

## Configuration

All configuration is done via environment variables in the `.env` file (which is gitignored). See `.env.example` for all available options:

| Variable | Description | Default |
|---|---|---|
| `DB_HOST` | Database host | `localhost` |
| `DB_USER` | Database username | `root` |
| `DB_PASS` | Database password | *(empty)* |
| `DB_NAME` | Database name | `victordevelop` |
| `CONTACT_EMAIL` | Contact email address | — |
| `CONTACT_PHONE` | Contact phone number | — |
| `CONTACT_WHATSAPP` | WhatsApp URL | — |
| `CONTACT_INSTAGRAM` | Instagram URL | — |
| `CONTACT_LOCATION` | Location text | — |
| `SITE_NAME` | Site name (brand) | `VictorDevelop` |
| `SITE_TITLE` | Browser title | `VictorDevelop - Desarrollo Web` |
| `SITE_DESCRIPTION` | Meta description | — |

## Project Structure

```
victordevelop/
├── admin/
│   ├── index.php              # Admin panel: add/list/delete publications
│   ├── login.php              # Admin login
│   ├── logout.php             # Admin logout
│   ├── register.php           # Admin user registration
│   └── eliminar_publicacion.php  # Delete publication
├── assets/
│   ├── css/
│   │   └── style.css          # Custom styles
│   ├── img/
│   │   ├── logo.png           # Site logo
│   │   └── logo.ico           # Favicon
│   └── js/
│       └── mandala.js         # Canvas mandala animation
├── database/
│   └── schema.sql             # Database schema
├── includes/
│   ├── auth.php               # Authentication helpers
│   ├── config.php             # Configuration (env-based)
│   ├── db.php                 # PDO database connection
│   ├── env_loader.php         # Simple .env loader
│   ├── footer.php             # Site footer
│   └── header.php             # Site header/navbar
├── .env.example               # Environment variable template
├── .gitignore
├── LICENSE                    # MIT License
├── README.md
└── ...php files at root
```

## Usage

### Managing Publications

1. Log in at `admin/login.php`.
2. On the admin panel (`admin/index.php`), fill in the title, description, and upload images.
3. Click "Agregar" to create a new publication.
4. Use the "Eliminar" button in the publications table to remove entries.

### Contact Form

The contact form on `contacto.php` stores messages in the `mensajes` table. Messages can be retrieved via the database.

## Security Notes

- All database credentials are loaded from environment variables — never hardcode them.
- Never commit your `.env` file (it is in `.gitignore`).
- The admin panel uses password hashing (`PASSWORD_BCRYPT`).
- Form inputs are sanitized with `htmlspecialchars()`.
- The `admin/uploads/` directory should not be directly accessible for execution of uploaded files.

## External Dependencies

- **Bootstrap 5** — CSS framework (loaded via CDN)
- **Font Awesome** — Icon library (loaded via CDN)
- **jQuery** — Loaded via CDN in footer

No Composer dependencies are required.

## License

This project is licensed under the MIT License — see the [LICENSE](LICENSE) file for details.
