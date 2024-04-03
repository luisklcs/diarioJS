<?php

class loginModel
{

    private $PDO;


    public function __construct()
    {
        require_once(dirname(__DIR__) . '/Config/conexion.php');

        $con = new db();
        $this->PDO = $con->conexion();
    }

    public function autenticacion($mail, $pass)
    {
        $query = 'SELECT `id_usuario`,`passwords` FROM `usuarios` WHERE `correo` = ' . ":mail" . '';
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(':mail', $mail);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($pass, $fila['passwords'])) {
                $query = "SELECT `id_usuario` ,`nombreUsuario`,`apellidos`,`estadoCuenta`,`rol` FROM `usuarios` WHERE `id_usuario` = :idUser";
                $stmt = $this->PDO->prepare($query);
                $stmt->bindParam(':idUser', $fila['id_usuario'], PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT, 11);
                $stmt->execute();
                $userData = $stmt->fetch(PDO::FETCH_ASSOC);
                return $userData;
            }
        }
        return false;
        exit;
    }

    public function actualizarPass($actual, $nueva, $id)
    {
        $query = "SELECT `passwords` FROM `usuarios` WHERE `id_usuario` = :idUser";
        $pass = $this->PDO->prepare($query);
        $pass->bindParam(':idUser', $id, PDO::PARAM_INT);
        $pass->execute();
        $pass = $pass->fetchColumn();
        if (password_verify($actual, $pass)) {
            $nueva = password_hash($nueva, PASSWORD_DEFAULT);
            $query = "UPDATE `usuarios` SET `passwords` = :newPass WHERE `usuarios`.`id_usuario` = :idUser";
            $update = $this->PDO->prepare($query);
            $update->bindParam(':newPass', $nueva, PDO::PARAM_STR,255);
            $update->bindParam(':idUser', $id, PDO::PARAM_INT);
            return ($update->execute()) ? true : false;
        }
    }
    public function actualizarPassCliente($nueva, $id)
    {
       
            $nueva = password_hash($nueva, PASSWORD_DEFAULT);
            $query = "UPDATE `usuarios` SET `passwords` = :newPass WHERE `usuarios`.`id_usuario` = :idUser";
            $update = $this->PDO->prepare($query);
            $update->bindParam(':newPass', $nueva, PDO::PARAM_STR,255);
            $update->bindParam(':idUser', $id, PDO::PARAM_INT);
           return ($update->execute()) ? true : false;
        
    }


}
