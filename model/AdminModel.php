<?php

require_once('jpgraph/src/jpgraph.php');
require_once('jpgraph/src/jpgraph_bar.php');

class AdminModel
{
    private $database;
    public function __construct($database)
    {
        $this->database = $database;
    }
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

    public function getAllUsers()
    {
        $query = "select u.*, G.nombre genero , r.rol  from usuario U, genero G, rol r  where U.idGenero =G.id and u.idRol =r.id";
        return $this->database->query($query);
    }

    public function getUsersId($idUsuario)
    {
        $query = "select u.*, G.nombre genero , r.rol  from usuario U, genero G, rol r  where U.idGenero =G.id and u.idRol =r.id and u.id=".$idUsuario;
        return $this->database->query($query);
    }

    public function upateRolNickName($nickName,$idRol)
    {
        $query = "update usuario set idRol=".$idRol."  where nickName like '".$nickName."'";
        return $this->database->query($query);
    }
    public function getAllRols()
    {
        $query = "select *  from rol";
        return $this->database->query($query);
    }
    public function getDiaUnoMesAnterior()
    {
        $currentDate = new DateTime();
        $currentDate->modify('first day of previous month');
        $firstDay = $currentDate->format('Y-m-d');
        return $firstDay;
    }

    public function getNombreDelMes($fecha)
    {
        $dateTime = new DateTime($fecha);
        $numeroMes = $dateTime->format('n'); // obtiene el número de mes del 1 a 12
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

    public function getMesesList()
    {
        $query = "SELECT nombre FROM Meses";
        $result = $this->database->query($query);

        if ($result && $result instanceof mysqli_result && $result->num_rows > 0) {
            $mesesArray = array();
            while ($row = $result->fetch_assoc()) {
                $mesesArray[] = $row['nombre'];
            }

            return $mesesArray;
        } else {
            // Manejar el caso en que la consulta no devuelva resultados
            return array(); // O devuelve un valor predeterminado, según tu lógica
        }
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
        $query = "SELECT COUNT(*) AS total FROM usuario WHERE fechaRegistro >= '$fecha'";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }

    public function getPartidasNuevasDesdeFecha($fecha)
    {
        $query = "SELECT COUNT(*) AS total FROM partida WHERE fecha >= '$fecha'";
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
        $query = "SELECT COALESCE(ROUND((COUNT(up.aciertos) / NULLIF((SELECT COUNT(*) FROM usuario_pregunta WHERE idUsuario = $idUsuario), 0)) * 100, 1), 0) AS porcentaje_acertadas
              FROM usuario_pregunta up
              INNER JOIN pregunta p ON up.idPregunta = p.id
              WHERE up.idUsuario = $idUsuario AND up.aciertos > 0";
        $result = $this->database->query($query);
        return $result[0]['porcentaje_acertadas'];
    }

    public function getCantidadUsuariosPorPais()
    {
        $query = "SELECT p.nombre AS pais, COUNT(u.id) AS cantidadUsuarios
              FROM usuario u
              INNER JOIN paises p ON u.pais = p.nombre
              GROUP BY p.nombre";
        $result = $this->database->query($query);
        return $result;
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
    public function getBalanceTrampitasPorUsuario()
    {
        $query = "SELECT u.id, u.nickname, COUNT(t.id) AS balanceTrampitas
              FROM Usuario u
              LEFT JOIN Trampita t ON u.id = t.idUsuario
              GROUP BY u.id, u.nickname";
        $result = $this->database->query($query);
        return $result[0]['balanceTrampitas'];
    }

    public function getCantidadTrampitas()
    {
        $query = "SELECT COUNT(*) AS cantidadTrampitas
              FROM Trampita";
        $result = $this->database->query($query);
        return $result[0]['cantidadTrampitas'];
    }

    public function crearGraficoBarras()
    {
        $datay = array(62, 105, 85, 50);
        $graph = new Graph(350, 220, 'auto');
        $graph->SetScale("textlin");
        $graph->yaxis->SetTickPositions(array(0, 30, 60, 90, 120, 150), array(15, 45, 75, 105, 135));
        $graph->SetBox(false);
        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels(array('A', 'B', 'C', 'D'));
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false, false);
        $b1plot = new BarPlot($datay);
        $graph->Add($b1plot);
        $b1plot->SetColor("white");
        $b1plot->SetFillGradient("#4B0082", "white", GRAD_LEFT_REFLECTION);
        $b1plot->SetWidth(45);
        $graph->title->Set("Bar Gradient(Left reflection)");
        $imagePath = 'graficos/imagenes/grafico.png';
        $directory = 'graficos/imagenes/';
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        if (!is_dir($directory)) {
            if (!mkdir($directory, 0777, true)) {
                die('Error al crear el directorio');
            }
        }
        $graph->Stroke($imagePath);
        return $imagePath;
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
        $porcentajePreguntasAcertadasPorUsuario = $this->getPorcentajePreguntasAcertadasPorUsuario($this->getIDUsuarioActual());
        $cantidadUsuariosPorSexo = $this->getCantidadUsuariosPorSexo();
        $partidasNuevasDesdeFecha = $this->getPartidasNuevasDesdeFecha($mesAnterior);
        $mesesList = $this->getMesesList();
        $balanceTrampitas = $this->getBalanceTrampitasPorUsuario();
        $cantidadTrampitas = $this->getCantidadTrampitas();
        $cantidadUsuarioPais = $this->getCantidadUsuariosPorPais();

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
        $arrayDatos['imagePath'] = $this->crearGraficoBarras();
        $arrayDatos["mesesList"] = $mesesList;
        $arrayDatos["balanceTrampitas"] = $balanceTrampitas;
        $arrayDatos["cantidadTrampitas"] = $cantidadTrampitas;
        $arrayDatos['cantidadPorPais'] = $cantidadUsuarioPais;

        return array('arrayDatos' => $arrayDatos);
    }
}
