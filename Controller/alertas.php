<?php
class Alertas{


    public function exitoso($tiempo, $ruta)
    {
        ?> <script type="text/javascript">
        setTimeout(function() {
            location.href = "ventas.php";
        }, 1500);
        Swal.fire({
            icon: 'success',
            title: 'Eliminado!',
            text: 'Artículo eliminado correctamente!',
        })
    </script><?php
    }
    public function errorSesion()
    {
        echo "<script>
        Swal.fire({
            icon: 'warning',
            title: 'Error!',
            text: 'Usuario o contraseña incorrectos!',
        })
        </script>";

    }
    public function cuentadesactivada()
    {
        echo "<script>
        Swal.fire({
            icon: 'warning',
            title: 'Cuenta esactivada!',
            text: 'Su cuenta se encuentra desactivada, por favor contacte al proveedor del servicio!',
        })
        </script>";

    }
    public function borrado()
    {
        echo "
        <script>
    setTimeout(function() {
        location.href = 'documentos.php';
    }, 1500);
    Swal.fire({
        icon: 'success',
        title: 'Eliminado!',
        text: 'Artículo eliminado correctamente!', })   
    </script>
        ";
    }
    public function Noborrado()
    {
        echo "
        <script>
    setTimeout(function() {
    }, 1500);
    Swal.fire({
        icon: 'Error',
        title: 'Error al eliminar!',
        text: 'No se pudo eliminar el documento!', })   
    </script>
        ";
    }

}


?>