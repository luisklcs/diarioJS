<?php

require_once(dirname(dirname(__DIR__)) . '/Config/conexion.php');
$con = new db();
$PDO = $con->conexion();

if ($_POST) {
    $data = limpiarDato($_POST['cliente']);
    /*  echo $data; */

    $infoCliente = "";
    $query = "SELECT us.id_usuario, us.nombreUsuario, us.apellidos, 
    us.correo, us.identificacion, fc.f_registro, fc.f_suspencion, 
    fc.f_reactivacion FROM usuarios us INNER JOIN fechas fc
    ON fc.id_usuario = us.id_usuario WHERE `rol` = 2 AND `nombreUsuario` LIKE '%" . $data . "%' OR `apellidos` LIKE  '%" . $data . "%'  OR `correo` LIKE  '%" . $data . "%'  ";

    $clientes = $PDO->prepare($query);
    $clientes->execute();

    if ($clientes->rowCount() > 0) {
        /*   $cliente = $cliente->fetchAll(PDO::FETCH_ASSOC); */
        $id = "";
        $infoCliente .= '<div class="table-responsive">
        <table class="table align-items-center mb-0" id="tablaResultado">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">n°</th>
                    <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">nombre</th>
                    <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">apellidos</th>
                    <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">correo</th>
                    <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">opciones</th>
                </tr>
            </thead>
            <tbody>';

        $n = 1;

        while ($cliente = $clientes->fetch(PDO::FETCH_ASSOC)) {

            if ($cliente['f_suspencion'] == null) {
                $fecha_suspension = "-------";
            } else {
                $fecha_suspension = $cliente['f_suspencion'];
            }

            if ($cliente['f_reactivacion'] == null) {
                $fecha_reactivacion = "-------";
            } else {
                $fecha_reactivacion = $cliente['f_reactivacion'];
            }
            $id = $cliente['id_usuario'];
            $infoCliente .= '
                <tr>
                    <td>
                        <div class="d-flex  py-1">
                            <span class="text-uppercase text-xs font-weight-bold">' . $n . '</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex  py-1">
                            <span class="text-uppercase text-xs font-weight-bold">' . $cliente['nombreUsuario'] . '</span>
                        </div>
                    </td>
    
                    <td>
                        <div class="d-flex  py-1">
                            <span class="text-uppercase text-xs font-weight-bold">' . $cliente['apellidos'] . '</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex  py-1">
                            <span class=" text-xs font-weight-bold">' . $cliente['correo'] . '</span>
                        </div>
                    </td>
                  
    
                    <td>
                        <div class="d-flex py-1">
                            <form action="" method="POST">
                                <input type="hidden" name="idCliente" value="' . $cliente['id_usuario'] . '">
                                <div class="ms-auto text-end">
                                   <button style="border:none" class="badge badge-sm bg-gradient-success" type="submit" name="accion" value="buscarclientepassw"><i class="fa-solid fa-pen-to-square"></i> </button>
                               
                                  </div>
                                </form>
                        </div>
                    </td>
    
                       
                </tr>';

            $n++;
        }
    }
    $infoCliente .= '</tbody>
   </table>
   </div>
   <script>
$(document).ready(function() {
    // Asigna un evento de clic al botón para buscar cliente
    $("#btnBuscarCliente").click(function() {
        var valorBusqueda = $("#busquedaCliente").val(); // Obtén el valor de búsqueda desde el campo de entrada
        buscarIdCliente(valorBusqueda); // Llama a la función para buscar el ID del cliente
    });
});

</script>
   ';
    echo $infoCliente;

}

function limpiarDato($dato)
{
    return htmlspecialchars($dato, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}
