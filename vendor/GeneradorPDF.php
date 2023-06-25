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

$dompdf = new Dompdf();
ob_start();
include_once "helpers/RenderizadorImagenDomPDF.php";
$html = ob_get_clean();
$dompdf->loadHtml($html);
$dompdf->render();
header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=documento.pdf");
echo $dompdf->output();