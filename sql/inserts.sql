USE pingPong;

insert into rol (rol) values ('Administrador');
insert into rol (rol) values ('Editor');
insert into rol (rol) values ('Jugador');

insert into genero (nombre) values ('Masculino');
insert into genero (nombre) values ('Femenino');
insert into genero (nombre) values ('Prefiero no cargarlo');

INSERT INTO Categoria (nombre) VALUES ('Historia');
INSERT INTO Categoria (nombre) VALUES ('Geografía');
INSERT INTO Categoria (nombre) VALUES ('Ciencia');
INSERT INTO Categoria (nombre) VALUES ('Arte');
INSERT INTO Categoria (nombre) VALUES ('Deportes');

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
VALUES ('Albert Einstein', 'Isaac Newton', 'Marie Curie', 'Charles Darwin', 1);

-- Opciones para la pregunta 5
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('Gabriel García Márquez', 'Mario Vargas Llosa', 'Julio Cortázar', 'Pablo Neruda', 1);

-- Opciones para la pregunta 6
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('Fútbol', 'Béisbol', 'Baloncesto', 'Hockey', 1);

-- Opciones para la pregunta 7
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('1945', '1939', '1941', '1943', 2);

-- Opciones para la pregunta 8
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('Au', 'Ag', 'Hg', 'Au', 3);

-- Opciones para la pregunta 9
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('William Shakespeare', 'Federico García Lorca', 'Miguel de Cervantes', 'Oscar Wilde', 3);

-- Opciones para la pregunta 10
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('Rusia', 'Canadá', 'China', 'Estados Unidos', 2);

-- Opciones para la pregunta 11
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('Thomas Edison', 'Nikola Tesla', 'Alexander Graham Bell', 'Benjamin Franklin', 1);

-- Opciones para la pregunta 12
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('Cubismo', 'Impresionismo', 'Expresionismo', 'Realismo', 1);

-- Opciones para la pregunta 13
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('Fútbol', 'Voleibol', 'Tenis', 'Baloncesto', 1);

-- Opciones para la pregunta 14
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('1624', '1789', '1626', '1846', 3);

-- Opciones para la pregunta 15
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('C', 'O', 'Ca', 'Co', 3);

-- Opciones para la pregunta 16
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('William Shakespeare', 'Miguel de Cervantes', 'Gabriel García Márquez', 'Jorge Luis Borges', 2);

-- Opciones para la pregunta 17
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('China', 'India', 'Estados Unidos', 'Rusia', 1);

-- Opciones para la pregunta 18
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('Alexander Fleming', 'Louis Pasteur', 'Marie Curie', 'Albert Einstein', 1);

-- Opciones para la pregunta 19
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('La última cena', 'La noche estrellada', 'La persistencia de la memoria', 'La Gioconda', 4);

-- Opciones para la pregunta 20
INSERT INTO Opcion (opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('Golf', 'Bádminton', 'Tenis', 'Bolos', 3);

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

-- Pregunta 6
INSERT INTO Pregunta (pregunta, idOpcion, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias)
VALUES ('¿Cuál es el deporte más popular en el mundo?', 6, 5, 100, 0, 0);

-- Pregunta 7
INSERT INTO Pregunta (pregunta, idOpcion, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias)
VALUES ('¿En qué año se fundó Estados Unidos?', 7, 2, 100, 0, 0);

-- Pregunta 8
INSERT INTO Pregunta (pregunta, idOpcion, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias)
VALUES ('¿Cuál es el símbolo químico del oro?', 8, 3, 100, 0, 0);

-- Pregunta 9
INSERT INTO Pregunta (pregunta, idOpcion, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias)
VALUES ('¿Quién escribió la novela "Don Quijote de la Mancha"?', 9, 1, 100, 0, 0);

-- Pregunta 10
INSERT INTO Pregunta (pregunta, idOpcion, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias)
VALUES ('¿Cuál es el país más grande del mundo?', 10, 2, 100, 0, 0);

-- Pregunta 11
INSERT INTO Pregunta (pregunta, idOpcion, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias)
VALUES ('¿Quién descubrió la penicilina?', 11, 3, 100, 0, 0);

-- Pregunta 12
INSERT INTO Pregunta (pregunta, idOpcion, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias)
VALUES ('¿Cuál es el movimiento artístico que se caracteriza por el uso de formas geométricas y múltiples perspectivas?', 12, 4, 100, 0, 0);

-- Pregunta 13
INSERT INTO Pregunta (pregunta, idOpcion, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias)
VALUES ('¿Cuál es el deporte más popular en Brasil?', 13, 5, 100, 0, 0);

-- Pregunta 14
INSERT INTO Pregunta (pregunta, idOpcion, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias)
VALUES ('¿En qué año terminó la Segunda Guerra Mundial?', 14, 2, 100, 0, 0);

-- Pregunta 15
INSERT INTO Pregunta (pregunta, idOpcion, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias)
VALUES ('¿Cuál es el símbolo químico del calcio?', 15, 3, 100, 0, 0);

-- Pregunta 16
INSERT INTO Pregunta (pregunta, idOpcion, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias)
VALUES ('¿Quién escribió la obra "Don Quijote de la Mancha"?', 16, 1, 100, 0, 0);

-- Pregunta 17
INSERT INTO Pregunta (pregunta, idOpcion, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias)
VALUES ('¿Cuál es el país más poblado del mundo?', 17, 2, 100, 0, 0);

-- Pregunta 18
INSERT INTO Pregunta (pregunta, idOpcion, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias)
VALUES ('¿Quién descubrió la penicilina?', 18, 3, 100, 0, 0);

-- Pregunta 19
INSERT INTO Pregunta (pregunta, idOpcion, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias)
VALUES ('¿Cuál es la famosa pintura de Leonardo da Vinci que muestra a una mujer sonriendo?', 19, 4, 100, 0, 0);

-- Pregunta 20
INSERT INTO Pregunta (pregunta, idOpcion, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias)
VALUES ('¿Cuál es el deporte que se juega con una raqueta y una pelota?', 20, 5, 100, 0, 0);