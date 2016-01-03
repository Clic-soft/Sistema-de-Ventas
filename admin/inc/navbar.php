	<nav role="navigation" class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggle">
	        		<span class="sr-only">Sistema - Tienda</span>
	        		<span class="icon-bar"></span>
	        		<span class="icon-bar"></span>
	        		<span class="icon-bar"></span>
				</button>
				<a href="./" class="navbar-brand">Sistema - Tienda</a>
	    	</div>
	    	<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
	        		<li>
	        			<a href="<?= ($_SESSION['Tipo']=='Administrador') ? "categoria.php":"#";?>">
	        				<i class="glyphicon glyphicon-home"></i> Categoría
	        			</a>
	        		</li>
	        		<li>
	        			<a href="productos.php">
	        				<i class="glyphicon glyphicon-home"></i> Productos
	        			</a>
	        		</li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" 
							role="button" aria-expanded="false">
							<i class="glyphicon glyphicon-bullhorn"></i> Reportes 
							<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<?php if($_SESSION['Tipo']=='Administrador'):?>
							<li><a href="productos-mas-vendidos.php">Listado de Productos más vendidos</a></li>
							<li><a href="ingresos-mensuales.php.php">Listado de ingresos mensuales</a></li>
							<li class="divider"></li>
							
							<li><a href="productos-stock-minimo.php">Listado de productos con stock mínimo</a></li>
							<li><a href="egresos-mensuales.php">Listado de egresos mensuales</a></li>
							<?php else:?>
							<li><a href="productos-mas-vendidos.php">Listado de Productos más vendidos</a></li>
							<li><a href="productos-stock-minimo.php">Listado de productos con stock mínimo</a></li>
							<?php endif;?>
						</ul>
					</li>

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
	                                        <p class="text-center"><strong><?=$_SESSION['Tipo']?></strong></p>
	                                        <p class="text-left small"><?=$_SESSION['Email']?></p>
	                                        <p class="text-left">
	                                            <a href="profile.php" class="btn btn-primary btn-block btn-md">Actualizar Datos</a>
	                                        </p>
	                                    </div>
	                                </div>
	                            </div>
	                        </li>
	                        <li class="divider"></li>
	                        <li>
	                            <div class="navbar-login navbar-login-session">
	                                <div class="row">
	                                    <div class="col-lg-12">
	                                        <p>
	                                            <a href="inc/CerrarSesion.php" class="btn btn-danger btn-block">Cerrar Sesion</a>
	                                        </p>
	                                    </div>
	                                </div>
	                            </div>
	                        </li>
	                    </ul>
	                </li>              
				</ul>
	    	</div>
		</div>
	</nav>