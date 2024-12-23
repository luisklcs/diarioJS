<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

define("SERVIDOR", "127.0.0.1:3306");
define("USUARIO", "u822807031_anteriior");
define("PASSWORD", "f4H~9b&KxO*");
define("BD", "u822807031_anterior");

$servidor = "mysql:host=" . SERVIDOR . ";dbname=" . BD;
try {
    $conexion = new PDO(
        $servidor,
        USUARIO,
        PASSWORD,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
    #echo "<script>alert('Conectado...')</script>" ;

} catch (PDOException $e) {
    // echo "<script>alert('Error...')</script>" ;
}

define("N_SERVIDOR", "127.0.0.1:3306");
define("N_USUARIO", "u822807031_u822807031");
define("N_PASSWORD", "f4H~9b&KxO*");
define("N_BD", "u822807031_D14r10Nu3v4");

$servidor = "mysql:host=" . N_SERVIDOR . ";dbname=" . N_BD;
try {
    $bd_nueva = new PDO(
        $servidor,
        N_USUARIO,
        N_PASSWORD,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
    #echo "<script>alert('Conectado...')</script>" ;

} catch (PDOException $e) {
    // echo "<script>alert('Error...')</script>" ;
}







# >--------- MIGRAR USUARIOS A LA NUEBA BD ----------------->
 
$query = "SELECT * FROM `usuarios`";
$docs = $conexion->prepare($query);
$docs->execute();

$data = $docs->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";

foreach ($data as $key => $Usuario) {
  #  print_r($Usuario);

    $fecha_registro = $Usuario['fecha_registro'];
    $fecha_registro = $Usuario['fecha_registro'];
   
    // Obtener el año actual
    $anio_actual = date('Y');

    // Obtener el mes actual
    $mes_actual = date('m');
    $mes_siguiente = date('m', strtotime('+1 month', mktime(0, 0, 0, $mes_actual, 1)));

    $dia_actual = date('d');
 

    $mes_registro = date('m', strtotime($fecha_registro));
    $dia_registro = date('d', strtotime($fecha_registro));

    if ($mes_registro > $mes_actual) {

        if ($dia_actual > $dia_registro) {
            $fecha_cobro = $anio_actual . '-' . $mes_siguiente . '-' . $dia_registro;
        } else {
            $fecha_cobro = $anio_actual . '-' . $mes_actual . '-' . $dia_registro;
        }
       

    } elseif ($mes_registro < $mes_actual) {

        echo "<pre>";
        if ($dia_actual > $dia_registro) {
            $fecha_cobro = $anio_actual . '-' . $mes_siguiente . '-' . $dia_registro;
        } else {
            $fecha_cobro = $anio_actual . '-' . $mes_actual . '-' . $dia_registro;
        }
       
    } elseif ($mes_registro = $mes_actual) {
        if ($dia_actual > $dia_registro) {
            $fecha_cobro = $anio_actual . '-' . $mes_siguiente . '-' . $dia_registro;
        } else {
            $fecha_cobro = $anio_actual . '-' . $mes_actual . '-' . $dia_registro;
        }
      
    }

    #<--------------Iniciar transacción para ejecutar todas las consultas ----------->
    try {
        $bd_nueva->beginTransaction();

        #<--------------INSERTAR DATOS EN TABLA USUARIO ----------->
        $query = "INSERT INTO `usuarios` (`id_usuario`, `nombreUsuario`, `apellidos`, `identificacion`, `correo`, 
        `telefono`, `telefono_secundario`, `direccion`, `passwords`, `estadoCuenta`, `rol`)
        VALUES (NULL, :nombreUsuario, :apellidos, :identificacion, :correo, :telefono, :telefono_secundario,
        :direccion, :passwords, :estadoCuenta, :rol)";

        $insert_usuario = $bd_nueva->prepare($query);
        $insert_usuario->bindParam(':nombreUsuario', $Usuario['nombreUsuario']);
        $insert_usuario->bindParam(':apellidos', $Usuario['apellidos']);
        $insert_usuario->bindParam(':identificacion', $Usuario['identificacion']);
        $insert_usuario->bindParam(':correo', $Usuario['correo']);
        $insert_usuario->bindParam(':telefono', $Usuario['telefono']);
        $insert_usuario->bindParam(':telefono_secundario', $Usuario['telefono_secundario']);
        $insert_usuario->bindParam(':direccion', $Usuario['direccion']);
        $password_hash = password_hash($Usuario['identificacion'], PASSWORD_DEFAULT);
        $insert_usuario->bindParam(':passwords', $password_hash);
        $insert_usuario->bindParam(':estadoCuenta', $Usuario['estadoCuenta']);
        $insert_usuario->bindParam(':rol', $Usuario['rol']);
        $insert_usuario->execute();

        $id_usuario = $bd_nueva->lastInsertId();

        #<--------------INSERTAR DATOS EN TABLA FECHAS ----------->
        $query = "INSERT INTO `fechas` (`id_fechas`, `id_usuario`, `f_registro`, `f_cobro`, `f_suspencion`,
            `f_reactivacion`)
            VALUES (NULL, :id_usuario, :f_registro, :f_cobro, NULL, NULL)";

        $insert_fechas = $bd_nueva->prepare($query);
        $insert_fechas->bindParam(':id_usuario', $id_usuario);
        $insert_fechas->bindParam(':f_registro', $fecha_registro);
        $insert_fechas->bindParam(':f_cobro', $fecha_cobro);
        $insert_fechas->execute();

        #<--------------INSERTAR DATOS EN TABLA PERMISOS ----------->
        $query = "INSERT INTO `permisos` (`id_permisos`, `id_usuario`, `restriccionDeVistas`, `impresion`, `cobro`)
            VALUES (NULL, :id_usuario, '1', '0', '1')";

        $insert_permisos = $bd_nueva->prepare($query);
        $insert_permisos->bindParam(':id_usuario', $id_usuario);
        $insert_permisos->execute();

        $bd_nueva->commit();
        echo "<pre>"; 
        echo "Permisos de Usuario asignados correctamente con id: ".$bd_nueva->lastInsertId();
    } catch (Exception $e) {
        $bd_nueva->rollBack();
        echo "Usuario No registrado " . $e->getMessage();
    }
}

echo "</pre>";  



#<---------------- CONFIGURAR VISTAS DE USUARIO  ------------------------->
 $query = "SELECT * FROM `usuarios`";
$usuarios = $bd_nueva->prepare($query);
$usuarios->execute();

 $users = $usuarios->fetchAll(PDO::FETCH_ASSOC);
#print_r($users);

foreach ($users as $key => $usuario) {
    echo "<pre>";
    $id = $usuario['id_usuario'];
    $query = "INSERT INTO `config_vistas_usuario` (`id_config_vista`, `id_usuario`, `vistas_asignadas`, `personalizadas`) VALUES (NULL, '.$id.', '3', '0')";
    $ins = $bd_nueva->prepare($query);
   if ($ins->execute()) {
   echo "Configuración asignada correctamente con id: ".$bd_nueva->lastInsertId();
   }
} 







# ------------- INSERTAR DOCUMENTOS EN LA NUEVA BD ----------------->
 $query = "SELECT * FROM `documentos`";
$get_documents = $conexion->prepare($query);
$get_documents->execute();

$data = $get_documents->fetchAll(PDO::FETCH_ASSOC);

#print_r($data);

foreach ($data as $key => $info_documento) {
    echo "<pre>";
      # print_r($info_documento);

   $query = "INSERT INTO `documentos` (`id_documento`, `nombre`, `fecha`, `url`) 
   VALUES (NULL, '".$info_documento['nombre']."', '".$info_documento['fecha']."', '".$info_documento['url']."')";

   $insert_documento = $bd_nueva->prepare($query);
   $insert_documento->execute();
   if ($insert_documento->rowCount()>0) {
    echo $key." Documento insertado con id: ". $bd_nueva->lastInsertId();
   }
   echo "</pre>";
} 


 #<---------------- LEER VISTAS EN BD ANTERIOR ------------------------->
 
$query = "SELECT * FROM `vistas`";

$data_vistas = $conexion->prepare($query);
$data_vistas->execute();

$vistas = $data_vistas->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
#print_r($vistas);


 foreach ($vistas as $key => $info_vistas) {
    echo "<pre>";
    print_r($info_vistas);
 print_r($info_vistas['id_documento']-14); 

$query = "INSERT INTO `vistas` (`id_vistas`, `id_usuario`, `id_documento`, `vistas_usadas_hoy`, 
`total_vistas_usadas`, `fecha_primera_vista`, `fecha_ultima_vista`) 
VALUES (NULL, '".$info_vistas['id_usuario']."', '".$info_vistas['id_documento']-14 ."', '".$info_vistas['vistasHoy']."',
 '".$info_vistas['totalVistas']."', '".$info_vistas['fechaVistas']."', '".$info_vistas['fechaVistas']."')";

 $insert_vistas = $bd_nueva->prepare($query);
 $insert_vistas ->execute();

 if ($insert_vistas->rowCount()>0) {
    echo "Vista Insertada Correctamente con id: ".$bd_nueva->lastInsertId();
 }
    echo "</pre>";
} 


?>

