<?php
 
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('../Connections/conexionbanca.php');

//echo $_POST['id_usu'];
$query_Recordset1 = sprintf(
        "/* PARSEADORES1 ventas\t_grabajugadahipicoticket2.php - QUERY 1 */ SELECT can_caballos, hor_carrera, fec_carrera, est_carrera, pau_ventas
								 FROM carrera
								 WHERE cod_carrera = %s 
								 LIMIT 1",
        GetSQLValueString($_POST['car'], "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);

    $query_Recordset1d = sprintf(
        "/* PARSEADORES1 ventas\t_grabajugadahipicoticket2.php - QUERY 2 */ SELECT cod_taquilla
								 FROM usuario
								 WHERE id_usuario = %s 
								 LIMIT 1",
        GetSQLValueString($_POST["id_usu"], "int")
    );
    $Recordset1d = mysqli_query($conexionbanca, $query_Recordset1d) or die(mysqli_error($conexionbanca));
    $row_Recordset1d = mysqli_fetch_assoc($Recordset1d);
    $totalRows_Recordset1d = mysqli_num_rows($Recordset1d);


    $horaTxt=horaactual();
    $FechaTxt=fechaactualbd();
    $cCab=$row_Recordset1['can_caballos']; // cantidad de caballo
    $fechacarrerabd=$row_Recordset1['fec_carrera'];
    $horacarrerabd=$row_Recordset1['hor_carrera'];
    $statuscarrerabd=$row_Recordset1['est_carrera'];
    $pau_ventas=$row_Recordset1['pau_ventas'];
    $usuarioVenta=$_POST["id_usu"];
    $codigoTaquilla=$row_Recordset1d["cod_taquilla"];
    $ipVenta=getRealIP();
    $cantTicket=ObtenerNumeroJugada($usuarioVenta, $FechaTxt)+1;
    $numerotiket2=$usuarioVenta.ObtenerUltimaVenta();
    $serial=generarCodigo(5, $numerotiket2);





$tj=0;
$asignacion=0;
$cantju=0;
$campo=array();
$array5 = array();
$aaa = array();
$bbb = array();
$ccc = array();
$ddd = array();
$doble = array();
$Exactasarray = array();
$Trifectasarray = array();
$Superfectasarray = array();
$DailyDoublesarray = array();
$hipodromo=$_POST['nom_hip'];
$codcarrera=$_POST['car'];
$id_usu=$_POST['id_usu'];
$bsapostados=$_POST['bs'];
$bsapostadosxjug=$_POST['inp_tot'];
if($_POST['id_usu']>0){ //verifica que haya un usuario haciendo la jugada
if($_POST['jug']=='wps'){  //aqui defino que es o ganador o place o show
foreach($_POST as $nombre_campo => $valor){
$asignacion2 = "\$" . $nombre_campo . "='" . $valor . "';";
if($valor=='on'){ $campo[]=$nombre_campo;}
$asignacion=$asignacion.$asignacion2;}
$explode=explode('$', $asignacion);
foreach($explode as $explode2){
$explode22=substr($explode2, 0, 2);
if($explode22=='bs'){}else{ if($explode22=='ca'){}else{
$explode2=$explode2.'yy';
$explode2x=substr($explode2, 0, -8);
if($explode2[0]=='a'){ $cantju++; $ncab=(substr($explode2x, -2)/1); $jugada=1; $array5[]= array( "ncab" => $ncab, "jugada" => $jugada,);  
        //aqui se registra una jugada
        $tipo=1;
        include("t_grabajugadahipicoticket3.php");
}
if($explode2[0]=='b'){ $cantju++; $ncab=(substr($explode2x, -2)/1); $jugada=2; $array5[]= array( "ncab" => $ncab, "jugada" => $jugada,);  
        //aqui se registra una jugada
        $tipo=2;
        include("t_grabajugadahipicoticket3.php");
}
if($explode2[0]=='c'){ $cantju++; $ncab=(substr($explode2x, -2)/1); $jugada=3; $array5[]= array( "ncab" => $ncab, "jugada" => $jugada,);  
        //aqui se registra una jugada
        $tipo=3;
        include("t_grabajugadahipicoticket3.php");
}
}}}}

if($_POST['jug']=='Exacta'){  echo 'Exacta<br>'; $jugada=4; 
foreach($_POST as $nombre_campo => $valor){
 $asignacion2 = "\$" . $nombre_campo . "='" . $valor . "';";
if($valor=='on'){ 
if($nombre_campo[0]=='a'){$aaa[]=(substr($nombre_campo, -2)/1); }
if($nombre_campo[0]=='b'){$bbb[]=(substr($nombre_campo, -2)/1); }
$campo[]=$nombre_campo;}
$asignacion=$asignacion.$asignacion2;}
echo '<br>';
foreach($aaa as $aaa2){
foreach($bbb as $bbb2){
if($aaa2<>$bbb2){$cantju++; $Exactasarray[]=$aaa2.'-'.$bbb2;
         //aqui se registra una jugada
         $ncab=$aaa2.'-'.$bbb2;
         $tipo=4;
         include("t_grabajugadahipicoticket3.php");
}}}
print_r($Exactasarray);}

if($_POST['jug']=='Trifecta'){  echo 'Trifecta<br>'; $jugada=5; 
foreach($_POST as $nombre_campo => $valor){
$asignacion2 = "\$" . $nombre_campo . "='" . $valor . "';";
if($valor=='on'){ 
if($nombre_campo[0]=='a'){$aaa[]=(substr($nombre_campo, -2)/1); }
if($nombre_campo[0]=='b'){$bbb[]=(substr($nombre_campo, -2)/1); }
if($nombre_campo[0]=='c'){$ccc[]=(substr($nombre_campo, -2)/1); }
$campo[]=$nombre_campo;}
$asignacion=$asignacion.$asignacion2;}
echo '<br>';
foreach($aaa as $aaa2){
foreach($bbb as $bbb2){
foreach($ccc as $ccc2){
if($aaa2<>$bbb2 && $aaa2<>$ccc2 && $bbb2<>$ccc2){$cantju++; 

        
        $Trifectasarray[]=$aaa2.'-'.$bbb2.'-'.$ccc2;
         //aqui se registra una jugada
         $ncab=$aaa2.'-'.$bbb2.'-'.$ccc2;
         $tipo=5;
         include("t_grabajugadahipicoticket3.php");
}}}}
print_r($Trifectasarray);}

if($_POST['jug']=='Superfecta'){  echo 'Superfecta<br>'; $jugada=6;    
foreach($_POST as $nombre_campo => $valor){
$asignacion2 = "\$" . $nombre_campo . "='" . $valor . "';";
if($valor=='on'){ 
if($nombre_campo[0]=='a'){$aaa[]=(substr($nombre_campo, -2)/1); }
if($nombre_campo[0]=='b'){$bbb[]=(substr($nombre_campo, -2)/1); }
if($nombre_campo[0]=='c'){$ccc[]=(substr($nombre_campo, -2)/1); }
if($nombre_campo[0]=='d'){$ddd[]=(substr($nombre_campo, -2)/1); }
$campo[]=$nombre_campo;}
$asignacion=$asignacion.$asignacion2;}
echo '<br>';
foreach($aaa as $aaa2){
foreach($bbb as $bbb2){
foreach($ccc as $ccc2){
foreach($ddd as $ddd2){
if($aaa2<>$bbb2 && $aaa2<>$ccc2 && $aaa2<>$ddd2 && $bbb2<>$ccc2 && $bbb2<>$ddd2 && $ccc2<>$ddd2){$cantju++; 
        $Superfectasarray[]=$aaa2.'-'.$bbb2.'-'.$ccc2.'-'.$ddd2;
         //aqui se registra una jugada
        $ncab=$aaa2.'-'.$bbb2.'-'.$ccc2.'-'.$ddd2;
        $tipo=6;
        include("t_grabajugadahipicoticket3.php");
}}}}}
print_r($Superfectasarray);}

if($_POST['jug']=='Daily Double'){  echo 'Daily Double<br>'; $jugada=7; 
        foreach($_POST as $nombre_campo => $valor){
                if($valor=='on'){ 
              //  $rest = substr("abcdef", 0, -1);  // devuelve "abcde"
              $race=substr($nombre_campo, 0, -3);

if($codcarrera==$race) {   
echo 'primera carrera '.$codcarrera.'<br>';
$aaaf=(substr($nombre_campo, -2)/1);
echo $aaaf.'<br>';

$doble1[]=$codcarrera.','.$aaaf;




}
$segundocarrera=$codcarrera+1;
if($segundocarrera==$race) { 
echo 'segunda carrera '.$race.'<br>';
$aaaf=(substr($nombre_campo, -2)/1);
echo $aaaf.'<br>';
$doble2[]=$race.','.$aaaf;



}
}}//foreach($_POST as $nombre_campo => $valor){


//print_r($doble);
foreach($doble1 as $doble11){
        foreach($doble2 as $doble22){
        
        if($doble11<>$doble22){  
           //  echo '--------------------<br>1<br>';
             $doble11w=explode(',', $doble11);
          //   print_r($doble11w[1]);
           //  echo '<br>1<br>';
             $doble22w=explode(',', $doble22);

           //  print_r($doble22w[1]);
           //  echo '<br>1<br>';
             $cantju++;

           $DailyDoublesarray[]=$doble11w[1].'-'.$doble22w[1];
         //aqui se registra una jugada
         $ncab=$doble11w[1].'-'.$doble22w[1];
         $tipo=22;
         include("t_grabajugadahipicoticket3.php");
         }










}
}
print_r($DailyDoublesarray);
}
//final de $DailyDouble
//inicio de pick 3
if($_POST['jug']=='Pick 3'){  echo 'Pick 3<br>'; $jugada=8; 
        foreach($_POST as $nombre_campo => $valor){
                if($valor=='on'){ 
              //  $rest = substr("abcdef", 0, -1);  // devuelve "abcde"
              $race=substr($nombre_campo, 0, -3);

if($codcarrera==$race) {   
echo 'primera carrera '.$codcarrera.'<br>';
$aaaf=(substr($nombre_campo, -2)/1);
echo $aaaf.'<br>';

$Pick31[]=$codcarrera.','.$aaaf;




}
$segundocarrera=$codcarrera+1;
if($segundocarrera==$race) { 
echo 'segunda carrera '.$race.'<br>';
$aaaf=(substr($nombre_campo, -2)/1);
echo $aaaf.'<br>';
$Pick32[]=$race.','.$aaaf;


}
$terceracarrera=$codcarrera+2;
if($terceracarrera==$race) { 
        echo 'segunda carrera '.$race.'<br>';
        $aaaf=(substr($nombre_campo, -2)/1);
        echo $aaaf.'<br>';
        $Pick33[]=$race.','.$aaaf;
        
        

}
}}//foreach($_POST as $nombre_campo => $valor){


//print_r($Pick3);
foreach($Pick31 as $Pick311){
        foreach($Pick32 as $Pick322){
                foreach($Pick33 as $Pick333){
        if($Pick311<>$Pick322){  
           //  echo '--------------------<br>1<br>';
             $Pick311w=explode(',', $Pick311);
          //   print_r($Pick311w[1]);
           //  echo '<br>1<br>';
             $Pick322w=explode(',', $Pick322);
             $Pick333w=explode(',', $Pick333);
           //  print_r($Pick322w[1]);
           //  echo '<br>1<br>';
             $cantju++;

           $Pick3sarray[]=$Pick311w[1].'-'.$Pick322w[1].'-'.$Pick333w[1];
         //aqui se registra una jugada
         $ncab=$Pick311w[1].'-'.$Pick322w[1].'-'.$Pick333w[1];
         $tipo=23;
         include("t_grabajugadahipicoticket3.php");
         }









        }
}
}
print_r($Pick3sarray);
}
//final Pick 3
//inicio Pick 4
if($_POST['jug']=='Pick 4'){  echo 'Pick 4<br>'; $jugada=9; 
        foreach($_POST as $nombre_campo => $valor){
                if($valor=='on'){ 
              //  $rest = substr("abcdef", 0, -1);  // devuelve "abcde"
              $race=substr($nombre_campo, 0, -3);

if($codcarrera==$race) {   
echo 'primera carrera '.$codcarrera.'<br>';
$aaaf=(substr($nombre_campo, -2)/1);
echo $aaaf.'<br>';

$Pick41[]=$codcarrera.','.$aaaf;




}
$segundocarrera=$codcarrera+1;
if($segundocarrera==$race) { 
echo 'segunda carrera '.$race.'<br>';
$aaaf=(substr($nombre_campo, -2)/1);
echo $aaaf.'<br>';
$Pick42[]=$race.','.$aaaf;


}
$terceracarrera=$codcarrera+2;
if($terceracarrera==$race) { 
        echo 'segunda carrera '.$race.'<br>';
        $aaaf=(substr($nombre_campo, -2)/1);
        echo $aaaf.'<br>';
        $Pick43[]=$race.','.$aaaf;
        
        

}
$cuartacarrera=$codcarrera+3;
if($cuartacarrera==$race) { 
        echo 'segunda carrera '.$race.'<br>';
        $aaaf=(substr($nombre_campo, -2)/1);
        echo $aaaf.'<br>';
        $Pick44[]=$race.','.$aaaf;
        
        

}
}}//foreach($_POST as $nombre_campo => $valor){


//print_r($Pick4);
foreach($Pick41 as $Pick411){
        foreach($Pick42 as $Pick422){
                foreach($Pick43 as $Pick433){
                        foreach($Pick44 as $Pick444){
        if($Pick411<>$Pick422){  
           //  echo '--------------------<br>1<br>';
             $Pick411w=explode(',', $Pick411);
          //   print_r($Pick311w[1]);
           //  echo '<br>1<br>';
             $Pick422w=explode(',', $Pick422);
             $Pick433w=explode(',', $Pick433);
             $Pick444w=explode(',', $Pick444);
           //  print_r($Pick322w[1]);
           //  echo '<br>1<br>';
             $cantju++;

           $Pick4sarray[]=$Pick411w[1].'-'.$Pick422w[1].'-'.$Pick433w[1].'-'.$Pick444w[1];
           $ncab=$Pick411w[1].'-'.$Pick422w[1].'-'.$Pick433w[1].'-'.$Pick444w[1];
           $tipo=24;
           include("t_grabajugadahipicoticket3.php");
         }









        } }
}
}
print_r($Pick4sarray);
}
//final Pick 4
//final Pick 5
if($_POST['jug']=='Pick 5'){  echo 'Pick 5<br>'; $jugada=10; 
        foreach($_POST as $nombre_campo => $valor){
                if($valor=='on'){ 
              //  $rest = substr("abcdef", 0, -1);  // devuelve "abcde"
              $race=substr($nombre_campo, 0, -3);

if($codcarrera==$race) {   
echo 'primera carrera '.$codcarrera.'<br>';
$aaaf=(substr($nombre_campo, -2)/1);
echo $aaaf.'<br>';

$Pick51[]=$codcarrera.','.$aaaf;




}
$segundocarrera=$codcarrera+1;
if($segundocarrera==$race) { 
echo 'segunda carrera '.$race.'<br>';
$aaaf=(substr($nombre_campo, -2)/1);
echo $aaaf.'<br>';
$Pick52[]=$race.','.$aaaf;


}
$terceracarrera=$codcarrera+2;
if($terceracarrera==$race) { 
        echo 'tercera carrera '.$race.'<br>';
        $aaaf=(substr($nombre_campo, -2)/1);
        echo $aaaf.'<br>';
        $Pick53[]=$race.','.$aaaf;
        
        

}
$cuartacarrera=$codcarrera+3;
if($cuartacarrera==$race) { 
        echo 'cuarta carrera '.$race.'<br>';
        $aaaf=(substr($nombre_campo, -2)/1);
        echo $aaaf.'<br>';
        $Pick54[]=$race.','.$aaaf;
        
        

}
$quintacarrera=$codcarrera+4;
if($quintacarrera==$race) { 
        echo 'quinta carrera '.$race.'<br>';
        $aaaf=(substr($nombre_campo, -2)/1);
        echo $aaaf.'<br>';
        $Pick55[]=$race.','.$aaaf;
        
        

}
}}//foreach($_POST as $nombre_campo => $valor){


//print_r($Pick5);
foreach($Pick51 as $Pick511){
        foreach($Pick52 as $Pick522){
                foreach($Pick53 as $Pick533){
                        foreach($Pick54 as $Pick544){
                                foreach($Pick55 as $Pick555){
        if($Pick511<>$Pick522){  
             $Pick511w=explode(',', $Pick511);
             $Pick522w=explode(',', $Pick522);
             $Pick533w=explode(',', $Pick533);
             $Pick544w=explode(',', $Pick544);
             $Pick555w=explode(',', $Pick555);
             $cantju++;

           $Pick5sarray[]=$Pick511w[1].'-'.$Pick522w[1].'-'.$Pick533w[1].'-'.$Pick544w[1].'-'.$Pick555w[1];
           $ncab=$Pick511w[1].'-'.$Pick522w[1].'-'.$Pick533w[1].'-'.$Pick544w[1].'-'.$Pick555w[1];
           $tipo=25;
        include("t_grabajugadahipicoticket3.php");
         }









        } } }
}
}
print_r($Pick5sarray);
}
//final Pick 5
}

if($jugada==1 OR $jugada==2 OR $jugada==3){  
foreach($array5 as $array51){

echo 'ncab '.$array51['ncab'].' jugada '.$array51['jugada'].'<br>';
}
}
echo '<br>Monto apostado por cada jugada '.$bsapostados; //listo
echo '<br>Monto total apostado por todas las jugada '.$bsapostadosxjug; //listo
echo '<br>Cantidad de jugadas '.$cantju; //listo
echo '<br>hipodromo '.$hipodromo; //listo
echo '<br>codcarrera '.$codcarrera; //listo
echo '<br>cod usuario '.$id_usu; //listo

/*
$letras=["A","B","C","D","E"];
$contador=0;

for($i=0;$i<=4; $i++){
        for($j=0; $j<=4;$j++){
                for($k=0;$k<=4;$k++){
                        for($l=0;$l<=4;$l++){
                                for($m=0;$m<=4;$m++){
                                        echo "$letras[$i]$letras[$j]$letras[$k]$letras[$l]$letras[$m] \n";
                                        $contador+=1;
                                }
                        }
                }
        }
}
echo "Combinaciones $contador \n";