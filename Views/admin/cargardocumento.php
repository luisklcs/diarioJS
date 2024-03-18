<script type="text/javascript">
    setTimeout(function() {
        if (window.history.replaceState) {
            console.log("prueba");
            window.history.replaceState(null, null, window.location.href);
        }
    }, 1500);
</script>
<?php

require_once(dirname(dirname(__DIR__)) . '/Views/admin/layout/links.php');

if (isset($_SESSION['user']) && $_SESSION['user']['rol'] == 1) {

    require_once(dirname(dirname(__DIR__)) . '/Controller/documentosController.php');
    $controller = new documentosController();
    $controller->tituloPagina = "Cargar documentos";

    date_default_timezone_set('America/Bogota');
    $fecha = date("Y-m-d");

    $dayOfWeek = date('l');
    $month = date('F');
    $days = array(
        'Monday' => 'Lunes',
        'Tuesday' => 'Martes',
        'Wednesday' => 'Miércoles',
        'Thursday' => 'Jueves',
        'Friday' => 'Viernes',
        'Saturday' => 'Sábado',
        'Sunday' => 'Domingo'
    );

    $months = array(
        'January' => 'Enero',
        'February' => 'Febrero',
        'March' => 'Marzo',
        'April' => 'Abril',
        'May' => 'Mayo',
        'June' => 'Junio',
        'July' => 'Julio',
        'August' => 'Agosto',
        'September' => 'Septiembre',
        'October' => 'Octubre',
        'November' => 'Noviembre',
        'December' => 'Diciembre'
    );

    $ndia = date("d");
    $anio = date("Y");

    $dia = $days[$dayOfWeek];
    $mes = $months[$month];

    include 'aside.php';
    $asd = new Aside();
?>

    <link rel="icon" href="../assets/img/icon.png" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <body class="g-sidenav-show  bg-gray-100">
        <?php $opc = "agregardocumento";
        $asd->aside($opc);
        require_once(dirname(__DIR__) . '/admin/layout/header.php');
        ?>



        <div class="container-fluid py-4">
            <div class="row my-4">
                <div class="col-lg-12 mb-md-0 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-lg-12 col-7">
                                    <h3 class="text-uppercase">Cargar Documento</h3>
                                    <p><?php # print_r($_POST)
                                        ?></p>
                                </div>
                            </div>

                            <form class="row" action="" method="post" enctype="multipart/form-data">

                                <div class="col-md-5">
                                    <label for="input" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" value="Estados judiciales <?php echo "{$dia} $ndia de {$mes} de {$anio} "; ?>" required>
                                </div>

                                <div class="col-md-2">
                                    <label for="input" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" name="fecha" value="<?php echo $fecha ?>" required>
                                </div>


                                <div class="col-md-5">
                                    <label for="input" class="form-label">Seleccionar archivo</label>
                                    <input type="file" class="form-control" name="documento">
                                </div>


                                <div class="col-md-12"> <br> </div>
                                <div class="row">

                                    <div class="col">
                                        <button name="accion" value="subir" type="submit" class="btn btn-success" style="width: 180px;">Guardar</button>
                                        <button name="accion" value="vertodos" type="submit" class="btn btn-info" onclick="documentos()">Ver archivos</button>
                            </form>


                        </div>
                        <div class="col-5">


                            <button name="accion" value="notificar" type="submit" class="btn btn-warning" ">Notificar usuarios</button>
                                </div>
                                
                                <script>
                                function documentos(){
                                setTimeout(function(){
                                location.href = "documentos.php";
                                }, 0);
                                }
                                </script>
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
        </div>

    <?php


    if (isset($_POST['accion']) && $_POST['accion'] == 'subir') {
        $controller->CargarDocumento();
    } elseif (isset($_POST['accion']) && $_POST['accion'] == 'notificar') {
        $controller->enviarmail();
    }

    require_once(dirname(__DIR__) . '/admin/layout/footer.php');
} else {
    header("location:../../index.php");
} ?>