<?php
require_once(dirname(__DIR__) . '/admin/layout/links.php');
if (isset($_SESSION['user']) && $_SESSION['user']['rol'] = 1 ) {
require_once(dirname(__DIR__) . '../../Controller/clientesController.php');
$controller = new clientesController();
include 'aside.php';
$asd = new Aside();

$id =   $_SESSION['id'];
if (!isset($_SESSION['id'])) {
   header("location:clientes.php");
} else {
$data = $controller->cargarVistas($id);


    
    ?>
<?php #require_once(dirname(__DIR__) . '/admin/layout/buscar.php'); 
?>
<link rel="icon" href="../assets/img/icon.png" type="image/png">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<body class="g-sidenav-show  bg-gray-100">
    <?php $opc = "";
    $asd->aside($opc);
    require_once(dirname(__DIR__) . '/admin/layout/header.php');
    ?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row my-4">
            <!-- LISTA DE CLIENTES LISTA DE CLIENTES LISTA DE CLIENTES LISTA DE CLIENTES LISTA DE CLIENTES -->
            <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6 class="text-uppercase ">Lista de documentos visualizados por el cliente</h6>
                                <p class="text-sm mb-2">
                                    Mostrando <?php #print_r($data['n']) ?> registros de
                                    <span class="font-weight-bold ms-1">
                                        <?php #print_r($cantidadClientes); ?>
                                    </span>documentos visualizados <i class="fa fa-check text-info" aria-hidden="true"></i>
                                </p>
                            </div>
                      
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">n°</th>
                                        <th class="text-uppercase text-center text-secondary text-xs font-weight-bold ps-2">nombre</th>
                                        <th class="text-uppercase text-center text-secondary text-xs font-weight-bold ps-2">Vistas asignadas</th>
                                        <th class="text-uppercase text-center text-secondary text-xs font-weight-bold ps-2">vistas usadas</th>
                                        <th class="text-uppercase text-center text-secondary text-xs font-weight-bold ps-2">Usadas hoy</th>
                                        <th class="text-uppercase text-center text-secondary text-xs font-weight-bold ps-2">fecha primera vista</th>
                                        <th class="text-uppercase text-center text-secondary text-xs font-weight-bold ps-2">fecha ultima vista</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $n = 1;
                                  
                             
                                  while ($cliente = $data->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex  py-1">
                                                    <span class="text-uppercase text-xs font-weight-bold"><?php echo $n;
                                                                                                            $n++ ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="align-middle text-center text-sm  py-1">
                                                    <span class="text-uppercase text-xs font-weight-bold"><?php echo ($cliente['fecha']) ?></span>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="align-middle text-center text-sm  py-1">
                                                    <span class="text-uppercase text-xs font-weight-bold"><?php echo ($cliente['asignadas']) ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="align-middle text-center text-sm  py-1">
                                                    <span class=" text-xs font-weight-bold"><?php echo ($cliente['vistasUsadas']) ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="align-middle text-center text-sm  py-1">
                                                    <span class=" text-xs font-weight-bold"><?php echo ($cliente['vistasHoy']) ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="align-middle text-center text-sm  py-1">
                                                    <span class="text-uppercase text-xs font-weight-bold"><?php echo ($cliente['fechaPrimerVista']) ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="align-middle text-center text-sm  py-1">
                                                    <span class="text-uppercase text-xs font-weight-bold"><?php echo ($cliente['fechaUltimaVista']) ?></span>
                                                </div>
                                            </td>


                                       

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

            <!--  FIN LISTA DE CLIENTES FIN LISTA DE CLIENTES FIN LISTA DE CLIENTES FIN LISTA DE CLIENTES -->

        </div>


        <!--  PAGINADOR PAGINADOR PAGINADOR PAGINADOR PAGINADOR  -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php


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
                    echo '<script type="text/javascript">
                    setTimeout(function() {
                    location.href = "editar.php?i=' . $_POST['idCliente'] . '"; 
                    }, 0);                     
                </script> 
                    ';
                    break;
                case 'editarcliente':
                    echo '<script type="text/javascript">
                    setTimeout(function() {
                    location.href = "editar.php?i=' . $_POST['idCliente'] . '"; 
                    }, 0);                     
                </script> 
                    ';
                    break;
                case 'eliminarCliente':
                    $c = $controller->eliminarCliente($_POST['id']);
                    if ($c==true) {
                        echo "<script>  Swal.fire({
                                icon: 'success',
                                title: 'Genial!😍',
                                text: 'Cliente eliminado exitosamente!',
                                 })   </script>";
                                 echo '<script type="text/javascript">
                                 setTimeout(function() {
                                 location.href = "clientes.php"; 
                                 }, 1000);                     
                             </script> 
                                 ';
                    } else {
                        echo "<script>  Swal.fire({
                                icon: 'error',
                                title: 'Algo anda mal😢!',
                                text: 'No se pudo eliminara el cliente, por favor intentalo nuevamente!',
                                 })   </script>";
                    } 
                    break;
            }
        }
        require_once(dirname(__DIR__) . '/admin/layout/footer.php');
    }} else {
        header("location:../../index.php");
    }  ?>