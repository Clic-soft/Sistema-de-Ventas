<?php session_start(); ?>
<?php if(isset($_SESSION["Usuario"])):?>
<?php require_once 'clases/clsCategoria.php'; 
	$objCat=new Categoria();
	$fila=$objCat->get_Categoria();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Sistema - Tienda Virtual</title>
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
							<button type="button" onclick='FormEmpresas();' 
							class="btn btn-small btn-default" data-toggle='modal' 
							data-target='#Modal_Mante_Categoria'>
								<i class="glyphicon glyphicon-plus"></i> Nueva Categoría
							</button>

							<div class='modal fade' id='Modal_Mante_Categoria' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
							</div>

							<a href="categoria.php" class="link-actualizar pull-right">
								<i class='glyphicon glyphicon-refresh'></i> Actualizar
							</a>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-sm-12 col-lg-12">
					<div class="mensaje">
						<?php 
							if(isset($_POST['btnReg'])):
								$objCat->descripcion=$_POST['categoria'];
								$Mensaje=$objCat->Add_Categoria();
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
								$objCat->IdCateg=$_POST['IdCat'];
								$objCat->descripcion=$_POST['categoria'];
								$Mensaje=$objCat->Update_Categoria();
								if($Mensaje=="El registro se ha actualizado."):?>
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

				<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1">
					<table class='table  table-bordered table-hover table-condensed' id="Tabla-Categoria">
						<thead class="alert alert-info text-head">
							<tr>
								<th class="text-center">Item</th>
								<th>Categoría</th>
								<th class="text-center">Estado</th>
								<th class="text-center">Editar</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($fila as $item):?>
							<tr>
								<td class="text-center"><?=$item[0]?></td>
								<td><?=$item[1]?></td>
								<td class="text-center">
									<span class="<?= ($item[2]=='Activo') ? "label label-success":"label label-danger";?>" 
										style="cursor:pointer;font-size:13px; font-weight:normal" onclick="ECategoria('<?= $item[0]?>','EC');"><?= $item['Estado']?>
									</span>
								</td>
								<td>
									<center>
										<span title="Actualizar Información" class="btn btn-xs btn-info" 
											onclick="FormEmpresas('<?=$item[0]?>');" data-toggle='modal' 
											data-target='#Modal_Mante_Categoria' id="top<?=$item[1]?>" 
											data-toggle="tooltip" data-placement="top">
											<i class="glyphicon glyphicon-edit"></i>
										</span>
									</center>
								</td>
							</tr>
							<script>
								$(document).ready(function(){
									$("#top<?=$item[1]?>").tooltip({
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