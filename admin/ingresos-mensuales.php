<?php session_start(); ?>
<?php if(isset($_SESSION["Usuario"])):?>
<?php require_once 'clases/clsReportes.php';
	$Reporte=new Reporte();
	if(isset($_POST['Consultar']))
		$montoMensual=$Reporte->getVentasMensual($_POST['year']);
	else
		$montoMensual=$Reporte->getVentasMensual(date('Y'));

	$meses=$Reporte->meses();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Sistema - Tienda Virtual</title>
	<?php require_once 'inc/header.php'; ?>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
		google.load("visualization", "1.1", {packages:["bar"]});
		google.setOnLoadCallback(drawChart);
			function drawChart() {
				var data = google.visualization.arrayToDataTable([
					['Meses', 'Ingresos'],
					<?php foreach ($montoMensual as $key):?>
						['<?=$key["Mes"]?>', <?=$key['Monto']?>],
					<?php endforeach; ?>
				]);

				var options = {
					chart: {
						title: 'Ingresos estimados mensuales en soles',
					},
					bars: 'horizontal' // Required for Material Bar Charts.
				};

				var chart = new google.charts.Bar(document.getElementById('barchart_material'));
				chart.draw(data, options);
			}
	</script>
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
							<span >Reporte de Ingresos de dinero - Año: <?= isset($_POST['Consultar']) ? $_POST['year']:date('Y'); ?></span>
							<a href="ingresos-mensuales" class="link-actualizar top-link pull-right">
								<i class="glyphicon glyphicon-refresh"></i> Actualizar
							</a>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="content-compras">
						<form class="form-horizontal top-form" name="formRep1" method="post">
							<div class="content-form">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group">
		                                <label for="" class="control-label col-xs-1">Año</label>
		                                <div class="col-xs-3">
		                                    <select class="form-control" required name="year">
											<?php for ($i=date(Y); $i>=2013 ; $i--):?>
													<option value="<?= $i?>" <?php if(date('Y')==$i) echo "Selected";?>><?= $i?></option>
											<?php endfor;?>
		                                    </select>
		                                </div>

		                                <div class="col-xs-2">
		                                	<button type="submit" class="btn btn-danger" name="Consultar">
		                                		<i class="glyphicon glyphicon-search"></i> Consultar
		                                	</button>
		                                </div>
		                                <div class="col-xs-4">
		                                	<?php $suma=0;
		                                	if(!empty($montoMensual)):
		                                	foreach ($montoMensual as $item):
		                                		$suma=$suma+$item['Monto'];
		                                	endforeach;
		                                	endif;?>
		                                	<label for="" class="total">
		                                		<span>Monto Total: S/. <?=number_format($suma,2)?></span>
		                                	</label>
		                                </div>
		                                <div class="col-xs-2">
		                                	<?php 
		                                	if(isset($_POST['Consultar'])):
		                                		$year=$_POST['year'];
		                                	else:
		                                		$year=date('Y');
		                                	endif;
		                                	?>
			                                <a class="btn btn-success" href="informe2/ingresos/<?=$year?>/" target="_blank">
			                                	<i class="glyphicon glyphicon-print"></i> Generar Reporte
			                                </a>
		                                </div>
									</div>
								</div>
							</div>
						</form>
					</div><br><br>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<table class='table  table-bordered table-hover table-condensed' id="Tabla-Categoria">
						<thead class="alert alert-info text-head">
							<tr>
								<th class="text-center">N°</th>
								<th>Mes</th>
								<th class="text-center">Monto Total</th>
							</tr>
						</thead>
						<tbody>
							<?PHP $cant=0; 
							if(!empty($montoMensual)):?>
							<?php foreach ($montoMensual as $item):
								$cant=$cant+1;?>
							<tr>
								<td class="text-center"><?=$cant?></td>
								<td><?=$item['Mes']?></td>
								<td class="text-center">
									S/. <?=$item['Monto']?>
								</td>
							</tr>
							<?php
								endforeach; 
							endif;?>
						</tbody>
					</table>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<div id="barchart_material" style="width: 100%; height: 350px;"></div>
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