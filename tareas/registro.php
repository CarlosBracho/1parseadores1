<?php  
if (!isset($_SESSION)) {
    session_start();
}
require_once('./Connections/conexionbanca.php');
//registro de usuario  // se agregara esta funcion a index.php para reducir archivos y se elimina este
$loginFormAction = $_SERVER['PHP_SELF'];

if(!empty(($_POST['Usuario'])) && !empty($_POST['Pass'])){
$query_Recordset18 = sprintf("/* PARSEADORES1 tareas\registro.php - QUERY 1 */ SELECT nom_usuario FROM tablausuario WHERE nom_usuario = %s",
GetSQLValueString(($_POST['Usuario']), "text"));
$Recordset18 = mysqli_query($conexionbanca, $query_Recordset18) or die(mysqli_error($conexionbanca));
$row_Recordset18 = mysqli_fetch_assoc($Recordset18);
$totalRows_Recordset18 = mysqli_num_rows($Recordset18);

if($row_Recordset18>0){

  echo "Este usuario ya existe en el sistema";

  
}else{
  $insertSQL1 = sprintf(
    "/* PARSEADORES1 tareas\registro.php - QUERY 2 */ INSERT 
    INTO tablausuario
    (nom_usuario, pass_usuario) 
    VALUES (%s, %s)",
    GetSQLValueString(($_POST['Usuario']), "text"),
    GetSQLValueString(($_POST['Pass']), "text"));
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));

    echo "Usuario registrado exitosamente";

}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/registro.css">

    <title>Registro</title>
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
                <form action="./registro.php" method="post" name="Form1" id="Form1" onsubmit="return chequearEnvio();">
                    <div class="row">
                        <div class="col-md-12 login-form-header">
                            <p class="login-form-font-header">Registro <span>de Usuarios</span>
                            <p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 login-from-row">
                            <h4>Nombre de Usuario</h4>
                            <input type="text" name="Usuario" placeholder="Usuario">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 login-from-row">
                            <h4>Clave</h4>
                            <input type="password" name="Pass" placeholder="Pass"><br><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 login-from-row">
                            <input type="submit" value="Registrar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>
    <center>
        Inicia Sesion <a href="index.php">Aqui.
    </center>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>