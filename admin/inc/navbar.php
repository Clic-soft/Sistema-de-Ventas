	<nav role="navigation" class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div>
				<a href="./" class="navbar-brand">Sistema - Tienda</a>
	    	</div>
	    	<!--<div class="navbar-collapse collapse">-->
	    	<div>
				<ul class="nav navbar-nav nav-right">
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
				</ul>
	    	</div>
		</div>
	</nav>