<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$menTaq="";
$menNre="";
$menTel="";
$menAmig="";	//monto apuesta minima a gan
$menAmag="";
$menRgan="";
$menMgan="";	// monto maximo a ganar a ganador
$menMmt="";		// monto maximo en ticket
$menAmip="";	//monto apuesta minima a pla
$menAmap="";
$menRpla="";
$menMpla="";
$menAmis="";	//monto apuesta minima a sho
$menAmas="";
$menRsho="";
$menMsho="";
$menMmae="";
$menAmie="";	//monto apuesta minima a exa
$menAmae="";
$menRexa="";
$menMexa="";
$menAmit="";	//monto apuesta minima a tri
$menAmat="";
$menRtri="";
$menMtri="";
$menAmisu="";	//monto apuesta minima a sup
$menAmasu="";
$menRsup="";
$menMsup="";
$menNus="";
$menNti="";
$menTeli="";	// maximo ticket a eliminar
$menOpNac="";
$mendiv_pdes1="";
$mendiv_phas1="";
$menpag_pdiv1="";
$mendiv_pdes2="";
$mendiv_phas2="";
$menpag_pdiv2="";
include("../includes/taquilla_estandar.php");

$xCodigo = "-1";
$xCodigo2 = "-1";
$editFormAction = $_SERVER['PHP_SELF'];
$editFormAction2 = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction2 .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if (isset($_GET["recordID"])) {
    $xCodigo = $_GET["recordID"];
    $xCodigo2 = $_GET["recordID"];
}
$query_Recordset1 =  sprintf(
    "/* PARSEADORES1 new\agente\agente_taquillas_edit_ame.php - QUERY 1 */ SELECT  
	ta.nom_taquilla, ta.nom_representante, ta.tel_taquilla, ta.tel_taquilla2, ta.tel_taquilla3, ta.est_taquilla, ta.cod_taquilla,
	ag.nom_agencia, ag.cod_agencia, ta.moneda 
	FROM  taquilla ta, agencia ag 
	WHERE ta.cod_taquilla = %s AND ag.cod_agencia = ta.cod_agencia LIMIT 1",
    GetSQLValueString($xCodigo, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$query_Recordset4 =  sprintf(
    "/* PARSEADORES1 new\agente\agente_taquillas_edit_ame.php - QUERY 2 */ SELECT  
	tp.pag_codigo, tp.apu_maxgan, tp.apu_maxpla, tp.apu_maxsho, tp.apu_maxexa, tp.apu_maxtri, tp.apu_maxsup, tp.apu_mingan,
	tp.apu_minpla, tp.apu_minsho, tp.apu_minexa, tp.apu_mintri, tp.apu_minsup, tp.reg_gan, tp.reg_pla, tp.reg_sho, tp.reg_exa,
	tp.reg_tri, tp.reg_sup, tp.est_gan, tp.est_pla, tp.est_sho, tp.est_exa, tp.est_tri, tp.est_sup, tp.max_aganar_gan,
	tp.max_aganar_pla, tp.max_aganar_sho, tp.max_aganar_exa, tp.max_aganar_tri, tp.max_aganar_sup, tp.mon_maxticket, 
	tp.mon_maxejemplar, tp.min_ejecarrera, tp.cod_taopcame, tp.por_taquilla, tp.est_impresion, tp.anu_regalia, tp.tic_caduca,
	tp.tip_ticket, tp.tie_reclamo, tp.ver_porpagar, tp.def_regdiv1, tp.div_pdes1, tp.div_phas1, tp.pag_pdiv1, tp.opc_ame, 
    tp.div_pdes2, tp.div_phas2, tp.pag_pdiv2, tp.opc_ame2
	FROM   taquilla ta, taquilla_opc_ame tp 
    WHERE ta.cod_taquilla = %s AND tp.cod_taquilla = ta.cod_taquilla
	LIMIT 1",
    GetSQLValueString($xCodigo, "int")
);
$Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
$row_Recordset4 = mysqli_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysqli_num_rows($Recordset4);
$porcentaje=0;
if ($totalRows_Recordset4>0) {
    $existe=1;
    $porcentaje=$row_Recordset4['por_taquilla'];
}
if ($totalRows_Recordset4==0 && (!isset($_POST["MM_insert2"]))) {
    $cod_taopcame="";
    $est_impresion=0;
    $apu_mingan=10;
    $apu_maxgan=50000;
    $reg_gan=0;
    $max_aganar_gan=20;
    $est_gan=1;
    $est_pla=1;
    $est_sho=1;
    $anu_regalia=0;
    $ver_porpagar=0;
    $tie_reclamo=0;
    $tic_caduca=0;
    $mon_maxejemplar=20000;
    $tip_ticket=0;
    $min_ejecarrera=4;
    $pag_codigo=0;
    $est_impresion=0;
    $mon_maxticket=100000;
    $apu_minpla=10;
    $apu_maxpla=50000;
    $reg_pla=0;
    $max_aganar_pla=16;
    $apu_minsho=10;
    $apu_maxsho=50000;
    $reg_sho=0;
    $max_aganar_sho=10;
    $apu_minexa=10;
    $apu_maxexa=10000;
    $reg_exa=0;
    $max_aganar_exa=200;
    $est_exa=0;
    $apu_mintri=10;
    $apu_maxtri=10000;
    $reg_tri=0;
    $max_aganar_tri=300;
    $est_tri=0;
    $apu_minsup=10;
    $apu_maxsup=10000;
    $reg_sup=0;
    $max_aganar_sup=400;
    $est_sup=0;
    $menOpNac="ATENCIÓN: Los datos para Carreras Americanas de esta taquilla no han sido creadas";
    $existe=0;
    $porcentaje=2;
    $def_regdiv1=0;
    $div_pdes1=0.10;
    $div_phas1=1;
    $pag_pdiv1=0;
    $opc_ame=0;
    $div_pdes2=0.10;
    $div_phas2=1;
    $pag_pdiv2=0.00;
    $opc_ame2=0;
    include("../includes/taquilla_estandar.php");
} else {
    $cod_taopcame=$row_Recordset4['cod_taopcame'];
    if ((isset($_POST["MM_insert2"])) && ($_POST["MM_insert2"] == "form2")) {
        if (isset($_POST["exp_agencia"]) && $_POST["exp_agencia"]>0) {
            $r4=$totalRows_Recordset4;
            $query_Recordset4 =  sprintf(
                "/* PARSEADORES1 new\agente\agente_taquillas_edit_ame.php - QUERY 3 */ SELECT  
				ta.pag_codigo, tp.apu_maxgan, tp.apu_maxpla, tp.apu_maxsho, tp.apu_maxexa, tp.apu_maxtri, tp.apu_maxsup,
				tp.apu_mingan, tp.apu_minpla, tp.apu_minsho, tp.apu_minexa, tp.apu_mintri, tp.apu_minsup, tp.reg_gan, tp.reg_pla,
				tp.reg_sho, tp.reg_exa, tp.reg_tri, tp.reg_sup, tp.est_gan, tp.est_pla, tp.est_sho, tp.est_exa, tp.est_tri, 
				tp.est_sup, tp.max_aganar_gan, tp.max_aganar_pla, tp.max_aganar_sho, tp.max_aganar_exa, tp.max_aganar_tri, 
				tp.max_aganar_sup, tp.mon_maxticket, tp.mon_maxejemplar, tp.min_ejecarrera, tp.cod_taopcame, tp.por_taquilla,
				tp.est_impresion, tp.anu_regalia, tp.tic_caduca, tp.tip_ticket, tp.tie_reclamo, tp.ver_porpagar, tp.def_regdiv1, tp.div_pdes1, tp.div_phas1,
                 tp.pag_pdiv1, tp.opc_ame, tp.div_pdes2, tp.div_phas2, tp.pag_pdiv2, tp.opc_ame2
				FROM  taquilla ta, taquilla_opc_ame tp 
				WHERE ta.cod_taquilla = %s AND tp.cod_taquilla = ta.cod_taquilla
				LIMIT 1",
                GetSQLValueString($_POST["exp_agencia"], "int")
            );
            $Recordset4 = mysqli_query($conexionbanca, $query_Recordset4) or die(mysqli_error($conexionbanca));
            $row_Recordset4 = mysqli_fetch_assoc($Recordset4);
            $totalRows_Recordset4 = mysqli_num_rows($Recordset4);
            if ($r4==0) {
                $menOpNac="ATENCIÓN: Los datos para Carreras Americanas de esta taquilla no han sido creadas*";
            }
        }
    }
    $apu_mingan=$row_Recordset4['apu_mingan'];
    $apu_maxgan=$row_Recordset4['apu_maxgan'];
    $reg_gan=$row_Recordset4['reg_gan'];
    $max_aganar_gan=$row_Recordset4['max_aganar_gan'];
    $est_gan=$row_Recordset4['est_gan'];
    $est_pla=$row_Recordset4['est_pla'];
    $est_sho=$row_Recordset4['est_sho'];
    $anu_regalia=$row_Recordset4['anu_regalia'];
    $ver_porpagar=$row_Recordset4['ver_porpagar'];
    $tie_reclamo=$row_Recordset4['tie_reclamo'];
    $tic_caduca=$row_Recordset4['tic_caduca'];
    $mon_maxejemplar=$row_Recordset4['mon_maxejemplar'];
    $tip_ticket=$row_Recordset4['tip_ticket'];
    $min_ejecarrera=$row_Recordset4['min_ejecarrera'];
    $pag_codigo=$row_Recordset4['pag_codigo'];
    $est_impresion=$row_Recordset4['est_impresion'];
    $mon_maxticket=$row_Recordset4['mon_maxticket'];
    $apu_minpla=$row_Recordset4['apu_minpla'];
    $apu_maxpla=$row_Recordset4['apu_maxpla'];
    $reg_pla=$row_Recordset4['reg_pla'];
    $max_aganar_pla=$row_Recordset4['max_aganar_pla'];
    $apu_minsho=$row_Recordset4['apu_minsho'];
    $apu_maxsho=$row_Recordset4['apu_maxsho'];
    $reg_sho=$row_Recordset4['reg_sho'];
    $max_aganar_sho=$row_Recordset4['max_aganar_sho'];
    $apu_minexa=$row_Recordset4['apu_minexa'];
    $apu_maxexa=$row_Recordset4['apu_maxexa'];
    $reg_exa=$row_Recordset4['reg_exa'];
    $max_aganar_exa=$row_Recordset4['max_aganar_exa'];
    $est_exa=$row_Recordset4['est_exa'];
    $apu_mintri=$row_Recordset4['apu_mintri'];
    $apu_maxtri=$row_Recordset4['apu_maxtri'];
    $reg_tri=$row_Recordset4['reg_tri'];
    $max_aganar_tri=$row_Recordset4['max_aganar_tri'];
    $est_tri=$row_Recordset4['est_tri'];
    $apu_minsup=$row_Recordset4['apu_minsup'];
    $apu_maxsup=$row_Recordset4['apu_maxsup'];
    $reg_sup=$row_Recordset4['reg_sup'];
    $max_aganar_sup=$row_Recordset4['max_aganar_sup'];
    $est_sup=$row_Recordset4['est_sup'];
    $def_regdiv1=$row_Recordset4['def_regdiv1'];
    $div_pdes1=$row_Recordset4['div_pdes1'];
    $div_phas1=$row_Recordset4['div_phas1'];
    $pag_pdiv1=$row_Recordset4['pag_pdiv1'];
    $opc_ame=$row_Recordset4['opc_ame'];
    $div_pdes2=$row_Recordset4['div_pdes2'];
    $div_phas2=$row_Recordset4['div_phas2'];
    $pag_pdiv2=$row_Recordset4['pag_pdiv2'];
    $opc_ame2=$row_Recordset4['opc_ame2'];
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $graba=31;
    if (isset($_POST['est_gan'])) {
        $_POST['est_gan']=1;
    } else {
        $_POST['est_gan']=0;
    }
    if (isset($_POST['est_pla'])) {
        $_POST['est_pla']=1;
    } else {
        $_POST['est_pla']=0;
    }
    if (isset($_POST['est_sho'])) {
        $_POST['est_sho']=1;
    } else {
        $_POST['est_sho']=0;
    }
    if (isset($_POST['est_exa'])) {
        $_POST['est_exa']=1;
    } else {
        $_POST['est_exa']=0;
    }
    if (isset($_POST['est_tri'])) {
        $_POST['est_tri']=1;
    } else {
        $_POST['est_tri']=0;
    }
    if (isset($_POST['est_sup'])) {
        $_POST['est_sup']=1;
    } else {
        $_POST['est_sup']=0;
    }
    if (isset($_POST['def_regdiv1'])) {
        $def_regdiv1 = $_POST['def_regdiv1'];
    } 
    if (!isset($_POST['apu_maxgan']) || $_POST['apu_maxgan']<=0) {
        $_POST['apu_maxgan']="";
        $menAmag= "indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_maxpla']) || $_POST['apu_maxpla']<=0) {
        $_POST['apu_maxpla']="";
        $menAmap= "indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_maxsho']) || $_POST['apu_maxsho']<=0) {
        $_POST['apu_maxsho']="";
        $menAmas= "indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_maxexa']) || $_POST['apu_maxexa']<=0) {
        $_POST['apu_maxexa']="";
        $menAmae= "indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_maxtri']) || $_POST['apu_maxtri']<=0) {
        $_POST['apu_maxtri']="";
        $menAmat= "indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_maxsup']) || $_POST['apu_maxsup']<=0) {
        $_POST['apu_maxsup']="";
        $menAmasu="indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_mingan']) || $_POST['apu_mingan']<=0) {
        $_POST['apu_mingan']="";
        $menAmig= "indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_minpla']) || $_POST['apu_minpla']<=0) {
        $_POST['apu_minpla']="";
        $menAmip= "indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_minsho']) || $_POST['apu_minsho']<=0) {
        $_POST['apu_minsho']="";
        $menAmis= "indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_minexa']) || $_POST['apu_minexa']<=0) {
        $_POST['apu_minexa']="";
        $menAmie= "indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_mintri']) || $_POST['apu_mintri']<=0) {
        $_POST['apu_mintri']="";
        $menAmit= "indique monto";
        $graba--;
    }
    if (!isset($_POST['apu_minsup']) || $_POST['apu_minsup']<=0) {
        $_POST['apu_minsup']="";
        $menAmisu="indique monto";
        $graba--;
    }
    if (!isset($_POST['reg_gan']) || $_POST['reg_gan']<0) {
        $_POST['reg_gan']="";
        $menRgan="indique monto";
        $graba--;
    }
    if (!isset($_POST['reg_pla']) || $_POST['reg_pla']<0) {
        $_POST['reg_pla']="";
        $menRpla="indique monto";
        $graba--;
    }
    if (!isset($_POST['reg_sho']) || $_POST['reg_sho']<0) {
        $_POST['reg_sho']="";
        $menRsho="indique monto";
        $graba--;
    }
    if (!isset($_POST['reg_exa']) || $_POST['reg_exa']<0) {
        $_POST['reg_exa']="";
        $menRexa="indique monto";
        $graba--;
    }
    if (!isset($_POST['reg_tri']) || $_POST['reg_tri']<0) {
        $_POST['reg_tri']="";
        $menRtri="indique monto";
        $graba--;
    }
    if (!isset($_POST['reg_sup']) || $_POST['reg_sup']<0) {
        $_POST['reg_sup']="";
        $menRsup="indique monto";
        $graba--;
    }
    if (!isset($_POST['max_aganar_gan'])||$_POST['max_aganar_gan']<=0) {
        $_POST['max_aganar_gan']="";
        $menMgan="indique monto";
        $graba--;
    }
    if (!isset($_POST['max_aganar_pla'])||$_POST['max_aganar_pla']<=0) {
        $_POST['max_aganar_pla']="";
        $menMpla="indique monto";
        $graba--;
    }
    if (!isset($_POST['max_aganar_sho'])||$_POST['max_aganar_sho']<=0) {
        $_POST['max_aganar_sho']="";
        $menMsho="indique monto";
        $graba--;
    }
    if (!isset($_POST['max_aganar_exa'])||$_POST['max_aganar_exa']<=0) {
        $_POST['max_aganar_exa']="";
        $menMexa="indique monto";
        $graba--;
    }
    if (!isset($_POST['max_aganar_tri'])||$_POST['max_aganar_tri']<=0) {
        $_POST['max_aganar_tri']="";
        $menMtri="indique monto";
        $graba--;
    }
    if (!isset($_POST['max_aganar_sup'])||$_POST['max_aganar_sup']<=0) {
        $_POST['max_aganar_sup']="";
        $menMsup="indique monto";
        $graba--;
    }
    if (!isset($_POST['mon_maxticket'])||$_POST['mon_maxticket']<=0) {
        $_POST['mon_maxticket']="";
        $menMmt="indique monto";
        $graba--;
    }
    if (!isset($_POST['mon_maxejemplar'])||$_POST['mon_maxejemplar']<=0) {
        $_POST['mon_maxejemplar']="";
        $menMmae="indique monto";
        $graba--;
    }
    if (!isset($_POST['div_pdes1']) && $_POST['def_regdiv1']==1 || $_POST['div_pdes1']<=0 && $_POST['def_regdiv1']==1) {
        $_POST['div_pdes1']=0.00;
        $mendiv_pdes1="indique monto";
        $graba--;
    }
    if (!isset($_POST['div_phas1']) && $_POST['def_regdiv1']==1 || $_POST['div_phas1']<=0 && $_POST['def_regdiv1']==1) {
        $_POST['div_phas1']=0.00;
        $mendiv_phas1="indique monto";
        $graba--;
    }
    if (!isset($_POST['div_pdes2']) && $_POST['def_regdiv1']==1 || $_POST['div_pdes2']<=0 && $_POST['def_regdiv1']==1) {
        $_POST['div_pdes2']=0.00;
        $mendiv_pdes1="indique monto";
        $graba--;
    }
    if (!isset($_POST['div_phas2']) && $_POST['def_regdiv1']==1 || $_POST['div_phas2']<=0 && $_POST['def_regdiv1']==1) {
        $_POST['div_phas2']=0.00;
        $mendiv_phas2="indique monto";
        $graba--;
    }
    if ($graba==31) {
        if (isset($row_Recordset4['reg_gan'])) {
            if ($_POST['reg_gan']<>$row_Recordset4['reg_gan'] or $_POST['reg_pla']<>$row_Recordset4['reg_pla'] or $_POST['pag_codigo']<>$row_Recordset4['pag_codigo']) {
                $reggan=$_POST['reg_gan'];
                $regpla=$_POST['reg_pla'];


                $nom_usuario=$_SESSION['MM_nom_usuario'];

                $descripcion="REGALIA MODIFICADA GAN ANTES ".$row_Recordset4['reg_gan']." Y DESPUES ".$reggan.", PLA ANTES ".$row_Recordset4['reg_pla']." Y DESPUES ".$regpla." Por: <u>".$nom_usuario."</u> A la taquilla: " .$row_Recordset1['nom_taquilla'];
                $horaactual=horaactual();
                $fechaactual=fechaactualbd();

                $msj="HA HABIDO UNA MODIFICACION EN UNA DE SUS TAQUILLAS QUE PUEDE AFECTAR SUS GANANCIAS  \n";
                $msj.= " TAQUILLA: " . $row_Recordset1['nom_taquilla'] . "\n";
                $msj.= " DEL AGENTE: " . $row_Recordset1['nom_agencia'] . "\n";

                if ($_POST['reg_gan']<>$row_Recordset4['reg_gan']) {
                    $msj.= " REGALIA A GANADOR MODIFICADA ANTES ".$row_Recordset4['reg_gan']." Y DESPUES ".$reggan."\n";
                }
                if ($_POST['reg_pla']<>$row_Recordset4['reg_pla']) {
                    $msj.= " REGALIA A PLACE MODIFICADA ANTES ".$row_Recordset4['reg_pla']." Y DESPUES ".$regpla."\n";
                }
                if ($_POST['pag_codigo']<>$row_Recordset4['pag_codigo']) {
                    if ($_POST['pag_codigo']==1) {
                        $msj.= " TAQUILLA PASO A PAGAR SIN CODIGO \n";
                    } else {
                        $msj.= " TAQUILLA PASO A PAGAR CON CODIGO \n";
                    }
                }
                $msjx=utf8_encode($msj);
        $post=[
          'chat_id'=>-1001548429339,
          'text'=>$msjx,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot5155928341:AAFaxAoro6OLjtRvCMwnri0Zyfnwd-MgPdY/sendMessage");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_exec ($ch);
        curl_close ($ch);


                $insertSQL2 = sprintf(
                    "/* PARSEADORES1 new\agente\agente_taquillas_edit_ame.php - QUERY 4 */ INSERT 
					INTO bitacora 
					(des_bitacora, hor_bitacora, codtaquilla, fec_bitacora) 
					VALUES (%s, %s, %s, %s)",
                    GetSQLValueString($msj, "text"),
                    GetSQLValueString($horaactual, "date"),
                    GetSQLValueString($row_Recordset1['cod_taquilla'], "date"),
                    GetSQLValueString($fechaactual, "date")
                );
                $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
            }
        }










        if ($_POST['existe']==1) {
            $insertSQL2 = sprintf(
                "/* PARSEADORES1 new\agente\agente_taquillas_edit_ame.php - QUERY 5 */ UPDATE taquilla_opc_ame
					SET
					pag_codigo=%s, 
					apu_maxgan=%s, 
					apu_maxpla=%s, 
					apu_maxsho=%s, 
					apu_maxexa=%s, 
					apu_maxtri=%s, 
					apu_maxsup=%s, 
					apu_mingan=%s, 
					apu_minpla=%s, 
					apu_minsho=%s,	
					apu_minexa=%s, 
					apu_mintri=%s, 
					apu_minsup=%s, 
					reg_gan=%s, 
					reg_pla=%s, 
					reg_sho=%s, 
					reg_exa=%s, 
					reg_tri=%s, 
					reg_sup=%s, 
					est_gan=%s, 
					est_pla=%s, 
					est_sho=%s, 
					est_exa=%s,
					est_tri=%s, 
					est_sup=%s, 
					max_aganar_gan=%s, 
					max_aganar_pla=%s, 
					max_aganar_sho=%s, 
					max_aganar_exa=%s, 
					max_aganar_tri=%s, 
					max_aganar_sup=%s,
					mon_maxticket=%s, 
					mon_maxejemplar=%s, 
					min_ejecarrera=%s, 
					por_taquilla=%s, 
					est_impresion=%s,
					tic_caduca=%s, 
					anu_regalia=%s,
					tip_ticket=%s,
					tie_reclamo=%s,
					ver_porpagar=%s,
                    div_pdes1=%s,
                    div_phas1=%s,
                    pag_pdiv1=%s,
                    opc_ame=%s,
                    div_pdes2=%s,
                    div_phas2=%s,
                    pag_pdiv2=%s,
                    opc_ame2=%s,
                    def_regdiv1=%s
					WHERE cod_taopcame=%s",
                GetSQLValueString($_POST['pag_codigo'], "int"),
                GetSQLValueString($_POST['apu_maxgan'], "double"),
                GetSQLValueString($_POST['apu_maxpla'], "double"),
                GetSQLValueString($_POST['apu_maxsho'], "double"),
                GetSQLValueString($_POST['apu_maxexa'], "double"),
                GetSQLValueString($_POST['apu_maxtri'], "double"),
                GetSQLValueString($_POST['apu_maxsup'], "double"),
                GetSQLValueString($_POST['apu_mingan'], "double"),
                GetSQLValueString($_POST['apu_minpla'], "double"),
                GetSQLValueString($_POST['apu_minsho'], "double"),
                GetSQLValueString($_POST['apu_minexa'], "double"),
                GetSQLValueString($_POST['apu_mintri'], "double"),
                GetSQLValueString($_POST['apu_minsup'], "double"),
                GetSQLValueString($_POST['reg_gan'], "int"),
                GetSQLValueString($_POST['reg_pla'], "int"),
                GetSQLValueString($_POST['reg_sho'], "int"),
                GetSQLValueString($_POST['reg_exa'], "int"),
                GetSQLValueString($_POST['reg_tri'], "int"),
                GetSQLValueString($_POST['reg_sup'], "int"),
                GetSQLValueString($_POST['est_gan'], "int"),
                GetSQLValueString($_POST['est_pla'], "int"),
                GetSQLValueString($_POST['est_sho'], "int"),
                GetSQLValueString($_POST['est_exa'], "int"),
                GetSQLValueString($_POST['est_tri'], "int"),
                GetSQLValueString($_POST['est_sup'], "int"),
                GetSQLValueString($_POST['max_aganar_gan'], "int"),
                GetSQLValueString($_POST['max_aganar_pla'], "int"),
                GetSQLValueString($_POST['max_aganar_sho'], "int"),
                GetSQLValueString($_POST['max_aganar_exa'], "int"),
                GetSQLValueString($_POST['max_aganar_tri'], "int"),
                GetSQLValueString($_POST['max_aganar_sup'], "int"),
                GetSQLValueString($_POST['mon_maxticket'], "double"),
                GetSQLValueString($_POST['mon_maxejemplar'], "int"),
                GetSQLValueString($_POST['min_ejecarrera'], "int"),
                GetSQLValueString($_POST['porcentaje'], "double"),
                GetSQLValueString($_POST['est_impresion'], "int"),
                GetSQLValueString($_POST['tic_caduca'], "int"),
                GetSQLValueString($_POST['anu_regalia'], "double"),
                GetSQLValueString($_POST['tip_ticket'], "int"),
                GetSQLValueString($_POST['tie_reclamo'], "int"),
                GetSQLValueString($_POST['ver_porpagar'], "int"),
                GetSQLValueString($_POST['div_pdes1'], "double"),
                GetSQLValueString($_POST['div_phas1'], "double"),
                GetSQLValueString($_POST['pag_pdiv1'], "double"),
                GetSQLValueString($_POST['opc_ame'], "int"),
                GetSQLValueString($_POST['div_pdes2'], "double"),
                GetSQLValueString($_POST['div_phas2'], "double"),
                GetSQLValueString($_POST['pag_pdiv2'], "double"),
                GetSQLValueString($_POST['opc_ame2'], "int"),
                GetSQLValueString($def_regdiv1, "int"),
                GetSQLValueString($_POST['cod_taopcame'], "int")
            );
            
            $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
            
            
            
            if ($row_Recordset1['moneda']==0) {
                $apuestasminimaausar=$apuestasminimaaganadorbss0;
            }
            if ($row_Recordset1['moneda']==1) {
                $apuestasminimaausar=$apuestasminimaaganadorusd1;
            }
            if ($row_Recordset1['moneda']==2) {
                $apuestasminimaausar=$apuestasminimaaganadorpc2;
            }
            if ($row_Recordset1['moneda']==3) {
                $apuestasminimaausar=$apuestasminimaaganadorsp3;
            }
            if ($row_Recordset1['moneda']==10) {
                $apuestasminimaausar=$apuestasminimaaganadorusd1;
            }

            $codigotaquilla = $row_Recordset1['cod_taquilla'];
            if($_POST['def_regdiv1']<>$row_Recordset4['def_regdiv1']){

                $insertGoTo = "../agente/agente_taquillas_edit_ame.php?recordID=".$row_Recordset1['cod_taquilla'];
                if (isset($_SERVER['QUERY_STRING'])) {
                    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
                    $insertGoTo .= $_SERVER['QUERY_STRING'];
                }
                header(sprintf("Location: %s", $insertGoTo));
            
            }else{
                    $insertGoTo = "../agente/taquillas_edit.php?recordID=".$row_Recordset1['cod_taquilla'];
                    if (isset($_SERVER['QUERY_STRING'])) {
                        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
                        $insertGoTo .= $_SERVER['QUERY_STRING'];
                    }
                    header(sprintf("Location: %s", $insertGoTo));
                }









            $query_Recordset22 =  sprintf(
                "/* PARSEADORES1 new\agente\agente_taquillas_edit_ame.php - QUERY 6 */ SELECT  
tp.apu_mingan
	FROM  taquilla_opc_ame tp 
	WHERE tp.cod_taquilla = %s
	LIMIT 1",
                GetSQLValueString($row_Recordset1['cod_taquilla'], "int")
            );
            $Recordset22 = mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
            $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
            $totalRows_Recordset22 = mysqli_num_rows($Recordset22);

            if ($apuestasminimaausar > $row_Recordset22['apu_mingan']) {
                $insertSQL11 = sprintf(
                    "/* PARSEADORES1 new\agente\agente_taquillas_edit_ame.php - QUERY 7 */ UPDATE taquilla_opc_ame
					SET
					apu_mingan=%s
					WHERE cod_taquilla=%s",
                    GetSQLValueString($apuestasminimaausar, "double"),
                    GetSQLValueString($_POST['cod_taquilla'], "int")
                );
            
                $Result11 = mysqli_query($conexionbanca, $insertSQL11) or die(mysqli_error($conexionbanca));
            }
        } else {
            $insertSQL2 = sprintf(
                "/* PARSEADORES1 new\agente\agente_taquillas_edit_ame.php - QUERY 8 */ INSERT 
			INTO 
			taquilla_opc_ame 
			(cod_taquilla, apu_maxgan,
			pag_codigo, 
			apu_maxpla,		apu_maxsho, 
			apu_maxexa, 	apu_maxtri, 
			apu_maxsup, 	apu_mingan, 
			apu_minpla, 	apu_minsho,
			apu_minexa, 	apu_mintri, 
			apu_minsup, 	reg_gan, 
			reg_pla, 		reg_sho, 
			reg_exa, 		reg_tri, 
			reg_sup, 		est_gan, 
			est_pla, 		est_sho, 
			est_exa,		est_tri, 
			est_sup, 		max_aganar_gan, 
			max_aganar_pla, max_aganar_sho, 
			max_aganar_exa, max_aganar_tri, 
			max_aganar_sup,	mon_maxticket, 
			mon_maxejemplar,min_ejecarrera,
			por_taquilla, 	anu_regalia, 
			tic_caduca, est_impresion, ver_porpagar, tie_reclamo, def_regdiv1,
            div_pdes1,  div_phas1,  pag_pdiv1,
            opc_ame,    div_pdes2,
            div_phas2, 
            pag_pdiv2,  opc_ame2) 
			VALUES 
			(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
			 %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
			 %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
			 %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 
             %s, %s ,%s ,%s ,%s, %s, %s, %s, %s, %s)",
                GetSQLValueString($_POST['cod_taquilla'], "int"),
                GetSQLValueString($_POST['apu_maxgan'], "double"),
                GetSQLValueString($_POST['pag_codigo'], "double"),
                GetSQLValueString($_POST['apu_maxpla'], "double"),
                GetSQLValueString($_POST['apu_maxsho'], "double"),
                GetSQLValueString($_POST['apu_maxexa'], "double"),
                GetSQLValueString($_POST['apu_maxtri'], "double"),
                GetSQLValueString($_POST['apu_maxsup'], "double"),
                GetSQLValueString($_POST['apu_mingan'], "double"),
                GetSQLValueString($_POST['apu_minpla'], "double"),
                GetSQLValueString($_POST['apu_minsho'], "double"),
                GetSQLValueString($_POST['apu_minexa'], "double"),
                GetSQLValueString($_POST['apu_mintri'], "double"),
                GetSQLValueString($_POST['apu_minsup'], "double"),
                GetSQLValueString($_POST['reg_gan'], "int"),
                GetSQLValueString($_POST['reg_pla'], "int"),
                GetSQLValueString($_POST['reg_sho'], "int"),
                GetSQLValueString($_POST['reg_exa'], "int"),
                GetSQLValueString($_POST['reg_tri'], "int"),
                GetSQLValueString($_POST['reg_sup'], "int"),
                GetSQLValueString($_POST['est_gan'], "int"),
                GetSQLValueString($_POST['est_pla'], "int"),
                GetSQLValueString($_POST['est_sho'], "int"),
                GetSQLValueString($_POST['est_exa'], "int"),
                GetSQLValueString($_POST['est_tri'], "int"),
                GetSQLValueString($_POST['est_sup'], "int"),
                GetSQLValueString($_POST['max_aganar_gan'], "int"),
                GetSQLValueString($_POST['max_aganar_pla'], "int"),
                GetSQLValueString($_POST['max_aganar_sho'], "int"),
                GetSQLValueString($_POST['max_aganar_exa'], "int"),
                GetSQLValueString($_POST['max_aganar_tri'], "int"),
                GetSQLValueString($_POST['max_aganar_sup'], "int"),
                GetSQLValueString($_POST['mon_maxticket'], "int"),
                GetSQLValueString($_POST['mon_maxejemplar'], "int"),
                GetSQLValueString($_POST['min_ejecarrera'], "int"),
                GetSQLValueString($_POST['porcentaje'], "double"),
                GetSQLValueString($_POST['anu_regalia'], "double"),
                GetSQLValueString($_POST['tic_caduca'], "int"),
                GetSQLValueString($_POST['est_impresion'], "int"),
                GetSQLValueString($_POST['ver_porpagar'], "int"),
                GetSQLValueString($_POST['tie_reclamo'], "int"),
                GetSQLValueString($def_regdiv1, "int"),
                GetSQLValueString($_POST['div_pdes1'], "double"),
                GetSQLValueString($_POST['div_phas1'], "double"),
                GetSQLValueString($_POST['pag_pdiv1'], "double"),
                GetSQLValueString($_POST['opc_ame'], "int"),
                GetSQLValueString($_POST['div_pdes2'], "double"),
                GetSQLValueString($_POST['div_phas2'], "double"),
                GetSQLValueString($_POST['pag_pdiv2'], "double"),
                GetSQLValueString($_POST['opc_ame2'], "int")
                
            );
            $Result2 = mysqli_query($conexionbanca, $insertSQL2) or die(mysqli_error($conexionbanca));
            
            
            
            
            if ($row_Recordset1['moneda']==0) {
                $apuestasminimaausar=$apuestasminimaaganadorbss0;
            }
            if ($row_Recordset1['moneda']==1) {
                $apuestasminimaausar=$apuestasminimaaganadorusd1;
            }
            if ($row_Recordset1['moneda']==2) {
                $apuestasminimaausar=$apuestasminimaaganadorpc2;
            }
            if ($row_Recordset1['moneda']==3) {
                $apuestasminimaausar=$apuestasminimaaganadorsp3;
            }

            $query_Recordset22 =  sprintf(
                "/* PARSEADORES1 new\agente\agente_taquillas_edit_ame.php - QUERY 9 */ SELECT  
tp.apu_mingan
	FROM  taquilla_opc_ame tp 
	WHERE tp.cod_taquilla = %s
	LIMIT 1",
                GetSQLValueString($row_Recordset1['cod_taquilla'], "int")
            );
            $Recordset22 = mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
            $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
            $totalRows_Recordset22 = mysqli_num_rows($Recordset22);

            if ($apuestasminimaausar > $row_Recordset22['apu_mingan']) {
                $insertSQL11 = sprintf(
                    "/* PARSEADORES1 new\agente\agente_taquillas_edit_ame.php - QUERY 10 */ UPDATE taquilla_opc_ame
					SET
					apu_mingan=%s
					WHERE cod_taquilla=%s",
                    GetSQLValueString($apuestasminimaausar, "int"),
                    GetSQLValueString($_POST['cod_taquilla'], "int")
                );
            
                $Result11 = mysqli_query($conexionbanca, $insertSQL11) or die(mysqli_error($conexionbanca));
            } else {
            }
        }
        if($_POST['def_regdiv1']==0 && $_POST['def_regdiv1']<>$row_Recordset4['def_regdiv1']){
            $msj=' SE HA DESACTIVADO LAS REGLAS AMERICANAS'.' DE LA TAQUILLA '.$row_Recordset1['nom_taquilla'];
        }
        if($_POST['def_regdiv1']==1 && $_POST['def_regdiv1']<>$row_Recordset4['def_regdiv1']){
            $msj=' SE HA DESACTIVADO LAS REGLAS AMERICANAS'.' DE LA TAQUILLA '.$row_Recordset1['nom_taquilla'];

            $msj.= " DEL AGENTE: " . $row_Recordset1['nom_agencia'] . "\n";
        }

        if ($_POST['opc_ame']<>$row_Recordset4['opc_ame'] || $_POST['div_pdes1']<>$row_Recordset4['div_pdes1'] || $_POST['div_phas1']<>$row_Recordset4['div_phas1'] || $_POST['pag_pdiv1']<>$row_Recordset4['pag_pdiv1']) {
            $msj=' SE HA MODIFICADO LAS REGLAS AMERICANAS DE LA'. "\n".'TAQUILLA: '.$row_Recordset1['nom_taquilla']. "\n"." DEL AGENTE: " . $row_Recordset1['nom_agencia'] . "\n";       
            $msj.= " SE HA MODIFICADO LA REGLA #1" ."\n";
            if($_POST['opc_ame']<>$row_Recordset4['opc_ame'] && $_POST['opc_ame']==0){
            $msj.= " LA OPCION DE PAGO PASO DE (=) A (+)"."\n";
            }
            if($_POST['opc_ame']<>$row_Recordset4['opc_ame'] && $_POST['opc_ame']==1){
            $msj.= " LA OPCION DE PAGO PASO DE (=) A (+)"."\n";
            }
            if($_POST['div_pdes1']<>$row_Recordset4['div_pdes1']){
            $msj.= " EL DIVIDENDO DESDE PASO DE ".$row_Recordset4['div_pdes1']." A ".$_POST['div_pdes1']."\n";
            }
            if($_POST['div_phas1']<>$row_Recordset4['div_phas1']){
            $msj.= " EL DIVIDENDO HASTA PASO DE ".$row_Recordset4['div_phas1']." A ".$_POST['div_phas1']."\n";
            }
            if($_POST['pag_pdiv1']<>$row_Recordset4['pag_pdiv1']){
                $msj.= " EL PAGO DE DIVIDENDOS PASO DE ".$row_Recordset4['pag_pdiv1']." A ".$_POST['pag_pdiv1']."\n";
            }
                }
        if ($_POST['opc_ame2']<>$row_Recordset4['opc_ame2'] || $_POST['div_pdes2']<>$row_Recordset4['div_pdes2'] || $_POST['div_phas2']<>$row_Recordset4['div_phas2'] || $_POST['pag_pdiv2']<>$row_Recordset4['pag_pdiv2']) {
            $msj=' SE HA MODIFICADO LAS REGLAS AMERICANAS DE LA'. "\n".'  TAQUILLA: '.$row_Recordset1['nom_taquilla']. "\n"." DEL AGENTE: " . $row_Recordset1['nom_agencia'] . "\n";       
            $msj.= " SE HA MODIFICADO LA REGLA #2 "."\n";
            if($_POST['opc_ame2']<>$row_Recordset4['opc_ame2'] && $_POST['opc_ame2']==0){
                $msj.= " LA OPCION DE PAGO PASO DE (=) A (+)"."\n";
                }
                if($_POST['opc_ame2']<>$row_Recordset4['opc_ame2'] && $_POST['opc_ame2']==1){
                $msj.= " LA OPCION DE PAGO PASO DE (=) A (+)"."\n";
                }
                if($_POST['div_pdes2']<>$row_Recordset4['div_pdes2']){
                $msj.= " EL DIVIDENDO DESDE PASO DE ".$row_Recordset4['div_pdes2']." A ".$_POST['div_pdes2']."\n";
                }
                if($_POST['div_phas2']<>$row_Recordset4['div_phas2']){
                $msj.= " EL DIVIDENDO HASTA PASO DE ".$row_Recordset4['div_phas2']." A ".$_POST['div_phas2']."\n";
                }
                if($_POST['pag_pdiv2']<>$row_Recordset4['pag_pdiv2']){
                    $msj.= " EL PAGO DE DIVIDENDOS PASO DE ".$row_Recordset4['pag_pdiv2']." A ".$_POST['pag_pdiv2']."\n";
                }
                }
            
        
                $msjx=utf8_encode($msj);
        $post=[
          'chat_id'=>-1001548429339,
          'text'=>$msjx,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot5155928341:AAFaxAoro6OLjtRvCMwnri0Zyfnwd-MgPdY/sendMessage");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_exec ($ch);
        curl_close ($ch);
        if($_POST['def_regdiv1']<>$row_Recordset4['def_regdiv1']){

            $insertGoTo = "../agente/agente_taquillas_edit_ame.php?recordID=".$row_Recordset1['cod_taquilla'];
            if (isset($_SERVER['QUERY_STRING'])) {
                $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
                $insertGoTo .= $_SERVER['QUERY_STRING'];
            }
            header(sprintf("Location: %s", $insertGoTo));
        
        }else{
                $insertGoTo = "../agente/taquillas_edit.php?recordID=".$row_Recordset1['cod_taquilla'];
                if (isset($_SERVER['QUERY_STRING'])) {
                    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
                    $insertGoTo .= $_SERVER['QUERY_STRING'];
                }
                header(sprintf("Location: %s", $insertGoTo));
            }
    }
}
    $agenteagente=$row_Recordset1['cod_agencia'];

$query_Recordset3 = sprintf(
    "/* PARSEADORES1 new\agente\agente_taquillas_edit_ame.php - QUERY 11 */ SELECT ta.cod_taquilla, ta.nom_taquilla 
FROM taquilla ta, taquilla_opc_ame tp WHERE ta.cod_agencia = %s AND ta.cod_taquilla = tp.cod_taquilla AND ta.cod_taquilla != %s ORDER BY nom_taquilla",
    GetSQLValueString($agenteagente, "int"),
    GetSQLValueString($xCodigo2, "int")
);
$Recordset3 =mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
$row_Recordset3 = mysqli_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysqli_num_rows($Recordset3);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style>
  .textbox, .textboxsmal {
	  border: 1px solid #DBE1EB;
	  font-size: 18px;
	  font-family: Arial, Verdana;
	  padding-left: 7px;
	  padding-right: 7px;
	  padding-top: 10px;
	  padding-bottom: 10px;
	  border-radius: 4px;
	  -moz-border-radius: 4px;
	  -webkit-border-radius: 4px;
	  -o-border-radius: 4px;
	  background: #FFFFFF;
	  background: linear-gradient(left, #FFFFFF, #F7F9FA);
	  background: -moz-linear-gradient(left, #FFFFFF, #F7F9FA);
	  background: -webkit-linear-gradient(left, #FFFFFF, #F7F9FA);
	  background: -o-linear-gradient(left, #FFFFFF, #F7F9FA);
	  color: #2E3133;
	  height:20px;
  }
  .textbox:focus, .textboxsmal:focus {
	  color: #2E3133;
	  border-color: #FBFFAD;
  }
  .textboxsmal {
	  width:50px;
	  height:10px;
  }
 </style>
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
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
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
<script>
var statusEnvio = false;
function chequearEnvio() {
    if (!statusEnvio) { statusEnvio = true;
        return true;
    } else { alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
        return false;
    }
}
function ValidaSoloNumerosx() {
	if (event.keyCode != 110) {
		if ((event.keyCode < 48) || (event.keyCode > 57)) 
			event.returnValue = false;
	}
}    

function ValidaSoloNumeros(evt,input){
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;    
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter(tempValue)=== false){
            return false;
        }else{       
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {     
              return true;              
          }else if(key == 46){
                if(filter(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
          }else{
              return false;
          }
    }
}
function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
    
}







function ocultaDiv(elemento) {
	document.getElementById(elemento).style.display = "none";
}
$(document).ready(function() {
	$('#exp_agencia').change(function(){
		if($("#exp_agencia").val()>0) {
			
			$("#botExp").removeAttr("disabled");
		}
		else {
			$("#botExp").attr('disabled', 'disabled');
		}
  });
 });
</script>
<!-- InstanceEndEditable -->
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">
<div class="container">
  <div class="header" style="height:100px; background:#333">
			<?php include("../includes/cabeceraamericana_ag.php");?>
            <div id="menu" style="height:50px; padding:0px 0px 0px 50px; margin:-10px 0px 0px 0px">
      			<div class="triangulo_sup"></div>
                <div style="background:#F90; margin:0px 0px 0px 0px; padding:0px 20px 5px 20px; word-spacing: normal;
                    position:absolute;border-radius: 0px 0px 5px 5px;">
                    <!-- InstanceBeginEditable name="Menu" -->
                    <?php include("../includes/cabeceraagente.php");?>
                    <!-- InstanceEndEditable -->        	
                </div>
            </div> <!-- end .menu -->
		</div> <!-- end .header -->
        <div style="background:#333; height:25px; color:#FFFFFF; padding:25px 15px 0px 0px; text-align:right;" id="datosUsuario">
        	<div style="background: #333;position:absolute;border-radius: 0px 0px 5px 5px; padding:15px; text-align:center;
            			margin:20px 0px 0px 0px; width:240px; font-size:16px ">
                <!-- InstanceBeginEditable name="pagina" -->
                EDITAR TAQUILLA<br/>
				<!-- InstanceEndEditable -->        
            </div>
              Usuario: <?php echo "  ".$_SESSION['MM_nom_usuario']." - "; echo  vfechaActual()." | "; ?>
             <span id="reloj"></span>
        </div>
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
    <div style="width:98%; float:right; text-align:right; padding:1.5% 2% 0 0; height:40px; font-size:16px;font-family:'Lucida Grande','Lucida Sans Unicode','Lucida Sans','DejaVu Sans',Verdana,sans-serif;">
        <form method="post" name="form2" action="<?php echo $editFormAction2; ?>" onsubmit="return chequearEnvio();">
        	Exportar opciones de:
            <select name="exp_agencia" id="exp_agencia" style="width:25%; height: auto; background:#9E1C0A; color:#FFFFFF" 
            	class="textbox">
                <option value="" style="background:#9E1C0A; color:#FFFFFF">SELECCIONE<?php
                do {?>
                    <option value="<?php echo $row_Recordset3['cod_taquilla']?>" style="background:#FFF; color:#000">
                        <?php echo $row_Recordset3['nom_taquilla']?></option><?php
                } while ($row_Recordset3 = mysqli_fetch_assoc($Recordset3));?>
            </select>
			<input name="botExp" id="botExp" type="submit"  value="Exportar" class=" btn-info" 
            	style="width:70px; height:35px; font-size:12px;" disabled="disabled"/>
			<input type="hidden" name="MM_insert2" value="form2"/>
        </form>
    </div>
	<div style="padding:70px 10px 20px 10px; text-align:left; font-size:18px; height: auto">
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
        	<div style="width:920px; text-align:left; font-size:18px; background: #E1E1E1">
              <table width="919" align="center" border="0" cellpadding="0" cellspacing="0" style="line-height:13px">
                <tr valign="baseline">
                  <td height="44" colspan="5" align="center" valign="middle" nowrap bgcolor="#333333" 
                  	style="color:#FFF; font-size:24px; font-weight: bold;">
                  	CONFIGURAR MODULO HIPISMO INTERNACIONAL
                  </td>
                <tr valign="baseline">
                  <td width="1" align="left" valign="middle" nowrap>&nbsp;</td>
                  <td colspan="4" align="left" valign="middle" nowrap><br>
                  	<div style="width:98.5%; text-align:left; padding:6px 0px 6px 8px; font-size:18px; background: #FFF">
                    Nombre de taquilla:
                  	<?php echo $row_Recordset1['nom_taquilla']." | Agente: ".$row_Recordset1['nom_agencia']?>
                    </div>
                    <br>
                  </td>


                <tr valign="baseline">
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                  <td align="right" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <?php if ($menOpNac!="") {?>
                  <td height="33" colspan="5" align="center" valign="middle" nowrap style="background:#CC0000; color:#FFF">
                  <?php echo $menOpNac."<br/>";
                  } else {?>
                  <td colspan="5" align="center" nowrap>
                  <?php }?>
                  </td>
                </tr>
                
                <tr valign="baseline">
                  <td height="26" colspan="5" align="center" valign="middle" nowrap bgcolor="#5EAEFF">OPCIONES DE TAQUILLA</td>
                </tr>
              <table width="920" align="center" border="0"  style="line-height:11px" cellpadding="0" cellspacing="0">
                <tr valign="baseline" style="font-size:10px">
                <?php if($def_regdiv1==0){?>
                  <td width="1" height="58" align="left" nowrap>&nbsp;</td>
                  <td width="119" align="left" nowrap>&nbsp;</td>
                  <td width="100" align="center" valign="bottom">APUESTA MÍNIMA</td>
                  <td width="140" align="center" valign="bottom">APUESTA MÁXIMA</td>
                  <td width="56" align="center" valign="bottom">RAGALIA</td>
                  <td width="56" align="center" valign="bottom">MAXIMO A PAGAR</td>
                  <td width="56" align="center" valign="bottom">ACEPTAR JUGADA</td>
                  <td width="96" align="center" valign="bottom">
                  ANULAR REGALIA<span style="font-size:9px"> Dividendo Menor o igual:</span></td>
                  <td width="148" align="center" valign="bottom">VER ANULADOS<br />
                  POR PAGAR</td>
                  <td colspan="2" valign="bottom" style="font-size:10px"><br/>TIEMPO RECLAMO CODIGO TICKET:
					   <select name="tie_reclamo" style="width: 68px; height: auto" class="textbox" tabindex="27">
                          <?php for ($i = 0; $i <= 180; $i+= 15) {?>
                            <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($i, htmlentities($tie_reclamo, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $i; ?>
                          </option>                           <?php  }?>
                    </select>
					   min                      
                  </td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">GANADOR:</td>
                  <td>
                  	<input type="text" name="apu_mingan" class="textboxsmal" style="height:auto; width:100px" onclick="ocultaDiv('Info4');"
                    value="<?php echo htmlentities($apu_mingan, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta mínima"
                    onKeyUp="return handleEnter(this, event)" />
                    <div id="Info4" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmig; ?></div>
                  </td>
                  <td>
                      <input type="text" name="apu_maxgan" class="textboxsmal" style="height:auto; width:140px" onclick="ocultaDiv('Info5');"
                      value="<?php echo htmlentities($apu_maxgan, ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta máxima"
                    onKeyUp="return handleEnter(this, event)" tabindex="6"/>
                    <div id="Info5" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmag; ?></div>
                  </td>
                  
                  <td>
                      <input type="number" name="reg_gan" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info6');"
                      value="<?php echo htmlentities($reg_gan, ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique regalía"
                    onKeyUp="return handleEnter(this, event)" tabindex="7" min="0" max="12" />
                    <div id="Info6" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menRgan; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="max_aganar_gan" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info7');"
                    value="<?php echo htmlentities($max_aganar_gan, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique máxima a ganar"
                    onKeyUp="return handleEnter(this, event)" tabindex="8"/>
                    <div id="Info7" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMgan; ?></div>
                  </td>
                  <td align="center" valign="middle">
                  	<input type="checkbox" name="est_gan" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($est_gan, ENT_COMPAT, 'utf-8'), "1"))) {
                                    echo "checked=\"checked\"";
                                } ?> />
                    </td>
                  <td style="font-size:12px" align="center" valign="bottom">
                    <input type="text" name="anu_regalia" class="textboxsmal" style="height:auto"
                    value="<?php echo htmlentities($anu_regalia, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique anulación de regalía"
                    onKeyUp="return handleEnter(this, event)" tabindex="8"/>                  
                  </td>
                  <td align="center" valign="top" style="font-size:12px">
					<select name="ver_porpagar" style="width:auto; height: 45px" class="textbox"> 
                      <option value="1" <?php if (!(strcmp(1, htmlentities($ver_porpagar, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>SI</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($ver_porpagar, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>NO</option>
                 	</select>                  
                  </td>
                  <td colspan="2" align="left" valign="top" style="font-size:12px">Monto máximo en ticket:
                    <input type="text" name="mon_maxticket" class="textboxsmal" style="height:15px; width:90px"
                    value="<?php echo htmlentities($mon_maxticket, ENT_COMPAT, 'utf-8'); ?>"
                    onkeypress="ValidaSoloNumeros()" title="indique máximo en ticket" onclick="ocultaDiv('Info8');"
                    onKeyUp="return handleEnter(this, event)" tabindex="9" required pattern="[0-9]{1,15}"/>
                    <div id="Info8" style="width:auto; color: #F00; margin:-10px 0px 0px 0px; font-size:10px;">
					<?php echo $menMmt; ?></div>
                  </td>
                </tr>

                
                <input type="hidden" name="div_pdes1" value="<?php echo htmlentities($div_pdes1, ENT_COMPAT, 'utf-8'); ?>">
                <input type="hidden" name="div_phas1" value="<?php echo htmlentities($div_phas1, ENT_COMPAT, 'utf-8'); ?>">
                <input type="hidden" name="opc_ame" value="<?php echo $opc_ame; ?>" >
                <input type="hidden" name="pag_pdiv1" value="<?php echo htmlentities($pag_pdiv1, ENT_COMPAT, 'utf-8'); ?>" >
                <input type="hidden" name="div_pdes2" value="<?php echo htmlentities($div_pdes2, ENT_COMPAT, 'utf-8'); ?>">
                <input type="hidden" name="div_phas2" value="<?php echo htmlentities($div_phas2, ENT_COMPAT, 'utf-8'); ?>">
                <input type="hidden" name="opc_ame2" value="<?php echo $opc_ame2; ?>" >
                <input type="hidden" name="pag_pdiv2" value="<?php echo htmlentities($pag_pdiv2, ENT_COMPAT, 'utf-8'); ?>" >

                <?php } ?>

                <?php if($def_regdiv1==1){?>
                
                    <td width="1" height="58" align="left" nowrap>&nbsp;</td>
                  <td width="119" align="left" nowrap>&nbsp;</td>
                  <td width="100" align="center" valign="bottom">APUESTA MÍNIMA</td>
                  <td width="140" align="center" valign="bottom">APUESTA MÁXIMA</td>
                  <td width="148" align="center" valign="bottom">VER ANULADOS<br />
                  POR PAGAR</td>
                  <td width="56" align="center" valign="bottom">TIEMPO RECLAMO CODIGO TICKET:</td>
                  <td width="56" align="center" valign="bottom">ACEPTAR JUGADA</td>
                  <td width="96" align="center" valign="bottom">MONTO MAXIMO EN TICKET</td>
                  
                  
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">GANADOR:</td>


                  
                      
                    
                  
                  
                  	<input type="hidden" name="max_aganar_gan" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info7');"
                    value="<?php echo htmlentities($max_aganar_gan, ENT_COMPAT, 'utf-8'); ?>"/>
                    
                  
                    <input type="hidden" name="reg_gan" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info6');"
                      value="<?php echo htmlentities($reg_gan, ENT_COMPAT, 'utf-8'); ?>"/>
                    
                  	
                  
                    <input type="hidden" name="anu_regalia" class="textboxsmal" style="height:auto"
                    value="<?php echo htmlentities($anu_regalia, ENT_COMPAT, 'utf-8'); ?>"/>                  
                  

                  <td>
                  	<input type="text" name="apu_mingan" class="textboxsmal" style="height:auto; width:100px" onclick="ocultaDiv('Info4');"
                    value="<?php echo htmlentities($apu_mingan, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta mínima"
                    onKeyUp="return handleEnter(this, event)" />
                    <div id="Info4" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmig; ?></div>
                  </td>
                  <td>
                      <input type="text" name="apu_maxgan" class="textboxsmal" style="height:auto; width:140px" onclick="ocultaDiv('Info5');"
                      value="<?php echo htmlentities($apu_maxgan, ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta máxima"
                    onKeyUp="return handleEnter(this, event)" tabindex="6"/>
                    <div id="Info5" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmag; ?></div>
                  </td>
                  
                  
                  
                
                  <td align="center" valign="top" style="font-size:12px">
					<select name="ver_porpagar" style="width:auto; height: 45px" class="textbox"> 
                      <option value="1" <?php if (!(strcmp(1, htmlentities($ver_porpagar, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>SI</option>
                      <option value="0" <?php if (!(strcmp(0, htmlentities($ver_porpagar, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>NO</option>
                 	</select>                  
                  </td>

                  
                  <td align="left" valign="bottom" style="font-size:10px">
					   <select name="tie_reclamo" style="width: 68px; height: auto" class="textbox" tabindex="27">
                          <?php for ($i = 0; $i <= 180; $i+= 15) {?>
                            <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($i, htmlentities($tie_reclamo, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $i; ?>
                          </option>                           <?php  }?>
                    </select>
					   min                      
                  </td>
                  <td  align="center" valign="middle">
                  	<input type="checkbox" name="est_gan" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($est_gan, ENT_COMPAT, 'utf-8'), "1"))) {
                                    echo "checked=\"checked\"";
                                } ?> />
                    </td>
                  
                  <td align="left" valign="top" style="font-size:12px">
                    <input type="text" name="mon_maxticket" class="textboxsmal" style="height:15px; width:90px"
                    value="<?php echo htmlentities($mon_maxticket, ENT_COMPAT, 'utf-8'); ?>"
                    onkeypress="ValidaSoloNumeros()" title="indique máximo en ticket" onclick="ocultaDiv('Info8');"
                    onKeyUp="return handleEnter(this, event)" tabindex="9" required pattern="[0-9]{1,15}"/>
                    <div id="Info8" style="width:auto; color: #F00; margin:-10px 0px 0px 0px; font-size:10px;">
					<?php echo $menMmt; ?></div>
                  </td>

                  
                </tr>





                    <tr valign="baseline" style="font-size:10px">
                  <td width="1" height="25" align="left" nowrap>&nbsp;</td>
                  <td width="119" align="left" nowrap>&nbsp;</td>
                  <td width="56" align="center" valign="bottom">DIVIDENDO DESDE</td>
                  <td width="56" align="center" valign="bottom">DIVIDENDO HASTA</td>
                  <td width="56" align="center" valign="bottom">OPCION</td>
                  <td width="96" align="center" valign="bottom"><span style="font-size:9px"> PAGA</span></td>
                



                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">REGLA#1:</td>
                 
                  <td>
                      <input type="text" name="div_pdes1" class="textboxsmal" style="height:auto; width:100px" onclick="ocultaDiv('Info6');"
                      value="<?php echo htmlentities($div_pdes1, ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique dividendo"
                    onKeyUp="return handleEnter(this, event)" tabindex="7" min="0" max="12" />
                    <div id="Info6" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $mendiv_pdes1; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="div_phas1" class="textboxsmal" style="height:auto; width:140px" onclick="ocultaDiv('Info7');"
                    value="<?php echo htmlentities($div_phas1, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique dividendo"
                    onKeyUp="return handleEnter(this, event)" tabindex="8"/>
                    <div id="Info7" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $mendiv_phas1; ?></div>
                  </td>
                  <td align="center" valign="top" style="font-size:12px">
                  <select name="opc_ame" 
                  style="width:auto; height: 45px" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_ame, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_ame, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                    </select>                 
                  </td>
                 
                  <td style="font-size:12px" align="center" valign="bottom">
                    <input type="text" name="pag_pdiv1" class="textboxsmal" style="height:auto"
                    value="<?php echo htmlentities($pag_pdiv1, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique a pagar"
                    onKeyUp="return handleEnter(this, event)" tabindex="8"/>                  
                  </td>



                  <tr valign="baseline" style="font-size:10px">
                  <td width="1" height="25" align="left" nowrap>&nbsp;</td>
                  <td width="119" align="left" nowrap>&nbsp;</td>
                  <td width="56" align="center" valign="bottom">DIVIDENDO DESDE</td>
                  <td width="56" align="center" valign="bottom">DIVIDENDO HASTA</td>
                  <td width="56" align="center" valign="bottom">OPCION</td>
                  <td width="96" align="center" valign="bottom"><span style="font-size:9px"> PAGA</span></td>
                



                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">REGLA#2:</td>
                 
                  <td>
                      <input type="text" name="div_pdes2" class="textboxsmal" style="height:auto; width:100px" onclick="ocultaDiv('Info6');"
                      value="<?php echo htmlentities($div_pdes2, ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique dividendo"
                    onKeyUp="return handleEnter(this, event)" tabindex="7" />
                    <div id="Info6" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menRgan; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="div_phas2" class="textboxsmal" style="height:auto; width:140px" onclick="ocultaDiv('Info7');"
                    value="<?php echo htmlentities($div_phas2, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique dividendo"
                    onKeyUp="return handleEnter(this, event)" tabindex="8"/>
                    <div id="Info7" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMgan; ?></div>
                  </td>
                  <td align="center" valign="top" style="font-size:12px">
                  <select name="opc_ame2" 
                  style="width:auto; height: 45px" class="textbox">
                    <option value="1" 
					<?php if (!(strcmp(1, htmlentities($opc_ame2, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    =
                    </option>
                    <option value="0" 
					<?php if (!(strcmp(0, htmlentities($opc_ame2, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
                    +
                    </option>
                    </select>                 
                  </td>
                 
                  <td style="font-size:12px" align="center" valign="bottom">
                    <input type="text" name="pag_pdiv2" class="textboxsmal" style="height:auto"
                    value="<?php echo htmlentities($pag_pdiv2, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique a pagar"
                    onKeyUp="return handleEnter(this, event)" tabindex="8"/>                  
                  </td>
                 
                 
                  


                <?php }?>

                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">PLACE:      </td>
                  <td>
                  	<input type="text" name="apu_minpla" class="textboxsmal" style="height:auto; width:100px" onclick="ocultaDiv('Info9');"
                    value="<?php echo htmlentities($apu_minpla, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta mínima"
                    onKeyUp="return handleEnter(this, event)" tabindex="10"/>
                    <div id="Info9" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmip; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="apu_maxpla" class="textboxsmal" style="height:auto; width:140px" onclick="ocultaDiv('Info10');"
                    value="<?php echo htmlentities($apu_maxpla, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta máxima"
                    onKeyUp="return handleEnter(this, event)" tabindex="11"/>
                    <div id="Info10" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmap; ?></div>
                  </td>
                  <td>
                  	<input type="number" name="reg_pla" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info11');"
                    value="<?php echo htmlentities($reg_pla, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="regalia a esta jugada esta desativada"
                    onKeyUp="return handleEnter(this, event)" tabindex="12"  min="0" max="4" />
                    <div id="Info11" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menRpla; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="max_aganar_pla" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info12');"
                    value="<?php echo htmlentities($max_aganar_pla, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique máximo monto"
                    onKeyUp="return handleEnter(this, event)" tabindex="13"/>
                    <div id="Info12" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMpla; ?></div>
                  </td>
                  <td align="center" valign="middle">
                  	<input type="checkbox" name="est_pla" class="textboxsmal"
                    value=""  <?php if (!(strcmp(htmlentities($est_pla, ENT_COMPAT, 'utf-8'), "1"))) {
                                    echo "checked=\"checked\"";
                                } ?> />
                    </td>
                  <td align="center" valign="bottom" style="font-size: 10px">&nbsp;</td>
                  <td align="right" valign="middle" style="font-size:12px">&nbsp;</td>
                  <td width="116" align="left" valign="middle" style="font-size:12px">Ticket Caduca:
					   <select name="tic_caduca" style="width: auto; height: auto" class="textbox" tabindex="27">
                          <?php for ($i = 0; $i <= 30; $i++) {?>
                            <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($i, htmlentities($tic_caduca, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $i; ?>
                          </option>                           <?php  }?>
                    </select>
					   días                      
                  </td>
                  <td width="82" align="left" valign="middle" style="font-size:10px; color:#900">(0) no caduca</td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">SHOW:      </td>
                  <td>
                  	<input type="text" name="apu_minsho" class="textboxsmal" style="height:auto; width:100px" onclick="ocultaDiv('Info13');"
                    value="<?php echo htmlentities($apu_minsho, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta mínima"
                    onKeyUp="return handleEnter(this, event)" tabindex="14"/>
                    <div id="Info13" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmis; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="apu_maxsho" class="textboxsmal" style="height:auto; width:140px" onclick="ocultaDiv('Info14');"
                    value="<?php echo htmlentities($apu_maxsho, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta máxima"
                    onKeyUp="return handleEnter(this, event)" tabindex="15"/>
                    <div id="Info14" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmas; ?></div>
                  </td>
                  <td>
                      <input type="text" name="reg_sho" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info15');"
                      value="<?php echo htmlentities($reg_sho, ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="regalia a esta jugada esta desativada"
                    onKeyUp="return handleEnter(this, event)" tabindex="16" required pattern="[0]{1}"/>
                    <div id="Info15" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menRsho; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="max_aganar_sho" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info16');"
                    value="<?php echo htmlentities($max_aganar_sho, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique máximo monto"
                    onKeyUp="return handleEnter(this, event)" tabindex="17" required pattern="[0-9]{1,15}"/>
                    <div id="Info16" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMsho; ?></div>
                  </td>
                  <td align="center" valign="middle">
                  	<input type="checkbox" name="est_sho" class="textboxsmal" style="height:auto"
                    value=""  <?php if (!(strcmp(htmlentities($est_sho, ENT_COMPAT, 'utf-8'), "1"))) {
                                    echo "checked=\"checked\"";
                                } ?> />
                    </td>
                  <td valign="top" style="font-size:10px">&nbsp;</td>
                  <td align="right" valign="top" style="font-size:12px">&nbsp;</td>
                  <td colspan="2" align="left" valign="top" style="font-size:12px">Monto máximo por ejemplar:
                    <input type="text" name="mon_maxejemplar" class="textboxsmal" style="height:15px; width:90px"
                      value="<?php echo htmlentities($mon_maxejemplar, ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique máximo monto" onclick="ocultaDiv('Info17');"
                    onKeyUp="return handleEnter(this, event)" tabindex="18" required pattern="[0-9]{1,15}"/>
                    <div id="Info17" style="width:auto; color: #F00; margin:-10px 0px 0px 0px; font-size:10px;">
					<?php echo $menMmae; ?></div>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">EXACTA: </td>
                  <td>
                  	<input type="text" name="apu_minexa" class="textboxsmal" style="height:auto; width:100px" onclick="ocultaDiv('Info18');"
                    value="<?php echo htmlentities($apu_minexa, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta mínima"
                    onKeyUp="return handleEnter(this, event)" tabindex="19"/>
                    <div id="Info18" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmie; ?></div>
                  </td>
                  <td>
                  	<input type="text" name="apu_maxexa" class="textboxsmal" style="height:auto; width:140px" onclick="ocultaDiv('Info19');"
                    value="<?php echo htmlentities($apu_maxexa, ENT_COMPAT, 'utf-8'); ?>" 
                    size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta máxima"
                    onKeyUp="return handleEnter(this, event)" tabindex="20"/>
                    <div id="Info19" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmae; ?></div>
                  </td>
                  <td>
                      <input type="text" name="reg_exa" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info20');"
                      value="<?php echo htmlentities($reg_exa, ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique regalía"
                    onKeyUp="return handleEnter(this, event)" tabindex="21"  required pattern="[0]{1}"/>
                    <div id="Info20" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menRexa; ?></div>
                  </td>
                  <td>
                      <input type="text" name="max_aganar_exa" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info21');"
                      value="<?php echo htmlentities($max_aganar_exa, ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique máximo monto"
                    onKeyUp="return handleEnter(this, event)" tabindex="22" required pattern="[0-9]{1,15}"/>
                    <div id="Info21" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMexa; ?></div>
                  </td>
                  <td align="center" valign="middle">
                  	  <input type="checkbox" name="est_exa" class="textboxsmal"
                      value=""  <?php if (!(strcmp(htmlentities($est_exa, ENT_COMPAT, 'utf-8'), "1"))) {
                                    echo "checked=\"checked\"";
                                } ?> />
                      </td>
                  <td>&nbsp;</td>
                  <td align="right" valign="middle" style="font-size:12px">&nbsp;</td>
                  <td colspan="2" align="left" valign="middle" style="font-size:12px">Tipo de ticket:<br/>
					<select name="tip_ticket" style="width:59px; height: 39px" class="textbox">
					<?php
                    for ($i = 0;  $i <= 10; $i++) {?>
                        <option value="<?php echo $i; ?>" 
						<?php if (!(strcmp($i, htmlentities($tip_ticket, ENT_COMPAT, 'utf-8')))) {
                        echo "SELECTED";
                    } ?>>
						<?php echo $i; ?>
                        </option>
                    <?php
                    }?>  
                    </select>                    
                  </td>
                </tr>
                <tr valign="baseline">
                  <td align="left" nowrap>&nbsp;</td>
                  <td height="28" align="left" nowrap>TRIFECTA:</td>
                  <td>
                      <input type="text" name="apu_mintri" class="textboxsmal" style="height:auto; width:100px"" onclick="ocultaDiv('Info22');"
                      value="<?php echo htmlentities($apu_mintri, ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta mínima"
                    onKeyUp="return handleEnter(this, event)" tabindex="23"/>
                    <div id="Info22" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmit; ?></div>
                  </td>
                  <td>
                      <input type="text" name="apu_maxtri" class="textboxsmal" style="height:auto; width:140px" onclick="ocultaDiv('Info23');"
                      value="<?php echo htmlentities($apu_maxtri, ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta máxima"
                    onKeyUp="return handleEnter(this, event)" tabindex="24"/>
                    <div id="Info23" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmat; ?></div>
                  </td>
                  <td>
                      <input type="text" name="reg_tri" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info24');"
                      value="<?php echo htmlentities($reg_tri, ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique regalía"
                    onKeyUp="return handleEnter(this, event)" tabindex="25" required pattern="[0]{1}"/>
                    <div id="Info24" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menRtri; ?></div>
                  </td>
                  <td>
                      <input type="text" name="max_aganar_tri" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info25');"
                      value="<?php echo htmlentities($max_aganar_tri, ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique máximo monto"
                    onKeyUp="return handleEnter(this, event)" tabindex="26" required pattern="[0-9]{1,15}"/>
                    <div id="Info25" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMtri; ?></div>
                  </td>
                  <td align="center" valign="middle">
                  	  <input type="checkbox" name="est_tri" class="textboxsmal"
                      value=""  <?php if (!(strcmp(htmlentities($est_tri, ENT_COMPAT, 'utf-8'), "1"))) {
                        echo "checked=\"checked\"";
                    } ?> />
                      </td>
                  <td>&nbsp;</td>
                  <td align="right" valign="top" style="font-size:12px">&nbsp;</td>
                  <td colspan="2" align="left" valign="top" style="font-size:12px">Ejemplares mínimos en carrera:
					   <select name="min_ejecarrera" style="width: auto; height: auto" class="textbox" tabindex="27">
                          <?php for ($i = 2; $i <= 15; $i++) {?>
                            <option value="<?php echo $i; ?>" <?php
                                if (!(strcmp($i, htmlentities($min_ejecarrera, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>><?php echo $i; ?>
                          </option>                           <?php  }?>
                      </select>                      
                  </td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td nowrap align="left">SUPERFECTA:</td>
                  <td>
                      <input type="text" name="apu_minsup" class="textboxsmal" style="height:auto; width:100px" onclick="ocultaDiv('Info26');"
                      value="<?php echo htmlentities($apu_minsup, ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta mínima"
                    onKeyUp="return handleEnter(this, event)" tabindex="28"/>
                    <div id="Info26" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmisu; ?></div>
                  </td>
                  <td>
                      <input type="text" name="apu_maxsup" class="textboxsmal" style="height:auto; width:140px" 
                      onclick="ocultaDiv('Info27');"
                      value="<?php echo htmlentities($apu_maxsup, ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique apuesta máxima"
                    onKeyUp="return handleEnter(this, event)" tabindex="29"/>
                    <div id="Info27" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menAmasu; ?></div>
                  </td>
                  <td>
                      <input type="text" name="reg_sup" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info28');"
                      value="<?php echo htmlentities($reg_sup, ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique regalía"
                    onKeyUp="return handleEnter(this, event)" tabindex="30" required pattern="[0]{1}"/>
                    <div id="Info28" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menRsup; ?></div>
                  </td>
                  <td>
                      <input type="text" name="max_aganar_sup" class="textboxsmal" style="height:auto" onclick="ocultaDiv('Info29');"
                      value="<?php echo htmlentities($max_aganar_sup, ENT_COMPAT, 'utf-8'); ?>" 
                      size="10" onkeypress="ValidaSoloNumeros()" title="indique máximo monto"
                    onKeyUp="return handleEnter(this, event)" tabindex="31" required pattern="[0-9]{1,15}"/>
                    <div id="Info29" style="float: left; width:auto; color: #F00; margin:-13px 0px 0px 0px; font-size:10px">
					<?php echo $menMsup; ?></div>
                  </td>
                  <td align="center" valign="middle">
                  	  <input type="checkbox" name="est_sup" class="textboxsmal"
                      value=""  <?php if (!(strcmp(htmlentities($est_sup, ENT_COMPAT, 'utf-8'), "1"))) {
                                    echo "checked=\"checked\"";
                                } ?> />
                  </td>
                  <td colspan="2" align="right" valign="top" style="font-size:12px; color: #F00">
                      	Forma de pagar apuesta y <br/>eliminar ticket:
                  </td>
                  <td colspan="2" align="left" valign="top">
					<select name="pag_codigo" style="width:auto; height: auto" class="textbox" tabindex="4"> 
                      <option value="0" <?php if (!(strcmp(0, htmlentities($pag_codigo, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>CON CÓDIGO</option>
                      <option value="1" <?php if (!(strcmp(1, htmlentities($pag_codigo, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>SIN CÓDIGO</option>
                 	</select>                  </td>
                </tr>
                <tr valign="baseline">
                  <td height="48" align="right" nowrap>&nbsp;</td>
                  <td nowrap align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td colspan="2" align="right"  valign="top" style="font-size:12px;color:#F00">
                  	Confirmación de impresión<br/>de ticket
                  </td>
                  <td colspan="2" align="left" valign="top">
					<select name="est_impresion" style="width:auto; height: auto" class="textbox" tabindex="4"> 
                      <option value="0" <?php if (!(strcmp(0, htmlentities($est_impresion, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>INACTIVO</option>
                      <option value="1" <?php if (!(strcmp(1, htmlentities($est_impresion, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>ACTIVO</option>
                 	</select>                  
                  </td>
                </tr>
                <tr valign="baseline">
                  <td height="48" align="right" nowrap>&nbsp;</td>
                  <td nowrap align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td colspan="2" align="right"  valign="top" style="font-size:12px;color:#F00">
                  	ACTIVAR REGLAS DE DIVIDENTOS<br/>
                  </td>
                  <td colspan="2" align="left" valign="top">
					<select name="def_regdiv1" style="width:auto; height: auto" class="textbox" tabindex="4"> 
                      <option value="0" <?php if (!(strcmp(0, htmlentities($def_regdiv1, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>INACTIVO</option>
                      <option value="1" <?php if (!(strcmp(1, htmlentities($def_regdiv1, ENT_COMPAT, 'utf-8')))) {
                                    echo "SELECTED";
                                } ?>>ACTIVO</option>
                 	</select>                  
                  </td>
                  
                  
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">&nbsp;</td>
                  <td nowrap align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td colspan="3">&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td height="20" colspan="11" align="center" valign="bottom" nowrap bgcolor="#5EAEFF">&nbsp;</td>
                </tr>
                </table>
              <table width="924" align="center">
                <tr valign="baseline">
                  <td width="28" align="left" nowrap>&nbsp;</td>
                  <td width="362" align="left" nowrap><br />
                  	<input type="submit" class="btn badge-warning" value="GUARDAR DATOS"  tabindex="50"
                  	style="width:180px; height:50px; font-size:16px;" />
                  </td>
                  <td width="88" align="left" nowrap>&nbsp;</td>
                  <td width="66" align="left" nowrap>&nbsp;</td>
                  <td width="33" align="left" nowrap>&nbsp;</td>
                  <td width="28" align="left" nowrap>&nbsp;</td>
                  <td width="26" align="left" nowrap>&nbsp;</td>
                  <td width="41" align="left" nowrap>&nbsp;</td>
                  <td align="right" valign="bottom" nowrap>
                  <a href='../agente/taquillas_edit.php?recordID=<?php echo $row_Recordset1['cod_taquilla']; ?>'
                  class="btn  btn-danger" style="width:150px; height:40px; font-size:16px;">
                  	<div style="padding:10px 0px 0px 0px">CANCELAR</div>
                  </a>
                  </td>
                  <td width="37" align="left" nowrap>&nbsp;</td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="left">&nbsp;</td>
                  <td colspan="9" align="left" nowrap>&nbsp;</td>
                </tr>
              </table>
               
          </div>
          <input type="hidden" name="MM_update" value="form1">
          <input type="hidden" name="cod_taquilla" value="<?php echo $row_Recordset1['cod_taquilla']; ?>">
          <input type="hidden" name="cod_taopcame" value="<?php echo $cod_taopcame; ?>">
          <input type="hidden" name="existe" value="<?php echo $existe; ?>">
      </form>
    </div>
  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright © Apuestas Hípicas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($Recordset1);
?>