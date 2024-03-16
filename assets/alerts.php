<?php
class Alertas {
    public function mostrarAlerta($icono, $titulo, $mensaje) {
        echo "<script>
            Swal.fire({
                icon: '$icono',
                title: '$titulo',
                text: '$mensaje'
            });
        </script>";
    }
}
?>