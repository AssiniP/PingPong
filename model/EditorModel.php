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
    public function getQuestionId($id){
        return $this->database->query("select p.*, c.nombre  categoria from pregunta_sugerida p,categoria c  where p.idCategoria =c.id  and  p.id=".$id);
    }
    public function delQuestionId($id){
        return $this->database->query("delete from pregunta_sugerida where id=".$id);
    }

    public function addQuestion($preguntaData) {
        $query = "INSERT INTO pregunta_sugerida (idCategoria,idUsuario,pregunta,opcion1,opcion2,opcion3,opcion4,respuestaCorrecta) VALUES (".
            $preguntaData['idCategoria'].",".$preguntaData['idUsuario'].",'".$preguntaData['pregunta']."','".$preguntaData['opcion1']."','".
            $preguntaData['opcion2']."','".$preguntaData['opcion3']."','".$preguntaData['opcion4']."',".$preguntaData['respuestaCorrecta'].")";
        return $this->database->query($query);
    }
    public function editQuestionId($preguntaData){
        $query = "UPDATE pregunta_sugerida SET  pregunta='". $preguntaData['pregunta']."',opcion1='".$preguntaData['opcion1'].
            "',opcion2='".$preguntaData['opcion2']."',opcion3='".$preguntaData['opcion3']."',opcion4='".$preguntaData['opcion4'].
            "',respuestaCorrecta=".$preguntaData['respuestaCorrecta'].",idCategoria=".$preguntaData['idCategoria']."  where id=".$preguntaData['idPregunta'];
        return $this->database->query($query);
    }

}