<?php session_start(); ?>
<?php if(isset($_SESSION["Usuario"])):?>
<?php require_once 'clases/clsProducto.php'; 
	$objPro=new Producto();
	$fila=$objPro->get_Productos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Tienda - Productos</title>
	<?php require_once 'inc/header.php'; ?>
</head>
<body>
	<?php require_once 'inc/menu-l.php'; ?>
	<script type="text/javascript">
			$("#productos").addClass("active");					
	</script>
	<div class="container-fluid col-md-10 col-md-offset-2">
		<div class="row">
			<div>
				<div class="col-xs-12 col-sm-12 col-sm-12 col-lg-12">
					<div class="space"></div>
					<div class="navbar navbar-default">
						<div class="navbar-inner contenido-button">

							<button type="button" onclick="FormProducto();" 
							class="btn btn-small btn-default" data-toggle='modal' 
							data-target='#Modal_Mante_Producto'>
								<i class="glyphicon glyphicon-plus"></i> Nuevo Producto
							</button>

							<div class='modal fade' id='Modal_Mante_Producto' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
							</div>
							<div class='modal fade' id='Modal_Mante_VerFoto' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
							</div>
							<a href="productos.php" class="link-actualizar pull-right">
								<i class='glyphicon glyphicon-refresh'></i> Actualizar
							</a>

						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-sm-12 col-lg-12">
					<div class="mensaje">
						<?php 
							//date_default_timezone_set('America/Bogota');
							//$date =strtotime(str_replace('/', '-', $_POST['fecha']));
							//echo date('Y-m-d h:m:s A',$date);
							/*$newfecha=explode('/', $_POST['fecha']);
							$year=substr($newfecha[2],0,4);
							$mes=$newfecha[1];
							$dia=$newfecha[0];
							$hora=substr($newfecha[2],5,11);
							$fecha=$year.'-'.$mes.'-'.$dia.' '.$hora;*/

							if(!empty($_FILES['Imagen']['tmp_name'])):
								$ruta_temporal=$_FILES['Imagen']['tmp_name'];
								$nombre_imagen=md5(mktime().$_FILES['Imagen']['name']);
								$ruta_destino=$nombre_imagen.".jpg";
							endif;

							if(isset($_POST['btnReg'])):
								if(move_uploaded_file($ruta_temporal,"uploads/".$ruta_destino)):
				
									$objPro->producto=$_POST['producto'];
									$objPro->unidad_medida=$_POST['unidad_medida'];
									$objPro->precio=$_POST['precio'];
									$objPro->RutaImagen=$ruta_destino;
									$Mensaje=$objPro->Add_Productos();
									if($Mensaje=="Registrado correctamente."):?>
										<div class='alert alert-success' role='alert'>
											<button type='button' class='close' data-dismiss='alert'>&times;</button>
											<i class='glyphicon glyphicon-ok'></i>&nbsp;<?=$Mensaje;?>
										</div>
							  		<?php 
							  		else: ?>
										<div class='alert alert-danger' role='alert'>
											<button type='button' class='close' data-dismiss='alert'>&times;</button>
											<i class='glyphicon glyphicon-remove'></i>&nbsp;<?=$Mensaje;?>
										</div>
							  		<?php 
							  		endif;
								endif;
							endif;

							if(isset($_POST['btnAct'])):
								if(move_uploaded_file($ruta_temporal,"uploads/".$ruta_destino)):
				                	$ruta_destino=$ruta_destino;
				                	if($_POST['ruta']!=$ruta_destino):
				                		!empty($_POST['ruta']) ? unlink("uploads/".$_POST['ruta']):'';
				                	endif;
				                else:
				                	$ruta_destino="";
				                endif;
								$objPro->id=$_POST['id'];
								$objPro->producto=$_POST['producto'];
								$objPro->unidad_medida=$_POST['unidad_medida'];
								$objPro->precio=$_POST['precio'];
								$objPro->RutaImagen=$ruta_destino;
								$Mensaje=$objPro->Update_Productos();
								if($Mensaje=="El registro se ha actualizado correctamente."):?>
									<div class='alert alert-success' role='alert'>
										<button type='button' class='close' data-dismiss='alert'>&times;</button>
										<i class='glyphicon glyphicon-ok'></i>&nbsp;<?=$Mensaje;?>
									</div>
						  		<?php 
						  		else: ?>
									<div class='alert alert-danger' role='alert'>
										<button type='button' class='close' data-dismiss='alert'>&times;</button>
										<i class='glyphicon glyphicon-remove'></i>&nbsp;<?=$Mensaje;?>
									</div>
						  		<?php 
						  		endif;
							endif;
						?>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<!--<div class="table-responsive hidden-md">-->
					<table class='table  table-bordered table-hover table-condensed' id="Tabla-Categoria">
						<thead class="alert alert-info text-head">
							<tr>
								<th class="text-center">Producto</th>
								<th class="text-center">Unid. Medida</th>
								<th class="text-center">P. Venta</th>
								<th class="text-center">Opciones</th>
							</tr>
						</thead>
						<tbody>
							<?php if(!empty($fila)): ?>
							<?php $cant=0; ?>
							<?php foreach ($fila as $item):?>
							<?php $cant++; ?>
							<tr>
								<td class="text-center"><?=$item[2]?></td>
								<td class="text-center"><?=$item[6]?></td>
								<td><?=$item[3]?></td>
								<td>
									<center>

										<span title="Actualizar Información" class="btn btn-xs btn-info" 
											onclick="FormProducto('<?=$item[0]?>');" data-toggle='modal' 
											data-target='#Modal_Mante_Producto' id="tooltip<?=$item[0]?>" data-toggle="tooltip"
											data-placement="top">
											<i class="glyphicon glyphicon-edit"></i>
										</span>
										<span title="Ver foto" class="btn btn-xs btn-warning" 
											onclick="FormVerFoto('<?=$item[0]?>');" data-toggle='modal' 
											data-target='#Modal_Mante_VerFoto' id="tool<?=$item[0]?>" data-toggle="tooltip"
											data-placement="top">
											<i class="glyphicon glyphicon-picture"></i>
										</span>
										<span title="Eliminar" class="btn btn-xs btn-danger" 
											onclick="FormVerFoto('<?=$item[0]?>');" id="tool<?=$item[0]?>" data-toggle="tooltip"
											data-placement="top">
											<i class="glyphicon glyphicon-trash"></i>
										</span>

									</center>
								</td>
							</tr>
							<script>
								$(document).ready(function(){
									$("#tooltip<?=$item[1]?>").tooltip({
										placement : 'top'
									});
									$("#tool<?=$item[1]?>").tooltip({
										placement : 'top'
									});
								});
							</script>
							<?php
								endforeach; 
							endif;
							?>
							
						</tbody>
					</table>
				<!--</div>-->
				</div>
			</div>
		</div>
	</div>

	<?php require_once 'inc/footer.php'; ?>
</body>
</html>
<?php 
else:
	header( 'Location: ../' );
endif;
?>