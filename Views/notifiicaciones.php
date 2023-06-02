<?php

include 'global/links.php';
if (isset($_SESSION['user']) && $_SESSION['user']['rol'] == 2 ) {
    include 'aside_cliente.php';
    $asd = new Aside();
   
require_once(dirname(__DIR__) . '/Controller/documentosController.php');
#$dir = dirname(__DIR__) . '\Controller\documentosController.php';
$documentos = new DocumentosController();
$cantidadDocumentos = $documentos->contar();

$pagActual = isset($_GET['pag']) ? $_GET['pag'] : 1;
$limite = 10;
$inicio = ($pagActual - 1) * $limite;
$total_paginas = ceil($cantidadDocumentos / $limite);

$lista = $documentos->listar($inicio,$limite);

#



?>
<body class="g-sidenav-show  bg-gray-100">
    <?php  $opc = "notificaciones";
    $asd->aside($opc);
    require_once 'global/header.php';
} else {
    header("location:../../index.php");
}   ?>






                
    
    

</footer>
</div>


<?php
require_once 'global/footer.php';
?>