<?php
session_start();

if ($_SESSION['user']['rol'] == 2) {
    ajustarVistas();
    BorrarFolder();
    exit();
}


if ($_SESSION['user']['rol'] == 1) {
   # echo "admin";
    sleep(5);

    if (isset($_SESSION['documento'])) { # SI HAY UNA SESIÓN DE DOCUMENTO


      
        $base = dirname(__DIR__).'/visualizer/web/filesAdmin/';
        $dir = $base . $_SESSION['documento']['folder'];
       # echo $dir;
      
        #  print_r($_SESSION['documento']);

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

       /*  unset($_SESSION['documento']);
        exit(); */
    }
}

 function ajustarVistas()
{
    date_default_timezone_set('America/Bogota');
    require_once(dirname(__DIR__).'/Config/conexion.php');
    require_once(dirname(__DIR__).'/Controller/limpiar.php');

    #INSTANCIA DE LA CONEXION
    $con = new db();
    $c = $con->conexion();

    #OBTENER ID DE DOCUMENTO Y DE USUARIO
    $idCliente = $_SESSION['user']['id_usuario'];
    $idDoc =  $_SESSION['documento']['id'];

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

        $hoy = $datos['vistas_usadas_hoy'];

        $usadas = $datos['total_vistas_usadas'];

        $fechaUltimaVista = $datos['fecha_ultima_vista'];

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

        $query = "UPDATE `vistas` SET `vistas_usadas_hoy` = :hoy, `total_vistas_usadas` = :usadas, 
        `fecha_ultima_vista` = :fecha 
        WHERE `vistas`.`id_vistas` = :idVista";
        $con = $c->prepare($query);
        $con->bindParam(':hoy', $hoy, PDO::PARAM_INT);
        $con->bindParam(':usadas', $usadas, PDO::PARAM_INT);
        $con->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $con->bindParam(':idVista', $idvistas, PDO::PARAM_INT);
        $con->execute();
    } else {
        # SI NO SE OBTIENEN RESULTADOS ES POR QUE NO SE HA VISUALIZADO EL DOCUMENTO Y SE PROCEDE A REALIZAR LA PRIMERA INSERSION EN BD  



        $stmt2 = $c->query('SELECT `vistas_asignadas` FROM `config_vistas_usuario` WHERE `id_usuario` = ' . $idCliente . '');
        $stmt2->execute();

        $asignadas =  $stmt2->fetchColumn();



        $fechaActual = date("Y-m-d");
        $nVistas = 1;


        # echo "<script>alert('No hay vistas')</script>";
        $query = "INSERT INTO `vistas` (`id_vistas`, `id_usuario`, `id_documento`, `vistas_usadas_hoy`,
         `total_vistas_usadas`, `fecha_primera_vista`, `fecha_ultima_vista`)
          VALUES (NULL, :id_usuario, :id_documento,  :vistasHoy, :vistasUsadas, :fechaPrimerVista, :fechaUltimaVista)";

        $vst = $c->prepare($query);

        $vst->bindParam(':id_usuario', $idCliente, PDO::PARAM_INT);
        $vst->bindParam(':id_documento', $idDoc, PDO::PARAM_INT);
        $vst->bindParam(':vistasHoy', $nVistas, PDO::PARAM_INT);
        $vst->bindParam(':vistasUsadas', $nVistas, PDO::PARAM_INT);
        $vst->bindParam(':fechaPrimerVista', $fechaActual, PDO::PARAM_STR);
        $vst->bindParam(':fechaUltimaVista', $fechaActual, PDO::PARAM_STR);
        $vst->execute();

     
        
    }
} 

function BorrarFolder()
    {
    sleep(5);
    if (isset($_SESSION['documento'])) { # SI HAY UNA SESIÓN DE DOCUMENTO

        # echo "<script>alert('Borrar carpeta')</script>";
        $base = dirname(__DIR__).'/visualizer/web/63db304ba6ec9/';
        $dir = $base . $_SESSION['documento']['folder'];
     #  echo $dir;

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
    }
}
    #  unset($_SESSION['documento']);
