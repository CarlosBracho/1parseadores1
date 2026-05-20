<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
function ObtenerMontoEjeTaq($codT, $fecV, $numE, $codC, $codA)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 ventas\t_grabajugadahipicoticket.php - QUERY 1 */ SELECT 
		SUM(mon_venta) AS total FROM venta 
	WHERE cod_taquilla = %s AND fec_venta = %s AND num_caballo = %s AND cod_carrera = %s AND cod_tventa = %s AND est_ticket = 1",
        GetSQLValueString($codT, "int"),
        GetSQLValueString($fecV, "date"),
        GetSQLValueString($numE, "text"),
        GetSQLValueString($codC, "int"),
        GetSQLValueString($codA, "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $total=$row_Recordset1['total'];
    echo $total;
    mysqli_free_result($Recordset1);
    return $total;
}
$usdabss=0;
include("../includes/montosminimos.php");

//codigo diego

if(isset($_SESSION['Carrera'])){
    $horaTxt=horaactual();
    $query_Recordset180 = sprintf(
        "/* PARSEADORES1 ventas\t_grabajugadahipicoticket.php - QUERY 2 */ SELECT  mon_venta, hor_venta, num_caballo, efectivoO, cod_carrera
        FROM venta
    WHERE 
    id_usuario=%s ORDER BY num_ticket DESC LIMIT 1 ",
        GetSQLValueString($_SESSION['MM_id_usuario'], "int")
    );
    $Recordset180 = mysqli_query($conexionbanca, $query_Recordset180) or die(mysqli_error($conexionbanca));
    $row_Recordset180 = mysqli_fetch_assoc($Recordset180);
    $totalRows_Recordset180 = mysqli_num_rows($Recordset180);

$query_Recordset180D = sprintf(
    "/* PARSEADORES1 ventas\t_grabajugadahipicoticket.php - QUERY 3 */ SELECT  tp.limit_ticket_ame, us.cod_taquilla
    FROM taquilla_opc_ame tp, usuario us
WHERE 
us.id_usuario=%s AND tp.cod_taquilla=us.cod_taquilla LIMIT 1",
    GetSQLValueString($_SESSION['MM_id_usuario'], "int")
);
$Recordset180D = mysqli_query($conexionbanca, $query_Recordset180D) or die(mysqli_error($conexionbanca));
$row_Recordset180D = mysqli_fetch_assoc($Recordset180D);
$totalRows_Recordset180D = mysqli_num_rows($Recordset180D);

$horatiket=$_SESSION['Hora'];
if($row_Recordset180D['limit_ticket_ame']==0){
$timeticket = strtotime('+5 second', strtotime($horatiket));
$timeecho=5;
}elseif($row_Recordset180D['limit_ticket_ame']==1){
$timeticket = strtotime('+15 second', strtotime($horatiket)); 
$timeecho=15;   
}elseif($row_Recordset180D['limit_ticket_ame']==2){
    $timeticket = strtotime('+30 second', strtotime($horatiket));
    $timeecho=30;
}elseif($row_Recordset180D['limit_ticket_ame']==3){
    $timeticket = strtotime('+60 second', strtotime($horatiket));
    $timeecho=60;
}elseif($row_Recordset180D['limit_ticket_ame']==4){
    $timeticket = strtotime('+120 second', strtotime($horatiket));
    $timeecho=120;
}
$timeticket = date("H:i:s", $timeticket );
$_SESSION['Monto']=$row_Recordset180['mon_venta'];
$_SESSION['Ejemplar']=$row_Recordset180['num_caballo'];
$_SESSION['Carrera']=$row_Recordset180['cod_carrera'];
$_SESSION['Hora']=$horaTxt;
$_SESSION['Tipomoneda']=$row_Recordset180['efectivoO'];

}



//fin codigo diego
?>
<style media="print" type="text/css">
#imprimir {
    visibility: hidden
}
</style>
<script type="text/javascript">
function imprSelec(muestra) {
    var ficha = document.getElementById(muestra);
    var ventimp = window.open(' ', '_blank', 'width=0, height=0, scrollbars=NO, top=0, left=0');
    ventimp.document.write(ficha.innerHTML);
    ventimp.document.close();
    ventimp.print();
    ventimp.close();
}
</script>

<script language="javascript">
function nuevoAjax() {
    var xmlhttp = false;
    try {
        // Creacion del objeto AJAX para navegadores no IE
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            // Creacion del objet AJAX para IE
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

function imprimeTicketie(cod, acceso) {
    if (acceso == 1) {
        ajax = nuevoAjax();
        ajax.open('POST', 't_imprimeticket.php', true);
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("iD=" + cod);
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4) {
                document.getElementById('divImprime').innerHTML = ajax.responseText;
                imprSelec('divImprime');
            }
        }
    }
}
</script>
<script language="javascript">
function imprimeTicketall(cod, acceso) {
    if (acceso == 1) {
        ajax = nuevoAjax();
        ajax.open('POST', 't_imprimeticket.php', true);
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("iD=" + cod);
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4) {
                //document.getElementById('divImprime').innerHTML = ajax.responseText;
                //doPrint();
                //imprSelec('divImprime');
                document.getElementById('divImprime').innerHTML = ajax.responseText;
                var htmlString = document.getElementById('divImprime').innerHTML;
                var newIframe = document.createElement('iframe');
                newIframe.width = '1px';
                newIframe.height = '1px';
                newIframe.src = 'about:blank';
                // for IE wait for the IFrame to load so we can access contentWindow.document.body
                newIframe.onload = function() {
                    var script_tag = newIframe.contentWindow.document.createElement("script");
                    script_tag.type = "text/javascript";
                    var script = newIframe.contentWindow.document.createTextNode(
                        'function Print(){ window.focus(); window.print(); }');
                    script_tag.appendChild(script);
                    newIframe.contentWindow.document.body.innerHTML = htmlString;
                    newIframe.contentWindow.document.body.appendChild(script_tag);
                    // for chrome, a timeout for loading large amounts of content
                    setTimeout(function() {
                        newIframe.contentWindow.Print();
                        newIframe.contentWindow.document.removeChild(script_tag);
                        newIframe.remove();
                    }, 1);
                };
                document.body.appendChild(newIframe);
                document.getElementById(monto).value = "";

            }
        }
    }
}
</script>
<?php
$fechasistema=fechaactualbd();
$exito=0;
$cCab="";
$mensaje2="";
$mensaje1="";
$mensaje2="";
$mensaje3="";
$mensaje4="";
$menValida="";
$fueFec=1;
$fueHor=1;
$maxCa="";
$numerotiket2="";
$_SESSION['selCarrera']=$_POST['cod_carrera'];
$query_Recordset7 = sprintf("/* PARSEADORES1 ventas\t_grabajugadahipicoticket.php - QUERY 4 */ SELECT est_control_ventas_ame FROM ctrol_ventpag_global_ame WHERE cod_ctrol_ventpag_global_ame = 1");
$Recordset7 = mysqli_query($conexionbanca, $query_Recordset7) or die(mysqli_error($conexionbanca));
$row_Recordset7 = mysqli_fetch_assoc($Recordset7);
$totalRows_Recordset7 = mysqli_num_rows($Recordset7);
$est_control_ventas=$row_Recordset7['est_control_ventas_ame'];//todas las ventas globales
$pau_ventas=0;// ventas por carrera
if (isset($_POST["MM_insert"]) && $_POST["MM_insert"]=="form1" && isset($_POST["cod_carrera"]) && $_POST["cod_carrera"]!=-1 && $est_control_ventas==0) {
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 ventas\t_grabajugadahipicoticket.php - QUERY 5 */ SELECT can_caballos, hor_carrera, fec_carrera, est_carrera, pau_ventas
								 FROM carrera
								 WHERE cod_carrera = %s 
								 LIMIT 1",
        GetSQLValueString($_POST['cod_carrera'], "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $tp1=0;
    $ju1=0;
    $tp2=0;
    $ju2=0;
    $tp3=0;
    $ju3=0;
    $tp4=0;
    $ju4=0;
    $horaTxt=horaactual();
    $FechaTxt=fechaactualbd();
    $cCab=$row_Recordset1['can_caballos']; // cantidad de caballo
    $fechacarrerabd=$row_Recordset1['fec_carrera'];
    $horacarrerabd=$row_Recordset1['hor_carrera'];
    $statuscarrerabd=$row_Recordset1['est_carrera'];
    $pau_ventas=$row_Recordset1['pau_ventas'];
    $usuarioVenta=$_POST["id_usuario"];
    $codigoTaquilla=$_POST["cod_taquilla"];
    $ipVenta=getRealIP();
    $cantTicket=ObtenerNumeroJugada($usuarioVenta, $fechasistema)+1;
    $numerotiket2=$usuarioVenta.ObtenerUltimaVenta();
    $serial=generarCodigo(5, $numerotiket2);
    $maxCa=0; // bandera maxima de caballo
    $_POST["tipotaquilla"]=((int)$_POST["tipotaquilla"]/(int)1);
    $tipotaquilla=$_POST["tipotaquilla"];
    $_POST["saldoactual"]=((float)$_POST["saldoactual"]/(float)1);
    $saldoactual=$_POST["saldoactual"];
    $_POST["tra_codigo"]=((int)$_POST["tra_codigo"]/(int)1);
    $tra_codigo=$_POST["tra_codigo"];
    $tra_codigox=$_POST["tra_codigo"];
    $_POST["tipo_pago"]=((int)$_POST["tipo_pago"]/(int)1);
    $tipo_pago=$_POST["tipo_pago"];
    $_POST["tipo_pagoa"]=((int)$_POST["tipo_pagoa"]/(int)1);
    $tipo_pagoa=$_POST["tipo_pagoa"];
    $_POST["cod_agencia"]=((int)$_POST["cod_agencia"]/(int)1);
    $cod_agencia=$_POST["cod_agencia"];
    $_POST["efectivoO"]=((int)$_POST["efectivoO"]/(int)1);
    $efectivoO=$_POST["efectivoO"];
    $_POST["monGan1"]=((float)$_POST["monGan1"]/(float)1);
    $_POST["monPla1"]=((float)$_POST["monPla1"]/(float)1);
    $_POST["monSho1"]=((float)$_POST["monSho1"]/(float)1);
    $_POST["monGan2"]=((float)$_POST["monGan2"]/(float)1);
    $_POST["monPla2"]=((float)$_POST["monPla2"]/(float)1);
    $_POST["monSho2"]=((float)$_POST["monSho2"]/(float)1);
    $_POST["monGan3"]=((float)$_POST["monGan3"]/(float)1);
    $_POST["monPla3"]=((float)$_POST["monPla3"]/(float)1);
    $_POST["monSho3"]=((float)$_POST["monSho3"]/(float)1);
    $_POST["monGan4"]=((float)$_POST["monGan4"]/(float)1);
    $_POST["monPla4"]=((float)$_POST["monPla4"]/(float)1);
    $_POST["monSho4"]=((float)$_POST["monSho4"]/(float)1);
    $_POST["numCa11"]=((float)$_POST["numCa11"]/(float)1);
    $_POST["numCa21"]=((float)$_POST["numCa21"]/(float)1);
    $_POST["numCa31"]=((float)$_POST["numCa31"]/(float)1);
    $_POST["numCa41"]=((float)$_POST["numCa41"]/(float)1);
    $_POST["numCa12"]=((float)$_POST["numCa12"]/(float)1);
    $_POST["numCa22"]=((float)$_POST["numCa22"]/(float)1);
    $_POST["numCa32"]=((float)$_POST["numCa32"]/(float)1);
    $_POST["numCa42"]=((float)$_POST["numCa42"]/(float)1);
    $_POST["numCa13"]=((float)$_POST["numCa13"]/(float)1);
    $_POST["numCa23"]=((float)$_POST["numCa23"]/(float)1);
    $_POST["numCa33"]=((float)$_POST["numCa33"]/(float)1);
    $_POST["numCa43"]=((float)$_POST["numCa43"]/(float)1);
    $_POST["numCa14"]=((float)$_POST["numCa14"]/(float)1);
    $_POST["numCa24"]=((float)$_POST["numCa24"]/(float)1);
    $_POST["numCa34"]=((float)$_POST["numCa34"]/(float)1);
    $_POST["numCa44"]=((float)$_POST["numCa44"]/(float)1);
    if (($_POST["numCa11"]=="" || $_POST["numCa11"]<=0) && ($_POST["numCa21"]>0) &&
        ($_POST["numCa31"]=="" || $_POST["numCa31"]<=0) && ($_POST["numCa41"]=="" || $_POST["numCa41"]<=0)) {
        $_POST["numCa11"]=$_POST["numCa21"];
    }
    if (($_POST["numCa11"]=="" || $_POST["numCa11"]<=0) && ($_POST["numCa31"]>0) &&
        ($_POST["numCa21"]=="" || $_POST["numCa21"]<=0) && ($_POST["numCa41"]=="" || $_POST["numCa41"]<=0)) {
        $_POST["numCa11"]=$_POST["numCa31"];
    }
    if (($_POST["numCa11"]=="" || $_POST["numCa11"]<=0) && ($_POST["numCa41"]>0) &&
        ($_POST["numCa21"]=="" || $_POST["numCa21"]<=0) && ($_POST["numCa31"]=="" || $_POST["numCa31"]<=0)) {
        $_POST["numCa11"]=$_POST["numCa41"];
    }
    if (($_POST["numCa12"]=="" || $_POST["numCa12"]<=0) && ($_POST["numCa22"]>0) &&
        ($_POST["numCa32"]=="" || $_POST["numCa32"]<=0) && ($_POST["numCa42"]=="" || $_POST["numCa42"]<=0)) {
        $_POST["numCa12"]=$_POST["numCa22"];
    }
    if (($_POST["numCa12"]=="" || $_POST["numCa12"]<=0) && ($_POST["numCa32"]>0) &&
        ($_POST["numCa22"]=="" || $_POST["numCa22"]<=0) && ($_POST["numCa42"]=="" || $_POST["numCa42"]<=0)) {
        $_POST["numCa12"]=$_POST["numCa32"];
    }
    if (($_POST["numCa12"]=="" || $_POST["numCa12"]<=0) && ($_POST["numCa42"]>0) &&
        ($_POST["numCa22"]=="" || $_POST["numCa22"]<=0) && ($_POST["numCa32"]=="" || $_POST["numCa32"]<=0)) {
        $_POST["numCa12"]=$_POST["numCa42"];
    }
    if (($_POST["numCa13"]=="" || $_POST["numCa13"]<=0) && ($_POST["numCa23"]>0) &&
        ($_POST["numCa33"]=="" || $_POST["numCa33"]<=0) && ($_POST["numCa43"]=="" || $_POST["numCa43"]<=0)) {
        $_POST["numCa13"]=$_POST["numCa23"];
    }
    if (($_POST["numCa13"]=="" || $_POST["numCa13"]<=0) && ($_POST["numCa33"]>0) &&
        ($_POST["numCa23"]=="" || $_POST["numCa23"]<=0) && ($_POST["numCa43"]=="" || $_POST["numCa43"]<=0)) {
        $_POST["numCa13"]=$_POST["numCa33"];
    }
    if (($_POST["numCa13"]=="" || $_POST["numCa13"]<=0) && ($_POST["numCa43"]>0) &&
        ($_POST["numCa23"]=="" || $_POST["numCa23"]<=0) && ($_POST["numCa33"]=="" || $_POST["numCa33"]<=0)) {
        $_POST["numCa13"]=$_POST["numCa43"];
    }
    if (($_POST["numCa14"]=="" || $_POST["numCa14"]<=0) && ($_POST["numCa24"]>0) &&
        ($_POST["numCa34"]=="" || $_POST["numCa34"]<=0) && ($_POST["numCa44"]=="" || $_POST["numCa44"]<=0)) {
        $_POST["numCa14"]=$_POST["numCa24"];
    }
    if (($_POST["numCa14"]=="" || $_POST["numCa14"]<=0) && ($_POST["numCa34"]>0) &&
        ($_POST["numCa24"]=="" || $_POST["numCa24"]<=0) && ($_POST["numCa44"]=="" || $_POST["numCa44"]<=0)) {
        $_POST["numCa14"]=$_POST["numCa34"];
    }
    if (($_POST["numCa14"]=="" || $_POST["numCa14"]<=0) && ($_POST["numCa44"]>0) &&
        ($_POST["numCa24"]=="" || $_POST["numCa24"]<=0) && ($_POST["numCa34"]=="" || $_POST["numCa34"]<=0)) {
        $_POST["numCa14"]=$_POST["numCa44"];
    }
    $exito=0;
    $z=0;
    if ($_POST["numCa11"]>0 && $_POST["numCa11"]!="") { // si esta definido 1er caballo LINEA 1
        if (isset($_POST["per1"])) { //inicio permuta 1
            $tp1=9;
        } //fin permuta 1
        //superfecta
        if (isset($_POST["numCa11"]) && isset($_POST["numCa21"]) && isset($_POST["numCa31"]) && isset($_POST["numCa41"]) &&
            $_POST["numCa11"]>0 && $_POST["numCa21"]>0 && $_POST["numCa31"]>0 && $_POST["numCa41"]>0) {
            if ($_POST["numCa11"]!=$_POST["numCa21"] && $_POST["numCa11"]!=$_POST["numCa31"] &&
                $_POST["numCa11"]!=$_POST["numCa41"] && $_POST["numCa21"]!=$_POST["numCa31"] &&
                $_POST["numCa21"]!=$_POST["numCa41"] && $_POST["numCa31"]!=$_POST["numCa41"]) {
                if ($tp1==0) {
                    $tp1=6;
                }
                if ($_POST["numCa11"]<=$cCab && $_POST["numCa21"]<=$cCab && $_POST["numCa31"]<=$cCab &&
                    $_POST["numCa41"]<=$cCab) {
                    $ju1=$_POST["numCa11"]."-".$_POST["numCa21"]."-".$_POST["numCa31"]."-".$_POST["numCa41"];
                } else {
                    $maxCa=1;
                }
            }
        } else {
            if ((isset($_POST["numCa11"]) && isset($_POST["numCa21"]) && isset($_POST["numCa31"]) &&
                ($_POST["numCa11"]>0 && $_POST["numCa21"]>0 && $_POST["numCa31"]>0) &&
                ($_POST["numCa11"]!=$_POST["numCa21"] && $_POST["numCa11"]!=$_POST["numCa31"] &&
                 $_POST["numCa21"]!=$_POST["numCa31"])) ||
                (isset($_POST["numCa11"]) && isset($_POST["numCa21"]) && isset($_POST["numCa41"]) &&
                ($_POST["numCa11"]>0 && $_POST["numCa21"]>0 && $_POST["numCa41"]>0) &&
                ($_POST["numCa11"]!=$_POST["numCa21"]) && $_POST["numCa11"]!=$_POST["numCa41"] &&
                 $_POST["numCa21"]!=$_POST["numCa41"]) ||
                (isset($_POST["numCa21"]) && isset($_POST["numCa31"]) && isset($_POST["numCa41"]) &&
                ($_POST["numCa21"]>0 && $_POST["numCa31"]>0 && $_POST["numCa41"]>0) &&
                ($_POST["numCa21"]!=$_POST["numCa31"] && $_POST["numCa31"]!=$_POST["numCa41"]) &&
                $_POST["numCa21"]!=$_POST["numCa41"])) {
                if ($tp1==0) {
                    $tp1=5;
                } else {
                    $tp1=$tp1-1;
                }
                if ($_POST["numCa11"]>0 && $_POST["numCa21"]>0 && $_POST["numCa31"]>0 &&
                        $_POST["numCa11"]!=$_POST["numCa21"] && $_POST["numCa11"]!=$_POST["numCa31"] &&
                        $_POST["numCa21"]!=$_POST["numCa31"]) {
                    if ($_POST["numCa11"]<=$cCab && $_POST["numCa21"]<=$cCab && $_POST["numCa31"]<=$cCab) {
                        $ju1=$_POST["numCa11"]."-".$_POST["numCa21"]."-".$_POST["numCa31"];
                    } else {
                        $maxCa=1;
                    }
                }
                if ($_POST["numCa11"]>0 && $_POST["numCa31"]>0 && $_POST["numCa41"]>0 &&
                        $_POST["numCa11"]!=$_POST["numCa31"] && $_POST["numCa11"]!=$_POST["numCa41"] &&
                        $_POST["numCa31"]!=$_POST["numCa41"]) {
                    if ($_POST["numCa11"]<=$cCab && $_POST["numCa31"]<=$cCab && $_POST["numCa41"]<=$cCab) {
                        $ju1=$_POST["numCa11"]."-".$_POST["numCa31"]."-".$_POST["numCa41"];
                    } else {
                        $maxCa=1;
                    }
                }
                if ($_POST["numCa21"]>0 && $_POST["numCa31"]>0 && $_POST["numCa41"]>0 &&
                        $_POST["numCa21"]!=$_POST["numCa31"] && $_POST["numCa31"]!=$_POST["numCa41"] &&
                        $_POST["numCa21"]!=$_POST["numCa41"]) {
                    if ($_POST["numCa21"]<=$cCab && $_POST["numCa31"]<=$cCab && $_POST["numCa41"]<=$cCab) {
                        $ju1=$_POST["numCa21"]."-".$_POST["numCa31"]."-".$_POST["numCa41"];
                    } else {
                        $maxCa=1;
                    }
                }
            } else {
                if ((isset($_POST["numCa11"]) && isset($_POST["numCa21"]) && $_POST["numCa11"]>0 && $_POST["numCa21"]>0 &&
                    $_POST["numCa11"]!=$_POST["numCa21"] && $_POST["numCa31"]=="" && $_POST["numCa41"]=="") ||
                    (isset($_POST["numCa11"]) && isset($_POST["numCa31"]) && $_POST["numCa11"]>0 && $_POST["numCa31"]>0 &&
                    $_POST["numCa11"]!=$_POST["numCa31"] && $_POST["numCa21"]=="" && $_POST["numCa41"]=="") ||
                    (isset($_POST["numCa11"]) && isset($_POST["numCa41"]) && $_POST["numCa11"]>0 && $_POST["numCa41"]>0 &&
                    $_POST["numCa11"]!=$_POST["numCa41"]&& $_POST["numCa21"]=="" && $_POST["numCa31"]=="") ||
                    (isset($_POST["numCa21"]) && isset($_POST["numCa31"]) && $_POST["numCa21"]>0 && $_POST["numCa31"]>0 &&
                    $_POST["numCa21"]!=$_POST["numCa31"]&& $_POST["numCa11"]=="" && $_POST["numCa41"]=="") ||
                    (isset($_POST["numCa21"]) && isset($_POST["numCa41"]) && $_POST["numCa21"]>0 && $_POST["numCa41"]>0 &&
                    $_POST["numCa21"]!=$_POST["numCa41"]&& $_POST["numCa11"]=="" && $_POST["numCa31"]=="") ||
                    (isset($_POST["numCa31"]) && isset($_POST["numCa41"]) && $_POST["numCa31"]>0 && $_POST["numCa41"]>0) &&
                    $_POST["numCa31"]!=$_POST["numCa41"]&& $_POST["numCa11"]=="" && $_POST["numCa21"]=="") {
                    if ($tp1==0) {
                        $tp1=4;
                    } else {
                        $tp1=$tp1-2;
                    }
                    if ($_POST["numCa11"]>0 && $_POST["numCa21"]>0 &&
                            $_POST["numCa11"]!=$_POST["numCa21"] && $_POST["numCa31"]=="" && $_POST["numCa41"]=="") {
                        if ($_POST["numCa11"]<=$cCab && $_POST["numCa21"]<=$cCab) {
                            $ju1=$_POST["numCa11"]."-".$_POST["numCa21"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa11"]>0 && $_POST["numCa31"]>0 &&
                            $_POST["numCa11"]!=$_POST["numCa31"] && $_POST["numCa21"]=="" && $_POST["numCa41"]=="") {
                        if ($_POST["numCa11"]<=$cCab && $_POST["numCa31"]<=$cCab) {
                            $ju1=$_POST["numCa11"]."-".$_POST["numCa31"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa11"]>0 && $_POST["numCa41"]>0 &&
                            $_POST["numCa11"]!=$_POST["numCa41"] && $_POST["numCa21"]=="" && $_POST["numCa31"]=="") {
                        if ($_POST["numCa11"]<=$cCab && $_POST["numCa41"]<=$cCab) {
                            $ju1=$_POST["numCa11"]."-".$_POST["numCa41"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa21"]>0 && $_POST["numCa31"]>0 &&
                            $_POST["numCa21"]!=$_POST["numCa31"] && $_POST["numCa11"]=="" && $_POST["numCa41"]=="") {
                        if ($_POST["numCa21"]<=$cCab && $_POST["numCa31"]<=$cCab) {
                            $ju1=$_POST["numCa21"]."-".$_POST["numCa31"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa31"]>0 && $_POST["numCa41"]>0 &&
                            $_POST["numCa31"]!=$_POST["numCa41"] && $_POST["numCa11"]=="" && $_POST["numCa21"]=="") {
                        if ($_POST["numCa31"]<=$cCab && $_POST["numCa41"]<=$cCab) {
                            $ju1=$_POST["numCa31"]."-".$_POST["numCa41"];
                        } else {
                            $maxCa=1;
                        }
                    }
                }
            }
        }
        if ($_POST["numCa11"]>0 && (!isset($_POST["per1"])) && $tp1==0) {
            if ($_POST["monGan1"]>0 && ($_POST["monPla1"]==0 || $_POST["monPla1"]=="")
                && ($_POST["monSho1"]==0 || $_POST["monSho1"]=="")) {
                $tp1=1;
                if ($_POST["numCa11"]<=$cCab) {
                    $ju1=$_POST["numCa11"];
                }
            } else {
                if ($_POST["monGan1"]>0 && $_POST["monPla1"]>0 && ($_POST["monSho1"]==0 || $_POST["monSho1"]=="")) {
                    $tp1=12;
                    if ($_POST["numCa11"]<=$cCab) {
                        $ju1=$_POST["numCa11"];
                    }
                } else {
                    if ($_POST["monGan1"]>0 && $_POST["monPla1"]>0 && $_POST["monSho1"]>0) {
                        $tp1=123;
                        if ($_POST["numCa11"]<=$cCab) {
                            $ju1=$_POST["numCa11"];
                        }
                    }
                }
            }
            if ($_POST["monPla1"]>0 && ($_POST["monGan1"]==0 || $_POST["monGan1"]=="") &&
                ($_POST["monSho1"]==0 || $_POST["monSho1"]=="")) {
                $tp1=2;
                if ($_POST["numCa11"]<=$cCab) {
                    $ju1=$_POST["numCa11"];
                }
            } else {
                if ($_POST["monPla1"]>0 && $_POST["monSho1"]>0 && ($_POST["monGan1"]==0 || $_POST["monGan1"]=="")) {
                    $tp1=23;
                    if ($_POST["numCa11"]<=$cCab) {
                        $ju1=$_POST["numCa11"];
                    }
                }
            }
            if ($_POST["monGan1"]>0 && ($_POST["monPla1"]==0 || $_POST["monPla1"]=="") && $_POST["monSho1"]>0) {
                $tp1=13;
                if ($_POST["numCa11"]<=$cCab) {
                    $ju1=$_POST["numCa11"];
                }
            } else {
                if (($_POST["monGan1"]==0 || $_POST["monGan1"]=="") && ($_POST["monPla1"]==0 || $_POST["monPla1"]=="") &&
                    $_POST["monSho1"]>0) {
                    $tp1=3;
                    if ($_POST["numCa11"]<=$cCab) {
                        $ju1=$_POST["numCa11"];
                    }
                }
            }
        }
        if ($maxCa==0 && $tp1!=0 && $ju1!=0) {// si no existen ejemplares retirados seleccionados
            if ($tp1==1 || $tp1==2 || $tp1==3 || $tp1==12 || $tp1==13 || $tp1==23 || $tp1==123) {
                $sRetiro1=RetiradosSimple($_POST['cod_carrera'], $ju1); // verifica estado de retirado
                if ($sRetiro1==0) {
                    if ($tp1==1 && ($_POST["monGan1"]>0 || $_POST["monGan1"]!="")) {
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monGan1"];
                        $tipo[$z]=1;
                        $z++;
                    }
                    if ($tp1==2 && ($_POST["monPla1"]>0 || $_POST["monPla1"]!="")) {
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monPla1"];
                        $tipo[$z]=2;
                        $z++;
                    }
                    if ($tp1==3 && ($_POST["monSho1"]>0 || $_POST["monSho1"]!="")) {
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monSho1"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp1==12 && ($_POST["monGan1"]>0 || $_POST["monGan1"]!="") &&
                        ($_POST["monPla1"]>0 || $_POST["monPla1"]!="")) {
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monGan1"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monPla1"];
                        $tipo[$z]=2;
                        $z++;
                    }
                    if ($tp1==13 && ($_POST["monGan1"]>0 || $_POST["monGan1"]!="") &&
                        ($_POST["monSho1"]>0 || $_POST["monSho1"]!="")) {
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monGan1"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monSho1"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp1==23 && ($_POST["monPla1"]>0 || $_POST["monPla1"]!="") &&
                        ($_POST["monSho1"]>0 || $_POST["monSho1"]!="")) {
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monPla1"];
                        $tipo[$z]=2;
                        $z++;
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monSho1"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp1==123 && ($_POST["monGan1"]>0 || $_POST["monGan1"]!="") &&
                        ($_POST["monPla1"]>0 || $_POST["monPla1"]!="") &&
                        ($_POST["monSho1"]>0 || $_POST["monSho1"]!="")) {
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monGan1"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monPla1"];
                        $tipo[$z]=2;
                        $z++;
                        $apuesta[$z]=$ju1;
                        $monto[$z]=$_POST["monSho1"];
                        $tipo[$z]=3;
                        $z++;
                    }
                } else {
                    $mensaje1="[".$ju1."]";
                } // mensaje de caballo retirado
            } else {
                if ($tp1==4 || $tp1==5 || $tp1==6 || $tp1==7 || $tp1==8 || $tp1==9) { //
                    $du=explode("-", $ju1);
                    foreach ($du as $ejem) {
                        $sRetiro1=RetiradosSimple($_POST['cod_carrera'], $ejem); // verifica estado de retirado
                        if ($sRetiro1==1) {
                            $mensaje1="[".$ju1."]";
                            break;
                        }
                    }
                    if ($sRetiro1==0) {
                        if ($_POST["monSho1"]>0) {
                            $monto[$z]=$_POST["monSho1"];
                        }
                        if ($_POST["monPla1"]>0) {
                            $monto[$z]=$_POST["monPla1"];
                        }
                        if ($_POST["monGan1"]>0) {
                            $monto[$z]=$_POST["monGan1"];
                        }
                        $apuesta[$z]=$ju1;
                        $tipo[$z]=$tp1;
                        $z++;
                    }
                }
            }
            if ($sRetiro1==0 && ($_POST["monGan1"]>0 || $_POST["monPla1"]>0 || $_POST["monSho1"]>0)) {
                if ($fechacarrerabd == $FechaTxt && $horacarrerabd > $horaTxt && $statuscarrerabd == 1) {
                    $f=1;
                    $exito=1;
                } else {
                    if ($fechacarrerabd != $FechaTxt) {
                        $fueFec=0;
                    }
                    if ($horacarrerabd < $horaTxt || $statuscarrerabd!= 1) {
                        $fueHor=0;
                    }
                }
            }
            //echo $apuesta[1]." ".$monto[1]."<br/>";
        } //fin no existen ejemplares retirados seleccionados
    } // fin si esta definido 1er caballo
    
/************************************************************* 2 ************************************************************/
    if ($_POST["numCa12"]>0 && $_POST["numCa12"]!="") {  // si esta definido 2do caballo LINEA 2
        if (isset($_POST["per2"])) { //inicio permuta 2
            $tp2=9;
        } //fin permuta 1
        //superfecta
        if (isset($_POST["numCa12"]) && isset($_POST["numCa22"]) && isset($_POST["numCa32"]) && isset($_POST["numCa42"]) &&
            $_POST["numCa12"]>0 && $_POST["numCa22"]>0 && $_POST["numCa32"]>0 && $_POST["numCa42"]>0) {
            if ($_POST["numCa12"]!=$_POST["numCa22"] && $_POST["numCa12"]!=$_POST["numCa32"] &&
                $_POST["numCa12"]!=$_POST["numCa42"] && $_POST["numCa22"]!=$_POST["numCa32"] &&
                $_POST["numCa22"]!=$_POST["numCa42"] && $_POST["numCa32"]!=$_POST["numCa42"]) {
                if ($tp2==0) {
                    $tp2=6;
                }
                if ($_POST["numCa12"]<=$cCab && $_POST["numCa22"]<=$cCab && $_POST["numCa32"]<=$cCab &&
                    $_POST["numCa42"]<=$cCab) {
                    $ju2=$_POST["numCa12"]."-".$_POST["numCa22"]."-".$_POST["numCa32"]."-".$_POST["numCa42"];
                } else {
                    $maxCa=1;
                }
            }
        } else {
            if ((isset($_POST["numCa12"]) && isset($_POST["numCa22"]) && isset($_POST["numCa32"]) &&
                ($_POST["numCa12"]>0 && $_POST["numCa22"]>0 && $_POST["numCa32"]>0) &&
                ($_POST["numCa12"]!=$_POST["numCa22"] && $_POST["numCa12"]!=$_POST["numCa32"] &&
                 $_POST["numCa22"]!=$_POST["numCa32"])) ||
                (isset($_POST["numCa12"]) && isset($_POST["numCa22"]) && isset($_POST["numCa42"]) &&
                ($_POST["numCa12"]>0 && $_POST["numCa22"]>0 && $_POST["numCa42"]>0) &&
                ($_POST["numCa12"]!=$_POST["numCa22"]) && $_POST["numCa12"]!=$_POST["numCa42"] &&
                 $_POST["numCa22"]!=$_POST["numCa42"]) ||
                (isset($_POST["numCa22"]) && isset($_POST["numCa32"]) && isset($_POST["numCa42"]) &&
                ($_POST["numCa22"]>0 && $_POST["numCa32"]>0 && $_POST["numCa42"]>0) &&
                ($_POST["numCa22"]!=$_POST["numCa32"] && $_POST["numCa32"]!=$_POST["numCa42"]) &&
                $_POST["numCa22"]!=$_POST["numCa42"])) {
                if ($tp2==0) {
                    $tp2=5;
                } else {
                    $tp2=$tp2-1;
                }
                if ($_POST["numCa12"]>0 && $_POST["numCa22"]>0 && $_POST["numCa32"]>0 &&
                        $_POST["numCa12"]!=$_POST["numCa22"] && $_POST["numCa12"]!=$_POST["numCa32"] &&
                        $_POST["numCa22"]!=$_POST["numCa32"]) {
                    if ($_POST["numCa12"]<=$cCab && $_POST["numCa22"]<=$cCab && $_POST["numCa32"]<=$cCab) {
                        $ju2=$_POST["numCa12"]."-".$_POST["numCa22"]."-".$_POST["numCa32"];
                    } else {
                        $maxCa=1;
                    }
                }
                if ($_POST["numCa12"]>0 && $_POST["numCa32"]>0 && $_POST["numCa42"]>0 &&
                        $_POST["numCa12"]!=$_POST["numCa32"] && $_POST["numCa12"]!=$_POST["numCa42"] &&
                        $_POST["numCa32"]!=$_POST["numCa42"]) {
                    if ($_POST["numCa12"]<=$cCab && $_POST["numCa32"]<=$cCab && $_POST["numCa42"]<=$cCab) {
                        $ju2=$_POST["numCa12"]."-".$_POST["numCa32"]."-".$_POST["numCa42"];
                    } else {
                        $maxCa=1;
                    }
                }
                if ($_POST["numCa22"]>0 && $_POST["numCa32"]>0 && $_POST["numCa42"]>0 &&
                        $_POST["numCa22"]!=$_POST["numCa32"] && $_POST["numCa32"]!=$_POST["numCa42"] &&
                        $_POST["numCa22"]!=$_POST["numCa42"]) {
                    if ($_POST["numCa22"]<=$cCab && $_POST["numCa32"]<=$cCab && $_POST["numCa42"]<=$cCab) {
                        $ju2=$_POST["numCa22"]."-".$_POST["numCa32"]."-".$_POST["numCa42"];
                    } else {
                        $maxCa=1;
                    }
                }
            } else {
                if ((isset($_POST["numCa12"]) && isset($_POST["numCa22"]) && $_POST["numCa12"]>0 && $_POST["numCa22"]>0 &&
                    $_POST["numCa12"]!=$_POST["numCa22"] && $_POST["numCa32"]=="" && $_POST["numCa42"]=="") ||
                    (isset($_POST["numCa12"]) && isset($_POST["numCa32"]) && $_POST["numCa12"]>0 && $_POST["numCa32"]>0 &&
                    $_POST["numCa12"]!=$_POST["numCa32"] && $_POST["numCa22"]=="" && $_POST["numCa42"]=="") ||
                    (isset($_POST["numCa12"]) && isset($_POST["numCa42"]) && $_POST["numCa12"]>0 && $_POST["numCa42"]>0 &&
                    $_POST["numCa12"]!=$_POST["numCa42"]&& $_POST["numCa22"]=="" && $_POST["numCa32"]=="") ||
                    (isset($_POST["numCa22"]) && isset($_POST["numCa32"]) && $_POST["numCa22"]>0 && $_POST["numCa32"]>0 &&
                    $_POST["numCa22"]!=$_POST["numCa32"]&& $_POST["numCa12"]=="" && $_POST["numCa42"]=="") ||
                    (isset($_POST["numCa22"]) && isset($_POST["numCa42"]) && $_POST["numCa22"]>0 && $_POST["numCa42"]>0 &&
                    $_POST["numCa22"]!=$_POST["numCa42"]&& $_POST["numCa12"]=="" && $_POST["numCa32"]=="") ||
                    (isset($_POST["numCa32"]) && isset($_POST["numCa42"]) && $_POST["numCa32"]>0 && $_POST["numCa42"]>0) &&
                    $_POST["numCa32"]!=$_POST["numCa42"]&& $_POST["numCa12"]=="" && $_POST["numCa22"]=="") {
                    if ($tp2==0) {
                        $tp2=4;
                    } else {
                        $tp2=$tp2-2;
                    }
                    if ($_POST["numCa12"]>0 && $_POST["numCa22"]>0 &&
                            $_POST["numCa12"]!=$_POST["numCa22"] && $_POST["numCa32"]=="" && $_POST["numCa42"]=="") {
                        if ($_POST["numCa12"]<=$cCab && $_POST["numCa22"]<=$cCab) {
                            $ju2=$_POST["numCa12"]."-".$_POST["numCa22"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa12"]>0 && $_POST["numCa32"]>0 &&
                            $_POST["numCa12"]!=$_POST["numCa32"] && $_POST["numCa22"]=="" && $_POST["numCa42"]=="") {
                        if ($_POST["numCa12"]<=$cCab && $_POST["numCa32"]<=$cCab) {
                            $ju2=$_POST["numCa12"]."-".$_POST["numCa32"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa12"]>0 && $_POST["numCa42"]>0 &&
                            $_POST["numCa12"]!=$_POST["numCa42"] && $_POST["numCa22"]=="" && $_POST["numCa32"]=="") {
                        if ($_POST["numCa12"]<=$cCab && $_POST["numCa42"]<=$cCab) {
                            $ju2=$_POST["numCa12"]."-".$_POST["numCa42"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa22"]>0 && $_POST["numCa32"]>0 &&
                            $_POST["numCa22"]!=$_POST["numCa32"] && $_POST["numCa12"]=="" && $_POST["numCa42"]=="") {
                        if ($_POST["numCa22"]<=$cCab && $_POST["numCa32"]<=$cCab) {
                            $ju2=$_POST["numCa22"]."-".$_POST["numCa32"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa32"]>0 && $_POST["numCa42"]>0 &&
                            $_POST["numCa32"]!=$_POST["numCa42"] && $_POST["numCa12"]=="" && $_POST["numCa22"]=="") {
                        if ($_POST["numCa32"]<=$cCab && $_POST["numCa42"]<=$cCab) {
                            $ju2=$_POST["numCa32"]."-".$_POST["numCa42"];
                        } else {
                            $maxCa=1;
                        }
                    }
                }
            }
        }
        if ($_POST["numCa12"]>0 && (!isset($_POST["per2"])) && $tp2==0) {
            if ($_POST["monGan2"]>0 && ($_POST["monPla2"]==0 || $_POST["monPla2"]=="")
                && ($_POST["monSho2"]==0 || $_POST["monSho2"]=="")) {
                $tp2=1;
                if ($_POST["numCa12"]<=$cCab) {
                    $ju2=$_POST["numCa12"];
                }
            } else {
                if ($_POST["monGan2"]>0 && $_POST["monPla2"]>0 && ($_POST["monSho2"]==0 || $_POST["monSho2"]=="")) {
                    $tp2=12;
                    if ($_POST["numCa12"]<=$cCab) {
                        $ju2=$_POST["numCa12"];
                    }
                } else {
                    if ($_POST["monGan2"]>0 && $_POST["monPla2"]>0 && $_POST["monSho2"]>0) {
                        $tp2=123;
                        if ($_POST["numCa12"]<=$cCab) {
                            $ju2=$_POST["numCa12"];
                        }
                    }
                }
            }
            if ($_POST["monPla2"]>0 && ($_POST["monGan2"]==0 || $_POST["monGan2"]=="") &&
                ($_POST["monSho2"]==0 || $_POST["monSho2"]=="")) {
                $tp2=2;
                if ($_POST["numCa12"]<=$cCab) {
                    $ju2=$_POST["numCa12"];
                }
            } else {
                if ($_POST["monPla2"]>0 && $_POST["monSho2"]>0 && ($_POST["monGan2"]==0 || $_POST["monGan2"]=="")) {
                    $tp2=23;
                    if ($_POST["numCa12"]<=$cCab) {
                        $ju2=$_POST["numCa12"];
                    }
                }
            }
            if ($_POST["monGan2"]>0 && ($_POST["monPla2"]==0 || $_POST["monPla2"]=="") && $_POST["monSho2"]>0) {
                $tp2=13;
                if ($_POST["numCa12"]<=$cCab) {
                    $ju2=$_POST["numCa12"];
                }
            } else {
                if (($_POST["monGan2"]==0 || $_POST["monGan2"]=="") && ($_POST["monPla2"]==0 || $_POST["monPla2"]=="") &&
                    $_POST["monSho2"]>0) {
                    $tp2=3;
                    if ($_POST["numCa12"]<=$cCab) {
                        $ju2=$_POST["numCa12"];
                    }
                }
            }
        }
        if ($maxCa==0 && $tp2!=0 && $ju2!=0) {// si no existen ejemplares retirados seleccionados
            //$z=0;
            if ($tp2==1 || $tp2==2 || $tp2==3 || $tp2==12 || $tp2==13 || $tp2==23 || $tp2==123) {
                $sRetiro2=RetiradosSimple($_POST['cod_carrera'], $ju2); // verifica estado de retirado
                if ($sRetiro2==0) {
                    if ($tp2==1 && ($_POST["monGan2"]>0 || $_POST["monGan2"]!="")) {
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monGan2"];
                        $tipo[$z]=1;
                        $z++;
                    }
                    if ($tp2==2 && ($_POST["monPla2"]>0 || $_POST["monPla2"]!="")) {
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monPla2"];
                        $tipo[$z]=2;
                        $z++;
                    }
                    if ($tp2==3 && ($_POST["monSho2"]>0 || $_POST["monSho2"]!="")) {
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monSho2"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp2==12 && ($_POST["monGan2"]>0 || $_POST["monGan2"]!="") &&
                        ($_POST["monPla2"]>0 || $_POST["monPla2"]!="")) {
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monGan2"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monPla2"];
                        $tipo[$z]=2;
                        $z++;
                    }
                    if ($tp2==13 && ($_POST["monGan2"]>0 || $_POST["monGan2"]!="") &&
                        ($_POST["monSho2"]>0 || $_POST["monSho2"]!="")) {
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monGan2"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monSho2"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp2==23 && ($_POST["monPla2"]>0 || $_POST["monPla2"]!="") &&
                        ($_POST["monSho2"]>0 || $_POST["monSho2"]!="")) {
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monPla2"];
                        $tipo[$z]=2;
                        $z++;
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monSho2"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp2==123 && ($_POST["monGan2"]>0 || $_POST["monGan2"]!="") &&
                        ($_POST["monPla2"]>0 || $_POST["monPla2"]!="") &&
                        ($_POST["monSho2"]>0 || $_POST["monSho2"]!="")) {
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monGan2"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monPla2"];
                        $tipo[$z]=2;
                        $z++;
                        $apuesta[$z]=$ju2;
                        $monto[$z]=$_POST["monSho2"];
                        $tipo[$z]=3;
                        $z++;
                    }
                } else {
                    $mensaje2="[".$ju2."]";
                } // mensaje de caballo retirado***************************************
            } else {
                if ($tp2==4 || $tp2==5 || $tp2==6 || $tp2==7 || $tp2==8 || $tp2==9) { //
                    $du=explode("-", $ju2);
                    foreach ($du as $ejem) {
                        $sRetiro2=RetiradosSimple($_POST['cod_carrera'], $ejem); // verifica estado de retirado
                        if ($sRetiro2==1) {
                            $mensaje2="[".$ju2."]";
                            break;
                        }
                    }
                    if ($sRetiro2==0) {
                        if ($_POST["monSho2"]>0) {
                            $monto[$z]=$_POST["monSho2"];
                        }
                        if ($_POST["monPla2"]>0) {
                            $monto[$z]=$_POST["monPla2"];
                        }
                        if ($_POST["monGan2"]>0) {
                            $monto[$z]=$_POST["monGan2"];
                        }
                        
                        $apuesta[$z]=$ju2;
                        $tipo[$z]=$tp2;
                        $z++;
                    }
                }
            }
            if ($sRetiro2==0 && ($_POST["monGan2"]>0 || $_POST["monPla2"]>0 || $_POST["monSho2"]>0)) {
                if ($fechacarrerabd == $FechaTxt && $horacarrerabd > $horaTxt && $statuscarrerabd == 1) {
                    $f=1;
                    $exito=1;
                } else {
                    if ($fechacarrerabd != $FechaTxt) {
                        $fueFec=0;
                    }
                    if ($horacarrerabd < $horaTxt || $statuscarrerabd!= 1) {
                        $fueHor=0;
                    }
                }
            }
            //echo $apuesta[1]." ".$monto[1]."<br/>";
        } //fin no existen ejemplares retirados seleccionados
    } // fin si esta definido 2DO caballo
/************************************************************* 3 ************************************************************/
    if ($_POST["numCa13"]>0 && $_POST["numCa13"]!="") {  // si esta definido 3r caballo LINEA 3
        if (isset($_POST["per3"])) { //inicio permuta 2
            $tp3=9;
        } //fin permuta 1
        //superfecta
        if (isset($_POST["numCa13"]) && isset($_POST["numCa23"]) && isset($_POST["numCa33"]) && isset($_POST["numCa43"]) &&
            $_POST["numCa13"]>0 && $_POST["numCa23"]>0 && $_POST["numCa33"]>0 && $_POST["numCa43"]>0) {
            if ($_POST["numCa13"]!=$_POST["numCa23"] && $_POST["numCa13"]!=$_POST["numCa33"] &&
                $_POST["numCa12"]!=$_POST["numCa43"] && $_POST["numCa23"]!=$_POST["numCa33"] &&
                $_POST["numCa22"]!=$_POST["numCa43"] && $_POST["numCa33"]!=$_POST["numCa43"]) {
                if ($tp3==0) {
                    $tp3=6;
                }
                if ($_POST["numCa13"]<=$cCab && $_POST["numCa23"]<=$cCab && $_POST["numCa33"]<=$cCab &&
                    $_POST["numCa43"]<=$cCab) {
                    $ju3=$_POST["numCa13"]."-".$_POST["numCa23"]."-".$_POST["numCa33"]."-".$_POST["numCa43"];
                } else {
                    $maxCa=1;
                }
            }
        } else {
            if ((isset($_POST["numCa13"]) && isset($_POST["numCa23"]) && isset($_POST["numCa33"]) &&
                ($_POST["numCa13"]>0 && $_POST["numCa23"]>0 && $_POST["numCa33"]>0) &&
                ($_POST["numCa13"]!=$_POST["numCa23"] && $_POST["numCa13"]!=$_POST["numCa33"] &&
                 $_POST["numCa23"]!=$_POST["numCa33"])) ||
                (isset($_POST["numCa13"]) && isset($_POST["numCa23"]) && isset($_POST["numCa43"]) &&
                ($_POST["numCa13"]>0 && $_POST["numCa23"]>0 && $_POST["numCa43"]>0) &&
                ($_POST["numCa13"]!=$_POST["numCa23"]) && $_POST["numCa13"]!=$_POST["numCa43"] &&
                 $_POST["numCa23"]!=$_POST["numCa43"]) ||
                (isset($_POST["numCa23"]) && isset($_POST["numCa33"]) && isset($_POST["numCa43"]) &&
                ($_POST["numCa23"]>0 && $_POST["numCa33"]>0 && $_POST["numCa43"]>0) &&
                ($_POST["numCa23"]!=$_POST["numCa33"] && $_POST["numCa33"]!=$_POST["numCa43"]) &&
                $_POST["numCa23"]!=$_POST["numCa43"])) {
                if ($tp3==0) {
                    $tp3=5;
                } else {
                    $tp3=$tp3-1;
                }
                if ($_POST["numCa13"]>0 && $_POST["numCa23"]>0 && $_POST["numCa33"]>0 &&
                        $_POST["numCa13"]!=$_POST["numCa23"] && $_POST["numCa13"]!=$_POST["numCa33"] &&
                        $_POST["numCa23"]!=$_POST["numCa33"]) {
                    if ($_POST["numCa13"]<=$cCab && $_POST["numCa23"]<=$cCab && $_POST["numCa33"]<=$cCab) {
                        $ju3=$_POST["numCa13"]."-".$_POST["numCa23"]."-".$_POST["numCa33"];
                    } else {
                        $maxCa=1;
                    }
                }
                if ($_POST["numCa13"]>0 && $_POST["numCa33"]>0 && $_POST["numCa43"]>0 &&
                        $_POST["numCa13"]!=$_POST["numCa33"] && $_POST["numCa13"]!=$_POST["numCa43"] &&
                        $_POST["numCa33"]!=$_POST["numCa43"]) {
                    if ($_POST["numCa13"]<=$cCab && $_POST["numCa33"]<=$cCab && $_POST["numCa43"]<=$cCab) {
                        $ju3=$_POST["numCa13"]."-".$_POST["numCa33"]."-".$_POST["numCa43"];
                    } else {
                        $maxCa=1;
                    }
                }
                if ($_POST["numCa23"]>0 && $_POST["numCa33"]>0 && $_POST["numCa43"]>0 &&
                        $_POST["numCa23"]!=$_POST["numCa33"] && $_POST["numCa33"]!=$_POST["numCa43"] &&
                        $_POST["numCa23"]!=$_POST["numCa43"]) {
                    if ($_POST["numCa23"]<=$cCab && $_POST["numCa33"]<=$cCab && $_POST["numCa43"]<=$cCab) {
                        $ju3=$_POST["numCa23"]."-".$_POST["numCa33"]."-".$_POST["numCa43"];
                    } else {
                        $maxCa=1;
                    }
                }
            } else {
                if ((isset($_POST["numCa13"]) && isset($_POST["numCa23"]) && $_POST["numCa13"]>0 && $_POST["numCa23"]>0 &&
                    $_POST["numCa13"]!=$_POST["numCa23"] && $_POST["numCa33"]=="" && $_POST["numCa43"]=="") ||
                    (isset($_POST["numCa13"]) && isset($_POST["numCa33"]) && $_POST["numCa13"]>0 && $_POST["numCa33"]>0 &&
                    $_POST["numCa13"]!=$_POST["numCa33"] && $_POST["numCa23"]=="" && $_POST["numCa43"]=="") ||
                    (isset($_POST["numCa13"]) && isset($_POST["numCa43"]) && $_POST["numCa13"]>0 && $_POST["numCa43"]>0 &&
                    $_POST["numCa13"]!=$_POST["numCa43"]&& $_POST["numCa23"]=="" && $_POST["numCa33"]=="") ||
                    (isset($_POST["numCa23"]) && isset($_POST["numCa33"]) && $_POST["numCa23"]>0 && $_POST["numCa33"]>0 &&
                    $_POST["numCa23"]!=$_POST["numCa33"]&& $_POST["numCa13"]=="" && $_POST["numCa43"]=="") ||
                    (isset($_POST["numCa23"]) && isset($_POST["numCa43"]) && $_POST["numCa23"]>0 && $_POST["numCa43"]>0 &&
                    $_POST["numCa23"]!=$_POST["numCa43"]&& $_POST["numCa13"]=="" && $_POST["numCa33"]=="") ||
                    (isset($_POST["numCa33"]) && isset($_POST["numCa43"]) && $_POST["numCa33"]>0 && $_POST["numCa43"]>0) &&
                    $_POST["numCa33"]!=$_POST["numCa43"]&& $_POST["numCa13"]=="" && $_POST["numCa23"]=="") {
                    if ($tp3==0) {
                        $tp3=4;
                    } else {
                        $tp3=$tp3-2;
                    }
                    if ($_POST["numCa13"]>0 && $_POST["numCa23"]>0 &&
                            $_POST["numCa13"]!=$_POST["numCa23"] && $_POST["numCa33"]=="" && $_POST["numCa43"]=="") {
                        if ($_POST["numCa13"]<=$cCab && $_POST["numCa23"]<=$cCab) {
                            $ju3=$_POST["numCa13"]."-".$_POST["numCa23"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa13"]>0 && $_POST["numCa33"]>0 &&
                            $_POST["numCa13"]!=$_POST["numCa33"] && $_POST["numCa23"]=="" && $_POST["numCa43"]=="") {
                        if ($_POST["numCa13"]<=$cCab && $_POST["numCa33"]<=$cCab) {
                            $ju3=$_POST["numCa13"]."-".$_POST["numCa33"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa13"]>0 && $_POST["numCa43"]>0 &&
                            $_POST["numCa13"]!=$_POST["numCa43"] && $_POST["numCa23"]=="" && $_POST["numCa33"]=="") {
                        if ($_POST["numCa13"]<=$cCab && $_POST["numCa43"]<=$cCab) {
                            $ju3=$_POST["numCa13"]."-".$_POST["numCa43"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa23"]>0 && $_POST["numCa33"]>0 &&
                            $_POST["numCa23"]!=$_POST["numCa33"] && $_POST["numCa13"]=="" && $_POST["numCa43"]=="") {
                        if ($_POST["numCa23"]<=$cCab && $_POST["numCa33"]<=$cCab) {
                            $ju3=$_POST["numCa22"]."-".$_POST["numCa33"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa33"]>0 && $_POST["numCa43"]>0 &&
                            $_POST["numCa33"]!=$_POST["numCa43"] && $_POST["numCa13"]=="" && $_POST["numCa23"]=="") {
                        if ($_POST["numCa33"]<=$cCab && $_POST["numCa43"]<=$cCab) {
                            $ju3=$_POST["numCa33"]."-".$_POST["numCa43"];
                        } else {
                            $maxCa=1;
                        }
                    }
                }
            }
        }
        if ($_POST["numCa13"]>0	&& (!isset($_POST["per3"])) && $tp3==0) {
            if ($_POST["monGan3"]>0 && ($_POST["monPla3"]==0 || $_POST["monPla3"]=="")
                && ($_POST["monSho3"]==0 || $_POST["monSho3"]=="")) {
                $tp3=1;
                if ($_POST["numCa13"]<=$cCab) {
                    $ju3=$_POST["numCa13"];
                }
            } else {
                if ($_POST["monGan3"]>0 && $_POST["monPla3"]>0 && ($_POST["monSho3"]==0 || $_POST["monSho3"]=="")) {
                    $tp3=12;
                    if ($_POST["numCa13"]<=$cCab) {
                        $ju3=$_POST["numCa13"];
                    }
                } else {
                    if ($_POST["monGan3"]>0 && $_POST["monPla3"]>0 && $_POST["monSho3"]>0) {
                        $tp3=123;
                        if ($_POST["numCa13"]<=$cCab) {
                            $ju3=$_POST["numCa13"];
                        }
                    }
                }
            }
            if ($_POST["monPla3"]>0 && ($_POST["monGan3"]==0 || $_POST["monGan3"]=="") &&
                ($_POST["monSho3"]==0 || $_POST["monSho3"]=="")) {
                $tp3=2;
                if ($_POST["numCa13"]<=$cCab) {
                    $ju3=$_POST["numCa13"];
                }
            } else {
                if ($_POST["monPla3"]>0 && $_POST["monSho3"]>0 && ($_POST["monGan3"]==0 || $_POST["monGan3"]=="")) {
                    $tp3=23;
                    if ($_POST["numCa13"]<=$cCab) {
                        $ju3=$_POST["numCa13"];
                    }
                }
            }
            if ($_POST["monGan3"]>0 && ($_POST["monPla3"]==0 || $_POST["monPla3"]=="") && $_POST["monSho3"]>0) {
                $tp3=13;
                if ($_POST["numCa13"]<=$cCab) {
                    $ju3=$_POST["numCa13"];
                }
            } else {
                if (($_POST["monGan3"]==0 || $_POST["monGan3"]=="") && ($_POST["monPla3"]==0 || $_POST["monPla3"]=="") &&
                    $_POST["monSho3"]>0) {
                    $tp3=3;
                    if ($_POST["numCa13"]<=$cCab) {
                        $ju3=$_POST["numCa13"];
                    }
                }
            }
        }
        if ($maxCa==0 && $tp3!=0 && $ju3!=0) {// si no existen ejemplares retirados seleccionados
            //$z=0;
            if ($tp3==1 || $tp3==2 || $tp3==3 || $tp3==12 || $tp3==13 || $tp3==23 || $tp3==123) {
                $sRetiro3=RetiradosSimple($_POST['cod_carrera'], $ju3); // verifica estado de retirado
                if ($sRetiro3==0) {
                    if ($tp3==1 && ($_POST["monGan3"]>0 || $_POST["monGan3"]!="")) {
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monGan3"];
                        $tipo[$z]=1;
                        $z++;
                    }
                    if ($tp3==2 && ($_POST["monPla3"]>0 || $_POST["monPla3"]!="")) {
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monPla3"];
                        $tipo[$z]=2;
                        $z++;
                    }
                    if ($tp3==3 && ($_POST["monSho3"]>0 || $_POST["monSho3"]!="")) {
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monSho3"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp3==12 && ($_POST["monGan3"]>0 || $_POST["monGan3"]!="") &&
                        ($_POST["monPla3"]>0 || $_POST["monPla3"]!="")) {
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monGan3"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monPla3"];
                        $tipo[$z]=2;
                        $z++;
                    }
                    if ($tp3==13 && ($_POST["monGan3"]>0 || $_POST["monGan3"]!="") &&
                        ($_POST["monSho3"]>0 || $_POST["monSho3"]!="")) {
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monGan3"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monSho3"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp3==23 && ($_POST["monPla3"]>0 || $_POST["monPla3"]!="") &&
                        ($_POST["monSho3"]>0 || $_POST["monSho3"]!="")) {
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monPla3"];
                        $tipo[$z]=2;
                        $z++;
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monSho3"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp3==123 && ($_POST["monGan3"]>0 || $_POST["monGan3"]!="") &&
                        ($_POST["monPla3"]>0 || $_POST["monPla3"]!="") &&
                        ($_POST["monSho3"]>0 || $_POST["monSho3"]!="")) {
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monGan3"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monPla3"];
                        $tipo[$z]=2;
                        $z++;
                        $apuesta[$z]=$ju3;
                        $monto[$z]=$_POST["monSho3"];
                        $tipo[$z]=3;
                        $z++;
                    }
                } else {
                    $mensaje3="[".$ju3."]";
                } // mensaje de caballo retirado***************************************
            } else {
                if ($tp3==4 || $tp3==5 || $tp3==6 || $tp3==7 || $tp3==8 || $tp3==9) { //
                    $du=explode("-", $ju3);
                    foreach ($du as $ejem) {
                        $sRetiro3=RetiradosSimple($_POST['cod_carrera'], $ejem); // verifica estado de retirado
                        if ($sRetiro3==1) {
                            $mensaje3="[".$ju3."]";
                            break;
                        }
                    }
                    if ($sRetiro3==0) {
                        if ($_POST["monSho3"]>0) {
                            $monto[$z]=$_POST["monSho3"];
                        }
                        if ($_POST["monPla3"]>0) {
                            $monto[$z]=$_POST["monPla3"];
                        }
                        if ($_POST["monGan3"]>0) {
                            $monto[$z]=$_POST["monGan3"];
                        }
                        $apuesta[$z]=$ju3;
                        $tipo[$z]=$tp3;
                        $z++;
                    }
                }
            }
            if ($sRetiro3==0 && ($_POST["monGan3"]>0 || $_POST["monPla3"]>0 || $_POST["monSho3"]>0)) {
                if ($fechacarrerabd == $FechaTxt && $horacarrerabd > $horaTxt && $statuscarrerabd == 1) {
                    $f=1;
                    $exito=1;
                } else {
                    if ($fechacarrerabd != $FechaTxt) {
                        $fueFec=0;
                    }
                    if ($horacarrerabd < $horaTxt || $statuscarrerabd!= 1) {
                        $fueHor=0;
                    }
                }
            }
            //echo $apuesta[1]." ".$monto[1]."<br/>";
        } //fin no existen ejemplares retirados seleccionados
    } // fin si esta definido 3r caballo
/************************************************************* 4 ************************************************************/
    if ($_POST["numCa14"]>0 && $_POST["numCa14"]!="") {  // si esta definido 4o caballo LINEA 4
        if (isset($_POST["per4"])) { //inicio permuta 2
            $tp4=9;
        } //fin permuta 1
        //superfecta
        if (isset($_POST["numCa14"]) && isset($_POST["numCa24"]) && isset($_POST["numCa34"]) && isset($_POST["numCa44"]) &&
            $_POST["numCa14"]>0 && $_POST["numCa24"]>0 && $_POST["numCa34"]>0 && $_POST["numCa44"]>0) {
            if ($_POST["numCa14"]!=$_POST["numCa24"] && $_POST["numCa14"]!=$_POST["numCa34"] &&
                $_POST["numCa14"]!=$_POST["numCa44"] && $_POST["numCa24"]!=$_POST["numCa34"] &&
                $_POST["numCa24"]!=$_POST["numCa44"] && $_POST["numCa34"]!=$_POST["numCa44"]) {
                if ($tp4==0) {
                    $tp4=6;
                }
                if ($_POST["numCa14"]<=$cCab && $_POST["numCa24"]<=$cCab && $_POST["numCa34"]<=$cCab &&
                    $_POST["numCa44"]<=$cCab) {
                    $ju4=$_POST["numCa14"]."-".$_POST["numCa24"]."-".$_POST["numCa34"]."-".$_POST["numCa44"];
                } else {
                    $maxCa=1;
                }
            }
        } else {
            if ((isset($_POST["numCa14"]) && isset($_POST["numCa24"]) && isset($_POST["numCa34"]) &&
                ($_POST["numCa14"]>0 && $_POST["numCa24"]>0 && $_POST["numCa34"]>0) &&
                ($_POST["numCa14"]!=$_POST["numCa24"] && $_POST["numCa14"]!=$_POST["numCa34"] &&
                 $_POST["numCa24"]!=$_POST["numCa34"])) ||
                (isset($_POST["numCa14"]) && isset($_POST["numCa24"]) && isset($_POST["numCa44"]) &&
                ($_POST["numCa14"]>0 && $_POST["numCa24"]>0 && $_POST["numCa44"]>0) &&
                ($_POST["numCa14"]!=$_POST["numCa24"]) && $_POST["numCa14"]!=$_POST["numCa44"] &&
                 $_POST["numCa24"]!=$_POST["numCa44"]) ||
                (isset($_POST["numCa24"]) && isset($_POST["numCa34"]) && isset($_POST["numCa44"]) &&
                ($_POST["numCa24"]>0 && $_POST["numCa34"]>0 && $_POST["numCa44"]>0) &&
                ($_POST["numCa24"]!=$_POST["numCa34"] && $_POST["numCa34"]!=$_POST["numCa44"]) &&
                $_POST["numCa24"]!=$_POST["numCa44"])) {
                if ($tp4==0) {
                    $tp4=5;
                } else {
                    $tp4=$tp4-1;
                }
                if ($_POST["numCa14"]>0 && $_POST["numCa24"]>0 && $_POST["numCa34"]>0 &&
                        $_POST["numCa14"]!=$_POST["numCa24"] && $_POST["numCa14"]!=$_POST["numCa34"] &&
                        $_POST["numCa24"]!=$_POST["numCa34"]) {
                    if ($_POST["numCa14"]<=$cCab && $_POST["numCa24"]<=$cCab && $_POST["numCa34"]<=$cCab) {
                        $ju4=$_POST["numCa14"]."-".$_POST["numCa24"]."-".$_POST["numCa34"];
                    } else {
                        $maxCa=1;
                    }
                }
                if ($_POST["numCa14"]>0 && $_POST["numCa34"]>0 && $_POST["numCa44"]>0 &&
                        $_POST["numCa14"]!=$_POST["numCa34"] && $_POST["numCa14"]!=$_POST["numCa43"] &&
                        $_POST["numCa34"]!=$_POST["numCa44"]) {
                    if ($_POST["numCa14"]<=$cCab && $_POST["numCa34"]<=$cCab && $_POST["numCa44"]<=$cCab) {
                        $ju4=$_POST["numCa14"]."-".$_POST["numCa34"]."-".$_POST["numCa44"];
                    } else {
                        $maxCa=1;
                    }
                }
                if ($_POST["numCa24"]>0 && $_POST["numCa34"]>0 && $_POST["numCa44"]>0 &&
                        $_POST["numCa24"]!=$_POST["numCa34"] && $_POST["numCa34"]!=$_POST["numCa44"] &&
                        $_POST["numCa24"]!=$_POST["numCa44"]) {
                    if ($_POST["numCa24"]<=$cCab && $_POST["numCa34"]<=$cCab && $_POST["numCa44"]<=$cCab) {
                        $ju4=$_POST["numCa24"]."-".$_POST["numCa34"]."-".$_POST["numCa44"];
                    } else {
                        $maxCa=1;
                    }
                }
            } else {
                if ((isset($_POST["numCa14"]) && isset($_POST["numCa24"]) && $_POST["numCa14"]>0 && $_POST["numCa24"]>0 &&
                    $_POST["numCa14"]!=$_POST["numCa24"] && $_POST["numCa34"]=="" && $_POST["numCa44"]=="") ||
                    (isset($_POST["numCa14"]) && isset($_POST["numCa34"]) && $_POST["numCa14"]>0 && $_POST["numCa34"]>0 &&
                    $_POST["numCa14"]!=$_POST["numCa34"] && $_POST["numCa24"]=="" && $_POST["numCa44"]=="") ||
                    (isset($_POST["numCa14"]) && isset($_POST["numCa44"]) && $_POST["numCa14"]>0 && $_POST["numCa44"]>0 &&
                    $_POST["numCa14"]!=$_POST["numCa44"]&& $_POST["numCa24"]=="" && $_POST["numCa34"]=="") ||
                    (isset($_POST["numCa24"]) && isset($_POST["numCa34"]) && $_POST["numCa24"]>0 && $_POST["numCa34"]>0 &&
                    $_POST["numCa24"]!=$_POST["numCa34"]&& $_POST["numCa14"]=="" && $_POST["numCa44"]=="") ||
                    (isset($_POST["numCa24"]) && isset($_POST["numCa44"]) && $_POST["numCa24"]>0 && $_POST["numCa44"]>0 &&
                    $_POST["numCa24"]!=$_POST["numCa44"]&& $_POST["numCa14"]=="" && $_POST["numCa34"]=="") ||
                    (isset($_POST["numCa34"]) && isset($_POST["numCa44"]) && $_POST["numCa34"]>0 && $_POST["numCa44"]>0) &&
                    $_POST["numCa34"]!=$_POST["numCa44"]&& $_POST["numCa14"]=="" && $_POST["numCa24"]=="") {
                    if ($tp4==0) {
                        $tp4=4;
                    } else {
                        $tp4=$tp4-2;
                    }
                    if ($_POST["numCa14"]>0 && $_POST["numCa24"]>0 &&
                            $_POST["numCa14"]!=$_POST["numCa24"] && $_POST["numCa34"]=="" && $_POST["numCa44"]=="") {
                        if ($_POST["numCa14"]<=$cCab && $_POST["numCa24"]<=$cCab) {
                            $ju4=$_POST["numCa14"]."-".$_POST["numCa24"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa14"]>0 && $_POST["numCa34"]>0 &&
                            $_POST["numCa14"]!=$_POST["numCa34"] && $_POST["numCa24"]=="" && $_POST["numCa44"]=="") {
                        if ($_POST["numCa14"]<=$cCab && $_POST["numCa34"]<=$cCab) {
                            $ju4=$_POST["numCa14"]."-".$_POST["numCa34"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa14"]>0 && $_POST["numCa44"]>0 &&
                            $_POST["numCa14"]!=$_POST["numCa44"] && $_POST["numCa24"]=="" && $_POST["numCa34"]=="") {
                        if ($_POST["numCa14"]<=$cCab && $_POST["numCa44"]<=$cCab) {
                            $ju4=$_POST["numCa14"]."-".$_POST["numCa44"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa24"]>0 && $_POST["numCa34"]>0 &&
                            $_POST["numCa24"]!=$_POST["numCa34"] && $_POST["numCa14"]=="" && $_POST["numCa44"]=="") {
                        if ($_POST["numCa24"]<=$cCab && $_POST["numCa34"]<=$cCab) {
                            $ju4=$_POST["numCa24"]."-".$_POST["numCa34"];
                        } else {
                            $maxCa=1;
                        }
                    }
                    if ($_POST["numCa34"]>0 && $_POST["numCa44"]>0 &&
                            $_POST["numCa34"]!=$_POST["numCa44"] && $_POST["numCa14"]=="" && $_POST["numCa24"]=="") {
                        if ($_POST["numCa34"]<=$cCab && $_POST["numCa44"]<=$cCab) {
                            $ju4=$_POST["numCa34"]."-".$_POST["numCa44"];
                        } else {
                            $maxCa=1;
                        }
                    }
                }
            }
        }
        if ($_POST["numCa14"]>0 && (!isset($_POST["per4"])) && $tp4==0) {
            if ($_POST["monGan4"]>0 && ($_POST["monPla4"]==0 || $_POST["monPla4"]=="")
                && ($_POST["monSho4"]==0 || $_POST["monSho4"]=="")) {
                $tp4=1;
                if ($_POST["numCa14"]<=$cCab) {
                    $ju4=$_POST["numCa14"];
                }
            } else {
                if ($_POST["monGan4"]>0 && $_POST["monPla4"]>0 && ($_POST["monSho4"]==0 || $_POST["monSho4"]=="")) {
                    $tp4=12;
                    if ($_POST["numCa14"]<=$cCab) {
                        $ju4=$_POST["numCa14"];
                    }
                } else {
                    if ($_POST["monGan4"]>0 && $_POST["monPla4"]>0 && $_POST["monSho4"]>0) {
                        $tp4=123;
                        if ($_POST["numCa14"]<=$cCab) {
                            $ju4=$_POST["numCa14"];
                        }
                    }
                }
            }
            if ($_POST["monPla4"]>0 && ($_POST["monGan4"]==0 || $_POST["monGan4"]=="") &&
                ($_POST["monSho4"]==0 || $_POST["monSho4"]=="")) {
                $tp4=2;
                if ($_POST["numCa14"]<=$cCab) {
                    $ju4=$_POST["numCa14"];
                }
            } else {
                if ($_POST["monPla4"]>0 && $_POST["monSho4"]>0 && ($_POST["monGan4"]==0 || $_POST["monGan4"]=="")) {
                    $tp4=23;
                    if ($_POST["numCa14"]<=$cCab) {
                        $ju4=$_POST["numCa14"];
                    }
                }
            }
            if ($_POST["monGan4"]>0 && ($_POST["monPla4"]==0 || $_POST["monPla4"]=="") && $_POST["monSho4"]>0) {
                $tp4=13;
                if ($_POST["numCa14"]<=$cCab) {
                    $ju4=$_POST["numCa14"];
                }
            } else {
                if (($_POST["monGan4"]==0 || $_POST["monGan4"]=="") && ($_POST["monPla4"]==0 || $_POST["monPla4"]=="") &&
                    $_POST["monSho4"]>0) {
                    $tp4=3;
                    if ($_POST["numCa14"]<=$cCab) {
                        $ju4=$_POST["numCa14"];
                    }
                }
            }
        }
        if ($maxCa==0 && $tp4!=0 && $ju4!=0) {// si no existen ejemplares retirados seleccionados
            //$z=0;
            if ($tp4==1 || $tp4==2 || $tp4==3 || $tp4==12 || $tp4==13 || $tp4==23 || $tp4==123) {
                $sRetiro4=RetiradosSimple($_POST['cod_carrera'], $ju4); // verifica estado de retirado
                if ($sRetiro4==0) {
                    if ($tp4==1 && ($_POST["monGan4"]>0 || $_POST["monGan4"]!="")) {
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monGan4"];
                        $tipo[$z]=1;
                        $z++;
                    }
                    if ($tp4==2 && ($_POST["monPla4"]>0 || $_POST["monPla4"]!="")) {
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monPla4"];
                        $tipo[$z]=2;
                        $z++;
                    }
                    if ($tp4==3 && ($_POST["monSho4"]>0 || $_POST["monSho4"]!="")) {
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monSho4"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp4==12 && ($_POST["monGan4"]>0 || $_POST["monGan4"]!="") &&
                        ($_POST["monPla4"]>0 || $_POST["monPla4"]!="")) {
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monGan4"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monPla4"];
                        $tipo[$z]=2;
                        $z++;
                    }
                    if ($tp4==13 && ($_POST["monGan4"]>0 || $_POST["monGan4"]!="") &&
                        ($_POST["monSho4"]>0 || $_POST["monSho4"]!="")) {
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monGan4"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monSho4"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp4==23 && ($_POST["monPla4"]>0 || $_POST["monPla4"]!="") &&
                        ($_POST["monSho4"]>0 || $_POST["monSho4"]!="")) {
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monPla4"];
                        $tipo[$z]=2;
                        $z++;
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monSho4"];
                        $tipo[$z]=3;
                        $z++;
                    }
                    if ($tp4==123 && ($_POST["monGan4"]>0 || $_POST["monGan4"]!="") &&
                        ($_POST["monPla4"]>0 || $_POST["monPla4"]!="") &&
                        ($_POST["monSho4"]>0 || $_POST["monSho4"]!="")) {
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monGan4"];
                        $tipo[$z]=1;
                        $z++;
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monPla4"];
                        $tipo[$z]=2;
                        $z++;
                        $apuesta[$z]=$ju4;
                        $monto[$z]=$_POST["monSho4"];
                        $tipo[$z]=3;
                        $z++;
                    }
                } else {
                    $mensaje4="[".$ju4."]";
                } // mensaje de caballo retirado***************************************
            } else {
                if ($tp4==4 || $tp4==5 || $tp4==6 || $tp4==7 || $tp4==8 || $tp4==9) { //
                    $du=explode("-", $ju4);
                    foreach ($du as $ejem) {
                        $sRetiro4=RetiradosSimple($_POST['cod_carrera'], $ejem); // verifica estado de retirado
                        if ($sRetiro4==1) {
                            $mensaje4="[".$ju4."]";
                            break;
                        }
                    }
                    if ($sRetiro4==0) {
                        if ($_POST["monSho4"]>0) {
                            $monto[$z]=$_POST["monSho4"];
                        }
                        if ($_POST["monPla4"]>0) {
                            $monto[$z]=$_POST["monPla4"];
                        }
                        if ($_POST["monGan4"]>0) {
                            $monto[$z]=$_POST["monGan4"];
                        }
                        $apuesta[$z]=$ju4;
                        $tipo[$z]=$tp4;
                        $z++;
                    }
                }
            }
            if ($sRetiro4==0 && ($_POST["monGan4"]>0 || $_POST["monPla4"]>0 || $_POST["monSho4"]>0)) {
                if ($fechacarrerabd == $FechaTxt && $horacarrerabd > $horaTxt && $statuscarrerabd == 1) {
                    $f=1;
                    $exito=1;
                } else {
                    if ($fechacarrerabd != $FechaTxt) {
                        $fueFec=0;
                    }
                    if ($horacarrerabd < $horaTxt || $statuscarrerabd!= 1) {
                        $fueHor=0;
                    }
                }
            }
        } //fin no existen ejemplares retirados seleccionados
    } // fin si esta definido 4o caballo
    if ($exito==1 && $pau_ventas==0) {// guarda e imprime ticket
        $t=0;
        $u=0;
        $apuesta2=$apuesta;
        $tipo2=$tipo;
        $valida=1;
        foreach ($apuesta as $busca) {  //busca exceso de montos
            $apTotCab[$t][0]=0;
            $apTotCab[$t][1]="";
            $actualCab=$busca;
            $actualTip=$tipo[$t];
            $u=0;
            foreach ($apuesta2 as $busca2) {
                if ($actualCab==$busca2 && $tipo2[$u]==$actualTip) {
                    $apTotCab[$t][0]=$apTotCab[$t][0]+$monto[$u];
                    $apTotCab[$t][1]=$actualCab;
                    $apTotCab[$t][2]=$actualTip;
                    $apuesta2[$u]=0;
                }
                $u++;
            }
            $t++;
        }
        foreach ($apTotCab as $busca) {
            if ($busca[2]==1) {
                if ($busca[0]>$_POST["apMaxGan"]) {
                    $valida=0;
                    $menValida="Monto excedido";
                    $exito=0;
                    break;
                }
                $vendido=ObtenerMontoEjeTaq($codigoTaquilla, $FechaTxt, $busca[1], $_POST['cod_carrera'], 1);
                $exces=$vendido+$busca[0];
                if ($exces>$_POST["monMaxEj"]) {
                    $valida=0;
                    $cMonMaxGa=1;
                    $exito=0;
                    $mEjeMax=$busca[1];
                    $exMon=$_POST["apMaxGan"]-$vendido;
                    if ($exMon<=0) {
                        $mEjeMax=$busca[1].". - TICKET NO GUARDADO";
                    } else {
                        $mEjeMax=$busca[1].". Monto permitido:".$exMon." - NO GUARDADO";
                    }
                    break;
                } //Monto Max alcanzado a ganador
            }
            if ($busca[2]==2) {
                if ($busca[0]>$_POST["apMaxPla"]) {
                    $valida=0;
                    $menValida="Monto excedido";
                    $exito=0;
                    break;
                }
                $vendido=ObtenerMontoEjeTaq($codigoTaquilla, $FechaTxt, $busca[1], $_POST['cod_carrera'], 2);
                $exces=$vendido+$busca[0];
                if ($exces>$_POST["monMaxEj"]) {
                    $valida=0;
                    $cMonMaxPl=1;
                    $exito=0;
                    $mEjeMax=$busca[1];
                    $exMon=$_POST["apMaxPla"]-$vendido;
                    if ($exMon<=0) {
                        $mEjeMax=$busca[1]." - TICKET NO GUARDADO";
                    } else {
                        $mEjeMax=$busca[1].". Montopermitido:".$exMon." - NO GUARDADO";
                    }
                    break;
                } //Monto Max alcanzado a place
            }
            if ($busca[2]==3) {
                if ($busca[0]>$_POST["apMaxSho"]) {
                    $valida=0;
                    $menValida="Monto excedido";
                    $exito=0;
                    break;
                }
                $vendido=ObtenerMontoEjeTaq($codigoTaquilla, $FechaTxt, $busca[1], $_POST['cod_carrera'], 3);
                $exces=$vendido+$busca[0];
                if ($exces>$_POST["monMaxEj"]) {
                    $valida=0;
                    $cMonMaxSh=1;
                    $exito=0;
                    $mEjeMax=$busca[1];
                    $exMon=$_POST["apMaxSho"]-$vendido;
                    if ($exMon<=0) {
                        $mEjeMax=$busca[1]." - TICKET NO GUARDADO";
                    } else {
                        $mEjeMax=$busca[1].". Monto permitido:".$exMon." - NO GUARDADO";
                    }
                    break;
                } //Monto Max alcanzado a show
            }
            if ($busca[2]==4 || $busca[1]==77) {
                if ($busca[0]>$_POST["apMaxExa"]) {
                    $valida=0;
                    $menValida="Monto en exacta excedido1";
                    $exito=0;
                    break;
                }
            }
            if ($busca[2]==5 || $busca[1]==88) {
                if ($busca[0]>$_POST["apMaxTri"]) {
                    $valida=0;
                    $menValida="Monto en trifecta excedido";
                    $exito=0;
                    break;
                }
            }
            if ($busca[2]==6 || $busca[1]==99) {
                if ($busca[0]>$_POST["apMaxSup"]) {
                    $valida=0;
                    $menValida="Monto en superfecta excedido";
                    $exito=0;
                    break;
                }
            }
        }
        if ($valida==1 && $pau_ventas==0) {
            $t=1;
            $totalTicket=0;
            foreach ($apuesta as $busca) {  //busca exceso o minimos de montos
                // valida si tipo de jugada esta activa
                if ($tipo[$t-1]==1) { // ganador
                    if ($_POST["est_gan"]==0) {
                        $valida=0;
                        $menValida="Tipo de jugada no permitida por el Banquero";
                        $exito=0;
                        break;
                    }
                }
                if ($tipo[$t-1]==2) { // pace
                    if ($_POST["est_pla"]==0) {
                        $valida=0;
                        $menValida="Tipo de jugada no permitida por el Banquero";
                        $exito=0;
                        break;
                    }
                }
                if ($tipo[$t-1]==3) { // show
                    if ($_POST["est_sho"]==0) {
                        $valida=0;
                        $menValida="Tipo de jugada no permitida por el Banquero";
                        $exito=0;
                        break;
                    }
                }
                if ($tipo[$t-1]==4 || $tipo[$t-1]==7) { // exacta
                    if ($_POST["est_exa"]==0) {
                        $valida=0;
                        $menValida="Tipo de jugada no permitida por el Banquero";
                        $exito=0;
                        break;
                    }
                }
                if ($tipo[$t-1]==5 || $tipo[$t-1]==8) { // trifecta
                    if ($_POST["est_tri"]==0) {
                        $valida=0;
                        $menValida="Tipo de jugada no permitida por el Banquero";
                        $exito=0;
                        break;
                    }
                }
                if ($tipo[$t-1]==6 || $tipo[$t-1]==9) { // superfecta
                    if ($_POST["est_sup"]==0) {
                        $valida=0;
                        $menValida="Tipo de jugada no permitida por el Banquero";
                        $exito=0;
                        break;
                    }
                }
                // si excede monto
                if ($tipo[$t-1]==1) { // ganador
                    if ($monto[$t-1]>$_POST["apMaxGan"]) {
                        $valida=0;
                        $menValida="Monto a ganador excedido";
                        $exito=0;
                        break;
                    }
                }
                if ($tipo[$t-1]==2) { // pace
                    if ($monto[$t-1]>$_POST["apMaxPla"]) {
                        $valida=0;
                        $menValida="Monto a place excedido";
                        $exito=0;
                        break;
                    }
                }
                if ($tipo[$t-1]==3) { // show
                    if ($monto[$t-1]>$_POST["apMaxSho"]) {
                        $valida=0;
                        $menValida="Monto a show excedido";
                        $exito=0;
                        break;
                    }
                }
                if ($tipo[$t-1]==4 || $tipo[$t-1]==7) { // exacta
                    if ($monto[$t-1]>$_POST["apMaxExa"]) {
                        $valida=0;
                        $menValida="Monto en exacta excedido2";
                        $exito=0;
                        break;
                    }
                }
                if ($tipo[$t-1]==5 || $tipo[$t-1]==8) { // trifecta
                    if ($monto[$t-1]>$_POST["apMaxTri"]) {
                        $valida=0;
                        $menValida="Monto en trifecta excedido";
                        $exito=0;
                        break;
                    }
                }
                if ($tipo[$t-1]==6 || $tipo[$t-1]==9) { // superfecta
                    if ($monto[$t-1]>$_POST["apMaxSup"]) {
                        $valida=0;
                        $menValida="Monto en superfecta excedido";
                        $exito=0;
                        break;
                    }
                }
            
                
                // si monto es menor
                if ($tipo[$t-1]==1 && 	$_POST['efectivoO']<=2) { // ganador
                    if ($monto[$t-1]<$apuestasminimaaganadorbss0) {
                        $valida=0;
                        $menValida="Monto menor al minimo permitido en bss ".$apuestasminimaaganadorbss0;
                        $exito=0;
                        break;
                    }
                }
                if ($tipo[$t-1]==1 && 	$_POST['efectivoO']==3) { // ganador
                    if ($monto[$t-1]<$apuestasminimaaganadorusd1) {
                        $valida=0;
                        $menValida="Monto menor al minimo permitido en usd ".$apuestasminimaaganadorusd1;
                        $exito=0;
                        break;
                    }
                }
                if ($tipo[$t-1]==1 && 	$_POST['efectivoO']==4) { // ganador
                    if ($monto[$t-1]<$apuestasminimaaganadorpc2) {
                        $valida=0;
                        $menValida="Monto menor al minimo permitido en pesos ".$apuestasminimaaganadorpc2;
                        $exito=0;
                        break;
                    }
                }
                if ($tipo[$t-1]==1 && 	$_POST['efectivoO']==5) { // ganador
                    if ($monto[$t-1]<$apuestasminimaaganadorsp3) {
                        $valida=0;
                        $menValida="Monto menor al minimo permitido en soles ".$apuestasminimaaganadorsp3;
                        $exito=0;
                        break;
                    }
                }
                
                
                
                if ($tipo[$t-1]==2) { // pace
                    if ($monto[$t-1]<$_POST["apMinPla"]) {
                        $valida=0;
                        $menValida="Monto mínimo a place";
                        $exito=0;
                        break;
                    }
                }
                if ($tipo[$t-1]==3) { // show
                    if ($monto[$t-1]<$_POST["apMinSho"]) {
                        $valida=0;
                        $menValida="Monto mínimo a show";
                        $exito=0;
                        break;
                    }
                }
                if ($tipo[$t-1]==4 || $tipo[$t-1]==7) { // exacta
                    if ($monto[$t-1]<$_POST["apMinExa"]) {
                        $valida=0;
                        $menValida="Monto mínimo en exacta";
                        $exito=0;
                        break;
                    }
                }
                if ($tipo[$t-1]==5 || $tipo[$t-1]==8) { // trifecta
                    if ($monto[$t-1]<$_POST["apMinTri"]) {
                        $valida=0;
                        $menValida="Monto mínimo en trfecta";
                        $exito=0;
                        break;
                    }
                }
                if ($tipo[$t-1]==6 || $tipo[$t-1]==9) { // superfecta
                    if ($monto[$t-1]<$_POST["apMinSup"]) {
                        $valida=0;
                        $menValida="Monto mínimo en superfecta";
                        $exito=0;
                        break;
                    }
                }
                $totalTicket=$totalTicket+$monto[$t-1];
                $t++;
            }
            if ($totalTicket>$_POST["monMaxTi"]) {
                $valida=0;
                $menValida="Monto de ticket excedido";
                $exito=0;
            }
            if ($totalTicket>500 && $_POST['efectivoO']==3) {
                $valida=0;
                $menValida="Monto en USD Supera el maximo de 500 USD";
                $exito=0;
            }


            
            $query_Recordset55 = sprintf(
                "
/* PARSEADORES1 ventas\t_grabajugadahipicoticket.php - QUERY 6 */ SELECT 
tasadecambio.usdabss, tasadecambio.copabss, tasadecambio.solabss, 
agencia.tipo_pagoa, agencia.saldoactuala,
taquilla.tipo_pago, taquilla.saldoactual
FROM 
tasadecambio, taquilla, agencia
WHERE 
taquilla.cod_taquilla = %s AND
agencia.cod_agencia = %s  AND
tasadecambio.Idtasadecambio = %s",
                GetSQLValueString($codigoTaquilla, "int"),
                GetSQLValueString($cod_agencia, "int"),
                GetSQLValueString(1, "int")
            );
            $Recordset55 = mysqli_query($conexionbanca, $query_Recordset55) or die(mysqli_error($conexionbanca));
            $row_Recordset55 = mysqli_fetch_assoc($Recordset55);
            $totalRows_Recordset55 = mysqli_num_rows($Recordset55);
            $saldoactuala=$row_Recordset55['saldoactuala'];
            $saldoactual=$row_Recordset55['saldoactual'];
            $usdabss=$row_Recordset55['usdabss'];
            $copabss=$row_Recordset55['copabss'];
            $solabss=$row_Recordset55['solabss'];
            $tasa=1;
            if ($_POST['efectivoO']<=2) {
                $tasa=1;
            }
            if ($_POST['efectivoO']==3) {
                $tasa=$usdabss;
            }
            if ($_POST['efectivoO']==4) {
                $tasa=$copabss;
            }
            if ($_POST['efectivoO']==5) {
                $tasa=$solabss;
            }


            $maxbssapueta=$usdabss*500;
            if ($totalTicket>$maxbssapueta && $_POST['efectivoO']<=2) {
                $valida=0;
                $menValida="Monto en Bs Supera el maximo de ".$maxbssapueta." Bs";
                $exito=0;
            }




            $totalTicketx=$totalTicket*$tasa;

            if ($totalTicketx>$saldoactual && $tipo_pago==1) {
                $valida=0;
                $menValida="Monto excede saldo recargue por favor";
                $exito=0;
            }
            if ($totalTicketx>$saldoactuala && $tipo_pagoa==1) {
                $valida=0;
                $menValida="Monto excede saldo en agente comunique al encargador";
                $exito=0;
            }
        }
        if ($valida==1 && $pau_ventas==0) {
            $f=0;
            $exito=1;
            foreach ($apuesta as $apta) {
                $yu=$f+1;
                $apta =trim(str_replace(".", "", $apta));
                $apta =ltrim($apta, "0");
                                
                if ($_POST["cod_cliente"]==""&&$_POST["cod_cliente2"]!="-1X") {
                    $_POST["cod_cliente"]=$_POST["cod_cliente2"];
                }
                $tra_codigo=0;
                if ($_POST["cod_cliente"]!="") {
                    $tra_codigo=1;
                }
                if ($_POST["cod_cliente"]==""&&$_POST["cod_cliente2"]=="-1X") {
                    $_POST["cod_cliente"]="anonimo";
                }
                $permisos=0;
                if(isset($_SESSION['Carrera'])){
                if($apta==$_SESSION['Ejemplar'] && $monto[$f]==$_SESSION['Monto'] && $_POST['cod_carrera']==$_SESSION['Carrera'] && $_POST['efectivoO']==$_SESSION['Tipomoneda'] && $timeticket > $horaTxt){

                 $permisos=1;   
                }else{

                $insertSQL = sprintf(
                    "/* PARSEADORES1 ventas\t_grabajugadahipicoticket.php - QUERY 7 */ INSERT INTO venta (ser_venta, ticket, cod_taquilla, fec_venta, hor_venta, cod_tventa,
					 num_caballo, mon_venta, cod_carrera, id_usuario, est_ticket, can_ticket, ip_venta, lin_ticket, cod_cliente, tra_codigo, efectivoO) 
					 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                    GetSQLValueString($serial, "text"),
                    GetSQLValueString($numerotiket2, "int"),
                    GetSQLValueString($codigoTaquilla, "int"),
                    GetSQLValueString($FechaTxt, "date"),
                    GetSQLValueString($horaTxt, "date"),
                    GetSQLValueString($tipo[$f], "int"),
                    GetSQLValueString($apta, "text"),
                    GetSQLValueString($monto[$f], "double"),
                    GetSQLValueString($_POST['cod_carrera'], "int"),
                    GetSQLValueString($usuarioVenta, "int"),
                    GetSQLValueString(1, "int"),
                    GetSQLValueString($cantTicket, "int"),
                    GetSQLValueString($ipVenta, "text"),
                    GetSQLValueString($yu, "int"),
                    GetSQLValueString(strtoupper($_POST["cod_cliente"]), "text"),
                    GetSQLValueString(1, "int"),
                    GetSQLValueString($_POST['efectivoO'], "int")
                );
                
                $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
                

                if ($tipo_pago==1) {
                    $insertSQL15 = sprintf(
                        "/* PARSEADORES1 ventas\t_grabajugadahipicoticket.php - QUERY 8 */ UPDATE taquilla 
				SET
				saldoactual=saldoactual-%s
				WHERE 
				cod_taquilla=%s",
                        GetSQLValueString($monto[$f]*$tasa, "double"),
                        GetSQLValueString($codigoTaquilla, "int")
                    );

                    $Result15 = mysqli_query($conexionbanca, $insertSQL15) or die(mysqli_error($conexionbanca));
                }
                if ($tipo_pagoa==1) {
                    $insertSQL155 = sprintf(
                        "/* PARSEADORES1 ventas\t_grabajugadahipicoticket.php - QUERY 9 */ UPDATE agencia 
				SET
				saldoactuala=saldoactuala-%s
				WHERE 
				cod_agencia=%s",
                        GetSQLValueString($monto[$f]*$tasa, "double"),
                        GetSQLValueString($cod_agencia, "int")
                    );

                    $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
                }

                $f++;
            }
        }else{
            $insertSQL = sprintf(
                "/* PARSEADORES1 ventas\t_grabajugadahipicoticket.php - QUERY 10 */ INSERT INTO venta (ser_venta, ticket, cod_taquilla, fec_venta, hor_venta, cod_tventa,
                 num_caballo, mon_venta, cod_carrera, id_usuario, est_ticket, can_ticket, ip_venta, lin_ticket, cod_cliente, tra_codigo, efectivoO) 
                 VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                GetSQLValueString($serial, "text"),
                GetSQLValueString($numerotiket2, "int"),
                GetSQLValueString($codigoTaquilla, "int"),
                GetSQLValueString($FechaTxt, "date"),
                GetSQLValueString($horaTxt, "date"),
                GetSQLValueString($tipo[$f], "int"),
                GetSQLValueString($apta, "text"),
                GetSQLValueString($monto[$f], "double"),
                GetSQLValueString($_POST['cod_carrera'], "int"),
                GetSQLValueString($usuarioVenta, "int"),
                GetSQLValueString(1, "int"),
                GetSQLValueString($cantTicket, "int"),
                GetSQLValueString($ipVenta, "text"),
                GetSQLValueString($yu, "int"),
                GetSQLValueString(strtoupper($_POST["cod_cliente"]), "text"),
                GetSQLValueString(1, "int"),
                GetSQLValueString($_POST['efectivoO'], "int")
            );
            
            $Result = mysqli_query($conexionbanca, $insertSQL) or die(mysqli_error($conexionbanca));
            $_SESSION['Carrera']=$_POST['cod_carrera'];

            if ($tipo_pago==1) {
                $insertSQL15 = sprintf(
                    "/* PARSEADORES1 ventas\t_grabajugadahipicoticket.php - QUERY 11 */ UPDATE taquilla 
            SET
            saldoactual=saldoactual-%s
            WHERE 
            cod_taquilla=%s",
                    GetSQLValueString($monto[$f]*$tasa, "double"),
                    GetSQLValueString($codigoTaquilla, "int")
                );

                $Result15 = mysqli_query($conexionbanca, $insertSQL15) or die(mysqli_error($conexionbanca));
            }
            if ($tipo_pagoa==1) {
                $insertSQL155 = sprintf(
                    "/* PARSEADORES1 ventas\t_grabajugadahipicoticket.php - QUERY 12 */ UPDATE agencia 
            SET
            saldoactuala=saldoactuala-%s
            WHERE 
            cod_agencia=%s",
                    GetSQLValueString($monto[$f]*$tasa, "double"),
                    GetSQLValueString($cod_agencia, "int")
                );

                $Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
            }

            $f++;




        }}
        }
        $_SESSION['selCarrera']=$_POST['cod_carrera'];
    }
}
if (isset($_SESSION['Carrera']) && $permisos==1) {
    $Dticket="Ticket posiblemente duplicado intente de nuevo en ".$timeecho." segundos";
}
if ($maxCa==1) {
    $menMaxCab="Excede Cantidad de Ejemplares Máx:".$cCab;
}
$menMaxCab="";
if ($maxCa==1) {
    $menMaxCab="Excede Cantidad de Ejemplares Máx:".$cCab;
}
$menRetCab="";
if ($mensaje4!="" || $mensaje3!="" || $mensaje2!="" || $mensaje1!="") {
    $menRetCab=" Existen caballos retirados en la jugada: ".$mensaje1.$mensaje2.$mensaje3.$mensaje4;
}
$menFueFec="";
if ($fueFec==0 || $fueHor==0) {
    $menFueFec=" Carrera cerrada ";
}
if ($est_control_ventas==1 or $pau_ventas==1) {
    if ($est_control_ventas==1) {
        $mensaje1="TICKET NO GUARDADO. VENTAS PAUSADAS";
    } else {
        $mensaje1="TICKET NO GUARDADO. VENTAS PAUSADAS PARA ESTA CARRERA";
    }
    $numerotiket2=0;
    $exito=0;
} else {
    $pausa="";
    $mensaje1='NO GUARDADO. '.$menMaxCab.$menRetCab.$menFueFec.$menValida.$pausa;
}
if ($permisos==1) {
    $exito=0;
    $mensaje1=$Dticket;
}
echo "<div id='resultado' style='line-height: 0.5em;'>";
    if ($exito==1) {  // se guardo correctamente
        echo 'TICKET GUARDADO! '." *".$pau_ventas;
    } else {
        if (isset($cMonMaxGa) && $cMonMaxGa==1) {
            $mensaje1="Excede Límite GAN Ej# ".$mEjeMax;
        } elseif (isset($cMonMaxPl) && $cMonMaxPl==1) {
            $mensaje1="Excede Límite PLA Ej# ".$mEjeMax;
        } elseif (isset($cMonMaxSh) && $cMonMaxSh==1) {
            $mensaje1="Excede Límite SHO Ej# ".$mEjeMax;
        }
        echo $mensaje1;
    }
echo "</div>";
if (($maxCa==0 || $maxCa==1) && isset($Recordset1)) {
    mysqli_free_result($Recordset1);
}
if ($tra_codigox!=1) {
    ?>
<script language="javascript">
var navegador = navigator.userAgent;
document.form1.cod_carrera.selectedIndex = <?php echo $_SESSION['selCarrera']; ?>;
if (navigator.userAgent.indexOf('MSIE') != -1) {
    imprimeTicketie(<?php echo $numerotiket2; ?>, <?php echo $exito; ?>);
} else {
    imprimeTicketall(<?php echo $numerotiket2; ?>, <?php echo $exito; ?>);
}
</script>
<?php
}?>