<?php
require_once('./Connections/conexionbanca.php');


$query_Recordset2 = sprintf(
    "/* PARSEADORES1 cambioconomonetario3.php - QUERY 1 */ SELECT 
*
 FROM balanceclientes ba
WHERE ba.newconomonetario = 0

AND ba.monedac = 0
ORDER BY ba.Idbalancecli ASC LIMIT 100000"
);
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);




echo $totalRows_Recordset2.'<br>';
do {
    $monto=$row_Recordset2['monto']/1000000;
    $saldoactualc=$row_Recordset2['saldoactualc']/1000000;
    echo ' monto '.$row_Recordset2['monto'].' new '.$monto.' saldoactualc '.$row_Recordset2['saldoactualc'].' new '.$saldoactualc.'';
    if($row_Recordset2['saldoactualc']>=1000){
        echo ' Se Editara monto +++++++++++++++> ';
///*
        $updateSQL = sprintf(
            "/* PARSEADORES1 cambioconomonetario3.php - QUERY 2 */ UPDATE balanceclientes SET saldoactualc=%s, newconomonetario=1
             WHERE Idbalancecli=%s",
            GetSQLValueString($saldoactualc, "double"),
            GetSQLValueString($row_Recordset2['Idbalancecli'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
//*/

    } 
    if($row_Recordset2['saldoactualc']>=0.00 && $row_Recordset2['saldoactualc']<1000){ echo ' Se Editara saldo a 0 ---------------> '; 
    ///*
        $updateSQL = sprintf(
            "/* PARSEADORES1 cambioconomonetario3.php - QUERY 3 */ UPDATE balanceclientes SET saldoactualc=%s, newconomonetario=1
             WHERE Idbalancecli=%s",
            GetSQLValueString(0, "double"),
            GetSQLValueString($row_Recordset2['Idbalancecli'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    //*/
    
    }



    if($row_Recordset2['saldoactualc']<=0.00){ echo ' Se Editara saldo a 0 ---------------> '; 
        ///*
            $updateSQL = sprintf(
                "/* PARSEADORES1 cambioconomonetario3.php - QUERY 4 */ UPDATE balanceclientes SET saldoactualc=%s, newconomonetario=1
                 WHERE Idbalancecli=%s",
                GetSQLValueString($saldoactualc, "double"),
                GetSQLValueString($row_Recordset2['Idbalancecli'], "int")
            );
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        //*/
        
        }





    echo  '<br>';
} while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));