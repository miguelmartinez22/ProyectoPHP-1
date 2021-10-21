-- Crear tabla usuario para "proyecto"
CREATE TABLE IF NOT EXISTS usuario (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    dni VARCHAR(9) NOT NULL UNIQUE,
    nombre VARCHAR(20) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    hospital VARCHAR(100) NOT NULL,
    vacuna1 DATE NOT NULL,
    vacuna2 DATE NOT NULL
);


-- Crear tabla vacuna para "proyecto"
CREATE TABLE IF NOT EXISTS vacuna (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(20) NOT NULL UNIQUE,
    nombre_largo VARCHAR(100) NOT NULL,
    fabricante VARCHAR(255) NOT NULL,
    num_dosis INT(10) NOT NULL,
    dias_minimos INT,
    dias_maximos INT
);