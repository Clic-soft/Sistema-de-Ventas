<?php 
	include_once '../clases/conexion.php';
	$mensajeOk=false;
	$mensajeError="No se pudo ejecutar la aplicación";
	
	$usuario=trim($_POST['usuario']);
	$pass=trim($_POST['pass']);
	if(!empty($usuario) && !empty($pass)):
		if(!empty($usuario)):
			if(!empty($pass)):
				if(isset($usuario)){
					$email=mysqli_query($conexion,"Select * From usuarios Where usuario='$usuario'");
					$mensaje='ok';
				}

						
				if($mensaje=='ok'):
					if(mysqli_num_rows($email)>0):
						$query=mysqli_query($conexion,"Select * From usuarios Where usuario='$usuario' And pass='".md5($pass)."'");
						$fila=mysqli_fetch_array($query);
						if(mysqli_num_rows($query)>0):
							if($fila[3]!="Inactivo"):
								$mensajeOk=true;
								session_start();
								$_SESSION['id']=$fila[0];
								$_SESSION['Usuario']=$fila[1];
								$_SESSION['estado']=$fila[3];
								$mensajeError="Logueado correctamente.";
							else:
								$mensajeError="El usuario se encuantra inactivo.";
							endif;
						else:
							$mensajeError="Contraseña incorrecta.";
						endif;
					else:

							$mensajeError="El usuario ingresado no existe.";
					endif;
				else:
					$mensajeError='El usuario ingresado no válido, verifique';
				endif;
			else:
				$mensajeError="Ingrese su contraseña";
			endif;
		else:
			$mensajeError="Ingrese su usuario";
		endif;
	else:
		$mensajeError="Todos los campos son obligatorios";
	endif;
	$salidaJson=array('respuesta' => $mensajeOk,'mensaje' => $mensajeError);
	echo json_encode($salidaJson);

?>