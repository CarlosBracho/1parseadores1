<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
list($horacarr, $hipodomo, $numeroca, $restante, $horacier)=consultaPacificna();
$fech=fechaactualbd();
$horasistema=horaactual();
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\admin\minutos_carrera.php - QUERY 1 */ SELECT * FROM carrera WHERE eje_primero=0 AND fec_carrera=%s",
    GetSQLValueString($fech, "date")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>.:Apuestas Hípicas:.</title>
<meta http-equiv="Refresh" content="5">
<link href="../estilo/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
</head>
<body>
<div class="container">
    <div style="background: #036; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align: center; font-size:34px"
    	id="datosUsuario">
        MINUTOS PARA LA CARRERA
	</div>
</div>
<div class="contentAdmin">
	<div style="padding:10px 10px 20px 10px; text-align:left; font-size:18px; height: auto" id="divControl">
        <div style="background: #F90; color: #FFF; width:758px">
        <table width="755" border="0">
          <tr>
            <td height="41" colspan="4" align="right" valign="middle" 
            	style="font-size:36px; color:#000000"><?php echo $horasistema ?></td>
          </tr>
          <tr>
            <td width="100"> CIERRE</td>
            <td width="510">HIPODROMO</td>
            <td width="51" align="center">#</td>
            <td width="80" align="center">RESTAN</td>
          </tr>
        </table>
        </div>
        <table width="755" border="1">
        <?php
        if ($totalRows_Recordset1>0) {
            $t=0;
            do {
                $f=0;
                $cont=1;
                if ($hipodomo[0]!="") {
                    foreach ($hipodomo as $hip) {
                        if (trim($hipodomo[$f])==trim($row_Recordset1['nom_hipodromo'])
                            && $numeroca[$f]==$row_Recordset1['num_carrera']) {
                            $hora=explode(" ", $horacarr[$f]);
                            $hor_carrera=horamysqlMTP($horacier[$f].":".$hora[1]);
                            $cod_carrera=$row_Recordset1['cod_carrera'];
                            $mtp_control=1;
                            $est=1; ?>
                              <tr>
                                <td width="100" align="center"><?php echo cambioHoramysql($hor_carrera); ?></td>
                                <td width="510"><?php echo $row_Recordset1['nom_hipodromo']; ?></td>
                                <td width="51" align="center"><?php echo $row_Recordset1['num_carrera']; ?></td>
                                <td width="80" align="right"><?php echo $restante[$f]." min."; ?></td>
                                
                              </tr>
                            <?php
                                $updateSQL = sprintf(
                                "/* PARSEADORES1 new\admin\minutos_carrera.php - QUERY 2 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s, est_carrera=%s 
                                                      WHERE cod_carrera=%s",
                                GetSQLValueString($hor_carrera, "date"),
                                GetSQLValueString($hor_carrera, "date"),
                                GetSQLValueString(1, "int"),
                                GetSQLValueString($cod_carrera, "int")
                            );
                                
                            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                            $cont=0;
                            break;
                        }
                        $f++;
                    }
                }
                if ($cont==1) {
                    if ($row_Recordset1['hor_carrera']>$horasistema && $row_Recordset1['est_carrera']==1) {
                        $cod_carrera=$row_Recordset1['cod_carrera'];
                        $est=0;
                        $updateSQL = sprintf(
                            "/* PARSEADORES1 new\admin\minutos_carrera.php - QUERY 3 */ UPDATE carrera SET hor_carrera=%s, hor_mtp=%s, est_carrera=%s
                                      WHERE cod_carrera=%s",
                            GetSQLValueString($horasistema, "date"),
                            GetSQLValueString($horasistema, "date"),
                            GetSQLValueString(0, "int"),
                            GetSQLValueString($cod_carrera, "int")
                        );
                        
                        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                    }
                }
            } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
            mysqli_free_result($Recordset1);
        } else {?>
        	<tr>
            	<td align="center">NO SE ENCONTRARON REGISTROS</td>
            </tr>
        </table>
        <?php }?>        
	</div>
</div>
</body>
</html>