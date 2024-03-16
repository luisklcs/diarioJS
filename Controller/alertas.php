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
            title: 'Cuenta desactivada!',
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

    public function documentoIncorrecto()
    {
        echo "
        <script>
   
         Swal.fire({
        icon: 'warning',
        title: 'Advertencia!',
        text: 'El tipo de documento que intenta cargar tiene un formato incorrecto, asegúrese que sea de tipo pdf!', })   
         </script>
        ";
    }

    public function documentoCargadoCorrectamente()
    {
        echo "
        <script> Swal.fire({
        icon: 'success',
        title: 'Documento guardado!',
        text: 'El documento se ha cargado correctamente!', })</script>
        ";
    }
    public function documentoNoCargado()
    {
        echo "
        <script> Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: 'Ocurrió un error al cargar el documento, por favor intente nuevamente!', })</script>
        ";
    }
    public function vistasActualizadas()
    {
        echo '<script type="text/javascript">
        setTimeout(function() {
            location.href = "index.php";
        }, 1500);';
        echo "
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Actualizado!',
            text: 'Vistas generales Actualizadas correctamente!',}) </script>
            ";
        }
}


?>