<?php
class Ventas
{
	public $dni;
	public $serie;
	public $numero;
	public $fecha;
	public $tipo;
	public $monto;

	//Datos detalle de venta
	public $IdP;
	public $PVenta;
	public $Cantidad;
	public $SubTotal;
	public $Igv;

	function __construct()
	{
		
	}

	function getSerie()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT NumComp FROM Ventas");
		$NumComp=mysqli_fetch_array($query);
		if(rtrim($NumComp[0])<999999)
			$serie='001';
		else
			$serie='002';			

		return $serie;
	}

	function getNumComprobante()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT MAX(NumComp) FROM Ventas WHERE TipoDoc='Boleta'");
		$numcomp=mysqli_fetch_array($query);
		if(empty($numcomp[0]))
			$numcomp='0000001';
		

		if(!empty($numcomp[0])):
			if($numcomp[0]<10)
				$numcomp='000000'.($numcomp[0]+1);
			else if($numcomp[0]<100)
				$numcomp='00000'.($numcomp[0]+1);
			else if($numcomp[0]<1000)
				$numcomp='0000'.($numcomp[0]+1);
			else if($numcomp[0]<10000)
				$numcomp='000'.($numcomp[0]+1);
			else if($numcomp[0]<100000)
				$numcomp='00'.($numcomp[0]+1);
			else if($numcomp[0]<1000000)
				$numcomp='0'.($numcomp[0]+1);
			else if($numcomp[0]<10000000)
				$numcomp=($numcomp[0]+1);

		endif;

		return $numcomp;
	}

	function Add_Ventas()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"CALL Reg_Ventas('$this->dni','$this->serie','$this->numero',
			'$this->fecha','$this->tipo','$this->monto',@Mensaje)");
		$query2=mysqli_query($conexion,"SELECT @Mensaje");
		$mensaje=mysqli_fetch_array($query2);
		return $mensaje[0];
	}

	function getcodigoventa()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT MAX(IdV) FROM Ventas");
		$fila=mysqli_fetch_array($query);
		return $fila[0];
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