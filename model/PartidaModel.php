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
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $tiempoActual = date("H:i:s");
        $query = "INSERT INTO Jugada (idPregunta, idPartida, tiempo, respondidoCorrectamente)
                  VALUES ($idPregunta, $idPartida, '$tiempoActual', 0)";
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
        $query = "SELECT  p.opcion1, p.opcion2, p.opcion3,p.respuestaCorrecta   FROM Pregunta p
                  WHERE p.id =". $idPregunta;
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

    public function empezarJugada($preguntaID){
        $usuarioId = $this->getIDUsuarioActual();
        $idPartida = $this->getIDPartidaActual();
        $this->createJugada($preguntaID, $this->getIDPartidaActual());
    }

    public function createUsuarioPregunta($idUsuario, $idPregunta){
        $query = "SELECT COUNT(*) as 'existe' FROM usuario_pregunta WHERE idUsuario = '".$idUsuario."' AND idPregunta = '".$idPregunta."';";
        $result = $this->database->query($query);

        if ($result[0]['existe'] == 0) {
            $query = "INSERT INTO usuario_pregunta (idUsuario, idPregunta) VALUES ('".$idUsuario."', '".$idPregunta."');";
            $this->database->query($query);
        }
    }

    public function juego()
    {
        $preguntaId = $_GET['pregunta'];
        $usuarioId = $this->getIDUsuarioActual();
        $idPartida = $this->getIDPartidaActual();
        $arrayDatos = array();
        $opcionSeleccionada = $_GET['opcion'];
        $respuestaCorrecta = $this->getRespuestaCorrecta($preguntaId);
        $this->createUsuarioPregunta($usuarioId, $preguntaId);
        $this->incrementarOcurrenciasDePregunta($preguntaId);
        $this->incrementarAparicionesPreguntaParaUsuario($usuarioId, $preguntaId);
        if ($opcionSeleccionada == $respuestaCorrecta[0]['respuestaCorrecta'] && $this->respondioATiempo($preguntaId, $idPartida)) {
            $arrayDatos['mensaje'] = "CORRECTO";
            $arrayDatos['url'] = "/partida/jugada";
            $arrayDatos['texto'] = "Siguiente Pregunta";
            $this->updateJugada($preguntaId, $idPartida, 1);
            /* aumentar cantidadDeAciertos en las 2 tablas */
            $this->incrementarCantidadAciertosPreguntaGeneral($preguntaId);
            $this->incrementarAciertosPreguntaParaUsuario($usuarioId, $preguntaId);
            /* en la tabla usuario_pregunta se requiere eliminar el delete posterior para q las estadisticas funcionen*/
        } else {
            $arrayDatos['mensaje'] = "FIN DEL JUEGO. LA RESPUESTA ERA: " .$respuestaCorrecta[0]['respuestaCorrecta'];
            $arrayDatos['url'] = "/lobby/list";
            $arrayDatos['texto'] = "Volver al Lobby";
            $_SESSION['jugando'] = false;
            $this->updateJugada($preguntaId, $idPartida, 0);
            $this->calculoDificultadDePregunta($preguntaId);
            $this->calculoHabilidadDelUser($usuarioId);
        }
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
        $arrayDatos['preguntaId'] = $preguntaId;
        $arrayDatos['usuarioId'] = $usuarioId;
        return array('arrayDatos' => $arrayDatos);
    }
    private function calculoDificultadDePregunta($preguntaId){
        $query = "SELECT cantidadAciertos as 'aciertos' FROM pregunta WHERE id = '".$preguntaId."';";
        $result = $this->database->query($query);
        $aciertos = intval($result[0]["aciertos"]);
        $query = "SELECT cantidadOcurrencias as 'ocurrencias' FROM pregunta WHERE id = '".$preguntaId."';";
        $result = $this->database->query($query);
        $ocurrencias = intval($result[0]["ocurrencias"]);
        $resultado = $aciertos/$ocurrencias;
        if(intval($resultado) == 0.5){
            $dificultad = "MEDIO";
        }else if(intval($resultado) < 0.5){
            $dificultad = "DIFICIL";
        } else{
            $dificultad = "FACIL";
        }
        $this->cambioDificultadDePregunta($preguntaId, $dificultad);
    }

    private function cambioDificultadDePregunta($preguntaId, $dificultad){
        $query = "UPDATE pregunta SET dificultad = '".$dificultad."' WHERE id = '".$preguntaId."';";
        $this->database->query($query);
    }

    private function calculoHabilidadDelUser($usuarioId){
        $query = "SELECT SUM(cantidadOcurrencias) AS totalOcurrencias FROM pregunta";
        $result = $this->database->query($query);
        $totalOcurrencias = intval($result[0]["totalOcurrencias"]);

        $query = "SELECT SUM(cantidadAciertos) AS totalAciertos FROM pregunta";
        $result = $this->database->query($query);
        $totalAciertos = intval($result[0]["totalAciertos"]);

        $query = "SELECT SUM(ocurrencias) AS usuarioOcurrencias FROM usuario_pregunta WHERE idUsuario = '" . $usuarioId . "'";
        $result = $this->database->query($query);
        $usuarioOcurrencias = intval($result[0]["usuarioOcurrencias"]);

        $query = "SELECT SUM(aciertos) AS usuarioAciertos FROM usuario_pregunta WHERE idUsuario = '" . $usuarioId . "'";
        $result = $this->database->query($query);
        $usuarioAciertos = intval($result[0]["usuarioAciertos"]);

        $proporcionAciertos = ($usuarioAciertos / $totalAciertos);

        $proporcionOcurrencias = ($usuarioOcurrencias / $totalOcurrencias);

        if ($proporcionAciertos > 0.5 && $proporcionOcurrencias > 0.5) {
            $categoria = "EXPERTO";
        } elseif ($proporcionAciertos == 0.5 && $proporcionOcurrencias == 0.5) {
            $categoria = "HABIL";
        } else {
            $categoria = "PRINCIPIANTE";
        }

        $this->cambioCategoriaDeUsuario($usuarioId, $categoria);
    }

    private function cambioCategoriaDeUsuario($usuarioId, $categoria){
        $query = "UPDATE usuario SET nivelJugador = '".$categoria."' WHERE id = '".$usuarioId."';";
        $this->database->query($query);
    }

    public function reportarPregunta($motivo, $idUsuario, $idPregunta){
        $reportData = [
            'motivo' => $motivo,
            'idUsuario' => $idUsuario,
            'idPregunta' => $idPregunta
        ];
        $query = "INSERT INTO preguntaReportada (motivo, idUsuario, idPregunta, fecha) VALUES (?, ?, ?, NOW())";
        $this->database->reportarPregunta($query, $reportData);
    }

    public function verificarTrampitas($idUsuario){
        $trampitasDisponibles = $this->database->query("SELECT COALESCE(COUNT(*), 0) as 'trampitas' FROM trampita t WHERE t.idUsuario = '". $idUsuario ."' and t.utilizada = false");
        if($trampitasDisponibles[0]['trampitas']>0){
            return true;
        }
        return false;
    }

    public function trampitaUsada($idUsuario){
        $query = "UPDATE trampita SET utilizada = true WHERE idUsuario = '$idUsuario' AND utilizada = false LIMIT 1;";
        $this->database->query($query);
    }

    public function comprarTrampita(){
        $idUsuario = $this->getIDUsuarioActual();
        $query = "INSERT INTO trampita (idUsuario, fechaCompra, utilizada) VALUES ('".$idUsuario."', NOW(), 0);";
        $this->database->query($query);
    }

    private function respondioATiempo($idPregunta, $idPartida){
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $inicio = $this->getTiempoDeJugada($idPregunta, $idPartida);
        $tiempoDeInicio = strtotime($inicio[0]["inicio"]);
        $tiempoActual = strtotime(date("H:i:s"));
        if (($tiempoActual - $tiempoDeInicio) > 10) {
            return false;
        } else {
            return true;
        }
    }

    private function getTiempoDeJugada($idPregunta, $idPartida){
        $query = "SELECT tiempo as 'inicio' from Jugada
                  WHERE idPregunta = '" .$idPregunta. "' AND idPartida = '". $idPartida ."'
                  ORDER BY id DESC
                  LIMIT 1;";
        $result =$this->database->query($query);
        return $result;
    }




}

