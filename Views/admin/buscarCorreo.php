<?php

require_once('../../Config/conexion.php');
$con = new db();
$PDO = $con->conexion();

$correo = limpiarDato($_POST['correo']);

$data = $PDO->prepare("SELECT COUNT(`correo`) FROM `usuarios` WHERE `correo` = '" . $correo . "'");
$data->execute();
if ($data->fetchColumn() > 0) {
    echo "
 Esta dirección de correo ya está en uso. 
 ";
}

function limpiarDato($dato)
{
    return htmlspecialchars($dato, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}
