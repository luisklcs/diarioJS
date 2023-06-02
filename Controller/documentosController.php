<?php
require_once(dirname(__DIR__) . '../Model/documentosModel.php');
require_once(dirname(__DIR__) . '/Controller/alertas.php');

class DocumentosController
{
  public $tituloPagina;
  public $vista;
  public $cantidad;
  public $objDocumento;

  public function __construct()
  {
    $this->objDocumento = new ModelDocumentos();
    $this->vista = "listar";
    $this->tituloPagina = "";
   
  }
  public function contar()
  {
    return $cantidadDocumentos = $this->objDocumento->contarDocumentos();
  }
  public function listar($inicio,$limite)
  {
    $this->vista = "documentos";
    $this->tituloPagina = "Lista de documentos";
    return  $this->objDocumento->listarDocumentos($inicio,$limite);
    
  }

  public function verDocAdmin($id)
  {
    $data = $this->objDocumento->visualizarDocumentoAdmin($id);
    $_SESSION['documento']=$data;
    $_SESSION['visitado']=true;
    echo "<script> location.href = '/Views/web/viewerPdf.php?file=". $data['pdf']. "'; </script> ";
  }

  public function verDocCliente($id)
  {
  
    $data = $this->objDocumento->visualizarDocumentoCliente($id);
    $_SESSION['documento']=$data;
    $_SESSION['visitado']=true;
    echo "<script> location.href = '../views/web/viewer.php?file=". $data['pdf']. "'; </script> ";    
  }


  public function borrarDocumento($id)
  {
    $a = new Alertas;  
   return   ($this->objDocumento->borrarDocumento($id) == true) ? $a->borrado() : $a->Noborrado() ;
  }


}
