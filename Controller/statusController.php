<?php

require_once(dirname(__DIR__).'/Config/conexion.php');

final class statusController {

    public function myStatus($id){
        $conexion = new db();
        $pdo = $conexion->conexion();
        
        $query = "SELECT `estadoCuenta` FROM `usuarios` WHERE `id_usuario` = :idUser";
        $status = $pdo->prepare($query);
        $status->bindparam(':idUser', $id, PDO::PARAM_INT);
        $status->execute();
       return $status->fetchColumn();
    }
    public function myFechaDeRegistro($id){
        $conexion = new db();
        $pdo = $conexion->conexion();
        
        $query = "SELECT `f_registro` FROM `fechas` WHERE `id_usuario` = :idUser";
        $FechaRegistro = $pdo->prepare($query);
        $FechaRegistro->bindparam(':idUser', $id, PDO::PARAM_INT);
        $FechaRegistro->execute();
       return $FechaRegistro->fetchColumn();

    }
    
}



?>