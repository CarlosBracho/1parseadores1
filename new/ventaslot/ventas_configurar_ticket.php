<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$idUsuario=$_SESSION['MM_id_usuario'];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\ventaslot\ventas_configurar_ticket.php - QUERY 1 */ SELECT tp.tip_ticket_lot, tp.lar_ticket_lot, 
	tp.cod_taopclot 
	FROM 
		usuario us,
		taquilla ta, 
		taquilla_opc_lot tp 
	WHERE 
		us.id_usuario = %s AND 
		us.cod_taquilla = ta.cod_taquilla AND
		tp.cod_taquilla = ta.cod_taquilla",
    GetSQLValueString($idUsuario, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$guardar=0;
$mensaje="";
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $updateSQL = sprintf(
        "/* PARSEADORES1 new\ventaslot\ventas_configurar_ticket.php - QUERY 2 */ UPDATE taquilla_opc_lot 
			SET 
			tip_ticket_lot=%s,
			lar_ticket_lot=%s  
			WHERE 
			cod_taopclot=%s",
        GetSQLValueString($_POST['tip_ticket_lot'], "int"),
        GetSQLValueString($_POST['lar_ticket_lot'], "int"),
        GetSQLValueString($_POST['cod_taopclot'], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    $guardar=2;
    $mensaje="DATOS GUARDADOS<br>CORRECTAMENTE!";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script LANGUAGE="JavaScript">function enviado(){return 0==cuenta?(cuenta++,!0):(alert("El formulario ya está siendo enviado, por favor aguarde un instante."),!1)}var cuenta=0;</script>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div style="background: #333333; width:100%; float:left; padding:50px 2px 2px 2px;
   		color:#FFF; font-size:28px; text-align:center">
       CONFIGURAR TICKET
  </div><!-- end .container -->
  <div style="background: #FFF; width:100%; float:left; padding:25px 0px 0px 10px; font-size:18px">
    <?php if ($guardar!=2) { ?>
     <form action="<?php echo $editFormAction; ?>" method="post" 
     	name="form1" id="form1" autocomplete="off" onsubmit="return chequearEnvio();">
        <div style="background: #FFF; width:100%; float:left; padding:25px 0px 0px 40px;">
         	Tipo Ticket:
			<select name="tip_ticket_lot" style="width:140px; height: auto" class="textbox">
			<?php
            for ($i = 0;  $i <= 3; $i++) {?>
				<option value="<?php echo $i; ?>" 
				<?php if (!(strcmp($i, htmlentities($row_Recordset1['tip_ticket_lot'], ENT_COMPAT, 'utf-8')))) {
                echo "SELECTED";
            } ?>>
				<?php echo $i; ?>
				</option>
				<?php
            }?>  
			</select>                    
        </div>
       <div style="background: #FFF; width:100%; float:left; padding:0px 0px 0px 36px;">
        	Ajuste largo: 
            <select name="lar_ticket_lot" style="width:140px; height: auto" class="textbox">
            <?php for ($i = 0; $i < 10; ++$i) {?>
                <option value="<?php echo $i; ?>"
                <?php if (!(strcmp($i, htmlentities($row_Recordset1['lar_ticket_lot'], ENT_COMPAT, 'utf-8')))) {
                echo "SELECTED";
            } ?>>
                <?php echo $i; ?>
                </option>
            <?php } ?>    
            </select>                    
        </div>
            <div style="background: #FFF; width:100%; float:left; padding:0px 0px 0px 0px; font-size:12px; 
            color:#C30; text-align:center">
            </div>

       <div style="background: #FFF; width:100%; float:left; text-align:center; padding:50px 0px 0px 0px;">
           <input id="btsubmit" onclick="return enviado()" type="submit" value="GUARDAR CAMBIOS" 
           class="btn-success" title=" guardar cambios" style="font-size:18px; height:40px" />
        </div>
       <input type="hidden" name="cod_taopclot" value="<?php echo $row_Recordset1['cod_taopclot']; ?>" />
       <input type="hidden" name="MM_update" value="form1" />
    </form>
        <div style="background: #FFF; width:100%; float:left; padding:30px 0px 0px 0px; font-size:24px;
        line-height:25px; text-align:center; color:#FF3333" id="Info1">
        <?php echo $mensaje; ?>
        </div>
    <?php } else {?>
        <div style="background: #FFF; width:100%; float:left; padding:60px 0px 0px 0px; font-size:24px;
        line-height:25px; text-align:center; color: #393" id="Info2">
        <?php echo $mensaje; ?>
        </div>
  <?php }?>
</div>  
</body>
</html>
<?php
mysqli_free_result($Recordset1);
?>