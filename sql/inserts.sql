USE pingPong;



insert into rol (rol) values ('Administrador');
insert into rol (rol) values ('Editor');
insert into rol (rol) values ('Jugador');

insert into genero (nombre) values ('Masculino');
insert into genero (nombre) values ('Femenino');
insert into genero (nombre) values ('Prefiero no cargarlo');

INSERT INTO Categoria (nombre,color) VALUES ('Historia','#4BA3C3');
INSERT INTO Categoria (nombre,color) VALUES ('Geografía','#175676');
INSERT INTO Categoria (nombre,color) VALUES ('Ciencia','pink');
INSERT INTO Categoria (nombre,color) VALUES ('Arte','orange');
INSERT INTO Categoria (nombre,color) VALUES ('Deportes','green');


INSERT INTO pingpong.usuario (nickName, password, nombre, email, imagenPerfil, pais, ciudad, idRol, cuentaValida,idGenero, fechaNacimiento, latitud, longitud)
VALUES ( 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin@mail.com', 'admin.jpg', 'Argentina', 'San Justo', '1', '1', '3','1974-05-25',-58.5614947,-34.6686986);
INSERT INTO pingpong.usuario (nickName, password, nombre, email, imagenPerfil, pais, ciudad, idRol, cuentaValida,idGenero, fechaNacimiento, latitud, longitud)
VALUES ( 'user', '202cb962ac59075b964b07152d234b70', 'usuario de prueba', 'user@gmail.com', 'user.jpg', 'Argentina', 'San Justo', '3', '1', '2','1989-05-25',-58.5614947,-34.6686986);
INSERT INTO pingpong.usuario (nickName, password, nombre, email, imagenPerfil, pais, ciudad, idRol, cuentaValida,idGenero, fechaNacimiento, latitud, longitud)
VALUES ( 'editor', '202cb962ac59075b964b07152d234b70', 'editor', 'editor@gmail.com', 'editor.jpg', 'Argentina', 'San Justo', '2', '1', '2','1989-05-25',-58.5614947,-34.6686986);
-- Pregunta 1
INSERT INTO Pregunta (pregunta, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias,opcion1,opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('¿Cuál es la capital de Francia?', 1, 1, 0, 0,'París', 'Londres', 'Roma', 'Madrid', 1);

-- Pregunta 2
INSERT INTO Pregunta (pregunta, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias,opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('¿Quién pintó la Mona Lisa?',  4, 1, 0, 0,'Leonardo da Vinci', 'Vincent van Gogh', 'Pablo Picasso', 'Miguel Ángel', 1);

-- Pregunta 3
INSERT INTO Pregunta (pregunta, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias,opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('¿Cuál es el río más largo del mundo?',  2, 1, 0, 0,'Amazonas', 'Nilo', 'Misisipi', 'Yangtsé', 2);

-- Pregunta 4
INSERT INTO Pregunta (pregunta, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias,opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('¿Quién descubrió la ley de la gravedad?',  3, 1, 0, 0,'Albert Einstein', 'Isaac Newton', 'Marie Curie', 'Charles Darwin', 2);

-- Pregunta 5
INSERT INTO Pregunta (pregunta, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias,opcion1, opcion2, opcion3, opcion4, respuestaCorrecta)
VALUES ('¿Quién escribió la obra "Romeo y Julieta"?',  1, 1, 0, 0,'William Shakespeare', 'Mario Vargas Llosa', 'Julio Cortázar', 'Pablo Neruda', 1);
