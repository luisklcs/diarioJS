<?php

require_once('../../Config/conexion.php');
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

        $infoCliente .='<div class="table-responsive">
        <table class="table align-items-center mb-0" id="tablaResultado">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">n°</th>
                    <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">nombre</th>
                    <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">apellidos</th>
                    <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">correo</th>
                    <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">identificacion</th>
                    <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">fecha de registro</th>
                    <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">fecha de suspensión</th>
                    <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">fecha de reactivación</th>
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

         $infoCliente .='
                <tr>
                    <td>
                        <div class="d-flex  py-1">
                            <span class="text-uppercase text-xs font-weight-bold">'.$n.'</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex  py-1">
                            <span class="text-uppercase text-xs font-weight-bold">'.$cliente['nombreUsuario'].'</span>
                        </div>
                    </td>
    
                    <td>
                        <div class="d-flex  py-1">
                            <span class="text-uppercase text-xs font-weight-bold">'.$cliente['apellidos'].'</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex  py-1">
                            <span class=" text-xs font-weight-bold">'.$cliente['correo'].'</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex  py-1">
                            <span class="text-uppercase text-xs font-weight-bold">'.$cliente['identificacion'].'</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex  py-1">
                            <span class="text-uppercase text-xs font-weight-bold">'.$cliente['f_registro'].'</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex  py-1">
                            <span class="text-uppercase text-xs font-weight-bold">'. $fecha_suspension.'</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex  py-1">
                            <span class="text-uppercase text-xs font-weight-bold">'. $fecha_reactivacion.'</span>
                        </div>
                    </td>
    
                    <td>
                        <div class="d-flex py-1">
                            <form action="" method="POST">
                                <input type="hidden" name="idCliente" value="'.$cliente['id_usuario'].'">
                                <div class="ms-auto text-end">
                                    <button style="border:none" class="badge badge-sm bg-gradient-info" type="submit" name="accion" value="vistascliente"><i class="fa-solid fa-eye"></i></button>
                                    <form action="editar.php" method="post">
                                        <button style="border:none" class="badge badge-sm bg-gradient-success" type="submit" name="accion" value="editarcliente"><i class="fa-solid fa-pen-to-square"></i> </button>
                                    </form>
                                    <button style="border:none" data-bs-toggle="modal" data-bs-target="#staticBackdrop'.$cliente['id_usuario'].'" class="badge badge-sm bg-gradient-danger" type="button"><i class="fa-solid fa-trash-can"></i> </button>
                                </div>
                            </form>
                        </div>
                    </td>
    
                    <div class="modal fade" id="staticBackdrop'.$cliente['id_usuario'].'" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">ADVERTENCIA!</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert " role="alert">
                                        <p class="mb-0">Esta operación no se puede deshacer, para eliminar el <b>Cliente</b> presione aceptar</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="" method="post">
                                        <input type="hidden" name="id" id="idCliente" value="'.$cliente['id_usuario'].'">
                                        <button name="accion" value="eliminarCliente" type="submit" class="btn btn-danger">Aceptar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
    
                </tr>';       
     
      $n++;
        }
    }
   $infoCliente .= '</tbody>
   </table>
   </div>';
    echo $infoCliente;
}

function limpiarDato($dato)
{
    return htmlspecialchars($dato, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}



       
      