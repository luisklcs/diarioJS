<?php

require_once('../admin/layout/links.php');

if (isset($_SESSION['user']) && $_SESSION['user']['rol'] == 1 ) {

require_once('../../Controller/clientesController.php');
$controller = new clientesController();



include 'aside.php';
$asd = new Aside();
?>

<link rel="icon" href="../assets/img/icon.png" type="image/png">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body class="g-sidenav-show  bg-gray-100">
    <?php $opc = "notificar";
    $asd->aside($opc);
    
    require_once('../admin/layout/header.php');
    



    require_once('../admin/layout/footer.php');
} else {
    header("location:../../index.php");
} ?>


