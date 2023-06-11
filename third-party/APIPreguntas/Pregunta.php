<?php

include_once "MySQLMethods.php";

class Pregunta extends MySQLMethods
{

    function obtenerPreguntas($id)
    {

        $query = $this->connect()->query("SELECT * FROM pregunta p where p.id  NOT IN (
            SELECT up.idPregunta
            FROM usuario_pregunta up
            WHERE up.idUsuario = " . $id . ")");
        return $query;
    }

    function obtenerOpcionesById($id)
    {
        $query = $this->connect()->query('SELECT * FROM opcion where id=' . $id);
        return $query;
    }

    function borrarPregunta($idOpcion)
    {
        $query = $this->connect()->query('delete pregunta,opcion from pregunta join opcion on opcion.id=pregunta.idOpcion where opcion.id=' . $idOpcion);
        return $query;
    }

    function obtenerPreguntaConPregunta($pregunta)
    {
        $query = $this->connect()->query('select pregunta from pregunta where pregunta=' . $pregunta);
        return $query;
    }

    function obtenerPreguntaConId($id)
    {
        $query = $this->connect()->query('select * from pregunta where id=' . $id);
        return $query;
    }

    function darDeAltaPregunta($pregunta, $opcion1, $opcion2, $opcion3, $opcion4, $correcta, $categoria, $usuario)
    {
        $idUsuario = $this->obtenerIdUsuario($usuario);
        $idCategoria = $this->obtenerIdCategoria($categoria);
        $idOpcion = $this->darDeAltaOpcion($opcion1, $opcion2, $opcion3, $opcion4, $correcta);
        $this->connect()->query("insert into pregunta (pregunta,idOpcion,idCategoria,idUsuario,cantidadAciertos,cantidadOcurrencias) VALUES ('" . $pregunta . "','" . $idOpcion . "','" . $idCategoria . "','" . $idUsuario . "0,0)");
        return "se agrego pregunta";
    }

    function darDeAltaOpcion($opcion1, $opcion2, $opcion3, $opcion4, $correcta)
    {
        $this->connect()->query("insert into opcion (opcion1,opcion2,opcion3,opcion4,repuestaCorrecta) VALUES('" . $opcion1 . "', '" . $opcion2 . "','" . $opcion3 . "','" . $opcion4 . "','" . $correcta . "')");
        $id = $this->connect()->query("select id from opcion where opcion1 LIKE '" . $opcion1 . "' and opcion2 like '" . $opcion2 . "' and opcion3 LIKE '" . $opcion3 . "' and opcion4 like '" . $opcion4 . "'");
        return $id;
    }

    function obtenerIdCategoria($categoria)
    {
        $id = $this->connect()->query("select id from categoria where nombre like '" . $categoria . "'");
        return $id;
    }

    function obtenerIdUsuario($usuario)
    {
        $id = $this->connect()->query("select id from usuario where nickName like '" . $usuario . "'");
        return $id;
    }

    function  obtenerCategoriaById($id){
        $categoria = $this->connect()->query("select * from categoria where id = " . $id );
        return $categoria;
    }
}
