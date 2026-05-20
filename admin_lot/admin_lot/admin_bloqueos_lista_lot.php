<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "A"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$menPrin="";
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$query_Recordset1 =  sprintf("/* PARSEADORES1 admin_lot\admin_lot\admin_bloqueos_lista_lot.php - QUERY 1 */ SELECT 
	ba.nom_banca, ba.nom_representante, ba.cod_banca,
		(/* PARSEADORES1 admin_lot\admin_lot\admin_bloqueos_lista_lot.php - QUERY 2 */ SELECT 
			GROUP_CONCAT(bl.num_bloqueado, 'x',
				(CASE bl.id_loteria
					WHEN 0 THEN 'TODAS'
					ELSE (/* PARSEADORES1 admin_lot\admin_lot\admin_bloqueos_lista_lot.php - QUERY 3 */ SELECT lo.nom_loteria FROM loterias lo WHERE lo.id_loteria = bl.id_loteria LIMIT 1)
				END)
			SEPARATOR ']&nbsp;&nbsp;[')
			
		FROM bloqueadoloterias bl WHERE bl.id_banca = ba.cod_banca) AS bloqueados
	FROM banca ba 
	ORDER BY bloqueados DESC, ba.nom_banca ASC");
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:Apuestas Hípicas:.</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 7]><link type="text/css" rel="stylesheet" media="all" href="../css/screen_ie.css" /><![endif]-->
<style>
body {background-color: #eeeeee;padding:0;margin:0 auto;font-family:"Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;	font-size:11px;}
</style>
<link href="../estilo/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<script type="text/javascript" src="../js/tcal.js"></script>
<script src="../js/jquery-1.9.1.min.js"></script>
<script>
 $(document).ready(function() {$("#reloj").load('../includes/reloj.php?&js='+Math.random());var refreshId1 = setInterval(function() {$("#reloj").load('../includes/reloj.php?&js='+Math.random());}, 60000);});
</script>
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
	<div class="container">
		<div class="header" style="height:100px; background:#0084B4">
			<?php include("../includes/cabeceraamericana.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup" style=" margin:0px 0px 0px 205px"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
						<?php include("../includes/cabecera_lot.php");?>
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#0084B4; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" 
        	id="datosUsuario">
        	<div style="background:#0084B4;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            	margin:20px 0px 0px 0px; width:240px; font-size:16px"> 
              BLOQUEO TRIPLES <br/>Y TERMINALES
		    </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
		<div class="contentAdmin">
			<div style="padding:15px 0; float:right; color:#FFFFFF; background:#FF9A9C; border: 0px solid #000000; margin:5px; 
            	font-size:20px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;
                border-radius: 5px 5px 5px 5px;-moz-border-radius: 5px 5px 5px 5px;-webkit-border-radius: 5px 5px 5px 5px"
                id="divPrin">
				<?php echo $menPrin; ?>
			</div>
			<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
				<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
					<table width="920" align="center" border="0" cellpadding="0" cellspacing="0">
						<tr valign="baseline">
							<td height="52" colspan="10" align="center" valign="middle" nowrap 
								style="background:#333333; font-size:24px; color: #FFF">
								<strong>BLOQUEO DE TRIPLES Y TERMINALES</strong>
							</td>
						</tr>
					</table>
                    <table width="100%" align="center" border="1" cellpadding="0" cellspacing="0">
						<tr style="background:#0084B4; color:#FFFFFF; height:30px; font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif; text-align:center" valign="bottom">
                            <td width="27%">DISTRIBUIDOR</td>
                            <td width="63%">BLOQUEOS</td>
                            <td width="10%">ACCION</td>
                        </tr><?php
                        do { ?>
                            <tr class="brillo" style="border-bottom:1px solid  #D5D5D5" valign="bottom">
                                <td align="left" style="line-height:1.1;"><?php
                                    echo $row_Recordset1['nom_banca']."<br/><font face='times new roman' size=1.5>";
                                    echo $row_Recordset1['nom_representante']."</font>";?>
                                </td>
                                <td style="font-size:11px" valign="top"><?php
                                    if ($row_Recordset1['bloqueados']!="") {
                                        echo "[".$row_Recordset1['bloqueados']."]";
                                    }?>
                                </td>
                                <td style="font-size:11px;" align="center">
                                    <a href='admin_bloqueo_edit_lot.php?recordID=<?php echo $row_Recordset1['cod_banca']; ?>'
                                        class="btn btn-info" style="text-decoration:none;line-height:1.1;font-size:10px"> 
                                        INCLUIR<BR/>EDITAR 
                                    </a>
                                </td>
                            </tr><?php
                        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
                    </table>
                    
				</div>
			</div>
		</div>
		<div class="footer" style="background:#0084B4">Copyright © Apuestas Hípicas</div>
	</div>
</body>
</html>
<?php
if (isset($Recordset1)) {
                            mysqli_free_result($Recordset1);
                        }
if (isset($Recordset2)) {
    mysqli_free_result($Recordset2);
}
?>