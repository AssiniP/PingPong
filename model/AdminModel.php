<?php
class AdminModel
{
    private $database;
    public function __construct($database)
    {
        $this->database = $database;
    }

    /* 
    ver cantidad de jugadores que tiene la aplicación.
    ver cantidad de jugadores que jugaron al menos una partida.
    ver cantidad de partidas jugadas.
    ver cantidad de preguntas en el juego.
    ver cantidad de preguntas creadas. 
    ver cantidad de usuarios nuevos.
    ver porcentaje de preguntas respondidas.
    ver porcentaje de preguntas respondidas por usuario.
    ver cantidad de usuarios por pais
    ver cantidad de usuarios por sexo 
    ver cantidad de usuarios por grupo de edad
    */

    public function getUserByNickname($nickname)
    {
        $query = "SELECT u.id
                  FROM Usuario u
                  WHERE u.nickName LIKE '$nickname'";
        return $this->database->query($query);
    }

    public function getIDUsuarioActual()
    {
        $nickname = $_SESSION['nickname'];
        $user = $this->getUserByNickname($nickname);
        return $user[0]['id'];
    }

    public function getTotalUsuarios()
    {
        $query = "SELECT COUNT(*) AS TotalUsuarios
                  FROM Usuario";
        $result = $this->database->query($query);
        return $result[0]['TotalUsuarios'];
    }
    public function getTotalJugadores()
    {
        $query = "SELECT COUNT(*) AS total FROM Usuario WHERE idRol = (SELECT id FROM Rol WHERE rol = 'Jugador')";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }

    public function getTotalEditores()
    {
        $query = "SELECT COUNT(*) AS total FROM Usuario WHERE idRol = (SELECT id FROM Rol WHERE rol = 'Editor')";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }

    public function getTotalAdministradores()
    {
        $query = "SELECT COUNT(*) AS total FROM Usuario WHERE idRol = (SELECT id FROM Rol WHERE rol = 'Administrador')";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }

    public function getTotalJugadoresConAlMenosUnaPartida()
    {
        $query = "SELECT COUNT(DISTINCT idUsuario) AS total FROM Partida";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }
    public function getCantidadPartidasJugadas()
    {
        $query = "SELECT COUNT(*) AS total FROM Partida";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }
    public function getTotalPreguntasCreadas()
    {
       /* Acá entra la API */
    }

    public function getCantidadUsuariosNuevosDesdeFecha($fecha)
    {
        $query = "SELECT COUNT(*) AS total FROM Usuario WHERE fecharegistro >= '$fecha'";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }
    public function getPorcentajePreguntasAcertadas()
    {
        $query = "SELECT (COUNT(*) / (SELECT COUNT(*) FROM Pregunta)) * 100 AS porcentaje_acertadas FROM Pregunta WHERE cantidadAciertos > 0";
        $result = $this->database->query($query);
        return $result[0]['porcentaje_acertadas'];
    }

    public function getPorcentajePreguntasAcertadasPorUsuario($idUsuario)
    {
        $query = "SELECT (COUNT(up.aciertos) / (SELECT COUNT(*) FROM usuario_pregunta WHERE idUsuario = $idUsuario)) * 100 AS porcentaje_acertadas
                  FROM usuario_pregunta up
                  INNER JOIN pregunta p ON up.idPregunta = p.id
                  WHERE up.idUsuario = $idUsuario AND up.aciertos > 0";
        $result = $this->database->query($query);
        return $result[0]['porcentaje_acertadas'];
    }

    public function getCantidadUsuariosPorPais()
    {
        $query = "SELECT Pais, COUNT(*) AS CantidadUsuarios
              FROM Usuario
              GROUP BY Pais";
        $result = $this->database->query($query);
        return $result;
    }

    public function getCantidadUsuariosPorSexo()
    {
        $query = "SELECT Sexo, COUNT(*) AS CantidadUsuarios
              FROM Usuario
              GROUP BY Sexo";
        $result = $this->database->query($query);
        return $result;
    }

    public function adminModelMethodsTest()
    {
        $arrayDatos = array();
        $fecha = '1960-01-01';

        $totalUsuarios = $this->getTotalUsuarios();
        $totalJugadores = $this->getTotalJugadores();
        $totalEditores = $this->getTotalEditores();
        $totalAdministradores = $this->getTotalAdministradores();
        $totalJugadoresConAlMenosUnaPartida = $this->getTotalJugadoresConAlMenosUnaPartida();
        $cantidadPartidasJugadas = $this->getCantidadPartidasJugadas();
        $cantidadUsuariosNuevosDesdeFecha = $this->getCantidadUsuariosNuevosDesdeFecha($fecha);


        $arrayDatos["totalUsuarios"] = $totalUsuarios;
        $arrayDatos["totalJugadores"] = $totalJugadores;
        $arrayDatos["totalEditores"] = $totalEditores;
        $arrayDatos["totalAdministradores"] = $totalAdministradores;
        $arrayDatos["totalJugadoresConAlMenosUnaPartida"] = $totalJugadoresConAlMenosUnaPartida;
        $arrayDatos["cantidadPartidasJugadas"] = $cantidadPartidasJugadas;
        $arrayDatos["cantidadUsuariosNuevosDesdeFecha"] = $cantidadUsuariosNuevosDesdeFecha;





        return array('arrayDatos' => $arrayDatos);
    }
    





}
