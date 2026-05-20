<?php  
require_once('./Connections/conexionbanca.php');
//$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$dias = array("7","1","2","3","4","5","6");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
$diasemana=$dias[date('w')];
$diames=date('d');
echo '<br>'.$diames.'<br>';
$fech=fechaactualbd();
$horasistema=horaactual();
$fechahora=$fech.' '.$horasistema;
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 tareas\reapertura.php - QUERY 1 */ SELECT *
    FROM 
        tablatarea, tablausuario
    WHERE 
    tablatarea.id_usuariocreador = tablausuario.id_usuario AND
    tablatarea.estado_tarea =1 AND
    tablatarea.repeticion LIKE %s  ",
    GetSQLValueString('%'.$diasemana.'%', "text"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    echo '<br>'.$totalRows_Recordset1.'<br>';
if($totalRows_Recordset1>0){
do {
  echo   $row_Recordset1['fec_culminar'].'<br>';
  //$rest = substr("abcdef", -2);    // devuelve "ef"
  $solohoravieja = substr($row_Recordset1['fec_culminar'], -8);    // devuelve "ef"
  echo   $solohoravieja.'<br>';
  $nuevafechaculminacion=fechaactualbd().' '.$solohoravieja;
  echo  $nuevafechaculminacion.'<br>';
    
    $insertSQL1 = sprintf(
        "/* PARSEADORES1 tareas\reapertura.php - QUERY 2 */ UPDATE tablatarea
            SET
            estado_tarea=%s, 
            fec_culminar=%s
            WHERE id_tarea=%s",
    GetSQLValueString(0, "int"),
    GetSQLValueString($nuevafechaculminacion, "date"),
    GetSQLValueString($row_Recordset1['id_tarea'], "int"));
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));


            $comentario='Reeabierta por el sistema por orden de '.$row_Recordset1['nom_usuario'].' a las '.$fechahora;
 
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 tareas\reapertura.php - QUERY 3 */ INSERT 
                INTO tablatareacomentario 
                (id_usuario, id_tarea, text_comentario) 
                VALUES (%s, %s, %s)",
                GetSQLValueString($row_Recordset1['id_usuariocreador'], "int"),
                GetSQLValueString($row_Recordset1['id_tarea'], "int"),
                GetSQLValueString($comentario, "text"));
                $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
    




echo   '<br><br><br><br><br><br>';
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); }


$query_Recordset11 = sprintf(
    "/* PARSEADORES1 tareas\reapertura.php - QUERY 4 */ SELECT *
    FROM 
        tablatarea, tablausuario
    WHERE 
    tablatarea.id_usuariocreador = tablausuario.id_usuario AND
    tablatarea.estado_tarea =1 AND
    tablatarea.diames LIKE %s  ",
    GetSQLValueString('%'.$diames.'%', "text"));
    $Recordset11 = mysqli_query($conexionbanca, $query_Recordset11) or die(mysqli_error($conexionbanca));
    $row_Recordset11 = mysqli_fetch_assoc($Recordset11);
    $totalRows_Recordset11 = mysqli_num_rows($Recordset11);
    echo '<br>'.$totalRows_Recordset11.'<br>';
if($totalRows_Recordset11>0){
do {
  echo   $row_Recordset11['fec_culminar'].'<br>';
  //$rest = substr("abcdef", -2);    // devuelve "ef"
  $solohoravieja = substr($row_Recordset11['fec_culminar'], -8);    // devuelve "ef"
  echo   $solohoravieja.'<br>';
  $nuevafechaculminacion=fechaactualbd().' '.$solohoravieja;
  echo  $nuevafechaculminacion.'<br>';
    
    $insertSQL11 = sprintf(
        "/* PARSEADORES1 tareas\reapertura.php - QUERY 5 */ UPDATE tablatarea
            SET
            estado_tarea=%s, 
            fec_culminar=%s
            WHERE id_tarea=%s",
    GetSQLValueString(0, "int"),
    GetSQLValueString($nuevafechaculminacion, "date"),
    GetSQLValueString($row_Recordset11['id_tarea'], "int"));
    $Result11 = mysqli_query($conexionbanca, $insertSQL11) or die(mysqli_error($conexionbanca));


            $comentario='Reeabierta por el sistema por orden de '.$row_Recordset11['nom_usuario'].' a las '.$fechahora;
 
            $insertSQL11 = sprintf(
                "/* PARSEADORES1 tareas\reapertura.php - QUERY 6 */ INSERT 
                INTO tablatareacomentario 
                (id_usuario, id_tarea, text_comentario) 
                VALUES (%s, %s, %s)",
                GetSQLValueString($row_Recordset11['id_usuariocreador'], "int"),
                GetSQLValueString($row_Recordset11['id_tarea'], "int"),
                GetSQLValueString($comentario, "text"));
                $Result11 = mysqli_query($conexionbanca, $insertSQL11) or die(mysqli_error($conexionbanca));
    




echo   '<br><br><br><br><br><br>';
} while ($row_Recordset11 = mysqli_fetch_assoc($Recordset11)); }