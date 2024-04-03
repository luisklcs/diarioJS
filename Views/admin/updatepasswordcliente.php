<?php
require_once(dirname(__DIR__) . '/admin/layout/links.php');
if (isset($_SESSION['user']) && $_SESSION['user']['rol'] = 1) {

    require_once(dirname(dirname(__DIR__)) . '/Controller/clientesController.php');
    require_once(dirname(dirname(__DIR__)) . '/Controller/sessionController.php');

    $controller = new clientesController();
    $controller->tituloPagina = "Actualizar contraseña del cliente";
    include 'aside.php';
    $asd = new Aside();
    $idUser = "";

?>
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
        <?php $opc = "passcliente";
        $asd->aside($opc);
        require_once('../admin/layout/header.php');
        ?>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row my-4" style="    width: 100%;
    margin: 0;
    align-content: center;
    justify-content: center;">

                <div class="col-lg-8  mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-lg-12 ">
                                    <h3 class="text-uppercase text-center">Cambiar contraseña del cliente</h3>

                                </div>
                                <div class="col-lg-12 col-12">
                                    <div class="input-group">
                                        <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="busquedaCliente" id="busquedaCliente" placeholder="Ingrese el nombre, apellido o email que desea buscar">
                                    </div>
                                    <br>
                                </div>

                                <?php
                             
                                if (isset($_POST['accion']) && $_POST['accion'] == "buscarclientepassw") {
                                   $_SESSION['id'] = $_POST['idCliente'];
                                    $info = $controller->infoCuentaCliente($_POST['idCliente']);
                                   
                                    echo ' <div class="table-responsive">
                                    <table class="table align-items-center mb-0" id="tablaClientes">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">nombre</th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">apellidos</th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2">Correo</th>
                                            </tr>
                                        </thead>
                                        </thead>
                                        <tbody>                                   
                                <tr>
                                <td>
                                    <div class="d-flex  py-1">
                                    <input type="hidden" name="id" value="' .$idUser . '">
                                        <span class="text-uppercase text-xs font-weight-bold">' . $info['nombreUsuario'] . '</span>
                                    </div>
                                </td>                
                                <td>
                                    <div class="d-flex  py-1">
                                        <span class="text-uppercase text-xs font-weight-bold">' . $info['apellidos'] . '</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex  py-1">
                                        <span class=" text-xs font-weight-bold">' . $info['correo'] . '</span>
                                    </div>
                                </td>
                                </tr>
                                </table>
                                </div>
                                ';


                                    echo '
                                <form class="row" action="" method="post" style="align-items: center; text-align:center">
                                <div class="row">


                                    <div class="col-md-6">
                                        <label for="inputPassword4" class="form-label">Nueva contraseña</label>
                                        <input type="password" class="form-control" name="newpass" id="pass1" required>
                                    </div>



                                    <div class="col-md-6">
                                        <label for="inputAddress2" class="form-label">Confirmar contraseña</label>
                                        <input type="password" class="form-control" name="confpass" id="pass2" required>
                                    </div>



                                
                                <br>
                                <br>
                                <div class="col-md-12 mb-3" id="verificar">
                                    <span id="verificar"></span>
                                </div>
                                <br>
                                <br>
                                <div class="row" style="align-items: center; text-align:center">
                                <div class="col">
                                    <button name="accion" value="ActualizarPass" id="submit" type="submit" class="btn btn-success" style="width: 180px;">Actualizar</button>
                                </div>
                            </div>                        
                       

                        </form>
                                ';
                                }
                                ?>



                            </div>

                            <div class="table-responsive" id="resultadobusqueda" name="resultadobusqueda"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(buscarClientes());


            function buscarClientes(cliente) {

                $.ajax({

                    url: 'buscarclientepassw.php',
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
                    buscarClientes(valorBusqueda);

                } else {
                    buscarClientes();

                }
            })


            var submitButton = document.getElementById('submit');
            submitButton.disabled = true;
            document.getElementById("pass2").onkeyup = function() {
                validatePassword();
            };

            function validatePassword() {
                var password1 = document.getElementById("pass1").value;
                var password2 = document.getElementById("pass2").value;
                var msg = document.getElementById("verificar");
                if (password1 !== password2) {
                    submitButton.disabled = true;
                    $('#verificar').fadeIn(1000).html('<div class="alert alert-danger"><strong>Upss!</strong> las contraseñas no coinciden.</div>');
                    window.setTimeout(function() {
                        $('#verificar').fadeOut(1000).html('<div class="alert alert-danger"><strong>Upss!</strong> las contraseñas no coinciden.</div>');
                    }, 2000);
                    return false;
                } else {
                    $('#verificar').fadeIn(1000).html('<div class="alert alert-success"><strong>Genial!</strong> las contraseñas coinciden.</div>');
                    window.setTimeout(function() {
                        $('#verificar').fadeOut(1000).html('<div class="alert alert-success"><strong>Genial!</strong> las contraseñas coinciden.</div>');
                    }, 2000);
                    submitButton.disabled = false;
                }
                return true;
            }
        </script>


    <?php

    if (isset($_POST['accion']) && $_POST['accion'] == 'ActualizarPass') {
    $update = new sessionController();
   $update->actualizarPassCliente( $_POST['newpass'], $_SESSION['id']);


    }

    require_once(dirname(__DIR__) . '/admin/layout/footer.php');
} else {
    header("location:../../index.php");
}  ?>
    <script src="../assets/jquery/jquery.min.js"></script>