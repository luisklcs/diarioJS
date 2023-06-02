<?php

class Clientes
{
  private $PDO;
  public function __construct()
  {
    require_once(dirname(__DIR__) . '/Config/conexion.php');

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

  public function listar($inicio, $limite)
  {

    #LISTA DE CLIENTES CON LIMITE
    $m = new Clientes();
    $i = $m->limpiarDato($inicio);
    $l = $m->limpiarDato($limite);


    $query = "SELECT * FROM `usuarios`  WHERE `rol` = 2 LIMIT $i , $l";
    $listar = $this->PDO->prepare($query);
    $listar->execute();
    $clientes['clientes'] = $listar;
    $clientes['n'] = $listar->rowCount();
    return $clientes;
  }
  public function registrar($data)
  {
    #LIMPIAR DATOS
    $nombre = strip_tags($data['nombre']);
    $nombre = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
    $nombre = addslashes($nombre);

    $apellidos = strip_tags($data['apellidos']);
    $apellidos = htmlspecialchars($apellidos, ENT_QUOTES, 'UTF-8');
    $apellidos = addslashes($apellidos);
    $nombre = addslashes($nombre);

    $identificacion = strip_tags($data['identificacion']);
    $identificacion = htmlspecialchars($identificacion, ENT_QUOTES, 'UTF-8');
    $identificacion = addslashes($identificacion);

    $correo = strip_tags($data['correo']);
    $correo = htmlspecialchars($correo, ENT_QUOTES, 'UTF-8');
    $correo = addslashes($correo);

    $telefono = strip_tags($data['telefono']);
    $telefono = htmlspecialchars($telefono, ENT_QUOTES, 'UTF-8');
    $telefono = addslashes($telefono);

    if (!empty($data['telefonoSec'])) {
      $telefonoSec = strip_tags($data['telefonoSec']);
      $telefonoSec = htmlspecialchars($telefonoSec, ENT_QUOTES, 'UTF-8');
      $telefonoSec = addslashes($telefonoSec);
    } else {
      $telefonoSec = null;
    }

    $direccion = strip_tags($data['direccion']);
    $direccion = htmlspecialchars($direccion, ENT_QUOTES, 'UTF-8');
    $direccion = addslashes($direccion);

    $estadoCuenta = strip_tags($data['estadoCuenta']);
    $estadoCuenta = htmlspecialchars($estadoCuenta, ENT_QUOTES, 'UTF-8');
    $estadoCuenta = addslashes($estadoCuenta);

    $impresion = strip_tags($data['impresion']);
    $impresion = htmlspecialchars($impresion, ENT_QUOTES, 'UTF-8');
    $impresion = addslashes($impresion);

    $restriccionVistas = strip_tags($data['restriccionVistas']);
    $restriccionVistas = htmlspecialchars($restriccionVistas, ENT_QUOTES, 'UTF-8');
    $restriccionVistas = addslashes($restriccionVistas);

    $cobro = strip_tags($data['cobro']);
    $cobro = htmlspecialchars($cobro, ENT_QUOTES, 'UTF-8');
    $cobro = addslashes($cobro);

    $accion = strip_tags($data['accion']);
    $accion = htmlspecialchars($accion, ENT_QUOTES, 'UTF-8');
    $accion = addslashes($accion);
    $rol = 2;

    #GENERAR PASSWORD CON NUM IDENTIFICACION
    $salt = bin2hex(random_bytes(16));
    $contrasena_con_salt = $identificacion . $salt;
    // Encriptar la contraseña con el salt
    $pass = password_hash($contrasena_con_salt, PASSWORD_ARGON2ID);

    #INSERTAR DATOS DE USUARIO
    $query = "INSERT INTO `usuarios` (`id_usuario`, `nombreUsuario`, `apellidos`, `identificacion`, `correo`, `telefono`, `telefono_secundario`, `direccion`, `passwords`, `salt`, `estadoCuenta`, `rol`)
    VALUES (NULL, :nombre, :apellidos, :identificacion, :correo, :telefono, :telefonoSec, :direccion, :passw, :salt, :estadoCuenta, :rol);";
    $insertar = $this->PDO->prepare($query);

    $insertar->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $insertar->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
    $insertar->bindParam(':identificacion', $identificacion, PDO::PARAM_STR);
    $insertar->bindParam(':correo', $correo, PDO::PARAM_STR);
    $insertar->bindParam(':telefono', $telefono, PDO::PARAM_STR);
    $insertar->bindParam(':telefonoSec', $telefonoSec, PDO::PARAM_STR);
    $insertar->bindParam(':direccion', $direccion, PDO::PARAM_STR);
    $insertar->bindParam(':passw', $pass, PDO::PARAM_STR);
    $insertar->bindParam(':salt', $salt, PDO::PARAM_STR);
    $insertar->bindParam(':estadoCuenta', $estadoCuenta, PDO::PARAM_INT);
    $insertar->bindParam(':rol', $rol, PDO::PARAM_INT);
    $insertar->execute();
    if ($insertar->rowCount() > 0) {
      $id = $this->PDO->lastInsertId();


      #INSERTAR FECHAS DE REGISTRO Y COBRO
      $fechaActual = date("Y-m-d");
      $fechaCobro = date("Y-m-d", strtotime($fechaActual . " +30 days"));

      $query = "INSERT INTO `fechas` (`id_fechas`, `id_usuario`, `f_registro`, `f_cobro`, `f_suspencion`, `f_reactivacion`)
    VALUES (NULL, :lastID, :actual, :cobro, NULL, NULL);";
      $insertar = $this->PDO->prepare($query);
      $insertar->bindParam(':lastID', $id, PDO::PARAM_INT);
      $insertar->bindParam(':actual', $fechaActual, PDO::PARAM_STR);
      $insertar->bindParam(':cobro', $fechaCobro, PDO::PARAM_STR);
      $insertar->execute();
      if ($insertar->rowCount() > 0) {
        return true;
      }
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

    if ($permisos->rowCount() > 0 && $data->rowCount() > 0) {
      $datos['datos'] = $data->fetch(PDO::FETCH_ASSOC);
      $datos['permisos'] = $permisos->fetch(PDO::FETCH_ASSOC);
      return $datos;
    }
  }

  public function actualizar($data)
  {
    $m = new Clientes();
    $dataOk = $m->limpiarDatosPost($data);
    if (empty($dataOk['telefonoSec'])) {
      $dataOk['telefonoSec'] = NULL;
    }

    $query = "UPDATE `usuarios` SET `nombreUsuario` = :nombre , `apellidos` = :apellidos , `identificacion` = :identificacion,
    `correo` = :correo, `telefono` = :telefono, `telefono_secundario` = :secundario, `direccion` = :direccion, `estadoCuenta` = :estadoCuenta
     WHERE `usuarios`.`id_usuario` = :idCliente";
    $act = $this->PDO->prepare($query);

    $act->bindParam(':nombre', $dataOk['nombre'], PDO::PARAM_STR);
    $act->bindParam(':apellidos', $dataOk['apellidos'], PDO::PARAM_STR);
    $act->bindParam(':identificacion', $dataOk['identificacion'], PDO::PARAM_STR);
    $act->bindParam(':correo', $dataOk['correo'], PDO::PARAM_STR);
    $act->bindParam(':telefono', $dataOk['telefono'], PDO::PARAM_STR);
    $act->bindParam(':secundario', $dataOk['telefonoSec'], PDO::PARAM_STR);
    $act->bindParam(':direccion', $dataOk['direccion'], PDO::PARAM_STR);
    $act->bindParam(':estadoCuenta', $dataOk['estadoCuenta'], PDO::PARAM_STR);
    $act->bindParam(':idCliente', $dataOk['idCliente'], PDO::PARAM_INT);
    $act->execute();
    $ac = 0;

    if ($act->rowCount() > 0) {
      $ac = 1;
    }

    $query = "UPDATE `permisos` SET `impresion` = :impresion, `restriccionDeVistas` = :restriccionVistas, 
    `cobro` = :cobro WHERE `permisos`.`id_usuario` = :idCliente";
    $perm = $this->PDO->prepare($query);
    $perm->bindParam(':impresion', $dataOk['impresion'], PDO::PARAM_INT);
    $perm->bindParam(':restriccionVistas', $dataOk['restriccionVistas'], PDO::PARAM_INT);
    $perm->bindParam(':cobro', $dataOk['cobro'], PDO::PARAM_INT);
    $perm->bindParam(':idCliente', $dataOk['idCliente'], PDO::PARAM_INT);
    $perm->execute();

    if ($perm->rowCount() > 0) {
      $ac++;
    }

    return $ac;
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
    $query = "SELECT dc.fecha, vs.id_vistas, vs.asignadas, vs.asignadasGeneral, vs.vistasHoy, vs.vistasUsadas, vs.fechaPrimerVista,
  vs.fechaUltimaVista FROM vistas vs INNER JOIN documentos dc ON vs.id_documento = dc.id_documento WHERE vs.id_usuario = $id";
    $vst = $this->PDO->prepare($query);
    $vst->execute();
    unset($_SESSION['id']);
    if ($vst->rowCount() > 0) {
      $vistas = $vst;
      return $vistas;
    }
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
