


    function disableIE() {
        if (document.all) {
            return false;
        }
    }
    function disableNS(e) {
        if (document.layers || (document.getElementById && !document.all)) {
            if (e.which==2 || e.which==3) {
                return false;
            }
        }
    }
    if (document.layers) {
        document.captureEvents(Event.MOUSEDOWN);
        document.onmousedown = disableNS;
    } 
    else {
        document.onmouseup = disableNS;
        document.oncontextmenu = disableIE;
    }
    document.oncontextmenu=new Function("return false"); 
    
     onkeydown = e => {
        let tecla = e.which || e.keyCode;
        
        // Evaluar si se ha presionado la tecla Ctrl:
        if ( e.ctrlKey ) {
          // Evitar el comportamiento por defecto del nevagador:
          e.preventDefault();
          e.stopPropagation();
          
          // Mostrar el resultado de la combinación de las teclas:
          
        }
      }  

  /*     $(document).keydown(function(event) {
    if (event.ctrlKey && event.which !== 61 && event.which !== 107 && event.which !== 109 && event.which !== 187 && event.which !== 189) {
        event.preventDefault();
     }
}); */

    
      $(document).keydown(function (event) { // lee el teclado
        if (event.keyCode == 123) { // si preciona F12
            return false;
        } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // si preciona Ctrl+Shift+I        
            return false;
        }else if(event.ctrlKey  && event.keyCode == 85){ // si preciona Ctr+u
            return false;
        }
    
        });  
    
        $(document).mousedown(function(e) { // lee el mouse
        if (e.which == 3) {
            //alert('Esta opción no está dispuesta, lo sentimos. '); // si preciona el click derecho del mouse
        }
        });
    
        function copyToClipboard() {
            // creamos un elemento input oculto ("hidden")
            var aux = document.createElement("input");
            // asignamos un valor al elemento en el atributo "value"
            aux.setAttribute("value", "Debido a las medidas de seguridad del sistema, no esta permitido realizar impresión de pantalla de esta página.");
            // agregamos el elemento al body de nuestra web
            document.body.appendChild(aux);
            // seleccionamos el contenido (el texto)
            aux.select();
            // copiamos el texto seleccionado
            document.execCommand("copy");
            // removemos el input oculto del body
            document.body.removeChild(aux);
          
        }
       $(window).keyup(function (e) {
            if (e.keyCode == 44) {
                //cuando se detecta la tecla 44 (o sea, print paint) ejecutamos la función copyToClipboard()
                copyToClipboard();
            }
        }); 
