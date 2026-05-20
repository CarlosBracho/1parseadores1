<?php
require_once('../Connections/conexionbanca.php');


function eliminar_acentos($cadena){
		
    //Reemplazamos la A y a
    $cadena = str_replace(
    array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
    array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
    $cadena
    );

    //Reemplazamos la E y e
    $cadena = str_replace(
    array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
    array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
    $cadena );

    //Reemplazamos la I y i
    $cadena = str_replace(
    array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
    array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
    $cadena );

    //Reemplazamos la O y o
    $cadena = str_replace(
    array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
    array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
    $cadena );

    //Reemplazamos la U y u
    $cadena = str_replace(
    array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
    array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
    $cadena );

    //Reemplazamos la N, n, C y c
    $cadena = str_replace(
    array('Ñ', 'ñ', 'Ç', 'ç'),
    array('N', 'n', 'C', 'c'),
    $cadena
    );
    
    return $cadena;
}



$url='http://localhost/1new/logros/Marcadoresbeisbol.html';
echo '<br>';
$ja=0;


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$datoscurl = curl_exec($ch);
curl_close($ch);
$datoscurl=preg_replace('/\s+/', '', $datoscurl);
$datoscurl=str_replace('(', 'ZZ', $datoscurl); 
$datoscurl=str_replace(')', 'ZZ', $datoscurl);
$borrardecurl=array(";", "=", "<", ">", "\\", "{", "}", "[", "]" , "#" , "'" , '"' , "/");
$datoscurl=str_replace($borrardecurl, '', $datoscurl);
$datoscurl=eliminar_acentos($datoscurl);
// echo $datoscurl;
//*
$datoscurl=explode('divclassevent__titleBoxspanclassevent__title--type', $datoscurl);
foreach ($datoscurl as $datoscurl2) { 
    
    if(strpos($datoscurl2, 'spanspanclassevent__title')){
        preg_match_all("((.*)spanspanclassevent__title--nametitle(.*)spandivdivahrefhttps:www.flashscore.com(.*))siU", $datoscurl2, $datoscurlcompe);
     
        //var_dump($datoscurlcompe);
        $largocompeticion=strlen($datoscurlcompe[2][0])/2;
       echo $datoscurlcompe[1][0].' '.substr($datoscurlcompe[2][0], 0, $largocompeticion).'<br>';
    $ja++;  
    //   echo 'largo de la competicion = '.strlen($datoscurl2).'  '.$ja.'<br>';
    $datoscurl22=explode('divdivclassevent__time', $datoscurl2);
    foreach ($datoscurl22 as $datoscurl222) { 
        $juego=substr($datoscurl222, 0, 999); 
        
        if(strpos($datoscurl222, 'score--away-')){

            preg_match_all("((.*)divimgclassevent__logoevent__logo--homeloadinglazysrc.Marcadoresbeisbol_files(.*).pngdivclassevent__participantevent__participant--home(.*)divimgclassevent__logoevent__logo--awayloadinglazysrc.Marcadoresbeisbol_files(.*).pngdivclassevent__participantevent__participant--away(.*)divdivclassevent__scoreevent__score--home-divdivclassevent__scoreevent__score--away-div(.*))siU", $datoscurl222, $datoscurljuego);

        echo  'HORA='.$datoscurljuego[1][0].' -- 1er equipo= '.$datoscurljuego[3][0].' -- 2er equipo= '.$datoscurljuego[5][0].' juegovalido Largo = '.strlen($juego).' Solo Del Juego valido<br>';

       //echo $juego.'<br><br><br><br><br>';
    }}

}
echo '<br><br>';
}



