-- Database schema for VictorDevelop
-- Import this file into MySQL/MariaDB to create the required database structure

CREATE DATABASE IF NOT EXISTS victordevelop
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE victordevelop;

-- Table: usuarios (admin users)
CREATE TABLE IF NOT EXISTS usuarios (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    username        VARCHAR(100) NOT NULL UNIQUE,
    password_hash   VARCHAR(255) NOT NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: publicaciones (catalog items)
CREATE TABLE IF NOT EXISTS publicaciones (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    titulo          VARCHAR(255) NOT NULL,
    descripcion     TEXT NOT NULL,
    fecha_creacion  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: imagenes (images for publications)
CREATE TABLE IF NOT EXISTS imagenes (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    publicacion_id  INT NOT NULL,
    ruta_imagen     VARCHAR(500) NOT NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (publicacion_id)
        REFERENCES publicaciones(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: mensajes (contact form submissions)
CREATE TABLE IF NOT EXISTS mensajes (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nombre          VARCHAR(255) NOT NULL,
    email           VARCHAR(255) NOT NULL,
    asunto          VARCHAR(255) NOT NULL,
    mensaje         TEXT NOT NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
