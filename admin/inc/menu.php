<?php require_once 'clases/clsReportes.php'; 
$repor=new Reporte();
?>
				<ul class="nav nav-pills nav-stacked nav-left">
					<div>
						<a 	href="./">Sistema - Tienda</a>
					</div>
					<li class="dropdown">
	                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="border-right: none;">
	                        <span class="glyphicon glyphicon-user"></span> 
	                        <strong>Perfil</strong>
	                    </a>
	                    <ul class="dropdown-menu">
	                        <li>
	                            <div class="navbar-login">
	                                <div class="row">
	                                    <div class="col-lg-4">
	                                        <p class="text-center">
	                                            <span class="glyphicon glyphicon-user icon-size"></span>
	                                        </p>
	                                    </div>
	                                    <div class="col-lg-8">
	                                        <p class="text-left"><strong><?=$_SESSION['Usuario']?></strong></p>
	                                        <p class="text-left"><strong><?=$_SESSION['Tipo']?></strong></p>
	                                        <p class="text-left small"><?=$_SESSION['Email']?></p>
	                                    </div>
	                                </div>
	                            </div>
	                        </li>
	                        <li class="divider"></li>
	                        <li>
	                            <div class="navbar-login navbar-login-session">
	                                <div class="row">
	                                    <div class="col-lg-12">
	                                    	<p class="text-left">
	                                            <a href="profile.php" class="btn btn-primary btn-block">Actualizar Datos</a>
	                                        </p>
	                                        <p>
	                                            <a href="inc/CerrarSesion.php" class="btn btn-danger btn-block">Cerrar Sesion</a>
	                                        </p>
	                                    </div>
	                                </div>
	                            </div>
	                        </li>
	                    </ul>
	                </li>
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