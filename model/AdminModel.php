<?php

require_once('jpgraph/src/jpgraph.php');
require_once('jpgraph/src/jpgraph_bar.php');
require_once('jpgraph/src/jpgraph_pie.php');
require_once('jpgraph/src/jpgraph_line.php');
require_once ('jpgraph/src/jpgraph_line.php');


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
        $query = "select u.*, G.nombre genero , r.rol  from usuario U, genero G, rol r  where U.idGenero =G.id and u.idRol =r.id and u.id=" . $idUsuario;
        return $this->database->query($query);
    }
    public function upateRolNickName($nickName, $idRol)
    {
        $query = "update usuario set idRol=" . $idRol . "  where nickName like '" . $nickName . "'";
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
            return array();
        }
    }
    public function getTotalUsuarios($filterDate)
    {
        $query = "SELECT COUNT(*) AS TotalUsuarios
              FROM Usuario
              WHERE fecharegistro <= '$filterDate'";
        $result = $this->database->query($query);
        return $result[0]['TotalUsuarios'];
    }
    public function getTotalJugadores($filterDate)
    {
        $query = "SELECT COUNT(*) AS total
              FROM Usuario
              WHERE idRol = (SELECT id FROM Rol WHERE rol = 'Jugador')
              AND fecharegistro <= '$filterDate'";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }

    public function getTotalEditores($filterDate)
    {
        $query = "SELECT COUNT(*) AS total
              FROM Usuario
              WHERE idRol = (SELECT id FROM Rol WHERE rol = 'Editor')
              AND fecharegistro <= '$filterDate'";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }

    public function getTotalAdministradores($filterDate)
    {
        $query = "SELECT COUNT(*) AS total
              FROM Usuario
              WHERE idRol = (SELECT id FROM Rol WHERE rol = 'Administrador')
              AND fecharegistro <= '$filterDate'";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }

    public function getTotalJugadoresConAlMenosUnaPartida($filterDate)
    {
        $query = "SELECT COUNT(DISTINCT idUsuario) AS total
              FROM Partida
              WHERE fecha <= '$filterDate'";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }
    public function getCantidadPartidasJugadas($filterDate)
    {
        $query = "SELECT COUNT(*) AS total
              FROM Partida
              WHERE fecha <= '$filterDate'";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }
    public function getTotalPreguntasCreadas()
    {
        $query = "SELECT COUNT(*) AS total FROM Pregunta";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }

    public function getCantidadUsuariosNuevosDesdeFecha($filterDate)
    {
        $query = "SELECT COUNT(*) AS total
              FROM Usuario
              WHERE fecharegistro <= '$filterDate'";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }

    public function getPartidasNuevasDesdeFecha($filterDate)
    {
        $query = "SELECT COUNT(*) AS total
              FROM Partida
              WHERE fecha <= '$filterDate'";
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

    public function getCantidadUsuariosPorPais($filterDate)
    {
        $query = "SELECT p.nombre AS pais, COUNT(u.id) AS cantidadUsuarios
              FROM usuario u
              INNER JOIN paises p ON u.pais = p.nombre
              WHERE u.fecharegistro <= '$filterDate'
              GROUP BY p.nombre";
        $result = $this->database->query($query);
        return $result;
    }

    public function getCantidadUsuariosPorSexo($filterDate)
    {
        $query = "SELECT g.nombre AS genero, COUNT(u.id) AS cantidadUsuarios
              FROM genero g
              INNER JOIN usuario u ON g.id = u.idGenero
              WHERE u.fecharegistro <= '$filterDate'
              GROUP BY g.nombre";
        $result = $this->database->query($query);
        return $result;
    }
    public function getBalanceTrampitasPorUsuario($filterDate)
    {
     $query = "SELECT u.id, u.nickname, COALESCE(COUNT(t.id), 0) AS balanceTrampitas
              FROM Usuario u
              LEFT JOIN Trampita t ON u.id = t.idUsuario
              WHERE t.fechaCompra <= '$filterDate'
              GROUP BY u.id, u.nickname";
        $result = $this->database->query($query);

        if ($result && isset($result[0]['balanceTrampitas'])) {
            return $result[0]['balanceTrampitas'];
        }
        return 0;
    }

    public function getCantidadTrampitas($filterDate)
    {
        $query = "SELECT COALESCE(COUNT(*), 0) AS cantidadTrampitas
              FROM Trampita
              WHERE fechaCompra <= '$filterDate'";
        $result = $this->database->query($query);
        return $result[0]['cantidadTrampitas'];
    }

    public function crearGraficoBarras()
    {
        $query = "SELECT u.id, u.nickname, COUNT(t.id) AS balanceTrampitas
              FROM Usuario u
              LEFT JOIN Trampita t ON u.id = t.idUsuario
              GROUP BY u.id, u.nickname";
        $result = $this->database->query($query);
        return $result[0]['balanceTrampitas'];
    }
    public function getCantidadUsuariosHombres($filterDate)
    {
        $query = "SELECT COALESCE(COUNT(*), 0) AS total FROM usuario WHERE idGenero = 1 AND fechaRegistro <= '$filterDate'";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }

    public function getCantidadUsuariosMujeres($filterDate)
    {
        $query = "SELECT COALESCE(COUNT(*), 0) AS total FROM usuario WHERE idGenero = 2 AND fechaRegistro <= '$filterDate'";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }

    public function getCantidadUsuariosOtros($filterDate)
    {
        $query = "SELECT COALESCE(COUNT(*), 0) AS total FROM usuario WHERE idGenero = 3 AND fechaRegistro <= '$filterDate'";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }

    /* Graficos */
    public function usuariosNuevosGrafico($fecha)
    {
        $totalUsuarios = $this->getTotalUsuarios($fecha);
        $datay = array($totalUsuarios);

        // Crear el objeto del gráfico
        $graph = new Graph(400, 300, 'auto');
        $graph->SetScale('textlin');
        $graph->SetMargin(50, 30, 20, 40);

        $barplot = new BarPlot($datay);
        $barplot->SetFillColor('red');
        $graph->Add($barplot);

        $graph->xaxis->title->Set('Usuarios Nuevos');
        $graph->yaxis->title->Set('Cantidad');
        $graph->xaxis->SetTickLabels(['Usuarios Nuevos']);
        $graph->yaxis->SetTickPositions(array(0, $totalUsuarios)); // Ajustar las marcas de división al rango de valores
        $barplot->value->Show();
        $barplot->value->SetFont(FF_ARIAL, FS_NORMAL, 12);
        $barplot->value->SetFormat('%d');

        // Establecer el formato de las etiquetas del eje y
        $graph->yaxis->SetLabelFormat('%d');

        $imagePath = 'public/graficos/imagenes/usuarios.png';
        $directory = 'public/graficos/imagenes/';

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
    public function generosGrafico($fecha)
    {
        $h = $this->getCantidadUsuariosHombres($fecha);
        $m = $this->getCantidadUsuariosMujeres($fecha);
        $o = $this->getCantidadUsuariosOtros($fecha);
        $generos = array('M' . ' ' . $h, 'F' . ' ' . $m, 'O' . ' ' . $o);
        $cantidadUsuarios = array($h, $m, $o);
        $grafico = new PieGraph(400, 300);
        $grafico->title->Set('Distribución de usuarios por género');
        $datos = new PiePlot($cantidadUsuarios);
        $datos->SetSliceColors(array('blue', 'pink', 'green'));
        $datos->SetLabels($generos);
        $datos->value->SetFont(FF_ARIAL, FS_BOLD, 12);
        $datos->value->SetColor('black');
        $datos->value->Show();
        $datos->ExplodeSlice(1);
        $grafico->Add($datos);
        $imagePath = 'public/graficos/imagenes/generos.png';
        $directory = 'public/graficos/imagenes/';
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        if (!is_dir($directory)) {
            if (!mkdir($directory, 0777, true)) {
                die('Error al crear el directorio');
            }
        }
        $grafico->Stroke($imagePath);
        return $imagePath;
    }

    public function generosGrafico($filterDate)
    {
        $h = $this->getCantidadUsuariosHombres($filterDate);
        $m = $this->getCantidadUsuariosMujeres($filterDate);
        $o = $this->getCantidadUsuariosOtros($filterDate);

        $generos = array('M' . ' ' . $h, 'F' . ' ' . $m, 'O' . ' ' . $o);
        $cantidadUsuarios = array($h, $m, $o);
        if (array_sum($cantidadUsuarios) === 0) {
            $imagePath = 'public/graficos/imagenes/error.png';
            return $imagePath;
        }
        $grafico = new PieGraph(400, 300);
        $grafico->title->Set('Distribución de usuarios por género');
        $datos = new PiePlot($cantidadUsuarios);
        $datos->SetSliceColors(array('blue', 'pink', 'green'));
        $datos->SetLabels($generos);
        $datos->value->SetFont(FF_ARIAL, FS_BOLD, 12);
        $datos->value->SetColor('black');
        $datos->value->Show();
        $datos->ExplodeSlice(1);
        $grafico->Add($datos);
        $imagePath = 'public/graficos/imagenes/generos.png';
        $directory = 'public/graficos/imagenes/';
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        if (!is_dir($directory)) {
            if (!mkdir($directory, 0777, true)) {
                die('Error al crear el directorio');
            }
        }
        $grafico->Stroke($imagePath);
        return $imagePath;
    }


    public function adminModelMethodsTest()
    {
        $filterDate = $_GET['filter_date'] ?? date('Y-m-d');

        $arrayDatos = array();

        //Querys filtrableess
        $totalUsuarios = $this->getTotalUsuarios($filterDate);
        $totalJugadores = $this->getTotalJugadores($filterDate);
        $totalEditores = $this->getTotalEditores($filterDate);
        $totalAdministradores = $this->getTotalAdministradores($filterDate);
        $totalJugadoresConAlMenosUnaPartida = $this->getTotalJugadoresConAlMenosUnaPartida($filterDate);
        $cantidadPartidasJugadas = $this->getCantidadPartidasJugadas($filterDate);
        $cantidadUsuariosPorSexo = $this->getCantidadUsuariosPorSexo($filterDate);
        $cantidadUsuarioPais = $this->getCantidadUsuariosPorPais($filterDate);
        $balanceTrampitas = $this->getBalanceTrampitasPorUsuario($filterDate);
        $cantidadTrampitas = $this->getCantidadTrampitas($filterDate);
        $cantidadUsuariosNuevosDesdeFecha = $this->getCantidadUsuariosNuevosDesdeFecha($filterDate);
        $partidasNuevasDesdeFecha = $this->getPartidasNuevasDesdeFecha($filterDate);
        //querys no filtrableees
        $cantidadPreguntas = $this->getTotalPreguntasCreadas();
        $porcentajePreguntasAcertadas = $this->getPorcentajePreguntasAcertadas();
        $porcentajePreguntasAcertadasPorUsuario = $this->getPorcentajePreguntasAcertadasPorUsuario($this->getIDUsuarioActual());

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

        $arrayDatos["balanceTrampitas"] = $balanceTrampitas;
        $arrayDatos["cantidadTrampitas"] = $cantidadTrampitas;
        $arrayDatos['cantidadPorPais'] = $cantidadUsuarioPais;
        $arrayDatos['filterDate'] = $filterDate;
        $arrayDatos['usuariosNuevosGrafico'] = "../../" . $this->usuariosNuevosGrafico($filterDate);

        $arrayDatos['generosGrafico'] = "../../" . $this->generosGrafico($filterDate);

        return array('arrayDatos' => $arrayDatos);
    }
}


// X FECHA: 

// PAIS, EDAD, PARTIDA, USUARIO, GENERO 