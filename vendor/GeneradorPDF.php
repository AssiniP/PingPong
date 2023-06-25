<?php
/*require_once 'autoload.php';
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml('<center><h1>Titulo</h1></center> <br> <center><h2> subtitulo </h2></center>');

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("document.pdf" , ['Attachment' => 0]);*/


include_once "autoload.php";

use Dompdf\Dompdf;

function generarReportePDF($datosReporte, $filterDate) {
    $dompdf = new Dompdf();

    include_once SITE_ROOT . "/helpers/RenderizadorImagenDomPDF.php";
    //HEADER CON INFO
    $base64 = renderImg("/public/img/prueba-logo.png");
    $html2 = headerLogo($filterDate, $base64);

    //Datos del grafico
    $base64 = renderImg($datosReporte['arrayDatos']['edadGrafico']);
    $html2 .= showGraph($base64, "Distribución de usuarios por edad");

    $base64 = renderImg($datosReporte['arrayDatos']['generosGrafico']);
    $html2 .= showGraph($base64, "Distribución de usuarios por genero");

    $base64 = renderImg($datosReporte['arrayDatos']['paisesGrafico']);
    $html2 .= showGraph($base64, "Distribución de usuarios por país");

    $base64 = renderImg($datosReporte['arrayDatos']['usuariosNuevosGrafico']);
    $html2 .= showGraph($base64, "Usuarios nuevos");

    $base64 = renderImg($datosReporte['arrayDatos']['partidasGrafico']);
    $html2 .= showGraph($base64, "Datos de partidas");

    //INFO DEMAS
    $html2 .= renderizar($datosReporte['arrayDatos']['totalUsuarios'], "Total de usuarios en la aplicación");
    $html2 .= renderizar($datosReporte['arrayDatos']['totalJugadores'], "Total de jugadores en la aplicación");
    $html2 .= renderizar($datosReporte['arrayDatos']['totalEditores'], "Total de editores en la aplicación");
    $html2 .= renderizar($datosReporte['arrayDatos']['totalAdministradores'], "Total de administradores en la aplicación");
    $html2 .= renderizar($datosReporte['arrayDatos']['totalJugadoresConAlMenosUnaPartida'], "Total de jugadores con al menos 1 partida");
    $html2 .= renderizar($datosReporte['arrayDatos']['cantidadPartidasJugadas'], "Cantidad de partidas jugadas");
    $html2 .= renderizar($datosReporte['arrayDatos']['cantidadPreguntas'], "Cantidad de preguntas");
    $html2 .= renderizar($datosReporte['arrayDatos']['cantidadUsuariosNuevosDesdeFecha'], "Cantidad de usuarios nuevos desde la fecha");
    $html2 .= renderizar($datosReporte['arrayDatos']['porcentajePreguntasAcertadas'], "Porcentaje de preguntas acertadas");
    $html2 .= renderizar($datosReporte['arrayDatos']['porcentajePreguntasAcertadasPorUsuario'], "Porcentaje de aciertos por usuario");
    $html2 .= renderizar($datosReporte['arrayDatos']['balanceTrampitas'], "Balance de trampitas por usuario");
    $html2 .= renderizar($datosReporte['arrayDatos']['cantidadTrampitas'], "Dinero ganado con trampitas");

    $dompdf->loadHtml($html2);
    $dompdf->render();
    header("Content-type: application/pdf");
    header("Content-Disposition: inline; filename=reporte.pdf");
    echo $dompdf->output();
}