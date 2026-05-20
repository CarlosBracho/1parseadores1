<?php
// 
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
if (!isset($_SESSION)) {
    session_start();
} require_once('Connections/conexionbanca.php');
$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
    $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}
function hActual()
{
    date_default_timezone_set("Pacific/Honolulu") ;
    $hora = getdate(time());
    $xhora = $hora["hours"];
    $xminuto = $hora["minutes"];
    $xsegundo = $hora["seconds"];
    $diaSeman = $hora['wday'];
    if ($hora["hours"] < 10) {
        $xhora = "0".$hora["hours"];
    }
    if ($hora["minutes"] < 10) {
        $xminuto = "0".$hora["minutes"];
    }
    if ($hora["seconds"] < 10) {
        $xsegundo = "0".$hora["seconds"];
    }
    $xhoraTxt[0]=$xhora.":".$xminuto.":".$xsegundo;
    $xhoraTxt[1]=$diaSeman;
    return $xhoraTxt;
}
$mensaje="&nbsp;";
include "./includes/mcript.php";






if (isset($_COOKIE['COOKIE_INDEFINED_SESSION'])) {

    $tipousuario=$_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['rtyugnhdfg'];



if ($desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['rtyugnhdfg'])=="U") {
    if (isset($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['ewrertert'])) {
    $_SESSION['ZonaHorario'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['ewrertert']); //ewrertert
    }else{ $_SESSION['ZonaHorario'] =$_SESSION['ZonaHorario'];}
    $_SESSION['MM_Username'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['456jtyhjty6']); //456jtyhjty6
    $_SESSION['MM_UserGroup'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['rtyjrtyj']); //rtyjrtyj
    $_SESSION['MM_id_usuario'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['sdfgsdfgsdf']); //sdfgsdfgsdf
    $_SESSION['MM_cod_taquilla'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['xcvbxcvbxc']); //xcvbxcvbxc
    $_SESSION['MM_nom_usuario'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['uopiopuiopuio']); //uopiopuiopuio
    $_SESSION['MM_mensaje2'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['gfhjfghjfghj']); //gfhjfghjfghj
    $_SESSION['MM_mensaje3'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['345wtwert']); //345wtwert
    $_SESSION['MM_Password'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['qwesfafgqg']); //qwesfafgqg








    $diasAcceso = explode("-", "1");
    $_SESSION['selCarrera']=$desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['poisdpfsdp']); //poisdpfsdp
    if (isset($_SESSION['PrevUrl']) && false) {
        $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
    }
    $MM_redirectLoginSuccess = "";
    $h=hActual();
    $horActual=$h[0];
    $d=$h[1];
    //if ($row_LoginRS["hor_inicio"]<=$horActual && $row_LoginRS["hor_fin"]>=$horActual && $diasAcceso[$d]==1) {
    $MM_redirectLoginSuccess = "acceso.php";
    header("Location: ". $MM_redirectLoginSuccess);
    //} else $mensaje='ACCESO DENEGADO!';
}
if ($desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['rtyugnhdfg'])=="A") {
    
    if (isset($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['ewrertert'])) {
        $_SESSION['ZonaHorario'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['ewrertert']); //ewrertert
        }else{ $_SESSION['ZonaHorario'] =$_SESSION['ZonaHorario'];}
    $_SESSION['MM_Username'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['456jtyhjty6']); //456jtyhjty6
    $_SESSION['MM_UserGroup'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['rtyjrtyj']); //rtyjrtyj
    $_SESSION['MM_id_usuario'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['sdfgsdfgsdf']); //sdfgsdfgsdf
    $_SESSION['MM_nom_usuario'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['uopiopuiopuio']); //uopiopuiopuio
    $_SESSION['selCarrera']= $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['poisdpfsdp']); //poisdpfsdp
    $_SESSION['acceso']=$desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['989dsfsdf']); //989dsfsdf
    if (isset($_SESSION['PrevUrl']) && false) {
        $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
    }
    $MM_redirectLoginSuccess = "admin/index.php";
    $_SESSION['username'] = "Soporte"; //uiooui3id







    header("Location: ". $MM_redirectLoginSuccess);
}
if ($desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['rtyugnhdfg'])=="G") {
    if (isset($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['ewrertert'])) {
        $_SESSION['ZonaHorario'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['ewrertert']); //ewrertert
        }else{ $_SESSION['ZonaHorario'] =$_SESSION['ZonaHorario'];}
    $_SESSION['MM_Username'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['456jtyhjty6']); //456jtyhjty6
    $_SESSION['MM_UserGroup'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['rtyjrtyj']); //rtyjrtyj
    $_SESSION['acceso']=$desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['989dsfsdf']); //989dsfsdf
    $_SESSION['MM_id_usuario'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['sdfgsdfgsdf']); //sdfgsdfgsdf
    $_SESSION['MM_nom_usuario'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['uopiopuiopuio']); //uopiopuiopuio
    if (isset($_SESSION['PrevUrl']) && false) {
        $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
    }







    $MM_redirectLoginSuccess = "agente/index.php";
    header("Location: ". $MM_redirectLoginSuccess);
}
if ($desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['rtyugnhdfg'])=="D") {
    if (isset($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['ewrertert'])) {
        $_SESSION['ZonaHorario'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['ewrertert']); //ewrertert
        }else{ $_SESSION['ZonaHorario'] =$_SESSION['ZonaHorario'];}
    $_SESSION['MM_Username'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['456jtyhjty6']); //456jtyhjty6
    $_SESSION['MM_UserGroup'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['rtyjrtyj']); //rtyjrtyj
    $_SESSION['acceso']=$desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['989dsfsdf']); //989dsfsdf
    $_SESSION['MM_id_usuario'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['sdfgsdfgsdf']); //sdfgsdfgsdf
    $_SESSION['MM_nom_usuario'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['uopiopuiopuio']); //uopiopuiopuio
    if (isset($_SESSION['PrevUrl']) && false) {
        $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
    }








    $MM_redirectLoginSuccess = "distri/index.php";
    header("Location: ". $MM_redirectLoginSuccess);
}
if ($desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['rtyugnhdfg'])=="C") {
    if (isset($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['ewrertert'])) {
        $_SESSION['ZonaHorario'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['ewrertert']); //ewrertert
        }else{ $_SESSION['ZonaHorario'] =$_SESSION['ZonaHorario'];}
    $_SESSION['MM_Username'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['456jtyhjty6']); //456jtyhjty6
    $_SESSION['MM_UserGroup'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['rtyjrtyj']); //rtyjrtyj
    $_SESSION['MM_id_usuario'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['sdfgsdfgsdf']); //sdfgsdfgsdf
    $_SESSION['MM_nom_usuario'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['uopiopuiopuio']); //uopiopuiopuio
    $_SESSION['selCarrera']=$desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['poisdpfsdp']); //poisdpfsdp
    $_SESSION['acceso']=$desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['989dsfsdf']); //989dsfsdf
    if (isset($_SESSION['PrevUrl']) && false) {
        $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
    }









    $MM_redirectLoginSuccess = "apostador/internacionalesa.php";
    header("Location: ". $MM_redirectLoginSuccess);
}
if ($desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['rtyugnhdfg'])=="S") {
    if (isset($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['ewrertert'])) {
        $_SESSION['ZonaHorario'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['ewrertert']); //ewrertert
        }else{ $_SESSION['ZonaHorario'] =$_SESSION['ZonaHorario'];}
    $_SESSION['MM_Username'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['456jtyhjty6']); //456jtyhjty6
    $_SESSION['MM_UserGroup'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['rtyjrtyj']); //rtyjrtyj
    $_SESSION['MM_id_usuario'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['sdfgsdfgsdf']); //sdfgsdfgsdf
    $_SESSION['MM_nom_usuario'] = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['uopiopuiopuio']); //uopiopuiopuio
    $_SESSION['selCarrera']=$desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['poisdpfsdp']); //poisdpfsdp
    $_SESSION['acceso']=$desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['989dsfsdf']); //989dsfsdf
    if (isset($_SESSION['PrevUrl']) && false) {
        $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
    }




    $MM_redirectLoginSuccess = "multidistri/index.php";
    header("Location: ". $MM_redirectLoginSuccess);
}

}
if (isset($_POST['usuario'])) {
    $loginUsername=$_POST['usuario'];
    $password=$_POST['password'];
    $MM_fldUserAuthorization = "tip_usuario";
    $MM_redirecttoReferrer = false;
    $LoginRS__query=sprintf(
        "/* PARSEADORES1 index.php - QUERY 1 */ SELECT id_usuario, nom_usuario, pas_usuario, tip_usuario, est_usuario, hor_inicio, 		
  	hor_fin, cod_taquilla, dia_entrada, niv_acceso, ZonaHorario
  	FROM usuario 
	WHERE nom_usuario=%s AND pas_usuario=%s LIMIT 1",
        GetSQLValueString($loginUsername, "text"),
        GetSQLValueString($password, "text")
    );
    $LoginRS = mysqli_query($conexionbanca, $LoginRS__query) or die(mysqli_error($conexionbanca));
    $row_LoginRS = mysqli_fetch_assoc($LoginRS);
    $loginFoundUser = mysqli_num_rows($LoginRS);
    if ($loginFoundUser) {
        $loginStrGroup = mysqli_result($LoginRS, 0, 'tip_usuario');
        if ($row_LoginRS["est_usuario"]==0) {
            $_SESSION['MM_systemE']=3;
            $MM_redirectLoginSuccess = "no_acceso_usuario.php";
            echo "<h1>Acceso denegado</h1>. Usuario desactivado";
            exit;
        //header("Location: ". $MM_redirectLoginSuccess );
        } else {







            if ($row_LoginRS["tip_usuario"]=="U") { //rtyugnhdfg
                $_SESSION['ZonaHorario'] = $row_LoginRS["ZonaHorario"];
                $_SESSION['MM_Username'] = $loginUsername; //456jtyhjty6
                $_SESSION['MM_UserGroup'] = $loginStrGroup; //rtyjrtyj
                $_SESSION['MM_id_usuario'] = $row_LoginRS["id_usuario"]; //sdfgsdfgsdf
                $_SESSION['MM_cod_taquilla'] = $row_LoginRS["cod_taquilla"]; //xcvbxcvbxc
                $_SESSION['MM_nom_usuario'] = $row_LoginRS["nom_usuario"]; //uopiopuiopuio
                $_SESSION['MM_mensaje2'] = "LE DAREMOS RESPUESTA EN EL MENOR TIEMPO POSIBLE"; //gfhjfghjfghj
                $_SESSION['MM_mensaje3'] = ""; //345wtwert

                if (!empty($_POST["mantener_sesion_abierta"])) {
                    setcookie("COOKIE_INDEFINED_SESSION", TRUE, time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[rtyugnhdfg]", $encriptar($row_LoginRS["tip_usuario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[456jtyhjty6]", $encriptar($loginUsername), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[rtyjrtyj]", $encriptar($loginStrGroup), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[sdfgsdfgsdf]", $encriptar($row_LoginRS["id_usuario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[xcvbxcvbxc]", $encriptar($row_LoginRS["cod_taquilla"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[uopiopuiopuio]", $encriptar($row_LoginRS["nom_usuario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[gfhjfghjfghj]", $encriptar("LE DAREMOS RESPUESTA EN EL MENOR TIEMPO POSIBLE"), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[345wtwert]", $encriptar(""), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[poisdpfsdp]", $encriptar("-1"), time()+31622400);
                
                }







                $diasAcceso = explode("-", $row_LoginRS["dia_entrada"]);
                $_SESSION['selCarrera']=-1; //poisdpfsdp
                if (isset($_SESSION['PrevUrl']) && false) {
                    $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
                }
                $MM_redirectLoginSuccess = "";
                $h=hActual();
                $horActual=$h[0];
                $d=$h[1];
                //if ($row_LoginRS["hor_inicio"]<=$horActual && $row_LoginRS["hor_fin"]>=$horActual && $diasAcceso[$d]==1) {
                $MM_redirectLoginSuccess = "acceso.php";
                header("Location: ". $MM_redirectLoginSuccess);
                //} else $mensaje='ACCESO DENEGADO!';
            }
            if ($row_LoginRS["tip_usuario"]=="A") { //rtyugnhdfg
                $_SESSION['ZonaHorario'] = $row_LoginRS["ZonaHorario"];//ewrertert
                $_SESSION['MM_Username'] = $loginUsername; //456jtyhjty6
                $_SESSION['MM_UserGroup'] = $loginStrGroup; //rtyjrtyj
                $_SESSION['MM_id_usuario'] = $row_LoginRS["id_usuario"]; //sdfgsdfgsdf
                $_SESSION['MM_nom_usuario'] = $row_LoginRS["nom_usuario"]; //uopiopuiopuio
                $_SESSION['selCarrera']=-1; //poisdpfsdp
                $_SESSION['acceso']=$row_LoginRS["niv_acceso"]; //989dsfsdf
                if (isset($_SESSION['PrevUrl']) && false) {
                    $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
                }
                $MM_redirectLoginSuccess = "admin/index.php";
                $_SESSION['username'] = "Soporte"; //uiooui3id

                if (!empty($_POST["mantener_sesion_abierta"])) {
                    setcookie("COOKIE_INDEFINED_SESSION", TRUE, time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[ewrertert]", $encriptar($row_LoginRS["ZonaHorario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[rtyugnhdfg]", $encriptar($row_LoginRS["tip_usuario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[456jtyhjty6]", $encriptar($loginUsername), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[rtyjrtyj]", $encriptar($loginStrGroup), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[sdfgsdfgsdf]", $encriptar($row_LoginRS["id_usuario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[uopiopuiopuio]", $encriptar($row_LoginRS["nom_usuario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[gfhjfghjfghj]", $encriptar("LE DAREMOS RESPUESTA EN EL MENOR TIEMPO POSIBLE"), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[345wtwert]", $encriptar(""), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[poisdpfsdp]", $encriptar("-1"), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[989dsfsdf]", $encriptar($row_LoginRS["niv_acceso"]), time()+31622400);
                }





                header("Location: ". $MM_redirectLoginSuccess);
            }
            if ($row_LoginRS["tip_usuario"]=="G") { //rtyugnhdfg
                $_SESSION['ZonaHorario'] = $row_LoginRS["ZonaHorario"];//ewrertert
                $_SESSION['MM_Username'] = $loginUsername; //456jtyhjty6
                $_SESSION['MM_UserGroup'] = $loginStrGroup; //rtyjrtyj
                $_SESSION['acceso']=$row_LoginRS["niv_acceso"]; //989dsfsdf
                $_SESSION['MM_id_usuario'] = $row_LoginRS["id_usuario"]; //sdfgsdfgsdf
                $_SESSION['MM_nom_usuario'] = $row_LoginRS["nom_usuario"]; //uopiopuiopuio
                if (isset($_SESSION['PrevUrl']) && false) {
                    $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
                }




                if (!empty($_POST["mantener_sesion_abierta"])) {
                    setcookie("COOKIE_INDEFINED_SESSION", TRUE, time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[ewrertert]", $encriptar($row_LoginRS["ZonaHorario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[rtyugnhdfg]", $encriptar($row_LoginRS["tip_usuario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[456jtyhjty6]", $encriptar($loginUsername), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[rtyjrtyj]", $encriptar($loginStrGroup), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[sdfgsdfgsdf]", $encriptar($row_LoginRS["id_usuario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[uopiopuiopuio]", $encriptar($row_LoginRS["nom_usuario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[989dsfsdf]", $encriptar($row_LoginRS["niv_acceso"]), time()+31622400);
                }





                $MM_redirectLoginSuccess = "agente/index.php";
                header("Location: ". $MM_redirectLoginSuccess);
            }
            if ($row_LoginRS["tip_usuario"]=="D") { //rtyugnhdfg
                $_SESSION['ZonaHorario'] = $row_LoginRS["ZonaHorario"];//ewrertert
                $_SESSION['MM_Username'] = $loginUsername; //456jtyhjty6
                $_SESSION['MM_UserGroup'] = $loginStrGroup; //rtyjrtyj
                $_SESSION['acceso']=$row_LoginRS["niv_acceso"]; //989dsfsdf
                $_SESSION['MM_id_usuario'] = $row_LoginRS["id_usuario"]; //sdfgsdfgsdf
                $_SESSION['MM_nom_usuario'] = $row_LoginRS["nom_usuario"]; //uopiopuiopuio
                if (isset($_SESSION['PrevUrl']) && false) {
                    $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
                }

                if (!empty($_POST["mantener_sesion_abierta"])) {
                    setcookie("COOKIE_INDEFINED_SESSION", TRUE, time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[ewrertert]", $encriptar($row_LoginRS["ZonaHorario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[rtyugnhdfg]", $encriptar($row_LoginRS["tip_usuario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[456jtyhjty6]", $encriptar($loginUsername), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[rtyjrtyj]", $encriptar($loginStrGroup), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[sdfgsdfgsdf]", $encriptar($row_LoginRS["id_usuario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[uopiopuiopuio]", $encriptar($row_LoginRS["nom_usuario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[989dsfsdf]", $encriptar($row_LoginRS["niv_acceso"]), time()+31622400);
                }






                $MM_redirectLoginSuccess = "distri/index.php";
                header("Location: ". $MM_redirectLoginSuccess);
            }
            if ($row_LoginRS["tip_usuario"]=="C") { //rtyugnhdfg
                $_SESSION['ZonaHorario'] = $row_LoginRS["ZonaHorario"];//ewrertert
                $_SESSION['MM_Username'] = $loginUsername; //456jtyhjty6
                $_SESSION['MM_UserGroup'] = $loginStrGroup; //rtyjrtyj
                $_SESSION['MM_id_usuario'] = $row_LoginRS["id_usuario"]; //sdfgsdfgsdf
                $_SESSION['MM_nom_usuario'] = $row_LoginRS["nom_usuario"]; //uopiopuiopuio
                $_SESSION['selCarrera']=-1; //poisdpfsdp
                $_SESSION['acceso']=$row_LoginRS["niv_acceso"]; //989dsfsdf
                if (isset($_SESSION['PrevUrl']) && false) {
                    $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
                }


                if (!empty($_POST["mantener_sesion_abierta"])) {
                    setcookie("COOKIE_INDEFINED_SESSION", TRUE, time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[ewrertert]", $encriptar($row_LoginRS["ZonaHorario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[rtyugnhdfg]", $encriptar($row_LoginRS["tip_usuario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[456jtyhjty6]", $encriptar($loginUsername), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[rtyjrtyj]", $encriptar($loginStrGroup), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[sdfgsdfgsdf]", $encriptar($row_LoginRS["id_usuario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[uopiopuiopuio]", $encriptar($row_LoginRS["nom_usuario"]), time()+31622400);

                    setcookie("COOKIE_DATA_INDEFINED_SESSION[poisdpfsdp]", $encriptar("-1"), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[989dsfsdf]", $encriptar($row_LoginRS["niv_acceso"]), time()+31622400);
                }






                $MM_redirectLoginSuccess = "apostador/internacionalesa.php";
                header("Location: ". $MM_redirectLoginSuccess);
            }
            if ($row_LoginRS["tip_usuario"]=="S") { //rtyugnhdfg
                $_SESSION['ZonaHorario'] = $row_LoginRS["ZonaHorario"];//ewrertert
                $_SESSION['MM_Username'] = $loginUsername; //456jtyhjty6
                $_SESSION['MM_UserGroup'] = $loginStrGroup; //rtyjrtyj
                $_SESSION['MM_id_usuario'] = $row_LoginRS["id_usuario"]; //sdfgsdfgsdf
                $_SESSION['MM_nom_usuario'] = $row_LoginRS["nom_usuario"]; //uopiopuiopuio
                $_SESSION['selCarrera']=-1; //poisdpfsdp
                $_SESSION['acceso']=$row_LoginRS["niv_acceso"]; //989dsfsdf
                if (isset($_SESSION['PrevUrl']) && false) {
                    $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
                }

                if (!empty($_POST["mantener_sesion_abierta"])) {
                    setcookie("COOKIE_INDEFINED_SESSION", TRUE, time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[ewrertert]", $encriptar($row_LoginRS["ZonaHorario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[rtyugnhdfg]", $encriptar($row_LoginRS["tip_usuario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[456jtyhjty6]", $encriptar($loginUsername), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[rtyjrtyj]", $encriptar($loginStrGroup), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[sdfgsdfgsdf]", $encriptar($row_LoginRS["id_usuario"]), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[uopiopuiopuio]", $encriptar($row_LoginRS["nom_usuario"]), time()+31622400);

                    setcookie("COOKIE_DATA_INDEFINED_SESSION[poisdpfsdp]", $encriptar("-1"), time()+31622400);
                    setcookie("COOKIE_DATA_INDEFINED_SESSION[989dsfsdf]", $encriptar($row_LoginRS["niv_acceso"]), time()+31622400);
                }






                $MM_redirectLoginSuccess = "multidistri/index.php";
                header("Location: ". $MM_redirectLoginSuccess);
            }














        }
    } else {
        if ($loginUsername=$_POST['usuario']!="") {
            $mensaje='Nombre de usuario o clave invalida!';
        }
    }
}
$info=detect2();
if (isset($info["version"])) {
} else {
    $info["version"]=11;
}
if ($info["version"]<=9 & $info["browser"]=='IE') {
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="description" content="americanas nacionales online sistema online de alquiler para ventas deportivas hipicas">
<meta name="keywords" content="americanassistema online, sistema nacioanles, sistema online de alquiler para ventas deportivas hipicas">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="images/favicon.ico">
<title>Apuestas Hipicas 2018</title>
<style type="text/css">body {font-family: Verdana, Geneva, sans-serif;color:#FFF;font-size:15px;font-weight:bold;background-color:#000;margin-left:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;}</style>
</head>
<body>
<CENTER>
<tr><td align="center">
	<h1 id="home-header" class="text-center">Apuestas Hipicas<span id="cloud-hosting-for" class="animated"></span></h1>
								<p id="high-performance" class="lead text-center">Sistema Online</p>
</td></tr>
<table width="800" height="578" border="0">


    <td width="309" rowspan="2" align="right" bgcolor="#000000"><img src="images/header.png" width="309" height="55"  alt="Apuestas Hipicas" />      </td>
    <td height="27" align="right" bgcolor="#000000" style="color: #C00"><?php echo $mensaje; ?></td>
  </tr>
  <tr>
   <td width="481"height="28"align="right"bgcolor="#000000"style="font-size:12px;font-family:'Trebuchet MS',Arial,Helvetica,sans-serif">
    <form id="inicio" name="inicio" method="POST" action="<?php echo $loginFormAction; ?>">
      <label for="usuario">Usuario:</label>
      <input type="text" name="usuario" id="usuario" style="height:18px;width:120px" />
      <label for="password">Clave:</label>
      <input type="password" name="password" id="password" style="height:18px;width:120px"/>
      <input type="submit" name="button" id="button" style="height:25px" value="Aceptar" /><br/><br/>
    </form>

   </td>
  </tr>
  <tr>
    <td width="309" rowspan="2" align="right" bgcolor="#000000"><a href="./guias/registro_de_pago.php" target="_blank"><img src="images/pagoenlinea.png" width="309" height="75"  alt="Pago en Linea" /></a></td>
      
    <td width="309" rowspan="2" align="right" bgcolor="#000000"><a href="http://anteriores.us.to/" target="_blank"><img src="images/botonsemanasanteriores.png" width="450" height="68"  alt="Semananas Anteriores" /></a></td>      

</tr>
<tr>
  </tr>

 <tr>
    <td height="480" colspan="2" align="right" background="images/Thoroughbred_Horse_Racing.jpg"></td>
  </tr>
  <tr>
    <td height="26" colspan="2" align="center" valign="middle" bgcolor="#151515" style="font-size:10px; font-family: Tahoma, Geneva, sans-serif">
Primer lugar (Win) El caballo debe terminar de primero.
<br/>Segundo lugar (Place) El caballo debe terminar de primero o de segundo, sin embargo solo cobras el premio de segundo.
<br/>Tercer lugar (Show) El caballo deber terminar de primero, segundo o tercero sin embargo solo cobras el premio del tercero.
<br/>Exacta: Es la forma mas simple de exacta, la cual es una combinacion de dos caballos para terminar en primero y segundo lugar, en el orden exacto en el que fueron escogidos, en otras palabras, para terminar primero y segundo, respectivamente.
<br/>Tripleta: Es la forma mas sencilla en tripletas, la cual es una sola combinacion de los primeros tres caballos en llegar de primero segundo y tercer lugar (win, place and show) en el orden exacto que se escogieron.
<br/>Superfecta: Es la forma mas sencilla de superfecta, la cual es una sola combinacion de los primeros cuatro caballos, 1ero, 2do, 3ro (win, place and show) y el 4to, en orden exacto al terminar.
<br/>Ejemplo: superfecta  1/2 /3/4
   </td>

  </tr>
  <tr>
    <td height="26" colspan="2" align="center" valign="middle" bgcolor="#151515" style="font-size:10px; font-family: Tahoma, Geneva, sans-serif"><br/><br/><br/>© Copyright 2012.. Apuestas1 Hípicas</td>
  </tr>

</table>
</CENTER>
</body>
</html>

<?php
} else {?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="./css/bootstrap5.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <title>APUESTAS</title>
	<style type="text/css">body {
    font-family: "Lato", sans-serif;
}
.main-head{
    height: 150px;
    background: #FFF;
   
}
.sidenav {
    height: 100%;
    background-color: #000;
    overflow-x: hidden;
    padding-top: 20px;
}
.main {
    padding: 0px 10px;
}
@media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
}
@media screen and (max-width: 450px) {
    .login-form{
        margin-top: 10%;
    }
    .register-form{
        margin-top: 10%;
    }
}
@media screen and (min-width: 768px){
    .main{
        margin-left: 40%; 
    }
    .sidenav{
        width: 40%;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
    }
    .login-form{
        margin-top: 60%;
    }
    .register-form{
        margin-top: 40%;
    }
}
.login-main-text{
    margin-top: 20%;
    padding: 60px;
    color: #fff;
}
.login-main-text h2{
    font-weight: 300;
}
.btn-black{
    background-color: #000 !important;
    color: #fff;
}</style>
  </head>
  <body>


	<link href="./css/bootstrap4.min.css" rel="stylesheet" id="bootstrap-css">
<script src="./js/bootstrap4.min.js"></script>
<script src="./js/jquery-1.11.1.min.js"></script>
<!-- Include the above in your HEAD tag -->

<div class="sidenav">
         <div class="login-main-text">
            <h2>APUESTAS<br></h2>
         </div>
      </div>
      <div class="main">
         <div class="col-md-6 col-sm-12">
            <div class="login-form">
            <div height="27" align="right" bgcolor="#000000" style="color: #C00"><?php echo $mensaje; ?></div>
			<form id="inicio" name="inicio" method="POST" action="<?php echo $loginFormAction; ?>">
                  <div class="form-group">
                     <label>USUARIO</label>
                     <input name="usuario" id="usuario" type="text" class="form-control" placeholder="USUARIO">
                  </div>
                  <div class="form-group">
                     <label>CLAVE</label>
                     <input name="password" id="password" type="password" class="form-control" placeholder="CLAVE">
                  </div>
                  <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="mantener_sesion_abierta"
                            name="mantener_sesion_abierta" value="lunes">
                        <label class="form-check-label" for="mantener_sesion_abierta">Mantener Sesion Abierta</label>
                    </div>
                  <button type="submit" class="btn btn-black">ACEPTAR</button>
               </form>
            </div>
         </div>
      </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
  
<script src="./js/bootstrap5.bundle.min.js"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    -->
  </body>
</html>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
<?php	} ?>