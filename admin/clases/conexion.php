<?php 
	$conexion=mysqli_connect('localhost','root','')or die(mysqli_error());
	mysqli_set_charset($conexion, "utf8");
	mysqli_select_db($conexion,'Tienda');
?>