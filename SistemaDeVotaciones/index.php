<?php
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    if(isset($_SESSION['tipo']))
	{
		header("location:categorias.php");
    }



    include 'conexion.php';
	if(isset($_POST['btn_login']))
	{
		$usuario = $_POST['txt_user'];
		$contraseña = $_POST['txt_pass'];
				
		$busca_usuario = mysqli_query($con,"select id_usuario, nombre, tipo, pass from usuarios n where n.nombre = '$usuario'");//con codigo de usuario.
		
		if(mysqli_num_rows($busca_usuario) > 0)
		{			
			$resp_arr = mysqli_fetch_array($busca_usuario);
			$contraseña2 = $resp_arr['pass'];
			$tipo = $resp_arr['tipo'];
			$id_usuario = $resp_arr['id_usuario'];
			if(trim($contraseña2) == $contraseña)
			{
				//echo "<script>alert('$contraseña : ".$contraseña2." : ".$tipo." : ".$id."');</script>";	
				$_SESSION['tipo'] = $tipo;
				$_SESSION['id_usuario'] = $id_usuario;
				$_SESSION['nombre'] = $usuario;
				header("location: categorias.php");
				//echo "<script>window.location=\"categorias.php\"</script>";
			}
			else 
			{
				error_login();
			}			
		}
		else 
		{
			error_login();
		}
	}

	function error_login()
	{
		echo "<script>alert('Datos incorrectos, intente de nuevo.');</script>";
		echo "<script>window.location=\"index.php\"</script>";
	}
	if (isset($_GET['sesion']) == 1) 
	{
		unset($_SESSION['tipo']);
		unset($_SESSION['id']);
		unset($_SESSION['nombre']);
		header("location:index.php");
	}
	if(isset($_SESSION['tipo']))
	{
		echo "<script>window.location=\"categorias.php\"</script>";
	}
	else 
	{
		//echo "<script>window.location=\"index.php\"</script>";
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
			
			<?php
				if(isset($_GET['error']) == 1)
			    {
			    	echo "alert('Datos incorrectos, no se pudo iniciar sesión');";
			    }
			?>
			function valida_caracteres_especiales(e)
			{
				var key;
				if(window.event) // IE
					{
						key = e.keyCode;
					}
				else if(e.which) // Netscape/Firefox/Opera
					{
						key = e.which;
					}
			
					if(key == 32 || key == 34 || key == 39 || key == 47 || key == 92) 
					{
						return false;
					}
			}
		</script>
	</head>
	<body onload="error_sesion()">
		
		<div id="cuerpo">
			<div id="bannermenu">
				<?php
					include 'banner.php';
					#include 'menu.php';
				?>			
			</div>			
			<div id="contenido">
				<form name="frm_login" action="index.php" method="post" onsubmit="return valida_login()">
					<div id="contenedor_login">
						<div id="lyr_usuario">
							<strong>Nombre de usuario:</strong><br>
							<input type="text" name="txt_user" id="txt_user" size="41" onkeypress="return valida_caracteres_especiales(event);">
						</div>
						<div id="lyr_contraseña">
							<strong>Contraseña:</strong><br>
							<input type="password" name="txt_pass" id="txt_pass" size="41" onkeypress="return valida_caracteres_especiales(event);">
						</div>						
						<input type="submit" name="btn_login" id="btn_login" value="Ingresar" >
					</div>
				</form>
			</div>
		</div>		
	</body>
</html>