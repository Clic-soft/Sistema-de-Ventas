<?php
class Reporte
{
	private $ventas;
	private $stockminimo;
	private $List_Reporte;
	private $List_Reporte2;
	private $Print_comprobante;
	
	function __construct()
	{
		$this->ventas=array();
		$this->stockminimo=array();
		$this->List_Reporte=array();
		$this->List_Reporte2=array();
		$this->Print_Comprobante=array();
	}

	public function PrintComprobante($num,$tipo)
	{
		require('conexion.php');
		$query=mysqli_query($conexion,"SELECT * FROM Comprobante WHERE NumComp='$num' AND TipoDoc='$tipo'");
		while($fila=mysqli_fetch_array($query)):
			$this->Print_comprobante[]=$fila;
		endwhile;
		return $this->Print_comprobante;
	}

	public function getdatosCliente($num,$tipo)
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,
			"SELECT C.DNIRUC,C.NombreCliente,C.Direccion 
			FROM Cliente C INNER JOIN Ventas V ON C.DNIRUC=V.DNIRUC
			WHERE V.NumComp='$num' AND V.TipoDoc='$tipo'");
		$fila=mysqli_fetch_array($query);
		return $fila;
	}

	//Rerporte ok
	public function Productos_vendidos_por_mes($mes,$year)
	{
		require('conexion.php');
		$query=mysqli_query($conexion,
			"SELECT * FROM Reporte1 WHERE MONTH(Fecha)='$mes' AND YEAR(Fecha)='$year' ORDER BY TotalVentas DESC");

		while($row=mysqli_fetch_array($query)):
			$this->List_Reporte[]=$row;
		endwhile;
		return $this->List_Reporte;
	}

	public function getEgresosmensual($year)
	{
		$meses=$this->meses();
		require('conexion.php');
		$query=mysqli_query($conexion,"SELECT DISTINCT(MONTH(Fecha)) Mes, SUM(MontoTotal) MontoTotal 
			FROM Compras WHERE YEAR(Fecha)='$year' GROUP BY Fecha");

		while($fila=mysqli_fetch_array($query)):
			for($mes=1; $mes<=12; $mes++):
				if($fila[0]==$mes)
					$arrayName[] = array('Mes' => $meses[$mes], 'Monto'=>$fila[1]);
			endfor;
		endwhile;
		return $arrayName;
	}

	function getVentas()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT DISTINCT(YEAR(Fecha)) YEAR, SUM(MontoTotal) MontoTotal 
			FROM Ventas GROUP BY Fecha");
		while($fila=mysqli_fetch_array($query)):
			$this->ventas[]=$fila;
		endwhile;
		return $this->ventas;
	}

	//Rerporte ok
	function getVentasMensual($year)
	{
		$meses=$this->meses();
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT DISTINCT(MONTH(Fecha)) Mes, SUM(MontoTotal) MontoTotal 
			FROM Ventas WHERE YEAR(Fecha)='$year' GROUP BY Fecha");
		while($fila=mysqli_fetch_array($query)):
			for($mes=1; $mes<=12; $mes++):
				if($fila[0]==$mes)
					$arrayName[] = array('Mes' => $meses[$mes], 'Monto'=>$fila[1]);
			endfor;
		endwhile;
		return $arrayName;
	}

	function getStockminimo()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT * FROM StockMinimo");
		while($fila=mysqli_fetch_array($query)):
			$this->stockminimo[]=$fila;
		endwhile;
		return $this->stockminimo;
	}


	function meses()
	{
		$meses = array(); 
		$meses[1] = "Enero"; 
		$meses[2] = "Febrero"; 
		$meses[3] = "Marzo";
		$meses[4] = "Abril"; 
		$meses[5] = "Mayo"; 
		$meses[6] = "Junio";
		$meses[7] = "Julio";
		$meses[8] = "Agosto";
		$meses[9] = "Septiembre";
		$meses[10] = "Octubre";
		$meses[11] = "Noviembre";
		$meses[12] = "Diciembre";
		return $meses;
	}

	function devolvermesletras($valor)
	{
		$meses=$this->meses();
		for($mes=1; $mes<=12; $mes++):
			if ($valor == $mes)
				return $meses[$mes];
		endfor;
	}

	function devolvermesactual()
	{
		$meses=$this->meses();
		for($mes=1; $mes<=12; $mes++):
			if (date('m') == $mes)
				return $meses[$mes];
		endfor;
	}

	function numprov()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT * FROM Proveedor");
		if(empty($query))
			$num=0;
		else
			$num=mysqli_num_rows($query);
		return $num;
	}
	function numprod()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT * FROM Producto");
		if(empty($query))
			$num=0;
		else
			$num=mysqli_num_rows($query);
		return $num;
	}

	function numpres()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT * FROM Presentacion");
		if(empty($query))
			$num=0;
		else
			$num=mysqli_num_rows($query);
		return $num;
	}

	function numcateg()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT * FROM Categoria");
		if(empty($query))
			$num=0;
		else
			$num=mysqli_num_rows($query);
		return $num;
	}

	function numusuario()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT * FROM Usuario");
		if(empty($query))
			$num=0;
		else
			$num=mysqli_num_rows($query);
		return $num;
	}
	function numcompras()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT * FROM Compras");
		if(empty($query))
			$num=0;
		else
			$num=mysqli_num_rows($query);
		return $num;
	}
	function numclientes()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT * FROM Cliente");
		if(empty($query))
			$num=0;
		else
			$num=mysqli_num_rows($query);
		return $num;
	}

	function numventas()
	{
		require 'conexion.php';
		$query=mysqli_query($conexion,"SELECT * FROM Ventas WHERE DAY(Fecha)=DAY(NOW())");
		if(empty($query))
			$num=0;
		else
			$num=mysqli_num_rows($query);
		return $num;
	}
}
/*
$b=new Reporte();
echo $b->numcateg();*/
?>