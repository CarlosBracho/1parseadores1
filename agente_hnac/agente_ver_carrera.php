	<div id="info" style="background:#333; width:99%; float: right; height:25px; border:1px solid #333;
	text-align:center; font-size:18px; color:#FFFFFF; padding:10px 0px 0px 4px">
		DATOS DE CARRERA
	</div>
    
    <?php
    
    require_once('../Connections/conexionbanca.php');
    if (isset($_POST["codCarrera"])) {
        $inicio=fechaymd($_POST['fecCarrera']);
        $codigoTaquilla=$_POST["codTaquilla"];
        $codCarrera=$_POST["codCarrera"];
        $numCarrera=$_POST["numCarrera"];
        include("baseAgente_hnac/ventas_carrera_ta.php");
    }
?>
