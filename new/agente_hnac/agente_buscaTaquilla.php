<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "G"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
if (isset($_GET["ag"])&&isset($_GET["ta"])&&isset($_GET["ti"])) {
    $fec=fechaactualbd();
    if ($_GET["ti"]==1) {
        $resultado="No hay registros";
        echo '<script type="text/javascript">';
        echo '$("#cod_carrera").prop("disabled", "disabled");';
        echo '$("#cod_ejemplar").prop("disabled", "disabled");';
        echo '$("#xTaquillas").html("");';
        echo '</script>';
        $query_Recordset1 = sprintf(
            "/* PARSEADORES1 new\agente_hnac\agente_buscaTaquilla.php - QUERY 1 */ SELECT
			ta.nom_taquilla, ta.cod_taquilla 
			FROM agencia ag, taquilla ta, taquilla_opc_hnac tp
				WHERE ag.cod_agencia = %s AND ta.cod_agencia = ag.cod_agencia AND ta.cod_taquilla = tp.cod_taquilla",
            GetSQLValueString($_GET["ag"], "int")
        );
        $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
        $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
        $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
        //echo $totalRows_Recordset1." ".$_GET["cod_agencia"];
        if ($totalRows_Recordset1>0) {
            $opciones= '';
            if ($totalRows_Recordset1>=1) {
                $opciones= '<option value="todas">TODAS</option>';
            }
            do {
            } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
            $query_Recordset2 = sprintf(
                "/* PARSEADORES1 new\agente_hnac\agente_buscaTaquilla.php - QUERY 2 */ SELECT
				ta.nom_taquilla, 
				ins.cod_inscrito_hnac, ins.nom_caballo_hnac, ins.num_caballo_hnac,
				ca.num_carrera_hnac, ca.cod_carrera_hnac,
				pr.max_eje_hnac, pr.max_jug_hnac, pr.min_jug_hnac, pr.pre_fijo_hnac, pr.id_pfijo_hnac
				FROM agencia ag, taquilla ta, carrera_hnac ca, inscritos ins, precio_fijo_hnac pr
				WHERE ag.cod_agencia = %s AND ca.fec_carrera_hnac = %s AND ta.cod_agencia = ag.cod_agencia AND
					pr.cod_carrera_hnac = ca.cod_carrera_hnac AND ta.cod_taquilla = pr.cod_taquilla AND
						ins.cod_carrera_hnac = ca.cod_carrera_hnac AND ins.cod_inscrito_hnac = pr.cod_inscrito_hnac AND
						ins.est_inscrito_hnac = 1
					ORDER BY ca.cod_carrera_hnac ASC, ca.num_carrera_hnac, ta.nom_taquilla",
                GetSQLValueString($_GET["ag"], "int"),
                GetSQLValueString($fec, "date")
            );
            $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
            $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
            $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
            if ($totalRows_Recordset2>0) {
                $codCarrera="";
                $resultado="";
                do {
                    if ($codCarrera!=$row_Recordset2['cod_carrera_hnac']) {
                        $codCarrera=$row_Recordset2['cod_carrera_hnac'];
                        //style="border-bottom:1px solid  #D5D5D5"
                        $resultado.='Carrera #:'.$row_Recordset2['num_carrera_hnac'].'<table width=\"100%\" cellpadding=\"0\" border=\"0\" style=\"text-align:center;font-size:10px;border-bottom:1px solid  #D5D5D5\"><tr valign=\"bottom\" bgcolor=\"#E7E7E7\"><td width=\"20%\">TAQUILLA</td><td width=\"1%\">#</td><td width=\"15%\">EJEMPLAR</td><td width=\"12%\">APUESTA MAXIMA</td><td width=\"17%\">JUGADA MINIMA</td><td width=\"17%\">JUGADA MAXIMA</td><td width=\"12%\">PRECIO FIJO</td><td width=\"6%\">ACCION</td></tr></table>';
                    }
                    $tr="tr".$row_Recordset2['id_pfijo_hnac'];
                    $it=$row_Recordset2['id_pfijo_hnac'];
                    $nt="id_pfijo_hnac[]";
                    $ip='<input type=\"checkbox\" onClick=\"cfon('.$tr.','.$it.')\" name=\"'.$nt.'\" id=\"'.$it.'\" value=\"'.$row_Recordset2['id_pfijo_hnac'].'\"/>';
                    $ap=$row_Recordset2['max_eje_hnac'];
                    $mi=$row_Recordset2['min_jug_hnac'];
                    $ma=$row_Recordset2['max_jug_hnac'];
                    $pr=$row_Recordset2['pre_fijo_hnac'];
                    $ac='<a href=\"#\" onClick=\"eliminar('.$row_Recordset2['id_pfijo_hnac'].')\">QUITAR</a>';
                    $resultado.= '<table width=\"100%\" cellpadding=\"0\"  border=\"0\" style=\"text-align:center;font-size:10px;border-bottom:1px solid  #D5D5D5\"><tr valign=\"bottom\" id=\"'.$tr.'\"><td width=\"20%\" align=\"left\">'.$ip.$row_Recordset2['nom_taquilla'].'</td><td width=\"1%\">'.$row_Recordset2['num_caballo_hnac'].'</td><td width=\"15%\" align=\"left\">'.$row_Recordset2['nom_caballo_hnac'].'</td><td width=\"12%\" align=\"right\">'.$ap.'</td><td width=\"17%\" align=\"right\">'.$mi.'</td><td width=\"17%\" align=\"right\">'.$ma.'</td><td width=\"12%\" align=\"right\">'.$pr.'</td><td width=\"6%\">'.$ac.'</td></tr></table>';
                } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
                //echo '<script type="text/javascript">';
                //echo '$("#xTaquillas").html("'.$resultado.'")';
                //echo '<//script>';
            }
            echo $opciones;
            echo '<script type="text/javascript">';
            echo '$("#cod_taquilla").removeAttr("disabled");';
            echo '$("#cod_carrera").removeAttr("disabled");';
            echo '</script>';
        } else {
            echo '<script type="text/javascript">';
            echo '$("#cod_taquilla").prop("disabled", "disabled");';
            echo '</script>';
        }
        echo '<script type="text/javascript">';
        echo '$("#xTaquillas").html("'.$resultado.'")';
        echo '</script>';
    }///
    
    elseif ($_GET["ti"]==2) {
        $resultado="No hay registros";
        if ($_GET["ta"]!="todas") {
            $query_Recordset2 = sprintf(
                "/* PARSEADORES1 new\agente_hnac\agente_buscaTaquilla.php - QUERY 3 */ SELECT
				ta.nom_taquilla,
				ins.cod_inscrito_hnac,
				ins.nom_caballo_hnac,
				ins.num_caballo_hnac,
				ca.num_carrera_hnac,
				ca.cod_carrera_hnac,
				pr.max_eje_hnac,
				pr.max_jug_hnac,
				pr.min_jug_hnac,
				pr.pre_fijo_hnac,
				pr.id_pfijo_hnac
				FROM
					taquilla ta, 
					carrera_hnac ca, 
					inscritos ins,
					precio_fijo_hnac pr
				WHERE
					ta.cod_taquilla = %s AND
					ca.fec_carrera_hnac = %s AND
					pr.cod_carrera_hnac = ca.cod_carrera_hnac AND
					ta.cod_taquilla = pr.cod_taquilla AND
					ins.cod_carrera_hnac = ca.cod_carrera_hnac AND
					ins.cod_inscrito_hnac = pr.cod_inscrito_hnac AND
					ins.est_inscrito_hnac = 1
				ORDER BY ca.cod_carrera_hnac ASC, ca.num_carrera_hnac, ta.nom_taquilla",
                GetSQLValueString($_GET["ta"], "int"),
                GetSQLValueString($fec, "date")
            );
            $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
            $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
            $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
            if ($totalRows_Recordset2>0) {
                $codCarrera="";
                $resultado="";
                do {
                    if ($codCarrera!=$row_Recordset2['cod_carrera_hnac']) {
                        $codCarrera=$row_Recordset2['cod_carrera_hnac'];
                        //style="border-bottom:1px solid  #D5D5D5"
                        $resultado.='Carrera #:'.$row_Recordset2['num_carrera_hnac'].'<table width=\"100%\" cellpadding=\"0\" border=\"0\" style=\"text-align:center;font-size:10px;border-bottom:1px solid  #D5D5D5\"><tr valign=\"bottom\" bgcolor=\"#E7E7E7\"><td width=\"1%\">-</td><td width=\"1%\">#</td><td width=\"35%\">EJEMPLAR</td><td width=\"12%\">APUESTA MAXIMA</td><td width=\"17%\">JUGADA MINIMA</td><td width=\"17%\">JUGADA MAXIMA</td><td width=\"12%\">PRECIO FIJO</td><td width=\"6%\">ACCION</td></tr></table>';
                    }
                    $tr="tr".$row_Recordset2['id_pfijo_hnac'];
                    $it=$row_Recordset2['id_pfijo_hnac'];
                    $nt="id_pfijo_hnac[]";
                    $ip='<input type=\"checkbox\" onClick=\"cfon('.$tr.','.$it.')\" name=\"'.$nt.'\" id=\"'.$it.'\" value=\"'.$row_Recordset2['id_pfijo_hnac'].'\"/>';
                    $ap=$row_Recordset2['max_eje_hnac'];
                    $mi=$row_Recordset2['min_jug_hnac'];
                    $ma=$row_Recordset2['max_jug_hnac'];
                    $pr=$row_Recordset2['pre_fijo_hnac'];
                    $ac='<a href=\"#\" onClick=\"eliminar('.$row_Recordset2['id_pfijo_hnac'].')\">QUITAR</a>';
                    $resultado.= '<table width=\"100%\" cellpadding=\"0\"  border=\"0\" style=\"text-align:center;font-size:10px;border-bottom:1px solid  #D5D5D5\"><tr valign=\"bottom\" id=\"'.$tr.'\" ><td width=\"1%\">'.$ip.'</td><td width=\"1%\">'.$row_Recordset2['num_caballo_hnac'].'</td><td width=\"35%\" align=\"left\">'.$row_Recordset2['nom_caballo_hnac'].'</td><td width=\"12%\" align=\"right\">'.$ap.'</td><td width=\"17%\" align=\"right\">'.$mi.'</td><td width=\"17%\" align=\"right\">'.$ma.'</td><td width=\"12%\" align=\"right\">'.$pr.'</td><td width=\"6%\">'.$ac.'</td></tr></table>';
                } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
            }
        } else {
            $query_Recordset2 = sprintf(
                "/* PARSEADORES1 new\agente_hnac\agente_buscaTaquilla.php - QUERY 4 */ SELECT
				ta.nom_taquilla,
				ins.cod_inscrito_hnac,
				ins.nom_caballo_hnac,
				ins.num_caballo_hnac,
				ca.num_carrera_hnac,
				ca.cod_carrera_hnac,
				pr.max_eje_hnac,
				pr.max_jug_hnac,
				pr.min_jug_hnac,
				pr.pre_fijo_hnac,
				pr.id_pfijo_hnac
				FROM
					agencia ag,
					taquilla ta, 
					carrera_hnac ca, 
					inscritos ins,
					precio_fijo_hnac pr
					WHERE
						ag.cod_agencia = %s AND
						ca.fec_carrera_hnac = %s AND
						ta.cod_agencia = ag.cod_agencia AND
						pr.cod_carrera_hnac = ca.cod_carrera_hnac AND
						ta.cod_taquilla = pr.cod_taquilla AND
						ins.cod_carrera_hnac = ca.cod_carrera_hnac AND
						ins.cod_inscrito_hnac = pr.cod_inscrito_hnac AND
						ins.est_inscrito_hnac = 1
					ORDER BY ca.cod_carrera_hnac ASC, ca.num_carrera_hnac, ta.nom_taquilla",
                GetSQLValueString($_GET["ag"], "int"),
                GetSQLValueString($fec, "date")
            );
            $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
            $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
            $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
            if ($totalRows_Recordset2>0) {
                $codCarrera="";
                $resultado="";
                do {
                    if ($codCarrera!=$row_Recordset2['cod_carrera_hnac']) {
                        $codCarrera=$row_Recordset2['cod_carrera_hnac'];
                        $resultado.='Carrera #:'.$row_Recordset2['num_carrera_hnac'].'<table width=\"100%\" cellpadding=\"0\" border=\"0\" style=\"text-align:center;font-size:10px;border-bottom:1px solid  #D5D5D5\"><tr valign=\"bottom\" bgcolor=\"#E7E7E7\"><td width=\"20%\">TAQUILLA</td><td width=\"1%\">#</td><td width=\"15%\">EJEMPLAR</td><td width=\"12%\">APUESTA MAXIMA</td><td width=\"17%\">JUGADA MINIMA</td><td width=\"17%\">JUGADA MAXIMA</td><td width=\"12%\">PRECIO FIJO</td><td width=\"6%\">ACCION</td></tr></table>';
                    }
                    $tr="tr".$row_Recordset2['id_pfijo_hnac'];
                    $it=$row_Recordset2['id_pfijo_hnac'];
                    $nt="id_pfijo_hnac[]";
                    $ip='<input type=\"checkbox\" onClick=\"cfon('.$tr.','.$it.')\" name=\"'.$nt.'\" id=\"'.$it.'\" value=\"'.$row_Recordset2['id_pfijo_hnac'].'\"/>';
                    $ap=$row_Recordset2['max_eje_hnac'];
                    $mi=$row_Recordset2['min_jug_hnac'];
                    $ma=$row_Recordset2['max_jug_hnac'];
                    $pr=$row_Recordset2['pre_fijo_hnac'];
                    $ac='<a href=\"#\" onClick=\"eliminar('.$row_Recordset2['id_pfijo_hnac'].')\">QUITAR</a>';
                    $resultado.= '<table width=\"100%\" cellpadding=\"0\"  border=\"0\" style=\"text-align:center;font-size:10px;border-bottom:1px solid  #D5D5D5\"><tr valign=\"bottom\" id=\"'.$tr.'\"><td width=\"20%\" align=\"left\">'.$ip.$row_Recordset2['nom_taquilla'].'</td><td width=\"1%\">'.$row_Recordset2['num_caballo_hnac'].'</td><td width=\"15%\" align=\"left\">'.$row_Recordset2['nom_caballo_hnac'].'</td><td width=\"12%\" align=\"right\">'.$ap.'</td><td width=\"17%\" align=\"right\">'.$mi.'</td><td width=\"17%\" align=\"right\">'.$ma.'</td><td width=\"12%\" align=\"right\">'.$pr.'</td><td width=\"6%\">'.$ac.'</td></tr></table>';
                } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
            }
        }
        echo '<script type="text/javascript">';
        echo '$("#xTaquillas").html("'.$resultado.'")';
        echo '</script>';
    }//else
    elseif ($_GET["ti"]==3&&isset($_GET["ca"])) {
        //$resultado="aqui estoy";
        if ($_GET["ta"]!="todas"&&$_GET["ca"]!="todas") {
            $resultado="No hay registros";
            $query_Recordset2 = sprintf(
                "/* PARSEADORES1 new\agente_hnac\agente_buscaTaquilla.php - QUERY 5 */ SELECT
				ta.nom_taquilla, 
				ins.cod_inscrito_hnac, ins.nom_caballo_hnac, ins.num_caballo_hnac,
				ca.num_carrera_hnac, ca.cod_carrera_hnac,
				pr.max_eje_hnac, pr.max_jug_hnac, pr.min_jug_hnac, pr.pre_fijo_hnac, pr.id_pfijo_hnac
				FROM
					taquilla ta, 
					carrera_hnac ca, 
					inscritos ins,
					precio_fijo_hnac pr
				WHERE
					ta.cod_taquilla = %s AND
					ca.fec_carrera_hnac = %s AND
					ca.cod_carrera_hnac = %s AND
					pr.cod_carrera_hnac = ca.cod_carrera_hnac AND
					ta.cod_taquilla = pr.cod_taquilla AND
					ins.cod_carrera_hnac = ca.cod_carrera_hnac AND
					ins.cod_inscrito_hnac = pr.cod_inscrito_hnac AND
					ins.est_inscrito_hnac = 1
				ORDER BY ca.cod_carrera_hnac ASC, ca.num_carrera_hnac, ta.nom_taquilla",
                GetSQLValueString($_GET["ta"], "int"),
                GetSQLValueString($fec, "date"),
                GetSQLValueString($_GET["ca"], "int")
            );
            $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
            $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
            $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
            if ($totalRows_Recordset2>0) {
                $codCarrera="";
                $resultado="";
                do {
                    if ($codCarrera!=$row_Recordset2['cod_carrera_hnac']) {
                        $codCarrera=$row_Recordset2['cod_carrera_hnac'];
                        $resultado.='Carrera #:'.$row_Recordset2['num_carrera_hnac'].'<table width=\"100%\" cellpadding=\"0\" border=\"0\" style=\"text-align:center;font-size:10px;border-bottom:1px solid  #D5D5D5\"><tr valign=\"bottom\" bgcolor=\"#E7E7E7\"><td width=\"1%\">*</td><td width=\"1%\">#</td><td width=\"35%\">EJEMPLAR</td><td width=\"12%\">APUESTA MAXIMA</td><td width=\"17%\">JUGADA MINIMA</td><td width=\"17%\">JUGADA MAXIMA</td><td width=\"12%\">PRECIO FIJO</td><td width=\"6%\">ACCION</td></tr></table>';
                    }
                    $tr="tr".$row_Recordset2['id_pfijo_hnac'];
                    $it=$row_Recordset2['id_pfijo_hnac'];
                    $nt="id_pfijo_hnac[]";
                    $ip='<input type=\"checkbox\" onClick=\"cfon('.$tr.','.$it.')\" name=\"'.$nt.'\" id=\"'.$it.'\" value=\"'.$row_Recordset2['id_pfijo_hnac'].'\"/>';
                    $ap=$row_Recordset2['max_eje_hnac'];
                    $mi=$row_Recordset2['min_jug_hnac'];
                    $ma=$row_Recordset2['max_jug_hnac'];
                    $pr=$row_Recordset2['pre_fijo_hnac'];
                    $ac='<a href=\"#\" onClick=\"eliminar('.$row_Recordset2['id_pfijo_hnac'].')\">QUITAR</a>';
                    $resultado.= '<table width=\"100%\" cellpadding=\"0\"  border=\"0\" style=\"text-align:center;font-size:10px;border-bottom:1px solid  #D5D5D5\"><tr valign=\"bottom\" id=\"'.$tr.'\"><td width=\"1%\">'.$ip.'</td><td width=\"1%\">'.$row_Recordset2['num_caballo_hnac'].'</td><td width=\"35%\" align=\"left\">'.$row_Recordset2['nom_caballo_hnac'].'</td><td width=\"12%\" align=\"right\">'.$ap.'</td><td width=\"17%\" align=\"right\">'.$mi.'</td><td width=\"17%\" align=\"right\">'.$ma.'</td><td width=\"12%\" align=\"right\">'.$pr.'</td><td width=\"6%\">'.$ac.'</td></tr></table>';
                } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
            }
            //$resultado="1 taquilla - 1 carrera";
        } elseif ($_GET["ta"]=="todas"&&$_GET["ca"]!="todas") {
            $resultado="todas las taquillas - 1 carrera";
            $resultado="No hay registros";
            $query_Recordset2 = sprintf(
                "/* PARSEADORES1 new\agente_hnac\agente_buscaTaquilla.php - QUERY 6 */ SELECT
				ta.nom_taquilla,
				ins.cod_inscrito_hnac,
				ins.nom_caballo_hnac,
				ins.num_caballo_hnac,
				ca.num_carrera_hnac,
				ca.cod_carrera_hnac,
				pr.max_eje_hnac,
				pr.max_jug_hnac,
				pr.min_jug_hnac,
				pr.pre_fijo_hnac,
				pr.id_pfijo_hnac
				FROM
					agencia ag,
					taquilla ta, 
					carrera_hnac ca, 
					inscritos ins,
					precio_fijo_hnac pr
					WHERE
						ag.cod_agencia = %s AND
						ca.cod_carrera_hnac = %s AND
						ca.fec_carrera_hnac = %s AND
						ta.cod_agencia = ag.cod_agencia AND
						pr.cod_carrera_hnac = ca.cod_carrera_hnac AND
						ta.cod_taquilla = pr.cod_taquilla AND
						ins.cod_carrera_hnac = ca.cod_carrera_hnac AND
						ins.cod_inscrito_hnac = pr.cod_inscrito_hnac AND
						ins.est_inscrito_hnac = 1
					ORDER BY ca.cod_carrera_hnac ASC, ca.num_carrera_hnac, ta.nom_taquilla",
                GetSQLValueString($_GET["ag"], "int"),
                GetSQLValueString($_GET["ca"], "int"),
                GetSQLValueString($fec, "date")
            );
            $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
            $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
            $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
            if ($totalRows_Recordset2>0) {
                $codCarrera="";
                $resultado="";
                do {
                    if ($codCarrera!=$row_Recordset2['cod_carrera_hnac']) {
                        $codCarrera=$row_Recordset2['cod_carrera_hnac'];
                        $resultado.='Carrera #:'.$row_Recordset2['num_carrera_hnac'].'<table width=\"100%\" cellpadding=\"0\" border=\"0\" style=\"text-align:center;font-size:10px;border-bottom:1px solid  #D5D5D5\"><tr valign=\"bottom\" bgcolor=\"#E7E7E7\"><td width=\"20%\">TAQUILLA</td><td width=\"1%\">#</td><td width=\"15%\">EJEMPLAR</td><td width=\"12%\">APUESTA MAXIMA</td><td width=\"17%\">JUGADA MINIMA</td><td width=\"17%\">JUGADA MAXIMA</td><td width=\"12%\">PRECIO FIJO</td><td width=\"6%\">ACCION</td></tr></table>';
                    }
                    $tr="tr".$row_Recordset2['id_pfijo_hnac'];
                    $it=$row_Recordset2['id_pfijo_hnac'];
                    $nt="id_pfijo_hnac[]";
                    $ip='<input type=\"checkbox\" onClick=\"cfon('.$tr.','.$it.')\" name=\"'.$nt.'\" id=\"'.$it.'\" value=\"'.$row_Recordset2['id_pfijo_hnac'].'\"/>';
                    $ap=$row_Recordset2['max_eje_hnac'];
                    $mi=$row_Recordset2['min_jug_hnac'];
                    $ma=$row_Recordset2['max_jug_hnac'];
                    $pr=$row_Recordset2['pre_fijo_hnac'];
                    $ac='<a href=\"#\" onClick=\"eliminar('.$row_Recordset2['id_pfijo_hnac'].')\">QUITAR</a>';
                    $resultado.= '<table width=\"100%\" cellpadding=\"0\"  border=\"0\" style=\"text-align:center;font-size:10px;border-bottom:1px solid  #D5D5D5\"><tr valign=\"bottom\" id=\"'.$tr.'\"><td width=\"20%\" align=\"left\">'.$ip.$row_Recordset2['nom_taquilla'].'</td><td width=\"1%\">'.$row_Recordset2['num_caballo_hnac'].'</td><td width=\"15%\" align=\"left\">'.$row_Recordset2['nom_caballo_hnac'].'</td><td width=\"12%\" align=\"right\">'.$ap.'</td><td width=\"17%\" align=\"right\">'.$mi.'</td><td width=\"17%\" align=\"right\">'.$ma.'</td><td width=\"12%\" align=\"right\">'.$pr.'</td><td width=\"6%\">'.$ac.'</td></tr></table>';
                } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
            }
        } elseif ($_GET["ta"]=="todas"&&$_GET["ca"]=="todas") {
            $resultado="todas las taquillas - todas las carreras";
            $resultado="No hay registros";
            $query_Recordset2 = sprintf(
                "/* PARSEADORES1 new\agente_hnac\agente_buscaTaquilla.php - QUERY 7 */ SELECT
				ta.nom_taquilla,
				ins.cod_inscrito_hnac,
				ins.nom_caballo_hnac,
				ins.num_caballo_hnac,
				ca.num_carrera_hnac,
				ca.cod_carrera_hnac,
				pr.max_eje_hnac,
				pr.max_jug_hnac,
				pr.min_jug_hnac,
				pr.pre_fijo_hnac,
				pr.id_pfijo_hnac
				FROM
					agencia ag,
					taquilla ta, 
					carrera_hnac ca, 
					inscritos ins,
					precio_fijo_hnac pr
					WHERE
						ag.cod_agencia = %s AND
						ca.fec_carrera_hnac = %s AND
						ta.cod_agencia = ag.cod_agencia AND
						pr.cod_carrera_hnac = ca.cod_carrera_hnac AND
						ta.cod_taquilla = pr.cod_taquilla AND
						ins.cod_carrera_hnac = ca.cod_carrera_hnac AND
						ins.cod_inscrito_hnac = pr.cod_inscrito_hnac AND
						ins.est_inscrito_hnac = 1
					ORDER BY ca.cod_carrera_hnac ASC, ca.num_carrera_hnac, ta.nom_taquilla",
                GetSQLValueString($_GET["ag"], "int"),
                GetSQLValueString($fec, "date")
            );
            $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
            $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
            $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
            if ($totalRows_Recordset2>0) {
                $codCarrera="";
                $resultado="";
                do {
                    if ($codCarrera!=$row_Recordset2['cod_carrera_hnac']) {
                        $codCarrera=$row_Recordset2['cod_carrera_hnac'];
                        $resultado.='Carrera #:'.$row_Recordset2['num_carrera_hnac'].'<table width=\"100%\" cellpadding=\"0\" border=\"0\" style=\"text-align:center;font-size:10px;border-bottom:1px solid  #D5D5D5\"><tr valign=\"bottom\" bgcolor=\"#E7E7E7\"><td width=\"20%\">TAQUILLA</td><td width=\"1%\">#</td><td width=\"15%\">EJEMPLAR</td><td width=\"12%\">APUESTA MAXIMA</td><td width=\"17%\">JUGADA MINIMA</td><td width=\"17%\">JUGADA MAXIMA</td><td width=\"12%\">PRECIO FIJO</td><td width=\"6%\">ACCION</td></tr></table>';
                    }
                    $tr="tr".$row_Recordset2['id_pfijo_hnac'];
                    $it=$row_Recordset2['id_pfijo_hnac'];
                    $nt="id_pfijo_hnac[]";
                    $ip='<input type=\"checkbox\" onClick=\"cfon('.$tr.','.$it.')\" name=\"'.$nt.'\" id=\"'.$it.'\" value=\"'.$row_Recordset2['id_pfijo_hnac'].'\"/>';
                    $ap=$row_Recordset2['max_eje_hnac'];
                    $mi=$row_Recordset2['min_jug_hnac'];
                    $ma=$row_Recordset2['max_jug_hnac'];
                    $pr=$row_Recordset2['pre_fijo_hnac'];
                    $ac='<a href=\"#\" onClick=\"eliminar('.$row_Recordset2['id_pfijo_hnac'].')\">QUITAR</a>';
                    $resultado.= '<table width=\"100%\" cellpadding=\"0\"  border=\"0\" style=\"text-align:center;font-size:10px;border-bottom:1px solid  #D5D5D5\"><tr valign=\"bottom\" ><td width=\"20%\" align=\"left\">'.$ip.$row_Recordset2['nom_taquilla'].'</td><td width=\"1%\">'.$row_Recordset2['num_caballo_hnac'].'</td><td width=\"15%\" align=\"left\">'.$row_Recordset2['nom_caballo_hnac'].'</td><td width=\"12%\" align=\"right\">'.$ap.'</td><td width=\"17%\" align=\"right\">'.$mi.'</td><td width=\"17%\" align=\"right\">'.$ma.'</td><td width=\"12%\" align=\"right\">'.$pr.'</td><td width=\"6%\">'.$ac.'</td></tr></table>';
                } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
            }
        } elseif ($_GET["ta"]!="todas"&&$_GET["ca"]=="todas") {
            $resultado="1 taquilla - todas las carreras";
            $resultado="No hay registros";
            $query_Recordset2 = sprintf(
                "/* PARSEADORES1 new\agente_hnac\agente_buscaTaquilla.php - QUERY 8 */ SELECT
				ta.nom_taquilla, 
				ins.cod_inscrito_hnac, ins.nom_caballo_hnac, ins.num_caballo_hnac,
				ca.num_carrera_hnac, ca.cod_carrera_hnac,
				pr.max_eje_hnac, pr.max_jug_hnac, pr.min_jug_hnac, pr.pre_fijo_hnac, pr.id_pfijo_hnac
				FROM
					taquilla ta, 
					carrera_hnac ca, 
					inscritos ins,
					precio_fijo_hnac pr
				WHERE
					ta.cod_taquilla = %s AND
					ca.fec_carrera_hnac = %s AND
					pr.cod_carrera_hnac = ca.cod_carrera_hnac AND
					ta.cod_taquilla = pr.cod_taquilla AND
					ins.cod_carrera_hnac = ca.cod_carrera_hnac AND
					ins.cod_inscrito_hnac = pr.cod_inscrito_hnac AND
					ins.est_inscrito_hnac = 1
				ORDER BY ca.cod_carrera_hnac ASC, ca.num_carrera_hnac, ta.nom_taquilla",
                GetSQLValueString($_GET["ta"], "int"),
                GetSQLValueString($fec, "date")
            );
            $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
            $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
            $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
            if ($totalRows_Recordset2>0) {
                $codCarrera="";
                $resultado="";
                do {
                    if ($codCarrera!=$row_Recordset2['cod_carrera_hnac']) {
                        $codCarrera=$row_Recordset2['cod_carrera_hnac'];
                        $resultado.='Carrera #:'.$row_Recordset2['num_carrera_hnac'].'<table width=\"100%\" cellpadding=\"0\" border=\"0\" style=\"text-align:center;font-size:10px;border-bottom:1px solid  #D5D5D5\"><tr valign=\"bottom\" bgcolor=\"#E7E7E7\"><td width=\"1%\">+</td><td width=\"1%\">#</td><td width=\"35%\">EJEMPLAR</td><td width=\"12%\">APUESTA MAXIMA</td><td width=\"17%\">JUGADA MINIMA</td><td width=\"17%\">JUGADA MAXIMA</td><td width=\"12%\">PRECIO FIJO</td><td width=\"6%\">ACCION</td></tr></table>';
                    }
                    $tr="tr".$row_Recordset2['id_pfijo_hnac'];
                    $it=$row_Recordset2['id_pfijo_hnac'];
                    $nt="id_pfijo_hnac[]";
                    $ip='<input type=\"checkbox\" onClick=\"cfon('.$tr.','.$it.')\" name=\"'.$nt.'\" id=\"'.$it.'\" value=\"'.$row_Recordset2['id_pfijo_hnac'].'\"/>';
                    $ap=$row_Recordset2['max_eje_hnac'];
                    $mi=$row_Recordset2['min_jug_hnac'];
                    $ma=$row_Recordset2['max_jug_hnac'];
                    $pr=$row_Recordset2['pre_fijo_hnac'];
                    $ac='<a href=\"#\" onClick=\"eliminar('.$row_Recordset2['id_pfijo_hnac'].')\">QUITAR</a>';
                    $resultado.= '<table width=\"100%\" cellpadding=\"0\"  border=\"0\" style=\"text-align:center;font-size:10px;border-bottom:1px solid  #D5D5D5\"><tr valign=\"bottom\" ><td width=\"1%\">'.$ip.'</td><td width=\"1%\">'.$row_Recordset2['num_caballo_hnac'].'</td><td width=\"35%\" align=\"left\">'.$row_Recordset2['nom_caballo_hnac'].'</td><td width=\"12%\" align=\"right\">'.$ap.'</td><td width=\"17%\" align=\"right\">'.$mi.'</td><td width=\"17%\" align=\"right\">'.$ma.'</td><td width=\"12%\" align=\"right\">'.$pr.'</td><td width=\"6%\">'.$ac.'</td></tr></table>';
                } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
            }
        }
        echo '<script type="text/javascript">';
        echo '$("#xTaquillas").html("'.$resultado.'")';
        echo '</script>';
    }
}
if (isset($Recordset2)) {
    mysqli_free_result($Recordset2);
}
if (isset($Recordset1)) {
    mysqli_free_result($Recordset1);
}
