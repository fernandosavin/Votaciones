<?php
	//Configuracion de la conexion a base de datos
	$bd_host = "localhost";
	$bd_usuario = "root";
	$bd_password = "";
	$bd_base = "voto_publico";
	$con = mysqli_connect($bd_host, $bd_usuario, $bd_password);
	mysqli_select_db($con, $bd_base);
?>