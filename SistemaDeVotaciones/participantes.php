<?php
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    if(isset($_SESSION['id_usuario']))
    {
    	if ($_SESSION['id_usuario'] == 1)
    	{
    		$id_administrador = $_SESSION['id_usuario'];
    	}
    	else
    	{
    		$id_juez = $_SESSION['id_usuario'];
    	}
    }
    else
    {
    	header("location:index.php");
    }
    if(isset($_GET['id_participante']))
    {
    	$_SESSION['id_participante'] = $_GET['id_participante'];
    	header("location:evaluacion.php");
    }
    if(isset($_SESSION['id_categoria']))
    {
    	$id_categoria = $_SESSION['id_categoria'];
    }
    else
    {
    	header("location:categorias.php");
    }   
    include "conexion.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"	"http://www.w3.org/TR/html4/loose.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Sistema de votaciones</title>
		<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
		<link rel="stylesheet" href="estilo.css" type="text/css">
		<script type="text/javascript">								
			//JAVASCRIPT
		</script>
	</head>
	<body>
		
		<div id="cuerpo">
			<div id="bannermenu">
				<?php
					include 'banner.php';
					#include 'menu.php';inpu
				?>				
			</div>			
			<div id="contenido">
				<div id="lyr_direc_sesion">
					<div id="lyr_contenedor_direc">
						<b><a href="categorias.php">Categorías</a></b>
					</div>
					<div id="lyr_contenedor_sesion">
						<b><a href="sesion.php?sesion=1">Cerrar sesión</a></b>
					</div>
				</div>
				<div id="lyr_title_seccion">
					<h1>Participantes</h1>
				</div>								
					<div id="cont_par">
						<?php
							$id_evento = 5;
							$id_categoria = $_SESSION['id_categoria'];
							$consulta_participantes = "select p.id_participante, p.nombre from eventos e, categorias c, participantes p where e.id_evento = c.id_evento and c.id_categoria = p.id_categoria and e.id_evento = $id_evento and c.id_categoria = $id_categoria";
							$res_consulta_participantes =  mysqli_query($con, $consulta_participantes);
							while($row = mysqli_fetch_array($res_consulta_participantes))
							{
								$id_participante = $row['id_participante'];
								$nombre_participante = utf8_encode($row['nombre']);
								$id_juez = $_SESSION['id_usuario'];
								echo "<form action='participantes.php' method='get'>";
									echo	"<div class=\"lyr_participante\">";
									$consulta_aspectos = "select id_aspecto from calificaciones where id_usuario = $id_juez and id_participante = $id_participante";
									$res_consulta_aspectos = mysqli_query($con, $consulta_aspectos);
									$arr_aspectos = mysqli_fetch_array($res_consulta_aspectos, MYSQLI_NUM);
									$aux = count($arr_aspectos);

									$consulta_existencia = "select id_aspecto from categorias c, eventos e, aspectos a where e.id_evento = c.id_evento and c.id_categoria = a.id_categoria and e.id_evento = $id_evento";
									$res_consulta_existencia = mysqli_query($con, $consulta_existencia);
									$bandera = false;
									while($row_existencia = mysqli_fetch_array($res_consulta_existencia))
									{										
										for($x = 0; $x < $aux; $x++)
										{
											if($row_existencia['id_aspecto'] == $arr_aspectos[$x])
											{
												$bandera = true;												
											}
										}
									}
									if($bandera == true)
									{
										echo		"<input class=\"btn_participante\" type=\"submit\" name=\" $id_participante\" style=\"background-image:url('imagenes/fondo_btn_ok.png')\" value=\"$nombre_participante\">";
									}
									else
									{
										echo		"<input class=\"btn_participante\" type=\"submit\" name=\" $id_participante\" style=\"background-image:url('imagenes/fondo_btn.png')\" value=\"$nombre_participante\">";
									}
									#echo		"<input class=\"btn_participante\" type=\"submit\" name=\" $id_participante\" value=\"$nombre_participante\">";
									echo 		"<input class=\"txt_param_par\" type=\"text\" name=\"id_participante\" value=\"$id_participante\">";
									echo	"</div>";
								echo "</form>";
							}
						?>
					</div>
			</div>
		</div>		
	</body>
</html>