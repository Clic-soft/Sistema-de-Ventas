<?php session_start(); ?>
<?php if(isset($_SESSION["Usuario"])):?>
<?php require_once 'clases/clsReportes.php';
	$Reporte=new Reporte();
	$fila=$Reporte->getStockminimo();
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
						<div class="navbar-inner content-span">
							<span >Reporte de productos con stock mínimo - <?=date('d/m/Y')?></span>
							<a href="productos-stock-minimo" class="link-actualizar top-link pull-right">
								<i class="glyphicon glyphicon-refresh"></i> Actualizar
							</a>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="content-compras">
						<div class="content-form">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group">
									<a class="btn btn-success pull-right" href="informe3/" target="_blank">
										<i class="glyphicon glyphicon-print"></i> Generar Reporte
									</a>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
					</div><br>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<table class='table  table-bordered table-hover table-condensed' id="Tabla-Categoria">
						<thead class="alert alert-info text-head">
							<tr>
								<th class="text-center">Item</th>
								<th>Categoría</th>
								<th class="text-center">Producto</th>
								<th class="text-center">Precio Venta</th>
								<th class="text-center">Stock</th>
							</tr>
						</thead>
						<tbody>
							<?PHP $cant=0; 
							if(!empty($fila)):?>
							<?php foreach ($fila as $item):
								$cant=$cant+1;?>
							<tr>
								<td class="text-center"><?=$cant?></td>
								<td><?=$item[1]?></td>
								<td>
									<?=$item[2]?>
								</td>
								<td class="text-center">
									S/. <?=$item[3]?>
								</td>
								<td class="text-center">
									<span class="badge alert-danger badge-red"><?=$item[4]?></span>
								</td>
							</tr>
							<?php
								endforeach; 
							endif;?>
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