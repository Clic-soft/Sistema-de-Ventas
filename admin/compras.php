<?php session_start(); ?>
<?php if(isset($_SESSION["Usuario"])):?>
<?php require_once 'clases/clsCategoria.php'; 
require_once('clases/clsCompras.php');
$objcomp=new Compras();
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
							<span >Realizar compras</span>
							<a href="compras" class="link-actualizar top-link pull-right">
								<i class="glyphicon glyphicon-refresh"></i> Actualizar
							</a>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="content-compras">
						<form class="form-horizontal top-form" name="formComp" method="post">
							<div class="content-form">
								<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
									<div class="form-group">
		                                <label for="" class="control-label col-xs-3">R.U.C.</label>
		                                <div class="col-xs-6">
		                                    <input type="text" readonly class="form-control" name="ruc" placeholder="R.U.C." required minlength="11" maxlength="11" value="">
		                                </div>
		                                <div class="col-xs-3">
		                                    <button type="button" onclick="FormListadoProveedores();" 
											class="btn btn-small btn-default" data-toggle='modal' 
											data-target='#Modal_Listado_Proveedores'>
												<i class="glyphicon glyphicon-search"></i> Buscar Proveedor
											</button>
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label for="" class="control-label col-xs-3">Razón Social</label>
		                                <div class="col-xs-9">
		                                    <input type="text" readonly class="form-control" name="razon" placeholder="Razón Social" required minlength="5">
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label for="" class="control-label col-xs-3">Dirección</label>
		                                <div class="col-xs-9">
		                                    <input type="text" readonly class="form-control" name="direccion" placeholder="Dirección" required minlength="5">
		                                </div>
		                            </div>
		                            <div class="form-group">
		                                <label for="" class="control-label col-xs-3">Fecha de Compra</label>
		                                <div class='col-xs-9 input-group date' id='datetimepicker1'>
		                                    <input type='text' name="fecha" class="form-control" required 
		                                        readonly data-date-format="DD/MM/YYYY hh:mm:ss A" placeholder="25/01/2015 05:32:51 PM"/>
		                                    <span class="input-group-addon">
		                                        <span class="text-danger glyphicon glyphicon-calendar"></span>
		                                    </span>
		                                </div>
		                            </div>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-md-offset-1">
									<div class="comprobante-pago-content-compra">
										<div class="comprobante-pago-title">
											<p>COMPROBANTE DE PAGO</p>
										</div>
										<div class="row">
											<div class="content-input">
												<div class="col-xs-12 col-sm-12 col-md-6">
													<label for="">Serie</label>
													<input type="text" name="serie" class="form-control" required minlength="3" maxlength="3" placeholder="001">
												</div>
												<div class="col-xs-12 col-sm-12 col-md-6">
													<label for="">N° Comprobante</label>
													<input type="text" name="numero" class="form-control" required minlength="5" maxlength="7" placeholder="0000001">
												</div>
											</div>
											
										</div>
									</div>
								</div>

								<div class='modal fade' id='Modal_Listado_Proveedores' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								</div>
							</div>

							<div class="content-form">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group">
										<label for="" class="control-label col-xs-2">Categoría</label>
		                                <div class="col-xs-4">
		                                    <select class="form-control" name="categ" id="categ">
		                                        <option value="">Selecione</option>
		                                        <?php foreach ($fila as $key):?>
		                                        <option value="<?=$key[0]?>"><?=$key[1]?></option>
		                                        <?php endforeach; ?>
		                                    </select>
		                                </div>
		                                <label for="" class="control-label col-xs-1">Producto</label>
		                                <div class="col-xs-5">
		                                    <select class="form-control" name="Producto" id="Producto">
		                                    </select>
		                                </div>
									</div>

									<div class="form-group">
										<label for="" class="control-label col-xs-2">Precio Compra S/.</label>
		                                <div class="col-xs-2">
		                                    <input type="text" id="precio" class="form-control" minlength="2" placeholder="20.40">
		                                </div>
		                                <label for="" class="control-label col-xs-1 col-md-offset-2">Cantidad</label>
		                                <div class="col-xs-2">
		                                    <input type="number" class="form-control" id="replyNumber" min="1" step="1" data-bind="value:replyNumber" value="1">
		                                </div>
		                                <div class="col-xs-3 col-md-offset-0">
		                                    <button type="button" class="btn btn-default pull-right" onclick="AgregarCarrito();" >
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
									<div class="tabla-carrito">
										
									</div>
								</div><button name="btnGuardar" class="btn btn-default pull-right btn-right">
								<i class="glyphicon glyphicon-floppy-saved"></i>	Registrar Compra</button>
							</div>
							
						</form>
						<?php 
						if(isset($_POST['btnGuardar'])):
							if(!empty($_SESSION['carrito'])):
								$Total=0;
								foreach ($_SESSION['carrito'] as $key):
									$Total=$Total+$key['SubTotal'];
								endforeach;
								$newfecha=explode('/', $_POST['fecha']);
								$year=substr($newfecha[2],0,4);
								$mes=$newfecha[1];
								$dia=$newfecha[0];
								$fecha=$year.'-'.$mes.'-'.$dia;

								$objcomp->Ruc=rtrim($_POST['ruc']);
								$objcomp->Serie=rtrim($_POST['serie']);
								$objcomp->NumComp=rtrim($_POST['numero']);
								$objcomp->Fecha=$fecha;
								$objcomp->MontoTotal=$Total;
								$mensaje1=$objcomp->Add_Compras();

								foreach ($_SESSION['carrito'] as $key) {
									$objcomp->IdP=$key['Id'];
									$objcomp->P_Compra=$key['Precio'];
									$objcomp->Cantidad=$key['Cantidad'];
									$objcomp->SubTotal=$key['SubTotal'];
									$objcomp->Igv=$key['Igv'];
									$mensaje2=$objcomp->Add_DetalleCompras();
								}

								if($mensaje2==$mensaje1):
									unset($_SESSION['carrito']);
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
	</div>
	<?php require_once 'inc/footer.php'; ?>
</body>
</html>
<?php 
else:
	header( 'Location: ../' );
endif;
?>