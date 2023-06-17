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

    public function getDiaUnoMesAnterior()
    {
        $currentDate = new DateTime();
        $currentDate->modify('first day of previous month');
        $firstDay = $currentDate->format('Y-m-d');
        return $firstDay;
    }

    public function getNombreDelMes($date)
    {
        $dateTime = new DateTime($date);
        $numeroMes = $dateTime->format('n'); // Obtiene el número de mes (1 a 12)
        
        $nombresMeses = [
            1 => 'enero',
            2 => 'febrero',
            3 => 'marzo',
            4 => 'abril',
            5 => 'mayo',
            6 => 'junio',
            7 => 'julio',
            8 => 'agosto',
            9 => 'septiembre',
            10 => 'octubre',
            11 => 'noviembre',
            12 => 'diciembre'
        ];
        $nombreMes = $nombresMeses[$numeroMes];
        $nombreMes = ucfirst($nombreMes); // mayus primer letra del mes
        return $nombreMes;
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
        $query = "SELECT COUNT(*) AS total FROM Pregunta";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }

    public function getCantidadUsuariosNuevosDesdeFecha($fecha)
    {
        $query = "SELECT COUNT(*) AS total FROM usuario WHERE fechaRegistro >= $fecha";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }

    public function getPartidasNuevasDesdeFecha($fecha)
    {
        $query = "SELECT COUNT(*) AS total FROM partida WHERE fecha >= $fecha";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }
    public function getPorcentajePreguntasAcertadas()
    {
        $query = "SELECT ROUND((COUNT(*) / (SELECT COUNT(*) FROM Pregunta)) * 100, 1) AS porcentaje_acertadas FROM Pregunta WHERE cantidadAciertos > 0";
        $result = $this->database->query($query);
        return $result[0]['porcentaje_acertadas'];
    }

    public function getPorcentajePreguntasAcertadasPorUsuario($idUsuario)
    {
        $query = "SELECT ROUND((COUNT(up.aciertos) / (SELECT COUNT(*) FROM usuario_pregunta WHERE idUsuario = $idUsuario)) * 100, 1) AS porcentaje_acertadas
                  FROM usuario_pregunta up
                  INNER JOIN pregunta p ON up.idPregunta = p.id
                  WHERE up.idUsuario = $idUsuario AND up.aciertos > 0";
        $result = $this->database->query($query);
        return $result[0]['porcentaje_acertadas'];
    }

    public function getCantidadUsuariosPorPais()
    {
        // se requiere la tabla país
    }

    public function getCantidadUsuariosPorSexo()
    {
        $query = "SELECT g.nombre AS genero, COUNT(u.id) AS cantidadUsuarios
                  FROM genero g
                  INNER JOIN usuario u ON g.id = u.idGenero
                  GROUP BY g.nombre";
        $result = $this->database->query($query);
        return $result;
    }

    public function adminModelMethodsTest()
    {
        $arrayDatos = array();
        $mesAnterior = $this->getDiaUnoMesAnterior();
        $nombreMes = $this->getNombreDelMes($mesAnterior);

        $totalUsuarios = $this->getTotalUsuarios();
        $totalJugadores = $this->getTotalJugadores();
        $totalEditores = $this->getTotalEditores();
        $totalAdministradores = $this->getTotalAdministradores();
        $totalJugadoresConAlMenosUnaPartida = $this->getTotalJugadoresConAlMenosUnaPartida();
        $cantidadPartidasJugadas = $this->getCantidadPartidasJugadas();
        $cantidadPreguntas = $this->getTotalPreguntasCreadas();
        $cantidadUsuariosNuevosDesdeFecha = $this->getCantidadUsuariosNuevosDesdeFecha($mesAnterior);
        $porcentajePreguntasAcertadas = $this->getPorcentajePreguntasAcertadas();
        // puede ser cualquier Id. debería estar la posibilidad de seleccionar un ID desde la vista
        $porcentajePreguntasAcertadasPorUsuario = $this->getPorcentajePreguntasAcertadasPorUsuario($this->getIDUsuarioActual());
        $cantidadUsuariosPorSexo = $this->getCantidadUsuariosPorSexo();
        $partidasNuevasDesdeFecha = $this->getPartidasNuevasDesdeFecha($mesAnterior);

        $arrayDatos["totalUsuarios"] = $totalUsuarios;
        $arrayDatos["totalJugadores"] = $totalJugadores;
        $arrayDatos["totalEditores"] = $totalEditores;
        $arrayDatos["totalAdministradores"] = $totalAdministradores;
        $arrayDatos["totalJugadoresConAlMenosUnaPartida"] = $totalJugadoresConAlMenosUnaPartida;
        $arrayDatos["cantidadPartidasJugadas"] = $cantidadPartidasJugadas;
        $arrayDatos["cantidadPreguntas"] = $cantidadPreguntas;
        $arrayDatos["cantidadUsuariosNuevosDesdeFecha"] = $cantidadUsuariosNuevosDesdeFecha;
        $arrayDatos["porcentajePreguntasAcertadas"] = $porcentajePreguntasAcertadas;
        $arrayDatos["porcentajePreguntasAcertadasPorUsuario"] = $porcentajePreguntasAcertadasPorUsuario;
        $arrayDatos["cantidadUsuariosPorSexo"] = $cantidadUsuariosPorSexo;
        $arrayDatos["partidasNuevasDesdeFecha"] = $partidasNuevasDesdeFecha;
        $arrayDatos["nombreMes"] = $nombreMes;












        return array('arrayDatos' => $arrayDatos);
    }
}
