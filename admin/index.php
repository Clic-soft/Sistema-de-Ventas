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
	<div class="m-left z-1 fixed inline-flex col-md-2">
		<div id="m">
			<?php require_once 'inc/menu.php'; ?>
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
			<!--<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">-->
			<!--<div class="content">-->
			<div>
				<!--<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-2">-->
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<!--<img src="images/fondo.png" class="img-responsive" style="margin-top: -20px;width: 80%; height=150px">-->
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