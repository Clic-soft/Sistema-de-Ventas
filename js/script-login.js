$(function(){
	$("#iniciar").click(function(){
		var usuario=$("#email").val();
		var pass=$("#pass").val();
		var recordar=$("#recordar").val();
		if(usuario.length>0){
			if(pass.length>0){
				$.ajax({
					type:"POST",
					dataType:"json",
					url:"admin/inc/loginuser.php",
					data:{usuario:usuario,pass:pass,recordar:recordar},
					success:function(response){
						if(response.respuesta==false){
							$("#mensaje").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert'>&times;</button><i class='glyphicon glyphicon-remove'></i>&nbsp;"+response.mensaje+"</div>");	
						}else{
							$("#mensaje").html("<div class='alert alert-success'><i class='glyphicon glyphicon-ok'></i>&nbsp; "+response.mensaje+"</div>");
							window.location = "admin/";
						}
					},error:function(){
						$("#mensaje").html("<div class='alert alert-danger'><i class='glyphicon glyphicon-remove'></i>&nbsp; ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE</div>");
					}
				});
			}else{
				$("#mensaje").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert'>&times;</button><i class='glyphicon glyphicon-remove'></i>&nbsp; Ingrese su contraseña</div>");
			}
		}else{
			$("#mensaje").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert'>&times;</button><i class='glyphicon glyphicon-remove'></i>&nbsp; Ingrese su email o celular</div>");
		}
		
	});
});