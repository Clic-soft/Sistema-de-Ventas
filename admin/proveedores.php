<?php session_start(); ?>
<?php if(isset($_SESSION["Usuario"])):?>
<?php require_once 'clases/clsProveedor.php'; 
	$objPro=new Proveedores();
	$fila=$objPro->get_Proveedores();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Sistema - Proveedores</title>
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
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="navbar navbar-default">
						<div class="navbar-inner contenido-button">
							<button type="button" onclick="FormProveedores();" 
							class="btn btn-small btn-default" data-toggle='modal' 
							data-target='#Modal_Mante_Proveedores'>
								<i class="glyphicon glyphicon-plus"></i> Nuevo Proveedor
							</button>

							<div class='modal fade' id='Modal_Mante_Proveedores' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
							</div>

							<a href="proveedores" class="link-actualizar pull-right">
								<i class="glyphicon glyphicon-refresh"></i> Actualizar
							</a>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group">
							<a class="btn btn-success pull-right" href="informe4/" target="_blank">
								<i class="glyphicon glyphicon-print"></i> Generar Reporte
							</a>
						</div>
					</div>
					<br>
				</div>

				<div class="col-xs-12 col-sm-12 col-sm-12 col-lg-12">
					<div class="mensaje">
						<?php 
							if(isset($_POST['btnReg'])):
								$objPro->ruc=$_POST['ruc'];
								$objPro->razonsocial=$_POST['rasonsocial'];
								$objPro->direccion=$_POST['direccion'];
								$objPro->telefono=$_POST['telefono'];
								$objPro->email=$_POST['email'];
								$Mensaje=$objPro->Add_Proveedor();
								if($Mensaje=="Registrado correctamente"):?>
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

							if(isset($_POST['btnAct'])):
								$objPro->ruc=$_POST['ruc'];
								$objPro->razonsocial=$_POST['rasonsocial'];
								$objPro->direccion=$_POST['direccion'];
								$objPro->telefono=$_POST['telefono'];
								$objPro->email=$_POST['email'];
								$Mensaje=$objPro->Update_Proveedor();
								if($Mensaje=="Registro actualizado correctamente."):?>
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
								<th class="text-center">R.U.C.</th>
								<th>Razón Social</th>
								<th>Dirección</th>
								<th>Teléfono</th>
								<th>E-mail</th>
								<th class="text-center">Estado</th>
								<th class="text-center">Editar</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($fila as $item):?>
							<tr>
								<td class="text-center"><?=$item[0]?></td>
								<td><?=$item[1]?></td>
								<td><?=$item[2]?></td>
								<td><?=$item[3]?></td>
								<td><?=$item[4]?></td>
								<td class="text-center">
									<span class="<?= ($item[5]=='Activo') ? "label label-success":"label label-danger";?>" 
										style="cursor:pointer;font-size:13px; font-weight:normal" onclick="EProveedor('<?= $item[0]?>','EProv');"><?= $item['Estado']?>
									</span>
								</td>
								<td>
									<center>
										<span title="Actualizar" class="btn btn-xs btn-info" 
											onclick="FormProveedores('<?=$item[0]?>');" data-toggle='modal' 
											data-target='#Modal_Mante_Proveedores' id="top<?=$item[0]?>" 
											data-toggle="tooltip" data-placement="top">
											<i class="glyphicon glyphicon-edit"></i>
										</span>
									</center>
								</td>
							</tr>
							<script>
								$(document).ready(function(){
									$("#top<?=$item[0]?>").tooltip({
										placement : 'top'
								    });
								});
							</script>
							<?php
								endforeach; 
							?>
							
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