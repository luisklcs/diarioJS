<?php

#echo "limpiar";
// Función para limpiar un dato individual
function limpiarDato($dato)
{
    $dato = strip_tags($dato);
    $dato = htmlspecialchars($dato, ENT_QUOTES, 'UTF-8');
    $dato = addslashes($dato);
    return $dato;
}

// Función para limpiar un arreglo de datos
function limpiarArreglo($arreglo)
{
    foreach ($arreglo as $key => $value) {
        $arreglo[$key] = limpiarDato($value);
    }
    return $arreglo;
}

function limpiarDatosPost($datosAlimpiar)
{
    foreach ($datosAlimpiar as $key => $value) {
        if (is_array($value)) {
            // Si el valor es un arreglo, aplicar limpieza a cada elemento del arreglo
            $datosAlimpiar[$key] = limpiarArreglo($value);
        } else {
            // Si el valor es un string, aplicar limpieza directamente
            $datosAlimpiar[$key] = limpiarDato($value);
        }
    }
    return $datosAlimpiar;
}



?>