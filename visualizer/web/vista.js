$(window).focus(function () {
    //cuando la ventana esta en foco, se muestra su contenido
    $("body").show();
}).blur(function () {
    //cuando se pierde el foto de la ventana, se oculata el contenido (a fin de que si se hace un print screen del contenido con el ventana sin foco, este no sea visible)
    $("body").hide();
});


   