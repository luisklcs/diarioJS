
<?php

define("SERVIDOR", "localhost");
define("USUARIO", "root");
define("PASSWORD", "");
define("BD", "u904935864_ddjus1nc13j0");

$servidor = "mysql:host=" . SERVIDOR . ";dbname=" . BD;
try {
    $conexion = new PDO(
        $servidor,
        USUARIO,
        PASSWORD,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
    #echo "<script>alert('Conectado...')</script>" ;

} catch (PDOException $e) {
    // echo "<script>alert('Error...')</script>" ;
}








# >--------- MIGRAR USUARIOS A LA NUEBA BD ----------------->

$query = "SELECT * FROM `usuarios`";
$docs = $conexion->prepare($query);
$docs->execute();

$data = $docs->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";

foreach ($data as $key => $Usuario) {
    #  print_r($Usuario);

    $fecha_registro = $Usuario['fecha_registro'];
   
    // Obtener el año actual
    $anio_actual = date('Y');

    // Obtener el mes actual
    $mes_actual = date('m');
    $mes_siguiente = date('m', strtotime('+1 month', mktime(0, 0, 0, $mes_actual, 1)));

    $dia_actual = date('d');
 

    $mes_registro = date('m', strtotime($fecha_registro));
    $dia_registro = date('d', strtotime($fecha_registro));

    if ($mes_registro > $mes_actual) {

        if ($dia_actual > $dia_registro) {
            $fecha_cobro = $anio_actual . '-' . $mes_siguiente . '-' . $dia_registro;
        } else {
            $fecha_cobro = $anio_actual . '-' . $mes_actual . '-' . $dia_registro;
        }
       

    } elseif ($mes_registro < $mes_actual) {

        echo "<pre>";
        if ($dia_actual > $dia_registro) {
            $fecha_cobro = $anio_actual . '-' . $mes_siguiente . '-' . $dia_registro;
        } else {
            $fecha_cobro = $anio_actual . '-' . $mes_actual . '-' . $dia_registro;
        }
       
    } elseif ($mes_registro = $mes_actual) {
        if ($dia_actual > $dia_registro) {
            $fecha_cobro = $anio_actual . '-' . $mes_siguiente . '-' . $dia_registro;
        } else {
            $fecha_cobro = $anio_actual . '-' . $mes_actual . '-' . $dia_registro;
        }
      
    }
    /*  print_r("fecha de cobro: " . $fecha_cobro);
    print_r("mes de registro: " . $mes);
    print_r("dia de registro: " . $dia); */
}

?>