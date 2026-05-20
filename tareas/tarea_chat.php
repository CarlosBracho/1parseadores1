<?php  
if (!isset($_SESSION)) {
    session_start();
}
require_once('./Connections/conexionbanca.php');
//aqui se muestra el chat de las tareas y aqui se cambia el estado de las tareas
$editFormAction = $_SERVER['PHP_SELF'];
if (!isset($_SESSION['usuario'])) {
	$MM_redirectLoginSuccess = "index.php";
	header("Location: ". $MM_redirectLoginSuccess);
}
$fech=fechaactualbd();
$horasistema=horaactual();
$fechahora=$fech.' '.$horasistema;
$query_Recordset2 = sprintf(
    "/* PARSEADORES1 tareas\tarea_chat.php - QUERY 1 */ SELECT *
    FROM 
        tablausuario
    WHERE 
    id_usuario = %s",
    GetSQLValueString($_SESSION['usuario'], "int"));
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);
    $usuariactivo=$row_Recordset2['nom_usuario'];

    if ($totalRows_Recordset2==0) {
        $MM_redirectLoginSuccess = "index.php";
        header("Location: ". $MM_redirectLoginSuccess);
    }

//var_dump($_POST);
    if(isset($_POST['datetime'])){
       // echo '<br>Se ejecuto el post<br>';
        $hora1=$_POST['datetime'];
        $nuevahora1 = strtotime('-0 hour', strtotime($hora1)) ;
        $nuevahora1 = date('Y-m-j H:i:s', $nuevahora1);

        $_GET["recordID"]=$_POST['recordID'];
//echo '<br><br>'.$_GET["recordID"].'<br><br>';

        $insertSQL1 = sprintf(
            "/* PARSEADORES1 tareas\tarea_chat.php - QUERY 2 */ UPDATE tablatarea
                SET
                fec_culminar = %s
                WHERE id_tarea = %s",
        GetSQLValueString($nuevahora1, "date"),
        GetSQLValueString($_POST['id_tarea'], "int"));
    
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));

        $insertSQL1 = sprintf(
            "/* PARSEADORES1 tareas\tarea_chat.php - QUERY 3 */ INSERT 
            INTO tablatareacomentario 
            (id_usuario, id_tarea, text_comentario) 
            VALUES (%s, %s, %s)",
            GetSQLValueString(($_SESSION['usuario']), "int"),
            GetSQLValueString($_POST['id_tarea'], "int"),
            GetSQLValueString('Se a modificado la fecha de limite de culminacion de '.$_POST['viejafecha'].' a '.$_POST['datetime'], "text"));
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
            
      // $MM_redirectLoginSuccess = "tarea_chat.php?recordID=".$_POST['id_tarea'];
     //  header("Location: ". $MM_redirectLoginSuccess);
    }





    $query_Recordset18 = sprintf("/* PARSEADORES1 tareas\tarea_chat.php - QUERY 4 */ SELECT * 
    FROM tablatarea, tablausuario
     WHERE tablatarea.id_tarea=%s  AND 
     tablatarea.id_usuariocreador=tablausuario.id_usuario
     LIMIT 1",
    GetSQLValueString($_GET["recordID"], "int"));
    $Recordset18 = mysqli_query($conexionbanca, $query_Recordset18) or die(mysqli_error($conexionbanca));
    $row_Recordset18 = mysqli_fetch_assoc($Recordset18);
    $totalRows_Recordset18 = mysqli_num_rows($Recordset18);
    

       
        $query_Recordset555 = sprintf("/* PARSEADORES1 tareas\tarea_chat.php - QUERY 5 */ SELECT * 
        FROM tablatareacomentario, tablausuario
        WHERE 
        tablatareacomentario.id_usuario= tablausuario.id_usuario AND 
        tablatareacomentario.id_tarea= %s  
        ORDER BY tablatareacomentario.id_comentario",
        GetSQLValueString($_GET["recordID"], "int"));
        $Recordset555 = mysqli_query($conexionbanca, $query_Recordset555) or die(mysqli_error($conexionbanca));
        $row_Recordset555 = mysqli_fetch_assoc($Recordset555);
        $totalRows_Recordset555 = mysqli_num_rows($Recordset555);



        if(isset($_POST['textocomentario'])){

            $insertSQL1 = sprintf(
            "/* PARSEADORES1 tareas\tarea_chat.php - QUERY 6 */ INSERT 
            INTO tablatareacomentario 
            (id_usuario, id_tarea, text_comentario) 
            VALUES (%s, %s, %s)",
            GetSQLValueString(($_SESSION['usuario']), "int"),
            GetSQLValueString($_POST['id_tarea'], "int"),
            GetSQLValueString(($_POST['textocomentario']), "text"));
            $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));


           $MM_redirectLoginSuccess = "tarea_chat.php?recordID=".$_POST['id_tarea'];
          header("Location: ". $MM_redirectLoginSuccess);

        }


        if(isset($_POST['FinalizarReabrir'])){
        if($_POST['estado_tarea']==1){
            $comentario='Finalizada por '.$usuariactivo.' a las '.$fechahora;
        }else{
            $comentario='Reeabierta por '.$usuariactivo.' a las '.$fechahora;
        }
            $insertSQL1 = sprintf(
                "/* PARSEADORES1 tareas\tarea_chat.php - QUERY 7 */ INSERT 
                INTO tablatareacomentario 
                (id_usuario, id_tarea, text_comentario) 
                VALUES (%s, %s, %s)",
                GetSQLValueString($_SESSION['usuario'], "int"),
                GetSQLValueString($_POST['id_tarea'], "int"),
                GetSQLValueString($comentario, "text"));
                $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
    



                $insertSQL1 = sprintf(
                    "/* PARSEADORES1 tareas\tarea_chat.php - QUERY 8 */ UPDATE tablatarea
                        SET
                        estado_tarea = %s,
                        fec_finalizada = %s
                        WHERE id_tarea = %s",
                GetSQLValueString($_POST['estado_tarea'], "int"),
                GetSQLValueString($fechahora, "date"),
                GetSQLValueString($_POST['id_tarea'], "int"));
            
                $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));


    
               $MM_redirectLoginSuccess = "tarea_chat.php?recordID=".$_POST['id_tarea'];
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="../js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

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
    ?>
        <div class="d-grid gap-2">

            <a href="./home.php" class="btn btn-primary" role="button">Volver</a>
        </div>


        <?php  if($row_Recordset18['estado_tarea']==0){ ?>

        <div class="d-grid gap-2">
            <button class="btn btn-outline-info" type="button">Esta Tarea Esta Pendiente</button>
        </div>
        <?php  }else{ ?>

        <div class="d-grid gap-2">
            <button class="btn btn-outline-danger" type="button">Esta Tarea Esta Finalizada</button>
        </div>

        <?php  } ?>




        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>


                        <?php   if($_SESSION['usuario']==$row_Recordset18['id_usuariocreador']){ ?>
                        <p class="text-end">
                            <?php echo $row_Recordset18['tareatext']; ?>
                        </p>


                        <?php }else{ ?>

                        <?php echo $row_Recordset18['tareatext']; ?>
                        <br>
                        <FONT SIZE=1><?php echo $row_Recordset18['nom_usuario']; ?></font>

                        <?php    } ?>




                    </td>
                </tr>

                <?php if($totalRows_Recordset555>0){
do { ?>
                <tr>
                    <td>

                        <?php   if($_SESSION['usuario']==$row_Recordset555['id_usuario']){ ?>
                        <p class="text-end">
                            <?php echo $row_Recordset555['text_comentario']; ?>
                        </p>


                        <?php }else{ ?>

                        <?php echo $row_Recordset555['text_comentario']; ?>
                        <br>
                        <FONT SIZE=1><?php echo $row_Recordset555['nom_usuario']; ?></font>

                        <?php    } ?>
                    </td>
                </tr>
                <?php
} while ($row_Recordset555 = mysqli_fetch_assoc($Recordset555));} ?>
                </tbody>
        </table>
        <form method="POST" name="form1" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
            <div class="col-auto">
                <input type="text" class="form-control" name="textocomentario" placeholder="Coloque Aqui el Mensaje"
                    required>
            </div>
            <div class="col-auto">
                <input type="hidden" name="id_tarea" value="<?php echo $row_Recordset18['id_tarea']; ?>">

                <button type="submit" class="btn btn-primary mb-3" onclick="btnCopy(this);">Enviar</button>
            </div>
        </form>

        <?php  if($row_Recordset18['estado_tarea']==0){ ?>
        <form method="POST" name="Finalizar" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
            <input type="hidden" name="id_tarea" value="<?php echo $row_Recordset18['id_tarea']; ?>">
            <input type="hidden" name="estado_tarea" value="1">
            <input type="hidden" name="FinalizarReabrir" value="1">

            <!-- Button trigger modal -->
            <div class="d-grid gap-2">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Finalizar
                </button>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Esta Seguro Que Desea Finalizar Esta Tarea
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                        </div>
                        <div class="modal-footer">

                            <button type="submit" class="btn btn-primary">SI</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NO</button>
                        </div>
                    </div>
                </div>
            </div>





        </form>
        <?php  }else{ ?>
        <form method="POST" name="Reabrir" action="<?php echo $editFormAction; ?>" onsubmit="return chequearEnvio();">
            <input type="hidden" name="id_tarea" value="<?php echo $row_Recordset18['id_tarea']; ?>">
            <input type="hidden" name="estado_tarea" value="0">
            <input type="hidden" name="FinalizarReabrir" value="0">
            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit">Reabrir</button>
            </div>




        </form>
        <?php  } ?>



        <br><br>
        <?php if($_SESSION['usuario']==$row_Recordset18['id_usuariocreador']){ ?>
        <form method="POST" name="FinalizacionTiempo" action="<?php echo $editFormAction; ?>"
            onsubmit="return chequearEnvio();">

            <!-- Button trigger modal -->
            <div class="d-grid gap-2">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                    data-bs-target="#FinalizacionTiempom">
                    Modificar Tiempo De Finalizacion
                </button>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="FinalizacionTiempom" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modificar Tiempo De Finalizacion
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">







                            <section id="demo_meridian" required>
                                Seleccione Fecha y Hora
                                <div>
                                    <div class="bs-docs-example">
                                        <div class="input-append date form_datetime6"
                                            data-date-format="dd MM yyyy - HH:ii P">
                                            <span class="add-on"><i class="icon-th"></i></span>

                                            <input size="26" type="text" value="" readonly="" required></br>
                                            <span class="add-on"><i class="icon-remove"></i></span>
                                            <input type="text" name="datetime" id="mirror_field" value="" readonly
                                                required />
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <script type="text/javascript">
                            $(".form_datetime6").datetimepicker({
                                format: "dd MM yyyy - HH:ii P",
                                autoclose: true,
                                todayBtn: true,
                                minuteStep: 1,
                                linkField: "mirror_field",
                                linkFormat: "yyyy-mm-dd hh:ii",
                                showMeridian: true
                            });
                            </script>










                        </div>
                        <div class="modal-footer">

                            <button type="submit" class="btn btn-primary">SI</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NO</button>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="recordID" value="<?php  echo $_GET["recordID"]; ?>">
            <input type="hidden" name="viejafecha" value="<?php  echo $row_Recordset18['fec_culminar']; ?>">

            <input type="hidden" name="id_tarea" value="<?php echo $row_Recordset18['id_tarea']; ?>">
            <br>
            <div class="d-grid gap-2">
                <a href="tareas_add.php?idtarea=<?php echo $row_Recordset18['id_tarea']; ?>" class="btn btn-danger"
                    tabindex="-1" role="button" aria-disabled="true">Editar Esta Tarea</a>
            </div>

        </form>
        <?php } ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
    </div>

</body>

</html>