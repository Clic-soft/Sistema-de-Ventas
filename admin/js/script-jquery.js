$(document).ready(function() {
	$(".tabla-carrito").load('inc/carrito.php');
	$(".tabla-carrito-ventas").load('inc/carritoventas.php');
	//Carganos los datos al control select llamado descripción
	$("#categ").change(function () {
		$("#categ option:selected").each(function () {
        	IdC=$(this).val();
        	$("#Producto").empty();
        	$.getJSON("clases/funciones.php",
        	{Accion:'GetProductos',IdC:IdC},
        	function(data){
          		for (i = 0; i < data.length; i++) {
            		$("#Producto").append(new Option(data[i].Descripcion,data[i].IdP));
          		};
        	});
      	});
    });

    //Para ventas

    $("#categoria").change(function () {
		$("#categoria option:selected").each(function () {
        	IdC=$(this).val();
        	$("#Productos").empty();
        	$.getJSON("clases/funciones.php",
        	{Accion:'GetProductos',IdC:IdC},
        	function(data){
        		$("#Productos").append(new Option('Seleccione'));
          		for (i = 0; i < data.length; i++) {
            		$("#Productos").append(new Option(data[i].Descripcion,data[i].IdP));
          		};
        	});
      	});
    });

    $("#Productos").change(function(){
    	$("#Productos option:selected").each(function () {
        	IdP=$(this).val();
        	$("#precio").empty();
        	$.getJSON("clases/funciones.php",
        	{Accion:'GetPrecioStock',IdP:IdP},
        	function(data){
          		for (i = 0; i < data.length; i++) {
            		$("#precio").val(data[i].PVenta);
            		$("#stock").val(data[i].Stock);
          		};
        	});
      	});
    });

    $("#tipoPer").change(function () {
    	$("#tipoPer option:selected").each(function () {
    		var tipo=$(this).val();
    		$("#documento").empty();
	    	if(tipo=="Natural")
	    		$(".documento").text('BOLETA DE VENTA');
	    	else
	    		$(".documento").text('FACTURA');

	    	$("#numero").empty();
        	$.getJSON("clases/funciones.php",
        	{Accion:'GetCorrelativo',tipo:tipo},
        	function(data){
            	$("#numero").val(data.num);
        	});
    	});	
    });

});

/************************************** Mantenimiento de Categorias *****************************************/

function FormEmpresas(IdCategoria){
	$.ajax({
		type:"POST",
		url:"frmweb/frmcategoria.php",
		data:{IdCategoria:IdCategoria},
		success:function(respuesta){
			$("#Modal_Mante_Categoria").html(respuesta);
		},error:function(){
			alert("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE.");
		}
	});
};

function ECategoria(IdTabla,Accion){
	var Accion=Accion;
	$.ajax({
		type:"POST",
		dataType:"json",
		url:'clases/Mantenimiento_Estados.php',
		data:{IdTabla:IdTabla,Accion:Accion},
		success:function(response){
			if(response.respuesta==true){
				window.location.href='categoria.php';
			}else{
				window.location.href='categoria.php';
			}
		},error:function(){
			alert("ERROR GENERAL EN LA APLICACIÓN");
		}

	});
}

/************************************ Mantenimiento de Presentaciones **************************************/
function FormPresentacion(IdPresen){
	$.ajax({
		type:"POST",
		url:"frmweb/frmpresentacion.php",
		data:{IdPresen:IdPresen},
		success:function(respuesta){
			$("#Modal_Mante_Present").html(respuesta);
		},error:function(){
			alert("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE.");
		}
	});
}


/************************************** Mantenimiento de Productos *****************************************/

function FormProducto(IdProducto){
	$.ajax({
		type:"POST",
		url:"frmweb/frmproducto.php",
		data:{IdProducto:IdProducto},
		success:function(respuesta){
			$("#Modal_Mante_Producto").html(respuesta);
		},error:function(){
			alert("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE.");
		}
	});
}

function FormVerFoto(IdProducto){
	$.ajax({
		type:"POST",
		url:"frmweb/frmverfoto.php",
		data:{IdProducto:IdProducto},
		success:function(respuesta){
			$("#Modal_Mante_VerFoto").html(respuesta);
		},error:function(){
			alert("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE.");
		}
	});
}

/************************************ Mantenimiento de Proveedores ***************************************/
function FormProveedores(ruc){
	$.ajax({
		type:"POST",
		url:"frmweb/frmproveedores.php",
		data:{ruc:ruc},
		success:function(respuesta){
			$("#Modal_Mante_Proveedores").html(respuesta);
		},error:function(){
			alert("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE.");
		}
	});
}

function EProveedor(IdTabla,Accion){
	var Accion=Accion;
	$.ajax({
		type:"POST",
		dataType:"json",
		url:'clases/Mantenimiento_Estados.php',
		data:{IdTabla:IdTabla,Accion:Accion},
		success:function(response){
			if(response.respuesta==true){
				window.location.href='proveedores.php';
			}else{
				window.location.href='proveedores.php';
			}
		},error:function(){
			alert("ERROR GENERAL EN LA APLICACIÓN");
		}

	});
}

function FormListadoProveedores(){
	$.ajax({
		type:"POST",
		url:"frmweb/frmlistadoproveedores.php",
		success:function(respuesta){
			$("#Modal_Listado_Proveedores").html(respuesta);
		},error:function(){
			alert("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE.");
		}
	});
}

/************************************** Agregamos proveedores ****************************************/
function AgregarProv(ruc,razon,direccion){
	$('#Modal_Listado_Proveedores').modal('hide');
	document.formComp.ruc.value=ruc;
	document.formComp.razon.value=razon;
	document.formComp.direccion.value=direccion;
}

/**************************************   Carrito de compras  ****************************************/
function AgregarCarrito(){
	var cate=$("#categ").val();
	var IdProd=$("#Producto").val();
	var prodTexto=$("#Producto option:selected").text()
	var precio=$("#precio").val();
	var cant=$("#replyNumber").val();
	if(cate.length>0){
		if(precio.length>0){
			if(cant.length>0){
				$.ajax({
					type:"POST",
					url:"inc/carrito.php",
					data:{IdP:IdProd,prodTexto:prodTexto,precio:precio,cant:cant},
					success:function(respuesta){
						$(".tabla-carrito").html(respuesta);
					},error:function(){
						alert("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE.");
					}
				});
			}else{
				$(".mensajeError").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert'>&times;</button><i class='glyphicon glyphicon-remove'></i>&nbsp; Ingrese cantidad</div>");
			}
		}else{
			$(".mensajeError").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert'>&times;</button><i class='glyphicon glyphicon-remove'></i>&nbsp; Ingrese precio de compra</div>");
		}
	}else{
		$(".mensajeError").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert'>&times;</button><i class='glyphicon glyphicon-remove'></i>&nbsp; Seleccione una categoría</div>");
		//$(".mensajeError").fadeOut(3000);
	}	
}
/*
$(document).ready(function(){
    setTimeout(function(){ 
        $("#clima").load("includes/clima.php"); 
    }, 5000);
});
*/
function Agregarmas(codigo,action){
	$.ajax({
		type:"POST",
		url:"inc/carrito.php",
		data:{IdProd:codigo,action:action},
		success:function(respuesta){
			$(".tabla-carrito").html(respuesta);
		},error:function(){
			alert("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE.");
		}
	});
}
function Quitarmenos(codigo,action){
	$.ajax({
		type:"POST",
		url:"inc/carrito.php",
		data:{IdProd:codigo,action:action},
		success:function(respuesta){
			$(".tabla-carrito").html(respuesta);
		},error:function(){
			alert("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE.");
		}
	});
}
function Eliminar(codigo,action){
	$.ajax({
		type:"POST",
		url:"inc/carrito.php",
		data:{IdProd:codigo,action:action},
		success:function(respuesta){
			$(".tabla-carrito").html(respuesta);
		},error:function(){
			alert("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE.");
		}
	});
}

/**************************************   Manten. Clientes  ****************************************/

function FormClientes(dni){
	$.ajax({
		type:"POST",
		url:"frmweb/frmclientes.php",
		data:{dni:dni},
		success:function(respuesta){
			$("#Modal_Mante_Clientes").html(respuesta);
		},error:function(){
			alert("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE.");
		}
	});
}

function FormListadoClientes(){
	$.ajax({
		type:"POST",
		url:"frmweb/frmlistadoclientes.php",
		success:function(respuesta){
			$("#Modal_Listado_Clientes").html(respuesta);
		},error:function(){
			alert("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE.");
		}
	});
}

/************************************** Agregamos clientes ****************************************/
function AgregarClie(ruc,nombre,direccion){
	$('#Modal_Listado_Clientes').modal('hide');
	document.formVent.ruc.value=ruc;
	document.formVent.nombre.value=nombre;
	document.formVent.direccion.value=direccion;
}

function AgregCarritoVenta(){
	var cate=$("#categoria").val();
	var IdProd=$("#Productos").val();
	var prodTexto=$("#Productos option:selected").text();
	var precio=$("#precio").val();
	var stock=$("#stock").val();
	var cant=$("#replyNumber").val();
	if(cate.length>0){
		if(precio.length>0){/*
			if(stock>=cant){*/
				$.ajax({
					type:"POST",
					url:"inc/carritoventas.php",
					data:{IdP:IdProd,prodTexto:prodTexto,precio:precio,cant:cant},
					success:function(respuesta){
						$(".tabla-carrito-ventas").html(respuesta);
					},error:function(){
						alert("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE.");
					}
				});/*
			}else{
				$(".mensajeError").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert'>&times;</button><i class='glyphicon glyphicon-remove'></i>&nbsp; Stock insuficiente, por favor verifique.</div>");
			}*/
		}else{
			$(".mensajeError").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert'>&times;</button><i class='glyphicon glyphicon-remove'></i>&nbsp; Seleccione un producto</div>");
		}
	}else{
		$(".mensajeError").html("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert'>&times;</button><i class='glyphicon glyphicon-remove'></i>&nbsp; Seleccione una categoría</div>");
		//$(".mensajeError").fadeOut(3000);
	}	
}

function AgregarVentas(codigo,action){
	$.ajax({
		type:"POST",
		url:"inc/carritoventas.php",
		data:{IdProd:codigo,action:action},
		success:function(respuesta){
			$(".tabla-carrito-ventas").html(respuesta);
		},error:function(){
			alert("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE.");
		}
	});
}
function QuitarVentas(codigo,action){
	$.ajax({
		type:"POST",
		url:"inc/carritoventas.php",
		data:{IdProd:codigo,action:action},
		success:function(respuesta){
			$(".tabla-carrito-ventas").html(respuesta);
		},error:function(){
			alert("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE.");
		}
	});
}
function EliminarVentas(codigo,action){
	$.ajax({
		type:"POST",
		url:"inc/carritoventas.php",
		data:{IdProd:codigo,action:action},
		success:function(respuesta){
			$(".tabla-carrito-ventas").html(respuesta);
		},error:function(){
			alert("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE.");
		}
	});
}


/******************************************************************************/
function EUsuario(IdTabla,Accion){
	var Accion=Accion;
	$.ajax({
		type:"POST",
		dataType:"json",
		url:'clases/Mantenimiento_Estados.php',
		data:{IdTabla:IdTabla,Accion:Accion},
		success:function(response){
			if(response.respuesta==true){
				window.location.href='usuarios.php';
			}else{
				window.location.href='usuarios.php';
			}
		},error:function(){
			alert("ERROR GENERAL EN LA APLICACIÓN");
		}

	});
}

function FormUsuarios(){
	$.ajax({
		type:"POST",
		url:"frmweb/frmusuarios.php",
		success:function(respuesta){
			$("#Modal_Mante_Usuarios").html(respuesta);
		},error:function(){
			alert("ERROR GENERAL DEL SISTEMA, POR FAVOR INTENTE MÁS TARDE.");
		}
	});


function activeClass(){
	$("li").addClass("active");
}
}