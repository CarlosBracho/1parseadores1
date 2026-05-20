<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G";$MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
if (isset($_GET["ca"])&&isset($_GET["ta"])) {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\agente_hnac\agente_buscaEjemplar.php - QUERY 1 */ SELECT
		ins.cod_inscrito_hnac, ins.nom_caballo_hnac, ins.num_caballo_hnac 
		FROM carrera_hnac ca, inscritos ins
		WHERE ca.cod_carrera_hnac = %s AND ins.cod_carrera_hnac = ca.cod_carrera_hnac AND
			ins.est_inscrito_hnac = 1",
        GetSQLValueString($_GET["ca"], "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    if ($totalRows_Recordset1>0) {
        $opciones = '<option value="-1">Seleccione</option>';
        $query_Recordset2 = sprintf(
            "/* PARSEADORES1 new\agente_hnac\agente_buscaEjemplar.php - QUERY 2 */ SELECT
			ins.cod_inscrito_hnac, ins.nom_caballo_hnac, ins.num_caballo_hnac,
			ca.num_carrera_hnac,
			pr.max_eje_hnac, pr.max_jug_hnac, pr.min_jug_hnac, pr.pre_fijo_hnac, pr.id_pfijo_hnac
			FROM carrera_hnac ca, inscritos ins, precio_fijo_hnac pr
			WHERE  ca.cod_carrera_hnac = %s AND pr.cod_taquilla = %s AND ins.cod_carrera_hnac = ca.cod_carrera_hnac AND
					pr.cod_carrera_hnac = ca.cod_carrera_hnac AND ins.cod_inscrito_hnac = pr.cod_inscrito_hnac AND
					ins.est_inscrito_hnac = 1",
            GetSQLValueString($_GET["ca"], "int"),
            GetSQLValueString($_GET["ta"], "int")
        );
        $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
        $ca="";
        $nu="";
        $x=0;
        $ap="";
        $mi="";
        $ma="";
        $lista[0]="";
        if ($totalRows_Recordset2>0) {
            $carrera=$row_Recordset2['num_carrera_hnac']." - LISTA DE EJEMPLARES FIJOS";
            do {
                if ($row_Recordset2['num_caballo_hnac']<10) {
                    $row_Recordset2['num_caballo_hnac']="0".$row_Recordset2['num_caballo_hnac'];
                }
                if ($x==0) {
                    $nu=$row_Recordset2['num_caballo_hnac'];
                    $ca=$row_Recordset2['nom_caballo_hnac'];
                    
                    $ap=$row_Recordset2['max_eje_hnac'];
                    $mi=$row_Recordset2['min_jug_hnac'];
                    $ma=$row_Recordset2['max_jug_hnac'];
                    $pr=$row_Recordset2['pre_fijo_hnac'];
                    $ac='<a href=\"#\" onClick=\"eliminar('.$row_Recordset2['id_pfijo_hnac'].')\">QUITAR</a>';
                } else {
                    $nu=$nu."<br/>".$row_Recordset2['num_caballo_hnac'];
                    $ca=$ca."<br/>".$row_Recordset2['nom_caballo_hnac'];
                    $ap=$ap."<br/>".$row_Recordset2['max_eje_hnac'];
                    $mi=$mi."<br/>".$row_Recordset2['min_jug_hnac'];
                    $ma=$ma."<br/>".$row_Recordset2['max_jug_hnac'];
                    $pr=$pr."<br/>".$row_Recordset2['pre_fijo_hnac'];
                    $ac=$ac.'<br/><a href=\"#\" onClick=\"eliminar('.$row_Recordset2['id_pfijo_hnac'].')\">QUITAR</a>';
                }
                $lista[$x]=$row_Recordset2['cod_inscrito_hnac'];
                $x++;
            } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
            do {
                $cod=$row_Recordset1['cod_inscrito_hnac'];
                if (!in_array($cod, $lista)) {
                    $num=$row_Recordset1['num_caballo_hnac'];
                    $nom=$row_Recordset1['nom_caballo_hnac'];
                    if ($num<10) {
                        $num="0".$num;
                    }
                    $opciones.='<option value="'.$cod.'">'.$num.'-'.$nom.'</option>';
                }
            } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        } else {
            do {
                $cod=$row_Recordset1['cod_inscrito_hnac'];
                $num=$row_Recordset1['num_caballo_hnac'];
                $nom=$row_Recordset1['nom_caballo_hnac'];
                if ($num<10) {
                    $num="0".$num;
                }
                $opciones.='<option value="'.$cod.'">'.$num.'-'.$nom.'</option>';
            } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
        }
        echo $opciones;
        echo '<script type="text/javascript">';
        echo '$("#cod_ejemplar").removeAttr("disabled");';
        echo '$("#guarda").prop("disabled", "disabled");';
        echo '$("#prFij").removeAttr("disabled");';
        if ($totalRows_Recordset2>0) {
            echo '$("#preciof").html(" Carrera #:'.$carrera.'<table width=\"100%\" cellpadding=\"0\"  border=\"1\" style=\"text-align:center;font-size:10px;\"><tr valign=\"bottom\" ><td width=\"1%\">#</td><td width=\"30%\">EJEMPLAR</td><td width=\"17%\">APUESTA MAXIMA</td><td width=\"17%\">JUGADA MINIMA</td><td width=\"17%\">JUGADA MAXIMA</td><td width=\"12%\">PRECIO FIJO</td><td width=\"6%\">ACCION</td></tr><tr valign=\"bottom\" ><td>'.$nu.'</td><td align=\"left\">'.$ca.'</td><td align=\"right\">'.$ap.'</td><td align=\"right\">'.$mi.'</td><td align=\"right\">'.$ma.'</td><td align=\"right\">'.$pr.'</td><td align=\"center\">'.$ac.'</td></tr></table>")';
        } else {
            echo '$("#preciof").html("")';
        }
        echo '</script>';
    } else {
        $opciones = '<option value="-1"></option>';
        echo $opciones;
        echo '<script type="text/javascript">';
        echo '$("#cod_ejemplar").prop("disabled", "disabled");';
        echo '$("#guarda").prop("disabled", "disabled");';
        echo '$("#prFij").prop("disabled", "disabled");';
        echo '</script>';
    }
}
if (isset($Recordset2)) {
    mysqli_free_result($Recordset2);
}
if (isset($Recordset1)) {
    mysqli_free_result($Recordset1);
}
