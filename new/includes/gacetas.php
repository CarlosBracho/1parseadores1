<?php
require_once('../Connections/conexionbanca.php');


$fechasistema=fechaactualbd();
$horasistema=horaactual();
$query_Recordset6 = sprintf("/* PARSEADORES1 new\includes\gacetas.php - QUERY 1 */ SELECT nom_hipodromo, cod_hipodromo
 FROM carrera USE INDEX(fec_carrera) 
 WHERE num_carrera = 1 
 AND fec_carrera = %s 
 ORDER BY hor_carrera 
 DESC LIMIT 59", GetSQLValueString($fechasistema, "date"));
$Recordset6 = mysqli_query($conexionbanca, $query_Recordset6) or die(mysqli_error($conexionbanca));
$row_Recordset6 = mysqli_fetch_assoc($Recordset6);
$totalRows_Recordset6 = mysqli_num_rows($Recordset6);


if ($totalRows_Recordset6>0) {
    do {
        echo $totalRows_Recordset6;
        echo "<br/>";
        echo $row_Recordset6['nom_hipodromo'];
        echo "<br/>";
        echo $row_Recordset6['cod_hipodromo'];
        echo "<br/>";

        if ($row_Recordset6['cod_hipodromo'] == "5") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/aqu.pdf");
            rename("/home/apuestas/public_html/includes/aqu.pdf", "/home/apuestas/public_html/gacetas/AQUEDUCT REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/AQUEDUCT.pdf");
            rename("/home/apuestas/public_html/includes/AQUEDUCT.pdf", "/home/apuestas/public_html/gacetas/AQUEDUCT WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "7") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/ap.pdf");
            rename("/home/apuestas/public_html/includes/ap.pdf", "/home/apuestas/public_html/gacetas/ARLINGTON PARK REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/ARLINGTON.pdf");
            rename("/home/apuestas/public_html/includes/ARLINGTON.pdf", "/home/apuestas/public_html/gacetas/ARLINGTON PARK WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "13") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/bel.pdf");
            rename("/home/apuestas/public_html/includes/bel.pdf", "/home/apuestas/public_html/gacetas/BELMONT PARK REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/BELMONT.pdf");
            rename("/home/apuestas/public_html/includes/BELMONT.pdf", "/home/apuestas/public_html/gacetas/BELMONT PARK WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "23") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/ct.pdf");
            rename("/home/apuestas/public_html/includes/ct.pdf", "/home/apuestas/public_html/gacetas/CHARLES TOWN REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/CHARLES.pdf");
            rename("/home/apuestas/public_html/includes/CHARLES.pdf", "/home/apuestas/public_html/gacetas/CHARLES TOWN WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "27") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/cd.pdf");
            rename("/home/apuestas/public_html/includes/cd.pdf", "/home/apuestas/public_html/gacetas/CHURCHILL DOWNS REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/CHURCHILL.pdf");
            rename("/home/apuestas/public_html/includes/CHURCHILL.pdf", "/home/apuestas/public_html/gacetas/CHURCHILL DOWNS WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "31") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/dmr.pdf");
            rename("/home/apuestas/public_html/includes/dmr.pdf", "/home/apuestas/public_html/gacetas/DEL MAR REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/DELMAR.pdf");
            rename("/home/apuestas/public_html/includes/DELMAR.pdf", "/home/apuestas/public_html/gacetas/DEL MAR WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "32") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/del.pdf");
            rename("/home/apuestas/public_html/includes/del.pdf", "/home/apuestas/public_html/gacetas/DELAWARE PARK REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/DELAWARE.pdf");
            rename("/home/apuestas/public_html/includes/DELAWARE.pdf", "/home/apuestas/public_html/gacetas/DELAWARE PARK WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "33") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/ded.pdf");
            rename("/home/apuestas/public_html/includes/ded.pdf", "/home/apuestas/public_html/gacetas/DELTA DOWNS REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/DELTA.pdf");
            rename("/home/apuestas/public_html/includes/DELTA.pdf", "/home/apuestas/public_html/gacetas/DELTA DOWNS WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "39") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/evd.pdf");
            rename("/home/apuestas/public_html/includes/evd.pdf", "/home/apuestas/public_html/gacetas/EVANGELINE DOWNS REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/EVANGELINE.pdf");
            rename("/home/apuestas/public_html/includes/EVANGELINE.pdf", "/home/apuestas/public_html/gacetas/EVANGELINE DOWNS WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "40") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/fg.pdf");
            rename("/home/apuestas/public_html/includes/fg.pdf", "/home/apuestas/public_html/gacetas/FAIR GROUNDS REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/FAIR.pdf");
            rename("/home/apuestas/public_html/includes/FAIR.pdf", "/home/apuestas/public_html/gacetas/FAIR GROUNDS  WINNERS CHOICE.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/FAIRGROUND.pdf");
            rename("/home/apuestas/public_html/includes/FAIRGROUND.pdf", "/home/apuestas/public_html/gacetas/FAIR GROUNDS WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "47") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/fl.pdf");
            rename("/home/apuestas/public_html/includes/fl.pdf", "/home/apuestas/public_html/gacetas/FINGER LAKES REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/FINGER.pdf");
            rename("/home/apuestas/public_html/includes/FINGER.pdf", "/home/apuestas/public_html/gacetas/FINGER LAKES WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "56") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/gg.pdf");
            rename("/home/apuestas/public_html/includes/gg.pdf", "/home/apuestas/public_html/gacetas/GOLDEN GATE FIELDS REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/GOLDEN.pdf");
            rename("/home/apuestas/public_html/includes/GOLDEN.pdf", "/home/apuestas/public_html/gacetas/GOLDEN GATE FIELDS WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "62") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/gpw.pdf");
            rename("/home/apuestas/public_html/includes/gpw.pdf", "/home/apuestas/public_html/gacetas/GULFSTREAM PARK WEST REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/GULFSTREAM.pdf");
            rename("/home/apuestas/public_html/includes/GULFSTREAM.pdf", "/home/apuestas/public_html/gacetas/GULFSTREAM PARK WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "65") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/haw.pdf");
            rename("/home/apuestas/public_html/includes/haw.pdf", "/home/apuestas/public_html/gacetas/HAWTHORNE REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/HAWTHORNE.pdf");
            rename("/home/apuestas/public_html/includes/HAWTHORNE.pdf", "/home/apuestas/public_html/gacetas/HAWTHORNE WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "71") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/kee.pdf");
            rename("/home/apuestas/public_html/includes/kee.pdf", "/home/apuestas/public_html/gacetas/KEENELAND REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/KEENELAND.pdf");
            rename("/home/apuestas/public_html/includes/KEENELAND.pdf", "/home/apuestas/public_html/gacetas/KEENELAND WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "75") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/lrl.pdf");
            rename("/home/apuestas/public_html/includes/lrl.pdf", "/home/apuestas/public_html/gacetas/LAUREL PARK REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/LAUREL.pdf");
            rename("/home/apuestas/public_html/includes/LAUREL.pdf", "/home/apuestas/public_html/gacetas/LAUREL PARK WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "78") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/ls.pdf");
            rename("/home/apuestas/public_html/includes/ls.pdf", "/home/apuestas/public_html/gacetas/LONE STAR PARK REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/LONE.pdf");
            rename("/home/apuestas/public_html/includes/LONE.pdf", "/home/apuestas/public_html/gacetas/LONE STAR PARK WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "79") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/la.pdf");
            rename("/home/apuestas/public_html/includes/la.pdf", "/home/apuestas/public_html/gacetas/LOS ALAMITOS QH REVISTA.pdf");

            // exec("wget http://www.centrohipicovip.com/pag/htm/GULFSTREAM.pdf");
// rename ("/home/apuestas/public_html/includes/GULFSTREAM.pdf", "/home/apuestas/public_html/gacetas/GULFSTREAM PARK WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "92") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/mnr.pdf");
            rename("/home/apuestas/public_html/includes/mnr.pdf", "/home/apuestas/public_html/gacetas/MOUNTAINEER PARK REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/MOUNTAINEER.pdf");
            rename("/home/apuestas/public_html/includes/MOUNTAINEER.pdf", "/home/apuestas/public_html/gacetas/MOUNTAINEER PARK WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "96") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/op.pdf");
            rename("/home/apuestas/public_html/includes/op.pdf", "/home/apuestas/public_html/gacetas/OAKLAWN PARK REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/OAKLAWN.pdf");
            rename("/home/apuestas/public_html/includes/OAKLAWN.pdf", "/home/apuestas/public_html/gacetas/OAKLAWN PARK WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "100") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/prx.pdf");
            rename("/home/apuestas/public_html/includes/prx.pdf", "/home/apuestas/public_html/gacetas/PARX RACING REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/PARX.pdf");
            rename("/home/apuestas/public_html/includes/PARX.pdf", "/home/apuestas/public_html/gacetas/PARX RACING WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "101") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/pen.pdf");
            rename("/home/apuestas/public_html/includes/pen.pdf", "/home/apuestas/public_html/gacetas/PENN NATIONAL REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/PENN.pdf");
            rename("/home/apuestas/public_html/includes/PENN.pdf", "/home/apuestas/public_html/gacetas/PENN NATIONAL WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "109") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/prm.pdf");
            rename("/home/apuestas/public_html/includes/prm.pdf", "/home/apuestas/public_html/gacetas/PRAIRIE MEADOWS REVISTA.pdf");

            // exec("wget http://www.centrohipicovip.com/pag/htm/GULFSTREAM.pdf");
// rename ("/home/apuestas/public_html/includes/GULFSTREAM.pdf", "/home/apuestas/public_html/gacetas/GULFSTREAM PARK WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "110") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/pid.pdf");
            rename("/home/apuestas/public_html/includes/pid.pdf", "/home/apuestas/public_html/gacetas/PRESQUE ISLE DOWNS REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/PRESQUE.pdf");
            rename("/home/apuestas/public_html/includes/PRESQUE.pdf", "/home/apuestas/public_html/gacetas/PRESQUE ISLE DOWNS WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "111") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/rp.pdf");
            rename("/home/apuestas/public_html/includes/rp.pdf", "/home/apuestas/public_html/gacetas/REMINGTON PARK REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/REMINGTON.pdf");
            rename("/home/apuestas/public_html/includes/REMINGTON.pdf", "/home/apuestas/public_html/gacetas/REMINGTON PARK WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "118") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/sa.pdf");
            rename("/home/apuestas/public_html/includes/sa.pdf", "/home/apuestas/public_html/gacetas/SANTA ANITA PARK REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/SANTA.pdf");
            rename("/home/apuestas/public_html/includes/SANTA.pdf", "/home/apuestas/public_html/gacetas/SANTA ANITA PARK WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "123") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/ind.pdf");
            rename("/home/apuestas/public_html/includes/ind.pdf", "/home/apuestas/public_html/gacetas/INDIANA GRAND REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/INDIANA.pdf");
            rename("/home/apuestas/public_html/includes/INDIANA.pdf", "/home/apuestas/public_html/gacetas/INDIANA GRAND WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "131") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/tam.pdf");
            rename("/home/apuestas/public_html/includes/tam.pdf", "/home/apuestas/public_html/gacetas/TAMPA BAY DOWNS REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/TAMPA.pdf");
            rename("/home/apuestas/public_html/includes/TAMPA.pdf", "/home/apuestas/public_html/gacetas/TAMPA BAY DOWNS WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "132") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/tdn.pdf");
            rename("/home/apuestas/public_html/includes/tdn.pdf", "/home/apuestas/public_html/gacetas/THISTLEDOWN REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/THISTLE.pdf");
            rename("/home/apuestas/public_html/includes/THISTLE.pdf", "/home/apuestas/public_html/gacetas/THISTLEDOWN WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "136") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/tup.pdf");
            rename("/home/apuestas/public_html/includes/tup.pdf", "/home/apuestas/public_html/gacetas/TURF PARADISE REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/TURF.pdf");
            rename("/home/apuestas/public_html/includes/TURF.pdf", "/home/apuestas/public_html/gacetas/TURF PARADISE WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "137") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/tp.pdf");
            rename("/home/apuestas/public_html/includes/tp.pdf", "/home/apuestas/public_html/gacetas/TURFWAY PARK REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/TURFWAY.pdf");
            rename("/home/apuestas/public_html/includes/TURFWAY.pdf", "/home/apuestas/public_html/gacetas/TURFWAY PARK WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "142") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/wo.pdf");
            rename("/home/apuestas/public_html/includes/wo.pdf", "/home/apuestas/public_html/gacetas/WOODBINE REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/WOODBINE.pdf");
            rename("/home/apuestas/public_html/includes/WOODBINE.pdf", "/home/apuestas/public_html/gacetas/WOODBINE WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "144") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/zia.pdf");
            rename("/home/apuestas/public_html/includes/zia.pdf", "/home/apuestas/public_html/gacetas/ZIA PARK REVISTA.pdf");

            exec("wget http://www.centrohipicovip.com/pag/htm/ZIA.pdf");
            rename("/home/apuestas/public_html/includes/ZIA.pdf", "/home/apuestas/public_html/gacetas/ZIA PARK WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "154") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/gp.pdf");
            rename("/home/apuestas/public_html/includes/gp.pdf", "/home/apuestas/public_html/gacetas/GULFSTREAM PARK REVISTA.pdf");

            // exec("wget http://www.centrohipicovip.com/pag/htm/GULFSTREAM.pdf");
// rename ("/home/apuestas/public_html/includes/GULFSTREAM.pdf", "/home/apuestas/public_html/gacetas/GULFSTREAM PARK WINNERS CHOICE.pdf");
        }

        if ($row_Recordset6['cod_hipodromo'] == "157") {
            exec("wget https://s3.amazonaws.com/dotworkers/racebook/retrospects/juegaenlineave/mvr.pdf");
            rename("/home/apuestas/public_html/includes/mvr.pdf", "/home/apuestas/public_html/gacetas/MAHONING VALLEY RACE REVISTA.pdf");

            // exec("wget http://www.centrohipicovip.com/pag/htm/GULFSTREAM.pdf");
// rename ("/home/apuestas/public_html/includes/GULFSTREAM.pdf", "/home/apuestas/public_html/gacetas/GULFSTREAM PARK WINNERS CHOICE.pdf");
        }
    } while ($row_Recordset6 = mysqli_fetch_assoc($Recordset6));
}

exec("find /home/apuestas/public_html/gacetas/*.pdf -mtime +0 -exec rm {} \;");


mysqli_free_result($Recordset6);
