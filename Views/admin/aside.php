<?php
class Aside
{

    public function aside($var)
    {
        $home = "";
        $verc = "";
        $agD  = "";
        $verD = "";
        $regc = "";

        switch ($var) {
            case 'clientes':
                $verc = "active";
                break;
            case 'documentos':
                $verD = "active";
                break;
            case 'agp':
                $agp = "active";
                break;
            case 'verp':
                $verp = "active";
                break;
            case 'registrar':
                $regc = "active";
                break;
            case 'home':
                $home = "active";
                break;
            case 'agregardocumento':
                $agD = "active";
                break;
            case 'notificar':
                $noti = "active";
                break;
         
        
        }
     
?>
        <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
            <div class="sidenav-header">
                <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
                <a class="navbar-brand m-0">
                    <img src="../assets/img/icon.png" class="navbar-brand-img h-100" alt="main_logo">
                    <span class="ms-1 font-weight-bold">Notificaciones Judiciales</span>
                </a>
            </div>
            <hr class="horizontal dark mt-0">
            <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link  <?php echo $home; ?>" href="index.php">
                            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                    <path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
                                </svg>
                            </div>
                            <span class="nav-link-text ms-1">Inicio</span>
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">CLIENTES</h6>
                    </li>
                    

                    <li class="nav-item">
                        <a class="nav-link <?php echo $verc; ?> " href="clientes.php">
                            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <img src="../assets/icons/users-solid.svg" alt="">
                            </div>
                            <span class="nav-link-text ms-1">Ver clientes</span>
                        </a>
                    </li>
                   
                    <li class="nav-item">
                        <a class="nav-link <?php echo $regc ;?>" href="registrar.php">
                            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <img src="../assets/icons/user-plus-solid.svg" alt="">
                            </div>
                            <span class="nav-link-text ms-1">Registrar cliente</span>
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Documentos</h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $verD; ?> " href="documentos.php">
                            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <img src="../assets/icons/file-invoice-solid.svg" alt="">
                            </div>
                            <span class="nav-link-text ms-1">Ver Documentos</span>
                        </a>
                    </li>

                    <li class="nav-item" >
                        <a class="nav-link <?php echo $agD; ?> " href="cargardocumento.php">
                            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <img src="../assets/icons/file-import-solid.svg" alt="">
                            </div>
                            <span class="nav-link-text ms-1">Agregar Documento</span>
                        </a>
                    </li>
                    

<!-- 
                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Notificaciones</h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php #echo $noti?> " href="notificar.php">
                            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <img src="../assets/icons/bell-solid.svg" alt="">
                            </div>
                            <span class="nav-link-text ms-1">Notificar usuario</span>
                        </a>
                    </li> -->
                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Cuenta</h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  " href="cerrarSesion.php">
                            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                <svg width="12px" height="12px" viewBox="0 0 46 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <title>customer-support</title>
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(-1717.000000, -291.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                            <g transform="translate(1716.000000, 291.000000)">
                                                <g transform="translate(1.000000, 0.000000)">
                                                    <path class="color-background opacity-6" d="M45,0 L26,0 C25.447,0 25,0.447 25,1 L25,20 C25,20.379 25.214,20.725 25.553,20.895 C25.694,20.965 25.848,21 26,21 C26.212,21 26.424,20.933 26.6,20.8 L34.333,15 L45,15 C45.553,15 46,14.553 46,14 L46,1 C46,0.447 45.553,0 45,0 Z"></path>
                                                    <path class="color-background" d="M22.883,32.86 C20.761,32.012 17.324,31 13,31 C8.676,31 5.239,32.012 3.116,32.86 C1.224,33.619 0,35.438 0,37.494 L0,41 C0,41.553 0.447,42 1,42 L25,42 C25.553,42 26,41.553 26,41 L26,37.494 C26,35.438 24.776,33.619 22.883,32.86 Z"></path>
                                                    <path class="color-background" d="M13,28 C17.432,28 21,22.529 21,18 C21,13.589 17.411,10 13,10 C8.589,10 5,13.589 5,18 C5,22.529 8.568,28 13,28 Z"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span class="nav-link-text ms-1">Cerrar sesión</span>
                        </a>
                    </li>

                </ul>
            </div>

        </aside>

<?php
    }
}?>