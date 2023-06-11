<?php
include_once 'Pregunta.php';
class ApiPreguntas
{
    function getAll($idUsuario)
    {

        $pregunta = new Pregunta();
        $preguntas = array();
        $preguntas["preguntas"] = array();


        $res = $pregunta->obtenerpreguntas($idUsuario);

        if ($res->rowCount()) {
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $opciones = json_decode($this->getAllOptionsById($row['idOpcion']), true);
                $categoria = $this->getCategory($row['idCategoria']);
                //var_dump($opciones);
                $item = array(
                    "id" => $row['id'],
                    "pregunta" => $row['pregunta'],
                    "opciones" => [$opciones],
                    "categoria"=> $categoria
                );
                array_push($preguntas["preguntas"], $item);
            }

            echo json_encode($preguntas);
        } else {
            echo json_encode(array('mensaje' => 'No hay elementos'));
        }
    }

    function getAllOptionsById($id)
    {
        $pregunta = new Pregunta();

        $res = $pregunta->obtenerOpcionesById($id);

        if ($res->rowCount()) {
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {

                $item = array(
                    "opcion_1" => $row['opcion1'],
                    "opcion_2" => $row['opcion2'],
                    "opcion_3" => $row['opcion3'],
                    "opcion_4" => $row['opcion4'],
                    "repuesta_correcta" => $row['respuestaCorrecta']
                );
            }

            return json_encode($item);
        } else {
            return json_encode(array('mensaje' => 'No hay elementos'));
        }
    }

    function getCategory($id)
    {
        $pregunta = new Pregunta();

        $res = $pregunta->obtenerCategoriaById($id);
        if ($res->rowCount()) {
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $item = array(
                    "nombre" => $row['nombre'],
                    "color" => $row['color']
                );
            }

            return $item;
        } else {
            return json_encode(array('mensaje' => 'No existen categorias con el id buscado.'));
        }
    }
}
