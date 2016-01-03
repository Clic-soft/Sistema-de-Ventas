<?php require_once 'clases/clsReportes.php'; 
$repor=new Reporte();
?>
<script type="text/javascript">
	$('li').click(function(e) {
    	$('.nav li.active').removeClass('active');
    	var $this = $(this);
    	$this.addClass('active');
    	e.preventDefault();
    	//alert("Si funciona mamá.");
	});
</script>
				<ul class="nav nav-pills nav-stacked nav-left">
					<li id="categoria" role="presentation">
						<a  href="<?= ($_SESSION['Tipo']=='Administrador') ? "categoria.php":"#";?>">
							<i class="glyphicon glyphicon-home"></i>
							Categoría <span class="badge alert-primary pull-right">
							<i class="glyphicon glyphicon-bell"></i><?=$repor->numcateg();?></span></a>
					</li>
					<li id="presentacion"  role="presentation">
						<a  href="<?= ($_SESSION['Tipo']=='Administrador') ? "presentacion.php":"#";?>">
							<i class="glyphicon glyphicon-knight"></i> Presentación 
							<span class="badge alert-primary pull-right">
								<i class="glyphicon glyphicon-bell"></i><?=$repor->numpres();?></span>
						</a>
					</li>
					<li id="productos"  role="presentation">
						<a  href="productos.php">
							<i class="glyphicon glyphicon-bed"></i> Productos 
							<span class="badge alert-primary pull-right">
								<i class="glyphicon glyphicon-bell"></i><?=$repor->numprod();?></span>
						</a>
					</li>
					<li id="proveedores"  role="presentation">
						<a  href="<?= ($_SESSION['Tipo']=='Administrador') ? "proveedores.php":"#";?>">
							<i class="glyphicon glyphicon-scale"></i> Proveedores 
							<span class="badge alert-primary pull-right">
								<i class="glyphicon glyphicon-bell"></i><?=$repor->numprov();?></span>
						</a>
					</li>
					<li id="compras"  role="presentation">
						<a  href="<?= ($_SESSION['Tipo']=='Administrador') ? "compras.php":"#";?>">
							<i class="glyphicon glyphicon-shopping-cart"></i> Compras 
							<span class="badge alert-primary pull-right">
								<i class="glyphicon glyphicon-bell"></i>
								<?php 
									if($repor->numcompras()<9)
										echo $repor->numcompras();
									else
										echo '+ '.$repor->numcompras();
								?>
							</span>
						</a>
					</li>
					<li id="clientes"  role="presentation">
						<a  href="<?= ($_SESSION['Tipo']=='Administrador') ? "clientes.php":"#";?>">
							<i class="glyphicon glyphicon-folder-open"></i> Clientes 
							<span class="badge alert-primary pull-right">
								<i class="glyphicon glyphicon-bell"></i>
								<?php 
									if($repor->numclientes()<9)
										echo $repor->numclientes();
									else
										echo '+ '.$repor->numclientes();
								?>
							</span>
						</a>
					</li>
					<li id="ventas"  role="presentation">
						<a href="ventas.php">
							<i class="glyphicon glyphicon-credit-card"></i> Ventas 
							<span class="badge alert-primary pull-right">
								<i class="glyphicon glyphicon-bell"></i>
								<?php 
									if($repor->numventas()<9)
										echo $repor->numventas();
									else
										echo '+ '.$repor->numventas();
								?>
							</span>
						</a>
					</li>
					<li id="reportes" role="presentation">
						<a href="menureporte.php">
							<i class="glyphicon glyphicon-list-alt"></i> Reportes 
							<span class="badge alert-primary pull-right">
								<i class="glyphicon glyphicon-bell"></i>4</span>
						</a>
					</li>
					<li id="usuarios"  role="presentation">
						<a  href="<?= ($_SESSION['Tipo']=='Administrador') ? "usuarios.php":"#";?>">
							<i class="glyphicon glyphicon-user"></i> Usuarios 
							<span class="badge alert-primary pull-right">
								<i class="glyphicon glyphicon-bell"></i>
								<?php 
									if($repor->numusuario()<9)
										echo $repor->numusuario();
									else
										echo '+ '.$repor->numusuario();
								?>
							</span>
						</a>
					</li>
				</ul>