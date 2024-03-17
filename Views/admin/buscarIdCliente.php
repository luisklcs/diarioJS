<?php

require_once(dirname(dirname(__DIR__)) . '/Config/conexion.php');
$con = new db();
$PDO = $con->conexion();

if ($_POST) {
    $data = limpiarDato($_POST['cliente']);
    /*  echo $data; */

    $infoCliente = "";
    $query = "SELECT us.id_usuario, us.nombreUsuario, us.apellidos, 
    us.correo, us.identificacion, fc.f_registro, fc.f_suspencion, 
    fc.f_reactivacion FROM usuarios us INNER JOIN fechas fc
    ON fc.id_usuario = us.id_usuario WHERE `rol` = 2 AND `nombreUsuario` LIKE '%" . $data . "%' OR `apellidos` LIKE  '%" . $data . "%'  OR `correo` LIKE  '%" . $data . "%'  ";

    $clientes = $PDO->prepare($query);
    $clientes->execute();

    if ($clientes->rowCount() > 0) {
        /*   $cliente = $cliente->fetchAll(PDO::FETCH_ASSOC); */
        $id = "";
      

        while ($cliente = $clientes->fetch(PDO::FETCH_ASSOC)) {

       
            $id = $cliente['id_usuario'];
           
        }
    }
  
    echo $id;
}

function limpiarDato($dato)
{
    return htmlspecialchars($dato, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}
