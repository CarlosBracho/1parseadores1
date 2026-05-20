<?php
$MM_donotCheckaccess = "false";
if (!((isset($_SESSION['MM_Username']))&&(isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
    $MM_qsChar = "?";
    $MM_referrer = $_SERVER['PHP_SELF'];
    if (strpos($MM_restrictGoTo, "?")) {
        $MM_qsChar = "&";
    }
    if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) {
        $MM_referrer .= "?" .
$_SERVER['QUERY_STRING'];
    }
    $MM_restrictGoTo = $MM_restrictGoTo.
$MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
    header("Location: ". $MM_restrictGoTo);
    exit;
}
$inicio=1;
if (isset($_SESSION['MM_id_usuario'])) {
    if ($MM_authorizedUsers == "U") {
        $query_Recordset11 = sprintf(
            "/* PARSEADORES1 includes\comprobar_acceso.php - QUERY 1 */ SELECT 
			ba.est_banca, ag.est_agencia, ta.est_taquilla, us.est_usuario, us.nom_usuario, ta.cod_taquilla, us.pas_usuario, 
ag.agen_vende_ame,
ag.agen_vende_hnac,
ag.agen_vende_parley,
ag.agen_vende_ani,

ba.dist_vende_ame,
ba.dist_vende_hnac,
ba.dist_vende_parley,
ba.dist_vende_ani,

ta.taq_vende_ame,
ta.taq_vende_hnac,	
ta.taq_vende_parley,	
ta.taq_vende_ani		

		FROM agencia ag, usuario us, taquilla ta, banca ba
		WHERE us.cod_taquilla = ta.cod_taquilla AND ag.cod_agencia = ta.cod_agencia AND ba.cod_banca = ag.cod_banca AND
			us.id_usuario = %s LIMIT 1",
            GetSQLValueString($_SESSION['MM_id_usuario'], "int")
        );
        $Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
        $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
        $totalRows_Recordset11 = mysqli_num_rows($Recordset11);
        $agen_vende_amex=$row_Recordset11['agen_vende_ame']/1;
        $agen_vende_hnacx=$row_Recordset11['agen_vende_hnac']/1;
        $agen_vende_parley=$row_Recordset11['agen_vende_parley']/1;
        $agen_vende_ani=$row_Recordset11['agen_vende_ani']/1;

        $dist_vende_hnacx=$row_Recordset11['dist_vende_hnac']/1;
        $dist_vende_amex=$row_Recordset11['dist_vende_ame']/1;
        $dist_vende_parley=$row_Recordset11['dist_vende_parley']/1;
        $dist_vende_ani=$row_Recordset11['dist_vende_ani']/1;

        $taq_vende_amex=$row_Recordset11['taq_vende_ame']/1;
        $taq_vende_hnacx=$row_Recordset11['taq_vende_hnac']/1;
        $taq_vende_parley=$row_Recordset11['taq_vende_parley']/1;
        $taq_vende_ani=$row_Recordset11['taq_vende_ani']/1;

        $_SESSION['MM_cod_taquilla'] = $row_Recordset11['cod_taquilla'];
        $_SESSION['MM_nom_usuario'] = $row_Recordset11["nom_usuario"];
        if ($totalRows_Recordset11<=0) {
            $inicio=0;
            $_SESSION['MM_systemE']=4;
        } else {
            $_SESSION['MM_systemE']=-1;
            if ($row_Recordset11['est_banca']==0 or $row_Recordset11['est_banca']==2 or  $row_Recordset11['est_banca']==4 or
            $row_Recordset11['est_agencia']==0 or $row_Recordset11['est_agencia']==2 or $row_Recordset11['est_agencia']==3 or $row_Recordset11['est_agencia']==4 or
            $row_Recordset11['est_taquilla']==0 or $row_Recordset11['est_taquilla']==2 or $row_Recordset11['est_taquilla']==3 or $row_Recordset11['est_taquilla']==4) {
                if (is_file("no_acceso_usuario.php")) {
                    $MM_redirectLoginSuccess = "no_acceso_usuario.php";
                }
                if (is_file("../ventasmie/no_acceso_usuario.php")) {
                    $MM_redirectLoginSuccess = "no_acceso_usuario.php";
                }
                if (is_file("ventasmie/no_acceso_usuario.php")) {
                    $MM_redirectLoginSuccess = "ventasmie/no_acceso_usuario.php";
                }
                header("Location: ".$MM_redirectLoginSuccess);
            }
        }

        if (!isset($_SESSION['MM_Password'])) { 
            $_SESSION['MM_Password']=$row_Recordset11['pas_usuario'];
            //echo $_SESSION['MM_Password'];
         }elseif (isset($_SESSION['MM_Password'])){
      
           if($_SESSION['MM_Password'] == $row_Recordset11['pas_usuario']){}else{
            $logoutGoTo = "../apostador/cerrar_sesion_apostador.php";
            header("Location: $logoutGoTo");
            
           }
            
         }
        
    }
    if ($MM_authorizedUsers == "C") {
        $query_Recordset11 = sprintf(
            "/* PARSEADORES1 includes\comprobar_acceso.php - QUERY 2 */ SELECT 
			ba.est_banca, ag.est_agencia, ta.est_taquilla, us.est_usuario, us.nom_usuario, ta.cod_taquilla, us.pas_usuario,
ag.agen_vende_ame,
ag.agen_vende_hnac,
ba.dist_vende_ame,
ba.dist_vende_hnac,
ta.taq_vende_ame,
ta.taq_vende_hnac			
		FROM agencia ag, usuario us, taquilla ta, banca ba
		WHERE us.cod_taquilla = ta.cod_taquilla AND ag.cod_agencia = ta.cod_agencia AND ba.cod_banca = ag.cod_banca AND
			us.id_usuario = %s LIMIT 1",
            GetSQLValueString($_SESSION['MM_id_usuario'], "int")
        );
        $Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
        $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
        $totalRows_Recordset11 = mysqli_num_rows($Recordset11);
        $agen_vende_amex=$row_Recordset11['agen_vende_ame']/1;
        $agen_vende_hnacx=$row_Recordset11['agen_vende_hnac']/1;
        $dist_vende_hnacx=$row_Recordset11['dist_vende_hnac']/1;
        $dist_vende_amex=$row_Recordset11['dist_vende_ame']/1;
        $taq_vende_amex=$row_Recordset11['taq_vende_ame']/1;
        $taq_vende_hnacx=$row_Recordset11['taq_vende_hnac']/1;
        $_SESSION['MM_cod_taquilla'] = $row_Recordset11['cod_taquilla'];
        $_SESSION['MM_nom_usuario'] = $row_Recordset11["nom_usuario"];
        if ($totalRows_Recordset11<=0) {
            $inicio=0;
            $_SESSION['MM_systemE']=4;
        } else {
            $_SESSION['MM_systemE']=-1;
            if ($row_Recordset11['est_banca']==0 or $row_Recordset11['est_banca']==2 or  $row_Recordset11['est_banca']==4 or
                $row_Recordset11['est_agencia']==0 or $row_Recordset11['est_agencia']==2 or $row_Recordset11['est_agencia']==3 or $row_Recordset11['est_agencia']==4 or
                $row_Recordset11['est_taquilla']==0 or $row_Recordset11['est_taquilla']==2 or $row_Recordset11['est_taquilla']==3 or $row_Recordset11['est_taquilla']==4) {
                if (is_file("no_acceso_usuario.php")) {
                    $MM_redirectLoginSuccess = "no_acceso_usuario.php";
                }
                if (is_file("../ventasmie/no_acceso_usuario.php")) {
                    $MM_redirectLoginSuccess = "no_acceso_usuario.php";
                }
                if (is_file("ventasmie/no_acceso_usuario.php")) {
                    $MM_redirectLoginSuccess = "ventasmie/no_acceso_usuario.php";
                }
                header("Location: ".$MM_redirectLoginSuccess);
            }
        }



        if (!isset($_SESSION['MM_Password'])) { 
            $_SESSION['MM_Password']=$row_Recordset11['pas_usuario'];
            //echo $_SESSION['MM_Password'];
         }elseif (isset($_SESSION['MM_Password'])){
      
           if($_SESSION['MM_Password'] == $row_Recordset11['pas_usuario']){}else{
            $logoutGoTo = "../apostador/cerrar_sesion_apostador.php";
            header("Location: $logoutGoTo");
            
           }
            
         }
    }
    if ($MM_authorizedUsers == "G") {
        $query_Recordset11 = sprintf(
            "/* PARSEADORES1 includes\comprobar_acceso.php - QUERY 3 */ SELECT 
			ba.est_banca, ag.cod_agencia, ag.nom_agencia, ag.est_agencia, us.est_usuario, us.pas_usuario,

ag.agen_vende_ame,
ag.agen_vende_hnac,
ag.agen_vende_parley,
ag.agen_vende_ani,
ba.dist_vende_ame,
ba.dist_vende_hnac,
ba.dist_vende_parley,
ba.dist_vende_ani

			FROM agencia ag, usuario us, banca ba
			WHERE us.cod_taquilla = ag.cod_agencia AND ba.cod_banca = ag.cod_banca AND us.id_usuario = %s LIMIT 1",
            GetSQLValueString($_SESSION['MM_id_usuario'], "int")
        );
        $Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
        $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
        $totalRows_Recordset11 = mysqli_num_rows($Recordset11);
        $agen_vende_amex=$row_Recordset11['agen_vende_ame']/1;
        $agen_vende_hnacx=$row_Recordset11['agen_vende_hnac']/1;
        $agen_vende_parley=$row_Recordset11['agen_vende_parley']/1;
        $agen_vende_ani=$row_Recordset11['agen_vende_ani']/1;

        $dist_vende_hnacx=$row_Recordset11['dist_vende_hnac']/1;
        $dist_vende_amex=$row_Recordset11['dist_vende_ame']/1;
        $dist_vende_parley=$row_Recordset11['dist_vende_parley']/1;
        $dist_vende_ani=$row_Recordset11['dist_vende_ani']/1;

        $_SESSION['MM_cod_agente'] = $row_Recordset11['cod_agencia'];
        $_SESSION['MM_nom_agente'] = $row_Recordset11['nom_agencia'];
        if ($totalRows_Recordset11<=0) {
            $inicio=0;
            $_SESSION['MM_systemE']=3;
        } else {
            $_SESSION['MM_systemE']=-1;
            if ($row_Recordset11['est_banca']==0 or $row_Recordset11['est_banca']==2 or  $row_Recordset11['est_banca']==4 or
            $row_Recordset11['est_agencia']==0 or $row_Recordset11['est_agencia']==2 or $row_Recordset11['est_agencia']==3 or $row_Recordset11['est_agencia']==4) {
                if (is_file("no_acceso_usuario.php")) {
                    $MM_redirectLoginSuccess = "no_acceso_usuario.php";
                }
                if (is_file("../agente/no_acceso_usuario.php")) {
                    $MM_redirectLoginSuccess = "no_acceso_usuario.php";
                }
                if (is_file("agente/no_acceso_usuario.php")) {
                    $MM_redirectLoginSuccess = "agente/no_acceso_usuario.php";
                }
                header("Location: ".$MM_redirectLoginSuccess);
            }
        }

        if (!isset($_SESSION['MM_Password'])) { 
            $_SESSION['MM_Password']=$row_Recordset11['pas_usuario'];
            //echo $_SESSION['MM_Password'];
         }elseif (isset($_SESSION['MM_Password'])){
      
           if($_SESSION['MM_Password'] == $row_Recordset11['pas_usuario']){}else{
            $logoutGoTo = "../apostador/cerrar_sesion_apostador.php";
            header("Location: $logoutGoTo");
            
           }
            
         }
    }
    if ($MM_authorizedUsers == "D") {
        $query_Recordset11 = sprintf(
            "/* PARSEADORES1 includes\comprobar_acceso.php - QUERY 4 */ SELECT 
			ba.cod_banca, ba.nom_banca, ba.est_banca, ba.mod_resultado, us.est_usuario, ba.dist_vende_parley, ba.dist_vende_ani, us.pas_usuario
			FROM banca ba, usuario us
			WHERE us.cod_taquilla = ba.cod_banca AND us.id_usuario = %s LIMIT 1",
            GetSQLValueString($_SESSION['MM_id_usuario'], "int")
        );
        $Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
        $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
        $totalRows_Recordset11 = mysqli_num_rows($Recordset11);
        $dist_vende_parley=$row_Recordset11['dist_vende_parley']/1;
        $dist_vende_ani=$row_Recordset11['dist_vende_ani']/1;
        
        $_SESSION['MM_cod_banca'] = $row_Recordset11['cod_banca'];
        $_SESSION['MM_nom_banca'] = $row_Recordset11['nom_banca'];
        $_SESSION['MM_mod_resultado'] = $row_Recordset11['mod_resultado'];
        if ($totalRows_Recordset11<=0) {
            $inicio=0;
            $_SESSION['MM_systemE']=4;
        } else {
            $_SESSION['MM_systemE']=-1;
            if ($row_Recordset11['est_banca']==0 or $row_Recordset11['est_banca']==2 or $row_Recordset11['est_banca']==4) {
                if (is_file("no_acceso_usuario.php")) {
                    $MM_redirectLoginSuccess = "no_acceso_usuario.php";
                }
                if (is_file("../distri/no_acceso_usuario.php")) {
                    $MM_redirectLoginSuccess = "no_acceso_usuario.php";
                }
                if (is_file("distri/no_acceso_usuario.php")) {
                    $MM_redirectLoginSuccess = "distri/no_acceso_usuario.php";
                }
                header("Location: ".$MM_redirectLoginSuccess);
            }
        }

        if (!isset($_SESSION['MM_Password'])) { 
            $_SESSION['MM_Password']=$row_Recordset11['pas_usuario'];
            //echo $_SESSION['MM_Password'];
         }elseif (isset($_SESSION['MM_Password'])){
      
           if($_SESSION['MM_Password'] == $row_Recordset11['pas_usuario']){}else{
            $logoutGoTo = "../apostador/cerrar_sesion_apostador.php";
            header("Location: $logoutGoTo");
            
           }
            
         }
    }
    if ($inicio==0) {
        $url=explode("/", $_SERVER["REQUEST_URI"]);
        $pos = strpos($url[2], ".php");
        if ($pos !== false) {
            $MM_redirectLoginSuccess = "no_acceso_usuario.php";
        } else {
            $MM_redirectLoginSuccess = "../no_acceso_usuario.php";
        }
        header("Location: ".$MM_redirectLoginSuccess);
    }
} else {
    $MM_redirectLoginSuccess = "../index.php";
    header("Location: ".$MM_redirectLoginSuccess);
}
$navegador=detect();