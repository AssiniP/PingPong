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
INSERT INTO Pregunta (pregunta, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias,opcion1,opcion2, opcion3, respuestaCorrecta)
VALUES ('¿Cuál es la capital de Francia?', 1, 1, 0, 0,'Londres', 'Roma', 'Madrid','París');

-- Pregunta 2
INSERT INTO Pregunta (pregunta, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias,opcion1, opcion2, opcion3, respuestaCorrecta)
VALUES ('¿Quién pintó la Mona Lisa?',  4, 1, 0, 0, 'Vincent van Gogh', 'Pablo Picasso', 'Miguel Ángel', 'Leonardo da Vinci');

-- Pregunta 3
INSERT INTO Pregunta (pregunta, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias,opcion1, opcion2, opcion3, respuestaCorrecta)
VALUES ('¿Cuál es el río más largo del mundo?',  2, 1, 0, 0,'Amazonas', 'Misisipi', 'Yangtsé', 'Nilo');

-- Pregunta 4
INSERT INTO Pregunta (pregunta, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias,opcion1, opcion2, opcion3, respuestaCorrecta)
VALUES ('¿Quién descubrió la ley de la gravedad?',  3, 1, 0, 0,'Albert Einstein','Marie Curie', 'Charles Darwin', 'Isaac Newton');

-- Pregunta 5
INSERT INTO Pregunta (pregunta, idCategoria, idUsuario, cantidadAciertos, cantidadOcurrencias,opcion1, opcion2, opcion3, respuestaCorrecta)
VALUES ('¿Quién escribió la obra "Romeo y Julieta"?',  1, 1, 0, 0,'Mario Vargas Llosa', 'Julio Cortázar', 'Pablo Neruda','William Shakespeare');

INSERT INTO paises (nombre) VALUES
                                ('Afganistán'),
                                ('Albania'),
                                ('Argelia'),
                                ('Andorra'),
                                ('Angola'),
                                ('Antigua y Barbuda'),
                                ('Arabia Saudita'),
                                ('Argelia'),
                                ('Argentina'),
                                ('Armenia'),
                                ('Australia'),
                                ('Austria'),
                                ('Azerbaiyán'),
                                ('Bahamas'),
                                ('Bangladés'),
                                ('Barbados'),
                                ('Baréin'),
                                ('Bélgica'),
                                ('Belice'),
                                ('Benín'),
                                ('Bielorrusia'),
                                ('Birmania/Myanmar'),
                                ('Bolivia'),
                                ('Bosnia y Herzegovina'),
                                ('Botsuana'),
                                ('Brasil'),
                                ('Brunéi'),
                                ('Bulgaria'),
                                ('Burkina Faso'),
                                ('Burundi'),
                                ('Bután'),
                                ('Cabo Verde'),
                                ('Camboya'),
                                ('Camerún'),
                                ('Canadá'),
                                ('Catar'),
                                ('Chad'),
                                ('Chile'),
                                ('China'),
                                ('Chipre'),
                                ('Ciudad del Vaticano'),
                                ('Colombia'),
                                ('Comoras'),
                                ('Corea del Norte'),
                                ('Corea del Sur'),
                                ('Costa de Marfil'),
                                ('Costa Rica'),
                                ('Croacia'),
                                ('Cuba'),
                                ('Dinamarca'),
                                ('Dominica'),
                                ('Ecuador'),
                                ('Egipto'),
                                ('El Salvador'),
                                ('Emiratos Árabes Unidos'),
                                ('Eritrea'),
                                ('Eslovaquia'),
                                ('Eslovenia'),
                                ('España'),
                                ('Estados Unidos'),
                                ('Estonia'),
                                ('Esuatini'),
                                ('Etiopía'),
                                ('Fiyi'),
                                ('Filipinas'),
                                ('Finlandia'),
                                ('Francia'),
                                ('Gabón'),
                                ('Gambia'),
                                ('Georgia'),
                                ('Ghana'),
                                ('Granada'),
                                ('Grecia'),
                                ('Guatemala'),
                                ('Guyana'),
                                ('Guinea'),
                                ('Guinea-Bisáu'),
                                ('Guinea Ecuatorial'),
                                ('Haití'),
                                ('Honduras'),
                                ('Hungría'),
                                ('India'),
                                ('Indonesia'),
                                ('Irak'),
                                ('Irán'),
                                ('Irlanda'),
                                ('Islandia'),
                                ('Islas Marshall'),
                                ('Islas Salomón'),
                                ('Israel'),
                                ('Italia'),
                                ('Jamaica'),
                                ('Japón'),
                                ('Jordania'),
                                ('Kazajistán'),
                                ('Kenia'),
                                ('Kirguistán'),
                                ('Kiribati'),
                                ('Kuwait'),
                                ('Laos'),
                                ('Lesoto'),
                                ('Letonia'),
                                ('Líbano'),
                                ('Liberia'),
                                ('Libia'),
                                ('Liechtenstein'),
                                ('Lituania'),
                                ('Luxemburgo'),
                                ('Macedonia del Norte'),
                                ('Madagascar'),
                                ('Malasia'),
                                ('Malaui'),
                                ('Maldivas'),
                                ('Malí'),
                                ('Malta'),
                                ('Marruecos'),
                                ('Mauricio'),
                                ('Mauritania'),
                                ('México'),
                                ('Micronesia'),
                                ('Moldavia'),
                                ('Mónaco'),
                                ('Mongolia'),
                                ('Montenegro'),
                                ('Mozambique'),
                                ('Namibia'),
                                ('Nauru'),
                                ('Nepal'),
                                ('Nicaragua'),
                                ('Níger'),
                                ('Nigeria'),
                                ('Noruega'),
                                ('Nueva Zelanda'),
                                ('Omán'),
                                ('Países Bajos'),
                                ('Pakistán'),
                                ('Palaos'),
                                ('Panamá'),
                                ('Papúa Nueva Guinea'),
                                ('Paraguay'),
                                ('Perú'),
                                ('Polonia'),
                                ('Portugal'),
                                ('Reino Unido'),
                                ('República Centroafricana'),
                                ('República Checa'),
                                ('República del Congo'),
                                ('República Democrática del Congo'),
                                ('República Dominicana'),
                                ('Ruanda'),
                                ('Rumania'),
                                ('Rusia'),
                                ('Samoa'),
                                ('San Cristóbal y Nieves'),
                                ('San Marino'),
                                ('San Vicente y las Granadinas'),
                                ('Santa Lucía'),
                                ('Santo Tomé y Príncipe'),
                                ('Senegal'),
                                ('Serbia'),
                                ('Seychelles'),
                                ('Sierra Leona'),
                                ('Singapur'),
                                ('Siria'),
                                ('Somalia'),
                                ('Sri Lanka'),
                                ('Suazilandia'),
                                ('Sudáfrica'),
                                ('Sudán'),
                                ('Sudán del Sur'),
                                ('Suecia'),
                                ('Suiza'),
                                ('Surinam'),
                                ('Tailandia'),
                                ('Taiwán'),
                                ('Tanzania'),
                                ('Tayikistán'),
                                ('Togo'),
                                ('Tonga'),
                                ('Trinidad y Tobago'),
                                ('Túnez'),
                                ('Turkmenistán'),
                                ('Turquía'),
                                ('Tuvalu'),
                                ('Ucrania'),
                                ('Uganda'),
                                ('Uruguay'),
                                ('Uzbekistán'),
                                ('Vanuatu'),
                                ('Venezuela'),
                                ('Vietnam'),
                                ('Yemen'),
                                ('Yibuti'),
                                ('Zambia'),
                                ('Zimbabue');

INSERT INTO `pingpong`.`meses` (`id`, `numero`, `nombre`) VALUES ('1', '1', 'Enero');
INSERT INTO `pingpong`.`meses` (`id`, `numero`, `nombre`) VALUES ('2', '2', 'Febrero');
INSERT INTO `pingpong`.`meses` (`id`, `numero`, `nombre`) VALUES ('3', '3', 'Marzo');
INSERT INTO `pingpong`.`meses` (`id`, `numero`, `nombre`) VALUES ('4', '4', 'Abril');
INSERT INTO `pingpong`.`meses` (`id`, `numero`, `nombre`) VALUES ('5', '5', 'Mayo');
INSERT INTO `pingpong`.`meses` (`id`, `numero`, `nombre`) VALUES ('6', '6', 'Junio');
INSERT INTO `pingpong`.`meses` (`id`, `numero`, `nombre`) VALUES ('7', '7', 'Julio');
INSERT INTO `pingpong`.`meses` (`id`, `numero`, `nombre`) VALUES ('8', '8', 'Agosto');
INSERT INTO `pingpong`.`meses` (`id`, `numero`, `nombre`) VALUES ('9', '9', 'Septiembre');
INSERT INTO `pingpong`.`meses` (`id`, `numero`, `nombre`) VALUES ('10', '10', 'Octubre');
INSERT INTO `pingpong`.`meses` (`id`, `numero`, `nombre`) VALUES ('11', '11', 'Noviembre');
INSERT INTO `pingpong`.`meses` (`id`, `numero`, `nombre`) VALUES ('12', '12', 'Diciembre');
