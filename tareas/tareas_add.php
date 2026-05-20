<?php  
if (!isset($_SESSION)) {
    session_start();
}
require_once('./Connections/conexionbanca.php');
//agregar tareas
//var_dump($_POST);
//$_GET['idtarea']=3;
if(!empty($_GET['idtarea'])){
//echo 'si es editar';
$query_Recordset555 = sprintf("/* PARSEADORES1 tareas\tareas_add.php - QUERY 1 */ SELECT * 
FROM tablatarea, tablausuario 
WHERE 
tablatarea.id_usuario = tablausuario.id_usuario AND
tablatarea.id_tarea= %s",
GetSQLValueString($_GET["idtarea"], "int"));
$Recordset555 = mysqli_query($conexionbanca, $query_Recordset555) or die(mysqli_error($conexionbanca));
$row_Recordset555 = mysqli_fetch_assoc($Recordset555);
$totalRows_Recordset555 = mysqli_num_rows($Recordset555);
//echo $totalRows_Recordset555;




}
$query_Recordset18 = sprintf("/* PARSEADORES1 tareas\tareas_add.php - QUERY 2 */ SELECT * FROM tablausuario ORDER BY tablausuario.id_usuario ");
$Recordset18 = mysqli_query($conexionbanca, $query_Recordset18) or die(mysqli_error($conexionbanca));
$row_Recordset18 = mysqli_fetch_assoc($Recordset18);
$totalRows_Recordset18 = mysqli_num_rows($Recordset18);
$query_Recordset2 = sprintf(
    "/* PARSEADORES1 tareas\tareas_add.php - QUERY 3 */ SELECT *
    FROM 
        tablausuario 
    WHERE 
    id_usuario = %s",
    GetSQLValueString($_SESSION['usuario'], "int"));
    $Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
    $row_Recordset2 = mysqli_fetch_assoc($Recordset2);
    $totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$fech=fechaactualbd();
$horasistema=horaactual();
$fechyhora=fechaactualbd().' '.horaactual();

if(!empty(($_POST['Usuario'])) && !empty($_POST['Tarea'])){

    $hora1=$_POST['datetime'];
    $nuevahora1 = strtotime('-0 hour', strtotime($hora1)) ;
    $nuevahora1 = date('Y-m-j H:i:s', $nuevahora1);
    $repeticion='0';
    $repeticionmes='0';
    if(!empty($_POST['diasemana1'])){$repeticion=$repeticion.','.$_POST['diasemana1'];}
    if(!empty($_POST['diasemana2'])){$repeticion=$repeticion.','.$_POST['diasemana2'];}
    if(!empty($_POST['diasemana3'])){$repeticion=$repeticion.','.$_POST['diasemana3'];}
    if(!empty($_POST['diasemana4'])){$repeticion=$repeticion.','.$_POST['diasemana4'];}
    if(!empty($_POST['diasemana5'])){$repeticion=$repeticion.','.$_POST['diasemana5'];}
    if(!empty($_POST['diasemana6'])){$repeticion=$repeticion.','.$_POST['diasemana6'];}
    if(!empty($_POST['diasemana7'])){$repeticion=$repeticion.','.$_POST['diasemana7'];}

    if(!empty($_POST['diames1'])){$repeticionmes=$repeticionmes.','.$_POST['diames1'];}
    if(!empty($_POST['diames2'])){$repeticionmes=$repeticionmes.','.$_POST['diames2'];}
    if(!empty($_POST['diames3'])){$repeticionmes=$repeticionmes.','.$_POST['diames3'];}
    if(!empty($_POST['diames4'])){$repeticionmes=$repeticionmes.','.$_POST['diames4'];}
    if(!empty($_POST['diames5'])){$repeticionmes=$repeticionmes.','.$_POST['diames5'];}
    if(!empty($_POST['diames6'])){$repeticionmes=$repeticionmes.','.$_POST['diames6'];}
    if(!empty($_POST['diames7'])){$repeticionmes=$repeticionmes.','.$_POST['diames7'];}
    if(!empty($_POST['diames8'])){$repeticionmes=$repeticionmes.','.$_POST['diames8'];}
    if(!empty($_POST['diames9'])){$repeticionmes=$repeticionmes.','.$_POST['diames9'];}
    if(!empty($_POST['diames10'])){$repeticionmes=$repeticionmes.','.$_POST['diames10'];}
    if(!empty($_POST['diames11'])){$repeticionmes=$repeticionmes.','.$_POST['diames11'];}
    if(!empty($_POST['diames12'])){$repeticionmes=$repeticionmes.','.$_POST['diames12'];}
    if(!empty($_POST['diames13'])){$repeticionmes=$repeticionmes.','.$_POST['diames13'];}
    if(!empty($_POST['diames14'])){$repeticionmes=$repeticionmes.','.$_POST['diames14'];}
    if(!empty($_POST['diames15'])){$repeticionmes=$repeticionmes.','.$_POST['diames15'];}
    if(!empty($_POST['diames16'])){$repeticionmes=$repeticionmes.','.$_POST['diames16'];}
    if(!empty($_POST['diames17'])){$repeticionmes=$repeticionmes.','.$_POST['diames17'];}
    if(!empty($_POST['diames18'])){$repeticionmes=$repeticionmes.','.$_POST['diames18'];}
    if(!empty($_POST['diames19'])){$repeticionmes=$repeticionmes.','.$_POST['diames19'];}
    if(!empty($_POST['diames20'])){$repeticionmes=$repeticionmes.','.$_POST['diames20'];}
    if(!empty($_POST['diames21'])){$repeticionmes=$repeticionmes.','.$_POST['diames21'];}
    if(!empty($_POST['diames22'])){$repeticionmes=$repeticionmes.','.$_POST['diames22'];}
    if(!empty($_POST['diames23'])){$repeticionmes=$repeticionmes.','.$_POST['diames23'];}
    if(!empty($_POST['diames24'])){$repeticionmes=$repeticionmes.','.$_POST['diames24'];}
    if(!empty($_POST['diames25'])){$repeticionmes=$repeticionmes.','.$_POST['diames25'];}
    if(!empty($_POST['diames26'])){$repeticionmes=$repeticionmes.','.$_POST['diames26'];}
    if(!empty($_POST['diames27'])){$repeticionmes=$repeticionmes.','.$_POST['diames27'];}
    if(!empty($_POST['diames28'])){$repeticionmes=$repeticionmes.','.$_POST['diames28'];}
    if(!empty($_POST['diames29'])){$repeticionmes=$repeticionmes.','.$_POST['diames29'];}
    if(!empty($_POST['diames30'])){$repeticionmes=$repeticionmes.','.$_POST['diames30'];}
    if(!empty($_POST['diames31'])){$repeticionmes=$repeticionmes.','.$_POST['diames31'];}




    if(!empty($_POST['tareaaactualizar'])){


        $query_Recordset51 = sprintf("/* PARSEADORES1 tareas\tareas_add.php - QUERY 4 */ SELECT * 
        FROM tablatarea, tablausuario 
        WHERE 
        tablatarea.id_usuario = tablausuario.id_usuario AND
        tablatarea.id_tarea= %s",
        GetSQLValueString($_POST['tareaaactualizar'], "int"));
        $Recordset51 = mysqli_query($conexionbanca, $query_Recordset51) or die(mysqli_error($conexionbanca));
        $row_Recordset51 = mysqli_fetch_assoc($Recordset51);
        $totalRows_Recordset51 = mysqli_num_rows($Recordset51);



if($row_Recordset51['id_usuario']<>$_POST['Usuario']){


    $insertSQL1 = sprintf(
        "/* PARSEADORES1 tareas\tareas_add.php - QUERY 5 */ INSERT 
        INTO tablatareacomentario 
        (id_usuario, id_tarea, text_comentario) 
        VALUES (%s, %s, %s)",
        GetSQLValueString($_SESSION['usuario'], "int"),
        GetSQLValueString($_POST['tareaaactualizar'], "int"),
        GetSQLValueString('Se a cambiado el usuario de '.$row_Recordset51['nom_usuario'].' al actual', "text"));
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));


}


if($row_Recordset51['tareatext']<>$_POST['Tarea']){


    $insertSQL1 = sprintf(
        "/* PARSEADORES1 tareas\tareas_add.php - QUERY 6 */ INSERT 
        INTO tablatareacomentario 
        (id_usuario, id_tarea, text_comentario) 
        VALUES (%s, %s, %s)",
        GetSQLValueString($_SESSION['usuario'], "int"),
        GetSQLValueString($_POST['tareaaactualizar'], "int"),
        GetSQLValueString('Se a cambiado el asunto de este --- '.$row_Recordset51['tareatext'].' --- a este --- '.$_POST['Tarea'].' ---', "text"));
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));


}














        $insertSQL1 = sprintf(
            "/* PARSEADORES1 tareas\tareas_add.php - QUERY 7 */ UPDATE tablatarea
                SET
                tareatext=%s,
                repeticion=%s,
                diames=%s,
                fec_culminar=%s, 
                id_usuario=%s 
                WHERE id_tarea=%s",
                GetSQLValueString($_POST['Tarea'], "text"),
                GetSQLValueString($repeticion, "text"),
                GetSQLValueString($repeticionmes, "text"),
        GetSQLValueString($nuevahora1, "date"),
        GetSQLValueString($_POST['Usuario'], "int"),
        GetSQLValueString($_POST['tareaaactualizar'], "int")
        );
        
        $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));





















    }else{




$insertSQL1 = sprintf(
  "/* PARSEADORES1 tareas\tareas_add.php - QUERY 8 */ INSERT 
  INTO tablatarea
  (id_usuario, tareatext, fec_creada, fec_culminar, id_usuariocreador, repeticion, diames) 
  VALUES (%s, %s, %s, %s, %s, %s, %s)",
  GetSQLValueString(($_POST['Usuario']), "int"),
  GetSQLValueString(($_POST['Tarea']), "text"),
  GetSQLValueString($fechyhora, "date"),
  GetSQLValueString($nuevahora1, "date"),
  GetSQLValueString($_SESSION['usuario'], "int"),
GetSQLValueString($repeticion, "text"),
GetSQLValueString($repeticionmes, "text"));
  $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));

  $query_Recordset13 = sprintf(
    "/* PARSEADORES1 tareas\tareas_add.php - QUERY 9 */ SELECT *
    FROM 
    tablatarea
    WHERE 
    id_usuario = %s AND
    id_usuariocreador = %s
    ORDER BY id_tarea  DESC LIMIT 1",
    GetSQLValueString($_POST['Usuario'], "int"),
    GetSQLValueString($_SESSION['usuario'], "int"));
    $Recordset13 = mysqli_query($conexionbanca, $query_Recordset13) or die(mysqli_error($conexionbanca));
    $row_Recordset13 = mysqli_fetch_assoc($Recordset13);
    $totalRows_Recordset13 = mysqli_num_rows($Recordset13);

    $_POST['tareaaactualizar']=$row_Recordset13['id_tarea'];

}
$MM_redirectLoginSuccess = "tarea_chat.php?recordID=".$_POST['tareaaactualizar'];
header("Location: ". $MM_redirectLoginSuccess);

}






?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas add</title>
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
    <script languague="javascript">
    function mostrar() {
        div = document.getElementById('flotante');
        div.style.display = '';
    }

    function cerrar() {
        div = document.getElementById('flotante');
        div.style.display = 'none';
    }

    function mostrardiassemana() {
        div = document.getElementById('flotantediassemana');
        div.style.display = '';
    }

    function cerrardiassemana() {
        div = document.getElementById('flotantediassemana');
        div.style.display = 'none';
    }
    </script>
</head>

<body>

    <div class="container">
        <?php
include("cabecera.php") 
    ?>

        <div style="background: black; color:white">

            <section id="container">
                <center>
                    <h2>Crear Nueva Tarea.</h2>
                </center>

                <h4> <?php echo "Nombre de Usuario: ".$row_Recordset2['nom_usuario'].'<br><br>';?> </h4>
        </div>
        <div class="d-grid gap-2">

            <a href="./home.php" class="btn btn-primary" role="button">Volver</a>
        </div>
        <form action="./tareas_add.php" method="post" name="Form1" id="Form1" onsubmit="return chequearEnvio();">
            <center>
                <h3
                    style="font-size:24px; font-weight: bold; background:#020202; color:#FFFFFF; height: 50px; padding: 10px">
                    Asignar Tarea a:</h3>
            </center><br>
            <center>
                <select name="Usuario" id="soflow" required
                    style="height:40px; width:280px; margin:-9px 0px 0px 0px; border:solid;">
                    <?php if(!empty($_GET['idtarea'])){ ?>
                    <option value="<?php echo $row_Recordset555['id_usuario']?>">
                        <?php echo strtoupper($row_Recordset555['nom_usuario']); ?></option>
                    <?php
                }else{
                    ?>
                    <option value=""> Selecionar</option>
                    <?php
                }
                do {
                    ?>
                    <option value="<?php echo $row_Recordset18['id_usuario']?>">
                        <?php echo strtoupper($row_Recordset18['nom_usuario']); ?>
                    </option>
                    <?php
                } while ($row_Recordset18 = mysqli_fetch_assoc($Recordset18));
                ?>
                </select><br>
                <center>
                    <h4>Fecha en la que Iniciara</h4>


                    <section id="demo_meridian" required>
                        Seleccione Fecha y Hora
                        <div>
                            <div class="bs-docs-example">
                                <div class="input-append date form_datetime6" data-date-format="dd MM yyyy">
                                    <span class="add-on"><i class="icon-th"></i></span>
                                    <?php if(!empty($_GET['idtarea'])){ ?>
                                    <input size="26" type="text" value="<?php echo $row_Recordset555['fec_culminar']?>"
                                        readonly="" required></br>
                                    <?php }else{ ?>
                                    <input size="26" type="text" value="" readonly="" required></br>
                                    <?php } ?>
                                    <span class="add-on"><i class="icon-remove"></i></span>
                                    <input type="text" name="datetime2" id="mirror_field" value="" readonly required />
                                </div>
                            </div>
                        </div>
                    </section>
                    <script type="text/javascript">
                    $(".form_datetime6").datetimepicker({
                        format: "dd MM yyyy",
                        autoclose: true,
                        linkField: "mirror_field",
                        linkFormat: "yyyy-mm-dd",
                        showMeridian: false
                    });
                    </script>


                    <br>

                    <h4>Hora a Culminar</h4>


                    <section id="demo_meridian" required>
                        Seleccione Fecha y Hora
                        <div>
                            <div class="bs-docs-example">
                                <div class="input-append date form_datetime6" data-date-format="dd MM yyyy - HH:ii P">
                                    <span class="add-on"><i class="icon-th"></i></span>
                                    <?php if(!empty($_GET['idtarea'])){ ?>
                                    <input size="26" type="text" value="<?php echo $row_Recordset555['fec_culminar']?>"
                                        readonly="" required></br>
                                    <?php }else{ ?>
                                    <input size="26" type="text" value="" readonly="" required></br>
                                    <?php } ?>
                                    <span class="add-on"><i class="icon-remove"></i></span>
                                    <input type="text" name="datetime" id="mirror_field" value="" readonly required />
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


                    <br>
                    <!-- Button trigger modal -->
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Selecione Dias A La Semana Que Se Repetira Esta Tarea
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Selecione Dias A La Semana Que Se
                                        Repetira
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                            name="diasemana1" value="1"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['repeticion'], '1') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox1">Lunes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                            name="diasemana2" value="2"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['repeticion'], '2') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox2">Martes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox3"
                                            name="diasemana3" value="3"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['repeticion'], '3') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox3">Miercoles</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox4"
                                            name="diasemana4" value="4"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['repeticion'], '4') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox4">Jueves</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox5"
                                            name="diasemana5" value="5"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['repeticion'], '5') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox5">Viernes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox6"
                                            name="diasemana6" value="6"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['repeticion'], '6') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox6">Sabado</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox7"
                                            name="diasemana7" value="7"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['repeticion'], '7') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox7">Domingo</label>
                                    </div>
                                    <div>
                                        <h5 class="modal-title" id="exampleModalLabel">Indique Por Cuantos Dias Se
                                            Activara
                                        </h5>
                                    </div>
                                    <div>

                                        <input type="number" name="diasactivo1" class="form-control" min="1" max="30">
                                    </div>


                                </div>
                                <div class="modal-footer">

                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Listo</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <!-- Button trigger modal -->
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#exampleModal2">
                            Selecione Dias Al Mes Que Se Repetira Esta Tarea
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Selecione Dias Al Mes Que Se
                                        Repetira Esta Tarea
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">




                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox01"
                                            name="diames1" value="01"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '01') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox01">1</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox02"
                                            name="diames2" value="02"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '02') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox02">2</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox03"
                                            name="diames3" value="03"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '03') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox03">3</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox04"
                                            name="diames4" value="04"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '04') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox04">4</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox05"
                                            name="diames5" value="05"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '05') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox05">5</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox06"
                                            name="diames6" value="06"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '06') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox06">6</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox07"
                                            name="diames7" value="07"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '07') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox07">7</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox08"
                                            name="diames8" value="08"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '08') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox08">8</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox09"
                                            name="diames9" value="09"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '09') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox09">9</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox10"
                                            name="diames10" value="10"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '10') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox10">10</label>
                                    </div>


                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox11"
                                            name="diames11" value="11"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '11') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox11">11</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox12"
                                            name="diames12" value="12"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '12') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox12">12</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox13"
                                            name="diames13" value="13"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '13') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox13">13</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox14"
                                            name="diames14" value="14"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '14') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox14">14</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox15"
                                            name="diames15" value="15"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '15') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox15">15</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox16"
                                            name="diames16" value="16"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '16') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox16">16</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox17"
                                            name="diames17" value="17"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '17') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox17">17</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox18"
                                            name="diames18" value="18"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '18') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox18">18</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox19"
                                            name="diames19" value="19"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '19') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox19">19</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox20"
                                            name="diames20" value="20"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '20') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox20">20</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox21"
                                            name="diames21" value="21"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '21') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox21">21</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox22"
                                            name="diames22" value="22"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '22') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox22">22</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox23"
                                            name="diames23" value="23"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '23') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox23">23</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox24"
                                            name="diames24" value="24"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '24') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox24">24</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox25"
                                            name="diames25" value="25"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '25') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox25">25</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox26"
                                            name="diames26" value="26"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '26') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox26">26</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox27"
                                            name="diames27" value="27"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '27') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox27">27</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox28"
                                            name="diames18" value="28"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '28') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox28">28</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox29"
                                            name="diames29" value="29"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '29') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox29">29</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox30"
                                            name="diames30" value="30"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '30') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox30">30</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox31"
                                            name="diames31" value="31"
                                            <?php if(!empty($_GET['idtarea'])){ if(strpos($row_Recordset555['diames'], '31') !== false){?>
                                            checked="checked" <?php }} ?>>
                                        <label class="form-check-label" for="inlineCheckbox31">31</label>
                                    </div>
                                    <div>
                                        <h5 class="modal-title" id="exampleModalLabel">Indique Por Cuantos Dias Se
                                            Activara
                                        </h5>
                                    </div>
                                    <div>

                                        <input type="number" name="diasactivo2" class="form-control" min="1" max="30">
                                    </div>

                                </div>
                                <div class="modal-footer">

                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Listo</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>



                    <?php if(!empty($_GET['idtarea'])){ ?>
                    <input type="hidden" name="tareaaactualizar" value="<?php echo $_GET['idtarea']; ?>">
                    <?php } ?>
                    <h3 style="font-size:24px; font-weight: bold; background:#020202; color:#FFFFFF; height:30px">
                        Descripcion de la Tarea</h3>
                </center><br>
                <input class="form-control" name="Tarea" required type="text"
                    placeholder="Escriba la terea a realizar aqui" <?php if(!empty($_GET['idtarea'])){ ?>
                    value="<?php echo $row_Recordset555['tareatext'];?>" <?php } ?>>

                <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
            </center>
        </form>


        <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
    </div>
</body>

</html>