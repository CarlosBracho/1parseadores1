<?php 
// aaaaaaaaaaa
echo '<br>';
echo 'V14<br>';
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('../Connections/conexionbanca.php');

//incluyo el c�digo de la clase stoper
include_once('../includes/class.stoper.php');
//instancio un objeto de la clase stoper
$s = new Stoper();

echo 'Empiezo...<br>';
//ejecuto el m�todo Start() para que el objeto stoper comience a contar el tiempo
$s->Start();


$query_Recordset18D =  sprintf(
    "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 1 */ SELECT  
*
            FROM  opciones_parley
            WHERE id_opcionp=%s
            LIMIT 1",
    GetSQLValueString(1, "int")
);
        $Recordset18D = mysqli_query($conexionbanca, $query_Recordset18D) or die(mysqli_error($conexionbanca));
        $row_Recordset18D = mysqli_fetch_assoc($Recordset18D);
        $totalRows_Recordset18D = mysqli_num_rows($Recordset18D);
$usourl=0;
$ja=0;
$la=0;
$JuegosQEstan=',';
//
//545451162

//futbol listo
//baloncesto listo
//Hoskey listo
//beisbol listo
//futbol americano listo por Leo*************


//inicio codigo de verificacion de fecha del archivo
$horaTxt=horaactual(); $FechaTxt=fechaactualbd(); $fechahora=$FechaTxt.' '.$horaTxt;

$exicte=0;
$archivoquehay=0;
$continuar=0;
$nombre_fichero = 'WiningBet.html';
$nombre_fichero2 = 'autosave.html';
if (file_exists($nombre_fichero)) {
    echo "El fichero $nombre_fichero existe<br>";
    $exicte=1;
    $archivoquehay='WiningBet.html';
} else {
    echo "El fichero $nombre_fichero no existe<br>";
}

if($exicte==0){
if (file_exists($nombre_fichero2)) {
    echo "El fichero $nombre_fichero2 existe<br>";
    $exicte=1;
    $archivoquehay='autosave.html';
} else {
    echo "El fichero $nombre_fichero2 no existe<br>";
}}






$nombre_archivo = $archivoquehay;
$newDate2=filemtime($nombre_archivo);
echo date ( 'Y-m-d H:i:s' , $newDate2).' Hora y ceha del archivo<br>';
$newDate2 = strtotime ( ' +0 hour , +15 minute' , $newDate2 ) ;//aqui se agrega en minutos el tiempo de viejo que se aceptara en este archivo
$newDate2 = date ( 'Y-m-d H:i:s' , $newDate2);
echo $newDate2.' archivo con 15 min mas<br>';
echo $fechahora.' hora actual<br>';


if($exicte==1){
if($newDate2>$fechahora){
echo 'Archivo de logros que esta subiendo es muy viejo suba uno actual y verifique que la hora de la pc sea la correcta<br>';

//unlink($nombre_archivo);

}else{
echo 'El archivo es actual<br>';
$continuar=1;
}}
//fin codigo de verificacion de fecha del archivo
$continuar=1;//borrar esta linea
if($continuar==1){ //aqui inicia todo


    $url='http://localhost/new/logros/autosave.html';
    $url2='http://localhost/new/logros/WiningBet.html';
//$url='http://localhost/sincronizado/autosave.html'; //mi pc
//$url2='http://localhost/sincronizado/WiningBet.html'; //mi pc

$horaTxt=horaactual(); $FechaTxt=fechaactualbd(); $fechahora=$FechaTxt.' '.$horaTxt;
$datetime =$fechahora; $datetime = strtotime('-6 hour', strtotime($datetime)); $datetime = date('Y-m-d H:i:s', $datetime);


//inicio de funciones

if($row_Recordset18D['Swicht']==0){
    function verificarjuego($codWiningBet, $horajuego, $ep1, $ep2)
    {
        global $conexionbanca;
        $yaestaequipo1cod=$ep1;
        $yaestaequipo2cod=$ep2;
        $horaTxt=horaactual();
        $FechaTxt=fechaactualbd();
        $datetime=$FechaTxt.' '.$horaTxt;
        $query_Recordset1 = sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 2 */ SELECT Id_p2juegosp2, idequipo1p2, idequipo2p2, pichee1p2, pichee2p2, codWiningBet_empate
        FROM p2juegos 
        WHERE  
        iniciodtp2 > %s AND
        codWiningBet = %s ",
            GetSQLValueString($FechaTxt.' 00:00:01', "date"),
            GetSQLValueString($codWiningBet, "int")
        );
        $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
        $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
        $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
        $totaltotalRows=$totalRows_Recordset1;
        $Id_p2juegosp2=$row_Recordset1['Id_p2juegosp2'];
        $idequipo1p2=$row_Recordset1['idequipo1p2'];
        $idequipo2p2=$row_Recordset1['idequipo2p2'];
        $pichee1p2=$row_Recordset1['pichee1p2'];
        $pichee2p2=$row_Recordset1['pichee2p2'];
        $codWiningBet_empate=$row_Recordset1['codWiningBet_empate'];
    
    
    
    
    
    if($totalRows_Recordset1>0)
    {
    
    
    
    
    
        $updateSQL = sprintf("/* PARSEADORES1 new\logros\WiningBet.php - QUERY 3 */ UPDATE p2juegos SET p2vecesactualizado=p2vecesactualizado+1, iniciodtp2 = %s
        WHERE  
        iniciodtp2 > %s AND
        codWiningBet = %s AND
        Id_p2juegosp2 = %s ",
        GetSQLValueString($horajuego, "date"),
        GetSQLValueString($FechaTxt.' 00:00:01', "date"),
        GetSQLValueString($codWiningBet, "int"),
        GetSQLValueString($Id_p2juegosp2, "int"));
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
    
    }

    //codigo inicia

    $query_Recordsetvrfjuego =  sprintf(
        "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 4 */ SELECT  
        *
                    FROM  p2juegos
                    WHERE 
                    iniciodtp2>%s 
                    AND idequipo1p2=%s
                    AND idequipo2p2=%s
                    AND jexterno=%s",
            GetSQLValueString($datetime, "date"),
            GetSQLValueString($yaestaequipo1cod, "int"),
            GetSQLValueString($yaestaequipo2cod, "int"),
            GetSQLValueString(1, "int")
    );
            $Recordsetvrfjuego = mysqli_query($conexionbanca, $query_Recordsetvrfjuego) or die(mysqli_error($conexionbanca));
            $row_Recordsetvrfjuego = mysqli_fetch_assoc($Recordsetvrfjuego);
            $totalRows_Recordsetvrfjuego = mysqli_num_rows($Recordsetvrfjuego);
            if($totalRows_Recordsetvrfjuego>0){
            

                $updateSQL = sprintf("/* PARSEADORES1 new\logros\WiningBet.php - QUERY 5 */ UPDATE p2juegos SET p2vecesactualizado=p2vecesactualizado+1, iniciodtp2 = %s
                WHERE  
                iniciodtp2 > %s AND
                Id_p2juegosp2 = %s ",
                GetSQLValueString($datetime, "date"),
                GetSQLValueString($datetime, "date"),
                GetSQLValueString($row_Recordsetvrfjuego['Id_p2juegosp2'], "int"));
                $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        }else{
            $query_Recordsetvrfjuego =  sprintf(
                "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 6 */ SELECT  
            *
                        FROM  p2juegos
                        WHERE 
                        iniciodtp2>%s 
                        AND idequipo1p2=%s
                        AND idequipo2p2=%s
                        AND jexterno=%s",
                GetSQLValueString($datetime, "date"),
                GetSQLValueString($yaestaequipo2cod, "int"),
                GetSQLValueString($yaestaequipo1cod, "int"),
                GetSQLValueString(1, "int")
            );
                    $Recordsetvrfjuego = mysqli_query($conexionbanca, $query_Recordsetvrfjuego) or die(mysqli_error($conexionbanca));
                    $row_Recordsetvrfjuego = mysqli_fetch_assoc($Recordsetvrfjuego);
                    $totalRows_Recordsetvrfjuego = mysqli_num_rows($Recordsetvrfjuego);
  
  
                    if($totalRows_Recordsetvrfjuego>0){
  
                      $updateSQL = sprintf("/* PARSEADORES1 new\logros\WiningBet.php - QUERY 7 */ UPDATE p2juegos SET p2vecesactualizado=p2vecesactualizado+1, iniciodtp2 = %s
        WHERE  
        iniciodtp2 > %s AND
        Id_p2juegosp2 = %s ",
        GetSQLValueString($datetime, "date"),
        GetSQLValueString($datetime, "date"),
        GetSQLValueString($row_Recordsetvrfjuego['Id_p2juegosp2'], "int"));
        $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
                    }


        }

    //codigo termina
    
    
        return array($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2, $codWiningBet_empate);
    }
    
    
    //estoy aqui un error p6 esta tomando la tabla que no es
    function verificarlogro($Id_p2juegosp2, $equipo, $tipol, $logrosarray)
    {
        $palabra_a_buscar  = $Id_p2juegosp2;
    
        foreach ($logrosarray as $clave=>$valor) {
    
            $indice = array_search($palabra_a_buscar, $valor);
            if ($valor["idjuegop3"]==$Id_p2juegosp2 & $valor["equipop3"]==$equipo & $valor["tipojugadap3"]==$tipol) {
                //echo 'ejecutando funcion<br>';
    
                if ($indice) {
                    $logro=$valor['logrop3'];
                    $Id_p3logros=$valor['Id_p3logrosp3'];
                    $logroABoRL=$valor['logroABoRLp3'];
                    $equipop3=$valor['equipop3'];
                    //echo $Id_p3logros.' - '.$logro.' - '.$logroABoRL.' - '.$equipop3.' - logro<br>';
    
                }
                return array($Id_p3logros, $logro, $logroABoRL, $equipop3);
            }
        }
    
    
      //  return array($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3);
    }
    //list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $tlarray);
    
    //list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $tlarray);
    
    
    function updatepiche($matches10px, $todox, $equipo)
    {
        global $conexionbanca;
    
        if ($equipo==1) {
            $horaTxt=horaactual();
            $FechaTxt=fechaactualbd();
            $datetime=$FechaTxt.' '.$horaTxt;
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 8 */ UPDATE p2juegos  
    SET pichee1p2=%s			
    WHERE 
    iniciodtp2 > %s AND
    codWiningBet=%s",
                GetSQLValueString($matches10px, "text"),
                GetSQLValueString($FechaTxt.' 00:00:01', "date"),
                GetSQLValueString($todox, "int")
            );
            // $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or trigger_error("Query Failed! SQL: $insertSQL1 - Error: ".mysqli_error($conexionbanca), E_USER_ERROR);
        }
        if ($equipo==2) {
            $horaTxt=horaactual();
            $FechaTxt=fechaactualbd();
            $datetime=$FechaTxt.' '.$horaTxt;
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 9 */ UPDATE p2juegos  
    SET pichee2p2=%s			
    WHERE 
    iniciodtp2 > %s AND
    codWiningBet=%s",
    
                GetSQLValueString($matches10px, "text"),
                GetSQLValueString($FechaTxt.' 00:00:01', "date"),
                GetSQLValueString($todox, "int")
            );
            //$Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or trigger_error("Query Failed! SQL: $insertSQL1 - Error: ".mysqli_error($conexionbanca), E_USER_ERROR);
        }
    }
    function updatelogro($todolo1, $todolo2, $Id_p3logrosp3, $tipojugadap7, $equipop7, $Id_p1equiposp7, $idjuegop7)
    {
        global $conexionbanca;
    
        $query_Recordset1logros = sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 10 */ SELECT actxp3
            FROM  p3logros
            WHERE Id_p3logrosp3=%s ",
            GetSQLValueString($Id_p3logrosp3, "int"));
            $Recordset1logros =mysqli_query($conexionbanca, $query_Recordset1logros) or die(mysqli_error($conexionbanca));
            $row_Recordset1logros = mysqli_fetch_assoc($Recordset1logros);
            $totalRows_Recordset1logros = mysqli_num_rows($Recordset1logros);

            if($row_Recordset1logros['actxp3']==55){}else{


        $horaTxt=horaactual();
        $FechaTxt=fechaactualbd();
        $datetime=$FechaTxt.' '.$horaTxt;
        $insertSQL1 = sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 11 */ UPDATE p3logros 
          SET logrop3=%s, logroABoRLp3=%s		
          WHERE 
          logrodtp3>%s AND
          Id_p3logrosp3=%s",
         
            GetSQLValueString($todolo1, "text"),
            GetSQLValueString($todolo2, "text"),
            GetSQLValueString($FechaTxt.' 00:00:01', "date"),
            GetSQLValueString($Id_p3logrosp3, "int")
        );
    
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
    
    
    
          $insertSQL = sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 12 */ INSERT 
        INTO p7histolg
        (idjuegop7, Id_p1equiposp7, tipojugadap7, logrop7, equipop7, logroABoRLp7, actxp7) 
        VALUES (%s, %s, %s, %s, %s, %s, %s)",
        
        GetSQLValueString($idjuegop7, "int"),
        GetSQLValueString($Id_p1equiposp7, "int"),
        GetSQLValueString($tipojugadap7, "text"),
        GetSQLValueString($todolo1, "text"),
        GetSQLValueString($equipop7, "int"),
        GetSQLValueString($todolo2, "text"),
        GetSQLValueString(0, "int")
        );
        
        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    
    }
    
    }
    function insertlogro($Id_p2juegosp2in, $Id_p1equiposp1in, $equipoin, $todoin1, $todoin2, $datetimein, $todoin3)
    {
        global $conexionbanca;
    
        $horaTxt=horaactual();
        $FechaTxt=fechaactualbd();
        $datetime=$FechaTxt.' '.$horaTxt;
        $insertSQL = sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 13 */ INSERT 
    INTO p3logros
    (idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
    VALUES (%s, %s, %s, %s, %s, %s, %s)",
            GetSQLValueString($Id_p2juegosp2in, "int"),
            GetSQLValueString($Id_p1equiposp1in, "int"),
            GetSQLValueString($equipoin, "int"),
            GetSQLValueString($todoin1, "text"),
            GetSQLValueString($todoin2, "text"),
            GetSQLValueString($datetimein, "date"),
            GetSQLValueString($todoin3, "text")
        );
    
        $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    
        $insertSQL = sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 14 */ INSERT 
        INTO p7histolg
        (idjuegop7, Id_p1equiposp7, tipojugadap7, logrop7, equipop7, logroABoRLp7, actxp7) 
        VALUES (%s, %s, %s, %s, %s, %s, %s)",
        
        GetSQLValueString($Id_p2juegosp2in, "int"),
        GetSQLValueString($Id_p1equiposp1in, "int"),
        GetSQLValueString($todoin1, "text"),
        GetSQLValueString($todoin2, "text"),
        GetSQLValueString($equipoin, "int"),
        GetSQLValueString($todoin3, "text"),
        GetSQLValueString(0, "int")
        );
        
        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    } 
    
    
    }else { //aqui inicia 10
    
    
        function verificarjuego($codWiningBet, $horajuego, $ep1, $ep2)
        {
            global $conexionbanca;
            $yaestaequipo1cod=$ep1;
            $yaestaequipo2cod=$ep2;
            $horaTxt=horaactual();
            $FechaTxt=fechaactualbd();
            $datetime=$FechaTxt.' '.$horaTxt;
            $query_Recordset1 = sprintf(
                "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 15 */ SELECT Id_p2juegosp2, idequipo1p2, idequipo2p2, pichee1p2, pichee2p2, codWiningBet_empate
            FROM p10juegos 
            WHERE  
            iniciodtp2 > %s AND
            codWiningBet = %s ",
                GetSQLValueString($FechaTxt.' 00:00:01', "date"),
                GetSQLValueString($codWiningBet, "int")
            );
            $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
            $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
            $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
            $totaltotalRows=$totalRows_Recordset1;
            $Id_p2juegosp2=$row_Recordset1['Id_p2juegosp2'];
            $idequipo1p2=$row_Recordset1['idequipo1p2'];
            $idequipo2p2=$row_Recordset1['idequipo2p2'];
            $pichee1p2=$row_Recordset1['pichee1p2'];
            $pichee2p2=$row_Recordset1['pichee2p2'];
            $codWiningBet_empate=$row_Recordset1['codWiningBet_empate'];
        
        
        
        
        
        if($totalRows_Recordset1>0)
        {
        
        
        
        
        
            $updateSQL = sprintf("/* PARSEADORES1 new\logros\WiningBet.php - QUERY 16 */ UPDATE p10juegos SET p2vecesactualizado=p2vecesactualizado+1, iniciodtp2 = %s
            WHERE  
            iniciodtp2 > %s AND
            codWiningBet = %s AND
            Id_p2juegosp2 = %s ",
            GetSQLValueString($horajuego, "date"),
            GetSQLValueString($FechaTxt.' 00:00:01', "date"),
            GetSQLValueString($codWiningBet, "int"),
            GetSQLValueString($Id_p2juegosp2, "int"));
            $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));
        
        }
        
        
            return array($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2, $codWiningBet_empate);
        }
        
        
        //estoy aqui un error p6 esta tomando la tabla que no es
        function verificarlogro($Id_p2juegosp2, $equipo, $tipol, $logrosarray)
        {
            $palabra_a_buscar  = $Id_p2juegosp2;
        
            foreach ($logrosarray as $clave=>$valor) {
        
                $indice = array_search($palabra_a_buscar, $valor);
                if ($valor["idjuegop3"]==$Id_p2juegosp2 & $valor["equipop3"]==$equipo & $valor["tipojugadap3"]==$tipol) {
                    //echo 'ejecutando funcion<br>';
        
                    if ($indice) {
                        $logro=$valor['logrop3'];
                        $Id_p3logros=$valor['Id_p3logrosp3'];
                        $logroABoRL=$valor['logroABoRLp3'];
                        $equipop3=$valor['equipop3'];
                        //echo $Id_p3logros.' - '.$logro.' - '.$logroABoRL.' - '.$equipop3.' - logro<br>';
        
                    }
                    return array($Id_p3logros, $logro, $logroABoRL, $equipop3);
                }
            }

        
          //  return array($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3);
        }
        //list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $tlarray);
        
        //list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $tlarray);
        
        
        function updatepiche($matches10px, $todox, $equipo)
        {
            global $conexionbanca;
        
            if ($equipo==1) {
                $horaTxt=horaactual();
                $FechaTxt=fechaactualbd();
                $datetime=$FechaTxt.' '.$horaTxt;
                $insertSQL1 = sprintf(
                    "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 17 */ UPDATE p10juegos  
        SET pichee1p2=%s			
        WHERE 
        iniciodtp2 > %s AND
        codWiningBet=%s",
                    GetSQLValueString($matches10px, "text"),
                    GetSQLValueString($FechaTxt.' 00:00:01', "date"),
                    GetSQLValueString($todox, "int")
                );
                // $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                $Result1 = mysqli_query($conexionbanca, $insertSQL1) or trigger_error("Query Failed! SQL: $insertSQL1 - Error: ".mysqli_error($conexionbanca), E_USER_ERROR);
            }
            if ($equipo==2) {
                $horaTxt=horaactual();
                $FechaTxt=fechaactualbd();
                $datetime=$FechaTxt.' '.$horaTxt;
                $insertSQL1 = sprintf(
                    "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 18 */ UPDATE p10juegos  
        SET pichee2p2=%s			
        WHERE 
        iniciodtp2 > %s AND
        codWiningBet=%s",
        
                    GetSQLValueString($matches10px, "text"),
                    GetSQLValueString($FechaTxt.' 00:00:01', "date"),
                    GetSQLValueString($todox, "int")
                );
                //$Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                $Result1 = mysqli_query($conexionbanca, $insertSQL1) or trigger_error("Query Failed! SQL: $insertSQL1 - Error: ".mysqli_error($conexionbanca), E_USER_ERROR);
            }
        }
        function updatelogro($todolo1, $todolo2, $Id_p3logrosp3, $tipojugadap7, $equipop7, $Id_p1equiposp7, $idjuegop7)
        {
            global $conexionbanca;
        
            $horaTxt=horaactual();
            $FechaTxt=fechaactualbd();
            $datetime=$FechaTxt.' '.$horaTxt;
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 19 */ UPDATE p10logros 
              SET logrop3=%s, logroABoRLp3=%s		
              WHERE 
              logrodtp3>%s AND
              Id_p3logrosp3=%s",
             
                GetSQLValueString($todolo1, "text"),
                GetSQLValueString($todolo2, "text"),
                GetSQLValueString($FechaTxt.' 00:00:01', "date"),
                GetSQLValueString($Id_p3logrosp3, "int")
            );
        
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
        
        
        
              $insertSQL = sprintf(
                "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 20 */ INSERT 
            INTO p7histolg
            (idjuegop7, Id_p1equiposp7, tipojugadap7, logrop7, equipop7, logroABoRLp7, actxp7) 
            VALUES (%s, %s, %s, %s, %s, %s, %s)",
            
            GetSQLValueString($idjuegop7, "int"),
            GetSQLValueString($Id_p1equiposp7, "int"),
            GetSQLValueString($tipojugadap7, "text"),
            GetSQLValueString($todolo1, "text"),
            GetSQLValueString($equipop7, "int"),
            GetSQLValueString($todolo2, "text"),
            GetSQLValueString(0, "int")
            );
            
            $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        
        
        
        }
        function insertlogro($Id_p2juegosp2in, $Id_p1equiposp1in, $equipoin, $todoin1, $todoin2, $datetimein, $todoin3)
        {
            global $conexionbanca;
        
            $horaTxt=horaactual();
            $FechaTxt=fechaactualbd();
            $datetime=$FechaTxt.' '.$horaTxt;
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 21 */ INSERT 
        INTO p10logros
        (idjuegop3, Id_p1equiposp3, equipop3, tipojugadap3, logrop3, logrodtp3, logroABoRLp3) 
        VALUES (%s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($Id_p2juegosp2in, "int"),
                GetSQLValueString($Id_p1equiposp1in, "int"),
                GetSQLValueString($equipoin, "int"),
                GetSQLValueString($todoin1, "text"),
                GetSQLValueString($todoin2, "text"),
                GetSQLValueString($datetimein, "date"),
                GetSQLValueString($todoin3, "text")
            );
        
            $Result111 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 22 */ INSERT 
            INTO p7histolg
            (idjuegop7, Id_p1equiposp7, tipojugadap7, logrop7, equipop7, logroABoRLp7, actxp7) 
            VALUES (%s, %s, %s, %s, %s, %s, %s)",
            
            GetSQLValueString($Id_p2juegosp2in, "int"),
            GetSQLValueString($Id_p1equiposp1in, "int"),
            GetSQLValueString($todoin1, "text"),
            GetSQLValueString($todoin2, "text"),
            GetSQLValueString($equipoin, "int"),
            GetSQLValueString($todoin3, "text"),
            GetSQLValueString(0, "int")
            );
            
            $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        } 
    
    
    
    }

//fin de funciones
//inicio array






if($row_Recordset18D['Swicht']==0){
    $query_RecordsetLG =  sprintf(
        "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 23 */ SELECT
      Id_p3logrosp3, idjuegop3, equipop3, tipojugadap3, logroABoRLp3, logrop3
      FROM  
      p3logros
      WHERE logrodtp3 >= %s AND Id_p3logrosp3 >= 0 ORDER BY Id_p3logrosp3 ASC",
      GetSQLValueString($FechaTxt.' 00:00:00', "date"));
    
    
    if ($resultLG = mysqli_query($conexionbanca, $query_RecordsetLG) or die(mysqli_error($conexionbanca))) {
        while ($rowLG = $resultLG->fetch_array()) {
            $logrosarray[] = $rowLG;
        }
        mysqli_free_result($resultLG);
    }
    
    
    $query_RecordsetAJ =  sprintf(
        "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 24 */ SELECT
      Id_p2juegosp2, idequipo1p2, idequipo2p2, deportep2, competicionp2, iniciodtp2, codWiningBet_empate, codWiningBet, pichee1p2, pichee2p2
      FROM  
      p2juegos
      WHERE 
      iniciodtp2 >= %s  ORDER BY Id_p2juegosp2 ASC",
      GetSQLValueString($FechaTxt.' 00:00:00', "date"));
    
    
    if ($resultAJ = mysqli_query($conexionbanca, $query_RecordsetAJ) or die(mysqli_error($conexionbanca))) {
        while ($rowAJ = $resultAJ->fetch_array()) {
            $juegosarray[] = $rowAJ;
        }
        mysqli_free_result($resultAJ);
    }
    
    }else{ //if($row_Recordset18D['Swicht']==0){
    
    
    
    
        $query_RecordsetLG =  sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 25 */ SELECT
          Id_p3logrosp3, idjuegop3, equipop3, tipojugadap3, logroABoRLp3, logrop3
          FROM  
          p10logros
          WHERE logrodtp3 >= %s AND Id_p3logrosp3 >= 0 ORDER BY Id_p3logrosp3 ASC",
          GetSQLValueString($FechaTxt.' 00:00:00', "date"));
        
        
        if ($resultLG = mysqli_query($conexionbanca, $query_RecordsetLG) or die(mysqli_error($conexionbanca))) {
            while ($rowLG = $resultLG->fetch_array()) {
                $logrosarray[] = $rowLG;
            }
            mysqli_free_result($resultLG);
        }
        
        
        $query_RecordsetAJ =  sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 26 */ SELECT
          Id_p2juegosp2, idequipo1p2, idequipo2p2, deportep2, competicionp2, iniciodtp2, codWiningBet_empate, codWiningBet, pichee1p2, pichee2p2
          FROM  
          p10juegos
          WHERE 
          iniciodtp2 >= %s  ORDER BY Id_p2juegosp2 ASC",
          GetSQLValueString($FechaTxt.' 00:00:00', "date"));
        
        
        if ($resultAJ = mysqli_query($conexionbanca, $query_RecordsetAJ) or die(mysqli_error($conexionbanca))) {
            while ($rowAJ = $resultAJ->fetch_array()) {
                $juegosarray[] = $rowAJ;
            }
            mysqli_free_result($resultAJ);
        }
        
    
    
    
    
    } //    }else{ //if($row_Recordset18D['Swicht']==0){
    

//fin array





$datoscurl='';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 7);
$datoscurl = curl_exec($ch);
curl_close($ch);

if(strlen($datoscurl)>1000){ $usourl=1; echo 'autosave.html<br>'; }else{ $usourl=2;  echo 'WiningBet.html<br>'; 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 7);
    $datoscurl = curl_exec($ch);
    curl_close($ch);

}

///*
if($usourl==1){
    $file = "autosave.html";
    if (!unlink($file)) {
    echo("Error deleting $file").'<br>';
    } else {
    echo("Deleted $file").'<br>';
    
    
    
    
    }}
    if($usourl==2){
    $file = "WiningBet.html";
    if (!unlink($file)) {
    echo("Error deleting $file").'<br>';
    } else {
    echo("Deleted $file").'<br>';
    
    
    
    
    }}
//*/
$comdatoscurl=$datoscurl; //este curl es para que se agreguen las competiciones




$datoscurl=preg_replace('/\s+/', '.ZZ.', $datoscurl);
$datoscurl=str_replace(')', 'ZZ', $datoscurl);
$datoscurl=str_replace('(', 'ZZ', $datoscurl); 
$borrardecurl=array(";", "=", "<", ">", "\\", "{", "}", "[", "]" , "#" , "'" , '"' , "/");
$datoscurl=str_replace($borrardecurl, '', $datoscurl);
if(strpos($datoscurl, 'Ingresar.ZZ.al.ZZ.Sistema')){


    $msj="WiningBet esta deslogeado, POR FAVOR REVISAR VPS";
    $msjx=utf8_encode($msj);
    $post=[
    'chat_id'=>-214345883,
    'text'=>$msjx,
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot5335385470:AAE0nAUC8c7ZDTPR3UPofIylv6TbkMsXGr8/sendMessage");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_exec ($ch);
    curl_close ($ch);

}
$datoscurl=str_replace('.WiningBet_filesfut', 'assetsparlaydeportesfut', $datoscurl);
$datoscurl=str_replace('.WiningBet_filesnba', 'assetsparlaydeportesnba', $datoscurl);
$datoscurl=str_replace('.WiningBet_filesmlb', 'assetsparlaydeportesmlb', $datoscurl);
$datoscurl=str_replace('.WiningBet_filesnhl', 'assetsparlaydeportesnhl', $datoscurl);
$datoscurl=str_replace('.WiningBet_filesnfl', 'assetsparlaydeportesnfl', $datoscurl);
$datoscurl=str_replace('.WiningBet_fileshome', 'assetsparlayhome', $datoscurl);

$datoscurl=str_replace('.am_filesfut', 'assetsparlaydeportesfut', $datoscurl);
$datoscurl=str_replace('.am_filesnba', 'assetsparlaydeportesnba', $datoscurl);
$datoscurl=str_replace('.am_filesmlb', 'assetsparlaydeportesmlb', $datoscurl);
$datoscurl=str_replace('.am_filesnhl', 'assetsparlaydeportesnhl', $datoscurl);
$datoscurl=str_replace('.am_filesnfl', 'assetsparlaydeportesnfl', $datoscurl);
$datoscurl=str_replace('.am_fileshome', 'assetsparlayhome', $datoscurl);
//echo $datoscurl;
if(strpos($datoscurl, 'Plataforma')){ 
    $updateSQL = sprintf("/* PARSEADORES1 new\logros\WiningBet.php - QUERY 27 */ UPDATE alertas SET contadoralerta=contadoralerta+1, fec_alerta=%s, hor_alerta=%s , contadorfallos=0
    WHERE idalertas=%s",
    GetSQLValueString($FechaTxt, "date"),
    GetSQLValueString($horaTxt, "date"),
    GetSQLValueString(7, "int"));
    $Result1 = mysqli_query($conexionbanca, $updateSQL) or die(mysqli_error($conexionbanca));

}
if(strpos($datoscurl, $FechaTxt)){ 
$datoscurl=explode($FechaTxt, $datoscurl);
$juegos=0; 






foreach ($datoscurl as $datoscurl2) { if(strpos($datoscurl2, 'VsOddsVS')) {// $juegos++;   echo '# '.$juegos;
//if(strlen($datoscurl2)==1767){ echo  $datoscurl2;    } //solo lo usea para qeu se imprima el jeugo que tenga de largo xxxx para poder ver que tiene
//echo $datoscurl2.'<br><br><br><br><br><br>';
echo 'vuelta<br>';

//assetsparlaydeportesmlb.png
if(strpos($datoscurl2, '2.ZZ.img.ZZ.srcassetsparlaydeportesmlb')){ echo ' Beisbol '; $ja++;

  //echo $datoscurl2.'<br><br><br><br><br><br>';
    //preg_match_all("(brspanclassVsOddsVSspanbr(.*)tdtdtableclasstext-leftstyleborder:nonecellspacing0cellpadding0tbodytrstyleborder:nonetdrowspan2styleborder:noneimgsrcassetsparlaydeportesmlb.pngclassimg-responsiveimgLogowidth30height30tdtdstyleborder:noneb(.*)btdtrtrtdstyleborder:none(.*)tdtrtbodytabletdtdclasstdsmlb(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtdclasstdsmlb(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtdclasstdsmlb(.*)tdtdclasstdsmlb(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtrtr(.*)tableclasstext-leftcellspacing0cellpadding0styleborder:nonetbodytrtdstyleborder:nonerowspan2imgsrcassetsparlaydeportesmlb.pngclassimg-responsiveimgLogowidth30height30tdtdstyleborder:noneb(.*)btdtrtrtdstyleborder:none(.*)imgsrcassetsparlayhome.pngclassimg-responsivewidth10height10tdtrtbodytabletdtdclasstdsmlb(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtdclasstdsmlb(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtdclasstdsmlb(.*)tdtdclasstdsmlb(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtr(.*))siU", $datoscurl2, $datoscurl3);
      preg_match_all("(brspan.ZZ.classVsOddsVSspanbr(.*)td.ZZ.td.ZZ.table.ZZ.classtext-left.ZZ.styleborder:.ZZ.none.ZZ.cellspacing0.ZZ.cellpadding0.ZZ.tbodytr.ZZ.styleborder:.ZZ.none.ZZ.td.ZZ.rowspan2.ZZ.styleborder:.ZZ.none.ZZ.img.ZZ.srcassetsparlaydeportesmlb.png.ZZ.classimg-responsive.ZZ.imgLogo.ZZ.width30.ZZ.height30.ZZ.td.ZZ.td.ZZ.styleborder:.ZZ.noneb(.*)btd.ZZ.tr.ZZ.tr.ZZ.td.ZZ.styleborder:.ZZ.none(.*).ZZ.(.*)td.ZZ.tr.ZZ.tbodytable.ZZ.td.ZZ.td.ZZ.classtdsmlb.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtdsmlb.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtdsmlb.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtdsmlb.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtdsmlb.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtdsmlb.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtdsmlb.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtdsmlb.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtdsmlb.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtdsmlb.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.tr.ZZ.tr(.*)table.ZZ.classtext-left.ZZ.cellspacing0.ZZ.cellpadding0.ZZ.styleborder:.ZZ.none.ZZ.tbodytr.ZZ.td.ZZ.styleborder:.ZZ.none.ZZ.rowspan2.ZZ.img.ZZ.srcassetsparlaydeportesmlb.png.ZZ.classimg-responsive.ZZ.imgLogo.ZZ.width30.ZZ.height30.ZZ.td.ZZ.td.ZZ.styleborder:.ZZ.noneb(.*)btd.ZZ.tr.ZZ.tr.ZZ.td.ZZ.styleborder:.ZZ.none(.*)img.ZZ.srcassetsparlayhome.png.ZZ.classimg-responsive.ZZ.width10.ZZ.height10td.ZZ.tr.ZZ.tbodytable.ZZ.td.ZZ.td.ZZ.classtdsmlb.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtdsmlb.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtdsmlb.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtdsmlb.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtdsmlb.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtdsmlb.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtdsmlb.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtdsmlb.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtdsmlb.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtdsmlb.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.tr(.*))siU", $datoscurl2, $datoscurl3);


 $codWiningBet=preg_replace('/[A-Za-z.]+/', '', $datoscurl3[3][0]);
    $e1=preg_replace('/\B([A-Z])/', ' $1', $datoscurl3[2][0]);
    $e1=str_replace('.ZZ.', ' ', $e1);
    $e1=str_replace('.Z Z.', ' ', $e1);


    $e2=preg_replace('/\B([A-Z])/', ' $1', $datoscurl3[22][0]);
    $e2=str_replace('.ZZ.', ' ', $e2);
    $e2=str_replace('.Z Z.', ' ', $e2);


    $p1=preg_replace('/[0-9]+/', '', $datoscurl3[4][0]);
$p1=str_replace('.ZZ.', ' ', $p1);
$p1=str_replace('.Z Z.', ' ', $p1);
    $p2=preg_replace('/[0-9]+/', '', $datoscurl3[23][0]);
$p2=str_replace('.ZZ.', ' ', $p2);
$p2=str_replace('.Z Z.', ' ', $p2);

    echo ' HORA='.$datoscurl3[1][0];
   echo '<br>e1='.$e1.' cod='.$codWiningBet.' p1='.$p1.' ml1='.$datoscurl3[5][0].' av1='.$datoscurl3[6][0].' al1='.$datoscurl3[7][0].' rlv1='.$datoscurl3[8][0].' rll1='.$datoscurl3[9][0].' srv1='.$datoscurl3[10][0].' srl1='.$datoscurl3[11][0].' ml15='.$datoscurl3[12][0].' av15='.$datoscurl3[13][0].' al15='.$datoscurl3[14][0].' rlv15='.$datoscurl3[15][0].' rll15='.$datoscurl3[16][0].' ap1='.$datoscurl3[17][0].' s='.$datoscurl3[18][0].' agv='.$datoscurl3[19][0].' agl='.$datoscurl3[20][0];                       
  echo '<br>e2='.$e2.' p1='.$p2.' ml2='.$datoscurl3[24][0].' av2='.$datoscurl3[25][0].' al2='.$datoscurl3[26][0].' rlv2='.$datoscurl3[27][0].' rll2='.$datoscurl3[28][0].' srv2='.$datoscurl3[29][0].' srl2='.$datoscurl3[30][0].' ml25='.$datoscurl3[31][0].' av25='.$datoscurl3[32][0].' al25='.$datoscurl3[33][0].' rlv25='.$datoscurl3[34][0].' rll25='.$datoscurl3[35][0].' ap2='.$datoscurl3[36][0].' n='.$datoscurl3[37][0].' bgv='.$datoscurl3[38][0].' bgl='.$datoscurl3[39][0].'<br>';

  $codWiningBetArray[] = array('codWiningBetEsta' => $codWiningBet);
///*


  $query_Recordset21 = sprintf(
    "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 28 */ SELECT Id_p1equiposp1
FROM p1equipos
WHERE  
nomwinningbet = %s AND deportep1 = %s",
GetSQLValueString($e1, "text"),
GetSQLValueString(0, "int"));
$Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
$row_Recordset21 = mysqli_fetch_assoc($Recordset21);
$totalRows_Recordset21 = mysqli_num_rows($Recordset21);

if ($totalRows_Recordset21==0) {
    echo "se creo equipo de  beisbol";
    echo " . . .";
    $insertSQL = sprintf(
        "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 29 */ INSERT 
INTO p1equipos
(nomequipop1, nomdimp1, nomwinningbet, deportep1, ordenp1) 
VALUES (%s, %s, %s, %s, %s)",
        GetSQLValueString($e1, "text"),
        GetSQLValueString($e1, "text"),
        GetSQLValueString($e1, "text"),
        GetSQLValueString(0, "int"),
        GetSQLValueString(0, "int")
    );

    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    $query_Recordset21 = sprintf(
        "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 30 */ SELECT Id_p1equiposp1
FROM p1equipos
WHERE  
nomwinningbet = %s",
        GetSQLValueString($e1, "text")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
}









$query_Recordset22 = sprintf(
  "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 31 */ SELECT Id_p1equiposp1
FROM p1equipos
WHERE  
nomwinningbet = %s AND deportep1 = %s",
GetSQLValueString($e2, "text"),
GetSQLValueString(0, "int"));
$Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
$row_Recordset22 = mysqli_fetch_assoc($Recordset22);
$totalRows_Recordset22 = mysqli_num_rows($Recordset22);

if ($totalRows_Recordset22==0) {
  echo "se creo equipo de  beisbol";
  echo " . . .";
  $insertSQL = sprintf(
      "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 32 */ INSERT 
INTO p1equipos
(nomequipop1, nomdimp1, nomwinningbet, deportep1, ordenp1) 
VALUES (%s, %s, %s, %s, %s)",
      GetSQLValueString($e2, "text"),
      GetSQLValueString($e2, "text"),
      GetSQLValueString($e2, "text"),
      GetSQLValueString(0, "int"),
      GetSQLValueString(0, "int")
  );

  $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
  $query_Recordset22 = sprintf(
      "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 33 */ SELECT Id_p1equiposp1
FROM p1equipos
WHERE  
nomwinningbet = %s",
      GetSQLValueString($e2, "text")
  );
  $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
  $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
  $totalRows_Recordset22 = mysqli_num_rows($Recordset22);
}








$horajuego =$FechaTxt.' '.$datoscurl3[1][0];
$horajuego = strtotime('-6 hour', strtotime($horajuego));
$horajuego = date('Y-m-d H:i:s', $horajuego);

list($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2)=verificarjuego($codWiningBet, $horajuego, $row_Recordset21['Id_p1equiposp1'], $row_Recordset22['Id_p1equiposp1']);

if ($totaltotalRows==0) {
    echo $totaltotalRows."juego no exicte es beisbol y se creara".$codWiningBet;
    echo " . . .";
    if ($totaltotalRows==0) {


        if($row_Recordset18D['Swicht']==0){
        $insertSQL = sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 34 */ INSERT 
INTO p2juegos
(idequipo1p2, idequipo2p2, deportep2, codWiningBet, iniciodtp2, jexterno) 
VALUES (%s, %s, %s, %s, %s, %s)",
            GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
            GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
            GetSQLValueString("beisbol", "text"),
            GetSQLValueString($codWiningBet, "int"),
            GetSQLValueString($horajuego, "date"),
            GetSQLValueString(0, "int")
        );

        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    }else{


        $insertSQL = sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 35 */ INSERT 
INTO p10juegos
(idequipo1p2, idequipo2p2, deportep2, codWiningBet, iniciodtp2, jexterno) 
VALUES (%s, %s, %s, %s, %s, %s)",
            GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
            GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
            GetSQLValueString("beisbol", "text"),
            GetSQLValueString($codWiningBet, "int"),
            GetSQLValueString($horajuego, "date"),
            GetSQLValueString(0, "int")
        );

        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));



    }
        list($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2)=verificarjuego($codWiningBet, $horajuego, $row_Recordset21['Id_p1equiposp1'], $row_Recordset22['Id_p1equiposp1']);
   
   
   
   
   
   
   
   
    }
}

updatepiche($p1, $codWiningBet, 1);
updatepiche($p2, $codWiningBet, 2);

//estoy aqui agregando ml con verificacion con array
//$logrosarray
$tipojugada="ML"; //besisbol
//list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada);
//list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);
//echo $Id_p3logrosp3.' - '.$logrop3.' - '.$logroABoRLp3.' - '.$equipop3.' - logro<br><br><br><br>';


if($JuegosQEstan==','){ $JuegosQEstan=$Id_p2juegosp2; }else{$JuegosQEstan=','.$JuegosQEstan.','.$Id_p2juegosp2;}

$tipojugada="ML"; //besisbol
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);
$nov="";
if ($datoscurl3[5][0]<>$logrop3) { $la++;
  updatelogro($datoscurl3[5][0], $nov, $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
   //echo ' - se actualizara logro logro<br>';

} if ($Id_p3logrosp3=="") {
    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[5][0], $horajuego, $nov);
    //echo ' - se creara logro<br>';

}
$tipojugada="ML"; //besisbol
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);
$nov="";
if ($datoscurl3[24][0]<>$logrop3) { $la++;
   updatelogro($datoscurl3[24][0], $nov, $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
   //echo ' - se actualizara logro logro<br>';

} if ($Id_p3logrosp3=="") {
   insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[24][0], $horajuego, $nov);
    //echo ' - se creara logro<br>';

}
$tipojugada="5ML"; //besisbol
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);
$nov="";
if ($datoscurl3[12][0]<>$logrop3) { $la++;
   updatelogro($datoscurl3[12][0], $nov, $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
}
if ($Id_p3logrosp3=="") {
    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[12][0], $horajuego, $nov);
}
$tipojugada="5ML"; //besisbol
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);
$nov="";
if ($datoscurl3[31][0]<>$logrop3) { $la++;
   updatelogro($datoscurl3[31][0], $nov, $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
}
if ($Id_p3logrosp3=="") {
  insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[31][0], $horajuego, $nov);
}



$tipojugada="A"; //besisbol
    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);

    if ($datoscurl3[7][0]<>$logrop3 OR $datoscurl3[6][0]<>$logroABoRLp3) { $la++;
                updatelogro($datoscurl3[7][0], $datoscurl3[6][0], $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
            } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[7][0], $horajuego, $datoscurl3[6][0]);
    }
$tipojugada="B"; //besisbol
    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);

    if ($datoscurl3[26][0]<>$logrop3 OR $datoscurl3[25][0]<>$logroABoRLp3) { $la++;
                updatelogro($datoscurl3[26][0], $datoscurl3[25][0], $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
            } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[26][0], $horajuego, $datoscurl3[25][0]);
    }
$tipojugada="5A"; //besisbol
    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
    verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);

    if ($datoscurl3[14][0]<>$logrop3 OR $datoscurl3[13][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[14][0], $datoscurl3[13][0], $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
    } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[14][0], $horajuego, $datoscurl3[13][0]);
    }
$tipojugada="5B"; //besisbol

    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
    verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);

    if ($datoscurl3[33][0]<>$logrop3 OR $datoscurl3[32][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[33][0], $datoscurl3[32][0], $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
    } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[33][0], $horajuego, $datoscurl3[32][0]);
    }
$agltipo="AG"; //besisbol
    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
    verificarlogro($Id_p2juegosp2, 1, $agltipo, $logrosarray);

    if ($datoscurl3[20][0]<>$logrop3 OR $datoscurl3[19][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[20][0], $datoscurl3[19][0], $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
    } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $agltipo, $datoscurl3[20][0], $horajuego, $datoscurl3[19][0]);
    }
    $agltipo="BG"; //besisbol
        list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
        verificarlogro($Id_p2juegosp2, 2, $agltipo, $logrosarray);
  
        if ($datoscurl3[39][0]<>$logrop3 OR $datoscurl3[38][0]<>$logroABoRLp3) { $la++;
            updatelogro($datoscurl3[39][0], $datoscurl3[38][0], $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
        } if ($Id_p3logrosp3=="") {
            insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $agltipo, $datoscurl3[39][0], $horajuego, $datoscurl3[38][0]);
        }




$tipojugada="RL"; //besisbol
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);

if ($datoscurl3[9][0]<>$logrop3 OR $datoscurl3[8][0]<>$logroABoRLp3) { $la++;
    updatelogro($datoscurl3[9][0], $datoscurl3[8][0], $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[9][0], $horajuego, $datoscurl3[8][0]);
}
$tipojugada="RL"; //besisbol
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);

if ($datoscurl3[28][0]<>$logrop3 OR $datoscurl3[27][0]<>$logroABoRLp3) { $la++;
    updatelogro($datoscurl3[28][0], $datoscurl3[27][0], $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
    insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[28][0], $horajuego, $datoscurl3[27][0]);
}
$tipojugada="SRL"; //besisbol
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);

if ($datoscurl3[11][0]<>$logrop3 OR $datoscurl3[10][0]<>$logroABoRLp3) { $la++;
    updatelogro($datoscurl3[11][0], $datoscurl3[10][0], $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[11][0], $horajuego, $datoscurl3[10][0]);
}
$tipojugada="SRL"; //besisbol
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);

if ($datoscurl3[30][0]<>$logrop3 OR $datoscurl3[29][0]<>$logroABoRLp3) { $la++;
    updatelogro($datoscurl3[30][0], $datoscurl3[29][0], $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
    insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[30][0], $horajuego, $datoscurl3[29][0]);
}
$tipojugada="5RL"; //besisbol
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);

if ($datoscurl3[16][0]<>$logrop3 OR $datoscurl3[15][0]<>$logroABoRLp3) { $la++;
    updatelogro($datoscurl3[16][0], $datoscurl3[15][0], $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[16][0], $horajuego, $datoscurl3[15][0]);
}
$tipojugada="5RL"; //besisbol
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);

if ($datoscurl3[35][0]<>$logrop3 OR $datoscurl3[34][0]<>$logroABoRLp3) { $la++;
    updatelogro($datoscurl3[35][0], $datoscurl3[34][0], $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
    insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[35][0], $horajuego, $datoscurl3[34][0]);
}



$sitipo="SI"; //besisbol
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $sitipo, $logrosarray);
$nov="";
if ($datoscurl3[18][0]<>$logrop3) { $la++;
    updatelogro($datoscurl3[18][0], $nov, $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
  
    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $sitipo, $datoscurl3[18][0], $horajuego, $nov);
}
$notipo="NO"; //besisbol
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $notipo, $logrosarray);
$nov="";
if ($datoscurl3[37][0]<>$logrop3) { $la++;
    updatelogro($datoscurl3[37][0], $nov, $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
    insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $notipo, $datoscurl3[37][0], $horajuego, $nov);
}  
$ap2tipo="AP"; //besisbol
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $ap2tipo, $logrosarray);
$nov="";
if ($datoscurl3[17][0]<>$logrop3) { $la++;
    updatelogro($datoscurl3[17][0], $nov, $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
  
    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $ap2tipo, $datoscurl3[17][0], $horajuego, $nov);
}
$ap2tipo="AP"; //besisbol
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $ap2tipo, $logrosarray);
$nov="";
if ($datoscurl3[36][0]<>$logrop3) { $la++;
    updatelogro($datoscurl3[36][0], $nov, $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
  
    insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $ap2tipo, $datoscurl3[36][0], $horajuego, $nov);
}





}//fin de beisbol


if(strpos($datoscurl2, '2.ZZ.img.ZZ.srcassetsparlaydeportesfut')){ echo ' Futbol '; $ja++;
    //echo $datoscurl2;
    //preg_match_all("(brspanclassVsOddsVSspanbr(.*)tdtdtableclasstext-lefttbodytrtdstyleborder:nonerowspan2imgsrcassetsparlaydeportesfut.pngclassimg-responsiveimgLogowidth30height30tdtdstyleborder:noneb(.*)btdtrtrtdstyleborder:none(.*)tdtrtbodytabletdtdclasstds(.*)tdtdrowspan2classtds(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtdclasstds(.*)tdtdrowspan2classtds(.*)tdtrtr(.*)tdtableclasstext-lefttbodytrtdstyleborder:nonerowspan2imgsrcassetsparlaydeportesfut.pngclassimg-responsiveimgLogowidth30height30tdtdstyleborder:noneb(.*)btdtrtrtdstyleborder:none(.*)imgsrcassetsparlayhome.pngclassimg-responsivewidth10height10tdtrtbodytabletdtdclasstds(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtdclasstds(.*)tdtrt(.*))siU", $datoscurl2, $datoscurl3);
    preg_match_all("(brspan.ZZ.classVsOddsVSspanbr(.*)td.ZZ.td.ZZ.table.ZZ.classtext-left.ZZ.tbodytr.ZZ.td.ZZ.styleborder:.ZZ.none.ZZ.rowspan2.ZZ.img.ZZ.srcassetsparlaydeportesfut.png.ZZ.classimg-responsive.ZZ.imgLogo.ZZ.width30.ZZ.height30.ZZ.td.ZZ.td.ZZ.styleborder:.ZZ.noneb(.*)btd.ZZ.tr.ZZ.tr.ZZ.td.ZZ.styleborder:.ZZ.none(.*)td.ZZ.tr.ZZ.tbodytable.ZZ.td.ZZ.td.ZZ.classtds.ZZ.(.*).ZZ.td.ZZ.td.ZZ.rowspan2.ZZ.classtds.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.(.*).ZZ.td.ZZ.td.ZZ.rowspan2.ZZ.classtds.ZZ.(.*).ZZ.td.ZZ.tr.ZZ.tr.ZZ.(.*).ZZ.table.ZZ.classtext-left.ZZ.tbodytr.ZZ.td.ZZ.styleborder:.ZZ.none.ZZ.rowspan2.ZZ.img.ZZ.srcassetsparlaydeportesfut.png.ZZ.classimg-responsive.ZZ.imgLogo.ZZ.width30.ZZ.height30.ZZ.td.ZZ.td.ZZ.styleborder:.ZZ.noneb(.*)btd.ZZ.tr.ZZ.tr.ZZ.td.ZZ.styleborder:.ZZ.none(.*).ZZ.img.ZZ.srcassetsparlayhome.png.ZZ.classimg-responsive.ZZ.width10.ZZ.height10td.ZZ.tr.ZZ.tbodytable.ZZ.td.ZZ.td.ZZ.classtds.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.(.*).ZZ.td.ZZ.tr.ZZ.(.*))siU", $datoscurl2, $datoscurl3);
    $e1=str_replace('.ZZ.', ' ', $datoscurl3[2][0]);

    $e2=str_replace('.ZZ.', ' ', $datoscurl3[11][0]);

    echo ' HORA='.$datoscurl3[1][0];
  echo '<br>e1='.$e1.' cod='.$datoscurl3[3][0].' ml1='.$datoscurl3[4][0].' emp='.$datoscurl3[5][0].' av='.$datoscurl3[6][0].' al='.$datoscurl3[7][0].' ml15='.$datoscurl3[8][0].' emp5='.$datoscurl3[9][0]; 
  echo '<br>e2='.$e2.' ml2='.$datoscurl3[13][0].' bv='.$datoscurl3[14][0].' bl='.$datoscurl3[15][0].' ml25='.$datoscurl3[16][0].'<br><br>'; 


  $codWiningBetArray[] = array('codWiningBetEsta' => $datoscurl3[3][0]);


  $query_Recordset21 = sprintf(
    "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 36 */ SELECT Id_p1equiposp1
FROM p1equipos
WHERE  
nomwinningbet = %s AND deportep1 = %s",
GetSQLValueString($e1, "text"),
GetSQLValueString(2, "int"));
$Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
$row_Recordset21 = mysqli_fetch_assoc($Recordset21);
$totalRows_Recordset21 = mysqli_num_rows($Recordset21);

if ($totalRows_Recordset21==0) {
    echo "se creo equipo de  futbol";
    echo " . . .";
    $insertSQL = sprintf(
        "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 37 */ INSERT 
INTO p1equipos
(nomequipop1, nomdimp1, nomwinningbet, deportep1, ordenp1) 
VALUES (%s, %s, %s, %s, %s)",
        GetSQLValueString($e1, "text"),
        GetSQLValueString($e1, "text"),
        GetSQLValueString($e1, "text"),
        GetSQLValueString(2, "int"),
        GetSQLValueString(0, "int")
    );

    $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    $query_Recordset21 = sprintf(
        "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 38 */ SELECT Id_p1equiposp1
FROM p1equipos
WHERE  
nomwinningbet = %s",
        GetSQLValueString($e1, "text")
    );
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
}

$query_Recordset22 = sprintf(
  "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 39 */ SELECT Id_p1equiposp1
FROM p1equipos
WHERE  
nomwinningbet = %s AND deportep1 = %s",
GetSQLValueString($e2, "text"),
GetSQLValueString(2, "int"));
$Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
$row_Recordset22 = mysqli_fetch_assoc($Recordset22);
$totalRows_Recordset22 = mysqli_num_rows($Recordset22);

if ($totalRows_Recordset22==0) {
  echo "se creo equipo de  beisbol";
  echo " . . .";
  $insertSQL = sprintf(
      "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 40 */ INSERT 
INTO p1equipos
(nomequipop1, nomdimp1, nomwinningbet, deportep1, ordenp1) 
VALUES (%s, %s, %s, %s, %s)",
      GetSQLValueString($e2, "text"),
      GetSQLValueString($e2, "text"),
      GetSQLValueString($e2, "text"),
      GetSQLValueString(2, "int"),
      GetSQLValueString(0, "int")
  );

  $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
  $query_Recordset22 = sprintf(
      "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 41 */ SELECT Id_p1equiposp1
FROM p1equipos
WHERE  
nomwinningbet = %s",
      GetSQLValueString($e2, "text")
  );
  $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
  $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
  $totalRows_Recordset22 = mysqli_num_rows($Recordset22);
}

$horajuego =$FechaTxt.' '.$datoscurl3[1][0];
$horajuego = strtotime('-6 hour', strtotime($horajuego));
$horajuego = date('Y-m-d H:i:s', $horajuego);

list($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2)=verificarjuego($datoscurl3[3][0], $horajuego, $row_Recordset21['Id_p1equiposp1'], $row_Recordset22['Id_p1equiposp1']);

if ($totaltotalRows==0) {
    echo $totaltotalRows."juego no exicte es futbol y se creara".$datoscurl3[3][0];
    echo " . . .";
    if ($totaltotalRows==0) {




        if($row_Recordset18D['Swicht']==0){
        $insertSQL = sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 42 */ INSERT 
INTO p2juegos
(idequipo1p2, idequipo2p2, deportep2, codWiningBet, iniciodtp2) 
VALUES (%s, %s, %s, %s, %s)",
            GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
            GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
            GetSQLValueString("futbol", "text"),
            GetSQLValueString($datoscurl3[3][0], "int"),
            GetSQLValueString($horajuego, "date")
        );

        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
    }else{

        $insertSQL = sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 43 */ INSERT 
INTO p10juegos
(idequipo1p2, idequipo2p2, deportep2, codWiningBet, iniciodtp2) 
VALUES (%s, %s, %s, %s, %s)",
            GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
            GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
            GetSQLValueString("futbol", "text"),
            GetSQLValueString($datoscurl3[3][0], "int"),
            GetSQLValueString($horajuego, "date")
        );

        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));




    }
        list($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2)=verificarjuego($datoscurl3[3][0], $horajuego, $row_Recordset21['Id_p1equiposp1'], $row_Recordset22['Id_p1equiposp1']);
    }
}
if($JuegosQEstan==','){ $JuegosQEstan=$Id_p2juegosp2; }else{$JuegosQEstan=','.$JuegosQEstan.','.$Id_p2juegosp2;}

$tipojugada="ML"; //futbol
list($Id_p3logrosp3, $logrop3, $logroABoRLp3,  $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);
$nov="";
if ($datoscurl3[4][0]<>$logrop3) { $la++;
    updatelogro($datoscurl3[4][0], $nov, $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
  
    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[4][0], $horajuego, $nov);
}
$tipojugada="ML"; //futbol
list($Id_p3logrosp3, $logrop3, $logroABoRLp3,  $equipop3)=verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);
$nov="";
if ($datoscurl3[13][0]<>$logrop3) { $la++;
    updatelogro($datoscurl3[13][0], $nov, $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
  
    insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[13][0], $horajuego, $nov);
}
$tipojugada="5ML"; //futbol
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);
$nov="";
if ($datoscurl3[8][0]<>$logrop3) { $la++;
    updatelogro($datoscurl3[8][0], $nov, $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[8][0], $horajuego, $nov);
}
$tipojugada="5ML"; //futbol
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);
$nov="";
if ($datoscurl3[16][0]<>$logrop3) { $la++;
    updatelogro($datoscurl3[16][0], $nov, $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
    insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[16][0], $horajuego, $nov);
}

$tipojugada="A"; //futbol
    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);

    if ($datoscurl3[7][0]<>$logrop3 OR $datoscurl3[6][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[7][0], $datoscurl3[6][0], $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
    } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[7][0], $horajuego, $datoscurl3[6][0]);
    }
$tipojugada="B"; //futbol

    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);

    if ($datoscurl3[15][0]<>$logrop3 OR $datoscurl3[14][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[15][0], $datoscurl3[14][0], $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
    } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[15][0], $horajuego, $datoscurl3[14][0]);
    }
    




    $tipojugada="EML"; //futbol
    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
    verificarlogro($Id_p2juegosp2, 0, $tipojugada, $logrosarray);
    $nov="";
    if ($datoscurl3[5][0]<>$logrop3) { $la++;
        updatelogro($datoscurl3[5][0], $nov, $Id_p3logrosp3, $tipojugada, 0, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
    } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 0, $tipojugada, $datoscurl3[5][0], $horajuego, $nov);
    }
    $tipojugada="E5ML"; //futbol
    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
    verificarlogro($Id_p2juegosp2, 0, $tipojugada, $logrosarray);
    $nov="";
    if ($datoscurl3[9][0]<>$logrop3) { $la++;
        updatelogro($datoscurl3[9][0], $nov, $Id_p3logrosp3, $tipojugada, 0, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
    } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 0, $tipojugada, $datoscurl3[9][0], $horajuego, $nov);
    }











}//fin de futbol







if(strpos($datoscurl2, '2.ZZ.img.ZZ.srcassetsparlaydeportesnfl')){ echo ' futbol americano '; $ja++;
    //echo '<br><br><br>'.$datoscurl2.'<br><br><br>';
    //echo $datoscurl2;
    //preg_match_all("(brspanclassVsOddsVSspanbr(.*)tdtdtableclasstext-lefttbodytrtdstyleborder:nonerowspan2imgsrcassetsparlaydeportesnfl.pngclassimg-responsiveimgLogowidth30height30tdtdstyleborder:noneb(.*)btdtrtrtdstyleborder:none(.*)tdtrtbodytabletdtdclasstds(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtdclasstds(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtrtr(.*)tableclasstext-lefttbodytrtdstyleborder:nonerowspan2imgsrcassetsparlaydeportesnfl.pngclassimg-responsiveimgLogowidth30height30tdtdstyleborder:noneb(.*)btdtrtrtdstyleborder:none(.*)imgsrcassetsparlayhome.pngclassimg-responsivewidth10height10tdtrtbodytabletdtdclasstds(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtdclasstds(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtrt(.*))siU", $datoscurl2, $datoscurl3);

    preg_match_all("(brspan.ZZ.classVsOddsVSspanbr(.*)td.ZZ.td.ZZ.table.ZZ.classtext-left.ZZ.tbodytr.ZZ.td.ZZ.styleborder:.ZZ.none.ZZ.rowspan2.ZZ.img.ZZ.srcassetsparlaydeportesnfl.png.ZZ.classimg-responsive.ZZ.imgLogo.ZZ.width30.ZZ.height30.ZZ.td.ZZ.td.ZZ.styleborder:.ZZ.noneb(.*)btd.ZZ.tr.ZZ.tr.ZZ.td.ZZ.styleborder:.ZZ.none(.*)td.ZZ.tr.ZZ.tbodytable.ZZ.td.ZZ.td.ZZ.classtds.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.tr.ZZ.tr.ZZ.(.*).ZZ.table.ZZ.classtext-left.ZZ.tbodytr.ZZ.td.ZZ.styleborder:.ZZ.none.ZZ.rowspan2.ZZ.img.ZZ.srcassetsparlaydeportesnfl.png.ZZ.classimg-responsive.ZZ.imgLogo.ZZ.width30.ZZ.height30.ZZ.td.ZZ.td.ZZ.styleborder:.ZZ.noneb(.*)btd.ZZ.tr.ZZ.tr.ZZ.td.ZZ.styleborder:.ZZ.none(.*).ZZ.img.ZZ.srcassetsparlayhome.png.ZZ.classimg-responsive.ZZ.width10.ZZ.height10td.ZZ.tr.ZZ.tbodytable.ZZ.td.ZZ.td.ZZ.classtds.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.tr.ZZ.(.*))siU", $datoscurl2, $datoscurl3);
    
    $e1=str_replace('.ZZ.', ' ', $datoscurl3[2][0]);

    $e2=str_replace('.ZZ.', ' ', $datoscurl3[15][0]);
 
    echo ' HORA='.$datoscurl3[1][0];
    echo '<br>e1='.$e1.' cod='.$datoscurl3[3][0].' ml1='.$datoscurl3[4][0].' av='.$datoscurl3[5][0].' al='.$datoscurl3[6][0].' rlv1='.$datoscurl3[7][0].' rll1='.$datoscurl3[8][0].' ml15='.$datoscurl3[9][0].' av5='.$datoscurl3[10][0].' al5='.$datoscurl3[11][0].' rlv15='.$datoscurl3[12][0].' rll15='.$datoscurl3[13][0]; 
    echo '<br>e2='.$e2.' ml2='.$datoscurl3[17][0].' bv='.$datoscurl3[18][0].' bl='.$datoscurl3[19][0].' rlv2='.$datoscurl3[20][0].' rll2='.$datoscurl3[21][0].' ml25='.$datoscurl3[22][0].' bv5='.$datoscurl3[23][0].' bl5='.$datoscurl3[24][0].' rlv25='.$datoscurl3[25][0].' rll25='.$datoscurl3[26][0].'<br><br>';
    $codWiningBetArray[] = array('codWiningBetEsta' => $datoscurl3[3][0]);
   
   
    $query_Recordset21 = sprintf(
        "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 44 */ SELECT Id_p1equiposp1
    FROM p1equipos
    WHERE  
    nomwinningbet = %s AND deportep1 = %s",
    GetSQLValueString($e1, "text"),
    GetSQLValueString(4, "int"));
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
    
    if ($totalRows_Recordset21==0) {
        echo "se creo equipo de  futbolamericano";
        echo " . . .";
        $insertSQL = sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 45 */ INSERT 
    INTO p1equipos
    (nomequipop1, nomdimp1, nomwinningbet, deportep1, ordenp1) 
    VALUES (%s, %s, %s, %s, %s)",
            GetSQLValueString($e1, "text"),
            GetSQLValueString($e1, "text"),
            GetSQLValueString($e1, "text"),
            GetSQLValueString(4, "int"),
            GetSQLValueString(0, "int")
        );
    
        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $query_Recordset21 = sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 46 */ SELECT Id_p1equiposp1
    FROM p1equipos
    WHERE  
    nomwinningbet = %s",
            GetSQLValueString($e1, "text")
        );
        $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
        $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
        $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
    }
    
    $query_Recordset22 = sprintf(
      "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 47 */ SELECT Id_p1equiposp1
    FROM p1equipos
    WHERE  
    nomwinningbet = %s AND deportep1 = %s",
    GetSQLValueString($e2, "text"),
    GetSQLValueString(4, "int"));
    $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
    $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
    $totalRows_Recordset22 = mysqli_num_rows($Recordset22);
    
    if ($totalRows_Recordset22==0) {
      echo "se creo equipo de  futbolamericano";
      echo " . . .";
      $insertSQL = sprintf(
          "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 48 */ INSERT 
    INTO p1equipos
    (nomequipop1, nomdimp1, nomwinningbet, deportep1, ordenp1) 
    VALUES (%s, %s, %s, %s, %s)",
          GetSQLValueString($e2, "text"),
          GetSQLValueString($e2, "text"),
          GetSQLValueString($e2, "text"),
          GetSQLValueString(4, "int"),
          GetSQLValueString(0, "int")
      );
    
      $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
      $query_Recordset22 = sprintf(
          "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 49 */ SELECT Id_p1equiposp1
    FROM p1equipos
    WHERE  
    nomwinningbet = %s",
          GetSQLValueString($e2, "text")
      );
      $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
      $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
      $totalRows_Recordset22 = mysqli_num_rows($Recordset22);
    }
    
    $horajuego =$FechaTxt.' '.$datoscurl3[1][0];
    $horajuego = strtotime('-6 hour', strtotime($horajuego));
    $horajuego = date('Y-m-d H:i:s', $horajuego);
    
    list($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2)=verificarjuego($datoscurl3[3][0], $horajuego, $row_Recordset21['Id_p1equiposp1'], $row_Recordset22['Id_p1equiposp1']);
    
    if ($totaltotalRows==0) {
        echo $totaltotalRows."juego no exicte es futbolamericano y se creara".$datoscurl3[3][0];
        echo " . . .";
        if ($totaltotalRows==0) {



            if($row_Recordset18D['Swicht']==0){
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 50 */ INSERT 
    INTO p2juegos
    (idequipo1p2, idequipo2p2, deportep2, codWiningBet, iniciodtp2) 
    VALUES (%s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
                GetSQLValueString("futbolamericano", "text"),
                GetSQLValueString($datoscurl3[3][0], "int"),
                GetSQLValueString($horajuego, "date")
            );
    
            $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                }else{

        $insertSQL = sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 51 */ INSERT 
INTO p10juegos
(idequipo1p2, idequipo2p2, deportep2, codWiningBet, iniciodtp2) 
VALUES (%s, %s, %s, %s, %s)",
            GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
            GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
            GetSQLValueString("futbolamericano", "text"),
            GetSQLValueString($datoscurl3[3][0], "int"),
            GetSQLValueString($horajuego, "date")
        );

        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));




            }
            list($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2)=verificarjuego($datoscurl3[3][0], $horajuego, $row_Recordset21['Id_p1equiposp1'], $row_Recordset22['Id_p1equiposp1']);
        }
    }
    if($JuegosQEstan==','){ $JuegosQEstan=$Id_p2juegosp2; }else{$JuegosQEstan=','.$JuegosQEstan.','.$Id_p2juegosp2;}

    $tipojugada="ML"; //futbolamericano
list($Id_p3logrosp3, $logrop3, $logroABoRLp3,  $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);
$nov="";
    if ($datoscurl3[4][0]<>$logrop3) { $la++;
    updatelogro($datoscurl3[4][0], $nov, $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {

    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[4][0], $horajuego, $nov);
}
$tipojugada="ML"; //futbolamericano
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);
$nov="";
    if ($datoscurl3[17][0]<>$logrop3) { $la++;
    updatelogro($datoscurl3[17][0], $nov, $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
  
    insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[17][0], $horajuego, $nov);
}

$tipojugada="5ML"; //futbolamericano
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);
$nov="";
    if ($datoscurl3[9][0]<>$logrop3) { $la++;
    updatelogro($datoscurl3[9][0], $nov, $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[9][0], $horajuego, $nov);
}


$tipojugada="5ML"; //futbolamericano
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);
$nov="";
    if ($datoscurl3[22][0]<>$logrop3) { $la++;
    updatelogro($datoscurl3[22][0], $nov, $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
    insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[22][0], $horajuego, $nov);
}



$tipojugada="A"; //futbolamericano

    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);

    if ($datoscurl3[6][0]<>$logrop3 OR $datoscurl3[5][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[6][0], $datoscurl3[5][0], $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[6][0], $horajuego, $datoscurl3[5][0]);
    }


$tipojugada="B"; //futbolamericano

    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);

    if ($datoscurl3[19][0]<>$logrop3 OR $datoscurl3[18][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[19][0], $datoscurl3[18][0], $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[19][0], $horajuego, $datoscurl3[18][0]);
    }



    $tipojugada="RL"; //futbolamericano

    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);

    if ($datoscurl3[8][0]<>$logrop3 OR $datoscurl3[7][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[8][0], $datoscurl3[7][0], $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[8][0], $horajuego, $datoscurl3[7][0]);
    }


    $tipojugada="RL"; //futbolamericano

    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);

    if ($datoscurl3[21][0]<>$logrop3 OR $datoscurl3[20][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[21][0], $datoscurl3[20][0], $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[21][0], $horajuego, $datoscurl3[20][0]);
    }



    $tipojugada="5RL"; //futbolamericano

    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);

    if ($datoscurl3[13][0]<>$logrop3 OR $datoscurl3[12][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[13][0], $datoscurl3[12][0], $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[13][0], $horajuego, $datoscurl3[12][0]);
    }


    $tipojugada="5RL"; //futbolamericano

    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);

    if ($datoscurl3[26][0]<>$logrop3 OR $datoscurl3[25][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[26][0], $datoscurl3[25][0], $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[26][0], $horajuego, $datoscurl3[25][0]);
    }


}//fin futbol americano















//if(strpos($datoscurl2, '2.ZZ.img.ZZ.srcassetsparlaydeportesfut545451162')){ echo ' Futbol '; $ja++;


if(strpos($datoscurl2, '2.ZZ.img.ZZ.srcassetsparlaydeportesnba')){ echo ' Baloncesto '; $ja++;
    //echo $datoscurl2;
    //preg_match_all("(brspanclassVsOddsVSspanbr(.*)tdtdtableclasstext-lefttbodytrtdstyleborder:nonerowspan2imgsrcassetsparlaydeportesnba.pngclassimg-responsiveimgLogowidth30height30tdtdstyleborder:noneb(.*)btdtrtrtdstyleborder:none(.*)tdtrtbodytabletdtdclasstds(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtdclasstds(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtrtr(.*)tableclasstext-lefttbodytrtdstyleborder:nonerowspan2imgsrcassetsparlaydeportesnba.pngclassimg-responsiveimgLogowidth30height30tdtdstyleborder:noneb(.*)btdtrtrtdstyleborder:none(.*)imgsrcassetsparlayhome.pngclassimg-responsivewidth10height10tdtrtbodytabletdtdclasstds(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtdclasstds(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtrt(.*))siU", $datoscurl2, $datoscurl3);
    preg_match_all("(brspan.ZZ.classVsOddsVSspanbr(.*)td.ZZ.td.ZZ.table.ZZ.classtext-left.ZZ.tbodytr.ZZ.td.ZZ.styleborder:.ZZ.none.ZZ.rowspan2.ZZ.img.ZZ.srcassetsparlaydeportesnba.png.ZZ.classimg-responsive.ZZ.imgLogo.ZZ.width30.ZZ.height30.ZZ.td.ZZ.td.ZZ.styleborder:.ZZ.noneb(.*)btd.ZZ.tr.ZZ.tr.ZZ.td.ZZ.styleborder:.ZZ.none(.*)td.ZZ.tr.ZZ.tbodytable.ZZ.td.ZZ.td.ZZ.classtds.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.tr.ZZ.tr.ZZ.(.*).ZZ.table.ZZ.classtext-left.ZZ.tbodytr.ZZ.td.ZZ.styleborder:.ZZ.none.ZZ.rowspan2.ZZ.img.ZZ.srcassetsparlaydeportesnba.png.ZZ.classimg-responsive.ZZ.imgLogo.ZZ.width30.ZZ.height30.ZZ.td.ZZ.td.ZZ.styleborder:.ZZ.noneb(.*)btd.ZZ.tr.ZZ.tr.ZZ.td.ZZ.styleborder:.ZZ.none(.*).ZZ.img.ZZ.srcassetsparlayhome.png.ZZ.classimg-responsive.ZZ.width10.ZZ.height10td.ZZ.tr.ZZ.tbodytable.ZZ.td.ZZ.td.ZZ.classtds.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.tr.ZZ.(.*))siU", $datoscurl2, $datoscurl3);
    

    $e1=str_replace('.ZZ.', ' ', $datoscurl3[2][0]);

    $e2=str_replace('.ZZ.', ' ', $datoscurl3[15][0]);
    echo ' HORA='.$datoscurl3[1][0];
    echo '<br>e1='.$e1.' cod='.$datoscurl3[3][0].' ml1='.$datoscurl3[4][0].' av='.$datoscurl3[5][0].' al='.$datoscurl3[6][0].' rlv1='.$datoscurl3[7][0].' rll1='.$datoscurl3[8][0].' ml15='.$datoscurl3[9][0].' av5='.$datoscurl3[10][0].' al5='.$datoscurl3[11][0].' rlv15='.$datoscurl3[12][0].' rll15='.$datoscurl3[13][0]; 
    echo '<br>e2='.$e2.'                           ml2='.$datoscurl3[17][0].' bv='.$datoscurl3[18][0].' bl='.$datoscurl3[19][0].' rlv2='.$datoscurl3[20][0].' rll2='.$datoscurl3[21][0].' ml25='.$datoscurl3[22][0].' bv5='.$datoscurl3[23][0].' bl5='.$datoscurl3[24][0].' rlv25='.$datoscurl3[25][0].' rll25='.$datoscurl3[26][0].'<br><br>';
    $codWiningBetArray[] = array('codWiningBetEsta' => $datoscurl3[3][0]);
    //echo '<br><br><br><br><br>avanzando12<br><br><br><br><br><br><br><br>';





    $query_Recordset21 = sprintf(
        "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 52 */ SELECT Id_p1equiposp1
    FROM p1equipos
    WHERE  
    nomwinningbet = %s AND deportep1 = %s",
    GetSQLValueString($e1, "text"),
    GetSQLValueString(1, "int"));
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
    
    if ($totalRows_Recordset21==0) {
        echo "se creo equipo de  baloncesto";
        echo " . . .";
        $insertSQL = sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 53 */ INSERT 
    INTO p1equipos
    (nomequipop1, nomdimp1, nomwinningbet, deportep1, ordenp1) 
    VALUES (%s, %s, %s, %s, %s)",
            GetSQLValueString($e1, "text"),
            GetSQLValueString($e1, "text"),
            GetSQLValueString($e1, "text"),
            GetSQLValueString(1, "int"),
            GetSQLValueString(0, "int")
        );
    
        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $query_Recordset21 = sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 54 */ SELECT Id_p1equiposp1
    FROM p1equipos
    WHERE  
    nomwinningbet = %s",
            GetSQLValueString($e1, "text")
        );
        $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
        $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
        $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
    }
    
    $query_Recordset22 = sprintf(
      "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 55 */ SELECT Id_p1equiposp1
    FROM p1equipos
    WHERE  
    nomwinningbet = %s AND deportep1 = %s",
    GetSQLValueString($e2, "text"),
    GetSQLValueString(1, "int"));
    $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
    $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
    $totalRows_Recordset22 = mysqli_num_rows($Recordset22);
    
    if ($totalRows_Recordset22==0) {
      echo "se creo equipo de  baloncesto";
      echo " . . .";
      $insertSQL = sprintf(
          "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 56 */ INSERT 
    INTO p1equipos
    (nomequipop1, nomdimp1, nomwinningbet, deportep1, ordenp1) 
    VALUES (%s, %s, %s, %s, %s)",
          GetSQLValueString($e2, "text"),
          GetSQLValueString($e2, "text"),
          GetSQLValueString($e2, "text"),
          GetSQLValueString(1, "int"),
          GetSQLValueString(0, "int")
      );
    
      $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
      $query_Recordset22 = sprintf(
          "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 57 */ SELECT Id_p1equiposp1
    FROM p1equipos
    WHERE  
    nomwinningbet = %s",
          GetSQLValueString($e2, "text")
      );
      $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
      $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
      $totalRows_Recordset22 = mysqli_num_rows($Recordset22);
    }
    
    $horajuego =$FechaTxt.' '.$datoscurl3[1][0];
    $horajuego = strtotime('-6 hour', strtotime($horajuego));
    $horajuego = date('Y-m-d H:i:s', $horajuego);
    
    list($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2)=verificarjuego($datoscurl3[3][0], $horajuego, $row_Recordset21['Id_p1equiposp1'], $row_Recordset22['Id_p1equiposp1']);
    
    if ($totaltotalRows==0) {
        echo $totaltotalRows."juego no exicte es baloncesto y se creara".$datoscurl3[3][0];
        echo " . . .";
        if ($totaltotalRows==0) {



            if($row_Recordset18D['Swicht']==0){
            $insertSQL = sprintf(
                "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 58 */ INSERT 
    INTO p2juegos
    (idequipo1p2, idequipo2p2, deportep2, codWiningBet, iniciodtp2) 
    VALUES (%s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
                GetSQLValueString("baloncesto", "text"),
                GetSQLValueString($datoscurl3[3][0], "int"),
                GetSQLValueString($horajuego, "date")
            );
    
            $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        }else{

            $insertSQL = sprintf(
                "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 59 */ INSERT 
    INTO p10juegos
    (idequipo1p2, idequipo2p2, deportep2, codWiningBet, iniciodtp2) 
    VALUES (%s, %s, %s, %s, %s)",
                GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
                GetSQLValueString("baloncesto", "text"),
                GetSQLValueString($datoscurl3[3][0], "int"),
                GetSQLValueString($horajuego, "date")
            );
    
            $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));




        }
            list($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2)=verificarjuego($datoscurl3[3][0], $horajuego, $row_Recordset21['Id_p1equiposp1'], $row_Recordset22['Id_p1equiposp1']);
        }
    }
    if($JuegosQEstan==','){ $JuegosQEstan=$Id_p2juegosp2; }else{$JuegosQEstan=','.$JuegosQEstan.','.$Id_p2juegosp2;}

    $tipojugada="ML"; //baloncesto
list($Id_p3logrosp3, $logrop3, $logroABoRLp3,  $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);
$nov="";
if ($datoscurl3[4][0]<>$logrop3) { $la++;
    updatelogro($datoscurl3[4][0], $nov, $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
  
    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[4][0], $horajuego, $nov);
}
$tipojugada="ML"; //baloncesto
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);
$nov="";
if ($datoscurl3[17][0]<>$logrop3) { $la++;
    updatelogro($datoscurl3[17][0], $nov, $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
  
    insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[17][0], $horajuego, $nov);
}

$tipojugada="5ML"; //baloncesto
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);
$nov="";
if ($datoscurl3[9][0]<>$logrop3) { $la++;
    updatelogro($datoscurl3[9][0], $nov, $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
    insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[9][0], $horajuego, $nov);
}


$tipojugada="5ML"; //baloncesto
list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=
verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);
$nov="";
if ($datoscurl3[22][0]<>$logrop3) { $la++;
    updatelogro($datoscurl3[22][0], $nov, $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
} if ($Id_p3logrosp3=="") {
    insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[22][0], $horajuego, $nov);
}



$tipojugada="A"; //baloncesto
    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);
    if ($datoscurl3[6][0]<>$logrop3 OR $datoscurl3[5][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[6][0], $datoscurl3[5][0], $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
    } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[6][0], $horajuego, $datoscurl3[5][0]);
    }


$tipojugada="B"; //baloncesto

    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);

    if ($datoscurl3[19][0]<>$logrop3 OR $datoscurl3[18][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[19][0], $datoscurl3[18][0], $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
    } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[19][0], $horajuego, $datoscurl3[18][0]);
    }

    $tipojugada="5A"; //baloncesto
    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);
    if ($datoscurl3[11][0]<>$logrop3 OR $datoscurl3[10][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[11][0], $datoscurl3[10][0], $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
    } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[11][0], $horajuego, $datoscurl3[10][0]);
    }


$tipojugada="5B"; //baloncesto

    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);

    if ($datoscurl3[24][0]<>$logrop3 OR $datoscurl3[23][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[24][0], $datoscurl3[23][0], $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
    } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[24][0], $horajuego, $datoscurl3[23][0]);
    }



    $tipojugada="RL"; //baloncesto

    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);

    if ($datoscurl3[8][0]<>$logrop3 OR $datoscurl3[7][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[8][0], $datoscurl3[7][0], $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
    } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[8][0], $horajuego, $datoscurl3[7][0]);
    }


    $tipojugada="RL"; //baloncesto aqui estoy

    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);

    if ($datoscurl3[21][0]<>$logrop3 OR $datoscurl3[20][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[21][0], $datoscurl3[20][0], $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
    } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[21][0], $horajuego, $datoscurl3[20][0]);
    }



    $tipojugada="5RL"; //baloncesto

    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);

    if ($datoscurl3[13][0]<>$logrop3 OR $datoscurl3[12][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[13][0], $datoscurl3[12][0], $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
    } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[13][0], $horajuego, $datoscurl3[12][0]);
    }


    $tipojugada="5RL"; //baloncesto

    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);

    if ($datoscurl3[26][0]<>$logrop3 OR $datoscurl3[25][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[26][0], $datoscurl3[25][0], $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
    } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[26][0], $horajuego, $datoscurl3[25][0]);
    }


















}//fin de Baloncesto


/*
if(strpos($datoscurl2, '2.ZZ.img.ZZ.srcassetsparlaydeportesnba545451162')){ echo ' Baloncesto '; $ja++;
    //echo $datoscurl2;
    //preg_match_all("(brspanclassVsOddsVSspanbr(.*)tdtdtableclasstext-lefttbodytrtdstyleborder:nonerowspan2imgsrcassetsparlaydeportesnba.pngclassimg-responsiveimgLogowidth30height30tdtdstyleborder:noneb(.*)btdtrtrtdstyleborder:none(.*)tdtrtbodytabletdtdclasstds(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtdclasstds(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtrtr(.*)tableclasstext-lefttbodytrtdstyleborder:nonerowspan2imgsrcassetsparlaydeportesnba.pngclassimg-responsiveimgLogowidth30height30tdtdstyleborder:noneb(.*)btdtrtrtdstyleborder:none(.*)imgsrcassetsparlayhome.pngclassimg-responsivewidth10height10tdtrtbodytabletdtdclasstds(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtdclasstds(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtdclasstdsZZ(.*)ZZ(.*)tdtrt(.*))siU", $datoscurl2, $datoscurl3);
    preg_match_all("(brspan.ZZ.classVsOddsVSspanbr(.*)td.ZZ.td.ZZ.table.ZZ.classtext-left.ZZ.tbodytr.ZZ.td.ZZ.styleborder:.ZZ.none.ZZ.rowspan2.ZZ.img.ZZ.srcassetsparlaydeportesnba.png.ZZ.classimg-responsive.ZZ.imgLogo.ZZ.width30.ZZ.height30.ZZ.td.ZZ.td.ZZ.styleborder:.ZZ.noneb(.*)btd.ZZ.tr.ZZ.tr.ZZ.td.ZZ.styleborder:.ZZ.none(.*)td.ZZ.tr.ZZ.tbodytable.ZZ.td.ZZ.td.ZZ.classtds.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.tr.ZZ.tr.ZZ.(.*).ZZ.table.ZZ.classtext-left.ZZ.tbodytr.ZZ.td.ZZ.styleborder:.ZZ.none.ZZ.rowspan2.ZZ.img.ZZ.srcassetsparlaydeportesnba.png.ZZ.classimg-responsive.ZZ.imgLogo.ZZ.width30.ZZ.height30.ZZ.td.ZZ.td.ZZ.styleborder:.ZZ.noneb(.*)btd.ZZ.tr.ZZ.tr.ZZ.td.ZZ.styleborder:.ZZ.none(.*).ZZ.img.ZZ.srcassetsparlayhome.png.ZZ.classimg-responsive.ZZ.width10.ZZ.height10td.ZZ.tr.ZZ.tbodytable.ZZ.td.ZZ.td.ZZ.classtds.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.tr.ZZ.(.*))siU", $datoscurl2, $datoscurl3);
    

    $e1=str_replace('.ZZ.', ' ', $datoscurl3[2][0]);

    $e2=str_replace('.ZZ.', ' ', $datoscurl3[15][0]);

*/


if(strpos($datoscurl2, '2.ZZ.img.ZZ.srcassetsparlaydeportesnhl')){ echo ' Hoskey <br>'; $ja++;
   // var_dump($datoscurl2);
    preg_match_all("(brspan.ZZ.classVsOddsVSspanbr(.*)td.ZZ.td.ZZ.table.ZZ.classtext-left.ZZ.tbodytr.ZZ.td.ZZ.styleborder:.ZZ.none.ZZ.rowspan2.ZZ.img.ZZ.srcassetsparlaydeportesnhl.png.ZZ.classimg-responsive.ZZ.imgLogo.ZZ.width30.ZZ.height30.ZZ.td.ZZ.td.ZZ.styleborder:.ZZ.noneb(.*)btd.ZZ.tr.ZZ.tr.ZZ.td.ZZ.styleborder:.ZZ.none(.*)td.ZZ.tr.ZZ.tbodytable.ZZ.td.ZZ.td.ZZ.classtds.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.classtds.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.tr.ZZ.tr(.*)styleborder:.ZZ.none.ZZ.rowspan2.ZZ.img.ZZ.srcassetsparlaydeportesnhl.png.ZZ.classimg-responsive.ZZ.imgLogo.ZZ.width30.ZZ.height30.ZZ.td.ZZ.td.ZZ.styleborder:.ZZ.noneb(.*)btd.ZZ.tr.ZZ.tr.ZZ.td.ZZ.styleborder:.ZZ.none(.*).ZZ.img.ZZ.srcassetsparlayhome.png.ZZ.classimg-responsive.ZZ.width10.ZZ.height10td.ZZ.tr.ZZ.tbodytable.ZZ.td.ZZ.td.ZZ.(.*).ZZ.td.ZZ.td.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.td.ZZ.ZZ(.*)ZZ.ZZ.(.*).ZZ.td.ZZ.tr.ZZ.t(.*))siU", $datoscurl2, $datoscurl3);

    $e1=str_replace('.ZZ.', ' ', $datoscurl3[2][0]);

    $e2=str_replace('.ZZ.', ' ', $datoscurl3[10][0]);
 
    echo ' HORA='.$datoscurl3[1][0];
    echo '<br>e1='.$e1.' cod='.$datoscurl3[3][0].' ml1='.$datoscurl3[4][0].' av='.$datoscurl3[5][0].' al='.$datoscurl3[6][0].' rlv1='.$datoscurl3[7][0].' rll1='.$datoscurl3[8][0]; 
    echo '<br>e2='.$e2.' ml2='.$datoscurl3[12][0].' bv='.$datoscurl3[13][0].' bl='.$datoscurl3[14][0].' rlv2='.$datoscurl3[15][0].' rll2='.$datoscurl3[16][0].'<br><br>';
    $codWiningBetArray[] = array('codWiningBetEsta' => $datoscurl3[3][0]);

    
    $query_Recordset21 = sprintf(
        "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 60 */ SELECT Id_p1equiposp1
    FROM p1equipos
    WHERE  
    nomwinningbet = %s AND deportep1 = %s",
    GetSQLValueString($e1, "text"),
    GetSQLValueString(5, "int"));
    $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
    $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
    $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
    
    if ($totalRows_Recordset21==0) {
        echo "se creo equipo de  hockey";
        echo " . . .";
        $insertSQL = sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 61 */ INSERT 
    INTO p1equipos
    (nomequipop1, nomdimp1, nomwinningbet, deportep1, ordenp1) 
    VALUES (%s, %s, %s, %s, %s)",
            GetSQLValueString($e1, "text"),
            GetSQLValueString($e1, "text"),
            GetSQLValueString($e1, "text"),
            GetSQLValueString(5, "int"),
            GetSQLValueString(0, "int")
        );
    
        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $query_Recordset21 = sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 62 */ SELECT Id_p1equiposp1
    FROM p1equipos
    WHERE  
    nomwinningbet = %s",
            GetSQLValueString($e1, "text")
        );
        $Recordset21 =mysqli_query($conexionbanca, $query_Recordset21) or die(mysqli_error($conexionbanca));
        $row_Recordset21 = mysqli_fetch_assoc($Recordset21);
        $totalRows_Recordset21 = mysqli_num_rows($Recordset21);
    }

    $query_Recordset22 = sprintf(
        "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 63 */ SELECT Id_p1equiposp1
      FROM p1equipos
      WHERE  
      nomwinningbet = %s AND deportep1 = %s",
      GetSQLValueString($e2, "text"),
      GetSQLValueString(5, "int"));
      $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
      $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
      $totalRows_Recordset22 = mysqli_num_rows($Recordset22);
      
      if ($totalRows_Recordset22==0) {
        echo "se creo equipo de  hockey";
        echo " . . .";
        $insertSQL = sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 64 */ INSERT 
      INTO p1equipos
      (nomequipop1, nomdimp1, nomwinningbet, deportep1, ordenp1) 
      VALUES (%s, %s, %s, %s, %s)",
            GetSQLValueString($e2, "text"),
            GetSQLValueString($e2, "text"),
            GetSQLValueString($e2, "text"),
            GetSQLValueString(5, "int"),
            GetSQLValueString(0, "int")
        );
      
        $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
        $query_Recordset22 = sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 65 */ SELECT Id_p1equiposp1
      FROM p1equipos
      WHERE  
      nomwinningbet = %s",
            GetSQLValueString($e2, "text")
        );
        $Recordset22 =mysqli_query($conexionbanca, $query_Recordset22) or die(mysqli_error($conexionbanca));
        $row_Recordset22 = mysqli_fetch_assoc($Recordset22);
        $totalRows_Recordset22 = mysqli_num_rows($Recordset22);
      }



      $horajuego =$FechaTxt.' '.$datoscurl3[1][0];
      $horajuego = strtotime('-6 hour', strtotime($horajuego));
      $horajuego = date('Y-m-d H:i:s', $horajuego);
      
      list($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2)=verificarjuego($datoscurl3[3][0], $horajuego, $row_Recordset21['Id_p1equiposp1'], $row_Recordset22['Id_p1equiposp1']);
      
      if ($totaltotalRows==0) {
          echo $totaltotalRows."juego no exicte es hockey y se creara".$datoscurl3[3][0];
          echo " . . .";
          if ($totaltotalRows==0) {





            if($row_Recordset18D['Swicht']==0){
              $insertSQL = sprintf(
                  "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 66 */ INSERT 
      INTO p2juegos
      (idequipo1p2, idequipo2p2, deportep2, codWiningBet, iniciodtp2) 
      VALUES (%s, %s, %s, %s, %s)",
                  GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                  GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
                  GetSQLValueString("hockey", "text"),
                  GetSQLValueString($datoscurl3[3][0], "int"),
                  GetSQLValueString($horajuego, "date")
              );
      
              $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
            }else{


                $insertSQL = sprintf(
                    "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 67 */ INSERT 
        INTO p10juegos
        (idequipo1p2, idequipo2p2, deportep2, codWiningBet, iniciodtp2) 
        VALUES (%s, %s, %s, %s, %s)",
                    GetSQLValueString($row_Recordset21['Id_p1equiposp1'], "int"),
                    GetSQLValueString($row_Recordset22['Id_p1equiposp1'], "int"),
                    GetSQLValueString("hockey", "text"),
                    GetSQLValueString($datoscurl3[3][0], "int"),
                    GetSQLValueString($horajuego, "date")
                );
        
                $Result1 = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));



            }






              list($totaltotalRows, $Id_p2juegosp2, $idequipo1p2, $idequipo2p2, $pichee1p2, $pichee2p2)=verificarjuego($datoscurl3[3][0], $horajuego, $row_Recordset21['Id_p1equiposp1'], $row_Recordset22['Id_p1equiposp1']);
          }
      }
      if($JuegosQEstan==','){ $JuegosQEstan=$Id_p2juegosp2; }else{$JuegosQEstan=','.$JuegosQEstan.','.$Id_p2juegosp2;}

      $tipojugada="ML"; //hockey
      list($Id_p3logrosp3, $logrop3, $logroABoRLp3,  $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);
      $nov="";
      if ($datoscurl3[4][0]<>$logrop3) { $la++;
          updatelogro($datoscurl3[4][0], $nov, $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
        } if ($Id_p3logrosp3=="") {
        
          insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[4][0], $horajuego, $nov);
      }
      $tipojugada="ML"; //hockey
      list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);
      $nov="";
      if ($datoscurl3[12][0]<>$logrop3) { $la++;
          updatelogro($datoscurl3[12][0], $nov, $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
        } if ($Id_p3logrosp3=="") {
        
          insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[12][0], $horajuego, $nov);

	if($totaltotalRows<=10){

          $msj= 'Se ha creado un nuevo Juego de Hockey entre ' .$e1 .' y '.$e2. ' con nuevos logros'. "\n" ;
          $msjx=utf8_encode($msj);
          $post=[
            'chat_id'=>-1001793339821,
            'text'=>$msjx,
          ];
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot5218437625:AAHpDKAOQ3Nv-UZD9F_FtIFn9f7sRWLDpsw/sendMessage");
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
          curl_exec ($ch);
          curl_close ($ch);
        }
      }



      $tipojugada="A"; //futbolamericano

    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);

    if ($datoscurl3[6][0]<>$logrop3 OR $datoscurl3[5][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[6][0], $datoscurl3[5][0], $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
    } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[6][0], $horajuego, $datoscurl3[5][0]);
    }


$tipojugada="B"; //futbolamericano

    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);

    if ($datoscurl3[14][0]<>$logrop3 OR $datoscurl3[13][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[14][0], $datoscurl3[13][0], $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
    } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[14][0], $horajuego, $datoscurl3[13][0]);
    }

    $tipojugada="RL"; //futbolamericano

    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 1, $tipojugada, $logrosarray);

    if ($datoscurl3[8][0]<>$logrop3 OR $datoscurl3[7][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[8][0], $datoscurl3[7][0], $Id_p3logrosp3, $tipojugada, 1, $row_Recordset21['Id_p1equiposp1'], $Id_p2juegosp2);
    } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset21['Id_p1equiposp1'], 1, $tipojugada, $datoscurl3[8][0], $horajuego, $datoscurl3[7][0]);
    }


    $tipojugada="RL"; //futbolamericano

    list($Id_p3logrosp3, $logrop3, $logroABoRLp3, $equipop3)=verificarlogro($Id_p2juegosp2, 2, $tipojugada, $logrosarray);

    if ($datoscurl3[16][0]<>$logrop3 OR $datoscurl3[15][0]<>$logroABoRLp3) { $la++;
        updatelogro($datoscurl3[16][0], $datoscurl3[15][0], $Id_p3logrosp3, $tipojugada, 2, $row_Recordset22['Id_p1equiposp1'], $Id_p2juegosp2);
    } if ($Id_p3logrosp3=="") {
        insertlogro($Id_p2juegosp2, $row_Recordset22['Id_p1equiposp1'], 2, $tipojugada, $datoscurl3[16][0], $horajuego, $datoscurl3[15][0]);
    }


}//fin Hoskey





}//if(strpos($datoscurl2, 'VsOddsVS'))
}//fin de foreach
}//if(strpos($datoscurl, $FechaTxt)){ 
}//if($continuar==1){  //aqui finaliza todo

//incicio de agregar competicones

$comdatoscurl=preg_replace('/\s+/', '.ZZ.', $comdatoscurl);
$comdatoscurl=str_replace(')', 'ZZ', $comdatoscurl);
$comdatoscurl=str_replace(' ', '.ZZ.', $comdatoscurl);

$comdatoscurl=str_replace('(', 'ZZ', $comdatoscurl); 
$comborrardecurl=array(";", "=", "<", ">", "\\", "{", "}", "[", "]" , "#" , "'" , '"' , "/");
$comdatoscurl=str_replace($comborrardecurl, '', $comdatoscurl);
$comdatoscurl=str_replace('.WiningBet_filesfut', 'assetsparlaydeportesfut', $comdatoscurl);
$comdatoscurl=str_replace('.WiningBet_filesnba', 'assetsparlaydeportesnba', $comdatoscurl);
$comdatoscurl=str_replace('.WiningBet_filesmlb', 'assetsparlaydeportesmlb', $comdatoscurl);
$comdatoscurl=str_replace('.WiningBet_filesnhl', 'assetsparlaydeportesnhl', $comdatoscurl);
$comdatoscurl=str_replace('.WiningBet_filesnfl', 'assetsparlaydeportesnfl', $comdatoscurl);
$comdatoscurl=str_replace('.WiningBet_fileshome', 'assetsparlayhome', $comdatoscurl);



//echo $comdatoscurl;

$competiciondatoscurl=explode("TextoTableCategoria.ZZ.text-center", $comdatoscurl);

$competicion=0; 

$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$datetime=$FechaTxt.' '.$horaTxt;
$query_Recordset17 = sprintf(
    "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 68 */ SELECT p2juegos.Id_p2juegosp2, p2juegos.idequipo1p2, p2juegos.idequipo2p2, p2juegos.pichee1p2, 
            p2juegos.pichee2p2, p2juegos.codWiningBet_empate, p2juegos.competicionp2, p2juegos.deportep2, p1equipos.nomequipop1
FROM p2juegos, p1equipos 
WHERE  
p2juegos.iniciodtp2 > %s AND p2juegos.idequipo1p2 = p1equipos.Id_p1equiposp1",
GetSQLValueString($datetime, "date"));
$Recordset17 = mysqli_query($conexionbanca, $query_Recordset17) or die(mysqli_error($conexionbanca));
$row_Recordset17 = mysqli_fetch_assoc($Recordset17);
$totalRows_Recordset17 = mysqli_num_rows($Recordset17);
echo $totalRows_Recordset17.' ttoal juego sin competicion';

if($totalRows_Recordset17>0){
do{
    if(strlen($row_Recordset17['competicionp2'])<=2){
//echo 'uno y mas <br>';

//echo '<br><br>'.$row_Recordset17['nomequipop1'].'<br><br>';

$deportep2=$row_Recordset17['deportep2'];

$nomequipop1=$row_Recordset17['nomequipop1'];
foreach ($competiciondatoscurl as $compdatoscurl) {
    //preg_match_all("(brspanclassVsOddsVSspanbr(.*)tdtdtableclasstext-leftstyleborder:nonecellspacing0cellpadding0tbodytrstyleborder:nonetdrowspan2styleborder:noneimgsrcassetsparlaydeportesmlb.pngclassimg-responsiveimgLogowidth30height30tdtdstyleborder:noneb(.*)btdtrtrtdstyleborder:none(.*)tdtrtbodytabletdtdclasstdsmlb(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtdclasstdsmlb(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtdclasstdsmlb(.*)tdtdclasstdsmlb(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtrtr(.*)tableclasstext-leftcellspacing0cellpadding0styleborder:nonetbodytrtdstyleborder:nonerowspan2imgsrcassetsparlaydeportesmlb.pngclassimg-responsiveimgLogowidth30height30tdtdstyleborder:noneb(.*)btdtrtrtdstyleborder:none(.*)imgsrcassetsparlayhome.pngclassimg-responsivewidth10height10tdtrtbodytabletdtdclasstdsmlb(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtdclasstdsmlb(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtdclasstdsmlb(.*)tdtdclasstdsmlb(.*)tdtdclasstdsmlbZZ(.*)ZZ(.*)tdtr(.*))siU", $datoscurl2, $datoscurl3);
   // preg_match_all("(responsivewidth20height20(.*)b(.*)bbuttononclicklocation.href)siU", $compdatoscurl, $compdatoscurlref);
    //preg_match_all("(width20 height20 b(.*)b button onclicklocation)siU", $compdatoscurl, $compdatoscurlref);
    preg_match_all("(responsive.ZZ.width20.ZZ.height20(.*)button.ZZ.onclicklocation)siU", $compdatoscurl, $compdatoscurlref);

    $comdatoscurlref=str_replace('spb', '', $compdatoscurlref);
$comdatoscurlref=str_replace('.ZZ.', ' ', $compdatoscurlref);
$comdatoscurlref=str_replace('&nb', '', $comdatoscurlref);
$comdatoscurlref=str_replace('b', '', $comdatoscurlref);


$compdatoscurl=str_replace('.ZZ.', ' ', $compdatoscurl);
//$compdatoscurlref[1][0]=str_replace('spb', '', $compdatoscurlref[1][0]);
//$compdatoscurlref[1][0]=str_replace('.ZZ.', ' ', $compdatoscurlref[1][0]);
//$compdatoscurlref[1][0]=str_replace('&nb', '', $compdatoscurlref[1][0]);
//$compdatoscurlref[1][0]=str_replace('b', '', $compdatoscurlref[1][0]);
//echo $compdatoscurlref[1][0];
//var_dump($compdatoscurlref);
   // -centerimgsrcassetsparlaydeportesnba.pngclassimg-responsivewidth20height20 bEUROPA:ABALEAGUEbbuttononclicklocation.href

   // echo $compdatoscurl;
   
    if(strpos($compdatoscurl, $nomequipop1)){ 
        $compdatoscurlref[1][0]=str_replace('.ZZ.', ' ', $compdatoscurlref[1][0]);
        $compdatoscurlref[1][0]=str_replace('b', '', $compdatoscurlref[1][0]);
        $compdatoscurlref[1][0]=str_replace('&nsp', '', $compdatoscurlref[1][0]);
        $compdatosfx=$compdatoscurlref[1][0];

        echo '<br>'.$deportep2.' '.$nomequipop1.' '.$compdatosfx.'<br>';
//echo $compdatoscurl;
$Id_p2juegosp2=$row_Recordset17['Id_p2juegosp2'];
$insertSQL1 = sprintf(
    "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 69 */ UPDATE p2juegos 
  SET competicionp2=%s		
  WHERE 
  Id_p2juegosp2=%s",
 
    GetSQLValueString($compdatosfx, "text"),
    GetSQLValueString($Id_p2juegosp2, "int")
);
  
$Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));

/*
$query_Recordset18 = sprintf(
    "SELECT p2juegos.Id_p2juegosp2, p2juegos.idequipo1p2, p2juegos.idequipo2p2, p2juegos.pichee1p2, 
            p2juegos.pichee2p2, p2juegos.codWiningBet_empate, p2juegos.competicionp2, p2juegos.deportep2, p1equipos.nomequipop1
FROM p2juegos, p1equipos 
WHERE 
p2juegos.p2juegosp2 = %s AND 
p2juegos.iniciodtp2 > %s AND p2juegos.idequipo1p2 = p1equipos.Id_p1equiposp1",
GetSQLValueString($Id_p2juegosp2, "int"),
GetSQLValueString($datetime, "date"));
$Recordset18 = mysqli_query($conexionbanca, $query_Recordset18) or die(mysqli_error($conexionbanca));
$row_Recordset18 = mysqli_fetch_assoc($Recordset18);
$totalRows_Recordset18 = mysqli_num_rows($Recordset18);
*/



        //echo '<br>'.$competicion.'Ursula<br><br><br><br><br><br><br><br><br><br>'; 
        $competicion++;
    }

}





}
} while ($row_Recordset17 = mysqli_fetch_assoc($Recordset17));
}


//fin de agregar competicones






//inicion codigo de verificaicon de logros sin actualizar
$newDate22=$fechahora;
echo $newDate22.' newDate22<br>';


$mifecha= $fechahora; 
$newDate22 = strtotime ( '+0 hour' , strtotime ($mifecha) ) ; 
$newDate22 = strtotime ( '-15 minute' , $newDate22 ) ; 
$newDate22 = date ( 'Y-m-d H:i:s' , $newDate22); 


echo $newDate22.' newDate22<br>';
$query_Recordset1111 = sprintf(
    "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 70 */ SELECT p3logros.idjuegop3, p1equipos.nomequipop1
FROM  p3logros, p2juegos, p1equipos
WHERE p3logros.logrodtp3 >= %s AND p3logros.idjuegop3 <> %s AND p3logros.logroactualdt <= %s AND 
p3logros.idjuegop3 = p2juegos.Id_p2juegosp2 AND 
p2juegos.idequipo1p2 = p1equipos.Id_p1equiposp1 AND 
p3logros.idjuegop3 >= 0 ORDER BY p3logros.idjuegop3 DESC",
    GetSQLValueString($fechahora, "date"),
    GetSQLValueString(999999, "int"),
    GetSQLValueString($newDate22, "date"));
$Recordset1111 =mysqli_query($conexionbanca, $query_Recordset1111) or die(mysqli_error($conexionbanca));
$row_Recordset1111 = mysqli_fetch_assoc($Recordset1111);
$totalRows_Recordset1111 = mysqli_num_rows($Recordset1111);



echo $totalRows_Recordset1111.' total logros desactualizados<br>';
if($totalRows_Recordset1111>0){

    $juegosinactualizar='';
    do{
        $juegosinactualizarx=$row_Recordset1111['nomequipop1'];


                    $juegosinactualizar=$row_Recordset1111['nomequipop1'].' , '.$juegosinactualizar;


        
        } while ($row_Recordset1111 = mysqli_fetch_assoc($Recordset1111));



/*
$a_val = explode(',',$juegosinactualizar);
$a_result = array_unique($a_val);
$juegosinactualizar  = implode(",",$a_result);


        echo '<br>'.$juegosinactualizar.'<br>';
        
        if(strlen($juegosinactualizar)<200){
    $msj='Hay logros sin actualizar por favor verifique a continuacion los equipos 1 de esos juegos '.$juegosinactualizar;
    $msjx=utf8_encode($msj);
    $post=[
      'chat_id'=>-576782283,
      'text'=>$msjx,
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE/sendMessage");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 7);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_exec ($ch);
    curl_close ($ch);

}
    */
    
    




}


/*
$query_Recordset11112 = sprintf(
    "SELECT idjuegop3
FROM  p3logros
WHERE logrodtp3 >= %s AND idjuegop3 <> %s  AND idjuegop3 >= 0 ORDER BY idjuegop3 DESC",
    GetSQLValueString($fechahora, "date"),
    GetSQLValueString(999999, "int"));
$Recordset11112 =mysqli_query($conexionbanca, $query_Recordset11112) or die(mysqli_error($conexionbanca));
$row_Recordset11112 = mysqli_fetch_assoc($Recordset11112);
$totalRows_Recordset11112 = mysqli_num_rows($Recordset11112);
echo $totalRows_Recordset11112.' total logros creados<br>';

*/



//fin codigo de verificaicon de logros sin actualizar

//-----------al final
//paro la cuenta del tiempo por el objeto stoper con el m�todo Stop()
$s->Stop();

//acabo mostrando el tiempo total de ejecuci�n del script
echo $s->showResult('Tiempo total de ejecuci�n: ').'<br>';
$tiempo = $s->showResult(' ');

$BD='';
if($row_Recordset18D['Swicht']==0){
    $BD=1;
}else{
    $BD=2;
}
if($ja <>0) {
    
    if (isset($_GET["envia"])) {
        $envia = $_GET['envia'];

    } else {  $envia = 'Nombre de quienn envia no reportado por get';     }


    $msj='Winni BD'.$BD.' Se act '.$ja.' jue y '.$la.' lg t '.$tiempo.' Subio ' .$envia.' V3.6';
    $msjx=utf8_encode($msj);
    $post=[
      'chat_id'=>-576782283,
      'text'=>$msjx,
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE/sendMessage");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7);
    curl_exec ($ch);
    curl_close ($ch);
    }


//var_dump($juegosarray);
//$juegosarray[]
//Id_p2juegosp2, idequipo1p2, idequipo2p2, deportep2, competicionp2, iniciodtp2, codWiningBet_empate, codWiningBet, pichee1p2, pichee2p2
//var_dump($codWiningBetArray);
//$codWiningBetArray[]
//$codWiningBetArray[] = array('codWiningBetEsta' => $datoscurl3[3][0]);



if($ja <>0) {

    $fechahora5 = strtotime('-5 minute', strtotime($fechahora));
    $fechahora5 = date('Y-m-d H:i:s', $fechahora5);



    ///.$JuegosQEstan
    if($row_Recordset18D['Swicht']==0){
    $query_Recordset1b = sprintf(
        "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 71 */ SELECT Id_p2juegosp2 FROM p2juegos WHERE 
    iniciodtp2 > %s AND
    idequipo1p2 > 0 AND
    idequipo1p2 > 0 AND
    jexterno = 0
    ORDER BY iniciodtp2 
    DESC",

        GetSQLValueString($fechahora, "date")
);
}else{

        $query_Recordset1b = sprintf(
            "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 72 */ SELECT Id_p2juegosp2 FROM p10juegos WHERE 
        iniciodtp2 > %s AND
        idequipo1p2 > 0 AND
        idequipo1p2 > 0 AND
        jexterno = 0
        ORDER BY iniciodtp2 
        DESC",
    
            GetSQLValueString($fechahora, "date")
    );


}
        $Recordset1b = mysqli_query($conexionbanca, $query_Recordset1b) or die(mysqli_error($conexionbanca));
        $row_Recordset1b = mysqli_fetch_assoc($Recordset1b);
        $totalRows_Recordset1b = mysqli_num_rows($Recordset1b);
        $juxp=0;
        if($totalRows_Recordset1b>0){
do { 

  //  $row_Recordset1b['Id_p2juegosp2'];
  if(!strpos($JuegosQEstan, $row_Recordset1b['Id_p2juegosp2'])){


    if($row_Recordset18D['Swicht']==0){
        $insertSQL24 = sprintf(
          "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 73 */ UPDATE p2juegos 
    SET iniciodtp2 = %s			
    WHERE 
    Id_p2juegosp2 = %s", 
    
          GetSQLValueString($fechahora5, "date"),
    
          GetSQLValueString($row_Recordset1b['Id_p2juegosp2'], "int")
      );
      //$Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
      $Result24 = mysqli_query($conexionbanca, $insertSQL24);
    }else{
    
        $insertSQL24 = sprintf(
          "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 74 */ UPDATE p10juegos 
    SET iniciodtp2 = %s			
    WHERE 
    Id_p2juegosp2 = %s", 
    
          GetSQLValueString($fechahora5, "date"),
    
          GetSQLValueString($row_Recordset1b['Id_p2juegosp2'], "int")
      );
      //$Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
      $Result24 = mysqli_query($conexionbanca, $insertSQL24);
    
    
    } //if($row_Recordset18D['Swicht']==1){ con else
     
        echo 'se cierra<br>';
        $msj='Winni 9999 no tiene el siguiente juego por lo tanto se cerrara'.$row_Recordset1b['Id_p2juegosp2'];
        $msjx=utf8_encode($msj);
        $post=[
          'chat_id'=>-576782283,
          'text'=>$msjx,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot309341364:AAETe6H8z5HXbqdv5XhpTEY-nsfBKtYQ0mE/sendMessage");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7);
        curl_exec ($ch);
        curl_close ($ch);

}


    $juxp++;
} while ($row_Recordset1b = mysqli_fetch_assoc($Recordset1b));

$inicioD=fechaactualbd();
$timestamp = strtotime('-3 day', strtotime($inicioD));
$newDate = date("Y-m-d", $timestamp );

$inicio=$newDate;
$final=fechaactualbd();

$iniciof=$newDate.' 00:00:01';
$finalf=fechaactualbd().' 23:59:59';

$query_Recordset13 = sprintf("/* PARSEADORES1 new\logros\WiningBet.php - QUERY 75 */ SELECT *
FROM p4jugadas
WHERE
p4jugadas.jugadadtp4 >= %s AND p4jugadas.jugadadtp4 <= %s AND p4jugadas.pverificado = 0 AND
p4jugadas.lineatp4= 1 AND p4jugadas.estadoticketp4 = 1",
GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date"));
$Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
$row_Recordset13 = mysqli_fetch_assoc($Recordset13);
$totalRows_Recordset13 = mysqli_num_rows($Recordset13);
?>

<div style="display: none">
<?php
if ($row_Recordset13['estadoticketp4'] == 1 && $row_Recordset13['pverificado '] == 0)  { 
 
$msj= 'Hay uno o mas Ticket por Aprobar en el Sistema en total: '. $totalRows_Recordset13;
  $msjx=utf8_encode($msj);
  $post=[
  'chat_id'=>-1001639542248,
  'text'=>$msjx,
  ];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot5335385470:AAE0nAUC8c7ZDTPR3UPofIylv6TbkMsXGr8/sendMessage");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
  curl_exec ($ch);
  curl_close ($ch);


}



}














    


}

$query_Recordsetalert = sprintf(
    "/* PARSEADORES1 new\logros\WiningBet.php - QUERY 76 */ SELECT logrodtp3, tipojugadap3, logroactualdt
    FROM  p3logros
    WHERE
    logrodtp3 >= %s AND actxp3 = 55",
  GetSQLValueString($datetime, "date"));
    $Recordsetalert =mysqli_query($conexionbanca, $query_Recordsetalert) or die(mysqli_error($conexionbanca));
    $row_Recordsetalert = mysqli_fetch_assoc($Recordsetalert);
    $totalRows_Recordsetalert = mysqli_num_rows($Recordsetalert);
  
    if($totalRows_Recordsetalert>0){
  
    do{  
  $dtime2 =$row_Recordsetalert['logroactualdt']; 
  $dtime2 = strtotime(' 1 minute', strtotime($dtime2)); 
  $dtime2 = date('Y-m-d H:i:s', $dtime2);
  if ($fechahora>$dtime2)  { 
  $alerty=1;
  }
  }while ($row_Recordsetalert = mysqli_fetch_assoc($Recordsetalert));
  
  if ($alerty==25)  { 
    $msj= 'Un logro se a modificado manualmente hace 45 min porfavor reviselo probando si funciona el archivo';
    $msjx=utf8_encode($msj);
    $post=[
    'chat_id'=>-1001639542248,
    'text'=>$msjx,
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://api.telegram.org/bot5335385470:AAE0nAUC8c7ZDTPR3UPofIylv6TbkMsXGr8/sendMessage");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_exec ($ch);
    curl_close ($ch);
    
    
    }
  }




