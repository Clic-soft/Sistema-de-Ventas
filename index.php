<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sistema Facturación - Arenera Riopaila</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>

	<div class="container login-top">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 login-panel">
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 login-panel">
			<div class="panel panel-info">
				<div class="panel-heading text-center">
					<strong>Iniciar Sesión</strong>
				</div>
				<div class="panel-body">
					<form  class= "form-horizontal"  role= "form" name="f1" method="post"> 
						<div  class= "form-group">
							<div  class= "col-sm-12" >
								<div class="input-group" align="center">
									<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
									<input type="text" class="form-control" placeholder="USUARIO" id="email" name="usuario">
								</div>
							</div> 
						</div> 
						<div  class= "form-group" > 
							<div  class= "col-sm-12" > 
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
									<input type="password" class="form-control" placeholder="CONTRASEÑA" id="contrasena" name="contrasena">
								</div>
							</div> 
						</div> 
						<div  class = "forma -group " > 
							<div  class = "col-sm-12 text-center">
								<button type="button" class="btn btn-primary" id="iniciar">
									<i class="glyphicon glyphicon-off"></i>&nbsp; Iniciar Sesión 
								</button>
							</div> 
						</div> 
					</form>    
				</div>
				<div class="panel-footer" id="mensaje"></div>
			</div>
		</div>
	</div>
</div>

	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/script-login.js"></script>
</body>
</html>