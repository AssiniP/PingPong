<?php
$nombreImagen = SITE_ROOT . "/public/bandmember.jpg";
$imagenBase64 = "data:image/png;base64," . base64_encode(file_get_contents($nombreImagen));
?>

<body>
Aquí una imagen:
<br>
<img src="<?php echo $imagenBase64 ?>" />

</body>
