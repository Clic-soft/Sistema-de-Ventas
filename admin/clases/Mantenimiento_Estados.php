<?php
	$mensajeOk=false;
	$mensajeError="No se pudo ejecutar la aplicación";
	if(isset($_POST['IdTabla']) and !empty($_POST['IdTabla'])):
		require('conexion.php');
		$Id=$_POST['IdTabla'];

		switch ($_POST['Accion']):
			case 'EU':
				$consulta=mysqli_query($conexion,"SELECT Estado FROM Usuario WHERE IdU='$Id'");
				$resultado=mysqli_fetch_array($consulta);
				if($resultado[0]=='Activo'):
					$query=mysqli_query($conexion,"UPDATE Usuario Set Estado='Inactivo' Where IdU='$Id'");
					if($query==true):
						$mensajeOk=true;
					else:
						$mensajeOk=false;
					endif;
				else:
					$query=mysqli_query($conexion,"UPDATE Usuario Set Estado='Activo' Where IdU='$Id'");
					if($query==true):
						$mensajeOk=true;
					else:
						$mensajeOk=false;
					endif;
				endif;
				break;

			case 'EC':
				$consulta=mysqli_query($conexion,"SELECT Estado FROM Categoria WHERE IdC='$Id'");
				$resultado=mysqli_fetch_array($consulta);
				if($resultado[0]=='Activo'):
					$query=mysqli_query($conexion,"Update Categoria Set Estado='Inactivo' Where IdC='$Id'");
					if($query==true):
						$mensajeOk=true;
					else:
						$mensajeOk=false;
					endif;
				else:
					$query=mysqli_query($conexion,"Update Categoria Set Estado='Activo' Where IdC='$Id'");
					if($query==true):
						$mensajeOk=true;
					else:
						$mensajeOk=false;
					endif;
				endif;
				break;

				case 'EProv':
				$consulta=mysqli_query($conexion,"SELECT Estado FROM Proveedor WHERE Ruc='$Id'");
				$resultado=mysqli_fetch_array($consulta);
				if($resultado[0]=='Activo'):
					$query=mysqli_query($conexion,"Update Proveedor Set Estado='Inactivo' Where Ruc='$Id'");
					if($query==true):
						$mensajeOk=true;
					else:
						$mensajeOk=false;
					endif;
				else:
					$query=mysqli_query($conexion,"Update Proveedor Set Estado='Activo' Where Ruc='$Id'");
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