<?php
session_start();

require '../vendor/autoload.php';

use WhichBrowser\Parser;

if ($_SESSION['user']['rol'] == 2) {

    ajustarVistas();
    BorrarFolder();
    exit();
}


if ($_SESSION['user']['rol'] == 1) {
    # echo "admin";
    sleep(5);

    if (isset($_SESSION['documento'])) { # SI HAY UNA SESIÓN DE DOCUMENTO



        $base = dirname(__DIR__) . '/visualizer/web/filesAdmin/';
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

    $dispositivo = dispositivo();

    date_default_timezone_set('America/Bogota');
    require_once(dirname(__DIR__) . '/Config/conexion.php');
    require_once(dirname(__DIR__) . '/Controller/limpiar.php');

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

        $fechaActual = date("Y-m-d H:i:s");

        $fechaDeBD = strtotime($fechaUltimaVista); //fecha Ultima vista BD
        $fechaActualInternet = strtotime($fechaActual); //fecha actual     

        #  print_r($datos);

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
        `fecha_ultima_vista` = :fecha, `dispositivo` = :dispositivo, `ip` = :ip, `navegador` = :navegador, `os` = :os
        WHERE `vistas`.`id_vistas` = :idVista";

        $con = $c->prepare($query);
        $con->bindParam(':hoy', $hoy, PDO::PARAM_INT);
        $con->bindParam(':usadas', $usadas, PDO::PARAM_INT);
        $con->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $con->bindParam(':idVista', $idvistas, PDO::PARAM_INT);
        $con->bindParam(':dispositivo', $dispositivo[3], PDO::PARAM_STR);
        $con->bindParam(':ip', $dispositivo[2], PDO::PARAM_STR);
        $con->bindParam(':navegador', $dispositivo[0], PDO::PARAM_STR);
        $con->bindParam(':os', $dispositivo[1], PDO::PARAM_STR);
        $con->execute();

    } else {
        # SI NO SE OBTIENEN RESULTADOS ES POR QUE NO SE HA VISUALIZADO EL DOCUMENTO Y SE PROCEDE A REALIZAR LA PRIMERA INSERSION EN BD  
        $fechaActual = date("Y-m-d H:i:s");
        $nVistas = 1;

      

        # echo "<script>alert('No hay vistas')</script>";
        $query = "INSERT INTO `vistas` (`id_vistas`, `id_usuario`, `id_documento`, `vistas_usadas_hoy`,
         `total_vistas_usadas`, `fecha_primera_vista`, `fecha_ultima_vista`, `dispositivo`, `ip`, `navegador`, `os`)
          VALUES (NULL, :id_usuario, :id_documento,  :vistasHoy, :vistasUsadas, :fechaPrimerVista, :fechaUltimaVista, :dispositivo, :ip, :navegador, :os)";

        $vst = $c->prepare($query);

        $vst->bindParam(':id_usuario', $idCliente, PDO::PARAM_INT);
        $vst->bindParam(':id_documento', $idDoc, PDO::PARAM_INT);
        $vst->bindParam(':vistasHoy', $nVistas, PDO::PARAM_INT);
        $vst->bindParam(':vistasUsadas', $nVistas, PDO::PARAM_INT);
        $vst->bindParam(':fechaPrimerVista', $fechaActual, PDO::PARAM_STR);
        $vst->bindParam(':fechaUltimaVista', $fechaActual, PDO::PARAM_STR);
        $vst->bindParam(':dispositivo', $dispositivo[3], PDO::PARAM_STR);
        $vst->bindParam(':ip', $dispositivo[2], PDO::PARAM_STR);
        $vst->bindParam(':navegador', $dispositivo[0], PDO::PARAM_STR);
        $vst->bindParam(':os', $dispositivo[1], PDO::PARAM_STR);
        $vst->execute();
    }
}

function BorrarFolder()
{
    sleep(5);
    if (isset($_SESSION['documento'])) { # SI HAY UNA SESIÓN DE DOCUMENTO

        # echo "<script>alert('Borrar carpeta')</script>";
        $base = dirname(__DIR__) . '/visualizer/web/63db304ba6ec9/';
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
function dispositivo()
{

    $dispositivo = detectDevice();
    $ip = $_SERVER['REMOTE_ADDR'];
    $navegador = navegador();
    $os = getOSDetails($_SERVER['HTTP_USER_AGENT']);

    return array($navegador, $os, $ip, $dispositivo);
}

function detectDevice()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $devices = array(
        'Celular' => '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',
        'Tablet' => '/(tablet|ipad|playbook)|(android(?!.*mobile))/i',
        'Computador' => '/(windows|macintosh|linux|unix)/i'
    );

    foreach ($devices as $device => $regex) {
        if (preg_match($regex, $userAgent)) {
            return $device;
        }
    }
    return 'Desconocido';
}

function getOSDetails($user_agent)
{
    $os_platform = "Unknown";
    $os_array = array(
        '/windows nt 10/i'      =>  'Windows 10',
        '/windows nt 6.3/i'     =>  'Windows 8.1',
        '/windows nt 6.2/i'     =>  'Windows 8',
        '/windows nt 6.1/i'     =>  'Windows 7',
        '/windows nt 6.0/i'     =>  'Windows Vista',
        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
        '/windows nt 5.1/i'     =>  'Windows XP',
        '/windows xp/i'         =>  'Windows XP',
        '/windows nt 5.0/i'     =>  'Windows 2000',
        '/windows me/i'         =>  'Windows ME',
        '/win98/i'              =>  'Windows 98',
        '/win95/i'              =>  'Windows 95',
        '/win16/i'              =>  'Windows 3.11',
        '/macintosh|mac os x/i' =>  'Mac OS X',
        '/mac_powerpc/i'        =>  'Mac OS 9',
        '/linux/i'              =>  'Linux',
        '/ubuntu/i'             =>  'Ubuntu',
        '/iphone/i'             =>  'iOS',
        '/ipod/i'               =>  'iOS',
        '/ipad/i'               =>  'iOS',
        '/android/i'            =>  'Android',
        '/blackberry/i'         =>  'BlackBerry',
        '/webos/i'              =>  'Mobile'
    );

    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }

    return $os_platform;
}

function navegador()
{
    $headers = getallheaders();
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    // Crear una nueva instancia del parser con el user agent
    $parser = new Parser($headers);

    // Obtener el resultado del análisis
    $result = new Parser($user_agent);
    return $result->browser->name . " " . $result->browser->version->value;
}
    #  unset($_SESSION['documento']);
