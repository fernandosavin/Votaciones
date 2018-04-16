<?php
include 'conexion.php';
	if(isset($_SESSION['tipo']))
	{
		$identificador = $_SESSION['id'];
	}	
?>
<div id='cssmenu'>
	<ul>
		<li>
			<a href='index.php'><span>Inicio</span></a>
		</li>
		<?php
			if(isset($_SESSION['tipo']))
			{
			echo "<li class='active has-sub'>
					<a href='cuenta.php'><span>Mi congreso</span></a>
					<ul>				
						<li>
							<a href='registro_talleres.php'><span>Registro en talleres</span></a>
						</li>
						<li>
							<a href='registro_conferencias.php'><span>Registro en conferencias</span></a>
						</li>";										
							$identificador = $_SESSION['id'];
							$consulta_datos_personales = "select edicion from usuario where id_usuario = '$identificador'";
							$res_con_dat_per = mysql_query($consulta_datos_personales,$con);
							$valores = mysql_fetch_array($res_con_dat_per);
							$edicion = $valores['edicion'];
							if($edicion == "NO")
							{
								echo "<li class='last'>
										<a href=\"datos_personales.php?btn_datos_per=1\"><span>Modificar mis datos personales</span></a>
									</li>";
							}
					
				echo "</ul>
				</li>";
			}
		
			if(isset($_SESSION['tipo']))
			{								
				if($_SESSION['tipo'] == 'ADMINISTRADOR')
				{					
					echo "<li class='active has-sub'>
							<a href='administracion.php'><span>Administración</span></a>
							<ul>
								<li>
									<a href='corte_de_registro.php'><span>Corte de registro de usuarios</span></a>
								</li>
								<li>
									<a href='confirmaciones.php'><span>Confirmacion de asistencia.</span></a>
								</li>				
								<li>
									<a href='pase_de_lista.php'><span>Pase de lista</span></a>
								</li>
								<li>
									<a href='impresion_de_constancias.php'><span>Impresión de constancias</span></a>
								</li>
								<li class='last'>
									<a href='marcar_impresiones.php'><span>Revisión de impresiones</span></a>
								</li>				
							</ul>
						</li>";
				}
			}
			
			echo "<li class='active has-sub'>
					<a href=''><span>Sesión</span></a>
					<ul>";				
					if(!isset($_SESSION['tipo']))
					{
						echo "<li>
							<a href='login.php'><span>Iniciar sesión</span></a>
						</li>
						<li>
							<a href='registro.php'><span>Registrarse</span></a>
						</li>
						<li>
							<a href='recuperar_con.php'><span>Recuperar contraseña</span></a>
						</li>";
					}
					else 
					{
						echo "<li class='last'>
							<a href='sesion.php?log_out=1'><span>Cerrar sesión</span></a>
						</li>";
					}	
					echo "</ul>
				</li>";
			
		?>
				
		<!--li>
			<a href='#'><span>elemento 3</span></a>
		</li>
		<li class='last'>
			<a href='#'><span>elemento 4</span></a>
		</li-->
	</ul>
</div>