<?php

class PartidaModel
{
    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function getPreguntas() {
        return $this->database->query("SELECT * FROM Pregunta");
    }

    public function getPartidas($idUsuario) {
        $query = "SELECT p.id, p.fecha, p.idUsuario FROM Partida p WHERE p.idUsuario = $idUsuario";
        return $this->database->query($query);
    }

    public function getLastPartida($idUsuario) {
        $query = "SELECT p.id, p.fecha, p.idUsuario 
                  FROM Partida p 
                  WHERE p.idUsuario = $idUsuario 
                  ORDER BY p.id DESC 
                  LIMIT 1";
        return $this->database->query($query);
    }

    public function addPartida($idUsuario){
        $query = "INSERT INTO partida (fecha, idUsuario) VALUES (NOW(), $idUsuario)";
        return $this->database->query($query);
    }

    public function getPregunta() {
        $query = "SELECT p.pregunta, o.* 
                  FROM Pregunta p
                  JOIN Opcion o ON p.idOpcion = o.id
                  ORDER BY RAND()
                  LIMIT 1";
        return $this->database->query($query);
    }

    public function createJugada($idPregunta, $idPartida) {
        $query = "INSERT INTO Jugada (idPregunta, idPartida, tiempo, respondidoCorrectamente)
                  VALUES ($idPregunta, $idPartida, null, null)";
        return $this->database->query($query);
    }

    public function updateJugada($idPregunta, $idPartida, $respondidoCorrectamente) {
        $query = "UPDATE Jugada
                  SET respondidoCorrectamente = '$respondidoCorrectamente'
                  WHERE idPregunta = $idPregunta AND idPartida = $idPartida";
        return $this->database->query($query);
    }

    public function getRespuestaCorrecta($idPregunta) {
        $query = "SELECT o.respuestaCorrecta
                  FROM Pregunta p
                  INNER JOIN Opcion o ON p.idOpcion = o.id
                  WHERE p.id = $idPregunta";
        return $this->database->query($query);
    }

    public function getUserByNickname($nickname) {
        $query = "SELECT u.id
                  FROM Usuario u
                  WHERE u.nickName LIKE '$nickname'";
        return $this->database->query($query);
    }

    public function setPreguntaUsuario($idUsuario, $idPregunta) {
        $query = "INSERT INTO usuario_pregunta (idUsuario, idPregunta) VALUES ($idUsuario, $idPregunta)";
        return $this->database->query($query);
    }

    public function getPreguntasUsuario($idUsuario, $idPregunta) {
        $query = "SELECT *
                  FROM usuario_pregunta
                  WHERE idUsuario = $idUsuario 
                  AND idPregunta = $idPregunta";
        return  $this->database->query($query);
    }

    public function countRespuestasCorrectas($partidaId) {
        $query = "SELECT COUNT(*) AS count
                  FROM Jugada
                  WHERE idPartida = $partidaId AND respondidoCorrectamente = true";
        $result = $this->database->query($query);
        return $result[0]['count'];
    }




}