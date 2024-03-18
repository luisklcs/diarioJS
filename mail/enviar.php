<?php

include_once 'Mail.php';


class enviarMail
{

    public function enviar($email, $name)
    {
        $cc = 'correo asociado al CC';  //Correo CC para copia del cuerpo enviado     
        $suj = 'Nuevo documento agregado';
        $data = $this->prepare_mail($name);
        $resp = sent_mail($email, $cc, $suj, $data);
       
        if ($resp == 'OK') {
            return true;
        } else {
            return "error".$resp;
        }
    }
    public function prepare_mail($name)
    {


        $data = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Notificación de carga de archivo</title>
        </head>
        <body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
        
            <div style="background-color: #ffffff; max-width: 600px; margin: 0 auto; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                <h2 style="color: #333333;">Nuevo archivo agregado</h2>
                <p style="color: #666666;">Hola, '.$name.' ya se encuentra disponible el archivo con la información judicial del día de hoy. Puedes acceder al sitio web para ver más detalles.</p>
                
            
                <a href="https://fabiolavillalba.info/Views/documentos.php" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 5px;">Ver documento</a>
            </div>
        
        </body>
        </html>
         ';
        return $data;
    }
}
