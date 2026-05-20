<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once('./Connections/conexionbanca.php');
//inicio logeo //se agregara el registro aqui para reducir cantidad de archivos eliminando registro.php
include "mcript.php";


$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_COOKIE['COOKIE_INDEFINED_SESSION'])) {

		$nombre_user = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['nombre']);
		$password_user = $desencriptar($_COOKIE['COOKIE_DATA_INDEFINED_SESSION']['password']);


        $query_Recordset1 = sprintf(
			"/* PARSEADORES1 tareas\index.php - QUERY 1 */ SELECT *
			FROM 
				tablausuario 
			WHERE 
			nom_usuario = %s AND
			pass_usuario = %s ",
			GetSQLValueString($nombre_user, "text"),
			GetSQLValueString($password_user, "text"));
			$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
			$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
			$totalRows_Recordset1 = mysqli_num_rows($Recordset1);

            if($totalRows_Recordset1>0){
                $_SESSION['usuario']=$row_Recordset1['id_usuario'];

                $MM_redirectLoginSuccess = "home.php";
                header("Location: ". $MM_redirectLoginSuccess);
	}
}

if (isset($_POST['usuario'])) {
	
	if (isset($_POST['contrasena'])) {
		//echo 'estoy aqui';

		$query_Recordset1 = sprintf(
			"/* PARSEADORES1 tareas\index.php - QUERY 2 */ SELECT *
			FROM 
				tablausuario 
			WHERE 
			nom_usuario = %s AND
			pass_usuario = %s ",
			GetSQLValueString($_POST['usuario'], "text"),
			GetSQLValueString($_POST['contrasena'], "text"));
			$Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
			$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
			$totalRows_Recordset1 = mysqli_num_rows($Recordset1);


if($totalRows_Recordset1>0){


	echo '<br><br>'.$row_Recordset1['nom_usuario'].'<br><br>';


	$_SESSION['usuario']=$row_Recordset1['id_usuario'];


$nombre = $encriptar($row_Recordset1['nom_usuario']);
$password = $encriptar($_POST["contrasena"]);





if (!empty($_POST["mantener_sesion_abierta"])) {
        setcookie("COOKIE_INDEFINED_SESSION", TRUE, time()+31622400);
		setcookie("COOKIE_DATA_INDEFINED_SESSION[nombre]", $nombre, time()+31622400);
        setcookie("COOKIE_DATA_INDEFINED_SESSION[password]", $password, time()+31622400);
		echo "Sesión abierta indefinidamente.<br/>";
} else {
	setcookie("COOKIE_CLOSE_NAVEGADOR", TRUE, 0) . "<br/>";
	echo "Sesión abierta hasta que cierre el navegador.<br/>";
}

	$MM_redirectLoginSuccess = "home.php";
	header("Location: ". $MM_redirectLoginSuccess);

}else{	
    $MM_redirectLoginSuccess = "index.php";
	header("Location: ". $MM_redirectLoginSuccess);
}

}}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Tareas pwa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"
        integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <script>
    var statusEnvio = false;

    function chequearEnvio() {
        if (!statusEnvio) {
            statusEnvio = true;
            return true;
        } else {
            alert("El formulario ya está siendo enviado, por favor aguarde un instante.");
            return false;
        }
    }
    </script>
</head>

<body>
    <div class="container">
        <div class="row text-center login-page">
            <div class="col-md-12 login-form">
                <form action="<?php echo $loginFormAction; ?>" method="post" onsubmit="return chequearEnvio();">

                    <div class="row">
                        <div class="col-md-12 login-form-header">
                            <p class="login-form-font-header">Gestion de Tareas <span>de Empleados</span>
                            <p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 login-from-row">
                            <h4>Nombre de Usuario</h4>
                            <input name="usuario" type="text" placeholder="Usuario" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 login-from-row">
                            <h4>Contraseña</h4>
                            <input name="contrasena" type="password" placeholder="Contraseña" required />
                        </div>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="mantener_sesion_abierta"
                            name="mantener_sesion_abierta" value="lunes">
                        <label class="form-check-label" for="mantener_sesion_abierta">Mantener Sesion Abierta</label>
                    </div>
                    <div class="row">
                        <div class="col-md-12 login-from-row">
                            <button class="btn btn-info">Entrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <center>
        Registrate aqui <a href="registro.php">Aqui.
    </center>

</body>

</html>