<?php
require_once('../Connections/conexionbanca.php');
date_default_timezone_set("America/Puerto_Rico");
$nUsu="Soporte";
$query_Recordset101 = sprintf(
    "/* PARSEADORES1 new\chat\pjson.php - QUERY 1 */ SELECT us.tip_usuario, us.id_usuario,
	CASE us.tip_usuario  
		WHEN 'U' THEN (/* PARSEADORES1 new\chat\pjson.php - QUERY 2 */ SELECT nom_taquilla FROM taquilla ta WHERE ta.cod_taquilla=us.cod_taquilla LIMIT 1)  
		WHEN 'G' THEN (/* PARSEADORES1 new\chat\pjson.php - QUERY 3 */ SELECT nom_agencia FROM agencia ag WHERE ag.cod_agencia=us.cod_taquilla LIMIT 1)
		WHEN 'D' THEN (/* PARSEADORES1 new\chat\pjson.php - QUERY 4 */ SELECT nom_banca FROM banca ba WHERE ba.cod_banca=us.cod_taquilla LIMIT 1)
		ELSE 'NO DEFINIDO'
	END AS nombre_chat, 
	(/* PARSEADORES1 new\chat\pjson.php - QUERY 5 */ SELECT COUNT(*) FROM chat ch 
		WHERE ch.to1=%s AND nombre_chat = ch.from1 AND recd=1
		ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC) AS no_leido,
	(/* PARSEADORES1 new\chat\pjson.php - QUERY 6 */ SELECT message FROM chat ch  
		WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
		ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS message,
	(/* PARSEADORES1 new\chat\pjson.php - QUERY 7 */ SELECT sentdate FROM chat ch 
		WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
		ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS sentdate,
	(/* PARSEADORES1 new\chat\pjson.php - QUERY 8 */ SELECT senttime FROM chat ch 
		WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
		ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS senttime,
	(/* PARSEADORES1 new\chat\pjson.php - QUERY 9 */ SELECT connected FROM chat ch 
		WHERE nombre_chat = ch.from1
		ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS connected
FROM 
	usuario us
WHERE us.tip_usuario='U' OR us.tip_usuario='G' OR us.tip_usuario='D'
GROUP BY nombre_chat
ORDER BY sentdate DESC, senttime DESC, connected DESC, nombre_chat ASC",
    GetSQLValueString($nUsu, "text"),
    GetSQLValueString($nUsu, "text"),
    GetSQLValueString($nUsu, "text"),
    GetSQLValueString($nUsu, "text"),
    GetSQLValueString($nUsu, "text"),
    GetSQLValueString($nUsu, "text"),
    GetSQLValueString($nUsu, "text")
);
$Recordset101 = mysqli_query($conexionbanca, $query_Recordset101) or die(mysqli_error($conexionbanca));
$row_Recordset101 = mysqli_fetch_assoc($Recordset101);
$totalRows_Recordset101 = mysqli_num_rows($Recordset101);
$usuarios=array();
$x=0;
do {
    if ($row_Recordset101['nombre_chat']!="") {
        $usuarios['usuarios'][$x]['nombre_chat']="Soporte";
        $usuarios['usuarios'][$x]['contactos'][$x]['id']=$row_Recordset101['id_usuario'];
        $usuarios['usuarios'][$x]['contactos'][$x]['enlace']=$row_Recordset101['nombre_chat'];
        if (strtotime(date('Y-m-d H:i:s'))>strtotime($row_Recordset101['connected']) or $row_Recordset101['connected']=="") {
            $row_Recordset101['connected']=0;
        } else {
            $row_Recordset101['connected']=1;
        }
        $usuarios['usuarios'][$x]['contactos'][$x]['connected']=$row_Recordset101['connected'];
        $usuarios['usuarios'][$x]['contactos'][$x]['tipo']=$row_Recordset101['tip_usuario'];
        $ultMens="";
        if ($row_Recordset101['message']!="") {
            if (strlen($row_Recordset101['message'])>20) {
                $ultMens=substr($row_Recordset101['message'], 0, 20)."...";
            } else {
                $ultMens=$row_Recordset101['message'];
            }
        }
        $usuarios['usuarios'][$x]['contactos'][$x]['message']=$ultMens;
        $usuarios['usuarios'][$x]['contactos'][$x]['noleido']=$row_Recordset101['no_leido']*1;
        if ($row_Recordset101['sentdate']=="") {
            $row_Recordset101['sentdate']="";
        } else {
            $row_Recordset101['sentdate']=date("d-m-Y", strtotime($row_Recordset101['sentdate']));
        }
        $usuarios['usuarios'][$x]['contactos'][$x]['sdate']=$row_Recordset101['sentdate'];
        if ($row_Recordset101['senttime']=="") {
            $row_Recordset101['senttime']="";
        } else {
            $row_Recordset101['senttime']=date("h:i:s a", strtotime($row_Recordset101['senttime']));
        }
        $usuarios['usuarios'][$x]['contactos'][$x]['stime']=$row_Recordset101['senttime'];
        $x++;
    }
} while ($row_Recordset101 = mysqli_fetch_assoc($Recordset101));
$query_Recordset102 = sprintf("/* PARSEADORES1 new\chat\pjson.php - QUERY 10 */ SELECT cod_banca, nom_banca FROM banca ORDER BY nom_banca ASC");
$Recordset102 = mysqli_query($conexionbanca, $query_Recordset102) or die(mysqli_error($conexionbanca));
$row_Recordset102 = mysqli_fetch_assoc($Recordset102);
$totalRows_Recordset102 = mysqli_num_rows($Recordset102);
do {
    $cod_banca=$row_Recordset102['cod_banca'];
    $nUsu=$row_Recordset102['nom_banca'];
    $query_Recordset101 = sprintf(
        "/* PARSEADORES1 new\chat\pjson.php - QUERY 11 */ SELECT us.tip_usuario, us.id_usuario, 
		CASE us.tip_usuario  
			WHEN 'U' THEN (/* PARSEADORES1 new\chat\pjson.php - QUERY 12 */ SELECT nom_taquilla FROM taquilla ta, agencia ag WHERE ta.cod_taquilla=us.cod_taquilla AND
				ag.cod_agencia=ta.cod_agencia AND ag.cod_banca =%s LIMIT 1)  
			WHEN 'G' THEN (/* PARSEADORES1 new\chat\pjson.php - QUERY 13 */ SELECT nom_agencia FROM agencia ag WHERE ag.cod_agencia=us.cod_taquilla AND
				ag.cod_banca =%s LIMIT 1)
			WHEN 'A' THEN 'Soporte'
			ELSE 'NO DEFINIDO'
		END AS nombre_chat, 
		CASE us.tip_usuario  
			WHEN 'U' THEN '2'
			WHEN 'G' THEN '1'
			WHEN 'A' THEN '0'
			ELSE 'NO DEFINIDO'
		END AS orden,
		(/* PARSEADORES1 new\chat\pjson.php - QUERY 14 */ SELECT COUNT(*) FROM chat ch 
			WHERE ch.to1=%s AND nombre_chat = ch.from1 AND recd=1
			ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC) AS no_leido,
		(/* PARSEADORES1 new\chat\pjson.php - QUERY 15 */ SELECT message FROM chat ch  
			WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
			ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS message,
		(/* PARSEADORES1 new\chat\pjson.php - QUERY 16 */ SELECT sentdate FROM chat ch 
			WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
			ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS sentdate,
		(/* PARSEADORES1 new\chat\pjson.php - QUERY 17 */ SELECT senttime FROM chat ch 
			WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
			ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS senttime,
		(/* PARSEADORES1 new\chat\pjson.php - QUERY 18 */ SELECT connected FROM chat ch 
			WHERE nombre_chat = ch.from1
			ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS connected
	FROM 
		usuario us
	WHERE us.tip_usuario='U' OR us.tip_usuario='G' OR us.tip_usuario='A'
	GROUP BY nombre_chat
	ORDER BY sentdate DESC, senttime DESC, orden ASC, connected DESC, nombre_chat ASC",
        GetSQLValueString($cod_banca, "int"),
        GetSQLValueString($cod_banca, "int"),
        GetSQLValueString($nUsu, "text"),
        GetSQLValueString($nUsu, "text"),
        GetSQLValueString($nUsu, "text"),
        GetSQLValueString($nUsu, "text"),
        GetSQLValueString($nUsu, "text"),
        GetSQLValueString($nUsu, "text"),
        GetSQLValueString($nUsu, "text")
    );
    $Recordset101 = mysqli_query($conexionbanca, $query_Recordset101) or die(mysqli_error($conexionbanca));
    $row_Recordset101 = mysqli_fetch_assoc($Recordset101);
    $totalRows_Recordset101 = mysqli_num_rows($Recordset101);
    do {
        if ($row_Recordset101['nombre_chat']!="") {
            $usuarios['usuarios'][$x]['nombre_chat']=$nUsu;
            $usuarios['usuarios'][$x]['contactos'][$x]['id']=$row_Recordset101['id_usuario'];
            $usuarios['usuarios'][$x]['contactos'][$x]['enlace']=$row_Recordset101['nombre_chat'];
            if (strtotime(date('Y-m-d H:i:s'))>strtotime($row_Recordset101['connected']) or $row_Recordset101['connected']=="") {
                $row_Recordset101['connected']=0;
            } else {
                $row_Recordset101['connected']=1;
            }
            $usuarios['usuarios'][$x]['contactos'][$x]['connected']=$row_Recordset101['connected'];
            $usuarios['usuarios'][$x]['contactos'][$x]['tipo']=$row_Recordset101['tip_usuario'];
            $ultMens="";
            if ($row_Recordset101['message']!="") {
                if (strlen($row_Recordset101['message'])>20) {
                    $ultMens=substr($row_Recordset101['message'], 0, 20)."...";
                } else {
                    $ultMens=$row_Recordset101['message'];
                }
            }
            $usuarios['usuarios'][$x]['contactos'][$x]['message']=$ultMens;
            $usuarios['usuarios'][$x]['contactos'][$x]['noleido']=$row_Recordset101['no_leido']*1;
            if ($row_Recordset101['sentdate']=="") {
                $row_Recordset101['sentdate']="";
            } else {
                $row_Recordset101['sentdate']=date("d-m-Y", strtotime($row_Recordset101['sentdate']));
            }
            $usuarios['usuarios'][$x]['contactos'][$x]['sdate']=$row_Recordset101['sentdate'];
            if ($row_Recordset101['senttime']=="") {
                $row_Recordset101['senttime']="";
            } else {
                $row_Recordset101['senttime']=date("h:i:s a", strtotime($row_Recordset101['senttime']));
            }
            $usuarios['usuarios'][$x]['contactos'][$x]['stime']=$row_Recordset101['senttime'];
            $x++;
        }
    } while ($row_Recordset101 = mysqli_fetch_assoc($Recordset101));
} while ($row_Recordset102 = mysqli_fetch_assoc($Recordset102));
$query_Recordset102 = sprintf("/* PARSEADORES1 new\chat\pjson.php - QUERY 19 */ SELECT cod_agencia, nom_agencia, cod_banca FROM agencia ORDER BY nom_agencia ASC");
$Recordset102 = mysqli_query($conexionbanca, $query_Recordset102) or die(mysqli_error($conexionbanca));
$row_Recordset102 = mysqli_fetch_assoc($Recordset102);
$totalRows_Recordset102 = mysqli_num_rows($Recordset102);
do {
    $cod_banca=$row_Recordset102['cod_banca'];
    $cod_agencia=$row_Recordset102['cod_agencia'];
    $nUsu=$row_Recordset102['nom_agencia'];
    $query_Recordset101 = sprintf(
        "/* PARSEADORES1 new\chat\pjson.php - QUERY 20 */ SELECT us.tip_usuario, us.id_usuario,
			CASE us.tip_usuario  
				WHEN 'U' THEN (/* PARSEADORES1 new\chat\pjson.php - QUERY 21 */ SELECT nom_taquilla FROM taquilla ta WHERE ta.cod_taquilla=us.cod_taquilla 
					AND ta.cod_agencia=%s LIMIT 1)  
				WHEN 'D' THEN (/* PARSEADORES1 new\chat\pjson.php - QUERY 22 */ SELECT nom_banca FROM banca ba WHERE ba.cod_banca=%s LIMIT 1)
				WHEN 'A' THEN 'Soporte'
				ELSE 'NO DEFINIDO'
			END AS nombre_chat, 
			CASE us.tip_usuario  
				WHEN 'U' THEN '2'
				WHEN 'D' THEN '1'
				WHEN 'A' THEN '0'
				ELSE 'NO DEFINIDO'
			END AS orden,
			(/* PARSEADORES1 new\chat\pjson.php - QUERY 23 */ SELECT COUNT(*) FROM chat ch 
				WHERE ch.to1=%s AND nombre_chat = ch.from1 AND recd=1
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC) AS no_leido,
			(/* PARSEADORES1 new\chat\pjson.php - QUERY 24 */ SELECT message FROM chat ch  
				WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS message,
			(/* PARSEADORES1 new\chat\pjson.php - QUERY 25 */ SELECT sentdate FROM chat ch 
				WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS sentdate,
			(/* PARSEADORES1 new\chat\pjson.php - QUERY 26 */ SELECT senttime FROM chat ch 
				WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS senttime,
			(/* PARSEADORES1 new\chat\pjson.php - QUERY 27 */ SELECT connected FROM chat ch 
				WHERE nombre_chat = ch.from1
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS connected
		FROM 
			usuario us
		WHERE us.tip_usuario='U' OR us.tip_usuario='D' OR us.tip_usuario='A'
		GROUP BY nombre_chat
		ORDER BY sentdate DESC, senttime DESC, orden ASC, connected DESC, nombre_chat ASC",
        GetSQLValueString($cod_agencia, "int"),
        GetSQLValueString($cod_banca, "int"),
        GetSQLValueString($nUsu, "text"),
        GetSQLValueString($nUsu, "text"),
        GetSQLValueString($nUsu, "text"),
        GetSQLValueString($nUsu, "text"),
        GetSQLValueString($nUsu, "text"),
        GetSQLValueString($nUsu, "text"),
        GetSQLValueString($nUsu, "text")
    );
    $Recordset101 = mysqli_query($conexionbanca, $query_Recordset101) or die(mysqli_error($conexionbanca));
    $row_Recordset101 = mysqli_fetch_assoc($Recordset101);
    $totalRows_Recordset101 = mysqli_num_rows($Recordset101);
    do {
        if ($row_Recordset101['nombre_chat']!="") {
            $usuarios['usuarios'][$x]['nombre_chat']=$nUsu;
            $usuarios['usuarios'][$x]['contactos'][$x]['id']=$row_Recordset101['id_usuario'];
            $usuarios['usuarios'][$x]['contactos'][$x]['enlace']=$row_Recordset101['nombre_chat'];
            if (strtotime(date('Y-m-d H:i:s'))>strtotime($row_Recordset101['connected']) or $row_Recordset101['connected']=="") {
                $row_Recordset101['connected']=0;
            } else {
                $row_Recordset101['connected']=1;
            }
            $usuarios['usuarios'][$x]['contactos'][$x]['connected']=$row_Recordset101['connected'];
            $usuarios['usuarios'][$x]['contactos'][$x]['tipo']=$row_Recordset101['tip_usuario'];
            $ultMens="";
            if ($row_Recordset101['message']!="") {
                if (strlen($row_Recordset101['message'])>20) {
                    $ultMens=substr($row_Recordset101['message'], 0, 20)."...";
                } else {
                    $ultMens=$row_Recordset101['message'];
                }
            }
            $usuarios['usuarios'][$x]['contactos'][$x]['message']=$ultMens;
            $usuarios['usuarios'][$x]['contactos'][$x]['noleido']=$row_Recordset101['no_leido']*1;
            if ($row_Recordset101['sentdate']=="") {
                $row_Recordset101['sentdate']="";
            } else {
                $row_Recordset101['sentdate']=date("d-m-Y", strtotime($row_Recordset101['sentdate']));
            }
            $usuarios['usuarios'][$x]['contactos'][$x]['sdate']=$row_Recordset101['sentdate'];
            if ($row_Recordset101['senttime']=="") {
                $row_Recordset101['senttime']="";
            } else {
                $row_Recordset101['senttime']=date("h:i:s a", strtotime($row_Recordset101['senttime']));
            }
            $usuarios['usuarios'][$x]['contactos'][$x]['stime']=$row_Recordset101['senttime'];
            $x++;
        }
    } while ($row_Recordset101 = mysqli_fetch_assoc($Recordset101));
} while ($row_Recordset102 = mysqli_fetch_assoc($Recordset102));
$query_Recordset102 = sprintf("/* PARSEADORES1 new\chat\pjson.php - QUERY 28 */ SELECT ta.cod_agencia, us.nom_usuario FROM usuario us, taquilla ta 
WHERE us.cod_taquilla = ta.cod_taquilla ORDER BY nom_usuario ASC");
$Recordset102 = mysqli_query($conexionbanca, $query_Recordset102) or die(mysqli_error($conexionbanca));
$row_Recordset102 = mysqli_fetch_assoc($Recordset102);
$totalRows_Recordset102 = mysqli_num_rows($Recordset102);
do {
    $cod_agencia=$row_Recordset102['cod_agencia'];
    $nUsu=$row_Recordset102['nom_usuario'];
    $query_Recordset101 = sprintf(
        "/* PARSEADORES1 new\chat\pjson.php - QUERY 29 */ SELECT us.tip_usuario, us.id_usuario,
			CASE us.tip_usuario  
				WHEN 'G' THEN (/* PARSEADORES1 new\chat\pjson.php - QUERY 30 */ SELECT nom_agencia FROM agencia ag WHERE ag.cod_agencia=%s LIMIT 1)
				WHEN 'A' THEN 'Soporte'
				ELSE 'NO DEFINIDO'
			END AS nombre_chat,
			CASE us.tip_usuario  
				WHEN 'G' THEN '2'
				WHEN 'D' THEN '1'
				WHEN 'A' THEN '0'
				ELSE 'NO DEFINIDO'
			END AS orden,
			(/* PARSEADORES1 new\chat\pjson.php - QUERY 31 */ SELECT COUNT(*) FROM chat ch 
				WHERE ch.to1=%s AND nombre_chat = ch.from1 AND recd=1
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC) AS no_leido,
			(/* PARSEADORES1 new\chat\pjson.php - QUERY 32 */ SELECT message FROM chat ch  
				WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS message,
			(/* PARSEADORES1 new\chat\pjson.php - QUERY 33 */ SELECT sentdate FROM chat ch 
				WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS sentdate,
			(/* PARSEADORES1 new\chat\pjson.php - QUERY 34 */ SELECT senttime FROM chat ch 
				WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS senttime,
			(/* PARSEADORES1 new\chat\pjson.php - QUERY 35 */ SELECT connected FROM chat ch 
				WHERE nombre_chat = ch.from1
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS connected
		FROM 
			usuario us
		WHERE us.tip_usuario='G' OR us.tip_usuario='A'
		GROUP BY nombre_chat
		ORDER BY sentdate DESC, senttime DESC, connected DESC, orden ASC, nombre_chat ASC",
        GetSQLValueString($cod_agencia, "int"),
        GetSQLValueString($nUsu, "text"),
        GetSQLValueString($nUsu, "text"),
        GetSQLValueString($nUsu, "text"),
        GetSQLValueString($nUsu, "text"),
        GetSQLValueString($nUsu, "text"),
        GetSQLValueString($nUsu, "text"),
        GetSQLValueString($nUsu, "text")
    );
    $Recordset101 = mysqli_query($conexionbanca, $query_Recordset101) or die(mysqli_error($conexionbanca));
    $row_Recordset101 = mysqli_fetch_assoc($Recordset101);
    $totalRows_Recordset101 = mysqli_num_rows($Recordset101);
    do {
        if ($row_Recordset101['nombre_chat']!="") {
            $usuarios['usuarios'][$x]['nombre_chat']=$nUsu;
            $usuarios['usuarios'][$x]['contactos'][$x]['id']=$row_Recordset101['id_usuario'];
            $usuarios['usuarios'][$x]['contactos'][$x]['enlace']=$row_Recordset101['nombre_chat'];
            if (strtotime(date('Y-m-d H:i:s'))>strtotime($row_Recordset101['connected']) or $row_Recordset101['connected']=="") {
                $row_Recordset101['connected']=0;
            } else {
                $row_Recordset101['connected']=1;
            }
            $usuarios['usuarios'][$x]['contactos'][$x]['connected']=$row_Recordset101['connected'];
            $usuarios['usuarios'][$x]['contactos'][$x]['tipo']=$row_Recordset101['tip_usuario'];
            $ultMens="";
            if ($row_Recordset101['message']!="") {
                if (strlen($row_Recordset101['message'])>20) {
                    $ultMens=substr($row_Recordset101['message'], 0, 20)."...";
                } else {
                    $ultMens=$row_Recordset101['message'];
                }
            }
            $usuarios['usuarios'][$x]['contactos'][$x]['message']=$ultMens;
            $usuarios['usuarios'][$x]['contactos'][$x]['noleido']=$row_Recordset101['no_leido']*1;
            if ($row_Recordset101['sentdate']=="") {
                $row_Recordset101['sentdate']="";
            } else {
                $row_Recordset101['sentdate']=date("d-m-Y", strtotime($row_Recordset101['sentdate']));
            }
            $usuarios['usuarios'][$x]['contactos'][$x]['sdate']=$row_Recordset101['sentdate'];
            if ($row_Recordset101['senttime']=="") {
                $row_Recordset101['senttime']="";
            } else {
                $row_Recordset101['senttime']=date("h:i:s a", strtotime($row_Recordset101['senttime']));
            }
            $usuarios['usuarios'][$x]['contactos'][$x]['stime']=$row_Recordset101['senttime'];
            $x++;
        }
    } while ($row_Recordset101 = mysqli_fetch_assoc($Recordset101));
} while ($row_Recordset102 = mysqli_fetch_assoc($Recordset102));
$usuarios=array_unique($usuarios);
$jsonUsuarios=json_encode($usuarios);
var_dump($jsonUsuarios);
$handler = fopen("chat.json", "w+");
fwrite($handler, $jsonUsuarios);
fclose($handler);
