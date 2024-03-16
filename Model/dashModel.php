<?php
class DashModel
{

    private $PDO;
    public function __construct()
    {
        require_once('../../Config/conexion.php');

        $con = new db();
        $this->PDO = $con->conexion();
    }
    public function dashboard()
    {
        
      #CONTAR CLIENTES
      $query = "SELECT COUNT(*) FROM `usuarios` WHERE `rol`=2 ";
      $listar = $this->PDO->prepare($query);
      $listar->execute();
      $clientes['CantidadClientes'] = $listar->fetchColumn();
      if ($clientes['CantidadClientes']>0) {
      
    
  
      #CONTAR DOCUMENTOS
      $query = "SELECT COUNT(*) FROM documentos";
      $listar = $this->PDO->prepare($query);
      $listar->execute();
      $clientes['CantDocumentos'] = $listar->fetchColumn();
  
      #CONTAR CLIENTES ACTIVOS
      $query = "SELECT COUNT(*) FROM `usuarios` WHERE `rol`=2 AND `estadoCuenta` = 1";
      $listar = $this->PDO->prepare($query);
      $listar->execute();
      $clientes['ClientesActivos'] = $listar->fetchColumn();
  
      #CONTAR CLIENTES INACTIVOS
      $query = "SELECT COUNT(*) FROM `usuarios` WHERE `rol`=2 AND `estadoCuenta` = 0";
      $listar = $this->PDO->prepare($query);
      $listar->execute();
      $clientes['ClientesInactivos'] = $listar->fetchColumn();
  
      #VISTAS GENERALES
      $query = "SELECT `vistas_generales` FROM `vistas_generales` WHERE `id_vistas_generales` = 1;";
      $listar = $this->PDO->prepare($query);
      $listar->execute();
      $generales = $listar->fetchColumn();
      $clientes['vistasGenerales'] = $generales;
  
      #NUM USUARIOS CON VISTAS MAYORES A GENERAL
      $query = "SELECT COUNT(`personalizadas`) FROM config_vistas_usuario cnf INNER JOIN usuarios Us
      ON cnf.id_usuario = Us.id_usuario WHERE  Us.estadoCuenta = 1 AND Us.rol = 2 AND cnf.personalizadas = 1";
      $listar = $this->PDO->prepare($query);
      $listar->execute();
      $clientes['personalizadas'] = $listar->fetchColumn();
  
      #VISTAS NO RESTRINGIDAS
      $query = "SELECT COUNT(`restriccionDeVistas`) FROM `permisos` Pe INNER JOIN usuarios Us
      ON Pe.id_usuario = Us.id_usuario WHERE Pe.restriccionDeVistas = 0 AND Us.estadoCuenta = 1 AND Us.rol = 2";
      $listar = $this->PDO->prepare($query);
      $listar->execute();
      $clientes['norestringidas'] = $listar->fetchColumn();
  
      #PERMISOS DE IMPRESION
      $query = "SELECT COUNT(`impresion`) FROM `permisos` Pe INNER JOIN usuarios Us
      ON Pe.id_usuario = Us.id_usuario WHERE Pe.impresion = 1 AND Us.estadoCuenta = 1 AND Us.rol = 2";
      $listar = $this->PDO->prepare($query);
      $listar->execute();
      $clientes['impresion'] = $listar->fetchColumn();
  
      #COBRO INACTIVO
      $query = "SELECT COUNT(`cobro`) FROM `permisos` Pe INNER JOIN usuarios Us
      ON Pe.id_usuario = Us.id_usuario WHERE Pe.cobro=0 AND Us.estadoCuenta = 1 AND Us.rol = 2";
      $listar = $this->PDO->prepare($query);
      $listar->execute();
      $clientes['cobroInactivo'] = $listar->fetchColumn();
      return $clientes;
      }else{
       $clientes['CantidadClientes'] = 0;
       $clientes['CantDocumentos'] = 0;
       $clientes['ClientesActivos'] = 0;
       $clientes['ClientesInactivos'] = 0;
       $clientes['vistasGenerales'] = 0;
       $clientes['mayoresAgeneral'] = 0;
       $clientes['norestringidas'] = 0;
       $clientes['impresion'] = 0;
       $clientes['cobroInactivo'] = 0;
       return $clientes;
      }
    }
   
    public function activas()
    {

        #CLIENTES ACTIVOS
        $query = "SELECT Us.`id_usuario`, Us.`nombreUsuario`, Us.`apellidos`, Us.`identificacion`, Us.`correo`, Vi.`vistas_asignadas`
        FROM `usuarios` Us INNER JOIN config_vistas_usuario Vi ON Vi.`id_usuario` = Us.`id_usuario` WHERE Us.`rol` = 2 AND Us.`estadoCuenta` = 1";
        $listar = $this->PDO->prepare($query);
        $listar->execute();
        return $listar;
    }

    public function inactivas()
    {

        #CLIENTES INACTIVOS
        $query = "SELECT Us.`id_usuario`, Us.`nombreUsuario`, Us.`apellidos`, Us.`identificacion`, Us.`correo`, Vi.`vistas_asignadas`
        FROM `usuarios` Us INNER JOIN config_vistas_usuario Vi ON Vi.`id_usuario` = Us.`id_usuario` WHERE Us.`rol` = 2 AND Us.`estadoCuenta` = 0 ";
        $listar = $this->PDO->prepare($query);
        $listar->execute();
        return $listar;
    }
    public function personalizadas()
    {

        #CLIENTES CON VISTAS PERSONALIZADAS
        $query = "SELECT Us.`id_usuario`, Us.`nombreUsuario`, Us.`apellidos`, Us.`identificacion`, Us.`correo`, Vi.`vistas_asignadas` FROM `usuarios` Us INNER JOIN config_vistas_usuario Vi ON Vi.`id_usuario` = Us.`id_usuario` WHERE Us.`rol` = 2 AND vi.personalizadas = 1 AND Us.`estadoCuenta` = 1;";
        $listar = $this->PDO->prepare($query);
        $listar->execute();
        return $listar;
    }
    public function Sinrestriccion()
    {

        #CLIENTES CON VISTAS PERSONALIZADAS
        $query = "SELECT Us.`id_usuario`, Us.`nombreUsuario`, Us.`apellidos`, Us.`identificacion`, Us.`correo`, Vi.`vistas_asignadas` 
        FROM `usuarios` Us INNER JOIN config_vistas_usuario Vi ON Vi.`id_usuario` = Us.`id_usuario` INNER JOIN permisos Pe ON Pe.id_usuario = Us.id_usuario
         WHERE Us.`rol` = 2 AND Us.`estadoCuenta` = 1 AND Pe.restriccionDeVistas=0;";
        $listar = $this->PDO->prepare($query);
        $listar->execute();
        return $listar;
    }
    public function impresion()
    {

        #CLIENTES CON VISTAS PERSONALIZADAS
        $query = "SELECT Us.`id_usuario`, Us.`nombreUsuario`, Us.`apellidos`, Us.`identificacion`, Us.`correo`, Vi.`vistas_asignadas`
         FROM `usuarios` Us INNER JOIN config_vistas_usuario Vi ON Vi.`id_usuario` = Us.`id_usuario` INNER JOIN permisos Pe ON Pe.id_usuario = Us.id_usuario
          WHERE Us.`rol` = 2 AND Us.`estadoCuenta` = 1 AND Pe.impresion = 1;";
        $listar = $this->PDO->prepare($query);
        $listar->execute();
        return $listar;
    }
    public function cobro()
    {

        #CLIENTES CON VISTAS PERSONALIZADAS
        $query = "SELECT Us.`id_usuario`, Us.`nombreUsuario`, Us.`apellidos`, Us.`identificacion`, Us.`correo`, Vi.`vistas_asignadas`
         FROM `usuarios` Us INNER JOIN config_vistas_usuario Vi ON Vi.`id_usuario` = Us.`id_usuario` INNER JOIN permisos Pe ON Pe.id_usuario = Us.id_usuario
          WHERE Us.`rol` = 2 AND Us.`estadoCuenta` = 1 AND Pe.cobro=0;";
        $listar = $this->PDO->prepare($query);
        $listar->execute();
        return $listar;
    }
     public function actualizarVistasGenerales($actl,$nvo)
    {
        $d = new DashModel();
        $actual = $d->limpiarDato($actl);
        $nuevo = $d->limpiarDato($nvo);

        #ACTUALIZAR GENERALES
        $query = "UPDATE vistas_generales SET `vistas_generales` = :nuevo";
        $nuevovalor = $this->PDO->prepare($query);
        $nuevovalor ->bindParam(':nuevo',$nuevo,PDO::PARAM_INT);
        $nuevovalor->execute();
       
        #ACTUALIZAR ASIGNADAS 
        $query = "UPDATE `config_vistas_usuario` SET `vistas_asignadas` = :nuevo WHERE `personalizadas` = 0";
        $asiignadas = $this->PDO->prepare($query);
        $asiignadas ->bindParam(':nuevo',$nuevo,PDO::PARAM_INT);
        $asiignadas->execute();
       
        if ($nuevovalor->rowCount()>0 && $asiignadas->rowCount()>0) {
          return true;
        }else {
            return false;
        }
    }

     // Función para limpiar un dato individual
  public function limpiarDato($dato)
  {
    $dato = strip_tags($dato);
    $dato = htmlspecialchars($dato, ENT_QUOTES, 'UTF-8');
    $dato = addslashes($dato);
    return $dato;
  }
}
