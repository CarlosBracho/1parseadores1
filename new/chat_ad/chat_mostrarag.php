<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once('../Connections/conexionbanca.php');
$editFormAction2 = $_SERVER['PHP_SELF'];
$de=$_SESSION['MM_nom_usuario'];
$fec=fechaactualbd();



$query_Recordset7 = sprintf(
    "/* PARSEADORES1 new\chat_ad\chat_mostrarag.php - QUERY 1 */ SELECT * FROM chat7 
 
USE INDEX(sentdate)
	WHERE 
	sentdate >= date_add(NOW(), INTERVAL -3 DAY) AND sentdate<=%s AND (from1=%s OR to1=%s OR to1='TODOS') 
	ORDER BY sentdate",
    GetSQLValueString($fec, "date"),
    GetSQLValueString($de, "text"),
    GetSQLValueString($de, "text")
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
        $nuevahora1 = strtotime('+6 hour', strtotime($hora1)) ;
        $nuevahora1 = date('H:i:s', $nuevahora1);

        echo horaampm($nuevahora1);
        
        echo '</td>';
        echo '<td>';
        echo '</td>';
        echo '<td>';
        echo '</td>';
        echo '</tr>';
    } while ($row_Recordset7 = mysqli_fetch_assoc($Recordset7));
    echo '</table>';
}
mysqli_free_result($Recordset7);
?>


