<?php session_start(); ?>
<?php if(isset($_SESSION["Usuario"])):?>
<?php require_once 'clases/clsProducto.php'; 
	$objPre=new Presentacion();
	$fila=$objPre->get_Presentacion();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Tienda - Presentación</title>
	<?php require_once 'inc/header.php'; ?>
</head>
<body>
	<div class="m-left z-1 fixed inline-flex col-md-2">
		<div id="m">
			<?php require_once 'inc/menu.php'; ?>
			<script type="text/javascript">
			$("#presentacion").addClass("active");					
		</script>
		</div>
	</div>
	<div class="menu--top container-fluid col-md-10 col-md-offset-2">
		<div class="row">
			<div class="nav-top-menu">
				<div class="col-xs-6">
					<strong><?=$_SESSION['Usuario']?></strong>
				</div>
				<div class="col-xs-6">
                	<a class="float-right" href="inc/CerrarSesion.php">Cerrar Sesión</a>
                </div>
			</div>
			<div id="more-menu" class="more-menu">
               	<span class="glyphicon glyphicon-chevron-down"></span>
            </div>	
            <script type="text/javascript">
           		$("#more-menu").click(function(){
           			$(".m-left").toggle();
           		});
            </script>
		</div>
	</div>
	<div class="container-fluid col-md-10 col-md-offset-2">
		<div class="row">
			<div>
				<div class="col-xs-12 col-sm-12 col-sm-12 col-lg-12">
					<div class="space"></div>
					<div class="navbar navbar-default">
						<div class="navbar-inner contenido-button">
							<button type="button" onclick="FormPresentacion();" 
							class="btn btn-small btn-default" data-toggle='modal' 
							data-target='#Modal_Mante_Present'>
								<i class="glyphicon glyphicon-plus"></i> Nueva Presentación
							</button>

							<div class='modal fade' id='Modal_Mante_Present' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
							</div>

							<a href="presentacion" class="link-actualizar pull-right">
								<i class="glyphicon glyphicon-refresh"></i> Actualizar
							</a>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-sm-12 col-lg-12">
					<div class="mensaje">
						<?php 
							if(isset($_POST['btnReg'])):
								$objPre->descripcion=$_POST['presentacion'];
								$Mensaje=$objPre->Add_Presentacion();
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
								$objPre->IdPre=$_POST['IdPre'];
								$objPre->descripcion=$_POST['presentacion'];
								$Mensaje=$objPre->Update_Presentacion();
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
				
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<table class='table  table-bordered table-hover table-condensed' id="Tabla-Categoria">
						<thead class="alert alert-info text-head">
							<tr>
								<th class="text-center">Item</th>
								<th>Presentación</th>
								<th class="text-center">Editar</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($fila as $item):?>
							<tr>
								<td class="text-center"><?=$item[0]?></td>
								<td><?=$item[1]?></td>
								<td>
									<center>
										<span title="Actualizar Información" class="btn btn-xs btn-info" 
											onclick="FormPresentacion('<?=$item[0]?>');" data-toggle='modal' 
											data-target='#Modal_Mante_Present' id="top<?=$item[0]?>" 
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

	<?php require_once 'inc/footer.php'; ?>
</body>
</html>
<?php 
else:
	header( 'Location: ../' );
endif;
?>