<?php session_start(); ?>
<?php if(isset($_SESSION["Usuario"])):?>
<?php require_once 'clases/clsVentas.php'; 
$objVentas=new Ventas();
$item=$objVentas->getVentas();


?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Sistema - Compras</title>
	<?php require_once 'inc/header.php'; ?>
</head>
<body>
	<?php require_once 'inc/menu-l.php'; ?>
		<script type="text/javascript">
			$("#ventas").addClass("active");					
		</script>
	<div class="container-fluid col-md-10 col-md-offset-2">
		<div class="row">
			<div>
				<div class="col-xs-12 col-sm-12 col-sm-12 col-lg-12">
					<div class="space"></div>
					<div class="navbar navbar-default">
						<div class="navbar-inner contenido-button">

							<button type="button" onclick="FormCabezaVenta();" 
							class="btn btn-small btn-default" data-toggle='modal' 
							data-target='#Modal_Mante_Venta'>
								<i class="glyphicon glyphicon-plus"></i> Nueva Venta
							</button>

							<div class='modal fade' id='Modal_Mante_Venta' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
							</div>
							<a href="ventas.php" class="link-actualizar pull-right">
								<i class='glyphicon glyphicon-refresh'></i> Actualizar
							</a>

						</div>
					</div>
				</div>


				<div class="col-xs-12 col-sm-12 col-sm-12 col-lg-12">
					<div class="mensaje">
						<?php 
							if(isset($_POST['btnRegve'])):
								$objVentas->id_cliente=$_POST['id_cliente'];
								$objVentas->forma_pago=$_POST['forma_pago'];
								$Mensaje=$objVentas->Add_EncabezadoVenta();
								if($Mensaje=="Datos registrados correctamente."):?>
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

				<div class="col-xs-12 col-sm-12 col-sm-12 col-lg-12">
					<div class="mensaje">
						<?php 
							if(isset($_POST['btnActve'])):
								$objVentas->id=$_POST['id'];
								$objVentas->id_cliente=$_POST['id_cliente'];
								$Mensaje=$objVentas->act_encventa();
								if($Mensaje=="Datos actualizados correctamente."):?>
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

				<div class="col-xs-12 col-sm-12 col-sm-12 col-lg-12">
					<div class="mensaje">
						<?php 
							if(isset($_POST['btnReg'])):
								$objUsu->usuario=$_POST['usuario'];
								$objUsu->password=$_POST['password'];
								$Mensaje=$objUsu->Add_Usuarios();
								if($Mensaje=="Datos registrados correctamente."):?>
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
					<table class='table  table-bordered table-hover table-condensed' id="Tabla-Categoria">
						<thead class="alert alert-info text-head">
							<tr>
								<th class="text-center">N°</th>
								<th class="text-center">FECHA</th>
								<th class="text-center">CLIENTE</th>
								<th class="text-center">FORMA PAGO</th>
								<th class="text-center">ESTADO</th>
								<th class="text-center">TOTAL</th>
								<th class="text-center">OPCIONES</th>
							</tr>
						</thead>
						<tbody>
						<?php if(!empty($item)):?>
							<?php foreach ($item as $item):?>
							<tr>
								<td class="text-center"><?=$item[1]."000".$item[2]?></td>
								<td class="text-center"><?=date('Y-m-d',strtotime($item[4]) )?></td>
								<td class="text-center"><?=$item[12]?></td>
								<td class="text-center"><?php if ($item[5] == 1){ echo "Efectivo";} elseif ($item[5] == 2){ echo "Credito";} ?></td>
								<td class="text-center"><?php if ($item[6] == 1){ echo "Creado";} elseif ($item[6] == 2){ echo "Pendiente";} elseif ($item[6] == 3){echo "Finalizado";} ?></td>
								<td class="text-center">$<?=$item[11]?></td>
								<td>
									<center>
										<span title="Editar Venta" class="btn btn-xs btn-success" 
											onclick="FormCabezaVenta('<?=$item[0]?>');" data-toggle='modal' 
											data-target='#Modal_Mante_Venta' id="tooltip<?=$item[0]?>" data-toggle="tooltip"
											data-placement="top">
											<i class="glyphicon glyphicon-pencil"></i>
										</span>

										
										<span title="Cambiar Estado" class="btn btn-xs btn-info" 
											onclick="FormVerFoto('<?=$item[0]?>');" data-toggle='modal' 
											data-target='#Modal_Mante_VerFoto' id="tool<?=$item[0]?>" data-toggle="tooltip"
											data-placement="top">
											<i class="glyphicon glyphicon-picture"></i>
										</span>
										<span title="Ver Documento" class="btn btn-xs btn-warning" 
											onclick="FormVerFoto('<?=$item[0]?>');" data-toggle='modal' 
											data-target='#Modal_Mante_VerFoto' id="tool<?=$item[0]?>" data-toggle="tooltip"
											data-placement="top">
											<i class="glyphicon glyphicon-picture"></i>
										</span>
									</center>
								</td>
							</tr>
							<?php endforeach; ?>
						<?php endif; ?>
						</tbody>
					</table>
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