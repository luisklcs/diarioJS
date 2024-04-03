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
?>