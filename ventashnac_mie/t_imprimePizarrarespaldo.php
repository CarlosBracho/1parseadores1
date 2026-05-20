<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$xTicket_Recordset1=0;
$usuario_venta=0;
if (isset($_GET["uVenta"])) {
    $vendedor = $_GET["uVenta"];
    $carrera =  $_GET["uCarre"];
    
    $acceso=1;
    $query_Recordset2 = sprintf(
        "/* PARSEADORES1 ventashnac_mie\t_imprimePizarrarespaldo.php - QUERY 1 */ SELECT 
			inscritos.num_caballo_hnac, 
			inscritos.nom_caballo_hnac,
			inscritos.est_inscrito_hnac, 
			inscritos.est_favorito_hnac,
			carrera_hnac.can_caballos_hnac,
			carrera_hnac.fec_carrera_hnac,
			carrera_hnac.num_carrera_hnac,
			hipodromo_hnac.nom_hipodromo_hnac
			FROM 
				inscritos,
				carrera_hnac,
				hipodromo_hnac
			WHERE
				carrera_hnac.cod_carrera_hnac =  inscritos.cod_carrera_hnac AND 
				hipodromo_hnac.cod_hipodromo_hnac = carrera_hnac.cod_hipodromo_hnac AND
				carrera_hnac.cod_carrera_hnac = %s 
			ORDER BY 
				inscritos.num_caballo_hnac ASC",
        GetSQLValueString($carrera, "int")
    );
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
    $ejeMax=$row_Recordset2['can_caballos_hnac'];
    $fec=$row_Recordset2['fec_carrera_hnac'];
    $hip=$row_Recordset2['nom_hipodromo_hnac'];
    $num=$row_Recordset2['num_carrera_hnac'];
} else {
    $acceso=0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title>.:Apuestas Hípicas:.</title>
<script language="JavaScript">function GetIEVersion(){var e=window.navigator.userAgent,t=e.indexOf("MSIE");return t>0?parseInt(e.substring(t+5,e.indexOf(".",t))):navigator.userAgent.match(/Trident\/7\./)?11:0}function doprint2(e){document.getElementById(e);window.print(e)}("Microsoft Internet Explorer"==navigator.appName||GetIEVersion()>0)&&document.write('<object id="factory" classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814" codebase="ScriptX.cab#Version=6,5,439,72"></object>');</script>
<script language="vbscript">
function doPrint1()
	document.all.item("noprint").style.display="none"
	document.all.item()
	with factory.printing
	.header = ""
	.footer = ""
	.topMargin = 0.4
	.bottomMargin = 0.4
	.leftMargin = 0.4
	.rightMargin = 0.4
	.Print(false)
	end with
	document.all.item("noprint").style.display=""
end function
</script>
</head>
<body>
<?php
    if ($acceso==1) {
        echo '<div id="printtitle" align="left" style="margin: 0px">'; ?>
		<table width="120px" border="0" style="font-size:11px"> 
			<tr>
				<td colspan="4" align="center">
				<?php
                    echo strtoupper($_GET["uNombr"])." - ";
        echo strtoupper($_GET["uTaqui"])."<BR/>";
        echo strtoupper($hip)." #".$num."<BR/>";
        ;
        echo fechanueva($fec); ?>
                </td>
			<tr>
			<?php
            $totCarr=0;
        if (isset($totalRows_Recordset2) && $totalRows_Recordset2>0) {
            do {
                if ($row_Recordset2['est_favorito_hnac']==1) {
                    $tipFav="F1";
                } elseif ($row_Recordset2['est_favorito_hnac']==2) {
                    $tipFav="F2";
                } elseif ($row_Recordset2['est_favorito_hnac']==3) {
                    $tipFav="F3";
                } else {
                    $tipFav="";
                }
                if ($row_Recordset2['est_inscrito_hnac']==0) {?>
                    <td width="7%"><?php echo $row_Recordset2['num_caballo_hnac']; ?></td>
                    <td colspan="2" >RETIRADO</td>
                    <?php
                    } else {
                        $gan=0;
                        $pla=0;
                        $mon=0;
                        //if ($totalRows_Recordset1>0) {
                        list($gan, $pla, $mon)=venPorCabUsu($carrera, $vendedor, $row_Recordset2['num_caballo_hnac'], $fec);
                        $totCarr=$totCarr+$mon;
                        //}?>
			<tr>
				<td width="7%"><?php echo $row_Recordset2['num_caballo_hnac']; ?></td>
				<td width="5%"><?php echo $tipFav; ?></td>
				<td width="40%" align="right"><?php echo number_format($gan, 2, ",", "."); ?></td>
			  <?php
                    } ?>
			  </tr>
					<?php
            } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
        } ?>
			</table>
			<table width="120px" border="0">
				<tr>
					<td style="text-align:right">
						TOTAL:&nbsp;<?php echo number_format($totCarr, 2, ",", "."); ?>
					</td>
			  </tr>
</table>
	<?php
    echo "</div>"; ?>
	<div id="noprint" align="center">
		<div align="left">
		  <script language="JavaScript">
			doPrint1();
			window.close();
            </script>
	    </div>
    </div>
	<?php
    } else {
        echo "<p><h1>No se produjo ningún resultado</h1></p>";
    } ?>
</body>
</html>
<?php
mysqli_free_result($Recordset2);
?>