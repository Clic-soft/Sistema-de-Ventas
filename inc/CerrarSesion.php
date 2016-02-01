<?php 
	session_start();/*
	$_SESSION['usuario'] = array();
	$_SESSION['tipo_usuario']= array();
	$_SESSION['Id']=array();
	$_SESSION['Titulo']=array();
	$_SESSION['Contenido']=array();*/
	session_destroy();
	header("Location: ../../");
 ?>
