<?php
class Compras
{
	//Datos de la compra
	public $Ruc;
	public $Serie;
	public $NumComp;
	public $Fecha;
	public $MontoTotal;

	//Datos del detalle de compra
	public $IdComp;
	public $IdP;
	public $P_Compra;
	public $Cantidad;
	public $SubTotal;
	public $Igv;
	
	function __construct()
	{

	}

	public function Add_Compras()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"CALL Reg_Compras('$this->Ruc','$this->Serie','$this->NumComp',
			'$this->Fecha','$this->MontoTotal',@Mensaje)");
		$query2=mysqli_query($conexion,"SELECT @Mensaje");
		$mensaje=mysqli_fetch_array($query2);
		return $mensaje[0];
	}

	function getcodigocompra()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT MAX(IdComp) FROM Compras");
		$fila=mysqli_fetch_array($query);
		return $fila[0];
	}

	public function Add_DetalleCompras()
	{
		require 'conexion.php';
		$codigo=$this->getcodigocompra();
		$query=mysqli_query($conexion,"CALL Reg_DetalleCompra('$codigo','$this->IdP','$this->P_Compra',
			'$this->Cantidad','$this->SubTotal','$this->Igv',@Mensaje)");
		$query2=mysqli_query($conexion,"SELECT @Mensaje");
		$mensaje=mysqli_fetch_array($query2);
		return $mensaje[0];
	}
}
?>