<?php
require_once(dirname(__DIR__) . '/admin/layout/links.php');
if (isset($_SESSION['user']) && $_SESSION['user']['rol'] = 1 ) {
require_once(dirname(__DIR__) . '../../Controller/clientesController.php');
require_once(dirname(__DIR__) . '../../Controller/dashController.php');
$controller = new DashController();
$dash = $controller->dashboard();
$card = true;

if (isset($_POST['accion'])) {

    switch ($_POST['accion']) {
        case 'cuentasActivas':
            $d = $controller->activas();
            $card = false;


            break;
        case 'ActualizarVistasGenerales':
            $a = $controller->actualizarVistasGenerales($dash['mayoresAgeneral'],$_POST['VistasGenerales']);
           $card = false;
            break;
        case 'cuentasInactivas':
            $d = $controller->inactivas();
            $card = false;
            break;
        case 'personalizadas':
            $d = $controller->personalizadas();
            $card = false;
            break;
        case 'vistasSinRestriccion':
            $d = $controller->vistasSinRestriccion();
            $card = false;
            break;
        case 'impresion':
            $d = $controller->impresion();
            $card = false;
            break;
        case 'cobro':
            $d = $controller->cobro();
            $card = false;
            break;

        case 'editarcliente':
            echo '<script type="text/javascript">
                setTimeout(function() {
                location.href = "editar.php?i=' . $_POST['idCliente'] . '"; 
                }, 0);                     
            </script> 
                ';
            break;
    }
}

include 'aside.php';
$asd = new Aside();
#require_once(dirname(__DIR__) . '/admin/layout/buscar.php'); 

?>
<link rel="icon" href="../assets/img/icon.png" type="image/png">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body class="g-sidenav-show  bg-gray-100">
    <?php $opc = "home";
    $asd->aside($opc);
    require_once(dirname(__DIR__) . '/admin/layout/header.php');
    ?>
    <!-- End Navbar -->


    <div class="container-fluid py-4">

        <?php
        if ($card == true) {
        ?>
            <!--  CARDS INFORMATIVOS   CARDS INFORMATIVOS    CARDS INFORMATIVOS -->
            <div class="container-fluid py-4">
                <form action="" method="POST">
                    <div class="row">

                        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total documentos</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    <?php echo $dash['CantDocumentos']; ?>
                                                    <!--  <span class="text-success text-sm font-weight-bolder">+3%</span> -->
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <a href="documentos.php">
                                                <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                                    <i class="fa-solid fa-file-lines opacity-10" aria-hidden="true"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total clientes</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    <?php echo $dash['CantidadClientes']; ?>
                                                    <!--    <span class="text-success text-sm font-weight-bolder">+55%</span> -->
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <a href="clientes.php">
                                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                                    <i class="fa-solid fa-users opacity-10" aria-hidden="true"></i>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-4 col-sm-6">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Vistas predeterminadas</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    <?php echo $dash['vistasGenerales']; ?>
                                                    <!--   <span class="text-success text-sm font-weight-bolder">+5%</span> -->
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" style="border:none; background-color: transparent;">
                                                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row">

                        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Cuentas activas</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    <?php echo $dash['ClientesActivos']; ?>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <button type="submit" name="accion" value="cuentasActivas" style="border:none; background-color: transparent;">
                                                <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                                    <i class="fa-solid fa-user-check opacity-10" aria-hidden="true"></i>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-sm-6">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Cuentas inactivas</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    <?php echo $dash['ClientesInactivos']; ?>
                                                    <!--   <span class="text-success text-sm font-weight-bolder">+5%</span> -->
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <button type="submit" name="accion" value="cuentasInactivas" style="border:none; background-color: transparent;">
                                                <div class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                                                    <i class="fa-solid fa-user-slash opacity-10" aria-hidden="true"></i>
                                                </div>
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-sm-6">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Vistas Personalizadas</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    <?php echo $dash['mayoresAgeneral']; ?>
                                                    <!--   <span class="text-success text-sm font-weight-bolder">+5%</span> -->
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <button type="submit" name="accion" value="personalizadas" style="border:none; background-color: transparent;">
                                                <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                                    <i class="fa-solid fa-eye-low-vision" aria-hidden="true"></i>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xl-4 col-sm-6">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0  font-weight-bold">Clientes sin restricción de vistas</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    <?php echo $dash['norestringidas']; ?>
                                                    <!--   <span class="text-success text-sm font-weight-bolder">+5%</span> -->
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <button type="submit" name="accion" value="vistasSinRestriccion" style="border:none; background-color: transparent;">
                                                <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                                    <i class="fa-solid fa-users-viewfinder" aria-hidden="true"></i>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0  font-weight-bold">Clientes con permisos de impresión</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    <?php echo $dash['impresion']; ?>
                                                    <!--   <span class="text-success text-sm font-weight-bolder">+5%</span> -->
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <button type="submit" name="accion" value="impresion" style="border:none; background-color: transparent;">
                                                <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                                    <i class="fa-solid fa-print" aria-hidden="true"></i>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-4 col-sm-6">
                            <div class="card">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0  font-weight-bold">Clientes con cobro inactivo</p>
                                                <h5 class="font-weight-bolder mb-0">
                                                    <?php echo  $dash['cobroInactivo'];  ?>
                                                    <!--   <span class="text-success text-sm font-weight-bolder">+5%</span> -->
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <button type="submit" name="accion" value="cobro" style="border:none; background-color: transparent;">
                                                <div class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                                                    <i class="fa-solid fa-hand-holding-dollar" aria-hidden="true"></i>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- FIN CARDS INFORMATIVOS  FIN CARDS INFORMATIVOS   FIN CARDS INFORMATIVOS -->
        <?php
        }

        ?>
        <div class="row my-4">
            <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
                <?php if (isset($d)) {
                ?>
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-lg-6 col-7">
                                    <h6><?php echo $controller->tituloTabla; ?></h6>
                                    <p class="text-sm mb-0">
                                        <i class="fa fa-check text-info" aria-hidden="true"></i>

                                    </p>
                                </div>
                                <div class="col-lg-6 col-5 my-auto text-end">
                                    <div class="dropdown float-lg-end pe-4">
                                        <div class="d-flex py-1">
                                            <form action="" method="POST">
                                                    <div class="ms-auto text-end">
                                                    <button style="border:none" class="badge badge-sm bg-gradient-primary" type="submit" name="accion" value="restaurarbotones"> <i class="fa-solid fa-arrow-left"> Volver </i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive" id="tabladatos">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">n°</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">nombre</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">apellidos</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">correo</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">identificacion</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">Vistas</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $n = 1;
                                        while ($cliente = $d->fetch(PDO::FETCH_ASSOC)) {
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
                                                        <span class="text-uppercase text-xs font-weight-bold"><?php echo ($cliente['asignadas']) ?></span>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="d-flex py-1">
                                                        <form action="" method="POST">
                                                            <input type="hidden" name="idCliente" value="<?php echo $cliente['id_usuario']; ?>">
                                                            <div class="ms-auto text-end">
                                                                <button style="border:none" class="badge badge-sm bg-gradient-success" type="submit" name="accion" value="editarcliente"><i class="fa-solid fa-pen-to-square"></i> </button>
                                                            </div>
                                                        </form>
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
        </div>
    <?php
                }
    ?>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Vistas predeterminadas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Número de vistas predeterminadas para los usuarios:</label>
            <input type="text" class="form-control" name="VistasGenerales" value="<?php echo $dash['vistasGenerales']; ?>">
          </div>
         
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary" name="accion" value="ActualizarVistasGenerales">Actualizar vistas predeterminadas</button>
      </div>
    </div> </form>
  </div>
</div>

    <?php require_once(dirname(__DIR__) . '/admin/layout/footer.php'); 
     } else {
        header("location:../../index.php");
    }
    ?>