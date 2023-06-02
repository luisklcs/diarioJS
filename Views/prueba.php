



<?php


require dirname(__DIR__).'/Config/conexion.php';
$con = new db();
$c = $con->conexion();
$query = "SELECT * FROM `usuarios`  WHERE `rol` = 2 ";
$listar = $c->prepare($query);
$listar->execute();

echo "<pre>";
while ($cl = $listar->fetch(PDO::FETCH_ASSOC)) {
   print_r($cl); 
   echo "<pre>";


    #GENERAR PASSWORD CON NUM IDENTIFICACION
    $salt = bin2hex(random_bytes(16));
    $contrasena_con_salt = $cl['identificacion'] . $salt;
    // Encriptar la contraseña con el salt
    $pass = password_hash($contrasena_con_salt, PASSWORD_ARGON2ID);

    #echo $pass;
    $query = "UPDATE `usuarios` SET `passwords` = :passw, `salt` = :salt WHERE `usuarios`.`id_usuario` = :idU ";
    $act = $c->prepare($query);
    $act ->bindParam(':passw',$pass,PDO::PARAM_STR);
    $act ->bindParam(':salt',$salt,PDO::PARAM_STR);
    $act ->bindParam(':idU',$cl['id_usuario'],PDO::PARAM_STR);
    $act->execute();

}







?>
