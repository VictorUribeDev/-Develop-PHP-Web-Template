# AGENTS.md — Development Guidelines

This file provides context for AI agents and developers working on the VictorDevelop codebase.

## Project Overview

VictorDevelop is a PHP web application for a web development business. It features a responsive Bootstrap-based frontend, an admin panel, a contact form, and a dynamic canvas-based mandala animation.

## Tech Stack

- **Language:** PHP 7.4+
- **Database:** MySQL / MariaDB (via PDO)
- **Frontend:** HTML5, CSS3, JavaScript (ES6+), Bootstrap 5, Font Awesome
- **No framework** — vanilla PHP with PDO

## Coding Standards

- **PHP:** Use PSR-12 formatting conventions (4-space indentation).
- **HTML:** Use 4-space indentation consistent with existing files.
- **CSS:** Standard CSS with 4-space indentation.
- **JavaScript:** Use `const`/`let`, avoid `var` where possible.

## Environment & Configuration

- All configuration is in `includes/config.php` and reads from environment variables via `getenv()`.
- Use `.env` for local development (copy from `.env.example`).
- `.env` is listed in `.gitignore` and must never be committed.
- Config constants are defined with `define()` at the top of `config.php`.

## Key Files

| File | Purpose |
|---|---|
| `includes/config.php` | All configuration constants (DB, contact, site) |
| `includes/db.php` | PDO connection — requires `config.php` |
| `includes/auth.php` | Session-based authentication helpers |
| `includes/env_loader.php` | Lightweight `.env` file loader |
| `includes/header.php` | Site header and navbar |
| `includes/footer.php` | Site footer |
| `admin/index.php` | Admin panel (CRUD for publications) |
| `admin/login.php` | Login form + handler |
| `admin/register.php` | Admin registration |
| `admin/auth.php` is required by admin pages via `require '../includes/auth.php'` |

## Development Workflow

1. Copy `.env.example` to `.env` and fill in values.
2. Import `database/schema.sql` into MySQL.
3. Start PHP dev server: `php -S localhost:8000`
4. Register an admin at `admin/register.php`, then log in at `admin/login.php`.

## Security Reminders

- Never commit `.env` or any file containing secrets.
- Sanitize all user input (use `htmlspecialchars` for output, prepared statements for SQL).
- Validate file uploads (check MIME type, use `uniqid()` for filenames).
- Hash passwords with `password_hash(PASSWORD_BCRYPT)`.

## Build / Lint Commands

There is no build step. PHP files can be linted with:

```bash
php -l <file.php>
```

For CSS, use your preferred linter. No npm scripts are configured.
