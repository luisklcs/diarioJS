<?php

class sessionController
{
    static function IniciarSession($mail, $pass)
    {
        require_once('Model/sessionModel.php');
        require_once('Controller/limpiar.php');
        require_once('Controller/alertas.php');
        $usr = new loginModel();
        $alertas = new Alertas();

        $mail = limpiarDato($mail);
        $user = $usr->autenticacion($mail, $pass);




        if ($user == false) {
            $a = $alertas->errorSesion();
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
                     print_r($_SESSION['user']);  return header("location:../Views/documentos.php");
                }
            } else {
                $a = $alertas->cuentadesactivada();
                echo $a;
            }
        }
    }
}
