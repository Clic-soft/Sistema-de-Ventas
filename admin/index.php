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
				<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-2">
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