<?php

require_once(dirname(__DIR__).'/Model/clientesModel.php');
require_once(dirname(__DIR__) . '/assets/alerts.php');

class clientesController
{
  public $tituloPagina;
  public $vista;
  public $cantidad;
  public $objCliente;
  public $alerta;
  public function __construct()
  {
    $this->vista = "listar";
    $this->tituloPagina = "";
    $this->objCliente = new Clientes();
    $this->alerta = new Alertas();
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
    if ($this->objCliente->eliminarCliente($idCliente) == true) {
      return $this->alerta->mostrarAlerta('success', 'Genial!😍', 'Cliente eliminado exitosamente!');
       } else{
        return $this->alerta->mostrarAlerta('error', 'Algo anda mal😢', 'No se pudo eliminara el cliente, por favor intentalo nuevamente!');  }
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
