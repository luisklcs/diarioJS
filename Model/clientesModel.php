<?php

class Clientes
{
  private $PDO;
  public function __construct()
  {
    require_once('../../Config/conexion.php');

    $con = new db();
    $this->PDO = $con->conexion();
  }
  public function cantidad()
  {
    #CONTAR CLIENTES
    $query = "SELECT COUNT(*) FROM `usuarios`  WHERE `rol` = 2";
    $listar = $this->PDO->prepare($query);
    $listar->execute();
    return $cantidad = $listar->fetchColumn();
  }

  public function buscarVistasGenerages()
  {
    $query = "SELECT `vistas_generales` FROM `vistas_generales` WHERE `id_vistas_generales` = 1;";
    $vg = $this->PDO->prepare($query);
    $vg->execute();
    if ($vg->rowCount() > 0) {
      $generales = $vg->fetch(PDO::FETCH_ASSOC);
      return $generales;
    } else {
      return 0;
    }
  }
  public function listar($inicio, $limite)
  {

    #LISTA DE CLIENTES CON LIMITE
    $m = new Clientes();
    $i = $m->limpiarDato($inicio);
    $l = $m->limpiarDato($limite);


    $query = "SELECT us.id_usuario, us.nombreUsuario, us.apellidos, 
    us.correo, us.identificacion, fc.f_registro, fc.f_suspencion, 
    fc.f_reactivacion FROM usuarios us INNER JOIN fechas fc
     ON fc.id_usuario = us.id_usuario WHERE `rol` = 2 LIMIT $i , $l";
    $listar = $this->PDO->prepare($query);
    $listar->execute();
    $clientes['clientes'] = $listar;
    $clientes['n'] = $listar->rowCount();
    return $clientes;
  }
  public function registrar($data)
  {

    #LIMPIAR DATOS
    $m = new Clientes();
    $data = $m->limpiarDatosPost($data);

    # print_r($data);

    if (empty($data['telefonoSec'])) {
      $telefonoSec = null;
    }




    if ($data['vistas_asignadas'] > $data['generales']) {
      $personalizado = 1;
    } else {
      $personalizado = 0;
    }

    $rol = 2;
    $pass = password_hash($data['identificacion'], PASSWORD_DEFAULT);
    $status = 0;



    try {
      $this->PDO->beginTransaction();

      // INSERTAR DATOS DE USUARIO
      $query = "INSERT INTO `usuarios` (`id_usuario`, `nombreUsuario`, `apellidos`, `identificacion`, `correo`, `telefono`, `telefono_secundario`, `direccion`, `passwords`,  `estadoCuenta`, `rol`)
      VALUES (NULL, :nombre, :apellidos, :identificacion, :correo, :telefono, :telefonoSec, :direccion, :passw,  :estadoCuenta, :rol);";
      $insertarUsuario = $this->PDO->prepare($query);

      $insertarUsuario->bindParam(':nombre', $data['nombre'], PDO::PARAM_STR);
      $insertarUsuario->bindParam(':apellidos', $data['apellidos'], PDO::PARAM_STR);
      $insertarUsuario->bindParam(':identificacion', $data['identificacion'], PDO::PARAM_STR);
      $insertarUsuario->bindParam(':correo', $data['correo'], PDO::PARAM_STR);
      $insertarUsuario->bindParam(':telefono', $data['telefono'], PDO::PARAM_STR);
      $insertarUsuario->bindParam(':telefonoSec', $data['telefonoSec'], PDO::PARAM_STR);
      $insertarUsuario->bindParam(':direccion', $data['direccion'], PDO::PARAM_STR);
      $insertarUsuario->bindParam(':passw', $pass, PDO::PARAM_STR);
      $insertarUsuario->bindParam(':estadoCuenta', $data['estadoCuenta'], PDO::PARAM_INT);
      $insertarUsuario->bindParam(':rol', $rol, PDO::PARAM_INT);
      $insertarUsuario->execute();

      $id = $this->PDO->lastInsertId();

      # INSERTAR FECHAS DE REGISTRO Y COBRO
      $fechaActual = date("Y-m-d");
      $fechaCobro = date("Y-m-d", strtotime($fechaActual . " +30 days"));

      $query = "INSERT INTO `fechas` (`id_fechas`, `id_usuario`, `f_registro`, `f_cobro`, `f_suspencion`, `f_reactivacion`)
      VALUES (NULL, :lastID, :actual, :cobro, NULL, NULL);";
      $insertarFechas = $this->PDO->prepare($query);

      $insertarFechas->bindParam(':lastID', $id, PDO::PARAM_INT);
      $insertarFechas->bindParam(':actual', $fechaActual, PDO::PARAM_STR);
      $insertarFechas->bindParam(':cobro', $fechaCobro, PDO::PARAM_STR);
      $insertarFechas->execute();

      $query = "INSERT INTO `config_vistas_usuario` (`id_config_vista`, `id_usuario`, `vistas_asignadas`, `personalizadas`) VALUES (NULL, :id_usuario, :vistas_asignadas, :personalizadas)";
      $insertarConfigVistas = $this->PDO->prepare($query);

      $insertarConfigVistas->bindParam(':id_usuario', $id, PDO::PARAM_INT);
      $insertarConfigVistas->bindParam(':vistas_asignadas', $data['vistas_asignadas'], PDO::PARAM_INT);
      $insertarConfigVistas->bindParam(':personalizadas', $personalizado, PDO::PARAM_INT);
      $insertarConfigVistas->execute();

      $query = "INSERT INTO `permisos` (`id_permisos`, `id_usuario`, `restriccionDeVistas`, `impresion`, `cobro`) VALUES (NULL, :lastID, :restriccionVistas, :impresion, :cobro)";
      $insertarPermisos = $this->PDO->prepare($query);

      $insertarPermisos->bindParam(':lastID', $id, PDO::PARAM_INT);
      $insertarPermisos->bindParam(':restriccionVistas', $data['restriccionVistas'], PDO::PARAM_INT);
      $insertarPermisos->bindParam(':impresion', $data['impresion'], PDO::PARAM_INT);
      $insertarPermisos->bindParam(':cobro', $data['cobro'], PDO::PARAM_INT);
      $insertarPermisos->execute();

      // Si llegamos hasta aquí, todas las operaciones fueron exitosas
      $this->PDO->commit();
      $status = 4;  // O cualquier otro valor que necesites
    } catch (PDOException $e) {
      // Manejar errores de PDO
      $this->PDO->rollBack();
      echo "Error: " . $e->getMessage();
      # return false;
    } finally {
      // Cerrar la conexión
      $this->PDO = null;
      return true;
    }
  }

  public function datosCliente($i)
  {
    $m = new Clientes();
    $id = $m->limpiarDato($i);
    $query = "SELECT * FROM `usuarios` WHERE `id_usuario` = :idCliente;";
    $data = $this->PDO->prepare($query);
    $data->bindParam(':idCliente', $id, PDO::PARAM_INT);
    $data->execute();

    $query = "SELECT * FROM `permisos` WHERE `id_usuario` = :idCliente;";
    $permisos = $this->PDO->prepare($query);
    $permisos->bindParam(':idCliente', $id, PDO::PARAM_INT);
    $permisos->execute();

    $query = "SELECT `vistas_asignadas` FROM `config_vistas_usuario` WHERE `id_usuario` = :idCliente;";
    $vistas = $this->PDO->prepare($query);
    $vistas->bindParam(':idCliente', $id, PDO::PARAM_INT);
    $vistas->execute();


    $datos['datos'] = $data->fetch(PDO::FETCH_ASSOC);
    $datos['permisos'] = $permisos->fetch(PDO::FETCH_ASSOC);
    $datos['vistas'] = $vistas->fetchColumn();
    return $datos;
  }

  public function actualizar($data)
  {
    #--------LIMPIAR DATOS POST----------
    $m = new Clientes();

    $dataOk = $m->limpiarDatosPost($data);

    if (empty($dataOk['telefonoSec'])) {
      $dataOk['telefonoSec'] = NULL;
    }


    $idUsuario =  $dataOk['idCliente'];


    $gral = $m->buscarVistasGenerages();
    $gral = $gral['vistas_generales'];

    $estado['vista general'] = $gral;

    $statusForm =  $dataOk['estadoCuenta'];
    
   # print_r($dataOk);
    # <-------------------- CONSULTAR ESTADO DEL CLIENTE -------------------------------->

    $query = "SELECT `estadoCuenta` FROM `usuarios` WHERE `id_usuario` = ".$idUsuario;
    $statusDB = $this->PDO->prepare($query);
    $statusDB->execute();
    $statusDB = $statusDB->fetchColumn();
   

    if ($statusDB == 1 && $statusForm == 0 ){
    
    # <-------------------- ACTUALIZAR FECHAS DE SUSPENSIÓN -------------------------------->
    $fechaActual = date("Y-m-d");
    $query = "UPDATE `fechas` SET `f_suspencion` = :fechaSuspension WHERE `fechas`.`id_usuario` = :idUsuario";
    $upFechas = $this->PDO->prepare($query);
    $upFechas->bindParam(':fechaSuspension', $fechaActual, PDO::PARAM_STR);
    $upFechas->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $upFechas->execute();
    if ($upFechas->rowCount() > 0) {
      $estado['fechas'] = "ok"; 
     # echo "Suspender cuenta";
    }
    
    # print_r($statusDB);
    
  } elseif ($statusDB == 0 && $statusForm == 1) {
    # <-------------------- ACTUALIZAR FECHAS DE REACTVACIÓN -------------------------------->
    $fechaActual = date("Y-m-d");
    $query = "UPDATE `fechas` SET `f_reactivacion` = :fechaReactivacion WHERE `fechas`.`id_usuario` = :idUsuario";
    $upFechas = $this->PDO->prepare($query);
    $upFechas->bindParam(':fechaReactivacion', $fechaActual, PDO::PARAM_STR);
    $upFechas->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $upFechas->execute();
    if ($upFechas->rowCount() > 0) {
      $estado['fechas'] = "ok";  }
 # echo "Activar cuenta";
  }

    
    #-------- ACTUALIZAR TABLA USUARIOS ----------
    $query = "UPDATE `usuarios` SET `nombreUsuario` = :nombre , `apellidos` = :apellidos , `identificacion` = :identificacion,
      `correo` = :correo, `telefono` = :telefono, `telefono_secundario` = :secundario, `direccion` = :direccion, `estadoCuenta` = :estadoCuenta
       WHERE `usuarios`.`id_usuario` = :idUsuario";
    $act = $this->PDO->prepare($query);

    $act->bindParam(':nombre', $dataOk['nombre'], PDO::PARAM_STR);
    $act->bindParam(':apellidos', $dataOk['apellidos'], PDO::PARAM_STR);
    $act->bindParam(':identificacion', $dataOk['identificacion'], PDO::PARAM_STR);
    $act->bindParam(':correo', $dataOk['correo'], PDO::PARAM_STR);
    $act->bindParam(':telefono', $dataOk['telefono'], PDO::PARAM_STR);
    $act->bindParam(':secundario', $dataOk['telefonoSec'], PDO::PARAM_STR);
    $act->bindParam(':direccion', $dataOk['direccion'], PDO::PARAM_STR);
    $act->bindParam(':estadoCuenta', $dataOk['estadoCuenta'], PDO::PARAM_INT);
    $act->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $act->execute();

    if ($act->rowCount() > 0) {

      $estado['datos usuario'] = "ok";
    }

    
    #-------- ACTUALIZAR TABLA PERMISOS ----------
    $query = "UPDATE `permisos` SET `impresion` = :impresion, `restriccionDeVistas` = :restriccionVistas, 
      `cobro` = :cobro WHERE `permisos`.`id_usuario` = :idUsuario";
    $perm = $this->PDO->prepare($query);
    $perm->bindParam(':impresion', $dataOk['impresion']);
    $perm->bindParam(':restriccionVistas', $dataOk['restriccionVistas']);
    $perm->bindParam(':cobro', $dataOk['cobro']);
    $perm->bindParam(':idUsuario', $idUsuario);
    $perm->execute();
    if ($perm->rowCount() > 0) {

      $estado['permisos'] = "ok";
    }

    #-------- ACTUALIZAR TABLA CONFIG_VISTA_USUARIOS ----------
    if ($dataOk['asignadas'] == $gral) {

      $query = "UPDATE `config_vistas_usuario` SET `vistas_asignadas` = '" . $dataOk['asignadas'] . "', `personalizadas` = '0'
    WHERE `config_vistas_usuario`.`id_usuario` = :idUsuario";
      $stmnt = $this->PDO->prepare($query);
      $stmnt->bindParam(':idUsuario', $idUsuario);
      $stmnt->execute();
      if ($stmnt->rowCount() > 0) {

        $estado['config vistas'] = "ok";
      }
    } else {

      $query = "UPDATE `config_vistas_usuario` SET `vistas_asignadas` = '" . $dataOk['asignadas'] . "',`personalizadas` = '1'
      WHERE  `config_vistas_usuario`.`id_usuario` = :idUsuario";
      $stmnt = $this->PDO->prepare($query);
      $stmnt->bindParam(':idUsuario', $idUsuario);
      $stmnt->execute();
      if ($stmnt->rowCount() > 0) {

        $estado['config vistas'] = "ok";
      }
    }




    return true; 
  }

  public function eliminarCliente($idCliente)
  {
    $m = new Clientes();
    $dataOk = $m->limpiarDato($idCliente);

    $query = "DELETE FROM usuarios WHERE `usuarios`.`id_usuario` = :idCliente";
    $del = $this->PDO->prepare($query);
    $del->bindParam(':idCliente', $dataOk, PDO::PARAM_INT);
    $del->execute();
    if ($del->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function vistasgenerales($i)
  {
    $m = new Clientes();
    $id = $m->limpiarDato($i);
    $query = "SELECT doc.fecha AS nombre_doc, vs.id_vistas, vs.vistas_usadas_hoy, vs.total_vistas_usadas,
    vs.fecha_primera_vista, vs.fecha_ultima_vista, cfvu.vistas_asignadas, us.nombreUsuario, us.apellidos
    FROM vistas vs INNER JOIN documentos doc ON vs.id_documento = doc.id_documento
    INNER JOIN config_vistas_usuario cfvu ON cfvu.id_usuario = vs.id_usuario
    INNER JOIN usuarios us ON vs.id_usuario = us.id_usuario WHERE vs.id_usuario = $id ORDER BY doc.fecha DESC";
    $vst = $this->PDO->prepare($query);
    $vst->execute();
    unset($_SESSION['id']);
    if ($vst->rowCount() > 0) {
      $vistas = $vst;
      return $vistas;
    } else {
      return 0;
    }
  }

  public function infoCuentaCliente($i)
  {
    $m = new Clientes();
    $id = $m->limpiarDato($i);
    $query = "SELECT `nombreUsuario` , `apellidos`, `identificacion`, `correo`, `telefono`, `telefono_secundario`, `direccion`, `estadoCuenta`, `f_registro`,`f_cobro` FROM `usuarios` INNER JOIN `fechas` ON fechas.id_usuario = usuarios.id_usuario WHERE usuarios.id_usuario = :idUsuario;";
    $data = $this->PDO->prepare($query);
    $data->bindParam(':idUsuario', $id, PDO::PARAM_INT);
    $data->execute();
    return $data->fetch(PDO::FETCH_ASSOC);
  }


  #LIMPIAR DATOS LIMPIAR DATOS LIMPIAR DATOS LIMPIAR DATOS LIMPIAR DATOS
  public function limpiarDatosPost($datosAlimpiar)
  {
    foreach ($datosAlimpiar as $key => $value) {
      if (is_array($value)) {
        // Si el valor es un arreglo, aplicar limpieza a cada elemento del arreglo
        $datosAlimpiar[$key] = $this->limpiarArreglo($value);
      } else {
        // Si el valor es un string, aplicar limpieza directamente
        $datosAlimpiar[$key] = $this->limpiarDato($value);
      }
    }
    return $datosAlimpiar;
  }

  // Función para limpiar un dato individual
  public function limpiarDato($dato)
  {
    $dato = strip_tags($dato);
    $dato = htmlspecialchars($dato, ENT_QUOTES, 'UTF-8');
    $dato = addslashes($dato);
    return $dato;
  }

  // Función para limpiar un arreglo de datos
  public function limpiarArreglo($arreglo)
  {
    foreach ($arreglo as $key => $value) {
      $arreglo[$key] = $this->limpiarDato($value);
    }
    return $arreglo;
  }
}
