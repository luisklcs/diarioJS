<?php
require_once(dirname(__DIR__) . '/Views/global/links.php');
if (isset($_SESSION['user']) && $_SESSION['user']['rol'] == 2) {
    require_once('../Controller/statusController.php');
    $statusController = new statusController();
    $status = $statusController->myStatus($_SESSION['user']['id_usuario']);
    if ($status == 1) {

        $fechaRegistro = $statusController->myFechaDeRegistro($_SESSION['user']['id_usuario']);
        $impresion = $statusController->impresionStatus($_SESSION['user']['id_usuario']);

        
        include 'aside_cliente.php';
        $asd = new Aside();

        require_once(dirname(__DIR__) . '/Controller/documentosController.php');

        $controller = new DocumentosController();
        $cantidadDocumentos = $controller->contar($fechaRegistro);

        $pagActual = isset($_GET['pag']) ? $_GET['pag'] : 1;
        $limite = 10;
        $inicio = ($pagActual - 1) * $limite;
        $total_paginas = ceil($cantidadDocumentos / $limite);

        $lista = $controller->listar($inicio, $limite, $fechaRegistro);

        #
        if (isset($_POST['accion']) && $_POST['accion']=='ver') {
            $id = $_POST['id'];
            if ($impresion == 1) {
            $controller->verDocImpresion($id);
            }else{
                $controller->verDocCliente($id);
            }
       
       
        }

     /*    if ($_POST) {
            $id = $_POST['id'];
            $accion = $_POST['accion'];

            switch ($accion) {

                case 'ver':
                    $controller->verDocCliente($id);
                    break;
            }
        } */


?>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <body class="g-sidenav-show  bg-gray-100">
            <?php $opc = "documentos";
            $asd->aside($opc);

            require_once(dirname(__DIR__) . '/Views/global/header.php');
            ?>
            <div class="container-fluid py-4">

                <div class="row">
                    <div class="col-12">
                        <div class="tabla" id="resultado">
                            <?php
                            if (isset($_SESSION['resultado'])) {
                                print_r($_SESSION['resultado']);
                                unset($_SESSION['resultado']);
                            }   ?>
                        </div>
                    </div>
                </div>

                <!-- TABLA TABLA TABLA TABLA TABLA TABLA TABLA TABLA TABLA TABLA TABLA -->

                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header pb-0">
                                <h6>Documentos</h6>

                            </div>
                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase  text-center text-secondary text-xs font-weight-bold ps-2">n°</th>
                                                <th class="text-uppercase  text-center text-secondary text-xs font-weight-bold ps-2">nombre</th>
                                                <th class="text-uppercase  text-center text-secondary text-xs font-weight-bold ps-2">fecha</th>
                                                <th class="text-uppercase  text-center text-secondary text-xs font-weight-bold ps-2">opciones</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $n = 1;
                                            while ($documento = $lista['docs']->fetch(PDO::FETCH_ASSOC)) {


                                                $vistas = $controller->vistasDocumento($documento['id_documento']);
                                                /*   echo "<pre>";
                                            print_r($vistas); */
                                            ?>
                                                <tr>
                                                    <td>
                                                        <div class="text-uppercase align-middle text-center text-xs font-weight-bold">
                                                            <span class="text-uppercase text-xs font-weight-bold"><?php echo $n;
                                                                                                                    $n++ ?></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-uppercase align-middle text-center text-xs font-weight-bold">
                                                            <span class="text-uppercase text-xs font-weight-bold"><?php echo ($documento['nombre']) ?></span>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="text-uppercase align-middle text-center text-xs font-weight-bold">
                                                            <span class="text-uppercase text-xs font-weight-bold"><?php echo ($documento['fecha']) ?></span>
                                                        </div>
                                                    </td>

                                                    <?php
                                                    if ($vistas['TotalUsadas'] >= $vistas['asignadas']) {
                                                    ?>
                                                        <td>
                                                            <div class=" align-middle text-center">
                                                                <div class="text-uppercase align-middle text-center ">
                                                                    <button class="badge  align-middle text-center badge-sm bg-gradient-danger" style="border: none;" type="button" name="accion" value="ver" onclick="sinVistas()"><i class="fa-solid fa-eye-slash"></i></button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                </tr>
                                            <?php
                                                    } else {
                                            ?>
                                                <td>
                                                    <div class=" align-middle text-center">
                                                        <form action="" method="POST">
                                                            <input type="hidden" name="id" value="<?php echo $documento['id_documento'] ?>">
                                                            <div class="text-uppercase align-middle text-center ">
                                                                <button class="badge  align-middle text-center badge-sm bg-gradient-success" style="border: none;" type="submit" name="accion" value="ver">Ver</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </td>
                                                </tr>
                                        <?php
                                                    }
                                                }

                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIN TABLA FIN TABLA FIN TABLA FIN TABLA FIN TABLA FIN TABLA FIN TABLA -->


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


                <script>
                    function sinVistas() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Upsss... Ya no puedes ver este documento! 😢',
                            text: 'Ya utilizaste todas tus vistas! ',
                        })
                    }
                </script>


        <?php
        require_once(dirname(__DIR__) . '/Views/global/footer.php');
    } else {
        echo '<script type="text/javascript"> location.href = "/Views/admin/cerrarSesion.php";  </script> ';
    }
} else {
    header("location:../../index.php");
} ?>