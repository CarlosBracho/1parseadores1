<?php  
if (!isset($_SESSION)) {
    session_start();
}
require_once('./Connections/conexionbanca.php');
//tareas finalizadas // esta funcion se agregara a home.php para reducir archivos
$editFormAction = $_SERVER['PHP_SELF'];


if (!isset($_SESSION['usuario'])) {
	$MM_redirectLoginSuccess = "index.php";
	header("Location: ". $MM_redirectLoginSuccess);
}

$query_Recordset18 = sprintf("/* PARSEADORES1 tareas\tareas_finalizadas.php - QUERY 1 */ SELECT * FROM tablausuario ORDER BY tablausuario.id_usuario ");
$Recordset18 = mysqli_query($conexionbanca, $query_Recordset18) or die(mysqli_error($conexionbanca));
$row_Recordset18 = mysqli_fetch_assoc($Recordset18);
$totalRows_Recordset18 = mysqli_num_rows($Recordset18);


if(isset($_POST['tareasdeusuariox'])){ 
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 tareas\tareas_finalizadas.php - QUERY 2 */ SELECT *
        FROM 
            tablatarea 
        WHERE 
            id_usuario = %s AND estado_tarea = 1
        ORDER BY  fec_culminar  ASC LIMIT 999999999",
    
        GetSQLValueString($_POST['tareasdeusuariox'], "int"));
        $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
        $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
        $totalRows_Recordset1 = mysqli_num_rows($Recordset1);


}else{
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 tareas\tareas_finalizadas.php - QUERY 3 */ SELECT *
    FROM 
        tablatarea 
    WHERE 
        id_usuario = %s AND estado_tarea = 1
    ORDER BY  fec_culminar  ASC LIMIT 999999999",

    GetSQLValueString($_SESSION['usuario'], "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
}



    $query_Recordset2 = sprintf(
        "/* PARSEADORES1 tareas\tareas_finalizadas.php - QUERY 4 */ SELECT *
        FROM 
            tablausuario 
        WHERE 
        id_usuario = %s",
        GetSQLValueString($_SESSION['usuario'], "int"));
        $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
        $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
        $totalRows_Recordset2 = mysqli_num_rows($Recordset2);


        if ($totalRows_Recordset2==0) {
            $MM_redirectLoginSuccess = "index.php";
            header("Location: ". $MM_redirectLoginSuccess);
        }


        ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas Finalizadas</title>
    <link rel="stylesheet" href="tareas_lista.css">
    <!-- Bootstrap CSS     -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
        <?php
include("cabecera.php")
    ?> <br>
        <div style="background: black; color:white">

            <section id="container">
                <center>
                    <h1>Lista de Tareas Finalizadas</h1>
                </center>

                <h4> <?php echo "Nombre de Usuario: ".$row_Recordset2['nom_usuario'].'<br><br>';?> </h4>
        </div>
        <div class="d-grid gap-2">

            <a href="./home.php" class="btn btn-primary" role="button">Volver</a>
        </div>
        <form method="POST" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">

            <center>
                <select name="tareasdeusuariox" id="cars" required
                    style="height:40px; width:280px; margin:-9px 0px 0px 0px; border:solid;">
                    <option value=""> Selecionar</option>
                    <?php
                do {
                    ?>
                    <option value="<?php echo $row_Recordset18['id_usuario']?>">
                        <?php echo strtoupper($row_Recordset18['nom_usuario']); ?>
                    </option>
                    <?php
                } while ($row_Recordset18 = mysqli_fetch_assoc($Recordset18));
                ?>
                </select><br>

                <input class="btn btn-primary" type="submit" value="Submit">


                <center>
        </form>
        <div style="height:100%; font-size:28px; padding:10px 10px 10px 10px; float:right;">
            <a href="./home.php" class="btn alert-success" style="font-size:18px; width:165px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:#9C0;
                text-decoration:none;" title="Tareas Pendientes">
                Tareas Pendientes
            </a>

        </div>

        <table>
            <tr>
                <th>Nombre de Tarea</th>

                <th>Estado</th>
            </tr>

            <?php 

if($totalRows_Recordset1>0){
do {

    ?>
            <tr>

                <td>

                    <a class="link_edit"
                        href="tarea_chat.php?recordID=<?php echo $row_Recordset1['id_tarea']; ?>"><?php  echo $row_Recordset1['tareatext'] ?></a>



                </td>

                <td>
                    <?php
    if( $row_Recordset1 ['estado_tarea'] =="1"){
             echo'Finalizada';
          }else{
             echo'Pendiente';
          }
        ?>
                </td>
            </tr>
            <?php 
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}else{
    ?>
            <tr>
                <td>
                    No Tiene Tareas Finalizadas
                </td>
            </tr>
            <?php 
}
?>

        </table>

        </section>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
    </div>
</body>

</html>