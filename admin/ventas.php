<?php session_start(); ?>
<?php if(isset($_SESSION["Usuario"])):?>
<?php require_once 'clases/clsCategoria.php';
require_once 'clases/clsVentas.php'; 
$objV=new Ventas();
$serie=$objV->getSerie();
$numcomp=$objV->getNumComprobante();

	$objCat=new Categoria();
	$fila=$objCat->get_Categoria();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Sistema - Compras</title>
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
							<span >Realizar ventas</span>
							<a href="ventas" class="link-actualizar top-link pull-right">
								<i class="glyphicon glyphicon-refresh"></i> Actualizar
							</a>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="content-compras">
						<form class="form-horizontal top-form" name="formVent" method="post">
							<div class="content-form">
								<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
									<div class="form-group">
		                                <label for="" class="control-label col-xs-3">D.N.I. / R.U.C.</label>
		                                <div class="col-xs-6">
		                                    <input type="text" readonly class="form-control" name="ruc" placeholder="R.U.C." required minlength="11" maxlength="11" value="">
		                                </div>
		                                <div class="col-xs-3">
		                                    <button type="button" onclick="FormListadoClientes();" 
											class="btn btn-small btn-default" data-toggle='modal' 
											data-target='#Modal_Listado_Clientes'>
												<i class="glyphicon glyphicon-search"></i> Buscar Clientes
											</button>
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label for="" class="control-label col-xs-3">Cliente</label>
		                                <div class="col-xs-9">
		                                    <input type="text" readonly class="form-control" name="nombre" 
		                                    placeholder="Nombre de Cliente" required minlength="5">
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label for="" class="control-label col-xs-3">Dirección</label>
		                                <div class="col-xs-9">
		                                    <input type="text" readonly class="form-control" name="direccion" placeholder="Dirección" required minlength="5">
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label for="" class="control-label col-xs-3">Tipo Persona</label>
		                                <div class='col-xs-4'>
		                                	<select class="form-control" id="tipoPer" name="tipoPer">
		                                		<?php $tipo=array('Natural','Jurídica'); 
			                                    foreach ($tipo as $key => $value):?>
			                                    	<option value="<?=$value?>"><?=$value?></option>
			                                   <?php endforeach;?>
		                                	</select>
		                                </div>
		                                <label for="" class="control-label col-xs-2">Fecha</label>
		                                <div class="col-xs-3">
		                                    <input type="text" readonly class="form-control" name="fecha" required value="<?=date('d/m/Y')?>">
		                                </div>
		                            </div>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-md-offset-1">
									<div class="comprobante-pago-content-venta">
										<div class="comprobante-pago-title">
											<p>R.U.C. N° 20395834584</p>
										</div>
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12">
												<div class="content-tipo">
													<p class="documento">BOLETA DE VENTA</p>
												</div>
											</div>
											<br>
											<div class="content-input">
												<div class="col-xs-12 col-sm-12 col-md-6">
													<label for="">Serie</label>
													<input type="text" readonly name="serie" value="<?=$serie?>" class="form-control">
												</div>
												<div class="col-xs-12 col-sm-12 col-md-6">
													<label for="">N° Comprobante</label>
													<input type="text" readonly id="numero" name="numero" class="form-control" value="<?=$numcomp?>">
												</div>
											</div>
											
										</div>
									</div>
								</div>

								<div class='modal fade' id='Modal_Listado_Clientes' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								</div>
							</div>

							<div class="content-form">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group">
										<label for="" class="control-label col-xs-2">Categoría</label>
		                                <div class="col-xs-4">
		                                    <select class="form-control" name="categ" id="categoria">
		                                        <option value="">Selecione</option>
		                                        <?php foreach ($fila as $key):?>
		                                        <option value="<?=$key[0]?>"><?=$key[1]?></option>
		                                        <?php endforeach; ?>
		                                    </select>
		                                </div>
		                                <label for="" class="control-label col-xs-1">Producto</label>
		                                <div class="col-xs-5">
		                                    <select class="form-control" name="Producto" id="Productos">
		                                    	<option value="">Selecione</option>
		                                    </select>
		                                </div>
									</div>

									<div class="form-group">
										<label for="" class="control-label col-xs-2">Precio Compra S/.</label>
		                                <div class="col-xs-2">
		                                    <input type="text" readonly id="precio" class="form-control" minlength="2" placeholder="20.40">
		                                </div>
		                                <label for="" class="control-label col-xs-1">Stock</label>
		                                <div class="col-xs-2">
		                                    <input type="text" readonly id="stock" class="form-control" placeholder="20">
		                                </div>
		                                <label for="" class="control-label col-xs-1">Cantidad</label>
		                                <div class="col-xs-2">
		                                    <input type="number" class="form-control" min="1" step="1" value="1" id="replyNumber" data-bind="value:replyNumber">
		                                </div>
		                                <div class="col-xs-2">
		                                    <button type="button" class="btn btn-default pull-right" onclick="AgregCarritoVenta();" >
												<i class="glyphicon glyphicon-shopping-cart"></i> Agregar al carrito
											</button>
		                                </div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="mensajeError"></div>
								</div>
							</div>

							<div class="content-form">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<!--<div class="table-responsive hidden-md">-->
									<div class="tabla-carrito-ventas">
										
									</div>
								</div><button name="btnGuardar" class="btn btn-default pull-right btn-right">
								<i class="glyphicon glyphicon-floppy-saved"></i>	Registrar Venta</button>
							</div>
						</form>

						<?php 
						if(isset($_POST['btnGuardar'])):
							if(!empty($_SESSION['carrito_ventas'])):
								$Total=0;
								foreach ($_SESSION['carrito_ventas'] as $key):
									$Total=$Total+$key['SubTotal'];
								endforeach;
								$fecha=date('Y-m-d');

								if($_POST['tipoPer']=="Natural"){
									$tipoDoc='Boleta';
								}else{
									$tipoDoc='Factura';
								}
									

								$objV->dni=rtrim($_POST['ruc']);
								$objV->serie=rtrim($_POST['serie']);
								$objV->numero=rtrim($_POST['numero']);
								$objV->fecha=$fecha;
								$objV->tipo=$tipoDoc;
								$objV->monto=$Total;
								$mensaje1=$objV->Add_Ventas();

								foreach ($_SESSION['carrito_ventas'] as $key) {
									$objV->IdP=$key['Id'];
									$objV->PVenta=$key['Precio'];
									$objV->Cantidad=$key['Cantidad'];
									$objV->SubTotal=$key['SubTotal'];
									$objV->Igv=$key['Igv'];
									$mensaje2=$objV->Add_DetalleVentas();
								}

								if($mensaje2==$mensaje1):
									if($_POST['tipoPer']=="Natural"){
										echo'<script>window.location="comprobante/boleta/'.rtrim($_POST["numero"]).'/";</script>';
									}else{
										echo'<script>window.location="comprobante/factura/'.rtrim($_POST["numero"]).'/";</script>';
									}
									unset($_SESSION['carrito_ventas']);
									?>
									<div class='alert alert-success' role='alert'>
										<button type='button' class='close' data-dismiss='alert'>&times;</button>
										<i class='glyphicon glyphicon-ok'></i>&nbsp;<?=$mensaje2;?>
									</div>
							  	<?php 
							  	else: ?>
									<div class='alert alert-danger' role='alert'>
										<button type='button' class='close' data-dismiss='alert'>&times;</button>
										<i class='glyphicon glyphicon-remove'></i>&nbsp;<?=$Mensaje;?>
									</div>
							  	<?php 
							  	endif;
							else:?>
								<div class='alert alert-danger' role='alert'>
									<button type='button' class='close' data-dismiss='alert'>&times;</button>
									<i class='glyphicon glyphicon-remove'></i>&nbsp;Carrito vacio, agregue productos.
								</div>
							<?php	
							endif;
						endif;
						?>

					</div>
					<script type="text/javascript">
						$(function () {
							$('#datetimepicker1').datetimepicker()
						});
					</script>
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