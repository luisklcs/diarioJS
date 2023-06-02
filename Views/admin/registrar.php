<?php
require_once(dirname(__DIR__) . '/admin/layout/links.php');
if (isset($_SESSION['user']) && $_SESSION['user']['rol'] = 1 ) {
require_once(dirname(__DIR__) . '/../Controller/clientesController.php');

$controller = new clientesController();
$controller->tituloPagina="Registrar cliente";
include 'aside.php';
$asd = new Aside();
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
    <?php $opc = "registrar";
    $asd->aside($opc);
    require_once(dirname(__DIR__) . '/admin/layout/header.php');
    ?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row my-4">

            <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-12 col-7">
                                <h3 class="text-uppercase">Registrar cliente</h3>
                            
                            </div>
                        </div>
                        <form class="row g-4" action="" method="post">

                            <div class="col-md-3">
                                <label for="input" class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" required>
                            </div>
                            <div class="col-3">
                                <label for="input" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" name="apellidos" required>
                            </div>
                            <div class="col-md-3">
                                <label for="input" class="form-label">Identificación</label>
                                <input type="number" class="form-control" name="identificacion" required>
                            </div>
                            <div class="col-md-3">
                                <label for="input" class="form-label">Correo</label>
                                <input type="email" class="form-control" name="correo" required>
                            </div>
                            <div class="col-md-3">
                                <label for="input" class="form-label">Teléfono</label>
                                <input type="number" class="form-control" name="telefono" required>
                            </div>
                            <div class="col-md-3">
                                <label for="input" class="form-label">Teléfono secundario</label>
                                <input type="number" class="form-control" name="telefonoSec" >
                            </div>

                            <div class="col-md-6">
                                <label for="input" class="form-label">Dirección</label>
                                <input type="text" class="form-control" name="direccion" requi>
                            </div>
                            <div class="col-md-3">
                                <label for="input" class="form-label">Estado de cuenta</label>
                                <select class="form-select" aria-label="Default select example" name="estadoCuenta" required>
                                    <option selected>Seleccione una opción</option>
                                    <option value="1">Activa</option>
                                    <option value="0">Inactiva</option>
                                    </select>                            
                            </div>
                            <div class="col-md-3">
                                <label for="input" class="form-label">Permitir impresión</label>
                                <select class="form-select" aria-label="Default select example" name="impresion" required>
                                    <option selected>Seleccione una opción</option>
                                    <option value="1">Permitir</option>
                                    <option value="0">No permitir</option>
                                    </select>                              
                            </div>
                            <div class="col-md-3">
                                <label for="input" class="form-label">Restringir vistas</label>
                                <select class="form-select" aria-label="Default select example" name="restriccionVistas" required>
                                    <option selected>Seleccione una opción</option>
                                    <option value="1">Restringir</option>
                                    <option value="0">No restringir</option>
                                    </select>                         
                            </div>
                            <div class="col-md-3">
                                <label for="input" class="form-label">Estado de cobro</label>
                                <select class="form-select" aria-label="Default select example" name="cobro" required>
                                    <option selected>Seleccione una opción</option>
                                    <option value="1">Activa</option>
                                    <option value="0">Inactiva</option>
                                    </select>                               
                            </div>


                            <div class="col-12">
                                <button type="submit" name="accion" value="registrarCliente" class="btn btn-primary">Registrar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        </div>
        <?php
         if (isset($_POST['accion']) && $_POST['accion']=="registrarCliente") {
            $c = $controller->registrar($_POST);
          if ($c == true) {
                echo "<script>  Swal.fire({
                    icon: 'success',
                    title: 'Genial!😍',
                    text: 'Usuario registrado exitosamente!',
                     })   </script>";
            }else {
                echo "<script>  Swal.fire({
                    icon: 'error',
                    title: 'Algo anda mal😢!',
                    text: 'No se pudo registrar el usuario, por favor intentalo nuevamente!',
                     })   </script>";
            }
          };
        require_once(dirname(__DIR__) . '/admin/layout/footer.php');        
    } else {
        header("location:../../index.php");
    }  ?>