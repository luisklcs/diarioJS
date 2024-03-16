<?php

 require_once(dirname(__DIR__).'/Config/conexion.php');
 $con = new db();
$PDO = $con->conexion();

 // Función para limpiar un dato individual
function limpiarDato($dato)
{
    return htmlspecialchars($dato, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}



$correo = limpiarDato($_POST['correo']);

$data = $this->PDO->prepare("SELECT COUNT(`correo`) FROM `usuarios` WHERE `correo` = '". $correo."'");
$data->execute();
if ($data->fetchColumn()>0) {
 echo "
 Esta dirección de correo ya está en uso.
 ";
} 


?>