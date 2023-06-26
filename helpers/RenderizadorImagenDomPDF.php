<?php
    function renderizar($info, $title){
        $html = '<h4>'.$title.':</h4><p>'.$info.'</p>';
        return $html;
    }
    function renderImg($img){
        $nombreImagen = SITE_ROOT ."/". $img;
        $imagenBase64 = "data:image/png;base64," . base64_encode(file_get_contents($nombreImagen));
        return $imagenBase64;
    }
    function showGraph($graph64, $title){
        $html = '<div style="text-align: center;"><h2>'.$title.'</h2></br><img src="'.$graph64.'"></div>';
        return $html;
    }

    function headerLogo($fechaFiltro, $img){
        $html = '<center><img style="max-width:80px;" src="'.$img.'"><h1>REPORTE DE PINGPONG</h1><p>Datos hasta el '.$fechaFiltro.'</p></center>';
        return $html;
    }
?>