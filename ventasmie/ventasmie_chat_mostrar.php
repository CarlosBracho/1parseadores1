<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
if (isset($_SESSION['MM_nom_usuario'])) {
    $de=$_SESSION['MM_nom_usuario'];
} else {
    $de=' ';
}


$info=detect2();
if (isset($info["version"])) {
} else {
    $info["version"]=11;
}
/*
$infoversionyexp=$info["browser"].' '.$info["version"].' '.$_SESSION['MM_nom_usuario'].' Version Vieja';
$query_Recordset1ex =  sprintf(
    "SELECT exploradorversion
  FROM 
  exploradorversion 
  WHERE 
  exploradorversion = %s",
    GetSQLValueString($infoversionyexp, "text")
);
$Recordset1ex = mysqli_query($conexionbanca, $query_Recordset1ex) or die(mysqli_error($conexionbanca));
$row_Recordset1ex = mysqli_fetch_assoc($Recordset1ex);
$totalRows_Recordset1ex = mysqli_num_rows($Recordset1ex);
if ($totalRows_Recordset1ex==0) {
    $insertSQL1 = sprintf(
        "INSERT 
		INTO exploradorversion 
		(exploradorversion) 
		VALUES (%s)",
        GetSQLValueString(strtoupper($infoversionyexp), "text")
    );
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
}
*/



$fec=fechaactualbd();
$query_Recordset7 = sprintf(
    "/* PARSEADORES1 ventasmie\ventasmie_chat_mostrar.php - QUERY 1 */ SELECT * FROM chat2 
	WHERE (sentdate=%s AND from1=%s AND tipo=0) OR (sentdate=%s AND to1=%s AND tipo=0) OR 
	(sentdate=%s AND to1='TODOS' AND tipo=0)
	ORDER BY id",
    GetSQLValueString($fec, "date"),
    GetSQLValueString($de, "text"),
    GetSQLValueString($fec, "date"),
    GetSQLValueString($de, "text"),
    GetSQLValueString($fec, "date")
);
$Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
$row_Recordset7 = mysqli_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysqli_num_rows($Recordset7);
if ($totalRows_Recordset7>0) {
    echo '<table width="100%">';
    $x=1;
    do {
        if ($x%2==0) {
            $tr='<tr bgcolor="#EAEAEA">';
        } else {
            $tr='<tr bgcolor="#FFFFFF">';
        }
        $x++;
        echo $tr;
        echo '<td>';
        if ($row_Recordset7['from1']==$de) {
            echo "<font style='color:#900'>";
        } else {
            echo "<font style='color:#000'>";
        }
        echo $row_Recordset7['from1'].": ";
        echo "&nbsp;&nbsp;".$row_Recordset7['message'];
        echo "</font>";
        echo '</td>';
                
        echo '<td align="right">';

        $hora1=$row_Recordset7['senttime'];
        $nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
        $nuevahora1 = date('H:i:s', $nuevahora1);

        echo horaampm($nuevahora1);
        echo '</td>';
        echo '</tr>';
    } while ($row_Recordset7 = mysqli_fetch_assoc($Recordset7));
    echo '</table>';
}
mysqli_free_result($Recordset7);
?>


