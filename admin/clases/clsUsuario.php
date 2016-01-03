<?php 

class Usuarios
{
	public $IdU;
	public $nombres;
	public $apellidos;
	public $celular;
	public $tipo;
	public $email;
	public $password;

	private $List_usuarios;

	function __construct()
	{
		$this->List_usuarios=array();
	}

	public function get_usuarios()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT IdU,Nombre,Apellidos,Celular,Tipo,Email,Estado FROM Usuario");
		while($fila=mysqli_fetch_array($query)):
			$this->List_usuarios[]=$fila;
		endwhile;
		return $this->List_usuarios;
	}

	public function get_usuario_id($id)
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT Nombre,Apellidos,Celular,Tipo,Email FROM Usuario WHERE IdU='$id'");
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