<?php
function Conectar(){


	$conexion['host']="localhost";
    $conexion['bd']="";
    $conexion['usuarioBD']="";
    $conexion['passBD']="";
	
	$link = mysqli_connect($conexion['host'], $conexion['usuarioBD'], $conexion['passBD'], $conexion['bd']);
	
	return $link;
}

?>