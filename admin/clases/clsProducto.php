<?php 
class Producto
{
	public $IdProd;
	public $IdC;
	public $IdPre;
	public $descripcion;
	public $UnidMedida;
	public $PrecioVenta;
	public $stock=0;
	public $RutaImagen;

	private $List_Productos;
	private $List_Reporte;
	private $List_Reporte2;

	function __construct()
	{
		$this->List_Productos=array();
	}

	public function get_Productos()
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"SELECT * FROM ListadoProductos");
		while($fila=mysqli_fetch_array($query)):
			$this->List_Productos[]=$fila;
		endwhile;
		return $this->List_Productos;
	}

	public function get_productos_id($id)
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"SELECT * FROM Producto WHERE IdP='$id'");
		$fila=mysqli_fetch_array($query);
		return $fila;
	}

	public function Add_Productos()
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"CALL Reg_Producto('$this->IdC','$this->IdPre','$this->descripcion',
			'$this->UnidMedida','$this->PrecioVenta','$this->stock','$this->RutaImagen', @Mensaje)");
		$query2=mysqli_query($conexion,"SELECT @Mensaje");
		$mensaje=mysqli_fetch_array($query2);
		return $mensaje[0];
	}

	public function Update_Productos()
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"CALL Act_Producto('$this->IdProd','$this->IdC','$this->IdPre','$this->descripcion',
			'$this->UnidMedida','$this->PrecioVenta','$this->stock','$this->RutaImagen', @Mensaje)");
		$query2=mysqli_query($conexion,"SELECT @Mensaje");
		$mensaje=mysqli_fetch_array($query2);
		return $mensaje[0];
	}
}


class Presentacion
{
	public $descripcion;
	public $IdPre;
	private $List_Presentacion;

	function __construct()
	{
		$this->List_Presentacion=array();
	}

	public function get_Presentacion()
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"SELECT * FROM Presentacion");
		while($fila=mysqli_fetch_array($query)):
			$this->List_Presentacion[]=$fila;
		endwhile;
		return $this->List_Presentacion;
	}

	public function get_presentacion_id($id){
		require('conexion.php');
		$query=mysqli_query($conexion,"SELECT Descripcion FROM Presentacion WHERE IdPr='$id'");
		$fila=mysqli_fetch_array($query);
		return $fila;
	}

	public function Add_Presentacion()
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"CALL Reg_Presentacion('$this->descripcion', @Mensaje)");
		$query2=mysqli_query($conexion,"SELECT @Mensaje");
		$mensaje=mysqli_fetch_array($query2);
		return $mensaje[0];
	}

	public function Update_Presentacion()
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"CALL Act_Presentacion('$this->IdPre','$this->descripcion', @Mensaje)");
		$query2=mysqli_query($conexion,"SELECT @Mensaje");
		$mensaje=mysqli_fetch_array($query2);
		return $mensaje[0];
	}
}
?>