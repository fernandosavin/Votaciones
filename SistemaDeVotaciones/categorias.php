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
    
    if(isset($_POST['id_categoria']))
    {    	
    	$_SESSION['id_categoria'] = $_POST['id_categoria'];    	
    	header("location:participantes.php");
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
					<div id="lyr_contenedor_sesion">
						<b><a href="sesion.php?sesion=1">Cerrar sesión</a></b>
					</div>
				</div>
				<div id="lyr_title_seccion">
					<h1>Categorías</h1>
				</div>								
					<div id="cont_cat">
						<?php
							$id_evento = 1;							
							$consulta_categorias = "select c.id_categoria, c.nombre from eventos e, categorias c where e.id_evento=c.id_evento and e.id_evento = $id_evento";
							$res_consulta_categorias =  mysqli_query($con, $consulta_categorias);
							while($row = mysqli_fetch_array($res_consulta_categorias))
							{
								$id_categoria = $row['id_categoria'];
								$nombre_categoria = utf8_encode($row['nombre']);
								echo "<form action='categorias.php' method='post'>";
									echo	"<div class=\"lyr_categoria\">";
									echo		"<input class=\"btn_categoria\" type=\"submit\" name=\"id_categoria\" style=\"background-image:url('imagenes/fondo_btn.png')\" value=\"".ucwords($nombre_categoria)."\">";
									echo 		"<input class=\"txt_param_cat\" type=\"text\" name=\"id_categoria\" value=\"$id_categoria\">";
									echo	"</div>";
								echo "</form>";
							}
						?>
					</div>
			</div>
		</div>		
	</body>
</html>