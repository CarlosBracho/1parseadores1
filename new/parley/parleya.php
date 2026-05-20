<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "C"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
$MM_donotCheckaccess = "false";
$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$usuario=$_SESSION['MM_id_usuario'];
$query_Recordset5 = sprintf(
    "
/* PARSEADORES1 new\parley\parleya.php - QUERY 1 */ SELECT * FROM usuario, taquilla, taquilla_opc_ame, agencia,
			banca
WHERE usuario.id_usuario = %s AND 
usuario.cod_taquilla = taquilla.cod_taquilla AND
taquilla_opc_ame.cod_taquilla = usuario.cod_taquilla AND
taquilla.cod_agencia = agencia.cod_agencia AND
agencia.cod_banca = banca.cod_banca
LIMIT 1",
    GetSQLValueString($_SESSION['MM_id_usuario'], "int")
);
$Recordset5 = mysqli_query($conexionbanca, $query_Recordset5) or die(mysqli_error($conexionbanca));
$row_Recordset5 = mysqli_fetch_assoc($Recordset5);
$totalRows_Recordset5 = mysqli_num_rows($Recordset5);
$taquilla=$row_Recordset5['cod_taquilla'];
$tipotaquilla=$row_Recordset5['tipotaquilla']/1;
$tra_codigo=$row_Recordset5['tra_codigo']/1;
$saldoactual=$row_Recordset5['saldoactual']/1;
$cod_agencia=$row_Recordset5['cod_agencia']/1;
$tipo_pagoa=$row_Recordset5['tipo_pagoa']/1;
$tel_agencia=$row_Recordset5['tel_agencia']/1;

$efectivoOt=$row_Recordset5['efectivoO']/1;
$est_hnac=$row_Recordset5['est_taquilla_hnac']/1;
$apGaMax=$row_Recordset5['apu_maxgan'];
$apPlMax=$row_Recordset5['apu_maxpla'];
$apShMax=$row_Recordset5['apu_maxsho'];
$apMin=$row_Recordset5['apu_minima'];
$apMinGan=$row_Recordset5['apu_mingan'];
$apMinPla=$row_Recordset5['apu_minpla'];
$apMinSho=$row_Recordset5['apu_minsho'];
$apMinExa=$row_Recordset5['apu_minexa'];
$apMinTri=$row_Recordset5['apu_mintri'];
$apMinSup=$row_Recordset5['apu_minsup'];
$apExMax=$row_Recordset5['apu_maxexa'];
$apTrMax=$row_Recordset5['apu_maxtri'];
$apSuMax=$row_Recordset5['apu_maxsup'];
$monMaxTi=$row_Recordset5['mon_maxticket'];
$ejeMinCar=$row_Recordset5['min_ejecarrera'];

$est_gan=$row_Recordset5['est_gan'];
$est_pla=$row_Recordset5['est_pla'];
$est_sho=$row_Recordset5['est_sho'];
$est_exa=$row_Recordset5['est_exa'];
$est_tri=$row_Recordset5['est_tri'];
$est_sup=$row_Recordset5['est_sup'];
$monMaxEj=$row_Recordset5['mon_maxejemplar'];
$tipo_pago=$row_Recordset5['tipo_pago'];
$moneda=$row_Recordset5['moneda'];
$ejemMax=30;
$totalRows_Recordset1=0;


function Obtenerlogro($Id_p2juegos, $equipo, $tipojugada)
{
    global $conexionbanca;
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 new\parley\parleya.php - QUERY 2 */ SELECT *
FROM  p3logros
WHERE 
p3logros.idjuego = %s AND
p3logros.equipo = %s AND
p3logros.tipojugada = %s",
        GetSQLValueString($Id_p2juegos, "int"),
        GetSQLValueString($equipo, "int"),
        GetSQLValueString($tipojugada, "text")
    );
    $Recordset1 =mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $logro=$row_Recordset1['logro'];
    $Id_p3logros=$row_Recordset1['Id_p3logros'];
    $logroABoRL=$row_Recordset1['logroABoRL'];
    return array($logro,$Id_p3logros,$logroABoRL);
}



    $query_Recordset1 = "/* PARSEADORES1 new\parley\parleya.php - QUERY 3 */ SELECT * FROM p2juegos";
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);





$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$usuario=1000;
$taquilla=9999;
$Baseball=1;
$Basketball=1;

?>
<!DOCTYPE html>
<!-- saved from url=(0033)https://wuao.site/taquilla_ticket -->
<html lang="es"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Vendedor</title>
    <!-- Bootstrap core CSS -->
    <link href="./Vendedorclon_files/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="./Vendedorclon_files/bootstrap.min(1).css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="./Vendedorclon_files/modern-business.css" rel="stylesheet">
    <link href="./Vendedorclon_files/bootstrap-datepicker3.min.css" rel="stylesheet">
    <!--<link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://bootswatch.com/4/yeti/bootstrap.min.css" rel="stylesheet">-->

    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css" rel="stylesheet">-->
    <link href="./Vendedorclon_files/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./Vendedorclon_files/toastr.min.css">
    <link href="./Vendedorclon_files/css.css" rel="stylesheet">
    <link href="./Vendedorclon_files/css2018.css" rel="stylesheet">
	    <link href="../fonts/font-awesome.min4.7.0.css" rel="stylesheet">


<style>.swal2-popup.swal2-toast{flex-direction:row;align-items:center;width:auto;padding:.625em;overflow-y:hidden;background:#fff;box-shadow:0 0 .625em #d9d9d9}.swal2-popup.swal2-toast .swal2-header{flex-direction:row;padding:0}.swal2-popup.swal2-toast .swal2-title{flex-grow:1;justify-content:flex-start;margin:0 .6em;font-size:1em}.swal2-popup.swal2-toast .swal2-footer{margin:.5em 0 0;padding:.5em 0 0;font-size:.8em}.swal2-popup.swal2-toast .swal2-close{position:static;width:.8em;height:.8em;line-height:.8}.swal2-popup.swal2-toast .swal2-content{justify-content:flex-start;padding:0;font-size:1em}.swal2-popup.swal2-toast .swal2-icon{width:2em;min-width:2em;height:2em;margin:0}.swal2-popup.swal2-toast .swal2-icon .swal2-icon-content{display:flex;align-items:center;font-size:1.8em;font-weight:700}@media all and (-ms-high-contrast:none),(-ms-high-contrast:active){.swal2-popup.swal2-toast .swal2-icon .swal2-icon-content{font-size:.25em}}.swal2-popup.swal2-toast .swal2-icon.swal2-success .swal2-success-ring{width:2em;height:2em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line]{top:.875em;width:1.375em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left]{left:.3125em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right]{right:.3125em}.swal2-popup.swal2-toast .swal2-actions{flex-basis:auto!important;width:auto;height:auto;margin:0 .3125em}.swal2-popup.swal2-toast .swal2-styled{margin:0 .3125em;padding:.3125em .625em;font-size:1em}.swal2-popup.swal2-toast .swal2-styled:focus{box-shadow:0 0 0 1px #fff,0 0 0 3px rgba(50,100,150,.4)}.swal2-popup.swal2-toast .swal2-success{border-color:#a5dc86}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line]{position:absolute;width:1.6em;height:3em;transform:rotate(45deg);border-radius:50%}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=left]{top:-.8em;left:-.5em;transform:rotate(-45deg);transform-origin:2em 2em;border-radius:4em 0 0 4em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=right]{top:-.25em;left:.9375em;transform-origin:0 1.5em;border-radius:0 4em 4em 0}.swal2-popup.swal2-toast .swal2-success .swal2-success-ring{width:2em;height:2em}.swal2-popup.swal2-toast .swal2-success .swal2-success-fix{top:0;left:.4375em;width:.4375em;height:2.6875em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line]{height:.3125em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=tip]{top:1.125em;left:.1875em;width:.75em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=long]{top:.9375em;right:.1875em;width:1.375em}.swal2-popup.swal2-toast .swal2-success.swal2-icon-show .swal2-success-line-tip{-webkit-animation:swal2-toast-animate-success-line-tip .75s;animation:swal2-toast-animate-success-line-tip .75s}.swal2-popup.swal2-toast .swal2-success.swal2-icon-show .swal2-success-line-long{-webkit-animation:swal2-toast-animate-success-line-long .75s;animation:swal2-toast-animate-success-line-long .75s}.swal2-popup.swal2-toast.swal2-show{-webkit-animation:swal2-toast-show .5s;animation:swal2-toast-show .5s}.swal2-popup.swal2-toast.swal2-hide{-webkit-animation:swal2-toast-hide .1s forwards;animation:swal2-toast-hide .1s forwards}.swal2-container{display:flex;position:fixed;z-index:1060;top:0;right:0;bottom:0;left:0;flex-direction:row;align-items:center;justify-content:center;padding:.625em;overflow-x:hidden;transition:background-color .1s;-webkit-overflow-scrolling:touch}.swal2-container.swal2-backdrop-show,.swal2-container.swal2-noanimation{background:rgba(0,0,0,.4)}.swal2-container.swal2-backdrop-hide{background:0 0!important}.swal2-container.swal2-top{align-items:flex-start}.swal2-container.swal2-top-left,.swal2-container.swal2-top-start{align-items:flex-start;justify-content:flex-start}.swal2-container.swal2-top-end,.swal2-container.swal2-top-right{align-items:flex-start;justify-content:flex-end}.swal2-container.swal2-center{align-items:center}.swal2-container.swal2-center-left,.swal2-container.swal2-center-start{align-items:center;justify-content:flex-start}.swal2-container.swal2-center-end,.swal2-container.swal2-center-right{align-items:center;justify-content:flex-end}.swal2-container.swal2-bottom{align-items:flex-end}.swal2-container.swal2-bottom-left,.swal2-container.swal2-bottom-start{align-items:flex-end;justify-content:flex-start}.swal2-container.swal2-bottom-end,.swal2-container.swal2-bottom-right{align-items:flex-end;justify-content:flex-end}.swal2-container.swal2-bottom-end>:first-child,.swal2-container.swal2-bottom-left>:first-child,.swal2-container.swal2-bottom-right>:first-child,.swal2-container.swal2-bottom-start>:first-child,.swal2-container.swal2-bottom>:first-child{margin-top:auto}.swal2-container.swal2-grow-fullscreen>.swal2-modal{display:flex!important;flex:1;align-self:stretch;justify-content:center}.swal2-container.swal2-grow-row>.swal2-modal{display:flex!important;flex:1;align-content:center;justify-content:center}.swal2-container.swal2-grow-column{flex:1;flex-direction:column}.swal2-container.swal2-grow-column.swal2-bottom,.swal2-container.swal2-grow-column.swal2-center,.swal2-container.swal2-grow-column.swal2-top{align-items:center}.swal2-container.swal2-grow-column.swal2-bottom-left,.swal2-container.swal2-grow-column.swal2-bottom-start,.swal2-container.swal2-grow-column.swal2-center-left,.swal2-container.swal2-grow-column.swal2-center-start,.swal2-container.swal2-grow-column.swal2-top-left,.swal2-container.swal2-grow-column.swal2-top-start{align-items:flex-start}.swal2-container.swal2-grow-column.swal2-bottom-end,.swal2-container.swal2-grow-column.swal2-bottom-right,.swal2-container.swal2-grow-column.swal2-center-end,.swal2-container.swal2-grow-column.swal2-center-right,.swal2-container.swal2-grow-column.swal2-top-end,.swal2-container.swal2-grow-column.swal2-top-right{align-items:flex-end}.swal2-container.swal2-grow-column>.swal2-modal{display:flex!important;flex:1;align-content:center;justify-content:center}.swal2-container.swal2-no-transition{transition:none!important}.swal2-container:not(.swal2-top):not(.swal2-top-start):not(.swal2-top-end):not(.swal2-top-left):not(.swal2-top-right):not(.swal2-center-start):not(.swal2-center-end):not(.swal2-center-left):not(.swal2-center-right):not(.swal2-bottom):not(.swal2-bottom-start):not(.swal2-bottom-end):not(.swal2-bottom-left):not(.swal2-bottom-right):not(.swal2-grow-fullscreen)>.swal2-modal{margin:auto}@media all and (-ms-high-contrast:none),(-ms-high-contrast:active){.swal2-container .swal2-modal{margin:0!important}}.swal2-popup{display:none;position:relative;box-sizing:border-box;flex-direction:column;justify-content:center;width:32em;max-width:100%;padding:1.25em;border:none;border-radius:.3125em;background:#fff;font-family:inherit;font-size:1rem}.swal2-popup:focus{outline:0}.swal2-popup.swal2-loading{overflow-y:hidden}.swal2-header{display:flex;flex-direction:column;align-items:center;padding:0 1.8em}.swal2-title{position:relative;max-width:100%;margin:0 0 .4em;padding:0;color:#595959;font-size:1.875em;font-weight:600;text-align:center;text-transform:none;word-wrap:break-word}.swal2-actions{display:flex;z-index:1;flex-wrap:wrap;align-items:center;justify-content:center;width:100%;margin:1.25em auto 0}.swal2-actions:not(.swal2-loading) .swal2-styled[disabled]{opacity:.4}.swal2-actions:not(.swal2-loading) .swal2-styled:hover{background-image:linear-gradient(rgba(0,0,0,.1),rgba(0,0,0,.1))}.swal2-actions:not(.swal2-loading) .swal2-styled:active{background-image:linear-gradient(rgba(0,0,0,.2),rgba(0,0,0,.2))}.swal2-actions.swal2-loading .swal2-styled.swal2-confirm{box-sizing:border-box;width:2.5em;height:2.5em;margin:.46875em;padding:0;-webkit-animation:swal2-rotate-loading 1.5s linear 0s infinite normal;animation:swal2-rotate-loading 1.5s linear 0s infinite normal;border:.25em solid transparent;border-radius:100%;border-color:transparent;background-color:transparent!important;color:transparent!important;cursor:default;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.swal2-actions.swal2-loading .swal2-styled.swal2-cancel{margin-right:30px;margin-left:30px}.swal2-actions.swal2-loading :not(.swal2-styled).swal2-confirm::after{content:"";display:inline-block;width:15px;height:15px;margin-left:5px;-webkit-animation:swal2-rotate-loading 1.5s linear 0s infinite normal;animation:swal2-rotate-loading 1.5s linear 0s infinite normal;border:3px solid #999;border-radius:50%;border-right-color:transparent;box-shadow:1px 1px 1px #fff}.swal2-styled{margin:.3125em;padding:.625em 2em;box-shadow:none;font-weight:500}.swal2-styled:not([disabled]){cursor:pointer}.swal2-styled.swal2-confirm{border:0;border-radius:.25em;background:initial;background-color:#3085d6;color:#fff;font-size:1.0625em}.swal2-styled.swal2-cancel{border:0;border-radius:.25em;background:initial;background-color:#aaa;color:#fff;font-size:1.0625em}.swal2-styled:focus{outline:0;box-shadow:0 0 0 1px #fff,0 0 0 3px rgba(50,100,150,.4)}.swal2-styled::-moz-focus-inner{border:0}.swal2-footer{justify-content:center;margin:1.25em 0 0;padding:1em 0 0;border-top:1px solid #eee;color:#545454;font-size:1em}.swal2-timer-progress-bar-container{position:absolute;right:0;bottom:0;left:0;height:.25em;overflow:hidden;border-bottom-right-radius:.3125em;border-bottom-left-radius:.3125em}.swal2-timer-progress-bar{width:100%;height:.25em;background:rgba(0,0,0,.2)}.swal2-image{max-width:100%;margin:1.25em auto}.swal2-close{position:absolute;z-index:2;top:0;right:0;align-items:center;justify-content:center;width:1.2em;height:1.2em;padding:0;overflow:hidden;transition:color .1s ease-out;border:none;border-radius:0;background:0 0;color:#ccc;font-family:serif;font-size:2.5em;line-height:1.2;cursor:pointer}.swal2-close:hover{transform:none;background:0 0;color:#f27474}.swal2-close::-moz-focus-inner{border:0}.swal2-content{z-index:1;justify-content:center;margin:0;padding:0 1.6em;color:#545454;font-size:1.125em;font-weight:400;line-height:normal;text-align:center;word-wrap:break-word}.swal2-checkbox,.swal2-file,.swal2-input,.swal2-radio,.swal2-select,.swal2-textarea{margin:1em auto}.swal2-file,.swal2-input,.swal2-textarea{box-sizing:border-box;width:100%;transition:border-color .3s,box-shadow .3s;border:1px solid #d9d9d9;border-radius:.1875em;background:inherit;box-shadow:inset 0 1px 1px rgba(0,0,0,.06);color:inherit;font-size:1.125em}.swal2-file.swal2-inputerror,.swal2-input.swal2-inputerror,.swal2-textarea.swal2-inputerror{border-color:#f27474!important;box-shadow:0 0 2px #f27474!important}.swal2-file:focus,.swal2-input:focus,.swal2-textarea:focus{border:1px solid #b4dbed;outline:0;box-shadow:0 0 3px #c4e6f5}.swal2-file::-moz-placeholder,.swal2-input::-moz-placeholder,.swal2-textarea::-moz-placeholder{color:#ccc}.swal2-file:-ms-input-placeholder,.swal2-input:-ms-input-placeholder,.swal2-textarea:-ms-input-placeholder{color:#ccc}.swal2-file::-ms-input-placeholder,.swal2-input::-ms-input-placeholder,.swal2-textarea::-ms-input-placeholder{color:#ccc}.swal2-file::placeholder,.swal2-input::placeholder,.swal2-textarea::placeholder{color:#ccc}.swal2-range{margin:1em auto;background:#fff}.swal2-range input{width:80%}.swal2-range output{width:20%;color:inherit;font-weight:600;text-align:center}.swal2-range input,.swal2-range output{height:2.625em;padding:0;font-size:1.125em;line-height:2.625em}.swal2-input{height:2.625em;padding:0 .75em}.swal2-input[type=number]{max-width:10em}.swal2-file{background:inherit;font-size:1.125em}.swal2-textarea{height:6.75em;padding:.75em}.swal2-select{min-width:50%;max-width:100%;padding:.375em .625em;background:inherit;color:inherit;font-size:1.125em}.swal2-checkbox,.swal2-radio{align-items:center;justify-content:center;background:#fff;color:inherit}.swal2-checkbox label,.swal2-radio label{margin:0 .6em;font-size:1.125em}.swal2-checkbox input,.swal2-radio input{margin:0 .4em}.swal2-validation-message{display:none;align-items:center;justify-content:center;padding:.625em;overflow:hidden;background:#f0f0f0;color:#666;font-size:1em;font-weight:300}.swal2-validation-message::before{content:"!";display:inline-block;width:1.5em;min-width:1.5em;height:1.5em;margin:0 .625em;border-radius:50%;background-color:#f27474;color:#fff;font-weight:600;line-height:1.5em;text-align:center}.swal2-icon{position:relative;box-sizing:content-box;justify-content:center;width:5em;height:5em;margin:1.25em auto 1.875em;border:.25em solid transparent;border-radius:50%;font-family:inherit;line-height:5em;cursor:default;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.swal2-icon .swal2-icon-content{display:flex;align-items:center;font-size:3.75em}.swal2-icon.swal2-error{border-color:#f27474;color:#f27474}.swal2-icon.swal2-error .swal2-x-mark{position:relative;flex-grow:1}.swal2-icon.swal2-error [class^=swal2-x-mark-line]{display:block;position:absolute;top:2.3125em;width:2.9375em;height:.3125em;border-radius:.125em;background-color:#f27474}.swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left]{left:1.0625em;transform:rotate(45deg)}.swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right]{right:1em;transform:rotate(-45deg)}.swal2-icon.swal2-error.swal2-icon-show{-webkit-animation:swal2-animate-error-icon .5s;animation:swal2-animate-error-icon .5s}.swal2-icon.swal2-error.swal2-icon-show .swal2-x-mark{-webkit-animation:swal2-animate-error-x-mark .5s;animation:swal2-animate-error-x-mark .5s}.swal2-icon.swal2-warning{border-color:#facea8;color:#f8bb86}.swal2-icon.swal2-info{border-color:#9de0f6;color:#3fc3ee}.swal2-icon.swal2-question{border-color:#c9dae1;color:#87adbd}.swal2-icon.swal2-success{border-color:#a5dc86;color:#a5dc86}.swal2-icon.swal2-success [class^=swal2-success-circular-line]{position:absolute;width:3.75em;height:7.5em;transform:rotate(45deg);border-radius:50%}.swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=left]{top:-.4375em;left:-2.0635em;transform:rotate(-45deg);transform-origin:3.75em 3.75em;border-radius:7.5em 0 0 7.5em}.swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=right]{top:-.6875em;left:1.875em;transform:rotate(-45deg);transform-origin:0 3.75em;border-radius:0 7.5em 7.5em 0}.swal2-icon.swal2-success .swal2-success-ring{position:absolute;z-index:2;top:-.25em;left:-.25em;box-sizing:content-box;width:100%;height:100%;border:.25em solid rgba(165,220,134,.3);border-radius:50%}.swal2-icon.swal2-success .swal2-success-fix{position:absolute;z-index:1;top:.5em;left:1.625em;width:.4375em;height:5.625em;transform:rotate(-45deg)}.swal2-icon.swal2-success [class^=swal2-success-line]{display:block;position:absolute;z-index:2;height:.3125em;border-radius:.125em;background-color:#a5dc86}.swal2-icon.swal2-success [class^=swal2-success-line][class$=tip]{top:2.875em;left:.8125em;width:1.5625em;transform:rotate(45deg)}.swal2-icon.swal2-success [class^=swal2-success-line][class$=long]{top:2.375em;right:.5em;width:2.9375em;transform:rotate(-45deg)}.swal2-icon.swal2-success.swal2-icon-show .swal2-success-line-tip{-webkit-animation:swal2-animate-success-line-tip .75s;animation:swal2-animate-success-line-tip .75s}.swal2-icon.swal2-success.swal2-icon-show .swal2-success-line-long{-webkit-animation:swal2-animate-success-line-long .75s;animation:swal2-animate-success-line-long .75s}.swal2-icon.swal2-success.swal2-icon-show .swal2-success-circular-line-right{-webkit-animation:swal2-rotate-success-circular-line 4.25s ease-in;animation:swal2-rotate-success-circular-line 4.25s ease-in}.swal2-progress-steps{align-items:center;margin:0 0 1.25em;padding:0;background:inherit;font-weight:600}.swal2-progress-steps li{display:inline-block;position:relative}.swal2-progress-steps .swal2-progress-step{z-index:20;width:2em;height:2em;border-radius:2em;background:#3085d6;color:#fff;line-height:2em;text-align:center}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step{background:#3085d6}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step{background:#add8e6;color:#fff}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step-line{background:#add8e6}.swal2-progress-steps .swal2-progress-step-line{z-index:10;width:2.5em;height:.4em;margin:0 -1px;background:#3085d6}[class^=swal2]{-webkit-tap-highlight-color:transparent}.swal2-show{-webkit-animation:swal2-show .3s;animation:swal2-show .3s}.swal2-hide{-webkit-animation:swal2-hide .15s forwards;animation:swal2-hide .15s forwards}.swal2-noanimation{transition:none}.swal2-scrollbar-measure{position:absolute;top:-9999px;width:50px;height:50px;overflow:scroll}.swal2-rtl .swal2-close{right:auto;left:0}.swal2-rtl .swal2-timer-progress-bar{right:0;left:auto}@supports (-ms-accelerator:true){.swal2-range input{width:100%!important}.swal2-range output{display:none}}@media all and (-ms-high-contrast:none),(-ms-high-contrast:active){.swal2-range input{width:100%!important}.swal2-range output{display:none}}@-moz-document url-prefix(){.swal2-close:focus{outline:2px solid rgba(50,100,150,.4)}}@-webkit-keyframes swal2-toast-show{0%{transform:translateY(-.625em) rotateZ(2deg)}33%{transform:translateY(0) rotateZ(-2deg)}66%{transform:translateY(.3125em) rotateZ(2deg)}100%{transform:translateY(0) rotateZ(0)}}@keyframes swal2-toast-show{0%{transform:translateY(-.625em) rotateZ(2deg)}33%{transform:translateY(0) rotateZ(-2deg)}66%{transform:translateY(.3125em) rotateZ(2deg)}100%{transform:translateY(0) rotateZ(0)}}@-webkit-keyframes swal2-toast-hide{100%{transform:rotateZ(1deg);opacity:0}}@keyframes swal2-toast-hide{100%{transform:rotateZ(1deg);opacity:0}}@-webkit-keyframes swal2-toast-animate-success-line-tip{0%{top:.5625em;left:.0625em;width:0}54%{top:.125em;left:.125em;width:0}70%{top:.625em;left:-.25em;width:1.625em}84%{top:1.0625em;left:.75em;width:.5em}100%{top:1.125em;left:.1875em;width:.75em}}@keyframes swal2-toast-animate-success-line-tip{0%{top:.5625em;left:.0625em;width:0}54%{top:.125em;left:.125em;width:0}70%{top:.625em;left:-.25em;width:1.625em}84%{top:1.0625em;left:.75em;width:.5em}100%{top:1.125em;left:.1875em;width:.75em}}@-webkit-keyframes swal2-toast-animate-success-line-long{0%{top:1.625em;right:1.375em;width:0}65%{top:1.25em;right:.9375em;width:0}84%{top:.9375em;right:0;width:1.125em}100%{top:.9375em;right:.1875em;width:1.375em}}@keyframes swal2-toast-animate-success-line-long{0%{top:1.625em;right:1.375em;width:0}65%{top:1.25em;right:.9375em;width:0}84%{top:.9375em;right:0;width:1.125em}100%{top:.9375em;right:.1875em;width:1.375em}}@-webkit-keyframes swal2-show{0%{transform:scale(.7)}45%{transform:scale(1.05)}80%{transform:scale(.95)}100%{transform:scale(1)}}@keyframes swal2-show{0%{transform:scale(.7)}45%{transform:scale(1.05)}80%{transform:scale(.95)}100%{transform:scale(1)}}@-webkit-keyframes swal2-hide{0%{transform:scale(1);opacity:1}100%{transform:scale(.5);opacity:0}}@keyframes swal2-hide{0%{transform:scale(1);opacity:1}100%{transform:scale(.5);opacity:0}}@-webkit-keyframes swal2-animate-success-line-tip{0%{top:1.1875em;left:.0625em;width:0}54%{top:1.0625em;left:.125em;width:0}70%{top:2.1875em;left:-.375em;width:3.125em}84%{top:3em;left:1.3125em;width:1.0625em}100%{top:2.8125em;left:.8125em;width:1.5625em}}@keyframes swal2-animate-success-line-tip{0%{top:1.1875em;left:.0625em;width:0}54%{top:1.0625em;left:.125em;width:0}70%{top:2.1875em;left:-.375em;width:3.125em}84%{top:3em;left:1.3125em;width:1.0625em}100%{top:2.8125em;left:.8125em;width:1.5625em}}@-webkit-keyframes swal2-animate-success-line-long{0%{top:3.375em;right:2.875em;width:0}65%{top:3.375em;right:2.875em;width:0}84%{top:2.1875em;right:0;width:3.4375em}100%{top:2.375em;right:.5em;width:2.9375em}}@keyframes swal2-animate-success-line-long{0%{top:3.375em;right:2.875em;width:0}65%{top:3.375em;right:2.875em;width:0}84%{top:2.1875em;right:0;width:3.4375em}100%{top:2.375em;right:.5em;width:2.9375em}}@-webkit-keyframes swal2-rotate-success-circular-line{0%{transform:rotate(-45deg)}5%{transform:rotate(-45deg)}12%{transform:rotate(-405deg)}100%{transform:rotate(-405deg)}}@keyframes swal2-rotate-success-circular-line{0%{transform:rotate(-45deg)}5%{transform:rotate(-45deg)}12%{transform:rotate(-405deg)}100%{transform:rotate(-405deg)}}@-webkit-keyframes swal2-animate-error-x-mark{0%{margin-top:1.625em;transform:scale(.4);opacity:0}50%{margin-top:1.625em;transform:scale(.4);opacity:0}80%{margin-top:-.375em;transform:scale(1.15)}100%{margin-top:0;transform:scale(1);opacity:1}}@keyframes swal2-animate-error-x-mark{0%{margin-top:1.625em;transform:scale(.4);opacity:0}50%{margin-top:1.625em;transform:scale(.4);opacity:0}80%{margin-top:-.375em;transform:scale(1.15)}100%{margin-top:0;transform:scale(1);opacity:1}}@-webkit-keyframes swal2-animate-error-icon{0%{transform:rotateX(100deg);opacity:0}100%{transform:rotateX(0);opacity:1}}@keyframes swal2-animate-error-icon{0%{transform:rotateX(100deg);opacity:0}100%{transform:rotateX(0);opacity:1}}@-webkit-keyframes swal2-rotate-loading{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}@keyframes swal2-rotate-loading{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown){overflow:hidden}body.swal2-height-auto{height:auto!important}body.swal2-no-backdrop .swal2-container{top:auto;right:auto;bottom:auto;left:auto;max-width:calc(100% - .625em * 2);background-color:transparent!important}body.swal2-no-backdrop .swal2-container>.swal2-modal{box-shadow:0 0 10px rgba(0,0,0,.4)}body.swal2-no-backdrop .swal2-container.swal2-top{top:0;left:50%;transform:translateX(-50%)}body.swal2-no-backdrop .swal2-container.swal2-top-left,body.swal2-no-backdrop .swal2-container.swal2-top-start{top:0;left:0}body.swal2-no-backdrop .swal2-container.swal2-top-end,body.swal2-no-backdrop .swal2-container.swal2-top-right{top:0;right:0}body.swal2-no-backdrop .swal2-container.swal2-center{top:50%;left:50%;transform:translate(-50%,-50%)}body.swal2-no-backdrop .swal2-container.swal2-center-left,body.swal2-no-backdrop .swal2-container.swal2-center-start{top:50%;left:0;transform:translateY(-50%)}body.swal2-no-backdrop .swal2-container.swal2-center-end,body.swal2-no-backdrop .swal2-container.swal2-center-right{top:50%;right:0;transform:translateY(-50%)}body.swal2-no-backdrop .swal2-container.swal2-bottom{bottom:0;left:50%;transform:translateX(-50%)}body.swal2-no-backdrop .swal2-container.swal2-bottom-left,body.swal2-no-backdrop .swal2-container.swal2-bottom-start{bottom:0;left:0}body.swal2-no-backdrop .swal2-container.swal2-bottom-end,body.swal2-no-backdrop .swal2-container.swal2-bottom-right{right:0;bottom:0}@media print{body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown){overflow-y:scroll!important}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown)>[aria-hidden=true]{display:none}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) .swal2-container{position:static!important}}body.swal2-toast-shown .swal2-container{background-color:transparent}body.swal2-toast-shown .swal2-container.swal2-top{top:0;right:auto;bottom:auto;left:50%;transform:translateX(-50%)}body.swal2-toast-shown .swal2-container.swal2-top-end,body.swal2-toast-shown .swal2-container.swal2-top-right{top:0;right:0;bottom:auto;left:auto}body.swal2-toast-shown .swal2-container.swal2-top-left,body.swal2-toast-shown .swal2-container.swal2-top-start{top:0;right:auto;bottom:auto;left:0}body.swal2-toast-shown .swal2-container.swal2-center-left,body.swal2-toast-shown .swal2-container.swal2-center-start{top:50%;right:auto;bottom:auto;left:0;transform:translateY(-50%)}body.swal2-toast-shown .swal2-container.swal2-center{top:50%;right:auto;bottom:auto;left:50%;transform:translate(-50%,-50%)}body.swal2-toast-shown .swal2-container.swal2-center-end,body.swal2-toast-shown .swal2-container.swal2-center-right{top:50%;right:0;bottom:auto;left:auto;transform:translateY(-50%)}body.swal2-toast-shown .swal2-container.swal2-bottom-left,body.swal2-toast-shown .swal2-container.swal2-bottom-start{top:auto;right:auto;bottom:0;left:0}body.swal2-toast-shown .swal2-container.swal2-bottom{top:auto;right:auto;bottom:0;left:50%;transform:translateX(-50%)}body.swal2-toast-shown .swal2-container.swal2-bottom-end,body.swal2-toast-shown .swal2-container.swal2-bottom-right{top:auto;right:0;bottom:0;left:auto}body.swal2-toast-column .swal2-toast{flex-direction:column;align-items:stretch}body.swal2-toast-column .swal2-toast .swal2-actions{flex:1;align-self:stretch;height:2.2em;margin-top:.3125em}body.swal2-toast-column .swal2-toast .swal2-loading{justify-content:center}body.swal2-toast-column .swal2-toast .swal2-input{height:2em;margin:.3125em auto;font-size:1em}body.swal2-toast-column .swal2-toast .swal2-validation-message{font-size:1em}</style></head>

<body onload="inicio()" onkeypress="reset()" onclick="reset()" onmousemove="reset()">
    <!-- Navigation Mobil-->
    <span class="d-none d-md-inline d-lg-none d-sm-inline d-md-none d-inline d-sm-none justify-content-between">
        <nav class="navbar fixed-bottom navbar-light bg-light " style="justify-content: center">
            <!--<table class="table table-borderless table-sm">
                <tr>
                    <td>
                        <label><small class="font-weight-bold">Monto de la Apuesta:</small></label>
                        <input type="number" placeholder="Monto Apuesta" id="montoApostar_mobil" name="montoApostar_mobil" required="" class="form-control form-control-sm" maxlength="10" autocomplete="OFF" onkeyup="premio_mobil(event,this)" />
                    </td>
                    <td>
                        <label><small class="font-weight-bold">Monto del Premio:</small></label>
                        <input disabled="" type="number" placeholder="Monto Premio" id="montoPremio_mobil" name="montoPremio_mobil" class="form-control form-control-sm form-input-premio" autofocus="" />
                    </td>
                </tr>
            </table>-->
            <!--<button type="button" class="btn btn-lg btn-light" onclick="javascript:$('#myCargandoJuegos').css('opacity','1.0'); $('#myCargandoJuegos').css('visibility','visible'); xajax_filtrar_disciplina(xajax.getFormValues(form_filtro_fecha)); return false; ">
                <i class="fa fa-home" aria-hidden="true"></i>
            </button>-->
            <!--<button id="btn_nuevo_pago_sm" type="button" class="btn btn-lg btn-light" onclick="xajax_nuevo_pago();">
                <i class="fa fa-usd" aria-hidden="true"></i>
            </button>-->
            <button type="button" class="btn btn-lg btn-danger" id="btnlimpiarjugada" data-tooltip-content="tooltip" data-placement="top" title="" data-original-title="Limpiar Jugadas">
                <i class="fa fa-paint-brush" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-lg btn-success" id="btnverticketjugado" data-toggle="modal" data-target="#exampleModal_mobil" data-tooltip-content="tooltip" data-placement="top" title="" data-original-title="Procesar Ticket">
                <i class="fa fa-check-circle" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-lg btn-light" id="btnticketjugados" data-toggle="modal" data-target="#exampleModal_mobil1" data-tooltip-content="tooltip" data-placement="top" title="" data-original-title="Listado Ticket">
                <i class="fa fa-th" aria-hidden="true"></i>
            </button>
            <!--<button type="button" class="btn btn-lg btn-success" onclick="$('#btn_procesar_final_lg').attr('disabled', false); xajax_procesar_jugadas();">
                <div id="jugadas_movil">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                </div>
            </button>-->
        </nav>
        <!--<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
            <table class="table table-borderless table-sm">
                <tr>
                    <td>
                        <label><small class="font-weight-bold text-white">Monto de la Apuesta:</small></label>
                        <input type="text" placeholder="Monto de la Apuesta" id="montoApostar-mobil" name="montoApostar-mobil" required="" class="form-control form-control-sm" autofocus="" />
                    </td>
                    <td>
                        <label><small class="font-weight-bold text-white">Monto del Premio:</small></label>
                        <input disabled="" type="text" placeholder="Monto de la Apuesta" id="montoPremio-mobil" name="montoPremio-mobil" class="form-control form-control-sm" autofocus="" />
                    </td>
                </tr>
            </table>
        </nav>-->
    </span>

    <!-- Navigation -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="https://wuao.site/taquilla_ticket#">
                Online
            </a>
            <button class="navbar-toggler navbar-toggler-left" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto"><li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="https://wuao.site/taquilla_ticket#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Jugar Aqui</a><div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio"><a href="https://wuao.site/taquilla_ticket" class="dropdown-item">Parley</a></div></li><li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="https://wuao.site/taquilla_ticket#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mi Cuenta</a><div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio"><a href="https://wuao.site/depositos" class="dropdown-item">Recarga de Saldo</a><a href="https://wuao.site/retiros" class="dropdown-item">Retiros</a><a href="https://wuao.site/perfil" class="dropdown-item">Datos de Perfil</a></div></li><li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="https://wuao.site/taquilla_ticket#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Procesos</a><div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio"><a href="https://wuao.site/buscar_ticket/vendedor" class="dropdown-item">Buscar Tickets</a></div></li><li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="https://wuao.site/taquilla_ticket#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reportes</a><div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio"><a href="https://wuao.site/reportes/ticket_prem" class="dropdown-item">Tickets Premiados</a><a href="https://wuao.site/reportes/vtaquillas" class="dropdown-item">Ventas Ticket</a></div></li><li class="nav-item"><a href="https://wuao.site/welcome/logout_ci" class="nav-link">Salir</a></li></ul>            </div>
        </div>
    </nav>
    <!-- Page Content -->
    <div class="container-fluid">
        <script type="text/javascript">
    var time;

    function inicio() {
        time = setTimeout(function() {
            $(document).ready(function(e) {
                $("#form").submit(function() {
                    //alert("SUBMIT");
                    return false; //Si devolvemos false, el formulario ya no se enviará.
                });
                //enviar();
                /* $.ajax({
		url:'server/include/verisession.php',
		type:'POST',
		data:'veri=1',
		success: function(data){			
			if(data == 1)
			{
				alert("Sesion Caducada");
			        document.location.href='index.html';			   
			}			
		}	
	});*/
            });
        }, 1800000); //fin timeout
    } //fin inicio
    function reset() {
        clearTimeout(time); //limpia el timeout para resetear el tiempo desde cero 
        time = setTimeout(function() {
            $(document).ready(function(e) {
                $("#form").submit(function() {
                    //alert("SUBMIT");
                    return false; //Si devolvemos false, el formulario ya no se enviará.
                });
                //enviar();
                /*$.ajax({
		url:'server/include/verisession.php',
		type:'POST',
		data:'veri=1',
		success: function(data){			
			if(data == 1)
			{
			   alert("Sesion Caducada");
			   document.location.href='index.html';			   
			}			
		}	
	});*/
            });
        }, 1800000); //fin timeout
    } //fin reset
    function autoservicio() {
        $.post("taquilla_ticket/autoservicio",
            function(eData) {
                $("#detalleAutoservicio").html(eData);
            });
    }
</script>
<style type="text/css">
    #scroll {
        width: 628px;
        height: 315px;
        background: url(../Images/contenido.jpg);
        overflow: auto;
    }

    .rules-part {

        font-size: 14pt;
        color: #800;
        font-style: italic;
        background-color: #ffffff;
    }

    .inputTextSingleCalc {
        background-color: transparent;
        color: #ffffff;
        text-align: center;
        border-style: none;
    }

    .inputTextSingleLeftCalc {
        background-color: transparent;
        color: #ffffff;
        text-align: left;
        border-style: none;
    }

    .inputTextSingleRightCalc {
        background-color: transparent;
        color: #ffffff;
        text-align: right;
        border-style: none;
    }

    .cabecera_titulo {
        background: #000000;
        font-family: Sans-serif, Helvetica, Arial, Verdana;
        font-size: 13px;
    }

    .fechaJuego {
        font-family: Tahoma;
        font-size: 10px;
        color: yellow;
    }

    .cabecera_titulo1 {
        background: #2d35d2;
        font-size: 16px;
        text-align: center;
    }

    #scrollj {
        top: 0px;
        left: 0;
        right: 0px;
        /*Set right value to WidthOfFrameDiv*/
        bottom: 0;
        overflow: auto;
        background: #00000;
        width: auto;
        height: 450px;
    }

    #scrollmobil {
        top: 0px;
        left: 0;
        right: 0px;
        /*Set right value to WidthOfFrameDiv*/
        bottom: 0;
        overflow: auto;
        background: #00000;
        width: auto;
        height: 350px;
    }


    .logro_ver {
        color: #ff0000;
        font-size: 12px;
    }

    #tabj {
        font-family: Sans-serif, Helvetica, Arial, Verdana;
        font-size: 12px;
        /*margin-top:30px*/
    }
</style>
<script type="text/javascript">
    $(function() {
        $(".hlpdep").button();
    });
</script>



<!-- Pantalla no mobil    XS - LG -->
<span class="d-none d-xl-inline d-lg-inline d-xl-none">
    <div class="row">
        <div class="col-lg-3 mb-4">

            <form action="http://localhost/parley/vendedorclon.php" method="post" accept-charset="utf-8" id="form" name="form">            
			<input type="hidden" name="agregar" value="false">
            <input type="hidden" name="teaser" id="teaser" value="false">
            <input type="hidden" name="isFree" value="0">
			<input type="hidden" name="usuario" value="<?php echo $usuario; ?>">
			<input type="hidden" name="taquilla" value="<?php echo $taquilla; ?>">
            <input type="hidden" name="simple" value="true">
            <input type="hidden" name="macAddress" value="">
            <input type="hidden" name="moneda" id="moneda" value="Bs.">
            <input type="text" name="n_ticket" size="6" class="inputTextSingleocul" style="text-align:right;display:none;" readonly="yes" value="0001042533">
            <input type="text" name="serial" size="6" class="inputTextSingleocul" style="text-align:right;display:none;" readonly="yes" value="D419Cb1CB4">
            <table class="table table-borderless table-sm">
                <tbody><tr class="ui-state-default ui-corner-all ui-state-focus liga">
                    <td colspan="2">
                        <h5 class="card-title">CALCULO DE LA JUGADA</h5>
                    </td>
                </tr>
                <tr class="ui-state-default ui-corner-all ui-state-focus liga"><td colspan="2">SALDO DISPONIBLE: $. <br><span style=" font-size:25px;color:#fc3c03">100000 </span></td></tr>                <tr>
                    <td colspan="4">
                        <label for="exampleInputMonto">Monto de la Apuesta: BOLIVARES<b>(Bs.)</b></label>
                        <input name="montoApostar" id="montoApostar" type="text" class="form-control" value="10000" size="10" style=" height:50px; font-size:30px" maxlength="10" autocomplete="OFF" onkeyup="premio(event,this)">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="row">
                            <div class="col-md-12 col-lg-7">
                                <!--<button type="submit" class="btn btn-primary" style="font-size:12px; height:30px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Grabar e Imprimir</button>-->
                                <button type="submit" class="btn btn-primary btn-block btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> ..Grabar e Imprimir..</button>
                            </div>
                            <div class="col-md-12 col-lg-5">
                                <!--<button type="button"  id="limpiar_parley"  class="btn btn-danger" onclick="limpiarPantalla()" style="font-size:12px; height:30px;"><i class="fa fa-paint-brush" aria-hidden="true"></i> Limpiar</button>-->
                                <button class="btn btn-danger btn-block btn-sm" onclick="limpiarPantalla();return false"><i class="fa fa-paint-brush" aria-hidden="true"></i> Limpiar</button>
                            </div>
                        </div>

                        <!--<button type="button"  id="limpiar_parley"  class="btn btn-danger" onclick="limpiarPantalla()" style="font-size:12px; height:30px;"><i class="fa fa-paint-brush" aria-hidden="true"></i> Limpiar</button>-->
                    </td>
                </tr>

                
                <tr>
                    <td colspan="2">
                        <label for="exampleInputPremio">Monto del Premio: BOLIVARES<b>(Bs.)</b></label>
                        <input type="text" name="montoPremio" id="xxxmontoPremio" size="10" class="form-control" style="height:50px;text-align:right;font-size:30px" readonly="yes">
                    </td>
                </tr>
                <tr class="ui-state-default ui-corner-all ui-state-focus">
                    <td class="calculadora">&nbsp;Jugadas: </td>
                    <!--<td class="calculadora">&nbsp;Ref.</td>
<td class="calculadora">&nbsp;Equipo</td>-->
                    <!--<td class="calculadora">&nbsp;Logro</td>-->
                </tr>
                                    <tr style="background:#0b0000;color:#ffffff">
                        <td class="calculadora borde_linea" style="display: ">
                            <input type="hidden" name="codigo" class="inputTextSingleCalc">
                            <input type="hidden" name="padre" class="inputTextSingleCalc">
                            <input type="hidden" name="deporte">
                            <input type="hidden" name="tipo" class="inputTextSingleCalc" readonly="yes" style="width:40px">
                            <input type="hidden" name="cantidad" class="inputTextSingleCalc" style="width:40px" readonly="yes">
                            <input type="hidden" name="referencia" class="inputTextSingleLeftCalc" style="width:60px" readonly="yes">
                            <input type="hidden" name="equipo" class="inputTextSingleCalc" style="width:150px;text-align:left;" readonly="yes">
                            <input type="hidden" name="logro" class="inputTextSingleLeftCalc" size="3" readonly="yes">
                            <input type="hidden" name="juego">
                            <input type="hidden" name="numero">
                            <input type="text" name="descrip" class="inputTextSingleCalc" readonly="yes" style="width:100%">
                        </td>
                    </tr>
                                    <tr style="background:#0b0000;color:#ffffff">
                        <td class="calculadora borde_linea" style="display: ">
                            <input type="hidden" name="codigo" class="inputTextSingleCalc">
                            <input type="hidden" name="padre" class="inputTextSingleCalc">
                            <input type="hidden" name="deporte">
                            <input type="hidden" name="tipo" class="inputTextSingleCalc" readonly="yes" style="width:40px">
                            <input type="hidden" name="cantidad" class="inputTextSingleCalc" style="width:40px" readonly="yes">
                            <input type="hidden" name="referencia" class="inputTextSingleLeftCalc" style="width:60px" readonly="yes">
                            <input type="hidden" name="equipo" class="inputTextSingleCalc" style="width:150px;text-align:left;" readonly="yes">
                            <input type="hidden" name="logro" class="inputTextSingleLeftCalc" size="3" readonly="yes">
                            <input type="hidden" name="juego">
                            <input type="hidden" name="numero">
                            <input type="text" name="descrip" class="inputTextSingleCalc" readonly="yes" style="width:100%">
                        </td>
                    </tr>
                                    <tr style="background:#0b0000;color:#ffffff">
                        <td class="calculadora borde_linea" style="display: ">
                            <input type="hidden" name="codigo" class="inputTextSingleCalc">
                            <input type="hidden" name="padre" class="inputTextSingleCalc">
                            <input type="hidden" name="deporte">
                            <input type="hidden" name="tipo" class="inputTextSingleCalc" readonly="yes" style="width:40px">
                            <input type="hidden" name="cantidad" class="inputTextSingleCalc" style="width:40px" readonly="yes">
                            <input type="hidden" name="referencia" class="inputTextSingleLeftCalc" style="width:60px" readonly="yes">
                            <input type="hidden" name="equipo" class="inputTextSingleCalc" style="width:150px;text-align:left;" readonly="yes">
                            <input type="hidden" name="logro" class="inputTextSingleLeftCalc" size="3" readonly="yes">
                            <input type="hidden" name="juego">
                            <input type="hidden" name="numero">
                            <input type="text" name="descrip" class="inputTextSingleCalc" readonly="yes" style="width:100%">
                        </td>
                    </tr>
                                    <tr style="background:#0b0000;color:#ffffff">
                        <td class="calculadora borde_linea" style="display: ">
                            <input type="hidden" name="codigo" class="inputTextSingleCalc">
                            <input type="hidden" name="padre" class="inputTextSingleCalc">
                            <input type="hidden" name="deporte">
                            <input type="hidden" name="tipo" class="inputTextSingleCalc" readonly="yes" style="width:40px">
                            <input type="hidden" name="cantidad" class="inputTextSingleCalc" style="width:40px" readonly="yes">
                            <input type="hidden" name="referencia" class="inputTextSingleLeftCalc" style="width:60px" readonly="yes">
                            <input type="hidden" name="equipo" class="inputTextSingleCalc" style="width:150px;text-align:left;" readonly="yes">
                            <input type="hidden" name="logro" class="inputTextSingleLeftCalc" size="3" readonly="yes">
                            <input type="hidden" name="juego">
                            <input type="hidden" name="numero">
                            <input type="text" name="descrip" class="inputTextSingleCalc" readonly="yes" style="width:100%">
                        </td>
                    </tr>
                                    <tr style="background:#0b0000;color:#ffffff">
                        <td class="calculadora borde_linea" style="display: ">
                            <input type="hidden" name="codigo" class="inputTextSingleCalc">
                            <input type="hidden" name="padre" class="inputTextSingleCalc">
                            <input type="hidden" name="deporte">
                            <input type="hidden" name="tipo" class="inputTextSingleCalc" readonly="yes" style="width:40px">
                            <input type="hidden" name="cantidad" class="inputTextSingleCalc" style="width:40px" readonly="yes">
                            <input type="hidden" name="referencia" class="inputTextSingleLeftCalc" style="width:60px" readonly="yes">
                            <input type="hidden" name="equipo" class="inputTextSingleCalc" style="width:150px;text-align:left;" readonly="yes">
                            <input type="hidden" name="logro" class="inputTextSingleLeftCalc" size="3" readonly="yes">
                            <input type="hidden" name="juego">
                            <input type="hidden" name="numero">
                            <input type="text" name="descrip" class="inputTextSingleCalc" readonly="yes" style="width:100%">
                        </td>
                    </tr>
                                    <tr style="background:#0b0000;color:#ffffff">
                        <td class="calculadora borde_linea" style="display: ">
                            <input type="hidden" name="codigo" class="inputTextSingleCalc">
                            <input type="hidden" name="padre" class="inputTextSingleCalc">
                            <input type="hidden" name="deporte">
                            <input type="hidden" name="tipo" class="inputTextSingleCalc" readonly="yes" style="width:40px">
                            <input type="hidden" name="cantidad" class="inputTextSingleCalc" style="width:40px" readonly="yes">
                            <input type="hidden" name="referencia" class="inputTextSingleLeftCalc" style="width:60px" readonly="yes">
                            <input type="hidden" name="equipo" class="inputTextSingleCalc" style="width:150px;text-align:left;" readonly="yes">
                            <input type="hidden" name="logro" class="inputTextSingleLeftCalc" size="3" readonly="yes">
                            <input type="hidden" name="juego">
                            <input type="hidden" name="numero">
                            <input type="text" name="descrip" class="inputTextSingleCalc" readonly="yes" style="width:100%">
                        </td>
                    </tr>
                                    <tr style="background:#0b0000;color:#ffffff">
                        <td class="calculadora borde_linea" style="display: ">
                            <input type="hidden" name="codigo" class="inputTextSingleCalc">
                            <input type="hidden" name="padre" class="inputTextSingleCalc">
                            <input type="hidden" name="deporte">
                            <input type="hidden" name="tipo" class="inputTextSingleCalc" readonly="yes" style="width:40px">
                            <input type="hidden" name="cantidad" class="inputTextSingleCalc" style="width:40px" readonly="yes">
                            <input type="hidden" name="referencia" class="inputTextSingleLeftCalc" style="width:60px" readonly="yes">
                            <input type="hidden" name="equipo" class="inputTextSingleCalc" style="width:150px;text-align:left;" readonly="yes">
                            <input type="hidden" name="logro" class="inputTextSingleLeftCalc" size="3" readonly="yes">
                            <input type="hidden" name="juego">
                            <input type="hidden" name="numero">
                            <input type="text" name="descrip" class="inputTextSingleCalc" readonly="yes" style="width:100%">
                        </td>
                    </tr>
                                    <tr style="background:#0b0000;color:#ffffff">
                        <td class="calculadora borde_linea" style="display: ">
                            <input type="hidden" name="codigo" class="inputTextSingleCalc">
                            <input type="hidden" name="padre" class="inputTextSingleCalc">
                            <input type="hidden" name="deporte">
                            <input type="hidden" name="tipo" class="inputTextSingleCalc" readonly="yes" style="width:40px">
                            <input type="hidden" name="cantidad" class="inputTextSingleCalc" style="width:40px" readonly="yes">
                            <input type="hidden" name="referencia" class="inputTextSingleLeftCalc" style="width:60px" readonly="yes">
                            <input type="hidden" name="equipo" class="inputTextSingleCalc" style="width:150px;text-align:left;" readonly="yes">
                            <input type="hidden" name="logro" class="inputTextSingleLeftCalc" size="3" readonly="yes">
                            <input type="hidden" name="juego">
                            <input type="hidden" name="numero">
                            <input type="text" name="descrip" class="inputTextSingleCalc" readonly="yes" style="width:100%">
                        </td>
                    </tr>
                                    <tr style="background:#0b0000;color:#ffffff">
                        <td class="calculadora borde_linea" style="display: ">
                            <input type="hidden" name="codigo" class="inputTextSingleCalc">
                            <input type="hidden" name="padre" class="inputTextSingleCalc">
                            <input type="hidden" name="deporte">
                            <input type="hidden" name="tipo" class="inputTextSingleCalc" readonly="yes" style="width:40px">
                            <input type="hidden" name="cantidad" class="inputTextSingleCalc" style="width:40px" readonly="yes">
                            <input type="hidden" name="referencia" class="inputTextSingleLeftCalc" style="width:60px" readonly="yes">
                            <input type="hidden" name="equipo" class="inputTextSingleCalc" style="width:150px;text-align:left;" readonly="yes">
                            <input type="hidden" name="logro" class="inputTextSingleLeftCalc" size="3" readonly="yes">
                            <input type="hidden" name="juego">
                            <input type="hidden" name="numero">
                            <input type="text" name="descrip" class="inputTextSingleCalc" readonly="yes" style="width:100%">
                        </td>
                    </tr>
                                    <tr style="background:#0b0000;color:#ffffff">
                        <td class="calculadora borde_linea" style="display: ">
                            <input type="hidden" name="codigo" class="inputTextSingleCalc">
                            <input type="hidden" name="padre" class="inputTextSingleCalc">
                            <input type="hidden" name="deporte">
                            <input type="hidden" name="tipo" class="inputTextSingleCalc" readonly="yes" style="width:40px">
                            <input type="hidden" name="cantidad" class="inputTextSingleCalc" style="width:40px" readonly="yes">
                            <input type="hidden" name="referencia" class="inputTextSingleLeftCalc" style="width:60px" readonly="yes">
                            <input type="hidden" name="equipo" class="inputTextSingleCalc" style="width:150px;text-align:left;" readonly="yes">
                            <input type="hidden" name="logro" class="inputTextSingleLeftCalc" size="3" readonly="yes">
                            <input type="hidden" name="juego">
                            <input type="hidden" name="numero">
                            <input type="text" name="descrip" class="inputTextSingleCalc" readonly="yes" style="width:100%">
                        </td>
                    </tr>
                            </tbody></table>
            <small><b>Zona Horaria:</b> America/Caracas</small>
            <br>
                        </form>
        </div>
        <!-- end .grid_1 -->
        <div class="col-lg-9 mb-4">
                        <div class="alert alert-danger" role="alert">
                <h6><b>ATENCION:</b> Si existe un error evidente en juego y/o logros, dicho logro sera anulado.</h6>
            </div>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
<?php if ($Baseball>0) {?>
<a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#nav-Beisbol" role="tab" aria-controls="nav-Beisbol" aria-selected="true">
<div class="sportIcon sportIcon--baseball"></div> Baseball</a>
<?php }?>
<?php if ($Basketball>0) {?>
<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-Baloncesto" role="tab" aria-controls="nav-Baloncesto" aria-selected="false">
<div class="sportIcon sportIcon--basketball"></div> Basketball</a>
<?php }?>
                    <!--<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-Hipico" role="tab" aria-controls="nav-Hipico" aria-selected="false"><img width="20px" height="20px" src="https://wuao.site/include/img/icono/1073253.png" class="img-responsive img-circle" alt="User Image"> Hipico</a>
                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-Macuare" role="tab" aria-controls="nav-Macuare" aria-selected="false"><img width="20px" height="20px" src="https://wuao.site/include/img/icono/1073253.png" class="img-responsive img-circle" alt="User Image"> Macuare</a>
                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-Otros" role="tab" aria-controls="nav-Otros" aria-selected="false"><img width="20px" height="20px" src="https://wuao.site/include/img/icono/2313758.png" class="img-responsive img-circle" alt="User Image"> Otros</a>-->
                </div>
            </nav>
			
			
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade " id="nav-Beisbol" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
								55555 beisbol inicio pc
                                    <div id="scrollj">
									
									
        <table class="table table-bordered table-sm">
                <thead>
                        <tr class="table-dark">
                                <td colspan="12">
                                        <h6 class="font-weight-bold">Baseball</h6>
                                </td>
                        </tr>
                </thead>
                <tbody>
            <tr class="table-danger"><td colspan="12"><div class="equipos">MAJOR LEAGUE BASEBALL | </div></td></tr>
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			<tr class="table-dark">
            <th><h6><small class="font-weight-bold">REF..</small></h6></th><th><h6><small class="font-weight-bold">07/09/2020 1:10 pm</small></h6></th><th><h6><small class="font-weight-bold">Ganar</small></h6></th>
            <th><h6><small class="font-weight-bold">RL</small></h6></th>
            <th><h6><small class="font-weight-bold">SRL</small></h6></th>
            <th><h6><small class="font-weight-bold">A/B</small></h6></th>
            <th><h6><small class="font-weight-bold">½ Ganar</small></h6></th>
            <th><h6><small class="font-weight-bold">½ RL</small></h6></th>
            <th><h6><small class="font-weight-bold">½ A/B</small></h6></th>
            <th><h6><small class="font-weight-bold">S/N</small></h6></th>
            <th><h6><small class="font-weight-bold">V/H</small></h6></th>
            <th><h6><small class="font-weight-bold">HCE</small></h6></th>
            </tr>
<tr class="table-light"><td><div class="text-center font-weight-bold">468938</div></td>
<td><img width="22px" height="22px" class="img-fluid" src="./Vendedorclon_files/riFAKCzS-OtgHPvkQ.png"> MARLINS (MIA)<p><small class="text-danger font-weight-bold">J URENA -R </small></p></td>
<td id="45684_468938" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45684,ML, ,468938,180,MARLINS (MIA),7027,1,19590,4,,13:10:00,">180</td><td id="45684_1468938" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45684,RL,1.5,1468938,-110,MARLINS (MIA),7027,2,19590,4,,13:10:00,"><small class="text-muted"><b>1.5</b></small> -110</td>
<td></td>
<td id="45684_A468938" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" 
class="45684,A,9,A468938,-110,MARLINS (MIA),7027,4,19590,4,,13:10:00,">
<small class="text-danger"><b>A 9</b></small> -110</td>


<td id="45684_5468938" 
onmouseover="changeCell(this)" 
onmouseout="changeCellOut(this)" 
class="45684,5ML, ,5468938,181,MARLINS (MIA),7027,9,19590,4,,13:10:00,">180</td>







<td id="45684_2468938" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45684,5RL,0.5,2468938,125,MARLINS (MIA),7027,10,19590,4,,13:10:00,"><small class="text-danger"><b>0.5</b></small> 125</td><td id="45684_A5468938" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45684,5A,5,A5468938,-115,MARLINS (MIA),7027,12,19590,4,,13:10:00,"><small class="text-danger"><b>A 5</b></small> -115</td>
<td></td>
<td id="45684_7468938" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45684,AP, ,7468938,,MARLINS (MIA),7027,19,19590,4,,13:10:00,"></td>
<td></td>
</tr>
<tr></tr>
<tr class="table-light">
<td><div class="text-center font-weight-bold">468939</div></td>
<td><img width="22px" height="22px" class="img-fluid" src="./Vendedorclon_files/IPmhSoEa-6HCcbU5j.png"> Bravos de Atlanta<p><small class="text-danger font-weight-bold">I ANDERSON -R </small></p></td>
<td id="45685_468939" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45685,ML, ,468939,-230,Bravos de Atlanta,5265,5,19590,4,,13:10:00,Atlanta Braves">-230</td>
<td id="45685_1468939" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45685,RL,-1.5,1468939,-120,Bravos de Atlanta,5265,6,19590,4,,13:10:00,Atlanta Braves"><small class="text-muted"><b>-1.5</b></small> -120</td>
<td></td>
<td id="45685_B468939" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45685,B,9,B468939,-110,Bravos de Atlanta,5265,8,19590,4,,13:10:00,Atlanta Braves"><small class="text-danger"><b>B 9</b></small> -110</td>
<td id="45685_5468939" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45685,5ML, ,5468939,-210,Bravos de Atlanta,5265,13,19590,4,,13:10:00,Atlanta Braves">-210</td>
<td id="45685_2468939" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45685,5RL,-0.5,2468939,-145,Bravos de Atlanta,5265,14,19590,4,,13:10:00,Atlanta Braves"><small class="text-danger"><b>-0.5</b></small> -145</td>
<td id="45685_B5468939" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45685,5B,5,B5468939,-105,Bravos de Atlanta,5265,16,19590,4,,13:10:00,Atlanta Braves"><small class="text-danger"><b>B 5</b></small> -105</td>
<td></td>
<td id="45685_7468939" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45685,AP, ,7468939,,Bravos de Atlanta,5265,23,19590,4,,13:10:00,Atlanta Braves"></td>
<td></td>
</tr><tr>

</tr>



























            <tr class="table-dark">
			<th><h6><small class="font-weight-bold">REF.</small></h6></th><th><h6><small class="font-weight-bold">07/09/2020 1:10 pm</small></h6></th><th><h6><small class="font-weight-bold">Ganar</small></h6></th>
            <th><h6><small class="font-weight-bold">RL</small></h6></th>
            <th><h6><small class="font-weight-bold">SRL</small></h6></th>
            <th><h6><small class="font-weight-bold">A/B</small></h6></th>
            <th><h6><small class="font-weight-bold">½ Ganar</small></h6></th>
            <th><h6><small class="font-weight-bold">½ RL</small></h6></th>
            <th><h6><small class="font-weight-bold">½ A/B</small></h6></th>
            <th><h6><small class="font-weight-bold">S/N</small></h6></th>
            <th><h6><small class="font-weight-bold">V/H</small></h6></th>
            <th><h6><small class="font-weight-bold">HCE</small></h6></th>
            </tr>
			<tr class="table-light">
			<td><div class="text-center font-weight-bold">468940</div></td>
			<td><img width="22px" height="22px" class="img-fluid" src="./Vendedorclon_files/AcX8PwzB-QHRR3jrT.png"> Filis de Filadelfia<p><small class="text-danger font-weight-bold">Z WHEELER -R </small></p></td>
			<td id="45686_468940" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45686,ML, ,468940,-130,Filis de Filadelfia,5272,1,19591,4,,13:10:00,Philadelphia Phillies">-130</td>
			<td id="45686_1468940" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45686,RL,-1.5,1468940,125,Filis de Filadelfia,5272,2,19591,4,,13:10:00,Philadelphia Phillies"><small class="text-muted"><b>-1.5</b></small> 125</td>
			<td></td>
			<td id="45686_A468940" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45686,A,9,A468940,-105,Filis de Filadelfia,5272,4,19591,4,,13:10:00,Philadelphia Phillies"><small class="text-danger"><b>A 9</b></small> -105</td>
			<td id="45686_5468940" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45686,5ML, ,5468940,-135,Filis de Filadelfia,5272,9,19591,4,,13:10:00,Philadelphia Phillies">-135</td>
			<td id="45686_2468940" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45686,5RL,-0.5,2468940,100,Filis de Filadelfia,5272,10,19591,4,,13:10:00,Philadelphia Phillies"><small class="text-danger"><b>-0.5</b></small> 100</td>
			<td id="45686_A5468940" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45686,5A,5,A5468940,100,Filis de Filadelfia,5272,12,19591,4,,13:10:00,Philadelphia Phillies"><small class="text-danger"><b>A 5</b></small> 100</td>
			<td></td><td id="45686_7468940" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45686,AP, ,7468940,,Filis de Filadelfia,5272,19,19591,4,,13:10:00,Philadelphia Phillies"></td>
			<td></td>
			</tr>
			<tr></tr>
			<tr class="table-light">
			<td><div class="text-center font-weight-bold">468941</div></td>
			<td><img width="22px" height="22px" class="img-fluid" src="./Vendedorclon_files/ID1PVAjl-S8v7yq39.png"> METS (NYM)<p><small class="text-danger font-weight-bold">D PETERSON -L </small></p></td>
			<td id="45687_468941" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45687,ML, ,468941,110,METS (NYM),7028,5,19591,4,,13:10:00,">110</td>
			<td id="45687_1468941" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45687,RL,1.5,1468941,-155,METS (NYM),7028,6,19591,4,,13:10:00,"><small class="text-muted"><b>1.5</b></small> -155</td>
			<td></td>
			<td id="45687_B468941" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45687,B,9,B468941,-115,METS (NYM),7028,8,19591,4,,13:10:00,"><small class="text-danger"><b>B 9</b></small> -115</td>
			<td id="45687_5468941" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45687,5ML, ,5468941,115,METS (NYM),7028,13,19591,4,,13:10:00,">115</td>
			<td id="45687_2468941" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45687,5RL,0.5,2468941,-120,METS (NYM),7028,14,19591,4,,13:10:00,"><small class="text-danger"><b>0.5</b></small> -120</td>
			<td id="45687_B5468941" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45687,5B,5,B5468941,-120,METS (NYM),7028,16,19591,4,,13:10:00,"><small class="text-danger"><b>B 5</b></small> -120</td>
			<td></td><td id="45687_7468941" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45687,AP, ,7468941,,METS (NYM),7028,23,19591,4,,13:10:00,"></td>
			<td></td>
			</tr>
			<tr></tr>
			

			<tr class="table-dark">
            <th><h6><small class="font-weight-bold">REF.</small></h6></th><th><h6><small class="font-weight-bold">07/09/2020 8:05 pm</small></h6></th><th><h6><small class="font-weight-bold">Ganar</small></h6></th>
            <th><h6><small class="font-weight-bold">RL</small></h6></th>
            <th><h6><small class="font-weight-bold">SRL</small></h6></th>
            <th><h6><small class="font-weight-bold">A/B</small></h6></th>
            <th><h6><small class="font-weight-bold">½ Ganar</small></h6></th>
            <th><h6><small class="font-weight-bold">½ RL</small></h6></th>
            <th><h6><small class="font-weight-bold">½ A/B</small></h6></th>
            <th><h6><small class="font-weight-bold">S/N</small></h6></th>
            <th><h6><small class="font-weight-bold">V/H</small></h6></th>
            <th><h6><small class="font-weight-bold">HCE</small></h6></th>
            </tr><tr class="table-light"><td><div class="text-center font-weight-bold">468958</div></td><td><img width="22px" height="22px" class="img-fluid" src="./Vendedorclon_files/Yg133Fg5-Yo5Ffu6p.png"> DIAMONDBACKS (ARZ)<p><small class="text-danger font-weight-bold">Z GALLEN -R </small></p></td><td id="45704_468958" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45704,ML, ,468958,110,DIAMONDBACKS (ARZ),7070,1,19600,4,,20:05:00,">110</td><td id="45704_1468958" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45704,RL,1.5,1468958,-215,DIAMONDBACKS (ARZ),7070,2,19600,4,,20:05:00,"><small class="text-muted"><b>1.5</b></small> -215</td><td></td><td id="45704_A468958" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45704,A,8,A468958,-110,DIAMONDBACKS (ARZ),7070,4,19600,4,,20:05:00,"><small class="text-danger"><b>A 8</b></small> -110</td><td id="45704_5468958" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45704,5ML, ,5468958,100,DIAMONDBACKS (ARZ),7070,9,19600,4,,20:05:00,">100</td><td id="45704_2468958" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45704,5RL,0.5,2468958,-135,DIAMONDBACKS (ARZ),7070,10,19600,4,,20:05:00,"><small class="text-danger"><b>0.5</b></small> -135</td><td id="45704_A5468958" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45704,5A,4,A5468958,-125,DIAMONDBACKS (ARZ),7070,12,19600,4,,20:05:00,"><small class="text-danger"><b>A 4</b></small> -125</td><td></td><td id="45704_7468958" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45704,AP, ,7468958,,DIAMONDBACKS (ARZ),7070,19,19600,4,,20:05:00,"></td><td></td></tr><tr></tr><tr class="table-light"><td><div class="text-center font-weight-bold">468959</div></td><td><img width="22px" height="22px" class="img-fluid" src="./Vendedorclon_files/faj1OHdM-S8v7yq39.png"> GIANTS (SF)<p><small class="text-danger font-weight-bold">K GAUSMAN -R </small></p></td><td id="45705_468959" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45705,ML, ,468959,-130,GIANTS (SF),7067,5,19600,4,,20:05:00,">-130</td><td id="45705_1468959" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45705,RL,-1.5,1468959,175,GIANTS (SF),7067,6,19600,4,,20:05:00,"><small class="text-muted"><b>-1.5</b></small> 175</td><td></td><td id="45705_B468959" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45705,B,8,B468959,-110,GIANTS (SF),7067,8,19600,4,,20:05:00,"><small class="text-danger"><b>B 8</b></small> -110</td><td id="45705_5468959" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45705,5ML, ,5468959,-120,GIANTS (SF),7067,13,19600,4,,20:05:00,">-120</td><td id="45705_2468959" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45705,5RL,-0.5,2468959,115,GIANTS (SF),7067,14,19600,4,,20:05:00,"><small class="text-danger"><b>-0.5</b></small> 115</td><td id="45705_B5468959" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45705,5B,4,B5468959,105,GIANTS (SF),7067,16,19600,4,,20:05:00,"><small class="text-danger"><b>B 4</b></small> 105</td><td></td><td id="45705_7468959" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45705,AP, ,7468959,,GIANTS (SF),7067,23,19600,4,,20:05:00,"></td><td></td></tr><tr>                </tr></tbody>
        
			<tr class="table-dark">
            <th><h6><small class="font-weight-bold">REF.</small></h6></th><th><h6><small class="font-weight-bold">07/09/2020 9:10 pm</small></h6></th><th><h6><small class="font-weight-bold">Ganar</small></h6></th>
            <th><h6><small class="font-weight-bold">RL</small></h6></th>
            <th><h6><small class="font-weight-bold">SRL</small></h6></th>
            <th><h6><small class="font-weight-bold">A/B</small></h6></th>
            <th><h6><small class="font-weight-bold">½ Ganar</small></h6></th>
            <th><h6><small class="font-weight-bold">½ RL</small></h6></th>
            <th><h6><small class="font-weight-bold">½ A/B</small></h6></th>
            <th><h6><small class="font-weight-bold">S/N</small></h6></th>
            <th><h6><small class="font-weight-bold">V/H</small></h6></th>
            <th><h6><small class="font-weight-bold">HCE</small></h6></th>
            </tr><tr class="table-light"><td><div class="text-center font-weight-bold">468956</div></td><td><img width="22px" height="22px" class="img-fluid" src="./Vendedorclon_files/KUkA1be5-CzVkxple.png"> ASTROS (HOU)<p><small class="text-danger font-weight-bold">C JAVIER -R </small></p></td><td id="45702_468956" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45702,ML, ,468956,130,ASTROS (HOU),7066,1,19599,4,,21:10:00,">130</td><td id="45702_1468956" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45702,RL,1.5,1468956,-155,ASTROS (HOU),7066,2,19599,4,,21:10:00,"><small class="text-muted"><b>1.5</b></small> -155</td><td></td><td id="45702_A468956" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45702,A,9,A468956,-120,ASTROS (HOU),7066,4,19599,4,,21:10:00,"><small class="text-danger"><b>A 9</b></small> -120</td><td id="45702_5468956" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45702,5ML, ,5468956,125,ASTROS (HOU),7066,9,19599,4,,21:10:00,">125</td><td id="45702_2468956" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45702,5RL,0.5,2468956,-110,ASTROS (HOU),7066,10,19599,4,,21:10:00,"><small class="text-danger"><b>0.5</b></small> -110</td><td id="45702_A5468956" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45702,5A,5,A5468956,-120,ASTROS (HOU),7066,12,19599,4,,21:10:00,"><small class="text-danger"><b>A 5</b></small> -120</td><td></td><td id="45702_7468956" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45702,AP, ,7468956,,ASTROS (HOU),7066,19,19599,4,,21:10:00,"></td><td></td></tr><tr></tr><tr class="table-light"><td><div class="text-center font-weight-bold">468957</div></td><td><img width="22px" height="22px" class="img-fluid" src="./Vendedorclon_files/OnC9Vnjl-EVX78ETc.png"> ATHLETICS (OAK)<p><small class="text-danger font-weight-bold">F MONTAS -R </small></p></td><td id="45703_468957" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45703,ML, ,468957,-150,ATHLETICS (OAK),7352,5,19599,4,,21:10:00,Oakland Athletics">-150</td><td id="45703_1468957" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45703,RL,-1.5,1468957,125,ATHLETICS (OAK),7352,6,19599,4,,21:10:00,Oakland Athletics"><small class="text-muted"><b>-1.5</b></small> 125</td><td></td><td id="45703_B468957" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45703,B,9,B468957,100,ATHLETICS (OAK),7352,8,19599,4,,21:10:00,Oakland Athletics"><small class="text-danger"><b>B 9</b></small> 100</td><td id="45703_5468957" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45703,5ML, ,5468957,-145,ATHLETICS (OAK),7352,13,19599,4,,21:10:00,Oakland Athletics">-145</td><td id="45703_2468957" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45703,5RL,-0.5,2468957,-110,ATHLETICS (OAK),7352,14,19599,4,,21:10:00,Oakland Athletics"><small class="text-danger"><b>-0.5</b></small> -110</td><td id="45703_B5468957" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45703,5B,5,B5468957,100,ATHLETICS (OAK),7352,16,19599,4,,21:10:00,Oakland Athletics"><small class="text-danger"><b>B 5</b></small> 100</td><td></td><td id="45703_7468957" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45703,AP, ,7468957,,ATHLETICS (OAK),7352,23,19599,4,,21:10:00,Oakland Athletics"></td><td></td></tr><tr></tr>
			

</tr></tbody>
        </table>
</div>        

55555 beisbol fin pc

                        </div>
                            </div>
                        </div>
                    </div>
                </div>
				
				
				

                <div class="tab-pane fade " id="nav-Baloncesto" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <div id="scrollj">
    <table class="table table-bordered table-sm">
        <thead>
            <tr class="table-dark">
                <td colspan="8">
                    <h6 class="font-weight-bold">Basketball</h6>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr class="table-primary"><td colspan="8"><div class="equipos">NBA | </div></td></tr><tr class="table-dark"><th><h6><small class="font-weight-bold">REF.</small></h6></th><th><h6><small class="font-weight-bold">07/09/2020 6:30 pm</small></h6></th><th><h6><small class="font-weight-bold">Ganar</small></h6></th><th><h6><small class="font-weight-bold">A/B</small></h6></th><th><h6><small class="font-weight-bold">Spread</small></h6></th><th><h6><small class="font-weight-bold">Ganar MJ</small></h6></th><th><h6><small class="font-weight-bold">A/B MJ</small></h6></th><th><h6><small class="font-weight-bold">Spread MJ</small></h6></th></tr><tr class="table-light"><td><div class="text-center font-weight-bold">468517</div></td><td>
    <div class="equipos"><img width="22px" height="22px" class="img-fluid" src="./Vendedorclon_files/2HLnhmZg-lIu3xPm3.png"> CELTICS (BOS)</div></td><td id="45608_468517" onmouseover="return changeCell(this)" onmouseout="return changeCellOut(this)" class="45608,ML, ,468517,-130,CELTICS (BOS),7029,1,19552,6,,18:30:00,Boston Celtics">-130</td><td id="45608_A468517" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45608,A,212,A468517,-110,CELTICS (BOS),7029,4,19552,6,,18:30:00,Boston Celtics"><small class="text-primary"><b>A 212</b></small> -110</td><td id="45608_1468517" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45608,RL,-1.5,1468517,-110,CELTICS (BOS),7029,2,19552,6,,18:30:00,Boston Celtics"><small class="text-primary"><b>-1.5</b></small> -110</td><td id="45608_5468517" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45608,5ML, ,5468517,-130,CELTICS (BOS),7029,9,19552,6,,18:30:00,Boston Celtics">-130</td><td id="45608_A5468517" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45608,5A,104.5,A5468517,-110,CELTICS (BOS),7029,12,19552,6,,18:30:00,Boston Celtics"><small class="text-primary"><b>A 104.5</b></small> -110</td><td id="45608_2468517" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45608,5RL,-0.5,2468517,-110,CELTICS (BOS),7029,10,19552,6,,18:30:00,Boston Celtics"><small class="text-primary"><b>-0.5</b></small> -110</td></tr><tr class="table-light"><td><div class="text-center font-weight-bold">468518</div></td><td>
    <div class="equipos"><img width="22px" height="22px" class="img-fluid" src="./Vendedorclon_files/UmPff6f5-Q9co7bFf.png"> RAPTORS (TOR)</div></td><td id="45609_468518" onmouseover="return changeCell(this)" onmouseout="return changeCellOut(this)" class="45609,ML, ,468518,100,RAPTORS (TOR),7030,5,19552,6,,18:30:00,Toronto Raptors">100</td><td id="45609_B468518" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45609,B,212,B468518,-110,RAPTORS (TOR),7030,8,19552,6,,18:30:00,Toronto Raptors"><small class="text-primary"><b>B 212</b></small> -110</td><td id="45609_1468518" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45609,RL,+1.5,1468518,-110,RAPTORS (TOR),7030,6,19552,6,,18:30:00,Toronto Raptors"><small class="text-primary"><b>+1.5</b></small> -110</td><td id="45609_5468518" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45609,5ML, ,5468518,100,RAPTORS (TOR),7030,13,19552,6,,18:30:00,Toronto Raptors">100</td><td id="45609_B5468518" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45609,5B,104.5,B5468518,-110,RAPTORS (TOR),7030,16,19552,6,,18:30:00,Toronto Raptors"><small class="text-primary"><b>B 104.5</b></small> -110</td><td id="45609_2468518" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45609,5RL,+0.5,2468518,-110,RAPTORS (TOR),7030,14,19552,6,,18:30:00,Toronto Raptors"><small class="text-primary"><b>+0.5</b></small> -110</td></tr><tr class="table-dark"><th><h6><small class="font-weight-bold">REF.</small></h6></th><th><h6><small class="font-weight-bold">07/09/2020 9:00 pm</small></h6></th><th><h6><small class="font-weight-bold">Ganar</small></h6></th><th><h6><small class="font-weight-bold">A/B</small></h6></th><th><h6><small class="font-weight-bold">Spread</small></h6></th><th><h6><small class="font-weight-bold">Ganar MJ</small></h6></th><th><h6><small class="font-weight-bold">A/B MJ</small></h6></th><th><h6><small class="font-weight-bold">Spread MJ</small></h6></th></tr><tr class="table-light"><td><div class="text-center font-weight-bold">468519</div></td><td>
    <div class="equipos"><img width="22px" height="22px" class="img-fluid" src="./Vendedorclon_files/QP7dfSXg-S8v7yq39.png"> CLIPPERS (LAC)</div></td><td id="45610_468519" onmouseover="return changeCell(this)" onmouseout="return changeCellOut(this)" class="45610,ML, ,468519,-435,CLIPPERS (LAC),7127,1,19553,6,,21:00:00,Los Angeles Clippers">-435</td><td id="45610_A468519" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45610,A,219.5,A468519,-110,CLIPPERS (LAC),7127,4,19553,6,,21:00:00,Los Angeles Clippers"><small class="text-primary"><b>A 219.5</b></small> -110</td><td id="45610_1468519" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45610,RL,-9,1468519,-110,CLIPPERS (LAC),7127,2,19553,6,,21:00:00,Los Angeles Clippers"><small class="text-primary"><b>-9</b></small> -110</td><td id="45610_5468519" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45610,5ML, ,5468519,-255,CLIPPERS (LAC),7127,9,19553,6,,21:00:00,Los Angeles Clippers">-255</td><td id="45610_A5468519" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45610,5A,113,A5468519,-110,CLIPPERS (LAC),7127,12,19553,6,,21:00:00,Los Angeles Clippers"><small class="text-primary"><b>A 113</b></small> -110</td><td id="45610_2468519" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45610,5RL,-5,2468519,-110,CLIPPERS (LAC),7127,10,19553,6,,21:00:00,Los Angeles Clippers"><small class="text-primary"><b>-5</b></small> -110</td></tr><tr class="table-light"><td><div class="text-center font-weight-bold">468520</div></td><td>
    <div class="equipos"><img width="22px" height="22px" class="img-fluid" src="./Vendedorclon_files/OnnMU0hl-ELSHsuFl.png"> NUGGETS (DEN)</div></td><td id="45611_468520" onmouseover="return changeCell(this)" onmouseout="return changeCellOut(this)" class="45611,ML, ,468520,335,NUGGETS (DEN),7032,5,19553,6,,21:00:00,Denver Nuggets">335</td><td id="45611_B468520" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45611,B,219.5,B468520,-110,NUGGETS (DEN),7032,8,19553,6,,21:00:00,Denver Nuggets"><small class="text-primary"><b>B 219.5</b></small> -110</td><td id="45611_1468520" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45611,RL,+9,1468520,-110,NUGGETS (DEN),7032,6,19553,6,,21:00:00,Denver Nuggets"><small class="text-primary"><b>+9</b></small> -110</td><td id="45611_5468520" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45611,5ML, ,5468520,205,NUGGETS (DEN),7032,13,19553,6,,21:00:00,Denver Nuggets">205</td><td id="45611_B5468520" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45611,5B,113,B5468520,-110,NUGGETS (DEN),7032,16,19553,6,,21:00:00,Denver Nuggets"><small class="text-primary"><b>B 113</b></small> -110</td><td id="45611_2468520" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45611,5RL,+5,2468520,-110,NUGGETS (DEN),7032,14,19553,6,,21:00:00,Denver Nuggets"><small class="text-primary"><b>+5</b></small> -110</td>        </tr></tbody>
    </table>
</div>                                </div>
                            </div>
                        </div>
                    </div>
                </div>

				

				

            </div>

                    </div>
    </div>
</span>
<!-- Pantalla mobil    -->
<span class="d-none d-md-inline d-lg-none d-sm-inline d-md-none d-inline d-sm-none justify-content-between">
            
<div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12" style="padding:5px">
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <?php if ($Baseball>0) {?>
		<a class="nav-item nav-link" id="nav-home-tab" data-toggle="tab" href="#nav-Beisbol-mobil" role="tab" aria-controls="nav-Beisbol-mobil" aria-selected="false"><div class="sportIcon sportIcon--baseball"></div>baseball</a>                
<?php }?>
		<?php if ($Basketball>0) {?>
		<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-Baloncesto-mobil" role="tab" aria-controls="nav-Baloncesto-mobil" aria-selected="false"><div class="sportIcon sportIcon--basketball"></div>basketball</a>                                
		<?php }?>
		</div>
</nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade" id="nav-Beisbol-mobil" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row"> 
                                <div class="col-lg-12 mb-4">
                                    <ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="https://wuao.site/taquilla_ticket" style="color:#000000;font-weight: 900;">
            <div class="sportIcon sportIcon--baseball"></div>Baseball
        </a>
    </li>
    <span class="ml-auto"><b>Balance:</b> <span class="badge badge-primary balance" id="balance">100.000,00</span></span></ol>
<div id="scrollj">
    <table class="table table-bordered table-sm">
        <tbody>
            <tr class="table-danger"><td colspan="12"><div class="equipos">MAJOR LEAGUE BASEBALL | </div></td></tr><tr class="table-dark">
            
			
			
            <th><h6><small class="font-weight-bold">07/09/2020 1:10 pm</small></h6></th>
            <th><h6><small class="font-weight-bold">Ganar</small></h6></th>
            <th><h6><small class="font-weight-bold">RL</small></h6></th>
            <th><h6><small class="font-weight-bold">SRL</small></h6></th>
            <th><h6><small class="font-weight-bold">A/B</small></h6></th>
            <th><h6><small class="font-weight-bold">½ Ganar</small></h6></th>
            <th><h6><small class="font-weight-bold">½ RL</small></h6></th>
            <th><h6><small class="font-weight-bold">½ A/B</small></h6></th>
            <th><h6><small class="font-weight-bold">S/N</small></h6></th>
            <th><h6><small class="font-weight-bold">V/H</small></h6></th>
            <th><h6><small class="font-weight-bold">HCE</small></h6></th>
            </tr><tr class="table-light"><td><img width="22px" height="22px" class="img-fluid" src="./Vendedorclon_files/riFAKCzS-OtgHPvkQ.png"> MARLINS (MIA)<p><small class="text-danger font-weight-bold">J URENA -R </small></p></td><td id="45684_468938" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45684,ML, ,468938,180,MARLINS (MIA),7027,1,19590,4,,13:10:00,">180</td><td id="45684_1468938" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45684,RL,1.5,1468938,-110,MARLINS (MIA),7027,2,19590,4,,13:10:00,"><small class="text-muted"><b>1.5</b></small> -110</td><td></td><td id="45684_A468938" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45684,A,9,A468938,-110,MARLINS (MIA),7027,4,19590,4,,13:10:00,"><small class="text-danger"><b>A 9</b></small> -110</td><td id="45684_5468938" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45684,5ML, ,5468938,180,MARLINS (MIA),7027,9,19590,4,,13:10:00,">180</td><td id="45684_2468938" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45684,5RL,0.5,2468938,125,MARLINS (MIA),7027,10,19590,4,,13:10:00,"><small class="text-danger"><b>0.5</b></small> 125</td><td id="45684_A5468938" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45684,5A,5,A5468938,-115,MARLINS (MIA),7027,12,19590,4,,13:10:00,"><small class="text-danger"><b>A 5</b></small> -115</td><td></td><td id="45684_7468938" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45684,AP, ,7468938,,MARLINS (MIA),7027,19,19590,4,,13:10:00,"></td><td></td></tr><tr></tr><tr class="table-light"><td><img width="22px" height="22px" class="img-fluid" src="./Vendedorclon_files/IPmhSoEa-6HCcbU5j.png"> Bravos de Atlanta<p><small class="text-danger font-weight-bold">I ANDERSON -R </small></p></td><td id="45685_468939" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45685,ML, ,468939,-230,Bravos de Atlanta,5265,5,19590,4,,13:10:00,Atlanta Braves">-230</td><td id="45685_1468939" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45685,RL,-1.5,1468939,-120,Bravos de Atlanta,5265,6,19590,4,,13:10:00,Atlanta Braves"><small class="text-muted"><b>-1.5</b></small> -120</td><td></td><td id="45685_B468939" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45685,B,9,B468939,-110,Bravos de Atlanta,5265,8,19590,4,,13:10:00,Atlanta Braves"><small class="text-danger"><b>B 9</b></small> -110</td><td id="45685_5468939" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45685,5ML, ,5468939,-210,Bravos de Atlanta,5265,13,19590,4,,13:10:00,Atlanta Braves">-210</td><td id="45685_2468939" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45685,5RL,-0.5,2468939,-145,Bravos de Atlanta,5265,14,19590,4,,13:10:00,Atlanta Braves"><small class="text-danger"><b>-0.5</b></small> -145</td><td id="45685_B5468939" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45685,5B,5,B5468939,-105,Bravos de Atlanta,5265,16,19590,4,,13:10:00,Atlanta Braves"><small class="text-danger"><b>B 5</b></small> -105</td><td></td><td id="45685_7468939" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45685,AP, ,7468939,,Bravos de Atlanta,5265,23,19590,4,,13:10:00,Atlanta Braves"></td><td></td></tr><tr></tr><tr class="table-dark">
            
			
			
			
            <th><h6><small class="font-weight-bold">07/09/2020 1:10 pm</small></h6></th>
            <th><h6><small class="font-weight-bold">Ganar</small></h6></th>
            <th><h6><small class="font-weight-bold">RL</small></h6></th>
            <th><h6><small class="font-weight-bold">SRL</small></h6></th>
            <th><h6><small class="font-weight-bold">A/B</small></h6></th>
            <th><h6><small class="font-weight-bold">½ Ganar</small></h6></th>
            <th><h6><small class="font-weight-bold">½ RL</small></h6></th>
            <th><h6><small class="font-weight-bold">½ A/B</small></h6></th>
            <th><h6><small class="font-weight-bold">S/N</small></h6></th>
            <th><h6><small class="font-weight-bold">V/H</small></h6></th>
            <th><h6><small class="font-weight-bold">HCE</small></h6></th>
            </tr><tr class="table-light"><td><img width="22px" height="22px" class="img-fluid" src="./Vendedorclon_files/AcX8PwzB-QHRR3jrT.png"> Filis de Filadelfia<p><small class="text-danger font-weight-bold">Z WHEELER -R </small></p></td><td id="45686_468940" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45686,ML, ,468940,-130,Filis de Filadelfia,5272,1,19591,4,,13:10:00,Philadelphia Phillies">-130</td><td id="45686_1468940" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45686,RL,-1.5,1468940,125,Filis de Filadelfia,5272,2,19591,4,,13:10:00,Philadelphia Phillies"><small class="text-muted"><b>-1.5</b></small> 125</td><td></td><td id="45686_A468940" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45686,A,9,A468940,-105,Filis de Filadelfia,5272,4,19591,4,,13:10:00,Philadelphia Phillies"><small class="text-danger"><b>A 9</b></small> -105</td><td id="45686_5468940" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45686,5ML, ,5468940,-135,Filis de Filadelfia,5272,9,19591,4,,13:10:00,Philadelphia Phillies">-135</td><td id="45686_2468940" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45686,5RL,-0.5,2468940,100,Filis de Filadelfia,5272,10,19591,4,,13:10:00,Philadelphia Phillies"><small class="text-danger"><b>-0.5</b></small> 100</td><td id="45686_A5468940" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45686,5A,5,A5468940,100,Filis de Filadelfia,5272,12,19591,4,,13:10:00,Philadelphia Phillies"><small class="text-danger"><b>A 5</b></small> 100</td><td></td><td id="45686_7468940" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45686,AP, ,7468940,,Filis de Filadelfia,5272,19,19591,4,,13:10:00,Philadelphia Phillies"></td><td></td></tr><tr></tr><tr class="table-light"><td><img width="22px" height="22px" class="img-fluid" src="./Vendedorclon_files/ID1PVAjl-S8v7yq39.png"> METS (NYM)<p><small class="text-danger font-weight-bold">D PETERSON -L </small></p></td><td id="45687_468941" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45687,ML, ,468941,110,METS (NYM),7028,5,19591,4,,13:10:00,">110</td><td id="45687_1468941" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45687,RL,1.5,1468941,-155,METS (NYM),7028,6,19591,4,,13:10:00,"><small class="text-muted"><b>1.5</b></small> -155</td><td></td><td id="45687_B468941" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45687,B,9,B468941,-115,METS (NYM),7028,8,19591,4,,13:10:00,"><small class="text-danger"><b>B 9</b></small> -115</td><td id="45687_5468941" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45687,5ML, ,5468941,115,METS (NYM),7028,13,19591,4,,13:10:00,">115</td><td id="45687_2468941" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45687,5RL,0.5,2468941,-120,METS (NYM),7028,14,19591,4,,13:10:00,"><small class="text-danger"><b>0.5</b></small> -120</td><td id="45687_B5468941" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45687,5B,5,B5468941,-120,METS (NYM),7028,16,19591,4,,13:10:00,"><small class="text-danger"><b>B 5</b></small> -120</td><td></td><td id="45687_7468941" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45687,AP, ,7468941,,METS (NYM),7028,23,19591,4,,13:10:00,"></td><td></td></tr><tr></tr><tr class="table-dark">
                  
    </table>
</div>                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="tab-pane fade" id="nav-Baloncesto-mobil" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="card">
                    <div class="card-body">
                        <div class="row"> 
                            <div class="col-lg-12 mb-4">
                                <ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="https://wuao.site/taquilla_ticket" style="color:#000000;font-weight: 900;">
            <div class="sportIcon sportIcon--basketball"></div>Basketball
        </a>
    </li>
    <span class="ml-auto"><b>Balance:</b> <span class="badge badge-primary balance" id="balance">100.000,00</span></span></ol>
<div class="scrollj_mobil">
    <div id="accordion">
        <div class="card"> <div class="card-header-mobil" id="headingOneNBA">
                    <h5 class="mb-0">
                    <button style="color:#000000;font-weight: 900;" class="btn btn-link" data-toggle="collapse" data-target="#collapseOneNBA" aria-expanded="true" aria-controls="collapseOneNBA">
                    <small>NBA </small>
                    </button>
                    </h5>
                    </div><div id="collapseOneNBA" class="collapse" aria-labelledby="headingOneNBA" data-parent="#accordion"><div class="card-body"><table class="table table-bordered table-sm"><thead></thead><tbody><tr class="tr-border-mobil"><td colspan="6"><div class="text-center"><img border="0" width="20" height="20" class="img-fluid" src="./Vendedorclon_files/2HLnhmZg-lIu3xPm3.png"> <span class="font-equipo"> <b>(V)</b> CELTICS (BOS)</span> <small class="font-weight-bold">vs</small> <img border="0" width="20" height="20" class="img-fluid" src="./Vendedorclon_files/UmPff6f5-Q9co7bFf.png"> <span class="font-equipo"> <b>(H)</b> RAPTORS (TOR)</span><br> <span class="badge badge-primary">07/09/2020 6:30 pm</span> </div></td></tr><tr class="table-dark"></tr><tr class="table-dark"><th><small class="font-weight-bold">Ganar</small></th><th><small class="font-weight-bold">A/B</small></th><th><small class="font-weight-bold">Spread</small></th><th><small class="font-weight-bold">Ganar MJ</small></th><th><small class="font-weight-bold">A/B MJ</small></th><th><small class="font-weight-bold">Spread MJ</small></th></tr><tr class="table-light"><td id="45608_468517" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45608,ML, ,468517,-130,CELTICS (BOS),7029,1,19552,6,,18:30:00,Boston Celtics"><div class="text-center"><span class="badge badge-pill badge-primary">Ganar <small class="font-weight-bold">(V)</small></span><small class="font-weight-bold"> <br><b>-130</b></small></div></td><td id="45608_A468517" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45608,A,212,A468517,-110,CELTICS (BOS),7029,4,19552,6,,18:30:00,Boston Celtics"><div class="text-center"><small class="text-primary"><b>A 212</b></small> <b>-110<b></b></b></div></td><td id="45608_1468517" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45608,RL,-1.5,1468517,-110,CELTICS (BOS),7029,2,19552,6,,18:30:00,Boston Celtics"><div class="text-center"><span class="badge badge-pill badge-primary">Spread <small class="font-weight-bold">(V)</small></span><small class="font-weight-bold"> <br><small class="text-primary"><b>-1.5</b></small> <b>-110<b></b></b></small></div></td><td id="45608_5468517" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45608,5ML, ,5468517,-130,CELTICS (BOS),7029,9,19552,6,,18:30:00,Boston Celtics"><div class="text-center"><b>-130</b></div></td><td id="45608_A5468517" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45608,5A,104.5,A5468517,-110,CELTICS (BOS),7029,12,19552,6,,18:30:00,Boston Celtics"><div class="text-center"><small class="text-primary"><b>A 104.5</b></small><b><br>-110</b></div></td><td id="45608_2468517" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45608,5RL,-0.5,2468517,-110,CELTICS (BOS),7029,10,19552,6,,18:30:00,Boston Celtics"><div class="text-center"><small class="text-primary"><b>-0.5</b></small><b><br>-110</b></div></td></tr><tr class="table-light"><td id="45609_468518" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45609,ML, ,468518,100,RAPTORS (TOR),7030,5,19552,6,,18:30:00,Toronto Raptors"><div class="text-center"><span class="badge badge-pill badge-primary">Ganar <small class="font-weight-bold">(H)</small></span><small class="font-weight-bold"> <br><b>100</b></small></div></td><td id="45609_B468518" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45609,B,212,B468518,-110,RAPTORS (TOR),7030,8,19552,6,,18:30:00,Toronto Raptors"><div class="text-center"><small class="text-primary"><b>B 212</b></small> <b>-110<b></b></b></div></td><td id="45609_1468518" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45609,RL,+1.5,1468518,-110,RAPTORS (TOR),7030,6,19552,6,,18:30:00,Toronto Raptors"><div class="text-center"><span class="badge badge-pill badge-primary">Spread <small class="font-weight-bold">(H)</small></span><small class="font-weight-bold"> <br><small class="text-primary"><b>+1.5</b></small> <b>-110<b></b></b></small></div></td><td id="45609_5468518" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45609,5ML, ,5468518,100,RAPTORS (TOR),7030,13,19552,6,,18:30:00,Toronto Raptors"><div class="text-center"><b>100</b></div></td><td id="45609_B5468518" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45609,5B,104.5,B5468518,-110,RAPTORS (TOR),7030,16,19552,6,,18:30:00,Toronto Raptors"><div class="text-center"><small class="text-primary"><b>B 104.5</b></small><b><br>-110</b></div></td><td id="45609_2468518" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45609,5RL,+0.5,2468518,-110,RAPTORS (TOR),7030,14,19552,6,,18:30:00,Toronto Raptors"><div class="text-center"><small class="text-primary"><b>+0.5</b></small><b><br>-110</b></div></td></tr><tr class="tr-border-mobil"><td colspan="6"><div class="text-center"><img border="0" width="20" height="20" class="img-fluid" src="./Vendedorclon_files/QP7dfSXg-S8v7yq39.png"> <span class="font-equipo"> <b>(V)</b> CLIPPERS (LAC)</span> <small class="font-weight-bold">vs</small> <img border="0" width="20" height="20" class="img-fluid" src="./Vendedorclon_files/OnnMU0hl-ELSHsuFl.png"> <span class="font-equipo"> <b>(H)</b> NUGGETS (DEN)</span><br> <span class="badge badge-primary">07/09/2020 9:00 pm</span> </div></td></tr><tr class="table-dark"></tr><tr class="table-dark"><th><small class="font-weight-bold">Ganar</small></th><th><small class="font-weight-bold">A/B</small></th><th><small class="font-weight-bold">Spread</small></th><th><small class="font-weight-bold">Ganar MJ</small></th><th><small class="font-weight-bold">A/B MJ</small></th><th><small class="font-weight-bold">Spread MJ</small></th></tr><tr class="table-light"><td id="45610_468519" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45610,ML, ,468519,-435,CLIPPERS (LAC),7127,1,19553,6,,21:00:00,Los Angeles Clippers"><div class="text-center"><span class="badge badge-pill badge-primary">Ganar <small class="font-weight-bold">(V)</small></span><small class="font-weight-bold"> <br><b>-435</b></small></div></td><td id="45610_A468519" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45610,A,219.5,A468519,-110,CLIPPERS (LAC),7127,4,19553,6,,21:00:00,Los Angeles Clippers"><div class="text-center"><small class="text-primary"><b>A 219.5</b></small> <b>-110<b></b></b></div></td><td id="45610_1468519" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45610,RL,-9,1468519,-110,CLIPPERS (LAC),7127,2,19553,6,,21:00:00,Los Angeles Clippers"><div class="text-center"><span class="badge badge-pill badge-primary">Spread <small class="font-weight-bold">(V)</small></span><small class="font-weight-bold"> <br><small class="text-primary"><b>-9</b></small> <b>-110<b></b></b></small></div></td><td id="45610_5468519" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45610,5ML, ,5468519,-255,CLIPPERS (LAC),7127,9,19553,6,,21:00:00,Los Angeles Clippers"><div class="text-center"><b>-255</b></div></td><td id="45610_A5468519" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45610,5A,113,A5468519,-110,CLIPPERS (LAC),7127,12,19553,6,,21:00:00,Los Angeles Clippers"><div class="text-center"><small class="text-primary"><b>A 113</b></small><b><br>-110</b></div></td><td id="45610_2468519" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45610,5RL,-5,2468519,-110,CLIPPERS (LAC),7127,10,19553,6,,21:00:00,Los Angeles Clippers"><div class="text-center"><small class="text-primary"><b>-5</b></small><b><br>-110</b></div></td></tr><tr class="table-light"><td id="45611_468520" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45611,ML, ,468520,335,NUGGETS (DEN),7032,5,19553,6,,21:00:00,Denver Nuggets"><div class="text-center"><span class="badge badge-pill badge-primary">Ganar <small class="font-weight-bold">(H)</small></span><small class="font-weight-bold"> <br><b>335</b></small></div></td><td id="45611_B468520" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45611,B,219.5,B468520,-110,NUGGETS (DEN),7032,8,19553,6,,21:00:00,Denver Nuggets"><div class="text-center"><small class="text-primary"><b>B 219.5</b></small> <b>-110<b></b></b></div></td><td id="45611_1468520" onmouseover="changeCell_mobil(this)" onmouseout="changeCellOut_mobil(this)" class="45611,RL,+9,1468520,-110,NUGGETS (DEN),7032,6,19553,6,,21:00:00,Denver Nuggets"><div class="text-center"><span class="badge badge-pill badge-primary">Spread <small class="font-weight-bold">(H)</small></span><small class="font-weight-bold"> <br><small class="text-primary"><b>+9</b></small> <b>-110<b></b></b></small></div></td><td id="45611_5468520" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45611,5ML, ,5468520,205,NUGGETS (DEN),7032,13,19553,6,,21:00:00,Denver Nuggets"><div class="text-center"><b>205</b></div></td><td id="45611_B5468520" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45611,5B,113,B5468520,-110,NUGGETS (DEN),7032,16,19553,6,,21:00:00,Denver Nuggets"><div class="text-center"><small class="text-primary"><b>B 113</b></small><b><br>-110</b></div></td><td id="45611_2468520" onmouseover="changeCell(this)" onmouseout="changeCellOut(this)" class="45611,5RL,+5,2468520,-110,NUGGETS (DEN),7032,14,19553,6,,21:00:00,Denver Nuggets"><div class="text-center"><small class="text-primary"><b>+5</b></small><b><br>-110</b></div></td></tr></tbody></table></div></div></div>    </div>
</div>                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
</div>
    </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Jugadas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
          <div id="scrollmobil">
            <div id="viewLogro"></div>
          </div>
      </div>
      <div class="modal-footer">
          <div id="row">
              <div class="col-lg-12 mb-4">
                  <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-secondary" id="btnjuegocompsoccer">Juego Completo</button>
                    <button type="button" class="btn btn-secondary" id="btnmediojuegosoccer">Medio Juego</button>
                </div>
            </div>
        </div>
          <div id="row">
              <div class="col-lg-12 mb-4">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                    <button type="button" class="btn btn-primary">Jugar</button>
                </div>
        </div>
      </div>
    </div>
  </div>
</div></span>

<div id="dialog-autoservicio" title="Auto Servicio"></div>
<div id="dialog-alerts" title="Información"></div>
<!--<div id="dialog-message" title="Detalle Ticket">
  <span id="det_ticket"></span>
</div>>-->
<!--<div id="DialogoAjax" title="Por favor espere"><img src="https://wuao.site/include/img/pageloading3.gif" alt="Cargando" ></div>	-->

<!-- Modal -->
<div class="modal" id="modalTicket" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div>
                <div class="col-lg-12 mt-4 mb-3">
                    <div class="card">
                        <div class="card-header">
                            Detalle Ticket
                        </div>
                        <div class="card-body">
                            <div style="display:none" class="zona_impresion info hide" id="zona_impresion"></div>
                            <div class="panel panel-default" id="detalleTickets">
                                <div class="bg-gray disabled color-palette text-center info hide" id="info2"></div>
                                <textarea class="form-control" rows="10" id="informacion_ticket" readonly=""></textarea>
                            </div>
                            <button type="button" class="btn btn-md sbold btn-danger col-sm-12" id="btnImprimir">
                                <i class="fa fa-print"></i>
                                <span>Imprimir Contenido (I)</span>
                            </button>
                            <button type="button" class="btn btn-md sbold btn-primary col-sm-12" id="copy_clipboard">
                                <i class="fa fa-copy"></i>
                                <span>Copiar Contenido</span>
                            </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Seguir Jugando</button>
                            <small id="emailHelp" class="form-text text-muted">
                                Puede Copiar el Contenido del Ticket y enviar por:
                                <a id="btnwhatsapp" href="https://web.whatsapp.com/" style="text-decoration:none;" target="_blank" title="whatsapp WEB" class="tooltips">
                                    <i class="fa fa-whatsapp"></i>&nbsp;WhatApp
                                </a>
                                &nbsp;
                                <!--
    <a 
                                href="https://web.telegram.org" 
                                style="text-decoration:none;"
                                target="_blank"
                                title="Telegram" 
                                class="tooltips" 
                                >
                                <i class="fa fa-send"></i>&nbsp;Telegram
                                </a>
                                , etc.-->
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModalAuto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">TICKET AUTO SERVICIO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="detalleAutoservicio">
                Cargando.....
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">DETALLE TICKET</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="dialog-message">
                Cargando.....
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal_mobil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fonth" id="exampleModalLabel">DETALLE TICKET</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="dialog-message-mobil">
                <textarea class="form-control fonth" id="detalleticketmobil" rows="5"></textarea>
                <!--<h5 class="modal-title fonth1" id="exampleModalLabel"><b>Monto Apuesta:</b> <span id="montojugadomobil"></span> <small>Bs.</small></h5>
        <h5 class="modal-title fonth1" id="exampleModalLabel"><b>Monto Premio:</b> <span id="montopremiomobil"></span> <small>Bs.</small></h5>-->
                <table class="table table-borderless table-sm">
                    <tbody><tr>
                        <td>
                            <label><small class="font-weight-bold">Monto de la Apuesta:</small></label>
                            <input type="number" placeholder="Monto Apuesta" id="montoApostar_mobil" name="montoApostar_mobil" required="" class="form-control form-control-sm" maxlength="10" autocomplete="OFF" onkeyup="premio_mobil(event,this)">
                        </td>
                        <td>
                            <label><small class="font-weight-bold">Monto del Premio:</small></label>
                            <input disabled="" type="number" placeholder="Monto Premio" id="montoPremio_mobil" name="montoPremio_mobil" class="form-control form-control-sm form-input-premio" autofocus="">
                        </td>
                    </tr>
                </tbody></table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal"><i class="fa fa-exchange" aria-hidden="true"></i> Seguir Jugando</button>
                <button type="button" id="btnregistrarjugadamovil" class="btn btn-warning btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Registrar Jugadas</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal_mobil1" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fonth" id="exampleModalScrollableTitle"> Ticket Jugados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="tablaTicketjugados"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>    </div>
    <!-- /.container -->
    <!-- Footer -->
    <!--<footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2018</p>
      </div>
      <!-- /.container -->
    <!--</footer>
    <!-- Bootstrap core JavaScript 
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    -->


    <script src="./Vendedorclon_files/jquery.min.js.descarga"></script>

    <!-- jQuery Validation Plugin -->
    <script src="./Vendedorclon_files/jquery.validate.min.js.descarga"></script>
    <script src="./Vendedorclon_files/additional-methods.min.js.descarga"></script>

    <script src="./Vendedorclon_files/popper.min.js.descarga"></script>
    <script src="./Vendedorclon_files/bootstrap.min.js.descarga" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="./Vendedorclon_files/bootstrap-datepicker.js.descarga"></script>
    <script src="./Vendedorclon_files/bootstrap-datepicker.es.min.js.descarga"></script>

    <script src="./Vendedorclon_files/jquery.dataTables.min.js.descarga"></script>
    <script src="./Vendedorclon_files/dataTables.bootstrap4.min.js.descarga"></script>
    <!-- toastr code -->
    <script src="./Vendedorclon_files/toastr.min.js.descarga"></script>
    <!-- bootbox code -->
    <script src="./Vendedorclon_files/bootbox.min.js.descarga"></script>
    <script src="./Vendedorclon_files/popper.min.js(1).descarga"></script>
    <!-- sweetalert2 code -->
    <script src="./Vendedorclon_files/sweetalert2@9"></script>



                            <script src="./Vendedorclon_files/taquilla.js.descarga2"></script>
        <script src="./Vendedorclon_files/taqmobil.js.descarga"></script>
        <script src="./Vendedorclon_files/validaciones.js.descarga"></script>




<script type="text/javascript">
    var reglasPago = [{'rangoIni':'0.00','rangoFin':'0.00','multiplo':'0','montoMaximo':'0.00'}];
    var com_bax = 10;
    var comb_min = 1;
    var cupo_derc_gr = 0;
    var cupo_parl_gr = 0;
    var cupo_derc_ve = 0;
    var cupo_parl_ve = 0;
    var sum_cupo_derc_gr = 0;
    var sum_cupo_parl_gr = 0;
    var sum_cupo_derc_ve = 0;
    var sum_cupo_parl_ve = 0;
    var imprime = "N";
    var tipot = "C";
    var comb_max = 10;
    var monto_premio = 10000000.00;
    console.log(monto_premio);
    var jugada_minima = 0.00;
    var jugada_minima_ve = 10000.00;
    var jugada_maxima_ve = 0;
    var comb_hembra = 3;
    var fact_mult_hem = 100;
    var fact_mult_mac = 100;

    var error_futbol = "1-2,1-5,1-6,2-5,2-6,4-8,5-6,13-9,13-14,13-10,10-14,12-16,10-9,10-1,10-5,1-9,1-13,1-14,2-9,2-13,2-10,2-14,2-12,25-1,25-5,25-2,25-6,25-9,25-10,25-13,25-12,25-16,25-14,25-26,26-1,26-5,26-2,26-6,26-4,26-8,26-9,26-10,26-13,26-14,5-9,5-13,5-12,5-16,5-14,1-12,1-16,6-9,10-6,6-14,6-12,6-16,6-13,2-16,4-13,4-9,4-10,4-14,4-12,4-16,8-13,8-9,8-10,8-14,8-12,8-16,2-4,2-8,6-4,6-8,10-12,10-16,14-12,14-16";
    var error_nhl = "1-2,1-5,1-6,1-25,2-4,2-5,2-6,2-8,2-25,4-6,4-8,5-6,5-25,6-8,6-25,8-25";
    var error_nfl = "1-2,1-5,1-6,1-25,2-4,2-5,2-6,2-8,2-25,4-6,4-8,5-6,5-25,6-8,6-25,8-25";
    var error_basket = "1-2,1-5,1-6,2-5,2-6,4-8,5-6,13-9,13-14,13-10,10-14,12-16,10-9,10-1,10-5,1-9,1-13,1-14,2-9,2-13,2-10,2-14,2-12,25-1,25-5,25-2,25-6,25-9,25-10,25-13,25-14,26-1,26-5,26-2,26-6,26-9,26-10,26-13,26-14,5-9,5-13,5-12,5-16,5-14,1-12,1-16,6-9,10-6,6-14,6-12,6-16,6-13,2-16,4-13,4-9,4-10,4-14,4-12,4-16,8-13,8-9,8-10,8-14,8-12,8-16";
    var error_beisbol = "1-2,1-3,1-5,1-6,1-7,1-9,1-10,1-13,1-14,1-19,2-3,2-5,2-6,2-7,2-9,2-10,2-13,2-14,2-19,3-4,3-5,3-6,3-7,3-8,3-9,3-10,3-13,3-14,3-19,4-7,4-8,4-12,4-16,4-20,5-6,5-7,5-9,5-10,5-13,5-14,5-23,6-7,6-9,6-10,6-13,6-14,6-23,7-9,7-10,7-13,7-14,7-23,8-12,8-16,8-24,9-10,9-13,9-14,9-19,10-13,10-14,10-19,12-16,12-17,12-20,13-14,13-23,14-23,16-21,16-24,17-21,19-23,4-20,8-20,12-20,16-20,17-20,20-24,4-24,8-24,12-24,16-24,17-24,30-32,30-31,30-32,32-33,32-31,33-31,30-20,30-24,32-24,33-24,31-24,31-20,33-20,32-20,21-24";
    var error_otros = "1-2,1-5,1-6,1-25,2-4,2-5,2-6,2-8,2-25,4-6,4-8,5-6,5-25,6-8,6-25,8-25";
    var error_esports = "1-2,1-5,1-6,2-5,2-6,4-8,5-6";
    var pago_macuare = 0.00;
    var tope_macuare = 0.00;
    var tope_venta = 0.00;
    var jdmin_macuare = 0.00;
    var acreditacion = 100000.00;
    var tipo_taquilla = "C";
    var puerto_imp = '';
    var tipo_impresion = 'N';
    var cupoDvend = 0.00;
    var factor_pago = 0.00;
    var factor_pago_c1 = 0;
    var factor_pago_c2 = 0;
    var factor_pago_c3 = 0;
    var factor_pago_c4 = 0;
    var factor_pago_c5 = 0;
    var factor_pago_c6 = 0;
    var factor_pago_c7 = 0;
    var factor_pago_c8 = 0;
    var mxtcrep = "5";
    var mxhemper = "N";
    var mxmachper = "N";
    var mxcombft = "N";
    var mxcombbs = "N";
    var mxcombbk = "N";
    var mxcombotr = "N";
    var jgxder = "N";
    var mxaltafut = "0";
    var solo_macuare = 'N';
</script></body></html>