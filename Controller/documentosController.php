<?php
require_once(dirname(__DIR__) . '../Model/documentosModel.php');
require_once(dirname(__DIR__) . '/Controller/alertas.php');


class DocumentosController
{
  public $tituloPagina;
  public $vista;
  public $cantidad;
  public $objDocumento;
  public $alerta;

  public function __construct()
  {
    $this->objDocumento = new ModelDocumentos();
    $this->alerta = new Alertas();
    $this->vista = "listar";
    $this->tituloPagina = "";
  }
  public function contar()
  {
    return $cantidadDocumentos = $this->objDocumento->contarDocumentos();
  }
  public function listar($inicio, $limite)
  {
    $this->vista = "documentos";
    $this->tituloPagina = "Lista de documentos";
    return  $this->objDocumento->listarDocumentos($inicio, $limite);
  }

  public function verDocAdmin($id)
  {
    $data = $this->objDocumento->visualizarDocumentoAdmin($id);

    $_SESSION['documento'] = $data;
    $_SESSION['visitado'] = true;
    echo "<script> location.href = '../../visualizer/web/viewerPdf.php?file=" . $data['pdf'] . "'; </script> ";
  }

  public function verDocCliente($id)
  {
    
    $data = $this->objDocumento->visualizarDocumentoCliente($id);
   
   $_SESSION['documento'] = $data;
    $_SESSION['visitado'] = true;
   /*  echo "<script> location.href = '../views/web/viewer.php?file=" . $data['pdf'] . "'; </script> "; */
     echo "<script> location.href = '../visualizer/web/viewer.php?file=" . $data['pdf'] . "'; </script> "; 
   # print_r($data);
  }


  public function borrarDocumento($id)
  {
    $a = new Alertas;
    return ($this->objDocumento->borrarDocumento($id) == true) ? $a->borrado() : $a->Noborrado();
  }
  public function CargarDocumento()
  {

    if (isset($_FILES['documento'])) {

      $uniqueFolderName = uniqid();
      $base = "../../63db127930f4a/";
      mkdir("$base" . $uniqueFolderName);
      $dir = $base . $uniqueFolderName . "/";
     

      $fecha = $_POST['fecha'];
      $nombreDoc = $_POST['nombre'];

      $file = $_FILES['documento'];
      $nombre = $file['name'];
      $tipo  = $file['type'];
      $ruta  = $file["tmp_name"];

      if ($tipo != "application/pdf") {
        return $this->alerta->documentoIncorrecto();
      } else {
        $src = $dir . $nombre;
        if (move_uploaded_file($ruta, $src)) {
          $src = "../63db127930f4a/".$uniqueFolderName."/".$nombre ; 
          $d = $this->objDocumento->cargarDocumento($nombreDoc, $fecha, $src);
          if ($d == true) {
            return $this->alerta->documentoCargadoCorrectamente();
          } else {
            return $this->alerta->documentoNoCargado();
          }
        }
      }
    }
  }

  public function vistasDocumento($idDoc)
  {
   return $this->objDocumento->vistasDocumento($idDoc);
  }
}
