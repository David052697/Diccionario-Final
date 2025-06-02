CREATE DATABASE IF NOT EXISTS diccionario;
USE diccionario;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    correo VARCHAR(100) UNIQUE,
    clave TEXT,
    rol ENUM('administrador', 'cliente') NOT NULL
);

CREATE TABLE IF NOT EXISTS palabras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100),
    descripcion TEXT,
    imagen VARCHAR(255)
);