<?php session_start(); ?>
<?php if(isset($_SESSION["Usuario"])):?>
<?php require_once 'clases/clsUsuario.php'; 
	$objUsu=new Usuarios();
	$fila=$objUsu->get_usuario_id($_SESSION["id"]);
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Sistema - Tienda Virtual</title>
	<?php require_once 'inc/header.php'; ?>
</head>
<body>
	<?php require_once 'inc/menu-l.php'; ?>
	<div class="container-fluid col-md-10 col-md-offset-2">
		<div class="row">
			<div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="mensaje">
						<?php 
						if(isset($_POST['btnGuardar'])):
							$objUsu->id=$_SESSION["id"];
							$objUsu->usuario=$_POST['usuario'];
							$Mensaje=$objUsu->Update_Usuarios();
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

					<div class="new-count">
						<div class="col-xs-12 col-md-8">
							<h3>Perfil del usuario: <?=$_SESSION["Usuario"]?></h3>
						</div>
						<div class="col-xs-12 col-md-4">
							<a href="profile.php" class="link-actualizar pull-right">
								<i class="glyphicon glyphicon-refresh"></i> Actualizar
							</a>
						</div>
						<div class="clearfix"></div>
						<form class="form-horizontal" action="" method="POST" name="frmprofile">
							<div class="acceso"><br>

	                            <div class="form-group">
	                            	<label for="" class="control-label col-xs-3">Usuario</label>
	                            	<div class="col-xs-8">
	                            		<input type="text" name="usuario" class="form-control" required
	                            			placeholder="Usuario" value="<?=$fila[1]?>">
	                            	</div>
	                            </div>
	                            <div class="form-group">
	                            	<label for="" class="control-label col-xs-3">Estado</label>
	                            	<div class="col-xs-8">
	                            		<select class="form-control" required disabled name="tipo">
	                                        <option value="">Selecione</option>
	                                        <option value="1" <?php if($fila[3]=="1") echo "Selected";?>>Activo</option>
	                                        <option value="2" <?php if($fila[3]=="2") echo "Selected";?>>Inactivo</option>
	                                    </select>
	                            	</div>
	                            </div>
							</div>

							<center>
	                           <button type="submit" class="btn btn-primary btn-center" 
	                           		name="btnGuardar">Guardar Información
	                           	</button> 
	                        </center>
						</form>
					</div>
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