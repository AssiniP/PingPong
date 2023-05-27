<?php

class GenerarQRController {
    private $renderer;
    private $userModel;
    public function __construct($userModel, $renderer) {
        $this->renderer = $renderer;
        $this->userModel = $userModel;
    }
    public function list() {
        $this->renderer->render('generarQR');
    }

    public function show() {

    }


// Nombre del archivo de imagen QR
//$filename = "/public/qr-perfil/qr_code_" . $code . ".png";
//$filename="hola";
//echo $filename;

// Tamaño y nivel de corrección del código QR
//$size = 10;
//$level = 'L';

// Generar el código QR
//QRcode::png($code, $filename, $level, $size);

// Mostrar la imagen QR generada
//echo "<img src='" . $filename . "' alt="QR Code'>";

}