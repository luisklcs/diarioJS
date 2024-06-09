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
    public function myFechaDeVistas($id){
        $conexion = new db();
        $pdo = $conexion->conexion();
        
        $query = "SELECT `desde` FROM `fechas` WHERE `id_usuario` = :idUser";
        $FechaRegistro = $pdo->prepare($query);
        $FechaRegistro->bindparam(':idUser', $id, PDO::PARAM_INT);
        $FechaRegistro->execute();
       return $FechaRegistro->fetchColumn();

    }

    public function impresionStatus($id){
        $conexion = new db();
        $pdo = $conexion->conexion();
        
        $query = "SELECT `impresion` FROM `permisos` WHERE `id_usuario` = :idUser";
        $impresion = $pdo->prepare($query);
        $impresion->bindparam(':idUser', $id, PDO::PARAM_INT);
        $impresion->execute();
       return $impresion->fetchColumn();
    }
    
}



?>