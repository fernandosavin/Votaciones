<?php
	if(!isset($_SESSION)) 
    { 
        session_start(); 
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
	}
	else
	{
		header("location:index.php");
	}
	header("location:participantes.php");
?>