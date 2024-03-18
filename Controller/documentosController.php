<?php

require_once(dirname(__DIR__) . '/Model/documentosModel.php');
require_once(dirname(__DIR__) . '/assets/alerts.php');


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
  public function contar($fechaRegistro)
  {
    return $cantidadDocumentos = $this->objDocumento->contarDocumentos($fechaRegistro);
  }
  public function listar($inicio, $limite, $fechaRegistro)
  {
    $this->vista = "documentos";
    $this->tituloPagina = "Lista de documentos";
    return  $this->objDocumento->listarDocumentos($inicio, $limite, $fechaRegistro);
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
    echo "<script> location.href = '../visualizer/web/viewer.php?file=" . $data['pdf'] . "'; </script> ";
  }

  public function verDocImpresion($id)
  {
    $data = $this->objDocumento->visualizarDocumentoCliente($id);

    $_SESSION['documento'] = $data;
    $_SESSION['visitado'] = true;
    echo "<script> location.href = '../visualizer/web/viewerPdf.php?file=" . $data['pdf'] . "'; </script> ";
  }

  public function borrarDocumento($id)
  {
    return ($this->objDocumento->borrarDocumento($id) == true) ? 1 : 0;
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
        return $this->alerta->mostrarAlerta('warning', 'Advertencia!', 'El tipo de documento que intenta cargar tiene un formato incorrecto, asegúrese que sea de tipo pdf!');
      } else {
        $src = $dir . $nombre;
        if (move_uploaded_file($ruta, $src)) {
          $src = "../63db127930f4a/" . $uniqueFolderName . "/" . $nombre;
          $d = $this->objDocumento->cargarDocumento($nombreDoc, $fecha, $src);
          if ($d == true) {
            return $this->alerta->mostrarAlerta('success', 'Documento guardado!', 'El documento se ha cargado correctamente!');
          } else {
            return $this->alerta->mostrarAlerta('error', 'Error!', 'EOcurrió un error al cargar el documento, por favor intente nuevamente!');
          }
        }
      }
    }
  }

  public function vistasDocumento($idDoc)
  {
    return $this->objDocumento->vistasDocumento($idDoc);
  }

  public function enviarmail()
  {

    require_once(dirname(__DIR__) . '/mail/enviar.php');
    require_once(dirname(__DIR__) . '/Model/clientesModel.php');
    $clientes = new Clientes();
    $listaEmails = $clientes->listaEmails();
    $mail = new enviarMail();
    $enviados = 0;

    foreach ($listaEmails as $key => $email) {
      if ($mail->enviar($email['correo'], $email['nombreUsuario']) == true) {
        $enviados++;
      }
    }
    return $this->alerta->mostrarAlerta('success', 'Usuarios notificados', 'Se notificaron ' . $enviados . ' clientes!');
  }
}
