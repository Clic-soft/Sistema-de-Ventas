$(document).ready(function() {
    $("#id_cliente").change(function(){
        var id_cliente = $(this).val();
        $("#id_placa").html('');
        comboplaca(id_cliente);
        
    });
});

function comboplaca(id_cliente){

    $.post(_ruta_ + 'ventas/getplacascombo/', {id_cliente : id_cliente} , function (data){
        if (data != "[]"){
            var item = $.parseJSON(data);
            $("#id_placa").append('<option value="">-SELECCIONE-</option>');
                $.each(item, function(i, valor){
                    if (valor.id !== null){
                        $("#id_placa").append('<option value="'+valor.id+'">'+valor.placa+'</option>');
                    }
                });
        }
        return false;
    });  
}
