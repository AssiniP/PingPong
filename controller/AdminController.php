<?php
require_once(SITE_ROOT . '/helpers/Session.php');
class AdminController
{
    private $renderer;
    private $adminModel;
    public function __construct($adminModel, $renderer)
    {
        $this->renderer = $renderer;
        $this->adminModel = $adminModel;
    }

    public function list()
    {
        $_SESSION['jugando'] = true;
        
        $arrayDatos = $this->adminModel->adminModelMethodsTest();

        $data['totalUsuarios'] = $arrayDatos['arrayDatos']['totalUsuarios'];
        $data['totalJugadores'] = $arrayDatos['arrayDatos']['totalJugadores'];
        $data['totalEditores'] = $arrayDatos['arrayDatos']['totalEditores'];
        $data['totalAdministradores'] = $arrayDatos['arrayDatos']['totalAdministradores'];
        $data['totalJugadoresConAlMenosUnaPartida'] = $arrayDatos['arrayDatos']['totalJugadoresConAlMenosUnaPartida'];
        $data['cantidadPartidasJugadas'] = $arrayDatos['arrayDatos']['cantidadPartidasJugadas'];
        $data['cantidadPreguntas'] = $arrayDatos['arrayDatos']['cantidadPreguntas'];
        $data['cantidadUsuariosNuevosDesdeFecha'] = $arrayDatos['arrayDatos']['cantidadUsuariosNuevosDesdeFecha'];
        $data['porcentajePreguntasAcertadas'] = $arrayDatos['arrayDatos']['porcentajePreguntasAcertadas'];
        $data['porcentajePreguntasAcertadasPorUsuario'] = $arrayDatos['arrayDatos']['porcentajePreguntasAcertadasPorUsuario'];
        $data['cantidadUsuariosPorSexo'] = $arrayDatos['arrayDatos']['cantidadUsuariosPorSexo'];
        $data['partidasNuevasDesdeFecha'] = $arrayDatos['arrayDatos']['partidasNuevasDesdeFecha'];
        $data['nombreMes'] = $arrayDatos['arrayDatos']['nombreMes'];




        

        $this->renderer->render('admin', $data);
    }
}
