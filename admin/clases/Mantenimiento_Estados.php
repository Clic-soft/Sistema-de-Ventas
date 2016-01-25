<?php
	$mensajeOk=false;
	$mensajeError="No se pudo ejecutar la aplicación";
	if(isset($_POST['IdTabla']) and !empty($_POST['IdTabla'])):
		require('conexion.php');
		$Id=$_POST['IdTabla'];

		switch ($_POST['Accion']):
			case 'EU':
				$consulta=mysqli_query($conexion,"SELECT estado FROM usuarios WHERE id='$Id'");
				$resultado=mysqli_fetch_array($consulta);
				if($resultado[0]==1):
					$query=mysqli_query($conexion,"UPDATE usuarios Set Estado=2 Where id='$Id'");
					if($query==true):
						$mensajeOk=true;
					else:
						$mensajeOk=false;
					endif;
				else:
					$query=mysqli_query($conexion,"UPDATE usuarios Set Estado=1 Where id='$Id'");
					if($query==true):
						$mensajeOk=true;
					else:
						$mensajeOk=false;
					endif;
				endif;
				break;

				case 'EProv':
				$consulta=mysqli_query($conexion,"SELECT estado FROM proveedores WHERE id='$Id'");
				$resultado=mysqli_fetch_array($consulta);
				if($resultado[0]==1):
					$query=mysqli_query($conexion,"Update proveedores Set estado=2 Where id='$Id'");
					if($query==true):
						$mensajeOk=true;
					else:
						$mensajeOk=false;
					endif;
				else:
					$query=mysqli_query($conexion,"Update proveedores Set estado=1 Where id='$Id'");
					if($query==true):
						$mensajeOk=true;
					else:
						$mensajeOk=false;
					endif;
				endif;
				break;
			
			default:
				$mensajeError="Ha ocurrido algun error";
				break;
		endswitch;
	else:
		$mensajeError="El Id de categoria esta vacia, lo sentimos.";
	endif;

	$salidaJson=array('respuesta' => $mensajeOk,'mensaje' => $mensajeError);
	echo json_encode($salidaJson);
?>