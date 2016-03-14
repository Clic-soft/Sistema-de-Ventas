$(document).ready(function() {
    $("#id_depto").change(function(){
        var id_depto = $(this).val();
        combociudad(id_depto);       
    });
    
});

function combociudad(id_depto){
    $("#id_ciudad").html('');
    $.post(_ruta_ + 'clientes/getciudadcombo/', {id_depto : id_depto} , function (data){
        if (data != "[]"){
            var item = $.parseJSON(data);
            $("#id_ciudad").html('');
            $("#id_ciudad").append('<option value="0">-SELECCIONE-</option>');
                $.each(item, function(i, valor){
                    if (valor.ciudad !== null){
                        $("#id_ciudad").append('<option value="'+valor.id+'">'+valor.ciudad+'</option>');
                    }
                });
        }
        return false;
    });  
}
