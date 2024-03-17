<?php

class ModelDocumentos
{

  private $PDO;

  public function __construct()
  {
    require_once(dirname(__DIR__).'/Config/conexion.php');
    require_once(dirname(__DIR__) . '/Controller/limpiar.php');
    $con = new db();
    $this->PDO = $con->conexion();
  }

  public function contarDocumentos($fechaRegistro)
  {
    $query = "SELECT COUNT(*) FROM `documentos` WHERE `fecha` >= '".$fechaRegistro."'";
    $stmt = $this->PDO->prepare($query);
    $stmt->execute();
    $numeroDocumentos = $stmt->fetchColumn();
    return $numeroDocumentos;
  }

  public function listarDocumentos($i, $l , $fecha)
  {

    $inicio = limpiarDato($i);
    $limite = limpiarDato($l);

    $query = 'SELECT * FROM `documentos` WHERE `fecha` >= '.$fecha.' ORDER BY `fecha` DESC  LIMIT ' . $inicio . ',' . $limite . '';
    $listar = $this->PDO->prepare($query);
    $listar->execute();
    $documentos['docs'] = $listar;
    return $documentos;
  }

  public function cargarDocumento($n, $f, $u)
  {
    $nombre = limpiarDato($n) . 'pdf';
    $fecha = limpiarDato($f);
    $url = limpiarDato($u);
    $query = "INSERT INTO `documentos` (`id_documento`, `nombre`, `fecha`, `url`) VALUES (NULL, :nombre , :fecha, :url)";
    $doc = $this->PDO->prepare($query);
    $doc->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $doc->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    $doc->bindParam(':url', $url, PDO::PARAM_STR);
    $doc->execute();
    if ($doc->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
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

      /*  $d ='../../visualizer/web/filesAdmin/'; */
      $d = dirname(__DIR__) . '/visualizer/web/filesAdmin/';

      $uniqueFolderName = uniqid();
      #$base = "../Views/web/63db304ba6ec9/";

      // Suponiendo que $d ya contiene una ruta válida y termina con una barra diagonal
      $dir = $d . $uniqueFolderName;
      print_r($dir);

      // Verificar si el directorio padre existe antes de intentar crear $dir
      if (!is_dir($d)) {
        throw new Exception("El directorio padre no existe.");
      }

      // Verificar si el directorio $dir no existe
      if (!is_dir($dir)) {
        mkdir($dir);

        // Asignar valores a las claves 'folder' y 'pdf' del arreglo $doc
        $doc['folder'] = $uniqueFolderName;
        $doc['pdf'] = "filesAdmin/" . $uniqueFolderName . "/" . $data['nombre'];

        // Construir la ruta completa del archivo destino
        $file = $dir . "/" . $data['nombre'];

        // Copiar el archivo desde $pdf a $file
        if (!copy($pdf, $file)) {
          throw new Exception("Error al copiar el archivo.");
        }
      } else {
        throw new Exception("El directorio ya existe.");
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
      $base = dirname(__DIR__) . '/visualizer/web/63db304ba6ec9/';
      #   $base = "../visualizer/web/63db304ba6ec9/";
      $dir = $base . $uniqueFolderName;

      #  print_r($dir);

      if (!is_dir($dir)) {
        mkdir($dir,);


        $doc['folder'] = $uniqueFolderName;
        $doc['pdf'] = "63db304ba6ec9/" . $uniqueFolderName . "/" . $data['nombre'];
      }

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

  public function vistasDocumento($i)
  {
    $idCliente = $_SESSION['user']['id_usuario'];
    $idDoc = limpiarDato($i);

    $this->PDO->beginTransaction();

    $asignadas = $this->PDO->query('SELECT `vistas_asignadas` FROM `config_vistas_usuario` WHERE `id_usuario` = ' . $idCliente . '');
    $vistasUsadas = $this->PDO->query('SELECT `total_vistas_usadas` FROM `vistas` WHERE vistas.id_documento = ' . $idDoc . ' AND vistas.id_usuario = ' . $idCliente . '');


    $this->PDO->commit();
    $asignadas = $asignadas->fetchColumn();
    $vistasUsadas = $vistasUsadas->fetchColumn();
    $data['asignadas'] = $asignadas;
    $data['TotalUsadas'] = $vistasUsadas;
    return $data;

  }
}
