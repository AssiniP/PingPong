<?php
include_once 'Pregunta.php';
class ApiPreguntas
{
    function getAll($id)
    {

        $pregunta = new Pregunta();
        $preguntas = array();
        $preguntas["preguntas"] = array();


        $res = $pregunta->obtenerpreguntas($id);

        if ($res->rowCount()) {
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {

                $categoria = $this->getCategory($row['idCategoria']);

                $item = array(
                    "id" => $row['id'],
                    "pregunta" => $row['pregunta'],
                    "opciones" => [
                        "opcion_1"=>$row['opcion1'],
                        "opcion_2"=>$row['opcion2'],
                        "opcion_3"=>$row['opcion3'],
                        "respuesta_correcta"=>$row['respuestaCorrecta']
                    ],
                    "categoria"=> $categoria
                );
                array_push($preguntas["preguntas"], $item);
            }

            return json_encode($preguntas);
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

    function altaPregunta($pregunta,$opcion1,$opcion2,$opcion3,$respuestaCorrecta,$categoria,$usuario){
        $preguntaClass = new Pregunta();

      return  json_encode(array('mensaje'=> $preguntaClass->darDeAltaPregunta($pregunta,$opcion1,$opcion2,$opcion3,$respuestaCorrecta,$categoria,$usuario)));
    }

    function bajaPregunta($idPregunta){
        $preguntaClass = new Pregunta();
        return  json_encode(array('mensaje'=> $preguntaClass->borrarPregunta($idPregunta)));
    }

    function modificarPregunta($idPregunta,$pregunta,$opcion1,$opcion2,$opcion3,$respuestaCorrecta,$categoria){
        $preguntaClass = new Pregunta();
        return  json_encode(array('mensaje'=> $preguntaClass->modificarPregunta($idPregunta,$pregunta,$opcion1,$opcion2,$opcion3,$respuestaCorrecta,$categoria)));
    }

    function getUsuarioByID($id){
        $pregunta = new Pregunta();

        $res = $pregunta->obtenerUsuario($id);
        if ($res->rowCount()) {
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $item = array(
                    "nick" => $row['nickName']
                );
            }

            return $item;
        } else {
            return json_encode(array('mensaje' => 'No existen categorias con el id buscado.'));
        }
    }

    function obtenerUnaPreguntaPorUsuario($id){
        $res = json_decode($this->getAll($id), true);

        return json_encode($res['preguntas'][0]);

    }
}
