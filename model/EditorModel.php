<?php
class EditorModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getIDUsuarioActual()
    {
        $nickname = $_SESSION['nickname'];
        $user = $this->getUser($nickname);
        return $user[0]['id'];
    }
    public function getUser($nickname) {
        return $this->database->query("select u.*, G.nombre genero, (select  if(sum(puntaje) is null,0,sum(puntaje)) as puntaje  from Partida P  where idUsuario=U.id) puntaje, (select COALESCE(COUNT(*), 0) from trampita  t where t.idUsuario=U.id AND t.utilizada = false) trampita, YEAR(CURDATE())-YEAR(fechaNacimiento)  AS `EDAD_ACTUAL` from usuario U, genero G  where U.idGenero =G.id  and nickname like '".$nickname."'");
    }
    public function getAllCategoria(){
        return $this->database->query("SELECT * FROM categoria ");
    }
    public function getQuestions(){
        return $this->database->query("select p.*, c.nombre  categoria from pregunta_sugerida p,categoria c  where idCategoria =c.id ");
    }

    public function getQuestionsAPI(){
        return $this->database->query("select p.*, c.nombre  categoria from pregunta p,categoria c  where idCategoria =c.id ");
    }
    public function getQuestionsReportada(){
        return $this->database->query("select p.*, c.nombre  categoria, r.id idReportada, r.fecha , r.motivo  from pregunta p,categoria c ,preguntareportada r where idCategoria =c.id and p.id = r.idPregunta ");
    }
    public function getQuestionId($id){
        return $this->database->query("select p.*, c.nombre  categoria from pregunta_sugerida p,categoria c  where p.idCategoria =c.id  and  p.id=".$id);
    }

    public function getQuestionIdAPI($id){
        return $this->database->query("select p.*, c.nombre  categoria from pregunta p,categoria c  where p.idCategoria =c.id  and  p.id=".$id);
    }

    public function getQuestionIdReportadas($id){
        return $this->database->query("select p.*, c.nombre  categoria, r.id idReportada, r.fecha , r.motivo from pregunta p,categoria c ,preguntareportada r where p.idCategoria =c.id and p.id = r.idPregunta   and  p.id=".$id);
    }
    public function delQuestionId($id){
        return $this->database->query("delete from pregunta_sugerida where id=".$id);
    }
    public function delReporteId($id){
        return $this->database->query("delete from preguntareportada where id=".$id);
    }
    public function addQuestion($body) {
        $query = "INSERT INTO pregunta_sugerida (idCategoria,idUsuario,pregunta,opcion1,opcion2,opcion3,respuestaCorrecta) VALUES (".
            $body->idCategoria.",".$this->getIDUsuarioActual().",'".$body->pregunta."','".$body->opcion1."','".
            $body->opcion2."','".$body->opcion3."','".$body->respuestaCorrecta."')";
        return $this->database->query($query);
    }
    public function editQuestionId($body){
        $query = "UPDATE pregunta_sugerida SET  pregunta='". $body->pregunta."',opcion1='".$body->opcion1.
            "',opcion2='".$body->opcion2."',opcion3='".$body->opcion3."',respuestaCorrecta='".$body->respuestaCorrecta.
            "',idCategoria=".$body->idCategoria."  where id=".$body->idPregunta;
        return $this->database->query($query);
    }

}