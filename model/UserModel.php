<?php

class UserModel {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function getAllUsers() {
        return $this->database->query("select u.*, G.nombre genero, (select  if(sum(puntaje) is null,0,sum(puntaje)) as puntaje  from Partida P  where idUsuario=U.id) puntaje from usuario U, genero G  where U.idGenero =G.id  order by  puntaje DESC");
    }

    public function getUser($nickname) {
        return $this->database->query("select u.*, G.nombre genero, (select  if(sum(puntaje) is null,0,sum(puntaje)) as puntaje  from Partida P  where idUsuario=U.id) puntaje, (select COALESCE(COUNT(*), 0) from trampita  t where t.idUsuario=U.id AND t.utilizada = false) trampita, YEAR(CURDATE())-YEAR(fechaNacimiento)  AS `EDAD_ACTUAL` from usuario U, genero G  where U.idGenero =G.id  and nickname like '".$nickname."'");
    }
    public function getPaises(){
        return $this->database->query("select * from paises ");
    }
    public function getUserInfo($nickname){
        return $this->database->query("select u.*, G.nombre genero, YEAR(CURDATE())-YEAR(fechaNacimiento)  AS `EDAD_ACTUAL` from usuario U, genero G  where U.idGenero =G.id  and nickname = '".$nickname."'");
    }
    public function getUserGameInfo($nickname){
        return $this->database->query("SELECT U.*, (SELECT IF(SUM(puntaje) IS NULL, 0, SUM(puntaje)) AS puntaje FROM Partida P WHERE P.idUsuario = U.id) AS puntaje, (SELECT COALESCE(COUNT(*), 0) FROM trampita t WHERE t.idUsuario = U.id AND t.utilizada = false) AS trampita FROM usuario U WHERE nickname like '".$nickname."';");
    }

    public function getHistorial($idUsuario) {
        return $this->database->query("select fecha, if((puntaje is null),0,puntaje) as puntaje  from Partida   where idUsuario=".$idUsuario . " order by fecha desc LIMIT 10");
    }
    //validar que ni el usuario ni el email ya se encuentren registrados.
    public function check_user($nickname,$email) {
        return $this->database->query("SELECT * FROM `usuario` WHERE nickname like '".$nickname."' OR email like '".$email."'");
    }

    public function getQuestionUser($nickname){
        return $this->database->query("select p.*, c.nombre  categoria from pregunta_sugerida p,categoria c  where idCategoria =c.id  and  p.idUsuario in (select id from usuario where nickName like '".$nickname."') ");
    }
    public function getQuestionId($id){
        return $this->database->query("select p.*, c.nombre  categoria from pregunta_sugerida p,categoria c  where p.idCategoria =c.id  and  p.id=".$id);
    }
    public function delQuestionId($id){
        return $this->database->query("delete from pregunta_sugerida where id=".$id);
    }
    public function getIDUsuarioActual()
    {
        $nickname = $_SESSION['nickname'];
        $user = $this->getUser($nickname);
        return $user[0]['id'];
    }

    public function addQuestion($pregunta, $opcion1, $opcion2, $opcion3, $respuestaCorrecta, $idCategoria) {
        $query = "INSERT INTO pregunta_sugerida (idCategoria,idUsuario,pregunta,opcion1,opcion2,opcion3,respuestaCorrecta) VALUES (".
            $idCategoria.",".$this->getIDUsuarioActual().",'".$pregunta."','".$opcion1."','".
            $opcion2."','".$opcion3."','".$respuestaCorrecta."')";
        return $this->database->query($query);
    }

    function editQuestionId($idPregunta,$pregunta,$opcion1,$opcion2,$opcion3,$respuestaCorrecta,$idCategoria)
    {
        $query = "UPDATE pregunta_sugerida SET pregunta ='".$pregunta."', opcion1 ='". $opcion1."', opcion2 ='". $opcion2."', opcion3 = '".$opcion3 ."', respuestaCorrecta = '".$respuestaCorrecta."', idCategoria = ".$idCategoria ." where id = ". $idPregunta;
        return $this->database->query($query);
    }

    //validar que el usuario y la password existan
    public function validarLogin(String $nickname, String $password){
        return $this->database->query("SELECT  u.* , r.rol FROM usuario U, rol  R  where R.id=U.idRol and nickname like '".$nickname."' and password like '".$password."'");
    }

    public function createJugada($idPregunta, $idPartida)
    {
        $query = "INSERT INTO Jugada (idPregunta, idPartida, tiempo, respondidoCorrectamente)
                  VALUES ($idPregunta, $idPartida, null, 0)";
        return $this->database->query($query);
    }
    public function addUser($body,$imgPath){
        $query = "INSERT INTO usuario (nickname, password, nombre, email,  imagenPerfil, pais, idRol, idGenero, fechaRegistro, ciudad, latitud, longitud,fechaNacimiento,nivelJugador) VALUES ('".
            $body->nickName."','".md5($body->password)."','".$body->nombre."','".$body->email."','".$imgPath."','".
            $body->pais."',3,".$body->idGenero." ,NOW(),'".$body->ciudad."',".$body->latitud.",".
            $body->longitud.",'".$body->fechaNacimiento."','PRINCIPIANTE')";
        return $this->database->query($query);
    }
    public function enviarMail($mail) {
        include_once("vendor/SendEmail.php");

        enviarMail($mail);
    }

    public function validarMail($email){
        return $this->database->query("SELECT * FROM usuario U join rol R on U.idRol = R.id where U.email like '".$email."'");

    }

    public function getAllGenero(){
        return $this->database->query("SELECT * FROM genero ");
    }

    public function getAllCategoria(){
        return $this->database->query("SELECT * FROM categoria ");
    }
    public function getAllRol(){
        return $this->database->query("SELECT * FROM rol ");
    }


   public function actualizarCuentaValidada($email){
        $esValido = true;
       return $this->database->queryBoolean("UPDATE Usuario SET cuentaValida  = ". $esValido ." where email like '".$email."'");
   }

    public function generateQR($nickname){
        include_once (SITE_ROOT . '/third-party/phpqrcode/qrlib.php');

        $tempDir = SITE_ROOT . '/public/qr-perfil/qr_code_' . $nickname . '.png';

        $url = 'http://localhost/user/seeProfile&nick=' . $nickname;

        $size = 3;
        $level = 'L';
        QRcode::png($url, $tempDir, $level, $size);
    }

    public function getRanking(){
       return $this->database->query( "select ROW_NUMBER() OVER(ORDER BY SUM(puntaje) DESC) AS 'Puesto', u.nickName,u.imagenPerfil ,sum(puntaje) as 'Puntaje' from partida p join usuario u on u.id = p.idUsuario group by idUsuario LIMIT 5");
    }
}