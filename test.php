<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>



    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Notificando usuarios</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="notificar">Notifiacr usuarios</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Button trigger modal -->
    <form action="" method="POST">
        <button type="submit" name="notificar" class="btn btn-primary" id="mostrarModal">
            Mostrar modal
        </button>
    </form>
    <!-- Modal -->
    <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Notificando usuarios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Usuarios notificados: <span id="contador">0</span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        var botonCerrarModal = document.querySelector("#miModal .btn-close");
        botonCerrarModal.addEventListener("click", function() {
            var miModal = new bootstrap.Modal(document.getElementById('miModal'));
            miModal.hide();
        });
    });
</script>


</html>


<?php

require 'vendor/autoload.php';

use WhichBrowser\Parser;





echo "<br>";
echo "SERVER";
echo "<br>";

$data = dispositivo();

echo $data[0];
echo "<br>";
echo "Sistema operativo: " . $data[1];
echo "<br>";
echo "Dirección IP: " . $data[2];
echo "<br>";
echo "Dispositivo: " . $data[3];
echo "<br>";

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
    echo "Navegador: " . $result->browser->name . "\n";
    echo "Versión: " . $result->browser->version->value . "\n";
}




// Recorrer el array $_SERVER utilizando foreach
/* foreach ($_SERVER as $clave => $valor) {
    echo "$clave => $valor <br>";
} */


/* 
include_once(dirname(__DIR__) . '/NotificacionesJudicialesSincelejo/mail/enviar.php');

if (isset($_POST['notificar'])) {
   # print_r($_POST);
    echo "<script> var miModal = new bootstrap.Modal(document.getElementById('miModal'));
    miModal.show(); </script>";
    $correos = [
        [
            'correo' => 'luis.correaserpa@gmail.com',
            'nombre' => 'luis'
        ],
        [
            'correo' => 'luiskcorrea@gmail.com',
            'nombre' => 'luis'
        ],
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
            echo "<script>document.getElementById('contador').innerText = $key + 1;</script>";
            flush(); // Vacía el búfer de salida
            ob_flush(); // Envia el búfer de salida
            sleep(1); // Opcional: pausa de 1 segundo entre envíos de correo
        }
    }
}
?> */


/* 

 <script>
    window.addEventListener('modalcreate', function() {

        setTimeout(() => {
            tinymce.init({
                selector: '#myTextarea',
                width: 1000,
                height: 590,
                plugins: [
                    'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview',
                    'anchor',
                    'pagebreak',
                    'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code',
                    'fullscreen',
                    'insertdatetime',
                    'media', 'table', 'emoticons', 'help'
                ],
                toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
                    'bullist numlist outdent indent   ',
                menu: {
                    favs: {
                        title: 'My Favorites',
                        items: ' searchreplace '
                    }
                },
                menubar: 'favs file edit view insert format tools ',
                content_css: 'css/content.css',
                noneditable_class: 'mceNonEditable',

            });

        });
    }, 1000);
</script>  */