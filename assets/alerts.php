<?php
class Alertas {
    public function mostrarAlerta($icono, $titulo, $mensaje) {
        echo "
        <script type='text/javascript'>
        setTimeout(function() {       
            }, 3000);
             Swal.fire({
                icon: '$icono',
                title: '$titulo',
                text: '$mensaje'
            });
            </script>";
    }
}
?>