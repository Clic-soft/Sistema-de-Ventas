$(document).ready(function() {

    $(".ventanaabono").fancybox({
        'showCloseButton': true,
        'width': 800,
        'height': 500,
        'autoSize': false,
        'autoDimensions': false,
        'transitionIn': 'none',
        'transitionOut': 'none',
        'type': 'iframe',
        'beforeClose': function() {
            window.location.reload();
        }

    });
   
	
});

function borrar_abono(id){
        var valor = $(this).parent().parent().attr('id');
        var parent = $(this).parent().parent();

        fancyConfirm("Est&aacute; seguro que desea eliminar el registro?",
                function() {
                    var respuesta = $.post(_ruta_ + 'ventas/eliminarabono/'+ id);
                    respuesta.done(function(data) {
                        if ($.isEmptyObject(data)) {
                                 window.location.reload();
                        } else {
                            fancyAlert('Error eliminando el registro tiene datos asociados.');
                        }
                    });
                },
                function() {
                    return false;
                });
    }