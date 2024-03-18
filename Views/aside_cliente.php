<?php


class Aside
{

    public function aside($var)
    {
       
        $noti = "";
        $verD = "";
        $estadoC = "";

        switch ($var) {
            case 'notificaciones':
                $noti = "active";
                break;
            case 'documentos':
                $verD = "active";
                break;
            case 'estadodecuenta':
                $estadoC = "active";
                break;
            
            default:
                # code...
                break;
        }

?>



        <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
            <div class="sidenav-header">
                <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
                <a class="navbar-brand m-0">
                    <img src="assets/img/icon.png" class="navbar-brand-img h-100" alt="main_logo">
                    <span class="ms-1 font-weight-bold">Estados judiciales Sincelejo</span>
                </a>
            </div>


            <hr class="horizontal dark mt-0">
            <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
                <ul class="navbar-nav">



                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Documentos</h6>
                    </li>




                    <li class="nav-item">
                        <a class="nav-link <?php echo $verD ?> " href="documentos.php">
                            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <img src="assets/icons/file-invoice-solid.svg" alt="">
                            </div>
                            <span class="nav-link-text ms-1">Ver Documentos</span>
                        </a>
                    </li>




                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Cuenta</h6>
                    </li>

                  <!--   <li class="nav-item">
                        <a class="nav-link <?php echo $noti ?> " href="notifiicaciones.php">
                            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <img src="assets/icons/bell-solid.svg" alt="">
                            </div>
                            <span class="nav-link-text ms-1">Notificaciones</span>
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo  $estadoC ?> " href="micuenta.php">
                            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <img src="assets/icons/business-time-solid.svg" alt="">
                            </div>
                            <span class="nav-link-text ms-1">Estado de cuenta</span>
                        </a>
                    </li>

                    


                    <li class="nav-item">
                        <a class="nav-link  " href="admin/cerrarSesion.php">
                            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <img src="assets/icons/arrow-right-from-bracket-solid.svg" alt="">
                            </div>
                            <span class="nav-link-text ms-1">Cerrar sesión</span>
                        </a>
                    </li>

                </ul>
            </div>

        </aside>

<?php
    }
}









?>