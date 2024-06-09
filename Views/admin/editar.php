<?php
require_once(dirname(__DIR__) . '/admin/layout/links.php');

if (isset($_SESSION['user']) && $_SESSION['user']['rol'] = 1) {
    require_once(dirname(dirname(__DIR__)) . '/Controller/clientesController.php');


    include 'aside.php';
    $asd = new Aside();

    $controller = new clientesController();
    $data['datos'] = $_SESSION['cliente']['datos'];
    $data['permisos'] = $_SESSION['cliente']['permisos'];
    $data['vistas'] = $_SESSION['cliente']['vistas'];
    $data['desde'] = $_SESSION['cliente']['desde'];

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
        <?php $opc = "";
        $asd->aside($opc);
        require_once('../admin/layout/header.php');
        ?>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row my-4">

                <div class="col-lg-12 mb-md-0 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-lg-12 col-7">
                                    <h3 class="text-uppercase">Editar cliente</h3>
                                </div>
                            </div>
                            <form class="row g-4" action="" method="post">

                                <div class="col-md-3">
                                    <label for="input" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" value="<?php echo $data['datos']['nombreUsuario']; ?>" required>
                                </div>
                                <div class="col-3">
                                    <label for="input" class="form-label">Apellidos</label>
                                    <input type="text" class="form-control" name="apellidos" value="<?php echo $data['datos']['apellidos']; ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="input" class="form-label">Identificación</label>
                                    <input type="number" class="form-control" name="identificacion" value="<?php echo $data['datos']['identificacion']; ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="input" class="form-label">Correo</label>
                                    <input type="email" class="form-control" name="correo" value="<?php echo $data['datos']['correo']; ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="input" class="form-label">Teléfono</label>
                                    <input type="number" class="form-control" name="telefono" value="<?php echo $data['datos']['telefono']; ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="input" class="form-label">Teléfono secundario</label>
                                    <input type="number" class="form-control" name="telefonoSec" value="<?php echo $data['datos']['telefono_secundario']; ?>">
                                </div>

                                <div class="col-md-3">
                                    <label for="input" class="form-label">Dirección</label>
                                    <input type="text" class="form-control" name="direccion" value="<?php echo $data['datos']['direccion']; ?>" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="input" class="form-label">Inicio de visualizaciones</label>
                                    <input type="date" class="form-control" name="desde" value="<?php echo ($data['desde']); ?>" required>
                                </div>
                                <div class="col-md-1">
                                    <label for="input" class="form-label">Vistas asignadas</label>
                                    <input type="number" class="form-control" name="asignadas" value="<?php print_r($data['vistas']); ?>" required>
                                </div>
                                <?php
                                if ($data['datos']['estadoCuenta'] == 1) {
                                    echo '
                              <div class="col-md-3">
                                <label for="input" class="form-label">Estado de cuenta</label>
                                <select class="form-select" aria-label="Default select example" name="estadoCuenta" required>
                                     <option  value="1" selected>Activa</option>
                                    <option value="0">Inactiva</option>
                                    </select>                            
                                    </div>
                                    ';
                                } else {
                                    echo '
                               <div class="col-md-3">
                                <label for="input" class="form-label">Estado de cuenta</label>
                                <select class="form-select" aria-label="Default select example" name="estadoCuenta" required>
                                     <option  value="1" >Activa</option>
                                    <option value="0" selected>Inactiva</option>
                                    </select>                            
                                 </div>
                                      ';
                                }
                                if ($data['permisos']['impresion'] == 1) {
                                    echo '  <div class="col-md-3">
                                <label for="input" class="form-label">Permitir impresión</label>
                                 <select class="form-select" aria-label="Default select example" name="impresion"  required>
                                      <option value="1" selected>Permitir</option>
                                      <option value="0">No permitir</option>
                                      </select>                              
                                </div>
                                ';
                                } else {
                                    echo '
                                    <div class="col-md-3">
                                    <label for="input" class="form-label">Permitir impresión</label>
                                    <select class="form-select" aria-label="Default select example" name="impresion"  required>
                                        <option value="1" >Permitir</option>
                                        <option value="0" selected>No permitir</option>
                                        </select>                              
                                </div>
                                    ';
                                }
                                if ($data['permisos']['restriccionDeVistas'] == 1) {
                                    echo '  <div class="col-md-3">
                                <label for="input" class="form-label">Restringir vistas</label>
                                 <select class="form-select" aria-label="Default select example" name="restriccionVistas"  required>
                                 <option value="1" selected>Restringir vistas</option>
                                 <option value="0">No restringir vistas</option>
                                      </select>                              
                                </div>
                                ';
                                } else {
                                    echo '
                                    <div class="col-md-3">
                                    <label for="input" class="form-label">Restringir vistas</label>
                                    <select class="form-select" aria-label="Default select example" name="restriccionVistas"  required>
                                        <option value="1">Restringir vistas</option>
                                        <option value="0" selected>No restringir vistas</option>
                                        </select>                              
                                </div>
                                    ';
                                }
                                if ($data['permisos']['cobro'] == 1) {
                                    echo '  <div class="col-md-3">
                                <label for="input" class="form-label">Estado de cobro</label>
                                 <select class="form-select" aria-label="Default select example" name="cobro"  required>
                                 <option value="1" selected>Activo</option>
                                 <option value="0">Inactivo</option>
                                      </select>                              
                                </div>
                                ';
                                } else {
                                    echo '
                                    <div class="col-md-3">
                                    <label for="input" class="form-label">Estado de cobro</label>
                                    <select class="form-select" aria-label="Default select example" name="cobro"  required>
                                    <option value="1" >Activo</option>
                                    <option value="0" selected>Inactivo</option>
                                        </select>                              
                                </div>
                                    ';
                                }
                                ?>
                                <div class="col-12">
                                    <input type="hidden" name="idCliente" value="<?php echo $data['datos']['id_usuario']; ?>">
                                    <button type="submit" name="accion" value="actualizarCliente" class="btn btn-primary">Actualizar datos</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php
    require_once(dirname(__DIR__) . '/admin/layout/footer.php');

    if (isset($_POST['accion']) && $_POST['accion'] == "actualizarCliente") {

        $c = $controller->actualizar($_POST);

        if ($c == 1) {
            unset($_SESSION['cliente']);
            echo "<script>  Swal.fire({
                    icon: 'success',
                    title: 'Genial!😍',
                    text: 'Datos actualizados exitosamente!',
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
                    text: 'No se pudo actualizar el usuario, por favor intentalo nuevamente!',
                     })   </script>";
        }
    };
} else {
    header("location:../../index.php");
}  ?></pre>