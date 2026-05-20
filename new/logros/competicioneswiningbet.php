<?php 
require_once('../Connections/conexionbanca.php');

$url='http://localhost/new/logros/WiningBet.html';


$datoscurl='';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 7);
$datoscurl = curl_exec($ch);
curl_close($ch);







$comdatoscurl=$datoscurl;


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
    "/* PARSEADORES1 new\logros\competicioneswiningbet.php - QUERY 1 */ SELECT p2juegos.Id_p2juegosp2, p2juegos.idequipo1p2, p2juegos.idequipo2p2, p2juegos.pichee1p2, 
            p2juegos.pichee2p2, p2juegos.codWiningBet_empate, p2juegos.competicionp2, p1equipos.nomequipop1
FROM p2juegos, p1equipos 
WHERE  
p2juegos.iniciodtp2 > %s AND p2juegos.idequipo1p2 = p1equipos.Id_p1equiposp1",
    GetSQLValueString($FechaTxt.' 00:00:01', "date"));
$Recordset17 = mysqli_query($conexionbanca, $query_Recordset17) or die(mysqli_error($conexionbanca));
$row_Recordset17 = mysqli_fetch_assoc($Recordset17);
$totalRows_Recordset17 = mysqli_num_rows($Recordset17);
echo $totalRows_Recordset17.' ttoal juego sin competicion';

if($totalRows_Recordset17>0){
do{
    if(strlen($row_Recordset17['competicionp2'])<2){
echo 'uno y mas <br>';

echo '<br><br>'.$row_Recordset17['nomequipop1'].'<br><br>';

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
    if(strpos($compdatoscurl, $row_Recordset17['nomequipop1'])){ 
        $compdatoscurlref[1][0]=str_replace('.ZZ.', ' ', $compdatoscurlref[1][0]);
        $compdatoscurlref[1][0]=str_replace('b', '', $compdatoscurlref[1][0]);
        $compdatoscurlref[1][0]=str_replace('&nsp', '', $compdatoscurlref[1][0]);
        
        
        echo '<br> Si esta '.$compdatoscurlref[1][0].' Aqui competicion<br>';
//echo $compdatoscurl;
$compdatosfx=$compdatoscurlref[1][0];
$insertSQL1 = sprintf(
    "/* PARSEADORES1 new\logros\competicioneswiningbet.php - QUERY 2 */ UPDATE p2juegos 
  SET competicionp2=%s		
  WHERE 
  Id_p2juegosp2>%s",
 
    GetSQLValueString($compdatosfx, "text"),
    GetSQLValueString($row_Recordset17['Id_p2juegosp2'], "int")
);
  
$Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));







        echo '<br>'.$competicion.'Ursula<br><br><br><br><br><br><br><br><br><br>'; 
        $competicion++;
    }

}





}
} while ($row_Recordset17 = mysqli_fetch_assoc($Recordset17));
}



