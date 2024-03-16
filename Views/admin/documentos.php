<?php
require_once(dirname(__DIR__).'/admin/layout/links.php');
if (isset($_SESSION['user']) && $_SESSION['user']['rol'] = 1) {
    require_once(dirname(dirname(__DIR__)).'/Controller/documentosController.php');

    $controller = new DocumentosController();

    $cantidadDocumentos = $controller->contar();

    $pagActual = isset($_GET['pag']) ? $_GET['pag'] : 1;
    $limite = 10;
    $inicio = ($pagActual - 1) * $limite;
    $total_paginas = ceil($cantidadDocumentos / $limite);

    $lista = $controller->listar($inicio, $limite);

    include 'aside.php';
    $asd = new Aside();
?>

    <link rel="icon" href="../assets/img/icon.png" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <body class="g-sidenav-show  bg-gray-100">

        <?php $opc = "documentos";
        $asd->aside($opc);
        require_once('../admin/layout/header.php');
        ?>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row my-4">
                <!-- LISTA DE DOCUMENTOS LISTA DE DOCUMENTOS LISTA DE DOCUMENTOS LISTA DE DOCUMENTOS LISTA DE DOCUMENTOS -->
                <div class="col-lg-12 mb-md-0 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-lg-6 col-7">
                                    <h6 class="text-uppercase "><?php print_r($controller->tituloPagina) ?></h6>
                                    <p class="text-sm mb-2">
                                        Mostrando 10 documentos de
                                        <span class="font-weight-bold ms-1">
                                            <?php print_r($cantidadDocumentos); ?>
                                        </span> registrados <i class="fa fa-check text-info" aria-hidden="true"></i>
                                    </p>
                                </div>
                                <div class="col-lg-6 col-7">
                                    <div class="input-group">
                                        <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="busquedaDocumento" id="busquedaDocumento" placeholder="Ingrese el nombre o fecha del documento">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php

                        if ($_POST) {

                            $id = $_POST['id'];
                            switch ($_POST['accion']) {

                                case 'verDocumento':
                                    $controller->verDocAdmin($id);
                                    break;

                                case 'eliminarDocumento':
                                    $controller->borrarDocumento($id);
                                    break;
                            }
                        }

                        ?>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive" id="resultadobusqueda" name="resultadobusqueda">

                            </div>
                            <div class="table-responsive" id="tablaDocumentos">
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
                                        <?php
                                        $n = 1;

                                        while ($documento = $lista['docs']->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="text-uppercase align-middle text-center text-xs font-weight-bold">
                                                        <span class="text-uppercase align-middle text-center text-xs font-weight-bold"><?php echo $n;
                                                                                                                                        $n++ ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-uppercase align-middle text-center text-xs font-weight-bold">
                                                        <span class="text-uppercase align-middle text-center text-xs font-weight-bold"><?php echo ($documento['nombre']) ?></span>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="text-uppercase align-middle text-center text-xs font-weight-bold">
                                                        <span class="text-uppercase align-middle text-center text-xs font-weight-bold"><?php echo ($documento['fecha']) ?></span>
                                                    </div>
                                                </td>



                                                <td>
                                                    <div class="text-uppercase align-middle text-center ">
                                                        <form action="" method="POST">
                                                            <input type="hidden" name="id" value="<?php echo $documento['id_documento']; ?>">
                                                            <div class="text-uppercase align-middle text-center ">
                                                                <button style="border:none" class="badge badge-sm bg-gradient-info" type="submit" name="accion" value="verDocumento"><i class="fa-solid fa-eye"></i></button>
                                                                <button style="border:none" class="badge badge-sm bg-gradient-success" type="submit" name="accion" value="verDocumento"><i class="fa-solid fa-list-check"></i></button>
                                                                <button style="border:none" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $documento['id_documento']; ?>" class="badge badge-sm bg-gradient-danger" type="button"><i class="fa-solid fa-trash-can"></i> </button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </td>
                                                <div class="modal fade" id="staticBackdrop<?php echo $documento['id_documento']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                                                    <input type="hidden" name="id" value="<?php echo $documento['id_documento']; ?>">
                                                                    <button name="accion" value="eliminarDocumento" type="submit" class="btn btn-danger">Aceptar</button>
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
                            </div>
                        </div>
                    </div>
                </div>
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

            <script>
                $(buscarDocumento());

                function buscarDocumento(documento) {

                    $.ajax({

                        url: 'buscarDocumento.php',
                        type: 'POST',
                        dataType: 'html',
                        data: {
                            documento: documento
                        },
                        success: function(resultado) {

                            $("#resultadobusqueda").html(resultado);

                        }


                    })
                }

                $(document).on('keyup', '#busquedaDocumento', function() {
                    var valorBusqueda = $(this).val();
                    if (valorBusqueda != "") {
                        $("#tablaDocumentos").hide();
                        buscarDocumento(valorBusqueda);
                    } else {

                        
                        $("#tablaDocumentos").shw();
                        buscarDocumento();
                    }
                })
            </script>

        <?php require_once(dirname(__DIR__).'/admin/layout/footer.php');
    } else {
        header("location:../../index.php");
    } ?>