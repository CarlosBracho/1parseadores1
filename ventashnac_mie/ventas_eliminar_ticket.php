<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xTicket_Recordset1 = "0";
$xserTic="";
$xnroTicket="";
if (isset($_POST["pagarT"])) {
    $xVendedor_Recordset1=$_POST["id_usuario_pago"];
    $numerotiket2=substr($_POST['pagarT'], 2, strlen($_POST['pagarT'])-2);
    $serial=substr($_POST['pagarT'], 0, 2);
    echo "<hr/> <p style='font-size:20px; color:#CC0000'> ELIMINAR TICKET<br><br>";
}

if (isset($_GET["pagoSIN"])) {
    $xnroTicket = $_GET["pagoSIN"];
    $numerotiket2=substr($xnroTicket, 2, strlen($xnroTicket)-2);
    $serial=substr($xnroTicket, 0, 2);
    $xVendedor_Recordset1=$_GET["uVenta"];
    echo'<div style="background:#333;width:100%;float:left;padding:10px 0px 0px 0px;color:#FFF;font-size:28px;text-align:center">';
    echo'ELIMINAR TICKET';
    echo'</div>';
}


$codigoTaquilla=$_SESSION['MM_cod_taquilla'];
$fechaactual=fechaactualbd();
$totaleliminados=BuscarTicketEliminados($xVendedor_Recordset1, $fechaactual);

$query_Recordset1 = sprintf("/* PARSEADORES1 ventashnac_mie\ventas_eliminar_ticket.php - QUERY 1 */ SELECT tic_eliminados 
	FROM usuario WHERE id_usuario = %s", GetSQLValueString($xVendedor_Recordset1, "int"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$maximo=$row_Recordset1['tic_eliminados'];
$mensaje="";
if ($totaleliminados<$maximo) {
    $query_Recordset8 = sprintf(
        "/* PARSEADORES1 ventashnac_mie\ventas_eliminar_ticket.php - QUERY 2 */ SELECT cod_taquilla 
								 FROM usuario 
								 WHERE id_usuario = %s LIMIT 1",
        GetSQLValueString($xVendedor_Recordset1, "int")
    );
    $Recordset8 = mysqli_query($conexionbanca, $query_Recordset8) or die(mysqli_error($conexionbanca));
    $row_Recordset8 = mysqli_fetch_assoc($Recordset8);
    $totalRows_Recordset8 = mysqli_num_rows($Recordset8);
    $codVenta=$row_Recordset8['cod_taquilla'];
    $query_Recordset2 = sprintf(
        "/* PARSEADORES1 ventashnac_mie\ventas_eliminar_ticket.php - QUERY 3 */ SELECT 
			venta.est_ticket, 
			venta.id_usuario, 
			venta.ser_venta,
			venta.cod_taquilla,
			carrera.est_carrera, 
			carrera.hor_carrera 
			FROM 
			venta, carrera 
			WHERE 
			venta.cod_carrera = carrera.cod_carrera AND 
			venta.ticket = %s AND 
			carrera.fec_carrera = %s",
        GetSQLValueString($numerotiket2, "int"),
        GetSQLValueString($fechaactual, "date")
    );
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
    $horaactual=horaactual();
    $acceso=1;
    if ($totalRows_Recordset2>0) {
        if ($serial!=substr($row_Recordset2['ser_venta'], 0, 2)) {
            $mensaje="TICKET #".$serial.$numerotiket2." <br/><br/> NO ENCONTRADO";
            $acceso=0;
        }
        if ($codVenta!=$row_Recordset2['cod_taquilla']) {
            $mensaje="TICKET #".$serial.$numerotiket2.' <br/><br/><p style="font-size:18px;color:#CC0000;"><strong>TICKET NO PUEDE SER ELIMINADO <br/><br/>POR ESTA TAQUILLA!</strong></p>';
            $acceso=0;
        }
    }
    if ($totalRows_Recordset2>=1 && $row_Recordset2['est_ticket']==1 && $row_Recordset2['est_carrera']==1 && $acceso==1 &&
        $row_Recordset2['hor_carrera']>=$horaactual && $xVendedor_Recordset1==$row_Recordset2['id_usuario']) {
        $mensaje="TICKET #".$serial.$numerotiket2." <br/><br/> ELIMINADO CORRECTAMENTE! <br/>";
        
        $query_Recordset3 = sprintf(
            "/* PARSEADORES1 ventashnac_mie\ventas_eliminar_ticket.php - QUERY 4 */ SELECT num_ticket 
			FROM 
			venta 
			WHERE 
			venta.ticket = %s",
            GetSQLValueString($numerotiket2, "int")
        );
        $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
        $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
        $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
        $y=0;
        if ($totalRows_Recordset3>0) {
            do {
                $nTicket[]=$row_Recordset3['num_ticket'];
                $y++;
            } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
            $x=0;
            $fec_pago=fechaactualbd();
            $horaPago=horaactual();
            $est_ticket="0";
            do {
                $updateSQL3 = sprintf(
                    "/* PARSEADORES1 ventashnac_mie\ventas_eliminar_ticket.php - QUERY 5 */ UPDATE venta SET est_ticket=%s, fec_pago=%s, hor_pago=%s WHERE num_ticket=%s",
                    GetSQLValueString($est_ticket, "int"),
                    GetSQLValueString($fec_pago, "date"),
                    GetSQLValueString($horaPago, "date"),
                    GetSQLValueString($nTicket[$x], "int")
                );
                
                $Result3 = mysqli_query($conexionbanca, $updateSQL3) or die(mysqli_error($conexionbanca));
                $x++;
            } while ($x < $y);
            $aElim=$maximo-$totaleliminados;
            $mensaje=$mensaje.'<br/><p style="font-size:12px;color:#000000;">Tiene la posibilidad de eliminar '.$aElim.' ticket(s) mas por hoy</p>';
        } else {
            $mensaje="<br/><br/><h3>SE PRODUJO UN ERROR AL INTENTAR ELIMINAR EL TICKET!</h3>";
        }
        mysqli_free_result($Recordset3);
    } else {
        if ($totalRows_Recordset2<=0) { //Ticket no encontrado
            $mensaje="TICKET #".$serial.$numerotiket2." <br/><br/> NO ENCONTRADO";
        }
        if ($totalRows_Recordset2>=1 && $row_Recordset2['est_ticket']==0) { //Ticket ya ha sido eliminado
            $mensaje="TICKET #".$serial.$numerotiket2." <br/><br/><h3>HA SIDO ELIMINADO ANTERIORMENTE!</h3>";
        }
        if ($totalRows_Recordset2>=1 && $row_Recordset2['est_ticket']==2) { //Ticket no puede ser eliminado;
            $mensaje="TICKET #".$serial.$numerotiket2." <br/><br/>NO PUEDE SER ELIMINADO!";
        }
        if ($totalRows_Recordset2>=1 && $row_Recordset2['est_ticket']==1 &&
            $row_Recordset2['est_carrera']==0) { //Carrera ha sido cerrada";
            $mensaje="TICKET #".$serial.$numerotiket2." <br/><br/><h3>NO PUEDE SER ELIMINADO!<br/><br/>CARRERA CERRADA</h3>";
        }
        if ($totalRows_Recordset2>=1 && $row_Recordset2['est_ticket']==1 &&
            $row_Recordset2['hor_carrera']<=$horaactual) { //Carrera ha sido cerrada;
            $mensaje="TICKET #".$serial.$numerotiket2." <br/><br/><h3>NO PUEDE SER ELIMINADO!<br/><br/>CARRERA CERRADA</h3>";
        }
        if ($totalRows_Recordset2>=1 && $row_Recordset2['est_ticket']==1 && $row_Recordset2['est_carrera']==1 &&
            $row_Recordset2['hor_carrera']>=$horaactual &&
            $xVendedor_Recordset1!=$row_Recordset2['id_usuario']) { //Ticket no vendido por este usuario
            $mensaje="TICKET #".$serial.$numerotiket2." <br/><br/><h3>NO PUEDE SER ELIMINADO <br/><br/>POR ESTE USUARIO!</h3>";
        }
    }
    mysqli_free_result($Recordset2);
} else {
    $mensaje="<br/><br/><h3>HA SUPERADO EL MAXIMO <br/><br/>DE TICKET A ELIMINAR</h3>";
}
mysqli_free_result($Recordset1);
echo  "<h2>".$mensaje."</h2>";
?>
<style>@charset "utf-8";body{margin:0;padding:0;font-family:Tahoma, Geneva, sans-serif;font-size:14px;color:#000;background-color:#E5E5E5;background-repeat:repeat-x;background-image:none;text-align:center}.btn-primary,.btn-primary:hover{color:#fff;text-shadow:0 -1px 0 rgba(0,0,0,0.25)}.btn-primary.active{color:rgba(255,255,255,0.75)}.btn-primary{background-color:#0074cc;*background-color:#05c;background-image:-ms-linear-gradient(top,#08c,#05c);background-repeat:repeat-x;border-color:#05c #05c #003580;border-color:rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);filter:progid:dximagetransform.microsoft.gradient(startColorstr='#0088cc',endColorstr='#0055cc',GradientType=0);filter:progid:dximagetransform.microsoft.gradient(enabled=false)}
</style>
<?php
if (isset($_GET["pagoSIN"])) {?>
	<div style="width:100%; float:left; text-align:right; padding:100px 0px 0px 0px; color:#FFF; font-size:28px; text-align:center">
		<input type="button" style="width:120px; font-size:18px; height:50px" title="volver" value="Volver" class="btn-primary" 
		onclick="location.href = '../ventasmie/eli_tic_sincodigo.php?recordID=<?php echo "1";?>&uVenta=<?php echo $xVendedor_Recordset1;?>'"/>	</div>
<?php } ?>