<?php

require_once('Config/conexion.php');
$conexion = new db();

$pdo = $conexion->conexion();

$query = "SELECT * FROM `fechas` ";
$fechasRegistro = $pdo->prepare($query);
$fechasRegistro->execute();
$fechas = $fechasRegistro->fetchAll(PDO::FETCH_ASSOC);

foreach ($fechas as $fecha) {
    $query = "UPDATE `fechas` SET `desde`  = '" . $fecha['f_registro'] . "' WHERE `id_usuario` = '" . $fecha['id_usuario'] . "'";
    $fechasRegistro = $pdo->prepare($query);
    if ($fechasRegistro->execute()) {
        echo "Actualizado correctamente";
    } else {
        echo "Error al actualizar";
    }
   
}
