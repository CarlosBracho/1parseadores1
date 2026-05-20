<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
    $_SESSION['MM_Username'] = null;
    $_SESSION['MM_UserGroup'] = null;
    $_SESSION['MM_id_usuario'] = null;
    unset($_SESSION['MM_Username']);
    unset($_SESSION['MM_UserGroup']);
    unset($_SESSION['MM_id_usuario']);
    unset($_SESSION['MM_cod_banca']);
    unset($_SESSION['MM_nom_banca']);
    unset($_SESSION['MM_systemE']);
    $MM_redirectLoginSuccess = "../index.php";
    header("Location: ".$MM_redirectLoginSuccess);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
<!--[if IE 7]><link rel="stylesheet" href="../css/font-awesome-ie7.min.css"><![endif]-->
<!--[if IE 8]><link rel="stylesheet" href="../css/font-awesome-ie7.min.css"><![endif]-->
<!--[if IE 9]><link rel="stylesheet" href="../css/font-awesome-ie7.min.css"><![endif]-->
<title>.:Apuestas Hípicas:.</title>
<style type="text/css"> 
#contenedor {
  width: 55%;
  margin: 0 auto;
  padding: 50px 0px 0px 10px;
  font-size:24px;
}
</style> 
</head>
<body style="margin: center">
    <div id="contenedor">
        <div style="width:125px; float:left;" >
            <i class="fa fa-exclamation-triangle fa-5x"></i>
        </div>    
        <div style="width:540px; float:left; line-height:20px; font-size:18px">
			<div style="width:auto; padding:0; text-align:center; float:right; height:42px">
				<form method="post" name="form1" action="<?php echo $editFormAction; ?>"  onsubmit="return chequearEnvio();">
					<input type="submit" class="btn" value="VOLVER" style="width:140px; height:40px; font-size:14px;"/>
					<input type="hidden" name="MM_insert" value="form1"/>
				</form>
			</div>
			<?php
            $error="<h1>Distribuidor desactivado.</h1>";
            echo $error."<br/>El servicio se encuentra desactivado, por favor use el chat para comunicarse con Soporte&nbsp;";
            echo "que sera respondido en breve";
            include("chat_disInactivo.php");
            ?>
        </div>
    </div>
</body>
</html>