<?php session_start(); ?>
<?php if(isset($_SESSION["Usuario"])):?>
<?php require_once 'clases/clsUsuario.php'; 
	$objUsu=new Usuarios();
	$fila=$objUsu->get_usuarios();
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
							<button type="button" <?= ($_SESSION['Tipo']=='Administrador') ? "onclick='FormUsuarios();'":"";?> 
							class="btn btn-small btn-default" data-toggle='modal' 
							data-target='#Modal_Mante_Usuarios'>
								<i class="glyphicon glyphicon-plus"></i> Nuevo Usuario
							</button>

							<div class='modal fade' id='Modal_Mante_Usuarios' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
							</div>

							<a href="<?= ($_SESSION['Tipo']=='Administrador') ? "usuarios":"#";?>" 
								class="link-actualizar pull-right"><i class='glyphicon glyphicon-refresh'></i> Actualizar
							</a>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-sm-12 col-lg-12">
					<div class="mensaje">
						<?php 
							if(isset($_POST['btnReg'])):
								$objUsu->nombres=$_POST['nombres'];
								$objUsu->apellidos=$_POST['apellidos'];
								$objUsu->celular=$_POST['celular'];
								$objUsu->tipo=$_POST['tipo'];
								$objUsu->email=$_POST['email'];
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
								<th>Apellidos y Nombres</th>
								<th>Tipo</th>
								<th>Celular</th>
								<th>E-mail</th>
								<th class="text-center">Estado</th>
							</tr>
						</thead>
						<tbody>
						<?php if(!empty($fila)):?>
							<?php foreach ($fila as $item):?>
							<tr>
								<td class="text-center"><?=$item[0]?></td>
								<td><?= $item[2]?>, <?=$item[1]?></td>
								<td><?=$item[4]?></td>
								<td><?=$item[3]?></td>
								<td><?=$item[5]?></td>
								<td class="text-center">
									<span class="<?= ($item[6]=='Activo') ? "label label-success":"label label-danger";?>" 
										style="cursor:pointer;font-size:13px; font-weight:normal" onclick="EUsuario('<?= $item[0]?>','EU');"><?= $item['Estado']?>
									</span>
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