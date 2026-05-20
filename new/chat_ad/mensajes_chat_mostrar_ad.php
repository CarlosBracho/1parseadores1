<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$fec=fechaactualbd();
$de=trim($_POST["rA"]);
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\chat_ad\mensajes_chat_mostrar_ad.php - QUERY 1 */ SELECT 
		from1,
		message,
		sentdate,
		senttime,
		recd
	FROM chat7 
	WHERE (from1=%s OR to1=%s) AND tipo = 0 ORDER BY id",
    GetSQLValueString($de, "text"),
    GetSQLValueString($de, "text")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
if ($totalRows_Recordset1>0) {
    echo '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="line-height:1">';
    $x=1;
    do {
        if ($x%2==0) {
            $tr='<tr bgcolor="#EAEAEA" style="border-bottom: 1px solid #C1BDBE;color:#000000;line-height:1">';
        } else {
            $tr='<tr bgcolor="#FFFFFF" style="border-bottom: 1px solid #C1BDBE;color:#000000;line-height:1">';
        }
        $x++;
        echo $tr;
        echo '<td width="80%">';
        if ($row_Recordset1['from1']==$de) {
            echo "<font style='color:#900'><br/>&nbsp;";
        } else {
            echo "<font style='color:#000'><br/>&nbsp;";
        }
        echo $row_Recordset1['from1'].": ";
        echo "&nbsp;&nbsp;".$row_Recordset1['message'];
        echo "</font>";
        echo '</td>';
                
        echo '<td align="center" style="font-size:9px;" align="right" width="20%">';
        echo fechanueva($row_Recordset1['sentdate'])."<br/>";
        $hora1=$row_Recordset1['senttime'];
        $nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
        $nuevahora1 = date('H:i:s', $nuevahora1);

        echo horaampm($nuevahora1);
        echo '</td>';
        echo '</tr>';
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    echo '</table>';
}
mysqli_free_result($Recordset1);
?>


