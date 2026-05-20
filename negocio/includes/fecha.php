<?php
function verfechaactual()
{
    date_default_timezone_set("Pacific/Honolulu") ;
    $tiempo = getdate(time());
    $dia = $tiempo['wday'];
    $dia_mes=$tiempo['mday'];
    $mes = $tiempo['mon'];
    $year = $tiempo['year'];
    $hora= $tiempo['hours'];
    $minutos = $tiempo['minutes'];
    $segundos = $tiempo['seconds'];
    if ($segundos < 10) {
        $segundos = "0".$segundos;
    }
    if ($hora < 12) {
        $segundos = $segundos."am";
    }
    if ($hora > 12) {
        $hora = (int)$hora - 12;
        $segundos = $segundos."pm";
    }
    if ($hora == 12) {
        $segundos = $segundos."pm";
    }
    if ($hora == 0) {
        $hora = "12";
    }
    if ($hora < 10) {
        $hora = "0".$hora;
    }
    if ($minutos < 10) {
        $minutos = "0".$minutos;
    }
    switch ($dia) {  case "1": $dia_nombre="Lunes"; break;  case "2": $dia_nombre="Martes"; break;  case "3": $dia_nombre="Mi&eacute;rcoles"; break;  case "4": $dia_nombre="Jueves"; break;  case "5": $dia_nombre="Viernes"; break;  case "6": $dia_nombre="S&aacute;bado"; break;  case "0": $dia_nombre="Domingo"; break;  }
    switch ($mes) {  case "1": $mes_nombre="Enero"; break;  case "2": $mes_nombre="Febrero"; break;  case "3": $mes_nombre="Marzo"; break;  case "4": $mes_nombre="Abril"; break;  case "5": $mes_nombre="Mayo"; break;  case "6": $mes_nombre="Junio"; break;  case "7": $mes_nombre="Julio"; break;  case "8": $mes_nombre="Agosto"; break;  case "9": $mes_nombre="Septiembre"; break;  case "10": $mes_nombre="Octubre"; break;  case "11": $mes_nombre="Noviembre"; break;  case "12": $mes_nombre="Diciembre"; break;  }
    echo $dia_nombre." ".$dia_mes." de ".$mes_nombre." de ".$year." | ".$hora.":".$minutos.".".$segundos;
} function vfechaActual()
{
    date_default_timezone_set("Pacific/Honolulu") ;
    $tiempo = getdate(time());
    $dia = $tiempo['wday'];
    $dia_mes=$tiempo['mday'];
    $mes = $tiempo['mon'];
    $year = $tiempo['year'];
    switch ($dia) {  case "1": $dia_nombre="Lunes"; break;  case "2": $dia_nombre="Martes"; break;  case "3": $dia_nombre="Mi&eacute;rcoles"; break;  case "4": $dia_nombre="Jueves"; break;  case "5": $dia_nombre="Viernes"; break;  case "6": $dia_nombre="S&aacute;bado"; break;  case "0": $dia_nombre="Domingo"; break;  }
    switch ($mes) {  case "1": $mes_nombre="Enero"; break;  case "2": $mes_nombre="Febrero"; break;  case "3": $mes_nombre="Marzo"; break;  case "4": $mes_nombre="Abril"; break;  case "5": $mes_nombre="Mayo"; break;  case "6": $mes_nombre="Junio"; break;  case "7": $mes_nombre="Julio"; break;  case "8": $mes_nombre="Agosto"; break;  case "9": $mes_nombre="Septiembre"; break;  case "10": $mes_nombre="Octubre"; break;  case "11": $mes_nombre="Noviembre"; break;  case "12": $mes_nombre="Diciembre"; break;  }
    echo $dia_nombre." ".$dia_mes." de ".$mes_nombre." de ".$year;
} function verfechaactualcorta()
{
    date_default_timezone_set("Pacific/Honolulu") ;
    $tiempo = getdate(time());
    $dia = $tiempo['wday'];
    $dia_mes=$tiempo['mday'];
    $mes = $tiempo['mon'];
    $year = $tiempo['year'];
    $hora= $tiempo['hours'];
    $minutos = $tiempo['minutes'];
    $segundos = $tiempo['seconds'];
    if ($segundos < 10) {
        $segundos = "0".$segundos;
    }
    if ($hora < 12) {
        $segundos = "am";
    }
    if ($hora > 12) {
        $hora = (int)$hora - 12;
        $segundos = "pm";
    }
    if ($hora == 12) {
        $segundos = "pm";
    }
    if ($hora == 0) {
        $hora = "12";
    }
    if ($hora < 10) {
        $hora = "0".$hora;
    }
    if ($minutos < 10) {
        $minutos = "0".$minutos;
    }
    if ($dia_mes>=1 || $dia_mes<=9) {
        $dia_mes="0".$dia_mes;
    }
    if ($mes>=1 || $mes<=9) {
        $mes="0".$mes;
    }
    return $dia_mes."-".$mes."-".$year."|".$hora.":".$minutos.$segundos;
} function diaactual()
{
    date_default_timezone_set("Pacific/Honolulu") ;
    $tiempo = getdate(time());
    $dia = $tiempo['wday'];
    return $dia;
} function nomDiaActual()
{
    date_default_timezone_set("Pacific/Honolulu") ;
    $tiempo = getdate(time());
    $dia = $tiempo['wday'];
    switch ($dia) {  case "0": $ndia="DOMINGO"; break;  case "1": $ndia="LUNES"; break;  case "2": $ndia="MARTES"; break;  case "3": $ndia="MIERCOLES"; break;  case "4": $ndia="JUEVES"; break;  case "5": $ndia="VIERNES"; break;  case "6": $ndia="SABADO"; break;  }
    return $ndia;
} function horaactual8()
{
    date_default_timezone_set("Pacific/Honolulu");
    $hora = date("H:i:s");
    return $hora;
} function fechanueva($fechavieja)
{
    date_default_timezone_set("Pacific/Honolulu") ;
    list($a, $m, $d)=explode("-", $fechavieja);
    return $d."-".$m."-".$a;
} function horaampm($horamilitar)
{
    $hora="00";
    $minutos="00";
    $segundos="00";
    if (!empty($horamilitar)) {
        list($hora, $minutos, $segundos)=explode(":", $horamilitar);
        if ($hora < 12) {
            $segundos = $segundos."am";
        }
        if ($hora > 12) {
            $hora = (int)$hora - 12;
            if ($hora > 9) {
                $segundos = $segundos."pm";
            } else {
                $hora = "0".$hora;
                $segundos = $segundos."pm";
            }
        }
        if ($hora == 12) {
            $segundos = $segundos."pm";
        }
        if ($hora == 0) {
            $hora = "12";
        }
    }
    return $hora.":".$minutos.":".$segundos;
} function horamysql($hora)
{
    list($hora, $minutos, $ampm)=explode(":", $hora);
    $hora=$hora/1;
    $minutos=$minutos/1;
    if ($ampm=="PM") {
        if ($hora!=12) {
            $hora=$hora+12;
        }
    }
    if ($hora!=12 && $hora<10) {
        $hora="0".$hora;
    }
    if ($minutos<10) {
        $minutos="0".$minutos;
    }
    if ($ampm=="AM" && $hora==12) {
        $hora="00";
    }
    return $hora.":".$minutos.":00";
} function horamysqlMTP($hora)
{
    list($hora, $minutos, $ampm)=explode(":", $hora);
    $hora=$hora/1;
    $minutos=$minutos/1;
    if ($ampm=="PM") {
        if ($hora!=12) {
            $hora=$hora+12;
        }
    }
    if ($hora!=12 && $hora<10) {
        $hora="0".$hora;
    }
    if ($minutos<10) {
        $minutos="0".$minutos;
    }
    if ($ampm=="AM" && $hora==12) {
        $hora="00";
    }
    return $hora.":".$minutos.":00";
} function cambioHoramysql($hora)
{
    list($hora, $minutos, $seg)=explode(":", $hora);
    $hora=$hora/1;
    $minutos=$minutos/1;
    $ampm="AM";
    if ($hora==12) {
        $ampm="PM";
    }
    if ($hora>12) {
        $hora=$hora-12;
        $ampm="PM";
    }
    if ($hora<10) {
        $hora="0".$hora;
    }
    if ($hora==0) {
        $hora="12";
        $ampm="PM";
    }
    if ($minutos<10) {
        $minutos="0".$minutos;
    }
    return $hora.":".$minutos.":".$ampm;
} function horasinampm($horamilitar)
{
    list($hora, $minutos, $segundos)=explode(":", $horamilitar);
    if ($hora > 12) {
        $hora = (int)$hora - 12;
        if ($hora > 9) {
            $segundos = $segundos."pm";
        } else {
            $hora = "0".$hora;
            $segundos = $segundos."pm";
        }
    }
    if ($hora == 12) {
        $segundos = $segundos."pm";
    }
    if ($hora == 0) {
        $hora = "12";
    }
    return $hora.":".$minutos.":".$segundos;
} function fechamysql($fechavieja)
{
    list($a, $m, $d)=explode("-", $fechavieja);
    return $a."-".$m."-".$d;
} function fechaymd($fechavieja)
{
    list($d, $m, $a)=explode("-", $fechavieja);
    return $a."-".$m."-".$d;
} function fechaactualve()
{
    date_default_timezone_set("Pacific/Honolulu") ;
    $tiempo = getdate(time());
    $dia = $tiempo['mday'];
    $mes = $tiempo['mon'];
    $anno = $tiempo['year'];
    return $dia."-".$mes."-".$anno;
} function timestampToH($timestamp)
{
    $return="";
    $hours=floor(($timestamp/60)/60);
    if ($hours>0) {
        $timestamp-=$hours*60*60;
        $return.=str_pad($hours, 2, "0", STR_PAD_LEFT).":";
    }
    $minutes=floor($timestamp/60);
    if ($minutes>0) {
        $timestamp-=$minutes*60;
        $return.=str_pad($minutes, 2, "0", STR_PAD_LEFT);
    }
    return $return;
} function fechaactualbd()
{
    date_default_timezone_set("Pacific/Honolulu") ;
    $tiempo = getdate(time());
    $dia = $tiempo['mday'];
    $mes = $tiempo['mon'];
    $anno = $tiempo['year'];
    $Fechatotal=$anno."-".$mes."-".$dia;
    if ($dia < 10) {
        $Fechatotal=$anno."-".$mes."-0".$dia;
    }
    if ($mes < 10) {
        $Fechatotal=$anno."-0".$mes."-".$dia;
    }
    if ($mes < 10 && $dia < 10) {
        $Fechatotal=$anno."-0".$mes."-0".$dia;
    }
    return $Fechatotal;
} function horaactual()
{
    date_default_timezone_set("Pacific/Honolulu") ;
    $hora = getdate(time());
    $xhora = $hora["hours"];
    $xminuto = $hora["minutes"];
    $xsegundo = $hora["seconds"];
    if ($hora["hours"] < 10) {
        $xhora = "0".$hora["hours"];
    }
    if ($hora["minutes"] < 10) {
        $xminuto = "0".$hora["minutes"];
    }
    if ($hora["seconds"] < 10) {
        $xsegundo = "0".$hora["seconds"];
    }
    $xhoraTxt=$xhora.":".$xminuto.":".$xsegundo;
    return $xhoraTxt;
} function dias_transcurridos($fi, $ff)
{
    $dias=(strtotime($fi)-strtotime($ff))/86400;
    $dias=abs($dias);
    $dias=floor($dias);
    return $dias;
} function restahoras($horaIni, $horaFin)
{
    $faltante=(date("H:i:s", strtotime("00:00:00") + strtotime($horaFin) - strtotime($horaIni)));
    list($h, $m, $s)=explode(":", $faltante);
    if ($h<0) {
        $h="00";
        $m="00";
        $s="00";
    }
    return $h.":".$m.":".$s."";
} function horamysqlMTP2($hora)
{
    list($hora, $minutos)=explode(":", $hora);
    $hora=$hora/1;
    $minutos=$minutos/1;
    if ($hora!=12) {
        $hora=$hora+12;
    }
    if ($hora!=12 && $hora<10) {
        $hora="0".$hora;
    }
    if ($minutos<10) {
        $minutos="0".$minutos;
    }
    $hora=0;
    $minutos=0;
    return $hora.":".$minutos.":00";
} function horaCreacionTicket($horaIni, $horaFin)
{
    $faltante=(date("H:i:s", strtotime("00:00:00") + strtotime($horaFin) - strtotime($horaIni)));
    list($h, $m, $s)=explode(":", $faltante);
    if ($h<0) {
        $h="00";
        $m="00";
        $s="00";
    }
    if ($h==0) {
        $h="";
    } else {
        $h=$h."h ";
    }
    return $h.$m."m ".$s."seg";
} function restahorassinseg($horaIni, $horaFin)
{
    $faltante=(date("H:i:s", strtotime("00:00:00") + strtotime($horaFin) - strtotime($horaIni)));
    list($h, $m, $s)=explode(":", $faltante);
    if ($h<0) {
        $h="00";
        $m="00";
        $s="00";
    }
    return $h."h:".$m."m";
} function restahoraRB($horaIni, $horaFin)
{
    $faltante=(date("H:i:s", strtotime("00:00:00") + strtotime($horaFin) - strtotime($horaIni)));
    list($h, $m, $s)=explode(":", $faltante);
    if ($h<=0) {
        $salida=($m*1)."min";
    } else {
        $salida=($h*1)."h:".($m*1)."m";
    }
    return $salida;
} function restahoraVenta($horaIni, $horaFin)
{
    $faltante=(date("H:i:s", strtotime("00:00:00") + strtotime($horaFin) - strtotime($horaIni)));
    list($h, $m, $s)=explode(":", $faltante);
    if ($h==0 && $m==0 && $s>2) {
        $m=1;
    }
    return array($h,$m,$s);
} function parteHora($hora)
{
    $horaSplit = explode(":", $hora);
    if (count($horaSplit) < 3) {
        $horaSplit[2] = 0;
    }
    return $horaSplit;
} function SumaHoras($time1, $time2)
{
    list($hour1, $min1, $sec1) = parteHora($time1);
    list($hour2, $min2, $sec2) = parteHora($time2);
    return date('H:i:s', mktime($hour1 + $hour2, $min1 + $min2, $sec1 + $sec2));
} function horaactual2()
{
    date_default_timezone_set("Pacific/Honolulu") ;
    $hora = date("H:i:s");
    return $hora;
} function convierteHora($hora, $x)
{
    $part=explode(" ", $hora);
    $hora=explode(":", $part[0]);
    $h=$hora[0];
    $m=$hora[1];
    if ($part[$x]=="pm" && $h!=12) {
        $h=$h+12;
    }
    if ($part[$x]=="PM" && $h!=12) {
        $h=$h+12;
    }
    return $h.":".$m;
} function MenosHoras($time1, $time2)
{
    list($hour1, $min1, $sec1) = parteHora($time1);
    list($hour2, $min2, $sec2) = parteHora($time2);
    return date('H:i:s', mktime($hour1 - $hour2, $min1 - $min2, $sec1 - $sec2));
}
function semana($fecha)
{
    $fec=explode("-", $fecha);
    $year=$fec[0];
    $month=$fec[1];
    $day=$fec[2];
    
    $semana=date("W", mktime(0, 0, 0, $month, $day, $year));
    $diaSemana=date("w", mktime(0, 0, 0, $month, $day, $year));
    if ($diaSemana==0) {
        $diaSemana=7;
    }
    $pDia=date("Y-m-d", mktime(0, 0, 0, $month, $day-$diaSemana+1, $year));
    $uDia=date("Y-m-d", mktime(0, 0, 0, $month, $day+(7-$diaSemana), $year));
    return array($pDia, $uDia, $semana);
}
function cortoFec($fecha)
{
    $fec=explode("-", $fecha);
    $dia=($fec[2]);
    $mes=($fec[1]);
    $ano=substr($fec[0], 2, 2);
    switch ($mes) {
        case "1": $ndia="ENE"; break;
        case "2": $ndia="FEB"; break;
        case "3": $ndia="MAR"; break;
        case "4": $ndia="ABR"; break;
        case "5": $ndia="MAY"; break;
        case "6": $ndia="JUN"; break;
        case "7": $ndia="JUL"; break;
        case "8": $ndia="AGO"; break;
        case "9": $ndia="SEP"; break;
        case "10": $ndia="OCT"; break;
        case "11": $ndia="NOV"; break;
        case "12": $ndia="DIC"; break;

    }
    return $dia."-".$ndia."-".$ano;
}
function verfechaF($fechavieja)
{
    list($a, $mes, $dia)=explode("-", $fechavieja);
    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
    $dia_nombre = $dias[date("w", mktime(0, 0, 0, $mes, $dia, $a))];
    switch ($mes) {
        case "1": $mes_nombre="Enero"; break;
        case "2": $mes_nombre="Febrero"; break;
        case "3": $mes_nombre="Marzo"; break;
        case "4": $mes_nombre="Abril"; break;
        case "5": $mes_nombre="Mayo"; break;
        case "6": $mes_nombre="Junio"; break;
        case "7": $mes_nombre="Julio"; break;
        case "8": $mes_nombre="Agosto"; break;
        case "9": $mes_nombre="Septiembre"; break;
        case "10": $mes_nombre="Octubre"; break;
        case "11": $mes_nombre="Noviembre"; break;
        case "12": $mes_nombre="Diciembre"; break;
    }
    return $dia_nombre.", ".$dia." de ".$mes_nombre." de ".$a;
}
//--------------------------------------- LOTERIA--------------------------------------
function diaSegunFecha($fechavieja)
{
    list($a, $mes, $dia)=explode("-", $fechavieja);
    $dias = array("0","1","2","3","4","5","6");
    $nro_dia = $dias[date("w", mktime(0, 0, 0, $mes, $dia, $a))];
    return $nro_dia;
}
function loteriaHoy($diahoy)
{
    switch ($diahoy) {
        case 0: $aDia="dom_loteria";$bDia="dom_loteriabanca";break;
        case 1: $aDia="lun_loteria";$bDia="lun_loteriabanca";break;
        case 2: $aDia="mar_loteria";$bDia="mar_loteriabanca";break;
        case 3: $aDia="mie_loteria";$bDia="mie_loteriabanca";break;
        case 4: $aDia="jue_loteria";$bDia="jue_loteriabanca";break;
        case 5: $aDia="vie_loteria";$bDia="vie_loteriabanca";break;
        case 6: $aDia="sab_loteria";$bDia="sab_loteriabanca";break;
    }
    return array($aDia, $bDia);
}
function loteriaHoyAdmin($diahoy)
{
    switch ($diahoy) {
        case 0: $cDia="dom";break;
        case 1: $cDia="lun";break;
        case 2: $cDia="mar";break;
        case 3: $cDia="mie";break;
        case 4: $cDia="jue";break;
        case 5: $cDia="vie";break;
        case 6: $cDia="sab";break;
    }
    return $cDia;
}
