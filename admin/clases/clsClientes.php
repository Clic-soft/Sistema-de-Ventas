<?php

class Clientes
{
	public $DNI;
	public $nombre;
	public $tipo;
	public $direccion;
	public $telefono;
	public $email;

	private $List_Clientes;
	
	function __construct()
	{
		$this->List_Clientes=array();
	}

	public function getClientes()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT * FROM Cliente");
		while($fila=mysqli_fetch_array($query)):
			$this->List_Clientes[]=$fila;
		endwhile;
		return $this->List_Clientes;
	}

	public function getClienteporId($dni)
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT * FROM Cliente where DNIRUC='$dni'");
		$fila=mysqli_fetch_array($query);
		return $fila;
	}

	public function Add_Clientes()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"CALL Reg_Cliente('$this->DNI','$this->tipo','$this->nombre',
			'$this->direccion','$this->telefono','$this->email',@Mensaje)");
		$query2=mysqli_query($conexion,"SELECT @Mensaje");
		$mensaje=mysqli_fetch_array($query2);
		return $mensaje[0];
	}

	public function Update_Cliente()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"CALL Act_Cliente('$this->DNI','$this->tipo','$this->nombre',
			'$this->direccion','$this->telefono','$this->email',@Mensaje)");
		$query2=mysqli_query($conexion,"SELECT @Mensaje");
		$mensaje=mysqli_fetch_array($query2);
		return $mensaje[0];
	}
}
?>