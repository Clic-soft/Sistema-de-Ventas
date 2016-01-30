<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');

class Ventas
{
	public $id;
	public $id_cliente;
	public $forma_pago;
	public $prefijo;
	public $numero;
	public $nactual;
	public $nactualact;
	public $fechaactual;
	
	public $tipo;
	public $monto;

	//Datos detalle de venta
	public $IdP;
	public $PVenta;
	public $Cantidad;
	public $SubTotal;
	public $Igv;

	private $List_Ventas;
	private $List_clientes;
	private $List_Productos;
	private $List_detalles;


	function __construct()
	{
		$this->List_Ventas=array();
		$this->List_clientes=array();
		$this->List_Productos=array();
		$this->List_detalles=array();
		
	}

	function getVentas()
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"SELECT e.*,c.razon_social FROM encabezado_venta as e, clientes as c WHERE e.id_cliente=c.id ");
		while($fila=mysqli_fetch_array($query)):
			$this->List_Ventas[]=$fila;
		endwhile;
		return $this->List_Ventas;
	}

	function getClientes()
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"SELECT c.* FROM clientes as c order by c.razon_social asc");
		while($fila=mysqli_fetch_array($query)):
			$this->List_clientes[]=$fila;
		endwhile;
		return $this->List_clientes;
	}

	function get_detalles_ventas($id)
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"SELECT d.*,p.producto,u.simbolo FROM detalle_ventas as d, productos as p, unidades_medida as u WHERE p.id=d.id_producto and u.id=p.id_und_medida and id_venta=$id");
		while($fila=mysqli_fetch_array($query)):
			$this->List_detalles[]=$fila;
		endwhile;
		return $this->List_detalles;
	}

	public function get_venta_id($id)
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"SELECT * FROM encabezado_venta WHERE id=$id");
		$fila=mysqli_fetch_array($query);
		return $fila;
	}

	function getProductos()
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"SELECT p.*,u.simbolo FROM productos as p, unidades_medida as u Where p.id_und_medida=u.id");
		while($fila=mysqli_fetch_array($query)):
			$this->List_Productos[]=$fila;
		endwhile;
		return $this->List_Productos;
	}

	public function get_detalle_venta_id($id)
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"SELECT * FROM detalle_ventas WHERE id=$id");
		$fila=mysqli_fetch_array($query);
		return $fila;
	}

	function Add_EncabezadoVenta()
	{
		$this->fechaactual = date("Y-m-d H:i:s");
		require 'conexion.php';

		if($this->forma_pago ==1){

		$query3=mysqli_query($conexion,"SELECT p.* FROM prefijos as p WHERE id=1");
		$numcomp=mysqli_fetch_array($query3);
		$this->prefijo=$numcomp[2];
		$this->numero=$numcomp[4];

		}else if($this->forma_pago ==2){

		$query3=mysqli_query($conexion,"SELECT p.* FROM prefijos as p WHERE id=2");
		$numcomp=mysqli_fetch_array($query3);
		$this->prefijo=$numcomp[2];
		$this->numero=$numcomp[4];
		}

		$this->nactual=$this->numero+1;

		$query4=mysqli_query($conexion,"CALL act_consecutivo('$this->nactual', '$this->prefijo')");
		$query=mysqli_query($conexion,"CALL Reg_Ventasencabezado('$this->prefijo', '$this->numero','$this->id_cliente','$this->forma_pago' ,'$this->fechaactual',@Mensaje)");
		$query2=mysqli_query($conexion,"SELECT @Mensaje");
		$mensaje=mysqli_fetch_array($query2);
		return $mensaje[0];
	}


	function act_encventa()
	{
		$this->fechaactual = date("Y-m-d H:i:s");
		require 'conexion.php';
		$query=mysqli_query($conexion,"CALL Act_Ventasencabezado('$this->id','$this->id_cliente','$this->fechaactual',@Mensaje)");
		$query2=mysqli_query($conexion,"SELECT @Mensaje");
		$mensaje=mysqli_fetch_array($query2);
		return $mensaje[0];
	}


	function Add_DetalleVentas()
	{
		require 'conexion.php';
		$codigo=$this->getcodigoventa();
		$query=mysqli_query($conexion,"CALL Reg_DetalleVentas('$codigo','$this->IdP','$this->PVenta','$this->Cantidad',
			'$this->SubTotal','$this->Igv',@Mensaje)");
		$query2=mysqli_query($conexion,"SELECT @Mensaje");
		$mensaje=mysqli_fetch_array($query2);
		return $mensaje[0];
	}
}
?>