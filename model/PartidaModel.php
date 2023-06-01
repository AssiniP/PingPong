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

    public function addPartida(){
        $query = "INSERT INTO partida (fecha, idUsuario) VALUES (NOW(), 1)";
        return $this->database->query($query);
    }

    public function getPregunta() {
        $query = "SELECT p.pregunta, o.* 
                  FROM Pregunta p
                  JOIN Opcion o ON p.idOpcion = o.id
                  ORDER BY p.id DESC 
                  LIMIT 1";
        return $this->database->query($query);
    }

    







}