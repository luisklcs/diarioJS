<?php

$dash = '  <div class="row">
<div class="col-xl-3 col-md-6">
    <div class="card bg-primary text-white mb-4">
        <div class="card-body">Usuarios registrados</div>
        <div class="card-footer d-flex align-items-center justify-content-between">
           <strong> <b>  <?php echo $numUsuarios ?></b></strong>
          <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6">
    <div class="card bg-warning text-white mb-4">
        <div class="card-body">Documentos cargados</div>
        <div class="card-footer d-flex align-items-center justify-content-between">
        <strong> <b>  <?php echo $numDocumentos ?></b></strong>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6">
    <div class="card bg-success text-white mb-4">
        <div class="card-body">Cuentas activas</div>
        <div class="card-footer d-flex align-items-center justify-content-between">
        <strong> <b>  <?php echo $cuentasActivas ?></b></strong>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6">
    <div class="card bg-danger text-white mb-4">
        <div class="card-body">Cuentas suspendidas</div>
        <div class="card-footer d-flex align-items-center justify-content-between">
        <strong> <b>  <?php echo $cuentasInactivas ?></b></strong>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div>
</div>';

?>