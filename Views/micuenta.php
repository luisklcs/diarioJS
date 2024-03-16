<?php
include 'global/links.php';



if (isset($_SESSION['user']) && $_SESSION['user']['rol'] == 2) {

  date_default_timezone_set('America/Bogota');


  require_once('/Controller/clientesController.php');
  $controller = new clientesController();

  $data = $controller->infoCuentaCliente($_SESSION['user']['id_usuario']);
  if ($data['estadoCuenta'] == 1) {
    $estado = "Activa";
  } else {
    $estado = "Suspendida";
  }


  include 'aside_cliente.php';
  $asd = new Aside();
  $opc = "estadodecuenta";
  $asd->aside($opc);
  require_once 'global/header.php';

  $fechaCobro = date_create($data['f_cobro']);
  # $fechaCobro = date_create("15-07-2023");
  $fechaActual = date_create(date("Y-m-d"));
  $intervalo = $fechaActual->diff($fechaCobro);
  $dias = $intervalo->format('%a');

  $porc = ($dias * 100) / 28;


  if ($porc >= 60.0) {
    $color = "bg-success";
  } elseif ($porc > 20.0 && $porc < 60.0) {
    $color = "bg-warning";
  } else {
    $color = "bg-danger";
  }

?>

  <body class="g-sidenav-show  bg-gray-100">
    <script>
      var newTitle = "Estado de cuenta | Diario Judicial de sincelejo";
      document.title = newTitle;
    </script>

    <div class="container-fluid">
      <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
        <span class="mask bg-gradient-info opacity-6"></span>
        <span style="text-align: center; width: 100%;">
          <h2 class="align-items-center text-uppercase" style="color:aliceblue;">Información de la cuenta</h2>
        </span>
      </div>
      <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
        <div class="row gx-4">
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
              <img src="assets/img/user.jpeg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
                <?php echo $data['nombreUsuario']; ?>
              </h5>
              <p class="mb-0 font-weight-bold text-sm">
                <?php echo $data['apellidos']; ?>
              </p>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="col-12 col-xl-12  mt-4">
      <div class="card">
        <div class="card-header pb-0 p-3">
          <div class="row">
            <div class="col d-flex align-items-center">
              <h5 class="mb-0">Información del perfil</h5>
            </div>
          </div>
        </div>
        <div class="card-body p-3">

          <?php  #print_r($porc); 
          ?>

          <ul class="list-group">
            <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Nombre:</strong> &nbsp; <?php echo $data['nombreUsuario'] . " " . $data['apellidos']; ?></li>
            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">N° Identificación:</strong> &nbsp; <?php echo $data['identificacion']; ?></li>
            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Teléfono:</strong> &nbsp; <?php echo $data['telefono']; ?></li>
            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Teléfono 2:</strong> &nbsp; <?php echo $data['telefono_secundario']; ?></li>
            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Correo:</strong> &nbsp; <?php echo $data['correo']; ?></li>
            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Dirección:</strong> &nbsp; <?php echo $data['direccion']; ?></li>
            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Estado de cuenta:</strong> &nbsp; <?php echo $estado; ?></li>
            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Días restantes:</strong> &nbsp; <?php echo $dias; ?></li>
            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Fecha de suspensión:</strong> &nbsp;<?php echo $data['f_cobro']; ?></li>
          </ul>
          <br>

          <div class="row container-fluid">
            <div class="col-9">
              <div class="col">
                <p>Dias restantes <strong><?php echo $dias ?></strong></p>
              </div>
            </div>

            <div class="col">
              <div class="col">
                <p style="text-align: right;">Días periodo: <strong>30</strong></p>
              </div>
            </div>
          </div>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo $color; ?>" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: <?php print_r($porc . "%") ?>"></div>
          </div>
        </div>
      </div>
    </div>

  <?php
  require_once 'global/footer.php';
} else {
  header("location:../../index.php");
}  ?>