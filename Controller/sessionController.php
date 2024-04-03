<?php

class sessionController
{
    static function IniciarSession($mail, $pass)
    {
        require_once('Model/sessionModel.php');
        require_once('Controller/limpiar.php');
        require_once(dirname(__DIR__) . '/assets/alerts.php');

        $usr = new loginModel();
        $alertas = new Alertas();

        $mail = limpiarDato($mail);
        $user = $usr->autenticacion($mail, $pass);

        if ($user == false) {
            $a = $alertas->mostrarAlerta('warning', 'Error!', 'Usuario o contraseña incorrectos!');
            echo $a;
        } else {

            $random_bytes = random_bytes(32);
            $session_id = bin2hex($random_bytes);
            session_id($session_id);
            session_start();

            $_SESSION['user'] = $user;

            if ($user['estadoCuenta'] == 1) {

                if ($user['rol'] == 1) {
                    return  header("location:../Views/admin/");
                }

                if ($user['rol'] == 2) {
                    print_r($_SESSION['user']);
                    return header("location:../Views/documentos.php");
                }
            } else {

             $alertas->mostrarAlerta('warning', 'Cuenta desactivada!', 'Su cuenta se encuentra desactivada, por favor contacte al proveedor del servicio!');
            }
        }
    }
    public function actualizarPass($actual, $nueva, $id) {
        require_once(dirname(__DIR__).'/Model/sessionModel.php');
         require_once(dirname(__DIR__) . '/assets/alerts.php');
        $usr = new loginModel();
        $alertas = new Alertas();
     
     
        if ( $usr->actualizarPass($actual, $nueva, $id) == true) {
            $alertas->mostrarAlerta('success', 'Contraseña actualizada!', 'Su contraseña se ha cambiado corretamente');
        }else{
            $alertas->mostrarAlerta('warning', 'Error!', 'No se pudo cambiar su contraseña');
        } 

    }
    public function actualizarPassCliente( $nueva, $id) {
        require_once(dirname(__DIR__).'/Model/sessionModel.php');
         require_once(dirname(__DIR__) . '/assets/alerts.php');
        $usr = new loginModel();
        $alertas = new Alertas();
     
     
        if ( $usr->actualizarPassCliente($nueva, $id) == true) {
            $alertas->mostrarAlerta('success', 'Contraseña actualizada!', 'Su contraseña se ha cambiado corretamente');
        }else{
            $alertas->mostrarAlerta('warning', 'Error!', 'No se pudo cambiar su contraseña');
        } 

    }
}
