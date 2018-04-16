<?php
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    if ($_SESSION['id_usuario'] == 1)
    {
    	$id_administrador = $_SESSION['id_usuario'];
    }
    else
    {
    	header("location:index.php");
    }
    include "conexion.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Sistema de votaciones</title>
        <script type="text/javascript" src="jquery-1.7.1.min.js"></script>
        <link rel="stylesheet" href="estilo.css" type="text/css">
        <script type="text/javascript">

        <!-- -->

        </script>
    </head>
    <body">
        
        <div id="cuerpo">
            <div id="bannermenu">
                <?php
                    include 'banner.php';
                    #include 'menu.php';
                ?>          
            </div>
            <div id="contenido">
                <div class = "lyr_contenedor_categoria">
                <?php
                    $consulta_categorias = "select c.id_categoria, c.nombre from eventos e, categorias c where e.id_evento = c.id_evento and e.id_evento = 5";
                    $res_con_categorias = mysqli_query($con, $consulta_categorias);
                    while ($row_categorias = mysqli_fetch_array($res_con_categorias)) 
                    {
                        $id_categoria = $row_categorias['id_categoria'];
                        $nombre_categoria = $row_categorias['nombre'];                        
                        $consulta_participantes = "select p.id_participante, p.nombre from eventos e, categorias c, participantes p where e.id_evento = c.id_evento and  c.id_categoria = p.id_categoria and c.id_categoria = $id_categoria";
                        $res_con_participantes = mysqli_query($con, $consulta_participantes);
                        $bandera_stop = 0;
                        while($row_participantes =  mysqli_fetch_array($res_con_participantes))
                        {
                            $id_participante = $row_participantes['id_participante'];
                            $nombre_participante = utf8_encode($row_participantes['nombre']);                        
                            $consulta_calificaciones = "select SUM(calificacion) as 'calificacion' from calificaciones WHERE id_participante = $id_participante";
                            $res_con_calificaciones = mysqli_query($con, $consulta_calificaciones);
                            $arr_calificaciones = mysqli_fetch_array($res_con_calificaciones);
                            $calificacion =  $arr_calificaciones['calificacion'];
                            if($calificacion > 0)
                            {                                
                                if($bandera_stop <= 0)
                                {
                                    echo "<div class=\"lyr_contenedor_titulo_calif\">";
                                    echo    "<h1>$nombre_categoria</h1>";
                                    echo "</div>";
                                    $bandera_stop++;
                                }                               
                                
                                echo "<div class=\"lyr_renglon_votos\">";
                                echo    "<div class=\"lyr_contenedor_participantes\">";
                                echo        "<label class=\"lbl_nombre_participante\">$nombre_participante</label>";
                                echo    "</div>";
                                echo    "<div class=\"lyr_contenedor_puntuacion\">";
                                echo        "<strong class=\"lbl_calificacion_total\">$calificacion</strong>";
                                echo    "</div>";
                                echo "</div>";

                            }
                        }
                    }
                    /*
                    echo "<h2></h2>";
                    echo "<div class=\"lyr_renglon_votos\">";
                    echo    "<div class=\"lyr_contenedor_participantes\">";
                    echo        "<strong>nombre nombre nombre nombre nombre nombre</strong>";
                    echo    "</div>";
                    echo    "<div class=\"lyr_contenedor_puntuacion\">";
                    echo        "<strong>10</strong>";
                    echo    "</div>"
                    echo "</div>";
                    */
                ?>
                </div>
            </div>
        </div>      
    </body>
</html>