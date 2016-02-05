function facturar(id, idenc){
        var valor = $(this).parent().parent().attr('id');
        var valor2 = $(this).parent().parent().attr('idenc');
        var parent = $(this).parent().parent();

        fancyConfirm("Est&aacute; seguro que desea facturar el registro?",
                function() {
                    var respuesta = $.post(_ruta_ + 'ventas/facturar/'+ id + '/' +idenc);
                    respuesta.done(function(data) {
                        if ($.isEmptyObject(data)) {
                                 window.location.reload();
                        } else {
                            window.location.reload();
                        }
                    });
                },
                function() {
                    return false;
                });
    }