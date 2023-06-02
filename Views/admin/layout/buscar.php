<form action="" class="ms-md-auto pe-md-3 d-flex align-items-center" method="POST">
                        <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                            <span class="d-sm-inline d-none ">Buscar por fecha</span>
                        </div>

                        <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                            <div class="input-group">
                                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                                <input type="date" class="form-control" name="fechaBusqueda" value="<?php echo date("Y-m-d") ?>">
                            </div>
                        </div>
                        <li class="nav-item d-flex align-items-center">
                            <button type="submit" name="accion" value="buscar" class="btn btn-outline-primary btn-sm mb-0 me-3" onclick="limpiar()">Buscar</button>

                        </li>
                        <?php
                    if (isset($_SESSION['resultado'])) {
                    ?>
                    <li class="nav-item d-flex align-items-center">
                            <button type="button" class="btn btn-info" onclick="limpiar()">Limpiar</button>

                        </li>
                            <script type="text/javascript">
                                function limpiar() {
                                    window.location.reload()
                                }
                                </script>
                         <?php
                    }   ?>