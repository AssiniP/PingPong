<?php

class PartidaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
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
        $query = "SELECT  p.respuestaCorrecta   FROM Pregunta p
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
        $query = "INSERT INTO aparicion_pregunta (idUsuario, idPregunta) VALUES ($idUsuario, $idPregunta)";
        return $this->database->query($query);
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
        $query = "DELETE FROM aparicion_pregunta WHERE idUsuario = $idUsuario";
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
    public function incrementarOcurrenciasDePregunta($idPregunta)
    {
        $query = "SELECT cantidadOcurrencias FROM Pregunta WHERE id = $idPregunta";
        $result = $this->database->query($query);
        if (!empty($result) && isset($result[0]['cantidadOcurrencias'])) {
            $ocurrencias = $result[0]['cantidadOcurrencias'];
            $ocurrencias++;
            $query = "UPDATE Pregunta SET cantidadOcurrencias = $ocurrencias WHERE id = $idPregunta";
            return $this->database->query($query);
        }
        return false;
    }

    public function incrementarCantidadAciertosPreguntaGeneral($idPregunta)
    {
        $query = "SELECT cantidadAciertos FROM Pregunta WHERE id = $idPregunta";
        $result = $this->database->query($query);
        if (!empty($result) && isset($result[0]['cantidadAciertos'])) {
            $aciertos = $result[0]['cantidadAciertos'];
            $aciertos++;
            $query = "UPDATE Pregunta SET cantidadAciertos = $aciertos WHERE id = $idPregunta";
            return $this->database->query($query);
        }
        return false;
    }

    public function incrementarAparicionesPreguntaParaUsuario($idUsuario, $idPregunta)
    {
        $query = "SELECT ocurrencias FROM usuario_pregunta WHERE idUsuario = $idUsuario AND idPregunta = $idPregunta";
        $result = $this->database->query($query);
        if (!empty($result) && isset($result[0]['ocurrencias'])) {
            $apariciones = $result[0]['ocurrencias'];
            $apariciones++;
            $query = "UPDATE usuario_pregunta SET ocurrencias = $apariciones WHERE idUsuario = $idUsuario AND idPregunta = $idPregunta";
            return $this->database->query($query);
        }
        return false;
    }

    public function incrementarAciertosPreguntaParaUsuario($idUsuario, $idPregunta)
    {
        $query = "SELECT aciertos FROM usuario_pregunta WHERE idUsuario = $idUsuario AND idPregunta = $idPregunta";
        $result = $this->database->query($query);
        if (!empty($result) && isset($result[0]['aciertos'])) {
            $aciertos = $result[0]['aciertos'];
            $aciertos++;
            $query = "UPDATE usuario_pregunta SET aciertos = $aciertos WHERE idUsuario = $idUsuario AND idPregunta = $idPregunta";
            return $this->database->query($query);
        }
        return false;
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
        $usuarioId = $this->getIDUsuarioActual();
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
            /* aumentar cantidadDeAciertos en las 2 tablas */
            $this->incrementarCantidadAciertosPreguntaGeneral($preguntaId);
            $this->incrementarAciertosPreguntaParaUsuario($usuarioId, $preguntaId);
            /* en la tabla usuario_pregunta se requiere eliminar el delete posterior para q las estadisticas funcionen*/
        } else {
            $arrayDatos['mensaje'] = "FIN DEL JUEGO. LA RESPUESTA ERA: " . $respuestaCorrecta[0]['opcion' . $respuestaCorrecta[0]['respuestaCorrecta']];
            $arrayDatos['url'] = "/lobby/list";
            $arrayDatos['texto'] = "Volver al Lobby";
            $_SESSION['jugando'] = false;
            $this->updateJugada($preguntaId, $idPartida, 0);
        }
        $this->incrementarOcurrenciasDePregunta($preguntaId);
        $this->incrementarAparicionesPreguntaParaUsuario($usuarioId, $preguntaId);
        $lastPreguntaID = $this->getLastInsertedPreguntaId();
        $this->setPreguntaUsuario($usuarioId, $preguntaId);
        if (intval($lastPreguntaID) == intval($preguntaId)) {
            $this->deleteUsuarioPartida($usuarioId);
        }
        $arrayDatos['pregunta'] = $this->getPreguntaByID($preguntaId);
        $respuestasCorrectas = $this->countRespuestasCorrectas($idPartida);
        $this->updatePuntajePartida($idPartida, $respuestasCorrectas);
        $puntaje = $this->obtenerPuntajeDeLaPartida($idPartida);
        $arrayDatos['puntaje'] = $puntaje;
        return array('arrayDatos' => $arrayDatos);
    }
}