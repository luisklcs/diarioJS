<?php
    session_start();

if ($_SESSION['user']['rol'] = 2) {
   
  #  ajustarVistas();
  #  BorrarFolder();
 # exit();
} 


if ($_SESSION['user']['rol'] = 1) {
   # echo "<script>alert('Borrar carpeta')</script>";
  
 
   sleep(5);

    if (isset( $_SESSION['documento'])) { # SI HAY UNA SESIÓN DE DOCUMENTO

         
        $base = "../Views/web/filesAdmin/";
        $dir = $base . $_SESSION['documento']['folder'];
      #  echo $dir;
      print_r($_SESSION['documento']);

        if (is_dir($dir)) {
        // Abrir el directorio
        $handle = opendir($dir);

        // Recorrer todos los archivos dentro del directorio
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
            // Eliminar cada archivo dentro del directorio
            unlink($dir . '/' . $file);
            }
        }

        // Cerrar el directorio
        closedir($handle);

        // Eliminar el directorio vacío
        rmdir($dir);
        }
   #  unset($_SESSION['documento']);
  # exit();
    }


  } 


function ajustarVistas()
{
    date_default_timezone_set('America/Bogota');
    require_once(dirname(__DIR__) . '/Config/conexion.php');
    require_once(dirname(__DIR__) . '/Controller/limpiar.php');

    #INSTANCIA DE LA CONEXION
    $con = new db();
    $c = $con->conexion();

    #OBTENER ID DE DOCUMENTO Y DE USUARIO
    $idCliente = $_SESSION['user']['id_usuario'];
   # $idDoc =  $_SESSION['doc']['id'];

   #print_r($_SESSION['documento']);

    #CONSULTAR LA TABLA DE VISTA CON ID DE USUARIO E ID DE DOCUMENTO
    $query = "SELECT * FROM `vistas` WHERE `id_usuario` = :idCliente AND `id_documento` = :idDoc";
    $con = $c->prepare($query);
    $con->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
    $con->bindParam(':idDoc', $idDoc, PDO::PARAM_INT);
    $con->execute();

    #SI SE OBTIENEN RESULTADOS
    if ($con->rowCount() > 0) {

        $datos = $con->fetch(PDO::FETCH_ASSOC);
      
        $idvistas = $datos['id_vistas'];

        $hoy = $datos['vistasHoy'];

        $usadas = $datos['vistasUsadas'];

        $fechaUltimaVista = $datos['fechaUltimaVista'];

        $fechaActual = date("Y-m-d");

        $fechaDeBD = strtotime($fechaUltimaVista); //fecha Ultima vista BD
        $fechaActualInternet = strtotime($fechaActual); //fecha actual     

        print_r($datos);

        if ($fechaActualInternet > $fechaDeBD) {
            $fecha = $fechaActual;
            $hoy = 1;
            $usadas++;
        } else {
            $fecha = $fechaUltimaVista;
            $hoy++;
            $usadas++;
        }

        $query ="UPDATE `vistas` SET `vistasHoy` = :hoy, `vistasUsadas` = :usadas, `fechaUltimaVista` = :fecha 
        WHERE `vistas`.`id_vistas` = :idVista";
        $con = $c->prepare($query);
        $con->bindParam(':hoy',$hoy, PDO::PARAM_INT);
        $con->bindParam(':usadas',$usadas, PDO::PARAM_INT);
        $con->bindParam(':fecha',$fecha, PDO::PARAM_STR);
        $con->bindParam(':idVista',$idvistas, PDO::PARAM_INT);
        $con->execute();


    }

}
    
function BorrarFolder()
    {
        sleep(5);
        if (isset( $_SESSION['documento'])) { # SI HAY UNA SESIÓN DE DOCUMENTO

              # echo "<script>alert('Borrar carpeta')</script>";
            $base = "../Views/web/63db304ba6ec9/";
            $dir = $base . $_SESSION['documento']['folder'];
            echo $dir;

            if (is_dir($dir)) {
            // Abrir el directorio
            $handle = opendir($dir);

            // Recorrer todos los archivos dentro del directorio
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                // Eliminar cada archivo dentro del directorio
                unlink($dir . '/' . $file);
                }
            }

            // Cerrar el directorio
            closedir($handle);

            // Eliminar el directorio vacío
            rmdir($dir);
            }
         unset($_SESSION['documento']);
        }
     } 
    #    unset($_SESSION['documento']);

