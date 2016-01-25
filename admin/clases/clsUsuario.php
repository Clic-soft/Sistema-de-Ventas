<?php 

class Usuarios
{
	public $id;
	public $usuario;
	public $pass;

	private $List_usuarios;

	function __construct()
	{
		$this->List_usuarios=array();
	}

	public function get_usuarios()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT id,usuario,estado FROM usuarios");
		while($fila=mysqli_fetch_array($query)):
			$this->List_usuarios[]=$fila;
		endwhile;
		return $this->List_usuarios;
	}

	public function get_usuario_id($id)
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT id,usuario,pass,estado FROM usuarios WHERE id='$id'");
		$fila=mysqli_fetch_array($query);
		return $fila;
	}

	public function Add_Usuarios()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"CALL Reg_Usuario('$this->nombres','$this->apellidos','$this->celular',
			'$this->tipo','$this->email','$this->password',@Mensaje)");
		$query2=mysqli_query($conexion,"SELECT @Mensaje");
		$mensaje=mysqli_fetch_array($query2);
		return $mensaje[0];
	}

	public function Update_Usuarios()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"CALL Act_Usuario('$this->IdU','$this->nombres','$this->apellidos','$this->celular',
			'$this->email',@Mensaje)");
		$query2=mysqli_query($conexion,"SELECT @Mensaje");
		$mensaje=mysqli_fetch_array($query2);
		return $mensaje[0];
	}
}
?>