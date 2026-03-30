


CREATE DATABASE cifrado_DB;
USE cifrado_DB;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE registros (
    id INT AUTO_INCREMENT,
    usuario_id INT,
    texto_original TEXT,
    texto_cifrado TEXT,
    token VARCHAR(100) UNIQUE,
    fecha_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);
