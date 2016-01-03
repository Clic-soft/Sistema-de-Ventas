<?php session_start(); ?>
<?php if(isset($_SESSION["Usuario"])):?>
<?php require_once 'clases/clsUsuario.php'; 
	$objUsu=new Usuarios();
	$fila=$objUsu->get_usuario_id($_SESSION["IdU"]);
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
					<div class="mensaje">
						<?php 
						if(isset($_POST['btnGuardar'])):
							$objUsu->IdU=$_POST['codigo'];
							$objUsu->nombres=$_POST['nombres'];
							$objUsu->apellidos=$_POST['apellidos'];
							$objUsu->celular=$_POST['celular'];
							$objUsu->email=$_POST['email'];
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
							<a href="profile" class="link-actualizar pull-right">
								<i class="glyphicon glyphicon-refresh"></i> Actualizar
							</a>
						</div>
						<div class="clearfix"></div>
						<form class="form-horizontal" action="" method="POST" name="frmprofile">
							<div class="acceso"><br>
								<div class="form-group">
									<input type="hidden" name="codigo" class="form-control" required value="<?=$_SESSION['IdU']?>">
	                            	<label for="disabledTextInput" class="control-label col-xs-3">Nombres</label>
	                            	<div class="col-xs-8">
	                            		<input type="text" name="nombres" class="form-control" required value="<?=utf8_encode($fila[0])?>">
	                            	</div>
	                            </div>
	                            <div class="form-group">
	                            	<label for="" class="control-label col-xs-3">Apellidos</label>
	                            	<div class="col-xs-8">
	                            		<input type="text" name="apellidos" class="form-control" required
	                            			placeholder="Apellidos" value="<?=$fila[1]?>">
	                            	</div>
	                            </div>
	                            <div class="form-group">
	                            	<label for="" class="control-label col-xs-3">Tipo de Usuario</label>
	                            	<div class="col-xs-8"><?=$item[0]?>
	                            		<select class="form-control" required disabled name="tipo">
	                                        <option value="">Selecione</option>
	                                        <option value="Administrador" <?php if($fila[3]=="Administrador") echo "Selected";?>>Administrador</option>
	                                        <option value="Trabajador" <?php if($fila[3]=="Trabajador") echo "Selected";?>>Trabajador</option>
	                                    </select>
	                            	</div>
	                            </div>
	                            <div class="form-group">
	                            	<label for="" class="control-label col-xs-3">Celular</label>
	                            	<div class="col-xs-8">
	                            		<input type="text" name="celular" class="form-control" required value="<?=$fila[2]?>">
	                            	</div>
	                            </div>
	                            <div class="form-group">
	                            	<label for="" class="control-label col-xs-3">E-mail</label>
	                            	<div class="col-xs-8">
	                            		<input type="email" name="email" class="form-control" required
	                            			placeholder="E-mail" value="<?=$fila[4]?>">
	                            	</div>
	                            </div>
	                            <div class="form-group">
	                                <label for="" class="control-label col-xs-3">Estado</label>
	                                <div class="col-lg-8">
	                                    <div class="checkbox">
	                                        <label>
	                                            <input type="checkbox" disabled checked> Activo
	                                        </label>
	                                    </div>
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