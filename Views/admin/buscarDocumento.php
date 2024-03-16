<?php

require_once('../../Config/conexion.php');
$con = new db();
$PDO = $con->conexion();

if ($_POST) {
    $data = limpiarDato($_POST['documento']);
    /*  echo $data; */

    $infoDocumentos = "";
    $query = "SELECT * FROM `documentos` WHERE `nombre` LIKE '%" . $data . "%' OR `fecha` LIKE  '%" . $data . "%' ";

    $documentos = $PDO->prepare($query);
    $documentos->execute();

    if ($documentos->rowCount() > 0) {

    $infoDocumentos = '
    <table class="table align-items-center mb-0">
    <thead>
        <tr>
            <th class="text-uppercase text-center text-secondary text-xs font-weight-bold ps-2">n°</th>
            <th class="text-uppercase text-center text-secondary text-xs font-weight-bold ps-2">nombre</th>
            <th class="text-uppercase text-center text-secondary text-xs font-weight-bold ps-2">fecha</th>
            <th class="text-uppercase text-center text-secondary text-xs font-weight-bold ps-2">opciones</th>
        </tr>
    </thead>
    <tbody>
    ';
    $n = 1;

    while ($documento = $documentos->fetch(PDO::FETCH_ASSOC)) {
      
        $infoDocumentos .= '
         <tr>
                                                <td>
                                                    <div class="text-uppercase align-middle text-center text-xs font-weight-bold">
                                                        <span class="text-uppercase align-middle text-center text-xs font-weight-bold"> '.$n.'</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-uppercase align-middle text-center text-xs font-weight-bold">
                                                        <span class="text-uppercase align-middle text-center text-xs font-weight-bold">'.$documento['nombre'].'</span>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="text-uppercase align-middle text-center text-xs font-weight-bold">
                                                        <span class="text-uppercase align-middle text-center text-xs font-weight-bold">'.$documento['fecha'].'</span>
                                                    </div>
                                                </td>



                                                <td>
                                                    <div class="text-uppercase align-middle text-center ">
                                                        <form action="" method="POST">
                                                            <input type="hidden" name="id" value="'.$documento['id_documento'].'">
                                                            <div class="text-uppercase align-middle text-center ">
                                                                <button style="border:none" class="badge badge-sm bg-gradient-info" type="submit" name="accion" value="verDocumento"><i class="fa-solid fa-eye"></i></button>
                                                                <button style="border:none" class="badge badge-sm bg-gradient-success" type="submit" name="accion" value="verDocumento"><i class="fa-solid fa-list-check"></i></button>
                                                                <button style="border:none" data-bs-toggle="modal" data-bs-target="#staticBackdrop'.$documento['id_documento'].'" class="badge badge-sm bg-gradient-danger" type="button"><i class="fa-solid fa-trash-can"></i> </button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </td>
                                                <div class="modal fade" id="staticBackdrop'.$documento['id_documento'].'" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">ADVERTENCIA!</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="alert " role="alert">
                                                                    <p class="mb-0">Esta operación no se puede deshacer, para eliminar el <b>Documento</b> presione aceptar</p>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                <form action="" method="post">
                                                                    <input type="hidden" name="id" value="'.$documento['id_documento'].'">
                                                                    <button name="accion" value="eliminarDocumento" type="submit" class="btn btn-danger">Aceptar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>
        ';
    }
    $n++;

    }
    echo $infoDocumentos;
}
function limpiarDato($dato)
{
return htmlspecialchars($dato, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}