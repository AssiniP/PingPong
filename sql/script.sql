CREATE DATABASE pingPong;

USE pingPong;

create table rol (
id int  auto_increment primary key,
rol  varchar(150) not null
);

create table genero (
id int  auto_increment primary key,
nombre  varchar(150) not null
);


CREATE TABLE usuario (
id int auto_increment primary key,
nickName varchar(50) not null,
password varchar(50) not null,
nombre varchar(150) not null,
email  varchar(150) not null,
ubicacion  varchar(150) not null,
imagenPerfil  varchar(150) not null,
pais  varchar(150) not null,
ciudad  varchar(150) not null,
idRol int not null, 
fecharegistro date,
idGenero int not null,
FOREIGN KEY (idGenero) REFERENCES genero(id),
FOREIGN KEY (idRol) references rol(id)
);