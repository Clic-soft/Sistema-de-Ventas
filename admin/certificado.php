<?php session_start(); ?>
<?php if(isset($_SESSION["Usuario"])):?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Sistema - Compras</title>
	<?php require_once 'inc/header.php'; ?>
	<link rel="stylesheet" type="text/css" href="css/certificado.css">
	<style type="text/css">
	.panel-body div{
		margin:5px 0;
	}
	</style>
</head>
<body>
	<?php require_once 'inc/menu-l.php'; ?>
	<script type="text/javascript">
		$("#certificado").addClass("active");					
	</script>

	<div>
	<div class="container-fluid col-md-10 col-md-offset-2">
		<div class="row">
			<div class="space"></div>
				<div class="col-xs-12 col-md-2 col-pr-2">
					<img class="img-responsive" src="images/minera.png">
				</div>
				<div class="col-xs-12 col-md-10 col-pr-10">
					<p class="txt-center title">VICEPRESIDENCIA DE SEGUIMIENTO CONTROL Y SEGURIDAD MINERA</p>
					<p class="txt-center">Grupo de Regalías y Contraprestaciones Económicas</p>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid col-md-10 col-md-offset-2">
		<div class="row">
			<div class="space"></div>
			<div class="cont col-pr-12">
				<div class="panel panel-default">
					<div class="panel-heading">
				    	<h3 class="txt-center title panel-title">CERTIFICADO DE ORIGEN EXPLOTADOR MINERO AUTORIZADO</h3>
				  	</div>
				  	<div class="panel-body">
				    	<div class="col-xs-12 col-md-4 col-pr-4">
				    		<div class="col-xs-3">
				    			<p class="txt-center">FECHA</p>
				    		</div>
				    		<div class="col-xs-9">
				    			<table class='table  table-bordered table-hover table-condensed' id="Tabla-Categoria">
									<thead class="alert alert-info text-head">
										<tr>
											<th>DD</th>
											<th>MM</th>
											<th>AAAA</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<input class="col-xs-12" type="text" />
											</td>
											<td>
												<input class="col-xs-12" type="text" />
											</td>
											<td>
												<input class="col-xs-12" type="text" />
											</td>
										</tr>
									</tbody>
								</table>
				    		</div>
				    	</div>
				    	<div class="col-xs-12 col-md-8 col-pr-8">
				    		<label for="" class="control-label col-xs-12 col-md-5 col-pr-5">No. Consecutivo del certificado de origen</label>
                            <div class="col-xs-12 col-md-7 col-pr-7">
                                <textarea class="form-control" requerid></textarea>
                            </div>
				    	</div>
				  	</div>
				</div>
				
				<!-- Inicia INFORMACIÓN DEL PRODUCTOR DEL MINERAL --> 

				<div class="panel panel-default">
					 <div class="panel-heading">
						<h3 class="title text-center panel-title">INFORMACIÓN DEL PRODUCTOR DEL MINERAL</h3>
					</div>
					<div class="panel-body">
					    <div class="col-xs-12 col-md-4 col-pr-4">
					    	<p class=" text-center"><strong>EXPLOTADOR MINERO AUTORIZADO</strong></p>
					    	<p class="text-center">(Seleccione una opción)</p>
					    </div>
					    <div class="col-xs-12 col-md-8 col-pr-8">

					    	<div class="col-xs-6 col-md-6 col-pr-6">
					    		<div>
					    			<label class="control-label col-xs-10 col-pr-10"><strong>Titular minero</strong></label class="control-label col-xs-7">
					    			<div class="col-xs-1">
					    				<input type="checkbox" name="titular_minero" />
					    			</div>
					    		</div>
					    		
					    		<div>
					    			<label class="label-control col-xs-10 col-pr-10"><strong>Beneficiario de Área de Reserva Especial</strong></label>
					    			<div class="col-xs-1">
					    				<input type="checkbox" />
					    			</div>
					    		</div>

					    	</div>
					    	<div class="col-xs-6 col-md-6 col-pr-6">
					    		<div>
					    			<label class="label-control col-xs-10 col-pr-10"><strong>Solicitante de  Legalización</strong></label>
					    			<div class="col-xs-1">
					    				<input type="checkbox" />
					    			</div>
					    		</div>
					    		
					    		<div>
					    			<label class="label-control col-xs-10 col-pr-10"><strong>Subcontrato de  Formalización</strong></label>
					    			<div class="col-xs-1">
					    				<input type="checkbox" />
					    			</div>
					    		</div>
					    	</div>	

					</div>

					    <div class="col-xs-12">
					    	<label for="" class="control-label col-xs-12 col-md-5 col-pr-5">CÓDIGO EXPEDIENTE</label>
                        	<div class="col-xs-12 col-md-7 col-pr-7">
                           		<input type="text" class="form-control" requerid />
                        	</div>
					    </div>

					    <div class="col-xs-12">
					    	<label for="" class="control-label col-xs-12 col-md-5 col-pr-5">NOMBRES Y APELLIDOS O RAZON SOCIAL DEL EXPLOTADOR MINERO AUTORIZADO</label>
                        	<div class="col-xs-12 col-md-7 col-pr-7">
                        		<div class="text-center col-xs-6 col-md-2 col-pr-2">
                        			<input type="checkbox" />
                        			<p><strong>NIT</strong></p>
                        		</div>
                        		<div class="text-center col-xs-6 col-md-3 col-pr-3">
                        			<input type="checkbox" />
                        			<p><strong>CÉDULA</strong></p>
                        		</div>
                        		<div class="text-center col-xs-6 col-md-5 col-pr-5">
                        			<input type="checkbox" />
                        			<p><strong>CÉDULA DE EXTRANJERÍA</strong></p>
                        		</div>
                        		<div class="text-center col-xs-6 col-md-2 col-pr-2">
                        			<input type="checkbox" />
                        			<p><strong>RUT</strong></p>
                        		</div>
                        	</div>
					    </div>


					    <div class="col-xs-12">
					    	<label for="" class="control-label col-xs-12 col-md-5 col-pr-5">No. DOCUMENTO DE IDENTIDAD  DEL EXPLOTADOR MINERO AUTORIZADOR</label>
                        	<div class="col-xs-12 col-md-7 col-pr-7">
                           		<input type="text" class="form-control" requerid />
                        	</div>
					    </div>


					    <div class="col-xs-12">
					    	<label for="" class="control-label col-xs-12 col-md-5 col-pr-5">DEPARTAMENTO (S) DONDE REALIZA LA EXPLOTACIÓN</label>
                        	<div class="col-xs-12 col-md-7 col-pr-7">
                           		<input type="text" class="form-control" requerid />
                        	</div>
					    </div>


					    <div class="col-xs-12">
					    	<label for="" class="control-label col-xs-12 col-md-5 col-pr-5">MINERAL EXPLOTADO</label>
                        	<div class="col-xs-12 col-md-7 col-pr-7">
                           		<input type="text" class="form-control" requerid />
                        	</div>
					    </div>


					    <div class="col-xs-12">
					    	<label for="" class="control-label col-xs-12 col-md-5 col-pr-5">CANTIDAD MINERAL COMERCIALIZADO</label>
                        	<div class="col-xs-12 col-md-7 col-pr-7">
                           		<input type="text" class="form-control" requerid />
                        	</div>
					    </div>


					    <div class="col-xs-12">
					    	<label for="" class="control-label col-xs-12 col-md-5 col-pr-5">UNIDAD DE MEDIDA</label>
                        	<div class="col-xs-12 col-md-7 col-pr-7">
                           		<input type="text" class="form-control" requerid />
                        	</div>
					    </div>
					</div>
				</div>


				<!-- Termina INFORMACIÓN DEL PRODUCTOR DEL MINERAL  -->

				<!-- iNICIA INFORMACIÓN DEL COMPRADOR DEL MINERAL -->

				<div class="panel panel-default">
				  	<div class="panel-heading">
				    	<h3 class="text-center title panel-title">INFORMACIÓN DEL COMPRADOR DEL MINERAL</h3>
				  	</div>
				  	<div class="panel-body">
						<div class="col-xs-12">
					    	<label for="" class="control-label col-xs-12 col-md-5 col-pr-5">NOMBRES Y APELLIDOS O RAZON SOCIAL</label>
                        	<div class="col-xs-12 col-md-7 col-pr-7">
                           		<input type="text" class="form-control" requerid />
                        	</div>
					    </div>

						<div class="col-xs-12">
					    	<label for="" class="control-label col-xs-12 col-md-5 col-pr-5">COMPRADOR (Seleccione una opción)</label>
                        	<div class="col-xs-12 col-md-7 col-pr-7">
                           		<input type="text" class="form-control" requerid />
                        	</div>
					    </div>

					    <div class="col-xs-12">
					    	<label for="" class="control-label col-xs-12 col-md-5 col-pr-5">No. DOCUMENTO DE IDENTIDAD</label>
                        	<div class="col-xs-12 col-md-7 col-pr-7">
                           		<input type="text" class="form-control" requerid />
                        	</div>
					    </div>					    
					    
					    <div class="col-xs-12">
					    	<label for="" class="control-label col-xs-12 col-md-5 col-pr-5">No. RUCOM</label>
                        	<div class="col-xs-12 col-md-7 col-pr-7">
                           		<input type="text" class="form-control" requerid />
                        	</div>
					    </div>
		    	    </div>
				</div>

				<!-- TERMINA INFORMACIÓN DEL COMPRADOR DEL MINERAL -->
			</div>
		</div>
	</div>
</body>
</html>
<?php 
else:
	header( 'Location: ../' );
endif;
?>