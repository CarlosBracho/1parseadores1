<?php  
if (!isset($_SESSION)) {
    session_start();
}
require_once('./Connections/conexionbanca.php');

$editFormAction = $_SERVER['PHP_SELF'];

if (!isset($_SESSION['usuario'])) {
	$MM_redirectLoginSuccess = "index.php";
	header("Location: ". $MM_redirectLoginSuccess);
}
$fech=fechaactualbd();
$horasistema=horaactual();
$fechahora=$fech.' '.$horasistema;
    $query_Recordset2 = sprintf(
        "/* PARSEADORES1 tareas\tareas_edit.php - QUERY 1 */ SELECT *
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

       $valor1= "-1";
       if (isset($_GET["recordID"])) {
            $valor1=$_GET["recordID"];
        }
        $query_Recordset18 = sprintf("/* PARSEADORES1 tareas\tareas_edit.php - QUERY 2 */ SELECT * FROM tablatarea WHERE id_tarea=%s LIMIT 1",
        GetSQLValueString($valor1, "int"));
        $Recordset18 = mysqli_query($conexionbanca, $query_Recordset18) or die(mysqli_error($conexionbanca));
        $row_Recordset18 = mysqli_fetch_assoc($Recordset18);
        $totalRows_Recordset18 = mysqli_num_rows($Recordset18);
        

           
            $query_Recordset555 = sprintf("/* PARSEADORES1 tareas\tareas_edit.php - QUERY 3 */ SELECT * FROM tablatareacomentario WHERE id_usuario= %s AND id_tarea= %s  ORDER BY id_comentario",
            GetSQLValueString(($_SESSION['usuario']), "int"),
            GetSQLValueString($valor1, "int"));
            $Recordset555 = mysqli_query($conexionbanca, $query_Recordset555) or die(mysqli_error($conexionbanca));
            $row_Recordset555 = mysqli_fetch_assoc($Recordset555);
            $totalRows_Recordset555 = mysqli_num_rows($Recordset555);
            
            
            
            if(isset($_POST['Tarea'])){


                $insertSQL1 = sprintf(
                    "/* PARSEADORES1 tareas\tareas_edit.php - QUERY 4 */ UPDATE tablatarea
                        SET
                        estado_tarea = %s
                        WHERE id_tarea = %s",
                GetSQLValueString($_POST['tarea'], "int"),
                GetSQLValueString($_POST['id_tarea'], "int"));
            
                $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));



            $insertSQL1 = sprintf(
              "/* PARSEADORES1 tareas\tareas_edit.php - QUERY 5 */ INSERT 
              INTO tablatareacomentario 
              (id_usuario, id_tarea, text_comentario) 
              VALUES (%s, %s, %s)",
              GetSQLValueString(($_SESSION['usuario']), "int"),
              GetSQLValueString($_POST['id_tarea'], "int"),
              GetSQLValueString(($_POST['Tarea']), "text"));
              $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));


              

            }

            if(isset($_POST['fec_finalizada'])){
                $insertSQL1 = sprintf(
                "/* PARSEADORES1 tareas\tareas_edit.php - QUERY 6 */ UPDATE tablatarea
                        SET
                        estado_tarea = %s, fec_finalizada = %s
                        WHERE id_tarea = %s",
                GetSQLValueString($_POST['tarea'], "int"),
                GetSQLValueString($fechahora, "date"),
                GetSQLValueString($_POST['id_tarea'], "int"));
                $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
                $MM_redirectLoginSuccess = "tareas_finalizadas.php";
                header("Location: ". $MM_redirectLoginSuccess);
                
            }
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas Edit </title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    <?php
include("cabecera.php") 
    ?>

    <div style="background: black; color:white">

        <section id="container">
            <center>
                <h2>Edifcion de Tarea.</h2>
            </center>

            <h4> <?php echo "Nombre de Usuario: ".$row_Recordset2['nom_usuario'].'<br><br>';?> </h4>
    </div>

    <table width="100%" style="text-align: center;" border=cellpadding="0" cellspacing="0" style="line-height:14px">
        <tr valign="baseline">
            <td> <br>
                <form method="POST" name="form1" action="<?php echo $editFormAction; ?>"
                    onsubmit="return chequearEnvio();">
                    ESTADO DE LA TAREA:<br /><br />
                    <select name="tarea" id="tarea" style="width:140px; height: auto" class="textbox" tabindex="4">
                        <option value="1">Finalizada</option>
                        <option value="0">Pendiente</option>
                    </select>
                    <input type="hidden" name="id_tarea" value="<?php echo $row_Recordset18['id_tarea']; ?>">
                    <table>
                        <a href="./home.php"><br><br>
                        </a>

                        <h2>Hora a Culminar</h2>
                        <input type="text" name="fec_finalizada" value="<?php echo $fech; ?>"
                            style="width: 200px; padding: 10px; border: solid;">
                        <input type="text" name="hor_finalizada" value="<?php echo $horasistema; ?>"
                            style="width: 200px; padding: 10px; border: solid;"><br><br>
                    </table><br><br>


                    <input type="text" name="Tarea" id="" style="width: 1000px; padding: 20px; border: solid;"><br><br>


                    <input style="text-align: center;" type="submit" value="Envio">


                </form>
                <?php 

if($totalRows_Recordset555>0){
do {

    ?>
        <tr>
            <td>
                <?php  echo $row_Recordset555['text_comentario'] ?>
            </td>
        </tr>
        <?php 
} while ($row_Recordset555 = mysqli_fetch_assoc($Recordset555));
}else{
    ?>
        <tr>
            <td>
                <h3>No hay comentarios realizados</h3>
            </td>
        </tr>
        <?php 
}
?>
        </td>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>

</body>

</html>