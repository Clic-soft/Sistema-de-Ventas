<?php session_start(); ?>
<?php if(isset($_SESSION["Usuario"])):?>
<?php require_once 'clases/clsReportes.php';
	$objRep=new Reporte();
	$meses=$objRep->meses();
	if(isset($_POST['Consultar']))
		$fila=$objRep->Productos_vendidos_por_mes($_POST['month'],$_POST['year']);
	else
		$fila=$objRep->Productos_vendidos_por_mes(date('m'),date('Y'));
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Sistema - Tienda Virtual</title>
	<?php require_once 'inc/header.php'; ?>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawChart);
		function drawChart() {
			var data = google.visualization.arrayToDataTable([
				['Productos', 'Cantidad'],
          
				<?php foreach ($fila as $key):?>
				['<?=$key[0]?>',     <?=$key[1]?>],
				<?php endforeach; ?>
			]);

			var options = {
				title: 'Productos más vendidos',
				is3D: true,
			};

			var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
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
							<?php 
							if(isset($_POST['Consultar'])):
								$m=$objRep->devolvermesletras($_POST['month']);
								$y=$_POST['year'];
							else:
								$m=$objRep->devolvermesactual();
								$y=date('Y');
							endif;
							?>
							<span >Reporte de productos más vendidos - <?=$m?> del <?=$y?></span>
							<a href="productos-mas-vendidos" class="link-actualizar top-link pull-right">
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
		                                <label for="" class="control-label col-xs-1">Mes</label>
		                                <div class="col-xs-3">
		                                    <select class="form-control" required name="month">
		                                    	<?php 
												for($mes=1; $mes<=12; $mes++):
													if (date("m") == $mes): ?>
													<option value="<?=$mes?>" selected><?=$meses[$mes]?></option>
													<?php else: ?>
													<option value="<?=$mes?>"><?=$meses[$mes]?></option>
													<?php endif;
												endfor;?>
		                                    </select>
		                                </div>

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

		                                <div class="col-xs-2">
		                                	<?php 
		                                	if(isset($_POST['Consultar'])):
		                                		$month=$_POST['month'];
		                                		$year=$_POST['year'];
		                                	else:
		                                		$month=date('m');
		                                		$year=date('Y');
		                                	endif;
		                                	?>
		                                	<a class="btn btn-success" href="informe/<?=$month?>/<?=$year?>/" target="_blank">
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
								<th class="text-center">Item</th>
								<th>Productos</th>
								<th class="text-center">Total Ventas</th>
							</tr>
						</thead>
						<tbody>
							<?PHP $cant=0; 
							if(!empty($fila)):?>
							<?php foreach ($fila as $item):
								$cant=$cant+1;?>
							<tr>
								<td class="text-center"><?=$cant?></td>
								<td><?=$item[0]?></td>
								<td class="text-center">
									<?=$item[1]?>
								</td>
							</tr>
							<?php endforeach; 
							endif;?>
						</tbody>
					</table>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					 <div id="piechart_3d" style="width: 100%; height: 300px;"></div>
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