<?php if (!isset($_SESSION)) {
    session_start();
}
require_once('../Connections/conexionbanca.php');
$contacto="Llamanos al 0212.021.0212";
$_SESSION['MM_UserChat']="";
if ($_SESSION['MM_UserGroup'] == "A") {
    $_SESSION['MM_UserChat']="Soporte";
} elseif ($_SESSION['MM_UserGroup'] == "U") {
    $query_Recordset105 = sprintf(
        "/* PARSEADORES1 chat\chat_datos.php - QUERY 1 */ SELECT ta.nom_taquilla, ta.cod_agencia 
			FROM 
				usuario us, 
				taquilla ta 
			WHERE 
				us.id_usuario = %s AND 
				us.cod_taquilla = ta.cod_taquilla
			LIMIT 1",
        GetSQLValueString($_SESSION['MM_id_usuario'], "int")
    );
    $Recordset105 = mysqli_query($conexionbanca, $query_Recordset105) or die(mysqli_error($conexionbanca));
    $row_Recordset105 = mysqli_fetch_assoc($Recordset105);
    $totalRows_Recordset105 = mysqli_num_rows($Recordset105);
    if ($totalRows_Recordset105>0) {
        $_SESSION['MM_UserChat']=$row_Recordset105['nom_taquilla'];
        $_SESSION['MM_cod_agencia']=$row_Recordset105['cod_agencia'];
        ;
    }
} elseif ($_SESSION['MM_UserGroup'] == "G") {
    $query_Recordset105 = sprintf(
        "/* PARSEADORES1 chat\chat_datos.php - QUERY 2 */ SELECT ag.nom_agencia, ag.cod_banca, ag.cod_agencia
			FROM 
				usuario us, 
				agencia ag 
			WHERE 
				us.id_usuario = %s AND 
				us.cod_taquilla = ag.cod_agencia
			LIMIT 1",
        GetSQLValueString($_SESSION['MM_id_usuario'], "int")
    );
    $Recordset105 = mysqli_query($conexionbanca, $query_Recordset105) or die(mysqli_error($conexionbanca));
    $row_Recordset105 = mysqli_fetch_assoc($Recordset105);
    $totalRows_Recordset105 = mysqli_num_rows($Recordset105);
    if ($totalRows_Recordset105>0) {
        $_SESSION['MM_UserChat']=$row_Recordset105['nom_agencia'];
        $_SESSION['MM_cod_agencia']=$row_Recordset105['cod_agencia'];
        $_SESSION['MM_cod_banca']=$row_Recordset105['cod_banca'];
    }
} elseif ($_SESSION['MM_UserGroup'] == "D") {
    $query_Recordset105 = sprintf(
        "/* PARSEADORES1 chat\chat_datos.php - QUERY 3 */ SELECT ba.nom_banca, ba.cod_banca 
			FROM 
				usuario us, 
				banca ba
			WHERE 
				us.id_usuario = %s AND 
				us.cod_taquilla = ba.cod_banca
			LIMIT 1",
        GetSQLValueString($_SESSION['MM_id_usuario'], "int")
    );
    $Recordset105 = mysqli_query($conexionbanca, $query_Recordset105) or die(mysqli_error($conexionbanca));
    $row_Recordset105 = mysqli_fetch_assoc($Recordset105);
    $totalRows_Recordset105 = mysqli_num_rows($Recordset105);
    if ($totalRows_Recordset105>0) {
        $_SESSION['MM_UserChat']=$row_Recordset105['nom_banca'];
        $_SESSION['MM_cod_banca']=$row_Recordset105['cod_banca'];
        ;
    }
}
