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

    public function getPreguntasConOpciones() {
        $query = "SELECT p.id, p.pregunta, o.opcion1, o.opcion2, o.opcion3, o.opcion4, o.respuestaCorrecta
                  FROM Pregunta p
                  INNER JOIN Opcion o ON p.idOpcion = o.id";
        return $this->database->query($query);
    }

    public function insertPartida($idUsuario) {
        $fechaActual = date("d-m-Y");
        $query = "INSERT INTO Partida (fecha, idUsuario) VALUES ('$fechaActual', $idUsuario)";
        return $this->database->query($query);
    }



}