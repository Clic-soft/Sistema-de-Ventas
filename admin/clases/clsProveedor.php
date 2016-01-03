<?php
class Proveedores
{
	public $ruc;
	public $razonsocial;
	public $direccion;
	public $telefono;
	public $email;
	private $List_Proveedores;

	function __construct()
	{
		$this->List_Proveedores=array();
	}

	public function get_Proveedores()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT * FROM Proveedor");
		while($fila=mysqli_fetch_array($query)):
			$this->List_Proveedores[]=$fila;
		endwhile;
		return $this->List_Proveedores;
	}

	public function get_proveedores_ruc($ruc)
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"SELECT * FROM Proveedor WHERE Ruc='$ruc'");
		$fila=mysqli_fetch_array($query);
		return $fila;
	}

	public function Add_Proveedor()
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"CALL Reg_Proveedor('$this->ruc','$this->razonsocial','$this->direccion',
			'$this->telefono','$this->email', @Mensaje)");
		$query2=mysqli_query($conexion,"SELECT @Mensaje");
		$mensaje=mysqli_fetch_array($query2);
		return $mensaje[0];
	}

	public function Update_Proveedor()
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"CALL Act_Proveedor('$this->ruc','$this->razonsocial','$this->direccion',
			'$this->telefono','$this->email', @Mensaje)");
		$query2=mysqli_query($conexion,"SELECT @Mensaje");
		$mensaje=mysqli_fetch_array($query2);
		return $mensaje[0];
	}

}
?>