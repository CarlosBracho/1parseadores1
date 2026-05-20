<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_GET["fechaID"])) {
    $fechaactual_Recordset1 = $_GET["fechaID"];
    $fecha=fechanueva($_GET["fechaID"]);
} else {
    $fechaactual_Recordset1 = fechaactualbd();
    $fecha=fechanueva(fechaactualbd());
}
$D=0;
if(isset($_POST["leito"])){
  $D=1;
  $Carrera=$_POST["leito"];
}
$query_Recordset1 = sprintf("/* PARSEADORES1 admin\historial_lista.php - QUERY 1 */ SELECT * 
FROM carrera 
WHERE carrera.eje_primero > 0 AND
 carrera.fec_carrera = %s 
 ORDER BY carrera.hor_carrera 
 DESC", 
 GetSQLValueString($fechaactual_Recordset1, "date"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);


$query_Recordset1D = sprintf("/* PARSEADORES1 admin\historial_lista.php - QUERY 2 */ SELECT DISTINCT nom_hipodromo 
FROM carrera 
WHERE carrera.eje_primero > 0 AND
 carrera.fec_carrera = %s 
 ORDER BY carrera.hor_carrera 
 DESC", 
 GetSQLValueString($fechaactual_Recordset1, "date"));
$Recordset1D = mysqli_query($conexionbanca, $query_Recordset1D) or die(mysqli_error($conexionbanca));
$row_Recordset1D = mysqli_fetch_assoc($Recordset1D);
$totalRows_Recordset1D = mysqli_num_rows($Recordset1D);


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $fechaactual_Recordset1=fechaymd($_POST["fecha"]);
   if($D==1 && $Carrera==' '){
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 admin\historial_lista.php - QUERY 3 */ SELECT * FROM carrera 
			WHERE carrera.eje_primero > 0 AND carrera.fec_carrera = %s ORDER BY carrera.hor_carrera DESC",
        GetSQLValueString($fechaactual_Recordset1, "date")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $fecha=$_POST["fecha"];


$query_Recordset1D = sprintf("/* PARSEADORES1 admin\historial_lista.php - QUERY 4 */ SELECT DISTINCT nom_hipodromo 
FROM carrera 
WHERE carrera.eje_primero > 0 AND
 carrera.fec_carrera = %s", 
 GetSQLValueString($fechaactual_Recordset1, "date"));
$Recordset1D = mysqli_query($conexionbanca, $query_Recordset1D) or die(mysqli_error($conexionbanca));
$row_Recordset1D = mysqli_fetch_assoc($Recordset1D);
$totalRows_Recordset1D = mysqli_num_rows($Recordset1D);
}else{
  $query_Recordset1 = sprintf(
    "/* PARSEADORES1 admin\historial_lista.php - QUERY 5 */ SELECT DISTINCT * FROM carrera 
  WHERE carrera.eje_primero > 0 AND carrera.fec_carrera = %s AND carrera.nom_hipodromo = %s ORDER BY carrera.hor_carrera DESC",
    GetSQLValueString($fechaactual_Recordset1, "date"),
    GetSQLValueString($_POST["leito"], "text")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$fecha=$_POST["fecha"];


$query_Recordset1D = sprintf("/* PARSEADORES1 admin\historial_lista.php - QUERY 6 */ SELECT DISTINCT nom_hipodromo 
FROM carrera 
WHERE carrera.eje_primero > 0 AND
carrera.fec_carrera = %s", 
GetSQLValueString($fechaactual_Recordset1, "date"));
$Recordset1D = mysqli_query($conexionbanca, $query_Recordset1D) or die(mysqli_error($conexionbanca));
$row_Recordset1D = mysqli_fetch_assoc($Recordset1D);
$totalRows_Recordset1D = mysqli_num_rows($Recordset1D);

}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<script LANGUAGE="JavaScript">
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
</script>
<!-- InstanceEndEditable -->
<!--[if lte IE 7]>
<link type="text/css" rel="stylesheet" media="all" href="../css/screen_ie.css" />
<![endif]-->
<style>
body {
	background-color: #eeeeee;
	padding:0;
	margin:0 auto;
	font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
	font-size:11px;
}
</style>
<link href="../estilo/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap2.3.2-combined.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<script>
 $(document).ready(function() { 
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 var refreshId1 = setInterval(function() {
 $("#reloj").load('../includes/reloj.php?&js='+Math.random());
 }, 60000);
});
</script>
<!-- InstanceBeginEditable name="aHead" -->
<link href='//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'/>
<!-- InstanceEndEditable -->
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#333">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabeceraadmin.php");?>
                    <!-- InstanceEndEditable -->        	
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#333; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #333;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px ">
                <!-- InstanceBeginEditable name="pagina" -->
                Historial de carreras<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
    <div style="height:100%; padding:40px 10px 80px 10px; text-align:left">
      <div style="text-align: right;" id="fecha">
           <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" autocomplete="off"  
                onsubmit="return chequearEnvio();">
                <select name="leito" id="soflow" style="height:40px; width:280px; margin:-9px 0px 0px 0px ">
                      <option value=" ">SELECIONE LA CARRERA</option>
                      <?php
                do {
                    ?>
               <option value="<?php echo $row_Recordset1D['nom_hipodromo']?>"
               <?php if (strtoupper($row_Recordset1D['nom_hipodromo']==$_POST["leito"])) {
                        echo "SELECTED";
                    } ?>>
							 <?php echo strtoupper($row_Recordset1D['nom_hipodromo']); ?>
               </option>
                      <?php
                } while ($row_Recordset1D = mysqli_fetch_assoc($Recordset1D));
                ?>
                    </select>
                    
                Fecha:
                <input name="fecha" type="text" id="dateArrival1" tabindex="1" style="width:100px; font-size:18px; height: 24px"
                    title="fecha inicio. formato: dd-mm-aaaa" class="tcal" 
                    value="<?php echo htmlentities($fecha, ENT_COMPAT, 'utf-8'); ?>"/>
                <input type="submit" value="Buscar" class="btn-warning" title="iniciar busqueda" onClick="return enviado()"
                 style="width:80px; height:34px"/>
                <input type="hidden" name="MM_update" value="form1" />
         </form>  
      </div>
   <?php if ($totalRows_Recordset1>=1) {  ?> 
<table width="100%" border="0" align="center">
  <tr style="background:#5EAEFF; color:#FFFFFF; height:30px; text-align:center">
    <td width="220">HIPÓDROMO</td>
    <td width="100">ABIERTO POR</td>
    <td width="100">CERRADO POR</td>
    <td width="100">CONFIRMADO POR</td>
    <td width="100">TIEMPO ABIERTO</td>
    <td width="100">HORA CIERRE</td>
    <td width="20"># CIERRES</td>
    <td width="100">TARDO EN CONFIRMAR</td>
    <td colspan="3">ACCIÓN</td>
  </tr>
  <?php do { ?>
    <tr class="brillo">
      <td align="left"><?php echo ObtenerNombreynumeroJugadaCarrera($row_Recordset1['cod_carrera']); ?></td>
      <td align="center"><?php echo 'ABI '; echo substr($row_Recordset1['ABIERTOX'], 0, 6);  ?></td>
      <td align="center"><?php echo 'CER '; echo substr($row_Recordset1['CERRADOX'], 0, 6); ?></td>
      <td align="center"><?php  echo 'CON '; 
      if ($row_Recordset1['confirmandox']==0){echo 'MANUAL'; }
      if ($row_Recordset1['confirmandox']==1){echo 'TRACK'; }
      if ($row_Recordset1['confirmandox']==2){echo 'TVG'; }
      if ($row_Recordset1['confirmandox']==3){echo 'BUILDA'; }
      if ($row_Recordset1['confirmandox']==4){echo 'TWINS'; }
      if ($row_Recordset1['confirmandox']==5){echo 'CAPIT'; }
      if ($row_Recordset1['confirmandox']==9){echo 'RACE'; }
      ?></td>
            <td align="center">

<?php
$faltan=restahoras($row_Recordset1['horaapertura'], $row_Recordset1['hor_carrera']);
if ($faltan<='00:10:00') {
  $faltan='<font color="red">'.$faltan.' VF</font>';
} else {
  $faltan='<font color="green">'.$faltan.'</font>';
} 
echo $faltan;
?>

</td>
      <td align="center">

<?php


$hora1=$row_Recordset1['hor_carrera'];
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
echo horaampm($nuevahora1); ?>


</td>

<td align="center">
<a href="#myModal" data-toggle="modal" onclick="detalle_ticket(<?php echo $row_Recordset1['cod_carrera']; ?>); return false">
  <?php echo '# '; 
if ($row_Recordset1['contador_cierres']>='10') {
  $cierres='<font color="red">'.$row_Recordset1['contador_cierres'].' VF</font>';
} else {
  $cierres='<font color="green">'.$row_Recordset1['contador_cierres'].'</font>';
} 
echo $cierres;

?></a></td>
<td align="center"><?php $faltan=restahoras($row_Recordset1['hor_carrera'], $row_Recordset1['hconfir']);
if ($faltan>='00:10:00') {
  $faltan='<font color="red">'.$faltan.' VF</font>';
} else {
  $faltan='<font color="green">'.$faltan.'</font>';
} 
echo $faltan;
?></td>
      <td width="33" align="center"><a href="dividendos_info.php?recordID=<?php echo $row_Recordset1['cod_carrera']; ?>" title="ver dividendos"><i class="fa fa-info-circle  fa-2x"></i></a></td>
      <td width="32" align="center"><a href="dividendos_edit.php?recordID=<?php echo $row_Recordset1['cod_carrera']; ?>" title="editar dividendos"><i class="fa fa-pencil fa-2x"></i></a></td>
      <td width="33" align="center">
      <?php if ($row_Recordset1['fec_carrera']==fechaactualbd()) {?>
      	<a href="dividendos_reset.php?recordID=<?php echo $row_Recordset1['cod_carrera']; ?>" title="reset dividendos">
        <i class="fa fa-undo fa-2x"></i></a>
      <?php }?>
        </td>
    </tr>
    <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
</table>
<?php } else { ?>
<br/>
<table width="100%" border="0" align="center">
  <tr style="background:#5EAEFF; color:#FFFFFF; height:30px; text-align:center">
    <td width="444">HIPÓDROMO</td>
    <td width="173">FECHA CIERRE</td>
    <td width="177">HORA CIERRE</td>
    <td width="98" colspan="2">ACCIÓN</td>
  </tr>
</table>
        <div style="height:100%; font-size:24px; padding:200px 0px 170px 0px; text-align:center ">
            No existen registros
        </div>

<?php }?>
</div>
  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>


<!-- Button trigger modal -->
<script>
  $('#myModal').modal('show');
  alert('show222');
    function detalle_ticket(cod_carrera){
      
        $.post("qabreqcierra.php", 
        {
          cod_carrera:cod_carrera
		},
        function(eData){				
            $("#dialog-message").html(eData);
        });	
       
    } 
    
</script>






<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">QUIEN ABRIO QUIEN CERRO</h3>
  </div>
  <div class="modal-body">
  <div id="dialog-message"></div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">CERRAR</button>

  </div>
</div>
<script src="../js/bootstrap2.3.2.min.js"></script>
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($Recordset1);
?>