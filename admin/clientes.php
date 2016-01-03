<?php session_start(); ?>
<?php if(isset($_SESSION["Usuario"])):?>
<?php require_once 'clases/clsClientes.php'; 
	$objCli=new Clientes();
	$fila=$objCli->getClientes();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Sistema - Compras</title>
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
							<button type="button" onclick="FormClientes();" 
							class="btn btn-small btn-default" data-toggle='modal' 
							data-target='#Modal_Mante_Clientes'>
								<i class="glyphicon glyphicon-plus"></i> Nuevo Cliente
							</button>

							<div class='modal fade' id='Modal_Mante_Clientes' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
							</div>

							<a href="clientes" class="link-actualizar pull-right">
								<i class="glyphicon glyphicon-refresh"></i> Actualizar
							</a>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-sm-12 col-lg-12">
					<div class="mensaje">
						<?php 
							if(isset($_POST['btnReg'])):
								$objCli->DNI=rtrim($_POST['dni']);
								$objCli->tipo=rtrim($_POST['tipo']);
								$objCli->nombre=rtrim($_POST['nombrecliente']);
								$objCli->direccion=rtrim($_POST['direccion']);
								$objCli->telefono=rtrim($_POST['telefono']);
								$objCli->email=rtrim($_POST['email']);
								$Mensaje=$objCli->Add_Clientes();
								if($Mensaje=="Registrado correctamente ok."):?>
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
								$objCli->DNI=rtrim($_POST['dni']);
								$objCli->tipo=rtrim($_POST['tipo']);
								$objCli->nombre=rtrim($_POST['nombrecliente']);
								$objCli->direccion=rtrim($_POST['direccion']);
								$objCli->telefono=rtrim($_POST['telefono']);
								$objCli->email=rtrim($_POST['email']);
								$Mensaje=$objCli->Update_Cliente();
								if($Mensaje=="Registro actualizado correctamente ok."):?>
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
								<th class="text-center">D.N.I. / R.U.C.</th>
								<th>Nombre Cliente</th>
								<th>Tipo</th>
								<th>Dirección</th>
								<th>Teléfono</th>
								<th>E-mail</th>
								<th class="text-center">Editar</th>
							</tr>
						</thead>
						<tbody>
							<?php $cant=0; ?>
							<?php foreach ($fila as $item):?>
							<?php $cant=$cant+1; ?>
							<tr>
								<td class="text-center"><?=$item[0]?></td>
								<td><?=$item[2]?></td>
								<td><?=$item[1]?></td>
								<td><?=$item[3]?></td>
								<td class="text-center"><?= (empty($item[4])) ? "-":$item[4];?></td>
								<td class="text-center">
									<?= (empty($item[5])) ? "-":$item[5];?>
								</td>
								<td>
									<center>
										<span title="Actualizar" class="btn btn-xs btn-info" 
											onclick="FormClientes('<?=$item[0]?>');" data-toggle='modal' 
											data-target='#Modal_Mante_Clientes' id="top<?=$cant?>" 
											data-toggle="tooltip" data-placement="top">
											<i class="glyphicon glyphicon-edit"></i>
										</span>
									</center>
								</td>
							</tr>
							<script>
								$(document).ready(function(){
									$("#top<?=$cant?>").tooltip({
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