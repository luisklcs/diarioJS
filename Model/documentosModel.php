<?php

class ModelDocumentos
{

  private $PDO;

  public function __construct()
  {
    require_once(dirname(__DIR__) . '/Config/conexion.php');
    require_once(dirname(__DIR__) . '/Controller/limpiar.php');
    $con = new db();
    $this->PDO = $con->conexion();
  }

  public function contarDocumentos()
  {
    $query = "SELECT COUNT(*) FROM documentos";
    $stmt = $this->PDO->prepare($query);
    $stmt->execute();
    $numeroDocumentos = $stmt->fetchColumn();
    return $numeroDocumentos;
  }

  public function listarDocumentos($i, $l)
  {

    $inicio = limpiarDato($i);
    $limite = limpiarDato($l);

    $query = 'SELECT  * FROM `documentos` ORDER BY `fecha` DESC  LIMIT ' . $inicio . ',' . $limite . '';
    $listar = $this->PDO->prepare($query);
    $listar->execute();
    $documentos['docs'] = $listar;
    return $documentos;
  }



  public function visualizarDocumentoAdmin($i)
  {
    try {
      $id = limpiarDato($i);
      $doc['id'] = $id;
      $query = "SELECT `nombre`, `url` FROM `documentos` WHERE `id_documento` = :iDoc";
      $stmt = $this->PDO->prepare($query);
      $stmt->bindParam(':iDoc', $id, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      $pdf = '../' . $data['url'];
      $d = dirname(__DIR__) . '\Views\web\filesAdmin/';

      $uniqueFolderName = uniqid();
      $base = "../Views/web/63db304ba6ec9/";
      $dir = $d . $uniqueFolderName;

      if (!is_dir($dir)) {
        mkdir($dir, 0777, true);



        $doc['folder'] = $uniqueFolderName;
        $doc['pdf'] = "filesAdmin/" . $uniqueFolderName . "/" . $data['nombre'];

        $file = $dir . "/" . $data['nombre'];
        if (!copy($pdf, $file)) {
          throw new Exception("Error copying file.");
        }
      }
      return $doc;
    } catch (Exception $e) {
      // Handle the exception here
      error_log($e->getMessage());
      return false;
    }
  }
  public function visualizarDocumentoCliente($i)
  {
    try {

      $id = limpiarDato($i);

      $doc['id'] = $id;

      $query = "SELECT `nombre`, `url` FROM `documentos` WHERE `id_documento` = :iDoc";
      $stmt = $this->PDO->prepare($query);
      $stmt->bindParam(':iDoc', $id, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
      $stmt->execute();
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      $pdf = $data['url'];

      $uniqueFolderName = uniqid();
      $base = "../Views/web/63db304ba6ec9/";
      $dir = $base . $uniqueFolderName;

      if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
      }


      $doc['folder'] = $uniqueFolderName;
      $doc['pdf'] = "63db304ba6ec9/" . $uniqueFolderName . "/" . $data['nombre'];

      $file = $dir . "/" . $data['nombre'];
      if (!copy($pdf, $file)) {
        throw new Exception("Error copying file.");
      }

      return $doc;
    } catch (Exception $e) {
      // Handle the exception here
      error_log($e->getMessage());
      return false;
    }
  }

  public function borrarDocumento($i)
  {
    $id = limpiarDato($i);
    $query = "DELETE FROM documentos WHERE `documentos`.`id_documento` = :id";
    $del = $this->PDO->prepare($query);
    $del->bindParam(':id', $id, PDO::PARAM_INT);
    $del->execute();

    if ($del->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }
}
