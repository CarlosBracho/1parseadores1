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
    "/* PARSEADORES1 ventas\ventas_configurar_ticket.php - QUERY 1 */ SELECT tp.lar_ticket, tp.tam_ticket, tp.cod_taopcame, tp.tip_ticket, ta.tra_codigo, ta.cod_taquilla
	FROM 
		usuario us,
		taquilla ta, 
		taquilla_opc_ame tp 
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
        "/* PARSEADORES1 ventas\ventas_configurar_ticket.php - QUERY 2 */ UPDATE taquilla_opc_ame 
			SET 
			tip_ticket=%s,
			lar_ticket=%s,
			tam_ticket=%s 
			WHERE 
			cod_taopcame=%s",
        GetSQLValueString($_POST['tip_ticket'], "int"),
        GetSQLValueString($_POST['lar_ticket'], "int"),
        GetSQLValueString($_POST['tam_ticket'], "int"),
        GetSQLValueString($_POST['cod_taopc'], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    $updateSQL = sprintf(
        "/* PARSEADORES1 ventas\ventas_configurar_ticket.php - QUERY 3 */ UPDATE taquilla 
			SET 
			tra_codigo=%s  
			WHERE 
			cod_taquilla=%s",
        GetSQLValueString($_POST['tra_codigo'], "int"),
        GetSQLValueString($_POST['cod_taquilla'], "int")
    );
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    $guardar=2;
    $mensaje="DATOS GUARDADOS<br>CORRECTAMENTE!";
}
?>
<script>
function configurarticket() {
    var url = 'ventas_configurar_ticket.php';
$.post( url,  $( "#form1" ).serialize() )
  .done(function( data ) {
    $("#dialog-message").html(data);


    var data=data.substr(-1);
if (data==1) {
    toastr.warning(
        '<h4>CLAVE ACTUAL INVALIDA Y VUELVA INTENTAR POR FAVOR</h3>',
        ' NOTIFIACION !!!'
    );
}
if (data==2) {
    toastr.warning(
        '<h4>INDIQUE NUEVA CLAVE Y VUELVA INTENTAR POR FAVOR</h3>',
        ' NOTIFIACION !!!'
    );
}
if (data==3) {
    toastr.warning(
        '<h4>CLAVE DEBE CONTENER 3 CARACTERES COMO MÍNIMO Y VUELVA INTENTAR POR FAVOR</h3>',
        ' NOTIFIACION !!!'
    );
}
if (data==4) {
    toastr.warning(
        '<h4>CLAVE DEBE CONTENER 20 CARACTERES COMO MÁXIMO Y VUELVA INTENTAR POR FAVOR</h3>',
        ' NOTIFIACION !!!'
    );
}
if (data==4) {
    toastr.warning(
        '<h4>CLAVE DEBE CONTENER 20 CARACTERES COMO MÁXIMO Y VUELVA INTENTAR POR FAVOR</h3>',
        ' NOTIFIACION !!!'
    );
}
if (data==5) {
    toastr.warning(
        '<h4>CAMBIO DE CLAVE EJECUTADO CORRECTAMENTE GUARDADOS CORRECTAMENTE!</h3>',
        ' NOTIFIACION !!!'
    );
}
  });

}
</script>
<div style="background: #0072C6; width:100%; float:left; padding:50px 2px 2px 2px;
   		color:#FFF; font-size:28px; text-align:center">
       CONFIGURAR TICKET
  </div><!-- end .container -->
  <div style="background: #FFF; width:100%; float:left; padding:25px 0px 0px 10px; font-size:16px">
    <?php if ($guardar!=2) { ?>
     <form  method="post" 
     	name="form1" id="form1" autocomplete="off" onsubmit="return chequearEnvio();">
        <div style="background: #FFF; width:100%; float:left; padding:25px 0px 0px 40px;">
        	Tipo Ticket:   
                    <select name="tip_ticket" style="width:auto; height: auto" class="textbox" tabindex="4"> 
                        <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['tip_ticket'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>NORMAL</option>
                        <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['tip_ticket'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>REDUCIDO</option>
                        <option value="2" <?php if (!(strcmp(2, htmlentities($row_Recordset1['tip_ticket'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>NORMAL 2</option>
						<option value="2" <?php if (!(strcmp(3, htmlentities($row_Recordset1['tip_ticket'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>REDUCIDO 2</option>
                    </select>			
        </div>
		
		       <div style="background: #FFF; width:100%; float:left; padding:25px 0px 0px 40px;">
        	Tamano Letra: 
			<input type="text" name="tam_ticket" class="textbox" 
                    value="<?php echo htmlentities($row_Recordset1['tam_ticket'], ENT_COMPAT, 'utf-8'); ?>" 
                    size="3" required max="100"/>
			              
        </div>
       <div style="background: #FFF; width:100%; float:left; padding:0px 0px 0px 36px;">
        	Ajuste largo: 
            <select name="lar_ticket" style="width:140px; height: auto" class="textbox">
            <?php for ($i = 0; $i < 10; ++$i) {?>
                <option value="<?php echo $i; ?>"
                <?php if (!(strcmp($i, htmlentities($row_Recordset1['lar_ticket'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>
                <?php echo $i; ?>
                </option>
            <?php } ?>    
            </select>               
        </div>
       <div style="background: #FFF; width:100%; float:left; padding:0px 0px 0px 10px; line-height:14px">
			<table width="60%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="35%" align="right">Trabajar con codigo cliente:</td>
                  <td width="25%">&nbsp;
                    <select name="tra_codigo" style="width:auto; height: auto" class="textbox" tabindex="4"> 
                        <option value="0" <?php if (!(strcmp(0, htmlentities($row_Recordset1['tra_codigo'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>NO</option>
                        <option value="1" <?php if (!(strcmp(1, htmlentities($row_Recordset1['tra_codigo'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>SI (NO IMPRIMIRA)</option>
                        <option value="2" <?php if (!(strcmp(2, htmlentities($row_Recordset1['tra_codigo'], ENT_COMPAT, 'utf-8')))) {
    echo "SELECTED";
} ?>>MIXTO</option>
                    </select>
                  </td>
                </tr>
            </table>
        </div>
            <div style="background: #FFF; width:100%; float:left; padding:0px 0px 0px 0px; font-size:12px; 
            color:#C30; text-align:center">
            </div>

       <div style="background: #FFF; width:100%; float:left; text-align:center; padding:50px 0px 0px 0px;">
           <input id="btsubmit" onclick="configurarticket(); return enviado();"  value="GUARDAR CAMBIOS" 
           class="btn-success" title=" guardar cambios" style="font-size:18px; height:40px" />
        </div>
       <input type="hidden" name="cod_taopc" value="<?php echo $row_Recordset1['cod_taopcame']; ?>" />
       <input type="hidden" name="cod_taquilla" value="<?php echo $row_Recordset1['cod_taquilla']; ?>" />
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
<?php
mysqli_free_result($Recordset1);
?>