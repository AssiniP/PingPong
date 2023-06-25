<?php

require_once('jpgraph/src/jpgraph.php');
require_once('jpgraph/src/jpgraph_bar.php');
require_once('jpgraph/src/jpgraph_pie.php');
require_once('jpgraph/src/jpgraph_line.php');
require_once ('jpgraph/src/jpgraph_line.php');
/*require_once (SITE_ROOT.'/third-party/pdfGenerator.php');
require_once (SITE_ROOT.'/third-party/fpdf185/fpdf.php');*/


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
              WHERE fecharegistro >= DATE_SUB('$filterDate', INTERVAL 3 DAY)";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }

    public function getPartidasNuevasDesdeFecha($filterDate)
    {
        $query = "SELECT COUNT(*) AS total
              FROM Partida
              WHERE fecha >= DATE_SUB('$filterDate', INTERVAL 3 DAY)";
        $result = $this->database->query($query);
        return $result[0]['total'];
    }
    public function getPorcentajePreguntasAcertadas()
    {
        $query = "SELECT ROUND((SUM(cantidadAciertos) / SUM(cantidadOcurrencias)) * 100, 1) AS porcentaje_acertadas FROM Pregunta WHERE cantidadOcurrencias > 0";
        $result = $this->database->query($query);
        return $result[0]['porcentaje_acertadas'];
    }

    public function getPorcentajePreguntasAcertadasPorUsuario()
    {
        $query = "SELECT COALESCE(ROUND((SUM(up.aciertos) / NULLIF(SUM(up.ocurrencias), 0)) * 100, 1), 0) AS porcentaje_acertadas
              FROM usuario_pregunta up
              INNER JOIN pregunta p ON up.idPregunta = p.id
              WHERE up.ocurrencias > 0";
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

    public function getCantidadUsuariosPorEdad($filterDate)
    {
        $query = "SELECT 
                CASE
                    WHEN TIMESTAMPDIFF(YEAR, u.fechaNacimiento, '$filterDate') < 18 THEN 'Menores'
                    WHEN TIMESTAMPDIFF(YEAR, u.fechaNacimiento, '$filterDate') >= 65 THEN 'Jubilados'
                    ELSE 'Medio'
                END AS categoria,
                COUNT(u.id) AS cantidadUsuarios
              FROM usuario u
              WHERE u.fecharegistro >= '$filterDate'
              GROUP BY categoria";

        $result = $this->database->query($query);
        return $result;
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
        $totalUsuarios = $this->getCantidadUsuariosNuevosDesdeFecha($fecha);
        $datay = array($totalUsuarios);

        if ($totalUsuarios == 0) {

            $imagePath = 'public/graficos/imagenes/error.png';
            return $imagePath;
        }

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

        $generos = array($h ." H" , $m ." M" , $o ." O" );
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
        $datos->SetLegends(array('Hombre', 'Mujer', 'Otro'));
        $datos->SetLabelType(PIE_VALUE_ABS);
        $datos->value->SetFormat('%d');
        $datos->value->Show();
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


    public function paisesGrafico($filterDate){
        $usuariosPorPais = $this->getCantidadUsuariosPorPais($filterDate);

        $paises = array();
        $cantidadUsuarios = array();

        foreach ($usuariosPorPais as $row) {
            $paises[] = $row['pais'];
            $cantidadUsuarios[] = $row['cantidadUsuarios'];
        }

        if (array_sum($cantidadUsuarios) === 0) {

            $imagePath = 'public/graficos/imagenes/error.png';
            return $imagePath;
        }

        $datay = $cantidadUsuarios;

        $graph = new Graph(250,300,'auto');
        $graph->SetScale("textlin");

        $theme_class=new UniversalTheme;
        $graph->SetTheme($theme_class);
        $graph->xaxis->SetTickLabels($paises);
        $graph->Set90AndMargin(80,40,40,40);
        $graph->img->SetAngle(90);
        $graph->title->Set('Distribucion de usuarios por pais');
        $graph->title->SetFont(FF_VERDANA,FS_BOLD,8);

        $graph->SetBox(false);

        $graph->ygrid->Show(false);
        $graph->ygrid->SetFill(false);
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false,false);

        $graph->SetBackgroundGradient('#00CED1', '#FFFFFF', GRAD_HOR, BGRAD_PLOT);

        $b1plot = new BarPlot($datay);

        $graph->Add($b1plot);

        $b1plot->SetWeight(0);
        $b1plot->SetFillGradient("#808000","#90EE90",GRAD_HOR);
        $b1plot->SetWidth(17);

        $imagePath = 'public/graficos/imagenes/paises.png';
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

    public function usuariosEdadGrafico($filterDate){
        // Some data
        $usuariosPorEdad = $this->getCantidadUsuariosPorEdad($filterDate);


        $categoria = array();
        $cantidadUsuarios = array();

        foreach ($usuariosPorEdad as $row) {
            $categoria[] = $row['categoria'];
            $cantidadUsuarios[] = $row['cantidadUsuarios'];
        }

        $data = $cantidadUsuarios;
        if (array_sum($cantidadUsuarios) === 0) {

            $imagePath = 'public/graficos/imagenes/error.png';
            return $imagePath;
        }

        $graph = new PieGraph(350,250);

        $theme_class="DefaultTheme";

        $graph->title->Set("Distribucion de usuarios por rango etario");
        $graph->SetBox(true);

        $p1 = new PiePlot($data);
        $graph->Add($p1);
        $p1->SetLegends($categoria);

        $p1->ShowBorder();
        $p1->SetColor('black');
        $p1->SetSliceColors(array('#1E90FF','#2E8B57','#ADFF2F','#DC143C','#BA55D3'));
        $p1->SetLabelType(PIE_VALUE_ABS);
        $p1->value->SetFormat('%d');
        $p1->value->Show();
        $p1->SetLabelPos(1);


        $imagePath = 'public/graficos/imagenes/edad.png';
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


    public function adminModelMethodsTest($filterDate)
    {

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
        $porcentajePreguntasAcertadasPorUsuario = $this->getPorcentajePreguntasAcertadasPorUsuario();

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
        //GRAFICOS FACHA
        $arrayDatos['usuariosNuevosGrafico'] = "../../" . $this->usuariosNuevosGrafico($filterDate);
        $arrayDatos['generosGrafico'] = "../../" . $this->generosGrafico($filterDate);
        $arrayDatos['paisesGrafico'] = "../../" . $this->paisesGrafico($filterDate);
        $arrayDatos['edadGrafico'] = "../../" . $this->usuariosEdadGrafico($filterDate);


        return array('arrayDatos' => $arrayDatos);
    }

    public function generarPdf($filterDate){
        /*include_once( SITE_ROOT . '/third-party/pdfGenerator.php');
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times','',12);
        $pdfPath = SITE_ROOT . '/public/reportes/archivo.pdf';
        return $pdf->Output($pdfPath, 'I');*/
    }
}