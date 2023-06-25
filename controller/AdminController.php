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
        $data['imagePath'] = $arrayDatos['arrayDatos']['imagePath'];



        $data['balanceTrampitas'] = $arrayDatos['arrayDatos']['balanceTrampitas'];
        $data['cantidadTrampitas'] = $arrayDatos['arrayDatos']['cantidadTrampitas'];
        $data['cantidadPorPais'] = $arrayDatos['arrayDatos']['cantidadPorPais'];
        
        $data['usuariosNuevosGrafico'] = $arrayDatos['arrayDatos']['usuariosNuevosGrafico'];
        $data['generosGrafico'] = $arrayDatos['arrayDatos']['generosGrafico'];

        $this->renderer->render('admin', $data);
    }

    public function users(){
        $data["usuarios"] = $this->adminModel->getAllUsers();
        $data["roles"]= $this->adminModel->getAllRols();
        if(isset($_GET["id"])) {
            $data["editarUsuario"] = $this->adminModel->getUsersId(intval($_GET["id"]));
        }
        $this->renderer->render('adminUsuario', $data);
    }

    public function updateRol(){
        var_dump($_POST);
        if(isset($_POST["nickName"]) && isset($_POST["idRol"])) {

            $this->adminModel->upateRolNickName($_POST["nickName"],intval($_POST["idRol"]));

        }
        header('location: /admin/users');

    }
}