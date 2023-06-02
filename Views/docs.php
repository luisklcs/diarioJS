<?php
include_once 'global/header.php';
require_once(dirname(__DIR__) . '\Controller\documentosController.php');
$dir = dirname(__DIR__) . '\Controller\documentosController.php';
require_once dirname(__DIR__) . '\Views\global\scripts.php';
$obj = new DocumentosController();
$lista = $obj->listar();
if ($_POST) {
    $id = $_POST['id'];
    $accion = $_POST['accion'];

    switch ($accion) {

        case 'ver':
            $obj->verDoc($id);
            #echo "<script> alert('veeeer...')</script>";
            break;

        case 'borrar':
           $obj->borrarDocumento($id);
            break;

        case 'vistasdocumento':
           $obj->vistasDocumento($id);
            break;
        
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Sistema Web</title>
    <link rel="stylesheet" href="../1mvcc/assets/vendor/remixicon/remixicon.css">
    <link rel="stylesheet" href="../1mvcc/assets/css/style.css">
</head>
<div class="container">
    <br>
    <div class="row justify-content-center">
        <div class="col-8 justify-content-center">
            <div class="alert alert-primary" role="alert">
                <strong>
                    <h3 style="text-align: center;">Lista de documentos</h3>
                </strong>
            </div>
        </div>
    </div>
    
    </div>
    <div class="bg-image h-100" style="background-color: #f5f7fa;">
        <table class="table table-striped mb-0" id="dataTable" cellspacing="0">
            <thead style="background-color: #96e985;">
                <tr>
                    <th scope="col">N°</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">fecha</th>
                    <th scope="col-sm">Opciones</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th scope="col" class="name">N°</th>
                    <th scope="col" class="name">Nombre</th>
                    <th scope="col" class="name">Fecha</th>
                    <th scope="col" class="name">Opciones</th>
                </tr>
            </tfoot>
            <tbody>
                <?php
                $n = 1;
                foreach ($lista as $dato => $value) {

                    for ($i = 0; $i < count($value); $i++) {

                        echo "<tr>";
                        echo "<td>" .  $n . "</td>";
                        echo "<td>" . $value[$i]['nombre'] . "</td>";
                        echo "<td>" . $value[$i]['fecha'] . "</td>";
                        echo '<td>
                                            <form action="" method="post">
                                            <input type="hidden" name="id" value="' . $value[$i]['id_documento'] . '">
                                            <button name="accion" value="ver" type="submit" class="btn btn-primary"><i class="ri-eye-fill"></i></button>
                                            <button name="accion" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop' . $value[$i]['id_documento'] . '"><i class="ri-delete-bin-fill"></i></button>
                                            <button name="accion" value="vistasdocumento" type="submit" class="btn btn-success"><i class="ri-list-check"></i></button>

                                            <div class="modal fade" id="staticBackdrop' . $value[$i]['id_documento'] . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">ADVERTENCIA!</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-warning" role="alert">

                                                                <p class="mb-0">Esta operación no se puede deshacer, para eliminar el documento presione aceptar</p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <form action="" method="post">
                                                                <input type="hidden" name="id" id="idDoc" value="' . $value[$i]['id_documento'] . '">
                                                                <button name="accion" value="borrar" type="submit" class="btn btn-danger">Aceptar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                            </td>';
                        echo "</tr>";
                        $n++;
                    }
                }

                ?>
            </tbody>
        </table>
    </div>
</div>



<script src="panel/js/scripts.js"></script>
<script src="no/panel/js/scripts.js"></script>
<script src="no/panel/assets/demo/datatables-demo.js"></script>

</body>
<br><br><br><br><br>
<?php
include_once 'global/footer.php';
?>

</html>