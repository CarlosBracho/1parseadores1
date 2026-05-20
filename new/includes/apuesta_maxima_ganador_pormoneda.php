<?php
require_once('../Connections/conexionbanca.php');



$apuestasminimaaganadorbss0='500000';
$apuestasminimaaganadorusd1='2';
$apuestasminimaaganadorpc2='2000';
$apuestasminimaaganadorsp3='1000';

$query_Recordset1 =  sprintf("/* PARSEADORES1 new\includes\apuesta_maxima_ganador_pormoneda.php - QUERY 1 */ SELECT  
	ta.moneda, ta.cod_taquilla
	FROM  taquilla ta
LIMIT 9999");
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

echo $totalRows_Recordset1;
echo "<br>";

    do {
        echo "--------------------------------------------------------------------";
        echo "<br>";
        
        echo "CODIGO TAQUILLA";
        echo "<br>";
        echo $row_Recordset1['cod_taquilla'];
        echo "<br>";
        echo "tipo de moneda";
        echo "<br>";
        echo $row_Recordset1['moneda'];
        echo "<br>";


        $query_Recordset2 =  sprintf(
            "/* PARSEADORES1 new\includes\apuesta_maxima_ganador_pormoneda.php - QUERY 2 */ SELECT  
tp.apu_maxgan
	FROM  taquilla_opc_ame tp 
	WHERE tp.cod_taquilla = %s
	LIMIT 1",
            GetSQLValueString($row_Recordset1['cod_taquilla'], "int")
        );
        $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
        echo "apuestasminima a actual";
        echo "<br>";
        echo $row_Recordset2['apu_maxgan'];
        echo "<br>";



        if ($row_Recordset1['moneda']==0) {
            $apuestasminimaausar=$apuestasminimaaganadorbss0;
            echo "apuestasminima a usar";
            echo "<br>";
            echo $apuestasminimaausar;
            echo "<br>";
        }
        if ($row_Recordset1['moneda']==1) {
            $apuestasminimaausar=$apuestasminimaaganadorusd1;
            echo "apuestasminima a usar";
            echo "<br>";
            echo $apuestasminimaausar;
            echo "<br>";
        }
        if ($row_Recordset1['moneda']==2) {
            $apuestasminimaausar=$apuestasminimaaganadorpc2;
            echo "apuestasminima a usar";
            echo "<br>";
            echo $apuestasminimaausar;
            echo "<br>";
        }
        if ($row_Recordset1['moneda']==3) {
            $apuestasminimaausar=$apuestasminimaaganadorsp3;
            echo "apuestasminima a usar";
            echo "<br>";
            echo $apuestasminimaausar;
            echo "<br>";
        }

        $codigotaquilla = $row_Recordset1['cod_taquilla'];


        if ($apuestasminimaausar > $row_Recordset2['apu_maxgan'] && $totalRows_Recordset2 > 0) {
            $insertSQL11 = sprintf(
                "/* PARSEADORES1 new\includes\apuesta_maxima_ganador_pormoneda.php - QUERY 3 */ UPDATE taquilla_opc_ame
					SET
					apu_maxgan=%s
					WHERE cod_taquilla=%s",
                GetSQLValueString($apuestasminimaausar, "int"),
                GetSQLValueString($codigotaquilla, "int")
            );
            
            $Result11 = mysqli_query($conexionbanca, $insertSQL11) or die(mysqli_error($conexionbanca));
            echo "se modifico";
            echo "<br>";
        } else {
            echo "no no se modifico";
            echo "<br>";
        }



        mysqli_free_result($Recordset2);
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
mysqli_free_result($Recordset1);
