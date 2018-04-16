<?php
	include "conexion.php";
	if(isset($_POST['nombre']) && isset($_POST['puntuacion']))
	{
		$name = $_POST['nombre'];
		$points = $_POST['puntuacion'];
		$points++;
		$consulta_incrementa = "update grupos set puntuacion = $points where nombre = '$name'";
		mysqli_query($con, $consulta_incrementa);
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"	"http://www.w3.org/TR/html4/loose.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Sistema de votaciones</title>
		<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
		<link rel="stylesheet" href="estilo.css" type="text/css">
		<script type="text/javascript">			
			
			function esta_seguro()
			{
				//Ingresamos un mensaje a mostrar
				var mensaje = confirm("¿Realmente desea votar por este grupo?");
				//Detectamos si el usuario acepto el mensaje
				if (mensaje) 
				{
					alert("¡Gracias por su voto!");
				}
				//Detectamos si el usuario denegó el mensaje
				else 
				{
					return false;
				}
			}			
		</script>
	</head>
	<body onload="error_sesion()">
		
		<div id="cuerpo">
			<div id="bannermenu">
				<!--?php
					include 'banner.php';
					#include 'menu.php';
				?-->			
			</div>			
			<div id="contenido">				
				<?php
					$consulta_grupos = "select * from grupos";
					$res_con_grupos = mysqli_query($con, $consulta_grupos);
					while($row_grupos = mysqli_fetch_array($res_con_grupos))
					{
						$nombre = $row_grupos['nombre'];
						$puntuacion = $row_grupos['puntuacion'];
						$directorio = $row_grupos['directorio'];
						echo "<form name=\"frm_voto\" action=\"index.php\" method=\"post\"  onsubmit=\"return esta_seguro()\">";
						echo 	"<div class=\"lyr_contenedor_boton\">";
						echo		"<input  type=\"submit\" style=\"width:800px; height:200px; background-image:url('$directorio'); border-radius: 30px;\" class=\"btn_votacion\"  name=\"btn_votacion\" value=\"\">";
						echo 		"<input  class=\"txt_param_calif\" type=\"text\" name=\"nombre\" value=\"$nombre\">";
						echo 		"<input  class=\"txt_param_calif\" type=\"text\" name=\"puntuacion\" value=\"$puntuacion\">";
						echo 	"</div>";
						echo "</form>";
					}
				?>
			</div>
		</div>		
	</body>
</html>	