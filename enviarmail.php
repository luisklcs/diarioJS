

<?php

include_once(dirname(__DIR__) . '/NotificacionesJudicialesSincelejo/mail/enviar.php');

if (isset($_POST['notificar'])) {
print_r($_POST);
$correos = [
/* [
    'correo' => 'luis.correaserpa@gmail.com',
    'nombre' => 'luis'
],
[
    'correo' => 'luiskcorrea@gmail.com',
    'nombre' => 'luis'
], */
[
    'correo' => 'luiskcorrea16@gmail.com',
    'nombre' => 'luis'
],
[
    'correo' => 'correaluisk93@gmail.com',
    'nombre' => 'luis'
],

];

$mail = new enviarMail();

foreach ($correos as $key => $correo) {
if ($mail->enviar($correo['correo'], $correo['nombre'])) {
    echo $key+1;
   # echo "<script>document.getElementById('contador').innerText = $key + 1;</script>";
    flush(); // Vacía el búfer de salida
    ob_flush(); // Envia el búfer de salida
    #  sleep(1); // Opcional: pausa de 1 segundo entre envíos de correo
}
}

}
?>