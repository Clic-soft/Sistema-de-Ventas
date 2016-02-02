				<ul class="nav nav-pills nav-stacked nav-left">
					<div>
						<a 	href="./">Sistema - Tienda</a>
					</div>
					<li class="dropdown" style="margin-top:15px;">
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
	                                        <p class="text-left"><strong><?=$_SESSION['usuario']?></strong></p>
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

					<li id="productos"  role="presentation">
						<a  href="productos.php">
							<i class="glyphicon glyphicon-bed"></i> Productos 
							<span class="badge alert-primary pull-right">
								<i class="glyphicon glyphicon-bell"></i></span>
						</a>
					</li>


					<li id="proveedores"  role="presentation">
						<a  href="proveedores.php">
							<i class="glyphicon glyphicon-scale"></i> Proveedores 
							<span class="badge alert-primary pull-right">
								<i class="glyphicon glyphicon-bell"></i></span>
						</a>
					</li>

					<li id="compras"  role="presentation">
						<a  href="compras.php">
							<i class="glyphicon glyphicon-shopping-cart"></i> Insumos 
							<span class="badge alert-primary pull-right">
								<i class="glyphicon glyphicon-bell"></i></span>
						</a>
					</li>


					<li id="clientes"  role="presentation">
						<a  href="clientes.php">
							<i class="glyphicon glyphicon-folder-open"></i> Clientes 
							<span class="badge alert-primary pull-right">
								<i class="glyphicon glyphicon-bell"></i></span>
						</a>
					</li>

					<li id="ventas"  role="presentation">
						<a href="ventas.php">
							<i class="glyphicon glyphicon-credit-card"></i> Ventas 
							<span class="badge alert-primary pull-right">
								<i class="glyphicon glyphicon-bell"></i></span>
						</a>
					</li>
					<li id="reportes" role="presentation">
						<a href="menureporte.php">
							<i class="glyphicon glyphicon-list-alt"></i> Reportes 
							<span class="badge alert-primary pull-right">
								<i class="glyphicon glyphicon-bell"></i></span>
						</a>
					</li>
					
					<li id="usuarios"  role="presentation">
						<a  href="usuarios.php">
							<i class="glyphicon glyphicon-user"></i> Usuarios 
							<span class="badge alert-primary pull-right">
								<i class="glyphicon glyphicon-bell"></i></span>
						</a>
					</li>
					
				</ul>