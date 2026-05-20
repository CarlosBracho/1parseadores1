<?php
$MM_donotCheckaccess = "false";
if (!((isset($_SESSION['MM_Username']))&&(isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
    $MM_qsChar = "?";
    $MM_referrer = $_SERVER['PHP_SELF'];
    if (strpos($MM_restrictGoTo, "?")) {
        $MM_qsChar = "&";
    }
    if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) {
        $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
    }
    $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
    header("Location: ". $MM_restrictGoTo);
    exit;
}
$inicio=1;
if (isset($_SESSION['MM_id_usuario'])) {
    if ($MM_authorizedUsers == "U") {
        $query_Recordset11 = sprintf(
            "/* PARSEADORES1 includes\comprobar_acceso1.php - QUERY 1 */ SELECT est_agencia
		FROM agencia, usuario, taquilla, banca
		WHERE
			usuario.cod_taquilla = taquilla.cod_taquilla AND
			agencia.cod_agencia = taquilla.cod_agencia AND
			banca.cod_banca = agencia.cod_banca AND
			agencia.est_agencia = 1 AND
			usuario.est_usuario = 1 AND
			banca.est_banca = 1 AND
			usuario.id_usuario = %s LIMIT 1",
            GetSQLValueString($_SESSION['MM_id_usuario'], "int")
        );
        $Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
        $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
        $totalRows_Recordset11 = mysqli_num_rows($Recordset11);
        if ($totalRows_Recordset11 <= 0) {
            $inicio=0;
        }
    }
    if ($MM_authorizedUsers == "G") {
        $query_Recordset11 = sprintf(
            "/* PARSEADORES1 includes\comprobar_acceso1.php - QUERY 2 */ SELECT cod_agencia, nom_agencia, est_agencia
			FROM agencia, usuario, banca
			WHERE
				usuario.cod_taquilla = agencia.cod_agencia AND
				banca.cod_banca = agencia.cod_banca AND
				agencia.est_agencia = 1 AND
				banca.est_banca = 1 AND
				usuario.est_usuario = 1 AND
				usuario.id_usuario = %s LIMIT 1",
            GetSQLValueString($_SESSION['MM_id_usuario'], "int")
        );
        $Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
        $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
        $totalRows_Recordset11 = mysqli_num_rows($Recordset11);
        $_SESSION['MM_cod_agente'] = $row_Recordset11['cod_agencia'];
        $_SESSION['MM_nom_agente'] = $row_Recordset11['nom_agencia'];
        if ($totalRows_Recordset11<=0) {
            $inicio=0;
        }
    }
    if ($MM_authorizedUsers == "D") {
        $query_Recordset11 = sprintf(
            "/* PARSEADORES1 includes\comprobar_acceso1.php - QUERY 3 */ SELECT cod_banca, nom_banca, est_banca 
			FROM 
				banca, usuario
			WHERE
				usuario.cod_taquilla = banca.cod_banca AND
				usuario.est_usuario = 1 AND
				banca.est_banca = 1 AND
				usuario.id_usuario = %s LIMIT 1",
            GetSQLValueString($_SESSION['MM_id_usuario'], "int")
        );
        $Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
        $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
        $totalRows_Recordset11 = mysqli_num_rows($Recordset11);
        $_SESSION['MM_cod_banca'] = $row_Recordset11['cod_banca'];
        $_SESSION['MM_nom_banca'] = $row_Recordset11['nom_banca'];
        if ($totalRows_Recordset11<=0) {
            $inicio=0;
        }
    }
    if ($inicio==0) {
        $_SESSION['MM_Username'] = null;
        $_SESSION['MM_UserGroup'] = null;
        $_SESSION['MM_id_usuario'] = null;
        unset($_SESSION['MM_Username']);
        unset($_SESSION['MM_UserGroup']);
        unset($_SESSION['MM_id_usuario']);
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
