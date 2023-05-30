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

CREATE TABLE usuario (
    id int auto_increment primary key,
    nickName varchar(50) not null,
    password varchar(50) not null,
    nombre varchar(150) not null,
    email varchar(150) not null,
    ubicacion varchar(150) not null,
    imagenPerfil varchar(150) not null,
    pais varchar(150) not null,
    ciudad varchar(150) not null,
    idRol int not null,
    fecharegistro date,
    cuentaValida bool default 0,
    idGenero int not null,
    FOREIGN KEY (idGenero) REFERENCES genero (id),
    FOREIGN KEY (idRol) references rol (id)
);

CREATE TABLE Partida (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    tiempo TIME NOT NULL
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
    FOREIGN KEY (idOpcion) REFERENCES Opcion (id),
    FOREIGN KEY (idCategoria) REFERENCES Categoria (id),
    FOREIGN KEY (idUsuario) REFERENCES Usuario (id)
);

CREATE TABLE Jugada (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idPartida INT NOT NULL,
    idPregunta INT NOT NULL,
    idUsuario INT NOT NULL,
    FOREIGN KEY (idUsuario) REFERENCES Usuario (id),
    FOREIGN KEY (idPartida) REFERENCES Partida (id),
    FOREIGN KEY (idPregunta) REFERENCES Pregunta (id)
);

CREATE TABLE PreguntaReportada (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idPregunta INT NOT NULL,
    idUsuario INT NOT NULL,
    fecha DATE NOT NULL,
    motivo VARCHAR(255) NOT NULL,
    FOREIGN KEY (idPregunta) REFERENCES Pregunta (id),
    FOREIGN KEY (idUsuario) REFERENCES Usuario (id)
);