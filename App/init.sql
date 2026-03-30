CREATE DATABASE IF NOT EXISTS cifrado_DB;
USE cifrado_DB;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT IGNORE INTO usuarios (id, username, password) VALUES (1, 'Isaiah', '12345');

CREATE TABLE IF NOT EXISTS registros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    texto_original TEXT,
    texto_cifrado TEXT,
    token VARCHAR(100) UNIQUE,
    fecha_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);