<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$fec=fechaactualbd();
$de=trim($_POST["rA"]);
/*
$query_Recordset1 = sprintf("SELECT * FROM chat2 WHERE (sentdate=%s AND from1=%s) OR (sentdate=%s AND to1=%s) ORDER BY id", GetSQLValueString($fec, "date"), GetSQLValueString($de, "text"), GetSQLValueString($fec, "date"), GetSQLValueString($de, "text"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
*/
$query_Recordset1 = sprintf("/* PARSEADORES1 includes\mensajes_chat_mostrar_hnac.php - QUERY 1 */ SELECT * FROM chat2 WHERE (from1=%s OR to1=%s) AND tipo = 2 ORDER BY id", GetSQLValueString($de, "text"), GetSQLValueString($de, "text"));
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
if ($totalRows_Recordset1>0) {
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
        if ($row_Recordset1['from1']==$de) {
            echo "<font style='color:#900'>";
        } else {
            echo "<font style='color:#000'>";
        }
        echo $row_Recordset1['from1'].": ";
        echo "&nbsp;&nbsp;".$row_Recordset1['message'];
        echo "</font>";
        echo '</td>';
                
        echo '<td align="center" style="font-size:10px">';
        echo fechanueva($row_Recordset1['sentdate'])."<br/>";
        echo horaampm($row_Recordset1['senttime']);
        echo '</td>';
        echo '</tr>';
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    echo '</table>';
}
mysqli_free_result($Recordset1);
?>


