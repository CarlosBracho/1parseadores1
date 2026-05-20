<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xTicket_Recordset1 = "0";
$xserTic="";
$xnroTicket="";
$navegador=detect(); if ($navegador['browser']=="IE") {
    $espacio="<br/><br/>";
} else {
    $espacio="<br/><br/>";
}
if (isset($_POST["pagarT"])) {
    $xVendedor_Recordset1=$_POST["id_usuario_pago"];
    $numerotiket2=substr($_POST['pagarT'], 2, strlen($_POST['pagarT'])-2);
    $serial=substr($_POST['pagarT'], 0, 2);
    echo "<hr/> <p style='font-size:20px; color:#CC0000'> ELIMINAR TICKET".$espacio;
}

if (isset($_GET["pagoSIN"])) {
    $xnroTicket = $_GET["pagoSIN"];
    $numerotiket2=substr($xnroTicket, 2, strlen($xnroTicket)-2);
    $serial=substr($xnroTicket, 0, 2);
    $xVendedor_Recordset1=$_GET["uVenta"];
    echo'<div style="background:#0E5157;width:100%;float:left;padding:10px 0px 0px 0px;color:#FFF;font-size:28px;text-align:center">';
    echo'ELIMINAR TICKET';
    echo'</div>';
}


$codigoTaquilla=$_SESSION['MM_cod_taquilla'];
$fechaactual=fechaactualbd();
$totaleliminados=BuscarTicketEliminadosHNAC($xVendedor_Recordset1, $fechaactual)+1;

$query_Recordset1 = sprintf("/* PARSEADORES1 ventashnac_mie\ventas_eliminar_ticket_hnac.php - QUERY 1 */ SELECT tic_eliminados 
	FROM usuario WHERE id_usuario = %s", GetSQLValueString($xVendedor_Recordset1, "int"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$maximo=$row_Recordset1['tic_eliminados'];
$mensaje="";
if ($totaleliminados<=$maximo) {
    $query_Recordset8 = sprintf(
        "/* PARSEADORES1 ventashnac_mie\ventas_eliminar_ticket_hnac.php - QUERY 2 */ SELECT cod_taquilla 
								 FROM usuario 
								 WHERE id_usuario = %s LIMIT 1",
        GetSQLValueString($xVendedor_Recordset1, "int")
    );
    $Recordset8 = mysqli_query($conexionbanca, $query_Recordset8) or die(mysqli_error($conexionbanca));
    $row_Recordset8 = mysqli_fetch_assoc($Recordset8);
    $totalRows_Recordset8 = mysqli_num_rows($Recordset8);
    $codVenta=$row_Recordset8['cod_taquilla'];
    $query_Recordset2 = sprintf(
        "/* PARSEADORES1 ventashnac_mie\ventas_eliminar_ticket_hnac.php - QUERY 3 */ SELECT 
			venta_hnac.est_ticket_hnac, 
			venta_hnac.id_usuario, 
			venta_hnac.ser_venta_hnac,
			carrera_hnac.est_carrera_hnac, 
			carrera_hnac.hor_carrera_hnac,
			taquilla.cod_taquilla
			FROM 
			venta_hnac, carrera_hnac, taquilla, usuario
			WHERE 
			venta_hnac.cod_carrera_hnac = carrera_hnac.cod_carrera_hnac AND 
			venta_hnac.ticket_hnac = %s AND 
			venta_hnac.id_usuario = usuario.id_usuario AND
			usuario.cod_taquilla = taquilla.cod_taquilla AND
			carrera_hnac.fec_carrera_hnac = %s",
        GetSQLValueString($numerotiket2, "int"),
        GetSQLValueString($fechaactual, "date")
    );
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
    $horaactual=horaactual();
    $acceso=1;
    if ($totalRows_Recordset2>0) {
        if ($serial!=substr($row_Recordset2['ser_venta_hnac'], 0, 2)) {
            $mensaje="TICKET #".$serial.$numerotiket2.$espacio."<h3> NO ENCONTRADO</h3>";
            $acceso=0;
        }
        if ($codVenta!=$row_Recordset2['cod_taquilla']) {
            $mensaje="TICKET #".$serial.$numerotiket2.$espacio.'<p style="font-size:18px;color:#CC0000;"><strong>TICKET NO PUEDE SER ELIMINADO <br/>POR ESTA TAQUILLA!</strong></p>';
            $acceso=0;
        }
    }
    if ($totalRows_Recordset2>=1 && $row_Recordset2['est_ticket_hnac']==1 && $row_Recordset2['est_carrera_hnac']==1 &&
        $acceso==1 && $row_Recordset2['hor_carrera_hnac']>=$horaactual &&
        $xVendedor_Recordset1==$row_Recordset2['id_usuario']) {
        $mensaje="TICKET #".$serial.$numerotiket2." <h5>ELIMINADO CORRECTAMENTE!</h5>";
        
        $query_Recordset3 = sprintf(
            "/* PARSEADORES1 ventashnac_mie\ventas_eliminar_ticket_hnac.php - QUERY 4 */ SELECT num_ticket_hnac 
			FROM 
			venta_hnac
			WHERE 
			venta_hnac.ticket_hnac = %s",
            GetSQLValueString($numerotiket2, "int")
        );
        $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
        $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
        $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
        $y=0;
        if ($totalRows_Recordset3>0) {
            do {
                $nTicket[]=$row_Recordset3['num_ticket_hnac'];
                $y++;
            } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));
            $x=0;
            $fec_pago=fechaactualbd();
            $horaPago=horaactual();
            $est_ticket="0";
            do {
                $updateSQL3 = sprintf(
                    "/* PARSEADORES1 ventashnac_mie\ventas_eliminar_ticket_hnac.php - QUERY 5 */ UPDATE venta_hnac SET est_ticket_hnac=%s, fec_pago_hnac=%s, hor_pago_hnac=%s 
				WHERE num_ticket_hnac=%s",
                    GetSQLValueString($est_ticket, "int"),
                    GetSQLValueString($fec_pago, "date"),
                    GetSQLValueString($horaPago, "date"),
                    GetSQLValueString($nTicket[$x], "int")
                );
                
                $Result3 = mysqli_query($conexionbanca, $updateSQL3) or die(mysqli_error($conexionbanca));
                $x++;
            } while ($x < $y);
            $aElim=$maximo-$totaleliminados;
            $mensaje=$mensaje.'<p style="font-size:12px;color:#000000;">puede eliminar '.$aElim.' ticket(s) mas por hoy</p>';
        } else {
            $mensaje=$espacio."<h3>SE PRODUJO UN ERROR AL INTENTAR ELIMINAR EL TICKET!</h3>";
        }
        mysqli_free_result($Recordset3);
    } else {
        if ($totalRows_Recordset2<=0) { //Ticket no encontrado
            $mensaje="TICKET #".$serial.$numerotiket2.$mensaje." <h3>NO ENCONTRADO</h3>";
        }
        if ($totalRows_Recordset2>=1 && $row_Recordset2['est_ticket_hnac']==0) { //Ticket ya ha sido eliminado
            $mensaje="TICKET #".$serial.$numerotiket2.$mensaje."<h3>HA SIDO ELIMINADO ANTERIORMENTE!</h3>";
        }
        if ($totalRows_Recordset2>=1 && $row_Recordset2['est_ticket_hnac']==2) { //Ticket no puede ser eliminado;
            $mensaje="TICKET #".$serial.$numerotiket2.$mensaje."<h3>NO PUEDE SER ELIMINADO!</h3>";
        }
        if ($totalRows_Recordset2>=1 && $row_Recordset2['est_ticket_hnac']==1 &&
            $row_Recordset2['est_carrera_hnac']==0) { //Carrera ha sido cerrada";
            $mensaje="TICKET #".$serial.$numerotiket2.$mensaje."<h3>NO PUEDE SER ELIMINADO!".$mensaje."CARRERA CERRADA</h3>";
        }
        if ($totalRows_Recordset2>=1 && $row_Recordset2['est_ticket_hnac']==1 &&
            $row_Recordset2['hor_carrera_hnac']<=$horaactual) { //Carrera ha sido cerrada;
            $mensaje="TICKET #".$serial.$numerotiket2.$mensaje."<h3>NO PUEDE SER ELIMINADO!<br/><br/>CARRERA CERRADA</h3>";
        }
        if ($totalRows_Recordset2>=1 && $row_Recordset2['est_ticket_hnac']==1 && $row_Recordset2['est_carrera_hnac']==1 &&
            $row_Recordset2['hor_carrera_hnac']>=$horaactual &&
            $xVendedor_Recordset1!=$row_Recordset2['id_usuario']) { //Ticket no vendido por este usuario
            $mensaje="TICKET #".$serial.$numerotiket2.$mensaje."<h3>NO PUEDE SER ELIMINADO <br/><br/>POR ESTE USUARIO!</h3>";
        }
    }
    mysqli_free_result($Recordset2);
} else {
    $mensaje=$mensaje."<h3>HA SUPERADO EL MAXIMO <br/><br/>DE TICKET A ELIMINAR</h3>";
}
mysqli_free_result($Recordset1);
echo  $mensaje;
?>
<style>@charset "utf-8";body{margin:0;padding:0;font-family:Tahoma, Geneva, sans-serif;font-size:14px;color:#000;background-color:#E5E5E5;background-repeat:repeat-x;background-image:none;text-align:center}.btn-primary,.btn-primary:hover{color:#fff;text-shadow:0 -1px 0 rgba(0,0,0,0.25)}.btn-primary.active{color:rgba(255,255,255,0.75)}.btn-primary{background-color:#0074cc;*background-color:#05c;background-image:-ms-linear-gradient(top,#08c,#05c);background-repeat:repeat-x;border-color:#05c #05c #003580;border-color:rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);filter:progid:dximagetransform.microsoft.gradient(startColorstr='#0088cc',endColorstr='#0055cc',GradientType=0);filter:progid:dximagetransform.microsoft.gradient(enabled=false)}
</style>
<?php
if (isset($_GET["pagoSIN"])) {?>
	<div style="width:100%; float:left; text-align:right; padding:100px 0px 0px 0px; color:#FFF; font-size:28px; text-align:center">
		<input type="button" style="width:120px; font-size:18px; height:50px" title="volver" value="Volver" class="btn-primary" 
		onclick="location.href = '../ventashnac_mie/eli_tic_sincodigo_hnac.php?recordID=<?php echo "1";?>&uVenta=<?php echo $xVendedor_Recordset1;?>'"/>	</div>
<?php } ?>