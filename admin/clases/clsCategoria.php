<?php 
class Categoria 
{
	public $IdCateg;
	public $descripcion;
	private $List_Categoria;

	public function __construct()
	{
		$this->List_Categoria=array();
	}

	public function get_Categoria(){
		require('conexion.php');
		$query=mysqli_query($conexion,"SELECT * FROM Categoria");
		while($fila=mysqli_fetch_array($query)):
			$this->List_Categoria[]=$fila;
		endwhile;
		return $this->List_Categoria;
	}

	public function get_categoria_id($id){
		require('conexion.php');
		$query=mysqli_query($conexion,"SELECT Descripcion FROM Categoria WHERE IdC='$id'");
		$fila=mysqli_fetch_array($query);
		return $fila;
	}

	public function Add_Categoria(){
		require('conexion.php');
		$query=mysqli_query($conexion,"CALL Reg_Categoria('$this->descripcion', @Mensaje)");
		$query2=mysqli_query($conexion,"SELECT @Mensaje");
		$mensaje=mysqli_fetch_array($query2);
		return $mensaje[0];
	}

	public function Update_Categoria(){
		require('conexion.php');
		$query=mysqli_query($conexion,"CALL Act_Categoria('$this->IdCateg','$this->descripcion',@Mensaje)");
		$query2=mysqli_query($conexion,"SELECT @Mensaje");
		$mensaje=mysqli_fetch_array($query2);
		return $mensaje[0];
	}
}
?>