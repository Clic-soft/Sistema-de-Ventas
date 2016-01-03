<?php 
	include_once '../clases/conexion.php';
	$mensajeOk=false;
	$mensajeError="No se pudo ejecutar la aplicación";
	
	$usuario=trim($_POST['usuario']);
	$contrasena=trim($_POST['contrasena']);
	if(!empty($usuario) && !empty($contrasena)):
		if(!empty($usuario)):
			if(!empty($contrasena)):
				if(is_numeric($usuario)){
					$email=mysqli_query($conexion,"Select Celular From Usuario Where Celular='$usuario'");
					$mensaje='ok';
				}else
					if(verificarEmail($usuario)){
						$email=mysqli_query($conexion,"Select Email From Usuario Where Email='$usuario'");
						$mensaje='ok';
					}else
						$mensaje='error';

						
				if($mensaje=='ok'):
					if(mysqli_num_rows($email)>0):
						$query=mysqli_query($conexion,"Select * From Usuario 
							Where (Email='$usuario' And Contrase=md5('$contrasena')) OR 
								(Celular='$usuario' And Contrase=md5('$contrasena'))");
						$fila=mysqli_fetch_array($query);
						if(mysqli_num_rows($query)>0):
							if($fila[7]!="Inactivo"):
								$mensajeOk=true;
								session_start();
								$_SESSION['IdU']=$fila[0];
								$_SESSION['Usuario']=$fila[1].' '.$fila[2];
								$_SESSION['Tipo']=$fila[4];
								$_SESSION['Email']=$fila[5];
								$mensajeError="Logueado correctamente.";
							else:
								$mensajeError="Su cuenta ha sido bloqueada.";
							endif;
						else:
							$mensajeError="Contraseña incorrecta.";
						endif;
					else:
						if(is_numeric($usuario))
							$mensajeError="Número de celular no existe.";
						else
							$mensajeError="El e-mail no existe.";
					endif;
				else:
					$mensajeError='E-mail no válido, verifique';
				endif;
			else:
				$mensajeError="Ingrese su contraseña";
			endif;
		else:
			$mensajeError="Ingrese su email o celular";
		endif;
	else:
		$mensajeError="Todos los campos son obligatorios";
	endif;
	$salidaJson=array('respuesta' => $mensajeOk,'mensaje' => $mensajeError);
	echo json_encode($salidaJson);


	function verificarEmail($email){
		if(preg_match('#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#',$email))
			return true;
		else
			return false;
	}

	function verificarCelular($celular){
		//$expresion = '/^[9|6|7][0-9]{8}$/'; //Teléfonos que empiecen por 9,6,7
		if(preg_match('/^[9][0-9]{8}$/', $celular))
			return true;
		else
			return false;
	}

?>