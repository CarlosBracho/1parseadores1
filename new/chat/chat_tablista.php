<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
date_default_timezone_set("America/Puerto_Rico");
//echo $_SESSION['MM_UserGroup']." * ".$_SESSION['MM_id_usuario']." * ".$_SESSION['MM_UserChat']." * ".$_SESSION['MM_cod_banca'];
if (isset($_SESSION['MM_id_usuario']) && $_SESSION['MM_id_usuario']!="" && isset($_SESSION['MM_UserChat']) && $_SESSION['MM_UserChat']!="") {
    function rand_color()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
    function color_var($i)
    {
        switch ($i) {
            case  0:$color="#FF851B";break; case  1:$color="#0074D9";break; case  2:$color="#FF4136";break;
            case  3:$color="#7FDBFF";break; case  4:$color="#39CCCC";break; case  5:$color="#F012BE";break;
            case  6:$color="#3D9970";break; case  7:$color="#B10DC9";break;	case  8:$color="#2ECC40";break;
            case  9:$color="#111111";break; case 10:$color="#01FF70";break; case 11:$color="#AAAAAA";break;
            case 12:$color="#FFDC00";break; case 13:$color="#DC143C";break; case 14:$color="#001f3f";break;
            case 15:$color="#85144b";break; case 16:$color="#eb315d";break; case 17:$color="#ebd231";break;
            case 18:$color="#bdc239";break; case 19:$color="#0fc77b";break; case 20:$color="#50795d";break;
        }
        return $color;
    }
    $nUsu=$_SESSION['MM_UserChat'];
    $query_Recordset102 = sprintf(
        "/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 1 */ SELECT ch.id, ch.connected	
		FROM chat ch 
		WHERE ch.from1=%s
		ORDER BY ch.id DESC
		LIMIT 1",
        GetSQLValueString($nUsu, "text")
    );
    $Recordset102 = mysqli_query($conexionbanca, $query_Recordset102) or die(mysqli_error($conexionbanca));
    $row_Recordset102 = mysqli_fetch_assoc($Recordset102);
    $totalRows_Recordset102 = mysqli_num_rows($Recordset102);
    $fechaActual = date('Y-m-d H:i:s');
    $nuevaFecha = strtotime('20 seconds', strtotime($fechaActual));
    $total = date(' Y-m-d H:i:s ', $nuevaFecha);
    if ($totalRows_Recordset102>0) {
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 2 */ UPDATE chat 
			SET connected=%s
			WHERE id=%s",
            GetSQLValueString($total, "date"),
            GetSQLValueString($row_Recordset102['id'], "int")
        );
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
    } else {
        $insertSQL = sprintf(
            "/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 3 */ INSERT INTO chat (from1, to1, message, sentdate, senttime, recd) 
				VALUES (%s, %s, %s, %s, %s, %s)",
            GetSQLValueString(trim($nUsu), "text"),
            GetSQLValueString('Soporte', "text"),
            GetSQLValueString(trim("inicio"), "text"),
            GetSQLValueString(fechaactualbd(), "date"),
            GetSQLValueString(horaactual(), "date"),
            GetSQLValueString(2, "int")
        );
        $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    }
    if ($_SESSION['MM_UserGroup'] == "A") {
        $query_Recordset101 = sprintf(
            "/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 4 */ SELECT us.nom_usuario, us.tip_usuario, us.id_usuario,
			CASE us.tip_usuario  
				WHEN 'U' THEN (/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 5 */ SELECT nom_taquilla FROM taquilla ta WHERE ta.cod_taquilla=us.cod_taquilla LIMIT 1)  
				WHEN 'G' THEN (/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 6 */ SELECT nom_agencia FROM agencia ag WHERE ag.cod_agencia=us.cod_taquilla LIMIT 1)
				WHEN 'D' THEN (/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 7 */ SELECT nom_banca FROM banca ba WHERE ba.cod_banca=us.cod_taquilla LIMIT 1)
				ELSE 'NO DEFINIDO'
			END AS nombre_chat, 
			CASE us.tip_usuario  
				WHEN 'U' THEN 'Taquilla'
				WHEN 'G' THEN 'Agente'
				WHEN 'D' THEN 'Distribuidor'
				ELSE 'NO DEFINIDO'
			END AS tipo_chat,
			CASE us.tip_usuario  
				WHEN 'U' THEN 'Agente: '
				WHEN 'G' THEN 'Distribuidor: '
				WHEN 'D' THEN ''
				ELSE 'NO DEFINIDO'
			END AS tipo_chat2,
			CASE us.tip_usuario  
				WHEN 'U' THEN (/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 8 */ SELECT nom_agencia FROM taquilla taq, agencia age WHERE taq.cod_taquilla=us.cod_taquilla AND 
					age.cod_agencia = taq.cod_agencia LIMIT 1)  
				WHEN 'G' THEN (/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 9 */ SELECT nom_banca FROM banca ban WHERE ban.cod_banca=us.cod_taquilla LIMIT 1)
				WHEN 'D' THEN ''
				ELSE 'NO DEFINIDO'
			END AS nombre_sup, 
			(/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 10 */ SELECT COUNT(*) FROM chat ch 
				WHERE ch.to1=%s AND nombre_chat = ch.from1 AND recd=1
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC) AS no_leido,
			(/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 11 */ SELECT message FROM chat ch  
				WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS message,
			(/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 12 */ SELECT sentdate FROM chat ch 
				WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS sentdate,
			(/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 13 */ SELECT senttime FROM chat ch 
				WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS senttime,
			(/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 14 */ SELECT connected FROM chat ch 
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
    } elseif ($_SESSION['MM_UserGroup'] == "U") {
        $query_Recordset101 = sprintf(
            "/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 15 */ SELECT us.nom_usuario, us.tip_usuario, us.id_usuario,
			CASE us.tip_usuario  
				WHEN 'G' THEN (/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 16 */ SELECT nom_agencia FROM agencia ag WHERE ag.cod_agencia=%s LIMIT 1)
				WHEN 'A' THEN 'Soporte'
				ELSE 'NO DEFINIDO'
			END AS nombre_chat,
			CASE us.tip_usuario  
				WHEN 'G' THEN 'Agente'
				WHEN 'A' THEN 'Soporte'
				ELSE 'NO DEFINIDO'
			END AS tipo_chat,
			CASE us.tip_usuario  
				WHEN 'G' THEN 'Distribuidor: '
				WHEN 'A' THEN 'Soporte'
				ELSE 'NO DEFINIDO'
			END AS tipo_chat2,
			CASE us.tip_usuario  
				WHEN 'G' THEN '2'
				WHEN 'D' THEN '1'
				WHEN 'A' THEN '0'
				ELSE 'NO DEFINIDO'
			END AS orden,
			CASE us.tip_usuario  
				WHEN 'G' THEN (/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 17 */ SELECT nom_banca FROM banca ban WHERE ban.cod_banca=us.cod_taquilla LIMIT 1)
				WHEN 'A' THEN 'Soporte'
				ELSE 'NO DEFINIDO'
			END AS nombre_sup,
			(/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 18 */ SELECT COUNT(*) FROM chat ch 
				WHERE ch.to1=%s AND nombre_chat = ch.from1 AND recd=1
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC) AS no_leido,
			(/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 19 */ SELECT message FROM chat ch  
				WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS message,
			(/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 20 */ SELECT sentdate FROM chat ch 
				WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS sentdate,
			(/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 21 */ SELECT senttime FROM chat ch 
				WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS senttime,
			(/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 22 */ SELECT connected FROM chat ch 
				WHERE nombre_chat = ch.from1
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS connected
		FROM 
			usuario us
		WHERE us.tip_usuario='G' OR us.tip_usuario='A'
		GROUP BY nombre_chat
		ORDER BY sentdate DESC, senttime DESC, connected DESC, orden ASC, nombre_chat ASC",
            GetSQLValueString($_SESSION['MM_cod_agencia'], "int"),
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
    } elseif ($_SESSION['MM_UserGroup'] == "G") {
        $query_Recordset101 = sprintf(
            "/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 23 */ SELECT us.nom_usuario, us.tip_usuario, us.id_usuario,
			CASE us.tip_usuario  
				WHEN 'U' THEN (/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 24 */ SELECT nom_taquilla FROM taquilla ta WHERE ta.cod_taquilla=us.cod_taquilla 
					AND ta.cod_agencia=%s LIMIT 1)  
				WHEN 'D' THEN (/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 25 */ SELECT nom_banca FROM banca ba WHERE ba.cod_banca=%s LIMIT 1)
				WHEN 'A' THEN 'Soporte'
				ELSE 'NO DEFINIDO'
			END AS nombre_chat, 
			CASE us.tip_usuario  
				WHEN 'U' THEN 'Taquilla'
				WHEN 'D' THEN 'Distribuidor'
				WHEN 'A' THEN 'Soporte'
				ELSE 'NO DEFINIDO'
			END AS tipo_chat,
			CASE us.tip_usuario  
				WHEN 'U' THEN 'Agente: '
				WHEN 'D' THEN ''
				WHEN 'A' THEN 'Soporte'
				ELSE 'NO DEFINIDO'
			END AS tipo_chat2,
			CASE us.tip_usuario  
				WHEN 'U' THEN '2'
				WHEN 'D' THEN '1'
				WHEN 'A' THEN '0'
				ELSE 'NO DEFINIDO'
			END AS orden,
			CASE us.tip_usuario  
				WHEN 'U' THEN (/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 26 */ SELECT nom_agencia FROM taquilla taq, agencia age WHERE taq.cod_taquilla=us.cod_taquilla AND 
					age.cod_agencia = taq.cod_agencia LIMIT 1)  
				WHEN 'D' THEN ''
				WHEN 'A' THEN 'Soporte'
				ELSE 'NO DEFINIDO'
			END AS nombre_sup, 
			(/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 27 */ SELECT COUNT(*) FROM chat ch 
				WHERE ch.to1=%s AND nombre_chat = ch.from1 AND recd=1
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC) AS no_leido,
			(/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 28 */ SELECT message FROM chat ch  
				WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS message,
			(/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 29 */ SELECT sentdate FROM chat ch 
				WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS sentdate,
			(/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 30 */ SELECT senttime FROM chat ch 
				WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS senttime,
			(/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 31 */ SELECT connected FROM chat ch 
				WHERE nombre_chat = ch.from1
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS connected
		FROM 
			usuario us
		WHERE us.tip_usuario='U' OR us.tip_usuario='D' OR us.tip_usuario='A'
		GROUP BY nombre_chat
		ORDER BY sentdate DESC, senttime DESC, orden ASC, connected DESC, nombre_chat ASC",
            GetSQLValueString($_SESSION['MM_cod_agencia'], "int"),
            GetSQLValueString($_SESSION['MM_cod_banca'], "int"),
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
    } elseif ($_SESSION['MM_UserGroup'] == "D") {
        $query_Recordset101 = sprintf(
            "/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 32 */ SELECT us.nom_usuario, us.tip_usuario, us.id_usuario,
			CASE us.tip_usuario  
				WHEN 'U' THEN (/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 33 */ SELECT nom_taquilla FROM taquilla ta, agencia ag WHERE ta.cod_taquilla=us.cod_taquilla AND
					ag.cod_agencia=ta.cod_agencia AND ag.cod_banca =%s LIMIT 1)  
				WHEN 'G' THEN (/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 34 */ SELECT nom_agencia FROM agencia ag WHERE ag.cod_agencia=us.cod_taquilla AND
					ag.cod_banca =%s LIMIT 1)
				WHEN 'A' THEN 'Soporte'
				ELSE 'NO DEFINIDO'
			END AS nombre_chat, 
			CASE us.tip_usuario  
				WHEN 'U' THEN 'Taquilla'
				WHEN 'G' THEN 'Agente'
				WHEN 'A' THEN 'Soporte'
				ELSE 'NO DEFINIDO'
			END AS tipo_chat,
			CASE us.tip_usuario  
				WHEN 'U' THEN 'Agente: '
				WHEN 'G' THEN 'Distribuidor: '
				WHEN 'A' THEN 'Soporte'
				ELSE 'NO DEFINIDO'
			END AS tipo_chat2,
			CASE us.tip_usuario  
				WHEN 'U' THEN '2'
				WHEN 'G' THEN '1'
				WHEN 'A' THEN '0'
				ELSE 'NO DEFINIDO'
			END AS orden,
			CASE us.tip_usuario  
				WHEN 'U' THEN (/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 35 */ SELECT nom_agencia FROM taquilla taq, agencia age WHERE taq.cod_taquilla=us.cod_taquilla AND 
					age.cod_agencia = taq.cod_agencia LIMIT 1)  
				WHEN 'G' THEN (/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 36 */ SELECT nom_banca FROM banca ban WHERE ban.cod_banca=us.cod_taquilla LIMIT 1)
				WHEN 'A' THEN 'Soporte'
				ELSE 'NO DEFINIDO'
			END AS nombre_sup, 
			(/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 37 */ SELECT COUNT(*) FROM chat ch 
				WHERE ch.to1=%s AND nombre_chat = ch.from1 AND recd=1
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC) AS no_leido,
			(/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 38 */ SELECT message FROM chat ch  
				WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS message,
			(/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 39 */ SELECT sentdate FROM chat ch 
				WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS sentdate,
			(/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 40 */ SELECT senttime FROM chat ch 
				WHERE (nombre_chat = ch.from1 AND ch.to1=%s AND recd!=2) OR (nombre_chat = ch.to1 AND ch.from1=%s AND recd!=2)
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS senttime,
			(/* PARSEADORES1 new\chat\chat_tablista.php - QUERY 41 */ SELECT connected FROM chat ch 
				WHERE nombre_chat = ch.from1
				ORDER BY ch.id DESC, ch.sentdate DESC, ch.senttime DESC LIMIT 1) AS connected
		FROM 
			usuario us
		WHERE us.tip_usuario='U' OR us.tip_usuario='G' OR us.tip_usuario='A'
		GROUP BY nombre_chat
		ORDER BY sentdate DESC, senttime DESC, orden ASC, connected DESC, nombre_chat ASC",
            GetSQLValueString($_SESSION['MM_cod_banca'], "int"),
            GetSQLValueString($_SESSION['MM_cod_banca'], "int"),
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
    }
    $noLeidoGlobal="";
    if (((isset($totalRows_Recordset101) && $totalRows_Recordset101>0))) {?>
		<table id="latabla" cellpadding="0" cellspacing="0" style="width:100%;" border="0">
		<thead><tr><th></th></tr></thead>
		<?php
            if ($totalRows_Recordset101>0) {
                $x=0;
                do {
                    if ($row_Recordset101['nombre_chat']!="") {
                        $ultMens="";
                        if ($row_Recordset101['message']!="") {
                            if (strlen($row_Recordset101['message'])>20) {
                                $ultMens=substr($row_Recordset101['message'], 0, 20)."...";
                            } else {
                                $ultMens=$row_Recordset101['message'];
                            }
                        }
                        $abrNom=substr($row_Recordset101['nombre_chat'], 0, 2);
                        $idtrT=$row_Recordset101['id_usuario'].$row_Recordset101['tip_usuario'];
                        $titl=$row_Recordset101['tipo_chat2'].strtoupper($row_Recordset101['nombre_sup']);
                        $nom_chat=substr($row_Recordset101['nombre_chat'], 0, 14);
                        if ($row_Recordset101['nombre_chat']=="") {
                            $nom_chat.="ERROR";
                        } ?>
						<tr height="40" style="border-bottom: 1px solid #C1BDBE;background:#FFFFFF; color:#000000;"
							onmouseover="cambiacolor_over(this)" onmouseout="cambiacolor_out(this)"
							id="<?php echo $idtrT; ?>" title="<?php echo $titl; ?>">
							<td style="padding:1.5% 0 0 0">
                            <div class="container-fluid">
                            <div class="row">
							<a href="#" id="<?php echo "a".$idtrT; ?>" style="text-decoration:none" 
								onClick="clicAhref('<?php echo $idtrT; ?>','<?php echo "n".$idtrT; ?>',
												   '<?php echo "f".$idtrT; ?>','<?php echo "m".$idtrT; ?>',
												   '<?php echo $nUsu; ?>','<?php echo $row_Recordset101['nombre_chat']; ?>',
												   '<?php echo 'newT'.$idtrT; ?>')"
								class="two"> 
								<div class="circulo" style="background:<?php echo color_var($x); ?>;" 
                                	id="<?php echo 'c'.$idtrT; ?>">
									<?php echo $abrNom; ?>
								</div>
                                
								<div class="col8 col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8" 
                                	style="float:left; color:#333333;padding:0 0 0 10px" id="<?php echo 'n'.$idtrT; ?>">
									<?php echo strtoupper($nom_chat);
                        //." ".$idtrT." ".rand(5, 90);
                        if (strtotime(date('Y-m-d H:i:s'))>strtotime($row_Recordset101['connected'])
                                            or $row_Recordset101['connected']=="") {
                            echo '<div class="c1 c2" style=" background:#B50003; float:left"></div>';
                        } else {
                            echo '<div class="c1 c2" style=" background:#2ECC40; float:left"></div>';
                        } ?>
								</div>
								<div class="col7 col-xl-2 col-lg-2 col-md-2 col-sm-2 hidden-xs" 
                                style="float:left; color:#333333; padding:2px 0 0 0;" 
                                	id="<?php echo 'f'.$idtrT; ?>"><?php
                                        if ($row_Recordset101['sentdate']!=0) {
                                            echo str_replace("-", ".", fechanueva($row_Recordset101['sentdate']));
                                        } else {
                                            echo "&nbsp;";
                                        } ?>
								</div>
								<div class="col1 col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8" 
                                	style="float:left; color:#333333;" id="<?php echo 'ti'.$idtrT; ?>">
									<?php echo $row_Recordset101['tipo_chat']; ?>
								</div>
								<div class="col11 col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-8" 
                                	style="float:left; color:#333333;" id="<?php echo 'm'.$idtrT; ?>">
									<?php echo $ultMens; ?>
								</div>
                                
								<?php
                                if ($row_Recordset101['no_leido']>0) {
                                    $nLeido=$row_Recordset101['no_leido'];
                                    $noLeidoGlobal=$noLeidoGlobal+$row_Recordset101['no_leido'];
                                    $noLClass="circulop";
                                } else {
                                    $nLeido="";
                                    $noLClass="circulopnone";
                                } ?>
								<div class="<?php echo $noLClass; ?>" id="<?php echo 'newT'.$idtrT; ?>">
									<?php echo $nLeido; ?>
								</div>
							  </a>
                            </div>
                            </div>
							</td>
						</tr><?php
                        $x++;
                        if ($x>=21) {
                            $x=0;
                        }
                    }
                } while ($row_Recordset101 = mysqli_fetch_assoc($Recordset101));
            }?>
		</table>
        <script>
			var caNL="<?php echo $noLeidoGlobal?>";
			if (caNL>0) $("#new-message").css("display", "block"); else $("#new-message").css("display", "none");
			document.getElementById("new-message").innerHTML = "<?php echo $noLeidoGlobal;?>";
		</script><?php
    } else {
        echo "No hay registros";
    }
    if (isset($Recordset101)) {
        mysqli_free_result($Recordset101);
    }
} else {
    echo "Inicie sesión";
}?>
<script>
	if( typeof colorActiva !== 'undefined' && jQuery.isFunction( colorActiva ) ) {colorActiva();}
	var xp=document.getElementById("q");theTable = $("#latabla");
	$(function() {theTable = $("#latabla");$("#q").keyup(function() {$.uiTableFilter(theTable, this.value);});});
	if(typeof xp !== 'undefined' && xp !== null) $.uiTableFilter(theTable, xp.value);
</script>