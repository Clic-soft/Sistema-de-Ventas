<?php  
	$Accion=$_REQUEST['Accion'];
	if(is_callable($Accion)):
		$Accion();
	endif;

	function GetProductos(){
		include('conexion.php');
		$IdC=$_REQUEST['IdC'];
		$ListadoProductos=array();
		$consulta=mysqli_query($conexion,"SELECT IdP,CONCAT(P.Descripcion,' ',Pr.Descripcion,' ', P.UnidMedida) AS 'Descripcion' FROM Presentacion Pr INNER JOIN Producto P ON Pr.IdPr=P.IdPr 
			WHERE P.IdC='$IdC' AND P.Estado='Activo'");
		while($fila=mysqli_fetch_array($consulta)):
			$ListadoProductos[]=$fila;
		endwhile;
		echo json_encode($ListadoProductos);
	}

	function GetPrecioStock()
	{
		include('conexion.php');
		$IdP=$_REQUEST['IdP'];
		$List_Productos=array();
		$consulta=mysqli_query($conexion,"SELECT P_Venta AS 'PVenta',Stock FROM Producto WHERE IdP='$IdP'");
		while($fila=mysqli_fetch_array($consulta)):
			$List_Productos[]=$fila;
		endwhile;
		echo json_encode($List_Productos);
	}

	function GetCorrelativo()
	{
		include('conexion.php');
		$tipo=$_REQUEST['tipo'];
		if($tipo=='Natural'):
			$query=mysqli_query($conexion,"SELECT max(NumComp) FROM Ventas WHERE TipoDoc='Boleta'");
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
		endif;

		if($tipo=='Jurídica'):
			$query=mysqli_query($conexion,"SELECT max(NumComp) FROM Ventas WHERE TipoDoc='Factura'");
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
		endif;

		$sali=$arrayName = array('num' => $numcomp);
		echo json_encode($sali);
	}
?>