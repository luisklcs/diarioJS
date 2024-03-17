<?php
require_once(dirname(__DIR__) . '/admin/layout/links.php');

if (isset($_SESSION['user']) && $_SESSION['user']['rol'] == 1) {

    require_once(dirname(dirname(__DIR__)) . '/Controller/clientesController.php');
    $controller = new clientesController();
    if (isset($_SESSION['cliente'])) {
        unset($_SESSION['cliente']);
    }
    if (isset($_SESSION['vistas'])) {
        unset($_SESSION['vistas']);
    }

    $cantidadClientes = $controller->contar();

    $pagActual = isset($_GET['pag']) ? $_GET['pag'] : 1;
    $limite = 10;
    $inicio = ($pagActual - 1) * $limite;
    $total_paginas = ceil($cantidadClientes / $limite);

    $data = $controller->listar($inicio, $limite);
    include 'aside.php';
    $asd = new Aside();
?>

    <link rel="icon" href="../assets/img/icon.png" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <body class="g-sidenav-show  bg-gray-100">
        <?php $opc = "clientes";
        $asd->aside($opc);
        require_once(dirname(__DIR__) . '/admin/layout/header.php');
        ?>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row my-4">
                <!-- LISTA DE CLIENTES LISTA DE CLIENTES LISTA DE CLIENTES LISTA DE CLIENTES LISTA DE CLIENTES -->
                <div class="col-lg-12  mb-md-0 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-lg-6 col-7">
                                    <h6 class="text-uppercase "><?php print_r($controller->tituloPagina) ?></h6>
                                    <p class="text-sm mb-2">
                                        Mostrando <?php print_r($data['n']) ?> registros de
                                        <span class="font-weight-bold ms-1">
                                            <?php print_r($cantidadClientes); ?>
                                        </span> Clientes registrados <i class="fa fa-check text-info" aria-hidden="true"></i>
                                    </p>
                                    <?php

                                    ?>
                                </div>
                                <div class="col-lg-6 col-7">
                                    <div class="input-group">
                                        <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="busquedaCliente" id="busquedaCliente" placeholder="Ingrese el nombre, apellido o email que desea buscar">
                                    </div>
                                </div>
                                <?php # print_r($_POST);
                                ?>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive" id="resultadobusqueda" name="resultadobusqueda"></div>
                            <div id="modalResultado" name="modalResultado"></div>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0" id="tablaClientes">
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
                                    <tbody>
                                        <?php
                                        $n = 1;

                                        while ($cliente = $data['clientes']->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex  py-1">
                                                        <span class="text-uppercase text-xs font-weight-bold"><?php echo $n;
                                                                                                                $n++ ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex  py-1">
                                                        <span class="text-uppercase text-xs font-weight-bold"><?php echo ($cliente['nombreUsuario']) ?></span>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="d-flex  py-1">
                                                        <span class="text-uppercase text-xs font-weight-bold"><?php echo ($cliente['apellidos']) ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex  py-1">
                                                        <span class=" text-xs font-weight-bold"><?php echo ($cliente['correo']) ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex  py-1">
                                                        <span class="text-uppercase text-xs font-weight-bold"><?php echo ($cliente['identificacion']) ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex  py-1">
                                                        <span class="text-uppercase text-xs font-weight-bold"><?php echo ($cliente['f_registro']) ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex  py-1">
                                                        <span class="text-uppercase text-xs font-weight-bold"><?php if ($cliente['f_suspencion'] == null) {
                                                                                                                    echo "-------";
                                                                                                                } else {
                                                                                                                    echo ($cliente['f_suspencion']);
                                                                                                                } ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex  py-1">
                                                        <span class="text-uppercase text-xs font-weight-bold"><?php if ($cliente['f_reactivacion'] == null) {
                                                                                                                    echo "-------";
                                                                                                                } else {
                                                                                                                    echo ($cliente['f_reactivacion']);
                                                                                                                } ?></span>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="d-flex py-1">
                                                        <form action="" method="POST">
                                                            <input type="hidden" name="idCliente" value="<?php echo $cliente['id_usuario']; ?>">
                                                            <div class="ms-auto text-end">
                                                                <button style="border:none" class="badge badge-sm bg-gradient-info" type="submit" name="accion" value="vistascliente"><i class="fa-solid fa-eye"></i></button>
                                                                <form action="editar.php" method="post">
                                                                    <button style="border:none" class="badge badge-sm bg-gradient-success" type="submit" name="accion" value="editarcliente"><i class="fa-solid fa-pen-to-square"></i> </button>
                                                                </form>
                                                                <button style="border:none" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $cliente['id_usuario']; ?>" class="badge badge-sm bg-gradient-danger" type="button"><i class="fa-solid fa-trash-can"></i> </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </td>
                                                <div class="modal fade" id="staticBackdrop<?php echo $cliente['id_usuario'];; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                                                    <input type="hidden" name="id" value="<?php echo $cliente['id_usuario'];; ?>">
                                                                    <button name="accion" value="eliminarCliente" type="submit" class="btn btn-danger">Aceptar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <!-- Modal -->
                                <div class="modal fade" id="modalEliminarCliente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEliminarClienteLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalEliminarClienteLabel">Eliminar Cliente</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Estás seguro de que deseas eliminar este cliente?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form id="formEliminarCliente" action="" method="post">
                                                    <input type="hidden" id="idClienteEliminar" name="id">
                                                    <button name="accion" value="eliminarCliente" type="submit" class="btn btn-danger">Aceptar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <!--  FIN LISTA DE CLIENTES FIN LISTA DE CLIENTES FIN LISTA DE CLIENTES FIN LISTA DE CLIENTES -->

            </div>


            <!--  PAGINADOR PAGINADOR PAGINADOR PAGINADOR PAGINADOR  -->
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <?php

                    $pagVisibles = 6;

                    $div = ceil($pagVisibles / 2);

                    $pagInicio = ($pagActual > $div) ? ($pagActual - $div) : 1;

                    if ($total_paginas > $div) {
                        $pagRestantes = $total_paginas - $pagActual;
                        $pagFin = ($pagRestantes > $div) ? ($pagActual + $div) : $total_paginas;
                    } else {
                        $pagFin = $total_paginas;
                    }

                    echo ($pagActual > 1) ? '<a class="btn btn-primary" id="Anterior" href="' . $_SERVER['PHP_SELF'] . '?pag=' . ($pagActual - 1) . '" role="button">Anterior</a>' :

                        '<button type="button"  id="AnteriorNo" class="btn btn-outline-secondary" disabled>Anterior</button>';

                    for ($i = $pagInicio; $i <= $pagFin; $i++) {
                        echo ($i == $pagActual) ?
                            ' <li class="page-item active">
                            <a class="page-link" id="boton" href="?pagina=' . $i . '">' . $i . '</a>
                          </li>'
                            : ' <a class="page-link" id="boton" href="' . $_SERVER['PHP_SELF'] . '?pag=' . $i . '">' . $i . '</a>';
                    }

                    echo ($pagActual < $total_paginas) ? ' <a class="btn btn-primary" id="Siguiente" href="' . $_SERVER['PHP_SELF'] . '?pag=' . ($pagActual + 1) . '" role="button">Siguiente</a> ' :
                        '<button type="button" id="SiguienteNo" class="btn btn-outline-secondary" disabled>Siguiente</button>';


                    ?>
                </ul>
                <style>
                    #Anterior {
                        margin: 10px;
                    }

                    #Siguiente {
                        margin: 10px;
                    }

                    #AnteriorNo {

                        margin: 10px;
                    }

                    #SiguienteNo {
                        margin: 10px;
                    }

                    #boton {
                        margin-top: 10px;
                        margin-left: 2px;
                        margin-right: 2px;
                    }
                </style>
            </nav>


            <!--   FIN PAGINADOR FIN PAGINADOR FIN PAGINADOR FIN PAGINADOR FIN PAGINADOR  -->

        <?php

        if (isset($_POST['accion'])) {

            switch ($_POST['accion']) {

                case 'vistascliente':
                    $_SESSION['id'] = $_POST['idCliente'];
                    echo '<script type="text/javascript"> location.href = "vistascliente.php";  </script> ';
                    break;
                case 'editarcliente':
                    $controller->editar($_POST['idCliente']);
                    break;
                case 'eliminarCliente':
                 $controller->eliminarCliente($_POST['id']);
            }
        }
        require_once(dirname(__DIR__) . '/admin/layout/footer.php');
    } else {
        header("location:../../index.php");
    } ?>

        <script>
          
            $(buscarClientes());
           // $(buscarIdCliente());

            function buscarClientes(cliente) {

                $.ajax({

                    url: 'buscarCliente.php',
                    type: 'POST',
                    dataType: 'html',
                    data: {
                        cliente: cliente
                    },
                    success: function(resultado) {

                        $("#resultadobusqueda").html(resultado);

                    }


                })
            }

            function buscarIdCliente(cliente) {
                $.ajax({
                    url: 'buscarIdCliente.php',
                    type: 'POST',
                    dataType: 'html',
                    data: {
                        cliente: cliente
                    },
                    success: function(resultado) {
                        // Establece el ID del cliente en el campo oculto del formulario en el modal
                        $("#idClienteEliminar").val(resultado);
                        // Abre el modal
                        $("#modalEliminarCliente").modal('show');
                        $("#modalResultado").html(resultado);
                    }
                });
            }


            $(document).on('keyup', '#busquedaCliente', function() {
                var valorBusqueda = $(this).val();
                if (valorBusqueda != "") {
                    $("#tablaClientes").hide();
                    buscarClientes(valorBusqueda);
                   
                } else {
                    $("#tablaClientes").show();
                    buscarClientes();
                  
                }
            })
        </script>