CREATE DATABASE pingPong;

USE pingPong;

CREATE TABLE Rol (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rol VARCHAR(150) NOT NULL
);

CREATE TABLE Genero (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL
);

CREATE TABLE Usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nickName VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    nombre VARCHAR(150) NOT NULL,
    descripcion VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    ubicacion VARCHAR(150) NOT NULL,
    imagenPerfil VARCHAR(150) NOT NULL,
    pais VARCHAR(150) NOT NULL,
    ciudad VARCHAR(150) NOT NULL,
    idRol INT NOT NULL,
    fecharegistro DATE,
    idGenero INT NOT NULL,
    FOREIGN KEY (idGenero) REFERENCES Genero(id),
    FOREIGN KEY (idRol) REFERENCES Rol(id)
);

CREATE TABLE Partida (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    tiempo TIME NOT NULL
);

CREATE TABLE Jugada (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idPartida INT NOT NULL,
    idUsuario INT NOT NULL,
    FOREIGN KEY (idPartida) REFERENCES Partida(id),
    FOREIGN KEY (idUsuario) REFERENCES Usuario(id)
);

CREATE TABLE Opcion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    opcion1 VARCHAR(255) NOT NULL,
    opcion2 VARCHAR(255) NOT NULL,
    opcion3 VARCHAR(255) NOT NULL,
    opcion4 VARCHAR(255) NOT NULL,
    respuestaCorrecta INT NOT NULL
);

CREATE TABLE Categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);

CREATE TABLE Pregunta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta VARCHAR(255) NOT NULL,
    idOpcion INT NOT NULL,
    idCategoria INT NOT NULL,
    idUsuario INT NOT NULL,
    cantidadAciertos INT NOT NULL,
    cantidadOcurrencias INT NOT NULL,
    idJugada INT NOT NULL,
    FOREIGN KEY (idOpcion) REFERENCES Opcion(id),
    FOREIGN KEY (idCategoria) REFERENCES Categoria(id),
    FOREIGN KEY (idUsuario) REFERENCES Usuario(id),
    FOREIGN KEY (idJugada) REFERENCES Jugada(id)
);

CREATE TABLE PreguntaReportada (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idPregunta INT NOT NULL,
    idUsuario INT NOT NULL,
    fecha DATE NOT NULL,
    motivo VARCHAR(255) NOT NULL,
    FOREIGN KEY (idPregunta) REFERENCES Pregunta(id),
    FOREIGN KEY (idUsuario) REFERENCES Usuario(id)
);
