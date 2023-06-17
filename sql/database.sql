DROP database pingpong;

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
    imagenPerfil varchar(150) not null,
    pais varchar(150) not null,
    ciudad varchar(150) not null,
    idRol int not null,
    fechaNacimiento date not null,
    fecharegistro date,
    cuentaValida bool default 0,
    idGenero int not null,
    longitud double not null,
    latitud double not null,
    nivelJugador varchar(150) default 'PRINCIPIANTE',
    FOREIGN KEY (idGenero) REFERENCES genero (id),
    FOREIGN KEY (idRol) references rol (id)
);

CREATE TABLE Partida (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    idUsuario INT NOT NULL,
    puntaje INT,
    FOREIGN KEY (idUsuario) REFERENCES Usuario (id)
);

CREATE TABLE Categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    color VARCHAR(100) NOT NULL
);

CREATE TABLE Pregunta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta VARCHAR(255) NOT NULL,
    idCategoria INT NOT NULL,
    idUsuario INT NOT NULL,
    cantidadAciertos INT NOT NULL,
    cantidadOcurrencias INT NOT NULL,
    opcion1 varchar(200) not null,
    opcion2 varchar(200) not null,
    opcion3 varchar(200) not null,
    opcion4 varchar(200) not null,
    respuestaCorrecta int not null,
    dificultad varchar(150) default 'FACIL',
    estadoReportada boolean default false,
    FOREIGN KEY (idCategoria) REFERENCES Categoria (id),
    FOREIGN KEY (idUsuario) REFERENCES Usuario (id)
);


CREATE TABLE Jugada (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idPregunta INT NOT NULL,
    idPartida INT NOT NULL,
    tiempo TIME,
    FOREIGN KEY (idPartida) REFERENCES Partida (id),
    FOREIGN KEY (idPregunta) REFERENCES Pregunta (id),
    respondidoCorrectamente BOOLEAN DEFAULT FALSE
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

CREATE TABLE usuario_pregunta (
    idUsuario INT not null,
    idPregunta INT not null,
    ocurrencias int default 0,
    aciertos int default 0,
    PRIMARY KEY (idUsuario, idPregunta),
    FOREIGN KEY (idPregunta) REFERENCES Pregunta (id),
    FOREIGN KEY (idUsuario) REFERENCES Usuario (id)
);

CREATE TABLE Pregunta_sugerida (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta VARCHAR(255) NOT NULL,
    idCategoria INT NOT NULL,
    idUsuario INT NOT NULL,
    opcion1 VARCHAR(255) NOT NULL,
    opcion2 VARCHAR(255) NOT NULL,
    opcion3 VARCHAR(255) NOT NULL,
    opcion4 VARCHAR(255) NOT NULL,
    respuestaCorrecta INT NOT NULL,
    FOREIGN KEY (idCategoria) REFERENCES Categoria (id),
    FOREIGN KEY (idUsuario) REFERENCES Usuario (id)
);

CREATE TABLE aparicion_pregunta (
    idUsuario INT not null,
    idPregunta INT not null,
    PRIMARY KEY (idUsuario, idPregunta),
    FOREIGN KEY (idPregunta) REFERENCES Pregunta (id),
    FOREIGN KEY (idUsuario) REFERENCES Usuario (id)
);

CREATE TABLE Trampita (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          idUsuario INT NOT NULL,
                          fechaCompra DATE NOT NULL,
                          utilizada BOOLEAN DEFAULT FALSE,
                          FOREIGN KEY (idUsuario) REFERENCES Usuario (id)
);