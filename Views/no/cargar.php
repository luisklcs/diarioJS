<script type="text/javascript">
    setTimeout(function() {
        if (window.history.replaceState) {
            console.log("prueba");
            window.history.replaceState(null, null, window.location.href);
        }
    }, 1500);
</script>
<?php
include_once '../Global/Header.php';
if (!isset($_SESSION['Admin'])) {
    header('location:documentos.php');
   ?>
    <script type="text/javascript">
           setTimeout(function() {
  
           location.href="documentos.php";
           }, 0);
           </script>  
  
           <?php 
} else{
include '../recycle/procesarArchivo.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Datos</title>
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  window.OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "0d9df4ff-4eec-4b86-bbd1-966689ff1f2a",
    });
  });
</script>

</head>


<body>
    <br><br><br><br>
  
    <div class="container">

        <div class="col-12">
            <div class="row align-items-center">

                <div class="alert alert-success" role="alert" style="text-align:center ;">
                    <h4 class="alert-heading">Subir archivo</h4>
                </div>
   
                <!-- ===================================== DOCUMENTO ======================================= -->
                <form class="row" action="" method="post" enctype="multipart/form-data">

                    <div class="col-md-12"> <br> </div>
                    <div class="col-md-12">
                        <label for="start">Fecha:</label>
                        <input type="date" name="fecha" step="1" min="2023-01-01" max="2050-12-31" value="<?php date_default_timezone_set('America/Bogota'); echo date("Y-m-d"); ?>" required>
                    </div>
                    <div class="col-md-12"> <br> </div>
                    <div class="col-md-4">
                    <label for="input" class="form-label">Seleccionar archivo</label>
                        <input type="file" name="archivo" required>
                    </div>

                    <div class="col-md-4"> <br><br> <br><br> </div>

                    <div class="row" style="align-items: center; text-align:center">

                        <div class="col">
                            <button name="accion" value="subir" type="submit" class="btn btn-success" style="width: 180px;">Guardar</button>

                            <button name="accion" value="vertodos" type="submit" class="btn btn-warning" onclick="alumnos()">Ver archivos</button>
                        </div>

                        <script type="text/javascript">
                            function alumnos() {
                                setTimeout(function() {
                                    location.href = "docs.php";
                                }, 0);
                            }
                        </script>
                    </div>

                </form>
            </div>
        </div>

    </div>
    </div>


</body>

</html>
<br><br><br><br><br>
<br><br><br><br>
<footer>
  <?php include '../Global/Footer.php'; ?>
</footer>
 <?php }
