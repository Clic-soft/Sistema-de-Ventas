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
	<!--<div class="m-left z-1 fixed inline-flex col-md-2">
		<div id="m">
			<?php require_once 'inc/menu.php'; ?>
		</div>
	</div>-->
	<div class="menu--top container-fluid col-md-12">
		<div class="row">
			<div class="nav-top-menu">
				<div class="col-xs-6">
					<strong><?=$_SESSION['Usuario']?></strong>
				</div>
				<div class="col-xs-6">
                	<a class="float-right" href="inc/CerrarSesion.php">Cerrar Sesión</a>
                </div>
			</div>
		</div>
	</div>

	<div class="container-fluid col-md-12">
		<div class="row">
			<!--<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">-->
			<!--<div class="content">-->
			<div>
				<!--<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-2">-->
				<div class="index row col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="space"></div>
					<a href="./">
						<div class="col-xs-12 col-md-4 welcome" style="height: 352px;">
							<p class="title">Bienvenido a XXXXXXXXX</p>
							<p>En esta aplicación tu podrás Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua.</p>							
						</div>
					</a>
					<!--Perfil-->
					<a href="profile.php">
						<div class="col-xs-6 col-md-2 iconos-i">
							<p><span class="glyphicon glyphicon-user"></span></p>
							<p class="title">Perfil</p>
							<p class="hidden">Clic-Soft</p>
						</div>
					</a>
					<!--Categoria-->
					<?php if(($_SESSION['Tipo']=='Administrador')) { ?>
					<a href="<?= ($_SESSION['Tipo']=='Administrador') ? "categoria.php":"#";?>">
						<div class="col-xs-6 col-md-2 iconos-i">
							<p><span class="glyphicon glyphicon-user"></span></p>
							<p class="title">
								Categoria
							</p>
							<p><i class="glyphicon glyphicon-bell"></i><?=$repor->numcateg();?></span></a></p>
						</div>
					</a>
					<?php } ?>
					 
					<!--Presentación -->
					<?php if(($_SESSION['Tipo']=='Administrador')) { ?>
					<a href="<?= ($_SESSION['Tipo']=='Administrador') ? "presentacion.php":"#";?>">
						<div class="col-xs-6 col-md-2 iconos-i">
							<p><span class="glyphicon glyphicon-knight"></span></p>
							<p class="title">Presentación</p>
							<p><i class="glyphicon glyphicon-bell"></i><?=$repor->numpres();?></span></p>
						</div>
					</a>
					<?php } ?>
					<!--Productos -->
					<a href="productos.php">
						<div class="col-xs-6 col-md-2 iconos-i">
							<p><span class="glyphicon glyphicon-bed"></span></p>
							<p class="title">Productos</p>
							<p><i class="glyphicon glyphicon-bell"></i><?=$repor->numprod();?></span></p>
						</div>
					</a>
					<!--Provedores -->
					<?php if(($_SESSION['Tipo']=='Administrador')) { ?>
					<a href="<?= ($_SESSION['Tipo']=='Administrador') ? "proveedores.php":"#";?>">
						<div class="col-xs-6 col-md-2 iconos-i">
							<p><span class="glyphicon glyphicon-scale"></span></p>
							<p class="title">Provedores</p>
							<i class="glyphicon glyphicon-bell"></i><?=$repor->numprov();?></span>
						</div>
					</a>
					<?php } ?>
					<!--Compras -->
					<?php if(($_SESSION['Tipo']=='Administrador')) { ?>
					<a href="<?= ($_SESSION['Tipo']=='Administrador') ? "compras.php":"#";?>">
						<div class="col-xs-6 col-md-2 iconos-i">
							<p><span class="glyphicon glyphicon-shopping-cart"></span></p>
							<p class="title">Compras</p>
								<i class="glyphicon glyphicon-bell"></i>
								<?php 
									if($repor->numcompras()<9)
										echo $repor->numcompras();
									else
										echo '+ '.$repor->numcompras();
								?>
						</div>
					</a>
					<?php } ?>
					<!--Clientes -->
					<?php if(($_SESSION['Tipo']=='Administrador')) { ?>
					<a href="<?= ($_SESSION['Tipo']=='Administrador') ? "clientes.php":"#";?>">
						<div class="col-xs-6 col-md-2 iconos-i">
							<p><span class="glyphicon glyphicon-folder-open"></span></p>
							<p class="title">Clientes</p>
							<i class="glyphicon glyphicon-bell"></i>
								<?php 
									if($repor->numclientes()<9)
										echo $repor->numclientes();
									else
										echo '+ '.$repor->numclientes();
								?>
						</div>
					</a>
					<?php } ?>
					<!--Ventas -->
					<a href="ventas.php">
						<div class="col-xs-6 col-md-2 iconos-i">
							<p><span class="glyphicon glyphicon-credit-card"></span></p>
							<p class="title">Ventas</p>
							<i class="glyphicon glyphicon-bell"></i>
								<?php 
									if($repor->numventas()<9)
										echo $repor->numventas();
									else
										echo '+ '.$repor->numventas();
								?>
						</div>
					</a>
					<!--Reportes -->
					<a href="menureporte.php">
						<div class="col-xs-6 col-md-2 iconos-i">
							<p><span class="glyphicon glyphicon-list-alt"></span></p>
							<p class="title">Reportes</p>
							<i class="glyphicon glyphicon-bell"></i>4</span>
						</div>
					</a>
					<!--Usuarios -->
					<?php if(($_SESSION['Tipo']=='Administrador')) { ?>
					<a href="<?= ($_SESSION['Tipo']=='Administrador') ? "usuarios.php":"#";?>">
						<div class="col-xs-6 col-md-2 iconos-i">
							<p><span class="glyphicon glyphicon-user"></span></p>
							<p class="title">Usuarios</p>
							<i class="glyphicon glyphicon-bell"></i>
								<?php 
									if($repor->numusuario()<9)
										echo $repor->numusuario();
									else
										echo '+ '.$repor->numusuario();
								?>
						</div>
					</a>
					<?php } ?>
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

<script type="text/javascript" src="js/script-jquery.js"></script>