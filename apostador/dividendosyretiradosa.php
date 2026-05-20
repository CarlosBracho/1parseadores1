<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');


$MM_authorizedUsers = "C"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1") && isset($_POST['fecha_inicio'])) {
    $fechaBusqueda=fechaymd($_POST['fecha_inicio']);
    $inicio=$_POST['fecha_inicio'];
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 apostador\dividendosyretiradosa.php - QUERY 1 */ SELECT * FROM carrera 
		WHERE 
			carrera.est_confirmacion=0 AND 
			carrera.fec_carrera = %s 
		ORDER BY carrera.hor_carrera DESC",
        GetSQLValueString($fechaBusqueda, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
} else {
    $inicio=fechanueva(fechaactualbd());
    $fechaBusqueda=fechaactualbd();
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 apostador\dividendosyretiradosa.php - QUERY 2 */ SELECT * FROM carrera 
		WHERE 
			carrera.est_confirmacion=0 AND 
			carrera.fec_carrera = %s 
		ORDER BY carrera.hor_carrera DESC",
        GetSQLValueString($fechaBusqueda, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
}
$fechaInicial=fechanueva(fechaactualbd());
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>.:Apuestas:.</title>

<!-- Bootstrap core CSS -->
<link href="dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="assets/sticky-footer-navbar.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<script type="text/javascript">
 $(document).ready(function() {
	 $("#saldocliente").load('saldoapostador.php?&js='+Math.random());
	 var refreshId6 = setInterval(function() {
	 	saldocli();
	 }, 30000);

});
</script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<header> 
  <!-- Fixed navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><span id="saldocliente"></span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="internacionalesa.php">Apostar Hipismo Internacional<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="dropdown-item" href="reportea.php">Reporte General</a>
      </li>
	  	        <li class="nav-item">
        <a class="dropdown-item" href="cambiomonedaa.php">Cambiar Moneda A Usar</a>
      </li>
	  	        <li class="nav-item">
         <a class="dropdown-item" href="dividendosyretiradosa.php">Dividendos y Retirados</a>
      </li>
	  	        <li class="nav-item">
         <a class="dropdown-item" href="../gacetas/retrospectosa.php">Retrospectos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="cerrar_sesion_apostador.php">Salir</a>
      </li>
    </ul>

  </div>
</nav>
</header>
	<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
	onsubmit="return chequearEnvio();">   
       <div style="width:100%; float:left; text-align:right; padding:10px 2px 2px 2px;font-size:18px;">
            Dividendos anteriores: 
    		<input    id="fecha" name="fecha_inicio" title="formato: dd-mm-aaaa"
        	 
        	value="<?php echo htmlentities($fechaInicial, ENT_COMPAT, 'utf-8'); ?>"/>
            <input type="submit" value="Aceptar" onClick="return enviado()" title="buscar dividendos anteriores" />
			    <script>
        $('#fecha').datepicker({
            uiLibrary: 'bootstrap',
			format: 'dd-mm-yyyy'
        });
    </script>

       </div><!-- end .container -->
	   <input type="hidden" name="MM_update" value="form1" />
	</form>    

  
  
  
	<?php
    if ($totalRows_Recordset1>=1) {
        do { ?>
  <div class="container">
</br>
  <div class="row">
    <div class="col-sm">
			  <tr>
				<td rowspan="4" align="center" valign="middle" style="font-size:28px; background:#CCCCCC">
					<?php echo $row_Recordset1['nom_hipodromo']; ?>
                </td>
				<td rowspan="4" align="center" valign="middle" style="font-size:28px; background:#CCCCCC">
                	<?php echo $row_Recordset1['num_carrera']; ?>
                </td>
				 </tr>
    </div>
	
    <div class="col-sm">
	<tr>
				<td width="4%" align="right">1ro</td>
				<td width="10%">
                	<?php echo $row_Recordset1['eje_primero']; ?>
                </td>
				<td>
					<?php echo $row_Recordset1['div_primero_gan']; ?>
                </td>
				<td>
					<?php echo $row_Recordset1['div_primero_pla']; ?>
                </td>
				<td>
                	<?php echo $row_Recordset1['div_primero_sho']; ?>
                </td>
			  </tr>
			  </br>
			  <tr>
				<td align="right">2do</td>
				<td>
<?php
if ($row_Recordset1['eje_segundo']<>99) {
            echo $row_Recordset1['eje_segundo'];
        }
?>
<?php
if ($row_Recordset1['eje_segundo']==99) {
    echo $row_Recordset1['eje_doble_primero'];
}
?>
                </td>
				<td>
<?php
if ($row_Recordset1['eje_segundo']<>99) {
}
?>
<?php
if ($row_Recordset1['eje_segundo']==99) {
    echo $row_Recordset1['div_doble_primero_gan'];
}
?>
                </td>
				<td>
<?php
if ($row_Recordset1['eje_segundo']<>99) {
    echo $row_Recordset1['div_segundo_pla'];
}
?>
<?php
if ($row_Recordset1['eje_segundo']==99) {
    echo $row_Recordset1['div_doble_primero_pla'];
}
?>
                </td>

		
				<td>
<?php
if ($row_Recordset1['eje_segundo']<>99) {
    echo $row_Recordset1['div_segundo_sho'];
}
?>
<?php
if ($row_Recordset1['eje_segundo']==99) {
    echo $row_Recordset1['div_doble_primero_sho'];
}
?>
                </td>
			  </tr>
</br>



			  <tr>
				<td align="right">3ro</td>
			<td>
<?php
if ($row_Recordset1['eje_tercero']<>99) {
    echo $row_Recordset1['eje_tercero'];
}
?>
<?php
if ($row_Recordset1['eje_tercero']==99) {
    echo $row_Recordset1['eje_doble_segundo'];
}
?>

                </td>
				<td>&nbsp;</td>
				<td>
<?php
if ($row_Recordset1['eje_tercero']<>99) {
}
?>
<?php
if ($row_Recordset1['eje_tercero']==99) {
    echo $row_Recordset1['div_doble_segundo_pla'];
}
?>
</td>
				<td>
<?php
if ($row_Recordset1['eje_tercero']<>99) {
    echo $row_Recordset1['div_tercero_sho'];
}
?>
<?php
if ($row_Recordset1['eje_tercero']==99) {
    echo $row_Recordset1['div_doble_segundo_sho'];
}
?>


                </td>
			  </tr>
</br>
<tr>
<td align="right">4ro</td>
				<td>
                	<?php echo $row_Recordset1['eje_cuarto']; ?>
	</td>		
<td>



                </td>
				<td>&nbsp;</td>

				<td>
<?php
if ($row_Recordset1['div_doble_tercero_sho']<>0.00) {
    echo $row_Recordset1['div_doble_tercero_sho'];
}
?>
<?php
if ($row_Recordset1['div_doble_tercero_sho']==0.00) {
}
?>
                </td>

			  </tr>

</br>







			  <tr style="background:#CCCCCC">
				<td colspan="2" align="left">
                	EXÓTICAS: 
                    Ex-> <?php echo $row_Recordset1['ord_exacta']." ".$row_Recordset1['div_exacta']." | "; ?>
                    Tr-> <?php echo $row_Recordset1['ord_trifecta']." ".$row_Recordset1['div_trifecta']." | "; ?>
                    Su-> <?php echo $row_Recordset1['ord_superfecta']." ".$row_Recordset1['div_superfecta']." | "; ?>
                </td>
				<td colspan="5" align="left">
<?php
if ($row_Recordset1['eje_primero']<>99) {
}
?>

<?php
if ($row_Recordset1['eje_primero']==99) {
    echo "CARRERA CANCELADA";
}
?>
</br>
                	RETIRADOS:
                    <?php echo BuscarRetirados($row_Recordset1['cod_carrera']);?>
                    </td>
				</tr>
    </div>
</br></br></br></br></br></br>
			<?php
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
	<?php
    } else { ?>
        <table style="width:100%; font-size:28px" align="left">
            <tr class="brillo">
              <td colspan="4"><?php echo "No existen registros";?></td>
              </tr>
        </table>
		  </div>
  
  
  
  
</div>
	<?php }?>
	
	
	






<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script src="dist/js/bootstrap.min.js"></script>
</body>
</html>
<!-- Begin page content -->
