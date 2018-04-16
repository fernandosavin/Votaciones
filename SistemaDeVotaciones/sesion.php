<?php
	
	if(!isset($_SESSION))
    { 
        session_start();
    }
    include 'conexion.php';
	if(isset($_SESSION['tipo']))
	{
		$identificador = $_SESSION['id_usuario'];
	}
	else 
	{
		echo "<script> window.location=\"index.php?error=1\"</script>";
		#header('location: index.php');
	}


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
		echo "<script>window.location=\"index.php\"</script>";
	}
?>