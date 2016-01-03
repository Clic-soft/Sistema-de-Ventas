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
	<?php require_once 'inc/navbar.php'; ?>

	<div class="container-fluid top-container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
				<?php require_once 'inc/menu.php'; ?>
			</div>
			<div class="content">
				<div class="col-xs-12 col-sm-12 col-sm-12 col-lg-12">
					<div class="navbar navbar-default">
						<div class="navbar-inner contenido-button">
							<?php if($_SESSION['Tipo']=='Administrador'):?>
							<button type="button" onclick="FormProducto();" 
							class="btn btn-small btn-default" data-toggle='modal' 
							data-target='#Modal_Mante_Producto'>
								<i class="glyphicon glyphicon-plus"></i> Nuevo Producto
							</button>
							<?php else: ?>
							<button type="button" class="btn btn-small btn-default">
								<i class="glyphicon glyphicon-plus"></i> Nuevo Producto
							</button>
							<?php endif; ?>
							<div class='modal fade' id='Modal_Mante_Producto' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
							</div>
							<div class='modal fade' id='Modal_Mante_VerFoto' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
							</div>
							<a href="<?= ($_SESSION['Tipo']=='Administrador') ? "productos":"#";?>" class="link-actualizar pull-right">
								<?= ($_SESSION['Tipo']=='Administrador') ? "<i class='glyphicon glyphicon-refresh'></i> Actualizar":"Usted no tiene permisos";?>
							</a>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-sm-12 col-lg-12">
					<div class="mensaje">
						<?php 
							//date_default_timezone_set('America/Lima');
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
									$objPro->IdC=$_POST['categoria'];
									$objPro->IdPre=$_POST['presentacion'];
									$objPro->descripcion=$_POST['producto'];
									$objPro->UnidMedida=$_POST['UnidMedida'];
									$objPro->PrecioVenta=$_POST['PVenta'];
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
								$objPro->IdProd=$_POST['IdProd'];
								$objPro->IdC=$_POST['categoria'];
								$objPro->IdPre=$_POST['presentacion'];
								$objPro->descripcion=$_POST['producto'];
								$objPro->UnidMedida=$_POST['UnidMedida'];
								$objPro->PrecioVenta=$_POST['PVenta'];
								$objPro->stock=$_POST['stock'];
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
								<th class="text-center">Categoria</th>
								<th>Producto</th>
								<th>Presentación</th>
								<th>Unid. Medida</th>
								<th>P. Venta</th>
								<th>Stock</th>
								<th class="text-center">Estado</th>
								<th class="text-center">Opciones</th>
							</tr>
						</thead>
						<tbody>
							<?php if(!empty($fila)): ?>
							<?php $cant=0; ?>
							<?php foreach ($fila as $item):?>
							<?php $cant++; ?>
							<tr>
								<td class="text-center"><?=$item[0]?></td>
								<td><?=$item[4]?></td>
								<td><?=$item[10]?></td>
								<td class="text-center"><?=$item[5]?></td>
								<td class="text-center">S/. <?=$item[6]?></td>
								<td class="text-center">
									<?php 
									if($item[7]<10):?>
									<span class="badge alert-danger badge-red"><?=$item[7]?></span>
									<?php else: ?>
									<span class="badge alert-success badge-green"><?=$item[7]?></span>
									<?php endif;
									?>
								</td>
								<td class="text-center">
									<span class="<?= ($item[9]=='Activo') ? "label label-success":"label label-danger";?>" 
										style="<?= ($_SESSION['Tipo']=='Administrador') ? "cursor:pointer;":"";?>font-size:13px; font-weight:normal"><?= $item['Estado']?>
									</span>
								</td>
								<td>
									<center>
										<?php if($_SESSION['Tipo']=='Administrador'):?>
										<span title="Actualizar Información" class="btn btn-xs btn-info" 
											onclick="FormProducto('<?=$item[1]?>');" data-toggle='modal' 
											data-target='#Modal_Mante_Producto' id="tooltip<?=$item[1]?>" data-toggle="tooltip"
											data-placement="top">
											<i class="glyphicon glyphicon-edit"></i>
										</span>
										<span title="Ver foto" class="btn btn-xs btn-warning" 
											onclick="FormVerFoto('<?=$item[1]?>');" data-toggle='modal' 
											data-target='#Modal_Mante_VerFoto' id="tool<?=$item[1]?>" data-toggle="tooltip"
											data-placement="top">
											<i class="glyphicon glyphicon-picture"></i>
										</span>
										<?php else: ?>
										<span class="btn btn-xs btn-info">
											<i class="glyphicon glyphicon-edit"></i>
										</span>
										<span class="btn btn-xs btn-warning">
											<i class="glyphicon glyphicon-picture"></i>
										</span>
										<?php endif; ?>
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