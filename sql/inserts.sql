USE pingPong;

insert into rol (rol) values ('Administrador');
insert into rol (rol) values ('Editor');
insert into rol (rol) values ('Jugador');

insert into genero (nombre) values ('Masculino');
insert into genero (nombre) values ('Femenino');
insert into genero (nombre) values ('Prefiero no cargarlo');

INSERT INTO Categoria (nombre) VALUES ('Historia','#4BA3C3');
INSERT INTO Categoria (nombre) VALUES ('Geografía','#175676');
INSERT INTO Categoria (nombre) VALUES ('Ciencia','yellow');
INSERT INTO Categoria (nombre) VALUES ('Arte','orange');
INSERT INTO Categoria (nombre) VALUES ('Deportes','green');

INSERT INTO `pingpong`.`usuario` (`id`, `nickName`, `password`, `nombre`, `email`, `ubicacion`, `imagenPerfil`, `pais`, `ciudad`, `idRol`, `cuentaValida`, `idGenero`,`fecharegistro`) VALUES ('100', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin@mail.com', 'admin', '', 'admin', 'admin', '1', '1', '3',now());

-- Opciones para la pregunta 1
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('París', 'Londres', 'Roma', 'Madrid', 1);

-- Opciones para la pregunta 2
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('Leonardo da Vinci', 'Vincent van Gogh', 'Pablo Picasso', 'Miguel Ángel', 1);

-- Opciones para la pregunta 3
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('Amazonas', 'Nilo', 'Misisipi', 'Yangtsé', 2);

-- Opciones para la pregunta 4
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('Albert Einstein', 'Isaac Newton', 'Marie Curie', 'Charles Darwin', 2);

-- Opciones para la pregunta 5
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('William Shakespeare', 'Mario Vargas Llosa', 'Julio Cortázar', 'Pablo Neruda', 1);


-- Pregunta 1
INSERT INTO Pregunta (pregunta, idOpcion, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias)
VALUES ('¿Cuál es la capital de Francia?', 1, 1, 100, 0, 0);

-- Pregunta 2
INSERT INTO Pregunta (pregunta, idOpcion, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias)
VALUES ('¿Quién pintó la Mona Lisa?', 2, 4, 100, 0, 0);

-- Pregunta 3
INSERT INTO Pregunta (pregunta, idOpcion, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias)
VALUES ('¿Cuál es el río más largo del mundo?', 3, 2, 100, 0, 0);

-- Pregunta 4
INSERT INTO Pregunta (pregunta, idOpcion, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias)
VALUES ('¿Quién descubrió la ley de la gravedad?', 4, 3, 100, 0, 0);

-- Pregunta 5
INSERT INTO Pregunta (pregunta, idOpcion, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias)
VALUES ('¿Quién escribió la obra "Romeo y Julieta"?', 5, 1, 100, 0, 0);
