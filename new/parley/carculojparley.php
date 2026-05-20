<?php if (isset($_GET['Id_p2juegosp2'])) {
$auto=0;
require_once('../Connections/conexionbanca.php');
$Id_p2juegosp2=$_GET['Id_p2juegosp2'];
//$Fechacal=substr($_GET['Fechacal'], 0, 10);
$Fechacal=$_GET['Fechacal'];
//$Fechacal = strtotime($Fechacal);
//$Fechacal = date("Y-m-d", $Fechacal);
//echo 'se ejecuta';
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min4.5.2.css">
    <link href="../fonts/font-awesome.min4.7.0.css" rel="stylesheet">
    <title>Hello, world!</title>


    <script src="../js/jquery-1.9.1.min.js"></script>
  </head>
  <body>
<table border='2'>


<?php
}else{  
    $auto=1;

    $Id_p2juegosp2=$row_Recordset177['Id_p2juegosp2'];
   
}


$query_Recordset18 = sprintf(
    "/* PARSEADORES1 new\parley\carculojparley.php - QUERY 1 */ SELECT * FROM p5resultadosj WHERE
     iniciodtp5 >= %s AND iniciodtp5 <= %s AND 
juegop5 = %s ORDER BY Id_p5resultadosjp5 ASC LIMIT 1",
GetSQLValueString($Fechacal.' 00:00:02', "date"),
GetSQLValueString($Fechacal.' 23:59:59', "date"),
GetSQLValueString($Id_p2juegosp2, "int")
);
$Recordset18 = mysqli_query($conexionbanca, $query_Recordset18) or die(mysqli_error($conexionbanca));
$row18 = mysqli_fetch_assoc($Recordset18);
$totalRows_Recordset18 = mysqli_num_rows($Recordset18);


if($row18['r21p5'] && $row18['r22p5'] && $row18['r23p5'] && $row18['r24p5'] == 999){



$query_Recordset188 = sprintf(
    "/* PARSEADORES1 new\parley\carculojparley.php - QUERY 2 */ SELECT * 
FROM 
p4jugadas, p2juegos 
WHERE 
p2juegos.iniciodtp2 >= %s AND p2juegos.iniciodtp2 <= %s AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND 
p4jugadas.juegop4 = %s AND p4jugadas.juegop4 = p2juegos.Id_p2juegosp2  AND estadoticketp4 <>7
ORDER BY 
p4jugadas.Id_p4jugadasp4 
ASC",
GetSQLValueString($Fechacal.' 00:00:02', "date"),
GetSQLValueString($Fechacal.' 23:59:59', "date"),
GetSQLValueString($Fechacal.' 00:00:02', "date"),
GetSQLValueString($Fechacal.' 23:59:59', "date"),
    GetSQLValueString($Id_p2juegosp2, "int")
);
$Recordset188 = mysqli_query($conexionbanca, $query_Recordset188) or die(mysqli_error($conexionbanca));
$row_Recordset188 = mysqli_fetch_assoc($Recordset188);
$totalRows_Recordset188 = mysqli_num_rows($Recordset188);
$totaljugadas188=$totalRows_Recordset188;
$nticketp4=$row_Recordset188['nticketp4'];


do{



$insertSQL155 = sprintf(
    "/* PARSEADORES1 new\parley\carculojparley.php - QUERY 3 */ UPDATE p4jugadas  SET 
estadojugadap4=%s
WHERE juegop4=%s",
    GetSQLValueString(3, "int"),
    GetSQLValueString($Id_p2juegosp2, "int")
);
$Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));




if($row_Recordset188['estadojugadap4']==0 && $row_Recordset188['estadojugadap4']<>2|| $row_Recordset188['estadojugadap4']==1 && $row_Recordset188['estadojugadap4']<>2){
    
    include("../parley/carculojparleyD.php");


}

}while($row_Recordset188 = mysqli_fetch_assoc($Recordset188));

?>

<script> 
//<!--
window.close(); 
//-->
</script>
<?php

}


$query_Recordset1 = sprintf(
    "/* PARSEADORES1 new\parley\carculojparley.php - QUERY 4 */ SELECT * 
FROM 
p4jugadas, p2juegos 
WHERE 
p2juegos.iniciodtp2 >= %s AND p2juegos.iniciodtp2 <= %s AND p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND 
p4jugadas.juegop4 = %s AND p4jugadas.juegop4 = p2juegos.Id_p2juegosp2  AND estadoticketp4 <> 7 AND estadoticketp4 <> 5 
ORDER BY 
p4jugadas.Id_p4jugadasp4 
ASC",
GetSQLValueString($Fechacal.' 00:00:02', "date"),
GetSQLValueString($Fechacal.' 23:59:59', "date"),
GetSQLValueString($Fechacal.' 00:00:02', "date"),
GetSQLValueString($Fechacal.' 23:59:59', "date"),
    GetSQLValueString($Id_p2juegosp2, "int")
);
$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
$totaljugadas=$totalRows_Recordset1;
if($row_Recordset1['estadojugadap4'] <> 7){
if($row_Recordset1['estadojugadap4'] <> 3){

$query_Recordset11 = sprintf(
    "/* PARSEADORES1 new\parley\carculojparley.php - QUERY 5 */ SELECT * FROM p5resultadosj WHERE
     iniciodtp5 >= %s AND iniciodtp5 <= %s AND 
juegop5 = %s ORDER BY Id_p5resultadosjp5 ASC LIMIT 1",
GetSQLValueString($Fechacal.' 00:00:02', "date"),
GetSQLValueString($Fechacal.' 23:59:59', "date"),
GetSQLValueString($Id_p2juegosp2, "int")
);
$Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
$row11 = mysqli_fetch_assoc($Recordset11);
$totalRows_Recordset11 = mysqli_num_rows($Recordset11);




echo "<tr>";
echo "<td>";
echo "Id_p2jueg";
echo "</td>";
echo "<td>";
echo "Id_p4jug";
echo "</td>";
echo "<td>";
echo "nticketp4";
echo "</td>";
echo "<td>";
echo "equipop4";
echo "</td>";
echo "<td>";
echo "tipojp4";
echo "</td>";
echo "<td>";
echo "ab_o_rlp4";
echo "</td>";
echo "<td>";
echo "estadoj";
echo "</td>";
echo "<td>";
echo "equipo";
echo "</td>";
echo "<td>";
echo "tipo";
echo "</td>";
echo "<td>";
echo "linea";
echo "</td>";
echo "<td>";
echo "premio";
echo "</td>";
echo "<td>";
echo "logro";
echo "</td>";



//inicio beisbol
if ($row_Recordset1['deportep2']=='beisbol') {
    $AB=$row11['r21p5']+$row11['r22p5'];
    $AB5=$row11['r23p5']+$row11['r24p5'];
    if ($row11['r21p5']>$row11['r22p5']) {
        $ganoml=1;
    } else {
        $ganoml=2;
    }
    if ($row11['r23p5']>$row11['r24p5']) {
        $gano5ml=1;
    }
    if ($row11['r23p5']<$row11['r24p5']) {
        $gano5ml=2;
    }
    if ($row11['r23p5']==$row11['r24p5']) {
        $gano5ml=3;
    }
    
    

    $AB5=$row11['r23p5']+$row11['r24p5'];
    $sino=$row11['r29p5'];
    $EHC=$row11['r30p5'];
    $Anota1ero=$row11['anotaprimerop5'];


    do {
        echo "<tr>";
        echo "<td>";
        echo $Id_p2juegosp2;
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['Id_p4jugadasp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['nticketp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['equipop4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['tipojp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['ab_o_rlp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['estadojugadap4'];
        echo "</td>";
        
        
        $query_Recordset2 = sprintf(
            "/* PARSEADORES1 new\parley\carculojparley.php - QUERY 6 */ SELECT * FROM p1equipos WHERE 
nomequipop1 = %s",
            GetSQLValueString($row_Recordset1['equipop4'], "text")
        );
        $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

        






        $query_Recordset3 = sprintf(
            "/* PARSEADORES1 new\parley\carculojparley.php - QUERY 7 */ SELECT * FROM p2juegos WHERE 
            iniciodtp2 >= %s AND iniciodtp2 <= %s AND 
idequipo1p2 = %s AND Id_p2juegosp2 = %s",
GetSQLValueString($Fechacal.' 00:00:02', "date"),
GetSQLValueString($Fechacal.' 23:59:59', "date"),
            GetSQLValueString($row_Recordset2['Id_p1equiposp1'], "int"),
            GetSQLValueString($Id_p2juegosp2, "int")
        );
        $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
        $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
        $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
        if ($totalRows_Recordset3==0) {
            $equipo=2;
        } else {
            $equipo=1;
        }

        echo "<td>";
        echo $equipo;
        echo "</td>";


        
        
        
        if ($row_Recordset1['tipojp4']=="ML" && $AB>0) {
            if (($equipo==1 && $ganoml==1) or ($equipo==2 && $ganoml==2)) {
                echo "<td>";
                echo "gano ml";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            }
            if (($equipo==1 && $ganoml==2) or ($equipo==2 && $ganoml==1)) {
                echo "<td>";
                echo "perdio ml";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
        }

        if ($row_Recordset1['tipojp4']=="5ML" && $AB>0) {
            if (($equipo==1 && $gano5ml==1) or ($equipo==2 && $gano5ml==2)) {
                echo "<td>";
                echo "gano 5ml";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            }
            if (($equipo==1 && $gano5ml==2) or ($equipo==2 && $gano5ml==1)) {
                echo "<td>";
                echo "perdio 5ml";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
            if (($equipo==1 && $gano5ml==3) or ($equipo==2 && $gano5ml==3)) {
                echo "<td>";
                echo "5mlempate ";
                echo "</td>";
                $estadojugadap4=3;
                include("../parley/carculojparley2.php");
            }
        }






        if ((($row_Recordset1['tipojp4']=="RL" && $AB>=0))) {
            if ($equipo==1) {
                $carrerase1rl=$row11['r21p5']+$row_Recordset1['ab_o_rlp4'];
                if ($carrerase1rl>$row11['r22p5']) {
                    echo "<td>";
                    echo "gano RL";
                    echo "</td>";
                    $estadojugadap4=1;
                    include("../parley/carculojparley2.php");
                } else {
                    echo "<td>";
                    echo "perdio RL";
                    echo "</td>";
                    $estadojugadap4=2;
                    include("../parley/carculojparley2.php");
                }
                if ($row11['r21p5']==$row11['r22p5']) {
                    echo "<td>";
                    echo "Devolucion RL";
                    echo "</td>";
                    $estadojugadap4=3;
                    include("../parley/carculojparley2.php");
                }
            }
            if ($equipo==2) {
                $carrerase2rl=$row11['r22p5']+$row_Recordset1['ab_o_rlp4'];
                if ($carrerase2rl>$row11['r21p5']) {
                    echo "<td>";
                    echo "gano RL";
                    echo "</td>";
                    $estadojugadap4=1;
                    include("../parley/carculojparley2.php");
                } else {
                    echo "<td>";
                    echo "perdio RL";
                    echo "</td>";
                    $estadojugadap4=2;
                    include("../parley/carculojparley2.php");
                }
                if ($row11['r21p5']==$row11['r22p5']) {
                    echo "<td>";
                    echo "Devolucion RL";
                    echo "</td>";
                    $estadojugadap4=3;
                    include("../parley/carculojparley2.php");
                }
            }
        }

        if ((($row_Recordset1['tipojp4']=="SRL" && $AB>0))) {
            if ($equipo==1) {
                $carrerase1srl=$row11['r21p5']+$row_Recordset1['ab_o_rlp4'];
                if ($carrerase1srl>$row11['r22p5']) {
                    echo "<td>";
                    echo "gano SRL";
                    echo "</td>";
                    $estadojugadap4=1;
                    include("../parley/carculojparley2.php");
                } else {
                    echo "<td>";
                    echo "perdio SRL";
                    echo "</td>";
                    $estadojugadap4=2;
                    include("../parley/carculojparley2.php");
                }
            }
            if ($equipo==2) {
                $carrerase2srl=$row11['r22p5']+$row_Recordset1['ab_o_rlp4'];
                if ($carrerase2srl>$row11['r21p5']) {
                    echo "<td>";
                    echo "gano SRL";
                    echo "</td>";
                    $estadojugadap4=1;
                    include("../parley/carculojparley2.php");
                } else {
                    echo "<td>";
                    echo "perdio SRL";
                    echo "</td>";
                    $estadojugadap4=2;
                    include("../parley/carculojparley2.php");
                }
            }
        }


        if ((($row_Recordset1['tipojp4']=="5RL") or ($row_Recordset1['tipojp4']=="5SR"))) {
            if ($equipo==1) {
                $carrerase1rl5=$row11['r23p5']+$row_Recordset1['ab_o_rlp4'];
                if ($carrerase1rl5>$row11['r24p5']) {
                    echo "<td>";
                    echo "gano 5RL";
                    echo "</td>";
                    $estadojugadap4=1;
                    include("../parley/carculojparley2.php");
                } else {
                    echo "<td>";
                    echo "perdio 5RL";
                    echo "</td>";
                    $estadojugadap4=2;
                    include("../parley/carculojparley2.php");
                }
                if ($row11['r23p5']==$row11['r24p5']) {
                    echo "<td>";
                    echo "Devolucion 5RL";
                    echo "</td>";
                    $estadojugadap4=3;
                    include("../parley/carculojparley2.php");
                }
            }
            if ($equipo==2) {
                $carrerase2rl5=$row11['r24p5']+$row_Recordset1['ab_o_rlp4'];
                if ($carrerase2rl5>$row11['r23p5']) {
                    echo "<td>";
                    echo "gano 5RL";
                    echo "</td>";
                    $estadojugadap4=1;
                    include("../parley/carculojparley2.php");
                } else {
                    echo "<td>";
                    echo "perdio 5RL";
                    echo "</td>";
                    $estadojugadap4=2;
                    include("../parley/carculojparley2.php");
                }
                if ($row11['r23p5']==$row11['r24p5']) {
                    echo "<td>";
                    echo "Devolucion 5RL";
                    echo "</td>";
                    $estadojugadap4=3;
                    include("../parley/carculojparley2.php");
                }
            }
        }

        if ($row_Recordset1['tipojp4']=="A" && $AB>0) {
            if ($AB>$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "gano A";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            }
            if ($AB<$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "perdio A";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
            if ($AB==$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "empate A";
                echo "</td>";
                $estadojugadap4=3;
                include("../parley/carculojparley2.php");
            }
        }

        if ($row_Recordset1['tipojp4']=="B" && $AB>0) {
            if ($AB<$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "gano B";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            }
            if ($AB>$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "perdio B";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
            if ($AB==$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "empate B";
                echo "</td>";
                $estadojugadap4=3;
                include("../parley/carculojparley2.php");
            }
        }

        if ($row_Recordset1['tipojp4']=="5A" && $AB5>=0) {
            if ($AB5>$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "gano 5A";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            }
            if ($AB5<$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "perdio 5A";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
            if ($AB5==$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "empate 5A";
                echo "</td>";
                $estadojugadap4=3;
                include("../parley/carculojparley2.php");
            }
        }

        if ($row_Recordset1['tipojp4']=="5B" && $AB5>=0) {
            if ($AB5<$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "gano 5B";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            }
            if ($AB5>$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "perdio 5B";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
            if ($AB5==$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "empate 5B";
                echo "</td>";
                $estadojugadap4=3;
                include("../parley/carculojparley2.php");
            }
        }

        if ($row_Recordset1['tipojp4']=="SI" && $AB>0 && $sino>0) {
            if ($sino>0) {
                echo "<td>";
                echo "gano SI";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            } else {
                echo "<td>";
                echo "perdio SI";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
        }

        if ($row_Recordset1['tipojp4']=="NO" && $AB>0 && $sino>0) {
            if ($sino==2) {
                echo "<td>";
                echo "gano NO";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            } else {
                echo "<td>";
                echo "perdio NO";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
        }

        // V/H es quien anota primero AP
        if ($row_Recordset1['tipojp4']=="AP" && $AB>0 && $row11['anotaprimerop5']!="0") {
            if ($Anota1ero==$row_Recordset1['equipop4']) {
                echo "<td>";
                echo "gano AP";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            } else {
                echo "<td>";
                echo "perdio AP";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
        }


        
        if ($row_Recordset1['tipojp4']=="AG" && $AB>0) {
            if ($EHC>$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "gano AG";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            }
            if ($EHC<$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "perdio AG";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
            if ($EHC==$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "empate AG";
                echo "</td>";
                $estadojugadap4=3;
                include("../parley/carculojparley2.php");
            }
        }

        if ($row_Recordset1['tipojp4']=="BG" && $AB>0) {
            if ($EHC<$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "gano BG";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            }
            if ($EHC>$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "perdio BG";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
            if ($EHC==$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "empate BG";
                echo "</td>";
                $estadojugadap4=3;
                include("../parley/carculojparley2.php");
            }
        }
        echo "<td>";
        echo $row_Recordset1['lineatp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['premioapagarp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['logrop4'];
        echo "</td>";
        echo "</tr>";
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));


    // echo $totaljugadas;
}
//fin beisbol

//inicio baloncesto
if ($row_Recordset1['deportep2']=='baloncesto') {
    $AB=$row11['r21p5']+$row11['r22p5']+$row11['r23p5']+$row11['r24p5'];
    $ABmi=$row11['r21p5']+$row11['r22p5'];
    if (($row11['r21p5']+$row11['r23p5'])>($row11['r22p5']+$row11['r24p5'])) {
        $gano=1;
    } else {
        $gano=2;
    }
    if ($row11['r21p5']>$row11['r22p5']) {
        $ganomi=1;
    }
    if ($row11['r21p5']<$row11['r22p5']) {
        $ganomi=2;
    }
    if ($row11['r21p5']==$row11['r22p5']) {
        $ganomi=3;
    }

    do {
        echo "<tr>";
        echo "<td>";
        echo $Id_p2juegosp2;
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['Id_p4jugadasp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['nticketp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['equipop4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['tipojp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['ab_o_rlp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['estadojugadap4'];
        echo "</td>";
        
        
        $query_Recordset2 = sprintf(
            "/* PARSEADORES1 new\parley\carculojparley.php - QUERY 8 */ SELECT * FROM p1equipos WHERE 
nomequipop1 = %s",
            GetSQLValueString($row_Recordset1['equipop4'], "text")
        );
        $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

        
        $query_Recordset3 = sprintf(
            "/* PARSEADORES1 new\parley\carculojparley.php - QUERY 9 */ SELECT * FROM p2juegos WHERE 
                        iniciodtp2 >= %s AND iniciodtp2 <= %s AND 
idequipo1p2 = %s AND Id_p2juegosp2 = %s",
GetSQLValueString($Fechacal.' 00:00:02', "date"),
GetSQLValueString($Fechacal.' 23:59:59', "date"),
            GetSQLValueString($row_Recordset2['Id_p1equiposp1'], "int"),
            GetSQLValueString($Id_p2juegosp2, "int")
        );
        $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
        $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
        $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
        if ($totalRows_Recordset3==0) {
            $equipo=2;
        } else {
            $equipo=1;
        }

        echo "<td>";
        echo $equipo;
        echo "</td>";


        
        
        
        if ($row_Recordset1['tipojp4']=="ML" && $AB>0) {
            if (($equipo==1 && $gano==1) or ($equipo==2 && $gano==2)) {
                echo "<td>";
                echo "gano ml";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            }
            if (($equipo==1 && $gano==2) or ($equipo==2 && $gano==1)) {
                echo "<td>";
                echo "perdio ml";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
        }

        if ($row_Recordset1['tipojp4']=="5ML" && $AB>0) {
            if (($equipo==1 && $ganomi==1) or ($equipo==2 && $ganomi==2)) {
                echo "<td>";
                echo "gano 5ml";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            }
            if (($equipo==1 && $ganomi==2) or ($equipo==2 && $ganomi==1)) {
                echo "<td>";
                echo "perdio 5ml";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
            if (($equipo==1 && $ganomi==3) or ($equipo==2 && $ganomi==3)) {
                echo "<td>";
                echo "5mlempate ";
                echo "</td>";
                $estadojugadap4=3;
                include("../parley/carculojparley2.php");
            }
        }
        if ((($row_Recordset1['tipojp4']=="RL" && $AB>0) or ($row_Recordset1['tipojp4']=="SR" && $AB>0))) {
            $ERL1=$row11['r21p5']+$row11['r23p5'];
            $ERL2=$row11['r22p5']+$row11['r24p5'];
            if ($equipo==1) {
                $carrerase1rl=$row11['r21p5']+$row11['r23p5']+$row_Recordset1['ab_o_rlp4'];
                if ($carrerase1rl>($row11['r22p5']+$row11['r24p5'])) {
                    echo "<td>";
                    echo "gano RL";
                    echo "</td>";
                    $estadojugadap4=1;
                    include("../parley/carculojparley2.php");
                } else {
                    echo "<td>";
                    echo "perdio RL";
                    echo "</td>";
                    $estadojugadap4=2;
                    include("../parley/carculojparley2.php");
                }
                if ($ERL1==$ERL2) {
                    echo "<td>";
                    echo "Devolucion RL";
                    echo "</td>";
                    $estadojugadap4=3;
                    include("../parley/carculojparley2.php");
                } 
            }
            if ($equipo==2) {
                $carrerase2rl=$row11['r22p5']+$row11['r24p5']+$row_Recordset1['ab_o_rlp4'];
                if ($carrerase2rl>($row11['r21p5']+$row11['r23p5'])) {
                    echo "<td>";
                    echo "gano RL";
                    echo "</td>";
                    $estadojugadap4=1;
                    include("../parley/carculojparley2.php");
                } else {
                    echo "<td>";
                    echo "perdio RL";
                    echo "</td>";
                    $estadojugadap4=2;
                    include("../parley/carculojparley2.php");
                }
                if ($ERL1==$ERL2) {
                    echo "<td>";
                    echo "Devolucion RL";
                    echo "</td>";
                    $estadojugadap4=3;
                    include("../parley/carculojparley2.php");
                }
            }
        }

        if ((($row_Recordset1['tipojp4']=="5RL" && $ABmi>0) or ($row_Recordset1['tipojp4']=="5SR" && $ABmi>0))) {
            if ($equipo==1) {
                $carrerase1rl=$row11['r21p5']+$row_Recordset1['ab_o_rlp4'];
                if ($carrerase1rl>($row11['r22p5'])) {
                    echo "<td>";
                    echo "gano 5RL";
                    echo "</td>";
                    $estadojugadap4=1;
                    include("../parley/carculojparley2.php");
                } else {
                    echo "<td>";
                    echo "perdio 5RL";
                    echo "</td>";
                    $estadojugadap4=2;
                    include("../parley/carculojparley2.php");
                }
                if ($row11['r21p5']==$row11['r22p5']) {
                    echo "<td>";
                    echo "Devolucion 5RL";
                    echo "</td>";
                    $estadojugadap4=3;
                    include("../parley/carculojparley2.php");
                }
            }
            if ($equipo==2) {
                $carrerase2rl=$row11['r22p5']+$row_Recordset1['ab_o_rlp4'];
                if ($carrerase2rl>($row11['r21p5'])) {
                    echo "<td>";
                    echo "gano 5RL";
                    echo "</td>";
                    $estadojugadap4=1;
                    include("../parley/carculojparley2.php");
                } else {
                    echo "<td>";
                    echo "perdio 5RL";
                    echo "</td>";
                    $estadojugadap4=2;
                    include("../parley/carculojparley2.php");
                }
            }
            if ($row11['r21p5']==$row11['r22p5']) {
                echo "<td>";
                echo "Devolucion 5RL";
                echo "</td>";
                $estadojugadap4=3;
                include("../parley/carculojparley2.php");
            }
        }


        if ($row_Recordset1['tipojp4']=="A" && $AB>0) {
            if ($AB>$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "gano A";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");


                
            }if ($AB==$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "Devolucion A";
                echo "</td>";
                $estadojugadap4=3;
                include("../parley/carculojparley2.php");
            } 
            if($AB<$row_Recordset1['ab_o_rlp4']){
                echo "<td>";
                echo "perdio A";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
        }

        if ($row_Recordset1['tipojp4']=="B" && $AB>0) {
            if ($AB<$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "gano B";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");

               
            } if ($AB==$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "Devolucion B";
                echo "</td>";
                $estadojugadap4=3;
                include("../parley/carculojparley2.php");
            }
            if($AB>$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "perdio B";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
        }

        if ($row_Recordset1['tipojp4']=="5A" && $ABmi>0) {
            if ($ABmi>$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "gano 5A";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            }
            if ($ABmi==$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "Devolucion 5A";
                echo "</td>";
                $estadojugadap4=3;
                include("../parley/carculojparley2.php");
            }
            if ($ABmi<$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "perdio 5A";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
        }

        if ($row_Recordset1['tipojp4']=="5B" && $ABmi>0) {
            if ($ABmi<$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "gano 5B";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            }
            if ($ABmi==$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "Devolucion 5B";
                echo "</td>";
                $estadojugadap4=3;
                include("../parley/carculojparley2.php");
            }
            if ($ABmi>$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "perdio 5B";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
        }


        echo "<td>";
        echo $row_Recordset1['lineatp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['premioapagarp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['logrop4'];
        echo "</td>";
        echo "</tr>";
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}

//fin baloncesto

//inicio futbol
if ($row_Recordset1['deportep2']=='futbol' or $row_Recordset1['deportep2']=='futbolamericano' or $row_Recordset1['deportep2']=='baloncesto') {
    $AB=$row11['r21p5']+$row11['r22p5']+$row11['r23p5']+$row11['r24p5'];
    $ABmi=$row11['r21p5']+$row11['r22p5'];
    if (($row11['r21p5']+$row11['r23p5'])>($row11['r22p5']+$row11['r24p5'])) {
        $gano=1;
    }
    if (($row11['r21p5']+$row11['r23p5'])<($row11['r22p5']+$row11['r24p5'])) {
        $gano=2;
    }
    if (($row11['r21p5']+$row11['r23p5'])==($row11['r22p5']+$row11['r24p5'])) {
        $gano=3;
    }
    if ($row11['r21p5']>$row11['r22p5']) {
        $ganomi=1;
    }
    if ($row11['r21p5']<$row11['r22p5']) {
        $ganomi=2;
    }
    if ($row11['r21p5']==$row11['r22p5']) {
        $ganomi=3;
    }

    do {
        echo "<tr>";
        echo "<td>";
        echo $Id_p2juegosp2;
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['Id_p4jugadasp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['nticketp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['equipop4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['tipojp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['ab_o_rlp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['estadojugadap4'];
        echo "</td>";
        
        
        $query_Recordset2 = sprintf(
            "/* PARSEADORES1 new\parley\carculojparley.php - QUERY 10 */ SELECT * FROM p1equipos WHERE 
nomequipop1 = %s",
            GetSQLValueString($row_Recordset1['equipop4'], "text")
        );
        $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

        
        $query_Recordset3 = sprintf(
            "/* PARSEADORES1 new\parley\carculojparley.php - QUERY 11 */ SELECT * FROM p2juegos WHERE 
                        iniciodtp2 >= %s AND iniciodtp2 <= %s AND 
idequipo1p2 = %s AND Id_p2juegosp2 = %s",
GetSQLValueString($Fechacal.' 00:00:02', "date"),
GetSQLValueString($Fechacal.' 23:59:59', "date"),
            GetSQLValueString($row_Recordset2['Id_p1equiposp1'], "int"),
            GetSQLValueString($Id_p2juegosp2, "int")
        );
        $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
        $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
        $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
        if ($totalRows_Recordset3==0) {
            $equipo=2;
        } else {
            $equipo=1;
        }

        echo "<td>";
        echo $equipo;
        echo "</td>";


        if ($row_Recordset1['tipojp4']=="EML") {
            if ($row11['r21p5']+$row11['r23p5']==$row11['r22p5']+$row11['r24p5']) {
                echo "<td>";
                echo "gano EML";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            } else {
                echo "<td>";
                echo "perdio EML";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
        }
        
        
        if ($row_Recordset1['tipojp4']=="ML") {
            if (($equipo==1 && $gano==1) or ($equipo==2 && $gano==2)) {
                echo "<td>";
                echo "gano ml";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            }
            if (($equipo==1 && $gano==2) or ($equipo==2 && $gano==1)) {
                echo "<td>";
                echo "perdio ml";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
            if ($gano==3) {
                echo "<td>";
                echo "perdio ml";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
        }


        
        if ($row_Recordset1['tipojp4']=="E5ML") {
            if ($row11['r21p5']==$row11['r22p5']) {
                echo "<td>";
                echo "gano E5ML";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            } else {
                echo "<td>";
                echo "perdio E5ML";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
        }

        if ($row_Recordset1['tipojp4']=="5ML") {
            if (($equipo==1 && $ganomi==1) or ($equipo==2 && $ganomi==2)) {
                echo "<td>";
                echo "gano 5ml";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            }
            if (($equipo==1 && $ganomi==2) or ($equipo==2 && $ganomi==1)) {
                echo "<td>";
                echo "perdio 5ml";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
            if ($ganomi==3) {
                echo "<td>";
                echo "perdio 5ml ";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
        }
        if ((($row_Recordset1['tipojp4']=="RL" && $AB>0) or ($row_Recordset1['tipojp4']=="SR" && $AB>0))) {
            $ERL1=$row11['r21p5']+$row11['r23p5'];
            $ERL2=$row11['r22p5']+$row11['r24p5'];
            if ($equipo==1) {
                $carrerase1rl=$row11['r21p5']+$row11['r23p5']+$row_Recordset1['ab_o_rlp4'];
                if ($carrerase1rl>($row11['r22p5']+$row11['r24p5'])) {
                    echo "<td>";
                    echo "gano RL";
                    echo "</td>";
                    $estadojugadap4=1;
                    include("../parley/carculojparley2.php");
                } else {
                    echo "<td>";
                    echo "perdio RL";
                    echo "</td>";
                    $estadojugadap4=2;
                    include("../parley/carculojparley2.php");
                }
                if ($ERL1==$ERL2) {
                    echo "<td>";
                    echo "Devolucion RL";
                    echo "</td>";
                    $estadojugadap4=3;
                    include("../parley/carculojparley2.php");
                }
            }
            if ($equipo==2) {
                $carrerase2rl=$row11['r22p5']+$row11['r24p5']+$row_Recordset1['ab_o_rlp4'];
                if ($carrerase2rl>($row11['r21p5']+$row11['r23p5'])) {
                    echo "<td>";
                    echo "gano RL";
                    echo "</td>";
                    $estadojugadap4=1;
                    include("../parley/carculojparley2.php");
                } else {
                    echo "<td>";
                    echo "perdio RL";
                    echo "</td>";
                    $estadojugadap4=2;
                    include("../parley/carculojparley2.php");
                }
                if ($ERL1==$ERL2) {
                    echo "<td>";
                    echo "Devolucion RL";
                    echo "</td>";
                    $estadojugadap4=3;
                    include("../parley/carculojparley2.php");
                }
            }
        }

        if ((($row_Recordset1['tipojp4']=="5RL") or ($row_Recordset1['tipojp4']=="5SR"))) {
            if ($equipo==1) {
                $carrerase1rl=$row11['r21p5']+$row_Recordset1['ab_o_rlp4'];
                if ($carrerase1rl>($row11['r22p5'])) {
                    echo "<td>";
                    echo "gano 5RL";
                    echo "</td>";
                    $estadojugadap4=1;
                    include("../parley/carculojparley2.php");
                } else {
                    echo "<td>";
                    echo "perdio 5RL";
                    echo "</td>";
                    $estadojugadap4=2;
                    include("../parley/carculojparley2.php");
                }
                if ($row11['r21p5']==$row11['r22p5']) {
                    echo "<td>";
                    echo "Devolucion 5RL";
                    echo "</td>";
                    $estadojugadap4=3;
                    include("../parley/carculojparley2.php");
                }
            }
            if ($equipo==2) {
                $carrerase2rl=$row11['r22p5']+$row_Recordset1['ab_o_rlp4'];
                if ($carrerase2rl>($row11['r21p5'])) {
                    echo "<td>";
                    echo "gano 5RL";
                    echo "</td>";
                    $estadojugadap4=1;
                    include("../parley/carculojparley2.php");
                } else {
                    echo "<td>";
                    echo "perdio 5RL";
                    echo "</td>";
                    $estadojugadap4=2;
                    include("../parley/carculojparley2.php");
                }
            }
            if ($row11['r21p5']==$row11['r22p5']) {
                echo "<td>";
                echo "Devolucion 5RL";
                echo "</td>";
                $estadojugadap4=3;
                include("../parley/carculojparley2.php");
            }
        }


        if ($row_Recordset1['tipojp4']=="A") {
            if ($AB>$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "gano A";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            }
            if ($AB<$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "perdio A";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
            if ($AB==$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "anulada A";
                echo "</td>";
                $estadojugadap4=3;
                include("../parley/carculojparley2.php");
            }
        }

        if ($row_Recordset1['tipojp4']=="B") {
            if ($AB<$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "gano B";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            }
            if ($AB>$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "perdio B";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
            if ($AB==$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "anulada B";
                echo "</td>";
                $estadojugadap4=3;
                include("../parley/carculojparley2.php");
            }
        }

        if ($row_Recordset1['tipojp4']=="5A") {
            if ($ABmi>$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "gano 5A";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            }
            if ($ABmi<$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "perdio 5A";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
            if ($ABmi==$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "anulado 5A";
                echo "</td>";
                $estadojugadap4=3;
                include("../parley/carculojparley2.php");
            }
        }

        if ($row_Recordset1['tipojp4']=="5B") {
            if ($ABmi<$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "gano 5B";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            }
            if ($ABmi>$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "perdio 5B";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
            if ($ABmi==$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "anulado 5B";
                echo "</td>";
                $estadojugadap4=3;
                include("../parley/carculojparley2.php");
            }
        }


        echo "<td>";
        echo $row_Recordset1['lineatp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['premioapagarp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['logrop4'];
        echo "</td>";
        echo "</tr>";
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}
// fin futbol


//inicio hockey
if ($row_Recordset1['deportep2']=='hockey') {
    $AB=$row11['r21p5']+$row11['r22p5'];
    if (($row11['r21p5'])>($row11['r22p5'])) {
        $gano=1;
    } else {
        $gano=2;
    }


    do {
        echo "<tr>";
        echo "<td>";
        echo $Id_p2juegosp2;
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['Id_p4jugadasp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['nticketp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['equipop4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['tipojp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['ab_o_rlp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['estadojugadap4'];
        echo "</td>";
        
        
        $query_Recordset2 = sprintf(
            "/* PARSEADORES1 new\parley\carculojparley.php - QUERY 12 */ SELECT * FROM p1equipos WHERE 
nomequipop1 = %s",
            GetSQLValueString($row_Recordset1['equipop4'], "text")
        );
        $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

        
        $query_Recordset3 = sprintf(
            "/* PARSEADORES1 new\parley\carculojparley.php - QUERY 13 */ SELECT * FROM p2juegos WHERE 
                        iniciodtp2 >= %s AND iniciodtp2 <= %s AND 
idequipo1p2 = %s AND Id_p2juegosp2 = %s",
GetSQLValueString($Fechacal.' 00:00:02', "date"),
GetSQLValueString($Fechacal.' 23:59:59', "date"),
            GetSQLValueString($row_Recordset2['Id_p1equiposp1'], "int"),
            GetSQLValueString($Id_p2juegosp2, "int")
        );
        $Recordset3 = mysqli_query($conexionbanca, $query_Recordset3) or die(mysqli_error($conexionbanca));
        $row_Recordset3 = mysqli_fetch_assoc($Recordset3);
        $totalRows_Recordset3 = mysqli_num_rows($Recordset3);
        if ($totalRows_Recordset3==0) {
            $equipo=2;
        } else {
            $equipo=1;
        }

        echo "<td>";
        echo $equipo;
        echo "</td>";


        
        
        
        if ($row_Recordset1['tipojp4']=="ML" && $AB>0) {
            if (($equipo==1 && $gano==1) or ($equipo==2 && $gano==2)) {
                echo "<td>";
                echo "gano ml";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            }
            if (($equipo==1 && $gano==2) or ($equipo==2 && $gano==1)) {
                echo "<td>";
                echo "perdio ml";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
        }


        if ((($row_Recordset1['tipojp4']=="RL" && $AB>=0) or ($row_Recordset1['tipojp4']=="SR" && $AB>0))) {
            $ERL1=$row11['r21p5']+$row11['r23p5'];
            $ERL2=$row11['r22p5']+$row11['r24p5'];
            if ($equipo==1) {
                $carrerase1rl=$row11['r21p5']+$row11['r23p5']+$row_Recordset1['ab_o_rlp4'];
                if ($carrerase1rl>($row11['r22p5']+$row11['r24p5'])) {
                    echo "<td>";
                    echo "gano RL";
                    echo "</td>";
                    $estadojugadap4=1;
                    include("../parley/carculojparley2.php");
                } else {
                    echo "<td>";
                    echo "perdio RL";
                    echo "</td>";
                    $estadojugadap4=2;
                    include("../parley/carculojparley2.php");
                }
                if ($ERL1==$ERL2) {
                    echo "<td>";
                    echo "Devolucion RL";
                    echo "</td>";
                    $estadojugadap4=3;
                    include("../parley/carculojparley2.php");
                }
            }
            if ($equipo==2) {
                $carrerase2rl=$row11['r22p5']+$row11['r24p5']+$row_Recordset1['ab_o_rlp4'];
                if ($carrerase2rl>($row11['r21p5']+$row11['r23p5'])) {
                    echo "<td>";
                    echo "gano RL";
                    echo "</td>";
                    $estadojugadap4=1;
                    include("../parley/carculojparley2.php");
                } else {
                    echo "<td>";
                    echo "perdio RL";
                    echo "</td>";
                    $estadojugadap4=2;
                    include("../parley/carculojparley2.php");
                }
                if ($ERL1==$ERL2) {
                    echo "<td>";
                    echo "Devolucion RL";
                    echo "</td>";
                    $estadojugadap4=3;
                    include("../parley/carculojparley2.php");
                }
            }
        }



        if ($row_Recordset1['tipojp4']=="A" && $AB>0) {
            if ($AB>$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "gano A";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            } else {
                echo "<td>";
                echo "perdio A";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
        }

        if ($row_Recordset1['tipojp4']=="B" && $AB>0) {
            if ($AB<$row_Recordset1['ab_o_rlp4']) {
                echo "<td>";
                echo "gano B";
                echo "</td>";
                $estadojugadap4=1;
                include("../parley/carculojparley2.php");
            } else {
                echo "<td>";
                echo "perdio B";
                echo "</td>";
                $estadojugadap4=2;
                include("../parley/carculojparley2.php");
            }
        }






        echo "<td>";
        echo $row_Recordset1['lineatp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['premioapagarp4'];
        echo "</td>";
        echo "<td>";
        echo $row_Recordset1['logrop4'];
        echo "</td>";
        echo "</tr>";
    } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}

//fin hockey




if($auto==0){
  
?>
<script> 
//<!--
window.close(); 
//-->
</script>
<script>

</script>
</table>
  </body>
</html>
<?php } }}?>