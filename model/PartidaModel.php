<?php

class PartidaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getPreguntas()
    {
        return $this->database->query("SELECT * FROM Pregunta");
    }

    public function getPartidas($idUsuario)
    {
        $query = "SELECT p.id, p.fecha, p.idUsuario FROM Partida p WHERE p.idUsuario = $idUsuario";
        return $this->database->query($query);
    }

    public function getLastPartida($idUsuario)
    {
        $query = "SELECT p.id, p.fecha, p.idUsuario 
                  FROM Partida p 
                  WHERE p.idUsuario = $idUsuario 
                  ORDER BY p.id DESC 
                  LIMIT 1";
        return $this->database->query($query);
    }

    public function addPartida($idUsuario)
    {
        $query = "INSERT INTO partida (fecha, idUsuario) VALUES (NOW(), $idUsuario)";
        return $this->database->query($query);
    }

    public function getPregunta($idUsuario)
    {

        $query = "SELECT p.pregunta, p.id as 'idPregunta', o.*, C.nombre as 'categoria' , C.color as color
        FROM Pregunta p
        JOIN Opcion o ON p.idOpcion = o.id
        JOIN categoria C ON p.idCategoria  = C.id
        WHERE p.id NOT IN (
            SELECT up.idPregunta
            FROM usuario_pregunta up
            WHERE up.idUsuario =  $idUsuario
        )
        ORDER BY p.id
        LIMIT 1";
        return $this->database->query($query);
    }

    public function getPreguntaByID($idPregunta)
    {
        $query = "SELECT p.pregunta FROM pregunta p WHERE id = $idPregunta";
        return $this->database->query($query);
    }

    public function createJugada($idPregunta, $idPartida)
    {
        $query = "INSERT INTO Jugada (idPregunta, idPartida, tiempo, respondidoCorrectamente)
                  VALUES ($idPregunta, $idPartida, null, 0)";
        return $this->database->query($query);
    }

    public function updateJugada($idPregunta, $idPartida, $respondidoCorrectamente)
    {
        $query = "UPDATE Jugada
                  SET respondidoCorrectamente = '$respondidoCorrectamente'
                  WHERE idPregunta = $idPregunta AND idPartida = $idPartida";
        return $this->database->query($query);
    }

    public function getRespuestaCorrecta($idPregunta)
    {
        // $query = "SELECT  o.respuestaCorrecta
        $query = "SELECT  o.*
                  FROM Pregunta p
                  INNER JOIN Opcion o ON p.idOpcion = o.id
                  WHERE p.id = $idPregunta";
        return $this->database->query($query);
    }

    public function getUserByNickname($nickname)
    {
        $query = "SELECT u.id
                  FROM Usuario u
                  WHERE u.nickName LIKE '$nickname'";
        return $this->database->query($query);
    }

    public function setPreguntaUsuario($idUsuario, $idPregunta)
    {
        $query = "INSERT INTO usuario_pregunta (idUsuario, idPregunta) VALUES ($idUsuario, $idPregunta)";
        return $this->database->query($query);
    }

    public function getPreguntasUsuario($idUsuario, $idPregunta)
    {
        $query = "SELECT *
                  FROM usuario_pregunta
                  WHERE idUsuario = $idUsuario 
                  AND idPregunta = $idPregunta";
        return  $this->database->query($query);
    }

    public function countRespuestasCorrectas($partidaId)
    {
        $query = "SELECT COUNT(*) AS count
                  FROM Jugada
                  WHERE idPartida = $partidaId AND respondidoCorrectamente = 1";
        $result = $this->database->query($query);
        return $result[0]['count'];
    }

    public function getIDUsuarioActual()
    {
        $nickname = $_SESSION['nickname'];
        $user = $this->getUserByNickname($nickname);
        return $user[0]['id'];
    }

    public function getIDPartidaActual()
    {
        $partida = $this->getLastPartida($this->getIDUsuarioActual());
        $pr = $partida[0];
        return $pr['id'];
    }

    public function updatePuntajePartida($idPartida, $nuevoPuntaje)
    {
        $query = "UPDATE Partida
                  SET puntaje = $nuevoPuntaje
                  WHERE id = $idPartida";
        return $this->database->query($query);
    }

    public function deleteUsuarioPartida($idUsuario)
    {
        $query = "DELETE FROM usuario_pregunta WHERE idUsuario = $idUsuario";
        return $this->database->query($query);
    }

    public function getLastInsertedPreguntaId()
    {
        $query = "SELECT id AS count FROM Pregunta ORDER BY id DESC LIMIT 1";
        $result = $this->database->query($query);
        return $result[0]['count'];
    }

    public function obtenerPuntajeDeLaPartida($idPartida)
    {
        $query = "SELECT puntaje FROM partida WHERE id = $idPartida";
        return $this->database->query($query);
    }

    public function jugarJuego()
    {
        $preguntaId = $_GET['pregunta'];
        $this->createJugada($preguntaId, $this->getIDPartidaActual());
        $idPartida = $this->getIDPartidaActual();
        $data['pregunta'] = $this->getPreguntaByID($preguntaId);
        $lastPreguntaID = $this->getLastInsertedPreguntaId();
        $this->setPreguntaUsuario($this->getIDUsuarioActual(), $preguntaId);
        if (intval($lastPreguntaID) == intval($preguntaId)) {
            $this->deleteUsuarioPartida($this->getIDUsuarioActual());
        }
        $respuestasCorrectas = $this->countRespuestasCorrectas($idPartida);
        $this->updatePuntajePartida($idPartida, $respuestasCorrectas);
        $puntaje = $this->obtenerPuntajeDeLaPartida($idPartida);
        $data['puntaje'] = $puntaje;
    }

    public function juego()
    {
        $arrayDatos = array();
        $idPartida = $this->getIDPartidaActual();
        $preguntaId = $_GET['pregunta'];
        $this->createJugada($preguntaId, $this->getIDPartidaActual());
        $opcionSeleccionada = $_GET['opcion'];
        $respuestaCorrecta = $this->getRespuestaCorrecta($preguntaId);
        if (intval($opcionSeleccionada) == intval($respuestaCorrecta[0]['respuestaCorrecta'])) {
            $arrayDatos['mensaje'] = "CORRECTO";
            $arrayDatos['url'] = "/partida/jugada";
            $arrayDatos['texto'] = "Siguiente Pregunta";
            $this->updateJugada($preguntaId, $idPartida, 1);
        } else {
            $arrayDatos['mensaje'] = "FIN DEL JUEGO. LA RESPUESTA ERA: " . $respuestaCorrecta[0]['opcion' . $respuestaCorrecta[0]['respuestaCorrecta']];
            $arrayDatos['url'] = "/lobby/list";
            $arrayDatos['texto'] = "Volver al Lobby";
            $_SESSION['jugando'] = false;
            $this->updateJugada($preguntaId, $idPartida, 0);
        }
        $lastPreguntaID = $this->getLastInsertedPreguntaId();
        $this->setPreguntaUsuario($this->getIDUsuarioActual(), $preguntaId);
        if (intval($lastPreguntaID) == intval($preguntaId)) {
            $this->deleteUsuarioPartida($this->getIDUsuarioActual());
        }
        $arrayDatos['pregunta'] = $this->getPreguntaByID($preguntaId);
        $respuestasCorrectas = $this->countRespuestasCorrectas($idPartida);
        $this->updatePuntajePartida($idPartida, $respuestasCorrectas);
        $puntaje = $this->obtenerPuntajeDeLaPartida($idPartida);
        $arrayDatos['puntaje'] = $puntaje;
        return array('arrayDatos' => $arrayDatos);
    }



}
