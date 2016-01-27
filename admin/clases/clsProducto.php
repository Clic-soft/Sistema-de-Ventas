<?php 
class Producto
{
	public $id;
	public $producto;
	public $unidad_medida;
	public $precio;
	public $RutaImagen;

	private $List_Productos;
	private $List_unidades;
	private $List_Reporte;
	private $List_Reporte2;

	function __construct()
	{
		$this->List_Productos=array();
		$this->List_unidades=array();
	}

	public function get_Productos()
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"SELECT p.*,u.simbolo FROM productos as p, unidades_medida as u Where p.id_und_medida=u.id");
		while($fila=mysqli_fetch_array($query)):
			$this->List_Productos[]=$fila;
		endwhile;
		return $this->List_Productos;
	}

	public function get_und_medida()
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"SELECT * FROM unidades_medida");
		while($fila=mysqli_fetch_array($query)):
			$this->List_unidades[]=$fila;
		endwhile;
		return $this->List_unidades;
	}

	public function get_productos_id($id)
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"SELECT * FROM productos WHERE id=$id");
		$fila=mysqli_fetch_array($query);
		return $fila;
	}

	public function Add_Productos()
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"CALL Reg_Producto('$this->producto','$this->unidad_medida',
			'$this->precio','$this->RutaImagen', @Mensaje)");
		 echo "CALL Reg_Producto('$this->producto','$this->unidad_medida',
			'$this->precio','$this->RutaImagen', @Mensaje)";
		$query2=mysqli_query($conexion,"SELECT @Mensaje");
		$mensaje=mysqli_fetch_array($query2);
		return $mensaje[0];
	}

	public function Update_Productos()
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"CALL Act_Producto('$this->id','$this->producto','$this->unidad_medida',
			'$this->precio','$this->RutaImagen',, @Mensaje)");
		$query2=mysqli_query($conexion,"SELECT @Mensaje");
		$mensaje=mysqli_fetch_array($query2);
		return $mensaje[0];
	}
}

?>