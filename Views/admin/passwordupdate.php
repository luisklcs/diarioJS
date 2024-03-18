<?php
require_once(dirname(__DIR__) . '/admin/layout/links.php');
if (isset($_SESSION['user']) && $_SESSION['user']['rol'] = 1) {

    require_once(dirname(dirname(__DIR__)) . '/Controller/sessionController.php');
    require_once(dirname(dirname(__DIR__)) . '/Controller/clientesController.php');

    $controller = new clientesController();
    $controller->tituloPagina = "Actualizar contraseña";
    include 'aside.php';
    $asd = new Aside();


?>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="../assets/img/icon.png" type="image/png">
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            appearance: textfield;
        }
    </style>

    <body class="g-sidenav-show  bg-gray-100">
        <?php $opc = "registrar";
        $asd->aside($opc);
        require_once('../admin/layout/header.php');
        ?>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row my-4">

                <div class="col-lg-8  mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-lg-12 ">
                                    <h3 class="text-uppercase">Cambiar contraseña</h3>

                                </div>
                            </div>
                            <form class="column" action="" method="post" style="align-items: center; text-align:center">
                                <div class="col">


                                    <div class="col-md-4">
                                        <label for="inputPassword4" class="form-label">Contraseña actual</label>
                                        <input type="password" class="form-control" name="actpass" id="actpass" required>
                                    </div>



                                    <div class="col-md-4">
                                        <label for="inputPassword4" class="form-label">Nueva contraseña</label>
                                        <input type="password" class="form-control" name="newpass" id="newpass" required>
                                    </div>



                                    <div class="col-4">
                                        <label for="inputAddress2" class="form-label">Confirmar contraseña</label>
                                        <input type="password" class="form-control" name="confpass" id="confpass" required>
                                    </div>



                                </div>
                                <div class="col-md-4 mb-3" id="verificar">
                                    <span id=""></span>
                                </div>


                                <div class="row" style="align-items: center; text-align:center">
                                    <div class="col">
                                        <button name="accion" value="ActualizarPass" type="submit" class="btn btn-success" style="width: 180px;">Actualizar</button>
                                    </div>
                                </div>

                                <script type="text/javascript">
                                    $('#confpass').on('blur', function() {

                                        var pass1 = $('#newpass').val();
                                        var pass2 = $('#confpass').val();

                                        if (pass1 == pass2) {
                                            $('#verificar').fadeIn(1000).html('<div class="alert alert-success"><strong>Genial!</strong> las contraseñas coinciden.</div>');
                                            window.setTimeout(function() {
                                                $('#verificar').fadeOut(1000).html('<div class="alert alert-success"><strong>Genial!</strong> las contraseñas coinciden.</div>');
                                            }, 2000);
                                            pass = true;
                                        } else {
                                            $('#verificar').fadeIn(1000).html('<div class="alert alert-danger"><strong>Upss!</strong> las contraseñas no coinciden.</div>');
                                            window.setTimeout(function() {
                                                $('#verificar').fadeOut(1000).html('<div class="alert alert-danger"><strong>Upss!</strong> las contraseñas no coinciden.</div>');
                                            }, 2000);

                                            pass = false;
                                        }
                                    });
                                </script>
                        </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
        </div>


    <?php


    if (isset($_POST['accion']) && $_POST['accion'] == 'ActualizarPass') {
        $update = new sessionController();
        $update->actualizarPass($_POST['actpass'], $_POST['newpass'], $_SESSION['user']['id_usuario']);
    }

    require_once(dirname(__DIR__) . '/admin/layout/footer.php');
} else {
    header("location:../../index.php");
}  ?>
    <script src="../assets/jquery/jquery.min.js"></script>