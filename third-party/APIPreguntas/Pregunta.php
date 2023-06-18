<?php

include_once "MySQLMethods.php";

class Pregunta extends MySQLMethods
{

    function obtenerPreguntas($id)
    {

        $query = $this->connect()->query("SELECT * FROM pregunta p where p.id NOT IN (select idPregunta from aparicion_pregunta where idUsuario =" .$id ." )");
        return $query;
    }



    function borrarPregunta($id)
    {
        $query = "DELETE FROM pregunta WHERE id = :id";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return "Se eliminó la pregunta.";
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

    function darDeAltaPregunta($pregunta, $opcion1, $opcion2, $opcion3, $correcta, $categoria, $usuario)
    {
        $idUsuario = $this->obtenerIdUsuario($usuario);
        $idCategoria = $this->obtenerIdCategoria($categoria);

        $query = "INSERT INTO pregunta (idCategoria, idUsuario, pregunta, opcion1, opcion2, opcion3, respuestaCorrecta, cantidadAciertos, cantidadOcurrencias) VALUES (:idCategoria, :idUsuario, :pregunta, :opcion1, :opcion2, :opcion3,  :correcta, 0, 0)";

        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(':idCategoria', $idCategoria);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->bindParam(':pregunta', $pregunta);
        $stmt->bindParam(':opcion1', $opcion1);
        $stmt->bindParam(':opcion2', $opcion2);
        $stmt->bindParam(':opcion3', $opcion3);
        $stmt->bindParam(':correcta', $correcta);

        $stmt->execute();

        return "Se agregó la pregunta.";
    }


    function obtenerIdCategoria($categoria)
    {
        $query = "SELECT id FROM categoria WHERE nombre LIKE :categoria";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $row['id'];
        return $id;
    }


    function obtenerIdUsuario($usuario)
    {
        $query = "SELECT id FROM usuario WHERE nickName LIKE :usuario";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $row['id'];
        return $id;
    }

    function  obtenerCategoriaById($id){
        $categoria = $this->connect()->query("select * from categoria where id = " . $id );
        return $categoria;
    }

    function modificarPregunta($id,$pregunta, $opcion1, $opcion2, $opcion3, $respuestaCorrecta, $categoria)
    {
        $idCategoria = $this->obtenerIdCategoria($categoria);
        $query = "UPDATE pregunta SET pregunta = :pregunta, opcion1 = :opcion1, opcion2 = :opcion2, opcion3 = :opcion3, respuestaCorrecta = :respuestaCorrecta, idCategoria = :idCategoria where id = ". $id;
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(':pregunta', $pregunta);
        $stmt->bindParam(':opcion1', $opcion1);
        $stmt->bindParam(':opcion2', $opcion2);
        $stmt->bindParam(':opcion3', $opcion3);
        $stmt->bindParam(':respuestaCorrecta', $respuestaCorrecta);
        $stmt->bindParam(':idCategoria', $idCategoria);
        $stmt->execute();

        return "se modifico la pregunta " . $pregunta ;
    }
}
