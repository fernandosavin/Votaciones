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
   include "conexion.php";
   if(isset($_POST['id_aspecto']) && isset($_POST['calif']))
	{
		$arr_id_aspecto = $_POST['id_aspecto'];
		$arr_calificaciones = $_POST['calif'];
		$id_usuario = $_SESSION['id_usuario'];
		$id_participante = $_SESSION['id_participante'];

		$i = 0;
		foreach ($arr_id_aspecto as $id_asp) //recorre 
		{
			$calif= $arr_calificaciones[$i];
			$consulta_verifica_calif = "select calificacion from  calificaciones c where id_usuario = $id_usuario  and id_participante = $id_participante and id_aspecto = $id_asp";
			$res_verif_calif = mysqli_query($con, $consulta_verifica_calif);
			if(mysqli_num_rows($res_verif_calif) == 0)#En caso de que no existan registros, los inserta
			{
				$inserta_calificacion = "insert into calificaciones values ($id_usuario, $id_participante, $id_asp, $calif)";
				mysqli_query($con, $inserta_calificacion);
			}
			else#En caso de que no existan registros, los actualiza
			{
				$actualiza_calificacion = "update calificaciones set calificacion = $calif where id_usuario = $id_usuario and id_participante = $id_participante and id_aspecto = $id_asp";
				mysqli_query($con, $actualiza_calificacion);
			}
			$i++;
		}
		echo "<script>alert('Los datos han sido guardados correctamente.');";
		echo "window.location=\"participantes.php\"</script>";
		#header("location:categorias.php");
	}
	if(isset($_SESSION['id_participante']))
    {
    	$id_participante = $_SESSION['id_participante'];
    }
	#header("location:participantes.php");

   
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
				?>				
			</div>			
			<div id="contenido">
				<div id="lyr_direc_sesion">
					<div id="lyr_contenedor_direc">
						<b><a href="categorias.php">Categorías</a>  |  <a href="participantes.php">Participantes</a></b>
					</div>
					<div id="lyr_contenedor_sesion">
						<b><a href="sesion.php?sesion=1">Cerrar sesión</a></b>
					</div>
				</div>
				<div id="lyr_title_seccion">
					<h1>Evaluación</h1>
				</div>
				<div class="lyr_contenedor_grupo">
					<form action="evaluacion.php" method="post">
						<?php
							$id_usuario = $_SESSION['id_usuario'];
							$id_categoria = $_SESSION['id_categoria'];
							$consulta_aspectos = "select a.id_aspecto, a.nombre from eventos e, categorias c, aspectos a where e.id_evento= c.id_evento and c.id_categoria = a.id_categoria and c.id_categoria = $id_categoria";
							$res_consulta_aspectos = mysqli_query($con, $consulta_aspectos);
							while($row = mysqli_fetch_array($res_consulta_aspectos))
							{
								$id_aspecto = $row['id_aspecto'];
								$consulta_calificaciones = "select calificacion from calificaciones where id_usuario = $id_usuario and id_participante = $id_participante and id_aspecto = $id_aspecto";
								$res_consulta_calif = mysqli_query($con, $consulta_calificaciones);
								if(mysqli_num_rows($res_consulta_calif) == 0)#si no existen registros de calificaciones
								{								
									$nombre_aspecto = utf8_encode($row['nombre']);
									$id_aspecto=$row['id_aspecto'];
									echo "<div class=\"lyr_aspecto\">";
									echo	"<div class=\"lyr_contenedor_aspecto\">";
									echo		"<label class=\"lbl_aspecto\">$nombre_aspecto</label>";
									echo	"</div>";
									echo	"<div class=\"lyr_contenedor_calificacion\">";
									echo		"<select class=\"cb_calif\" name=\"calif[]\">";
									echo			"<option value=\"1\" selected=\"true\">1</option>";
									echo 			"<option value=\"2\">2</option>";
									echo			"<option value=\"3\">3</option>";
									echo			"<option value=\"4\">4</option>";
									echo			"<option value=\"5\">5</option>";
									echo			"<option value=\"6\">6</option>";
									echo			"<option value=\"7\">7</option>";
									echo			"<option value=\"8\">8</option>";
									echo			"<option value=\"9\">9</option>";
									echo			"<option value=\"10\">10</option>";
									echo		"</select>";
									echo 		"<input class=\"txt_param_id_asp\" type=\"text\" name=\"id_aspecto[]\" value=\"$id_aspecto\">";
									echo	"</div>";
									echo "</div>";
								}
								else#si ya existen registros de calificaciones
								{
									$nombre_aspecto = utf8_encode($row['nombre']);
									$id_aspecto=$row['id_aspecto'];
									$consulta_calificaciones = "select calificacion from calificaciones where id_usuario = $id_usuario and id_participante = $id_participante and id_aspecto = $id_aspecto";
									$res_con_calif = mysqli_query($con, $consulta_calificaciones);
									$arr_calificacion = mysqli_fetch_array($res_con_calif);
									echo "<div class=\"lyr_aspecto\">";
									echo	"<div class=\"lyr_contenedor_aspecto\">";
									echo		"<label class=\"lbl_aspecto\">$nombre_aspecto</label>";
									echo	"</div>";
									echo	"<div class=\"lyr_contenedor_calificacion\">";
									echo		"<select class=\"cb_calif\" name=\"calif[]\">";

									for($x=1; $x < 11; $x++)#genera los items del combo box
									{
										if($arr_calificacion['calificacion'] == $x)#para marcar como seleccionado el item
										{
											echo 			"<option value=\"$x\" selected=\"true\">$x</option>";
										}
										else#para marcarlo como cualquier otro item
										{
											echo 			"<option value=\"$x\">$x</option>";
										}										
									}
									echo		"</select>";
									echo 		"<input class=\"txt_param_id_asp\" type=\"text\" name=\"id_aspecto[]\" value=\"$id_aspecto\">";
									echo	"</div>";
									echo "</div>";
								}
							}
						?>
					</div>
					<div id="lyr_guardar_votos">
							<input type="submit" id="btn_guardar_votos" name="btn_guardar_votos" value="Guardar votación">
					</div>
				</form>
			</div>
		</div>		
	</body>
</html>