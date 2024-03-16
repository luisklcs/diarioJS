<?php

require_once('../../Model/clientesModel.php');

class clientesController
{
  public $tituloPagina;
  public $vista;
  public $cantidad;
  public $objCliente;

  public function __construct()
  {
    $this->vista = "listar";
    $this->tituloPagina = "";
    $this->objCliente = new Clientes();
  }

  public function contar()
  {
    return $this->objCliente->cantidad();
  }

  public function listar($inicio, $limite)
  {
    $this->vista = "clientes";
    $this->tituloPagina = "Lista de clientes";
    return $this->objCliente->listar($inicio, $limite);
  }

  public function registrar($data)
  {
    $this->vista = "clientes";
    $this->tituloPagina = "Lista de clientes";
    return $this->objCliente->registrar($data);
  }

  public function editar($idCliente)
  {
    $_SESSION['cliente'] = $this->objCliente->datosCliente($idCliente);
    echo '<script type="text/javascript"> location.href = "editar.php";  </script> ';
  }

  public function infoCuentaCliente($id)
  {
    return $this->objCliente->infoCuentaCliente($id);
  }
  public function actualizar($data)
  {
    return $this->objCliente->actualizar($data);
  }
  public function eliminarCliente($idCliente)
  {
    return $this->objCliente->eliminarCliente($idCliente);
  }

  public function cargarVistas()
  {
      $id =  $_SESSION['id'];
      return $this->objCliente->vistasgenerales($id);   
   
  }

  public function buscarVistasGenerages()
  {
   return $this->objCliente->buscarVistasGenerages();
  }

}
