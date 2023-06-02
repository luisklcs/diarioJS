<?php

session_start();

require_once(dirname(__DIR__) . '../../Config/conexion.php');
$bd = new db();
$dbh = $bd->conexion();

$dbh->beginTransaction();

// Realizar la consulta
$stmt1 = $dbh->query('SELECT COUNT(*) FROM documentos');
$stmt2 = $dbh->query('SELECT COUNT(*) FROM usuarios');
$stmt3 = $dbh->query('SELECT COUNT(*) FROM `usuarios` WHERE `estadoCuenta` = 1');
$stmt4 = $dbh->query('SELECT COUNT(*) FROM `usuarios` WHERE `estadoCuenta` = 2');

// Obtener los resultados
$numDocumentos = $stmt1->fetchColumn();
$numUsuarios = $stmt2->fetchColumn();
$cuentasActivas = $stmt3->fetchColumn();
$cuentasInactivas = $stmt4->fetchColumn();

// Confirmar la transacción
$dbh->commit();

// Imprimir los resultados











/* 
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
} */

/* $nombre = $_SESSION['nombre'];
$tipo_usuario = $_SESSION['tipo_usuario'];


if ($tipo_usuario == 1) {
    */
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Estados judiciales</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/d1c19db837.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/vendor/remixicon/remixicon.css">
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Estados judiciales</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button><!-- Navbar Search-->
        <!--<form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
				<input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
				<div class="input-group-append">
				<button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
				</div>
                </div>
			</form>-->
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Admin<?php # echo $nombre; 
                                                                                                                                                                        ?><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">Salir</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">




                        <div class="sb-sidenav-menu-heading">páginas</div>

                        <a class="nav-link" href="layout-static.html">
                            <div class="sb-nav-link-icon"> <i class="ri-file-list-line"></i> </div> Ver documentos
                        </a>
                        <a class="nav-link" href="layout-sidenav-light.html">
                            <div class="sb-nav-link-icon"> <i class="ri-file-upload-line"></i> </div> Cargar nuevo documento
                        </a>


                        <a class="nav-link" href="layout-static.html">
                            <div class="sb-nav-link-icon"><i class="ri-user-shared-2-line"></i></div>Ver clientes
                        </a>
                        <a class="nav-link" href="layout-sidenav-light.html">
                            <div class="sb-nav-link-icon"><i class="ri-user-add-line"></i></div> Registrar nuevo cliente
                        </a>
                        <a class="nav-link" href="layout-sidenav-light.html">
                            <div class="sb-nav-link-icon"><i class="ri-notification-2-line"></i></div> Notificar cliente
                        </a>

                    </div>
                </div>

            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Página principal</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Página principal</li>
                    </ol>
                    <?php
                    /*       require_once '../dash.php';
                  echo $dash; */
                    ?>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="row justify-content-center align-items-center g-2">
                                   <div class="card-body">Usuarios registrados</div>
                                   <div class="card-body"> <strong>  <?php echo $numUsuarios ?></strong></div>
                                </div>
                               
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                <div> ver detalles</div>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-info text-white mb-4">
                                <div class="row justify-content-center align-items-center g-2">
                                    <div class="card-body">Documentos cargados</div>
                                    <div class="card-body"> <strong><?php echo $numDocumentos ?></strong></div>
                                </div>

                                <div class="card-footer d-flex align-items-center justify-content-between">
                                <div> ver detalles</div>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="row justify-content-center align-items-center g-2">
                                    <div class="card-body">Cuentas activas</div>
                                    <div class="card-body"> <strong><?php echo $cuentasActivas ?></strong></div>
                                </div>

                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div> ver detalles</div>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="row justify-content-center align-items-center g-2">
                                       <div class="card-body">Cuentas suspendidas</div>
                                       <div class="card-body">  <strong><?php echo $cuentasInactivas ?></strong></div>
                                </div>
                            
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                <div> ver detalles</div>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>'
                     <div class="row">
                           <p>datos de usuario</p>
                           <p><?php
                           print_r($user)
                           ?></p>
							</div>
                        
						</div>


                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; fabiolavillalba.com 2023</div>
                        <!--  <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
							</div> -->
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>
</body>

</html>
<?php #} 
?>