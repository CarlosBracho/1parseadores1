<?php  
if (!isset($_SESSION)) {
    session_start();
}
require_once('./Connections/conexionbanca.php');
//aqui se muestran las tareas pendientes // se agregaran las tareas finalizadas aqui para reducir archivos eliminando tareas_finalizadas.php

$fech=fechaactualbd();
$horasistema=horaactual();
$fechahora=$fech.' '.$horasistema;
//echo $fechahora;
$editFormAction = $_SERVER['PHP_SELF'];


if (!isset($_SESSION['usuario'])) {
	$MM_redirectLoginSuccess = "index.php";
	header("Location: ". $MM_redirectLoginSuccess);
}

$query_Recordset18 = sprintf("/* PARSEADORES1 tareas\home.php - QUERY 1 */ SELECT * FROM tablausuario ORDER BY tablausuario.id_usuario ");
$Recordset18 = mysqli_query($conexionbanca, $query_Recordset18) or die(mysqli_error($conexionbanca));
$row_Recordset18 = mysqli_fetch_assoc($Recordset18);
$totalRows_Recordset18 = mysqli_num_rows($Recordset18);

if(isset($_POST['tareasdeusuariox'])){ 
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 tareas\home.php - QUERY 2 */ SELECT *
        FROM 
            tablatarea 
        WHERE 
            id_usuario = %s AND estado_tarea = 0
        ORDER BY  fec_culminar  DESC LIMIT 999999999",
    
        GetSQLValueString($_POST['tareasdeusuariox'], "int"));
        $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
        $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
        $totalRows_Recordset1 = mysqli_num_rows($Recordset1);


}else{
$query_Recordset1 = sprintf(
    "/* PARSEADORES1 tareas\home.php - QUERY 3 */ SELECT *
    FROM 
        tablatarea 
    WHERE 
        id_usuario = %s AND estado_tarea = 0
    ORDER BY  fec_culminar  ASC LIMIT 999999999",

    GetSQLValueString($_SESSION['usuario'], "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
}
    $query_Recordset2 = sprintf(
        "/* PARSEADORES1 tareas\home.php - QUERY 4 */ SELECT *
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

        $query_Recordset111 = sprintf(
            "/* PARSEADORES1 tareas\home.php - QUERY 5 */ SELECT *
            FROM 
                tablatarea, tablausuario 
            WHERE 
            tablatarea.id_usuario = tablausuario.id_usuario AND
            tablatarea.estado_tarea = 0
            ORDER BY  tablatarea.fec_culminar  ASC LIMIT 999999999");
            $Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
            $row_Recordset111 = mysqli_fetch_assoc($Recordset111);
            $totalRows_Recordset111 = mysqli_num_rows($Recordset111);
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="../js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

</head>

<body>

    <div class="container">
        <?php
include("cabecera.php")
    ?> <br>

        <div style="background: black; color:white">

            <section id="container">
                <center>
                    <h1>Lista de Tareas.</h1>
                </center>

                <h4> <?php echo "Nombre de Usuario: ".$row_Recordset2['nom_usuario'].'<br><br>';?> </h4>
        </div>
        <div>
            <form method="POST" name="form1" action="<?php echo $editFormAction; ?>">

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
                <a href="./tareas_add.php" class="btn alert-success" style="font-size:18px; width:165px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:#9C0;
                text-decoration:none;" title="crear nueva tarea">
                    Añadir Nueva Tarea
                </a>
            </div>
            <div style="height:100%; font-size:28px; padding:10px 10px 10px 10px; float:right;">
                <a href="./tareas_finalizadas.php" class="btn alert-success" style="font-size:18px; width:165px; height:40px; padding:5px 0px 0px 0px; text-align:center; background:#9C0;
                text-decoration:none;" title="Tareas Pendientes">
                    Tareas Finalizadas
                </a>

            </div>
        </div>
        <div style="border:5px solid black;">
            <table class="table table-info table-striped" style="border: 1px;">
                <tr>
                    <th>Tareas Pendientes </th>
                </tr>

                <?php 

if($totalRows_Recordset1>0){
do {

    ?>
                <tr>

                    <td>
                        <a class="link_edit"
                            href="tarea_chat.php?recordID=<?php echo $row_Recordset1['id_tarea']; ?>"><?php  echo $row_Recordset1['tareatext'] ?></a>

                        <a class="link_edit" style="color:blue"
                            href="tarea_chat.php?recordID=<?php echo $row_Recordset1['id_tarea']; ?>"><?php  

       $mifecha= $row_Recordset1['fec_culminar']; 
      // echo '<br>'.$mifecha.' -- '.$row_Recordset1['fec_culminar'].'<br>';
        $NuevaFecha = strtotime ( '-0 hour' , strtotime ($mifecha) ) ; 
        $NuevaFecha = strtotime ( '-0 minute' , $NuevaFecha ) ; 
        $NuevaFecha = strtotime ( '-0 second' , $NuevaFecha ) ; 
        $NuevaFecha = date ( 'Y-m-d H:i:s' , $NuevaFecha); 
$datestr=$NuevaFecha;//Your date
$date=strtotime('-5 hour', strtotime($datestr));//Converted to a PHP date (a second count)
$diff=$date-time();//time returns current time in seconds
$days=floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)
$hours=round(($diff-$days*60*60*24)/(60*60));


if(strpos($days, '-') !== false){

    echo "<br><font color=red><i class=icon-warning-sign></i>
     Tiempo Limite Acabado Por Favor Culmine La Tarea Cuanto Antes <font/><br>";

}else{   
    echo "<br><i class=icon-time></i>Tiempo Limite $days dias $hours horas <br />";

} 

?>
                        </a>
                    </td>
                </tr>
                <?php 
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}else{
    ?>
                <tr>
                    <td>
                        <h3>No Tiene Tareas Pendientes En Estos Momentos</h3>
                    </td>
                </tr>
                <?php 
}
?>

            </table>






            <table class="table table-light table-striped">
                <thead>
                    <tr>
                        <th scope="col">Todas Las Tareas Pendientes De Los Demas</th>

                    </tr>
                </thead>
                <tbody style="border: 1px;">


                    <?php
                    if($totalRows_Recordset111>0){
                do {
                    ?>
                    <?php if($_SESSION['usuario']<>$row_Recordset111['id_usuario']){ ?>

                    <tr>

                        <td>
                            <a class="link_edit" style="color:red"
                                href="tarea_chat.php?recordID=<?php echo $row_Recordset111['id_tarea']; ?>"><?php  echo $row_Recordset111['nom_usuario']; ?><br></a>
                            <a class="link_edit"
                                href="tarea_chat.php?recordID=<?php echo $row_Recordset111['id_tarea']; ?>"><?php  echo $row_Recordset111['tareatext'] ?></a>

                            <a class="link_edit" style="color:blue"
                                href="tarea_chat.php?recordID=<?php echo $row_Recordset111['id_tarea']; ?>"><?php  
                           
                           
                           $mifecha= $row_Recordset111['fec_culminar']; 
                            $NuevaFecha = strtotime ( '-0 hour' , strtotime ($mifecha) ) ; 
                            $NuevaFecha = strtotime ( '-0 minute' , $NuevaFecha ) ; 
                            $NuevaFecha = strtotime ( '-0 second' , $NuevaFecha ) ; 
                            $NuevaFecha = date ( 'Y-m-d H:i:s' , $NuevaFecha); 
$datestr=$NuevaFecha;//Your date
$date=strtotime('-5 hour', strtotime($datestr));//Converted to a PHP date (a second count)
$diff=$date-time();//time returns current time in seconds
$days=floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)
$hours=round(($diff-$days*60*60*24)/(60*60));
if(strpos($days, '-') !== false){

    echo "<br><font color=red><i class=icon-warning-sign></i>
     Tiempo Limite Acabado Por Favor Culmine La Tarea Cuanto Antes <font/><br>";

}else{   
    echo "<br><i class=icon-time></i>Tiempo Limite $days dias $hours horas <br />";

}  ?></a>
                        </td>
                    </tr>


                    <?php }
                } while ($row_Recordset111 = mysqli_fetch_assoc($Recordset111));
            }else{
                ?>
                    <tr>
                        <td>
                            <h3>No Hay Tareas Pendientes De Los Demas</h3>
                        </td>
                    </tr>
                    <?php 
            }
            ?>


                </tbody>
            </table>
        </div>


        <?php 
















$query_Recordset1 = sprintf(
    "/* PARSEADORES1 tareas\home.php - QUERY 6 */ SELECT *
    FROM 
        tablatarea 
    WHERE 
        id_usuario = %s AND estado_tarea = 1
    ORDER BY  fec_finalizada  DESC LIMIT 10",

    GetSQLValueString($_SESSION['usuario'], "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);




echo '<br>';

$query_Recordset111 = sprintf(
    "/* PARSEADORES1 tareas\home.php - QUERY 7 */ SELECT *
    FROM 
        tablatarea, tablausuario 
    WHERE 
    tablatarea.id_usuario = tablausuario.id_usuario AND
    tablatarea.estado_tarea = 1
    ORDER BY  tablatarea.fec_finalizada  DESC LIMIT 20");
    $Recordset111 = mysqli_query($conexionbanca, $query_Recordset111) or die(mysqli_error($conexionbanca));
    $row_Recordset111 = mysqli_fetch_assoc($Recordset111);
    $totalRows_Recordset111 = mysqli_num_rows($Recordset111);

?>

        <div style="border:5px solid black;">
            <table class="table table-info table-striped" style="border: 1px;">
                <tr>
                    <th>10 Ultimas Tareas Finalizadas </th>
                </tr>

                <?php 

if($totalRows_Recordset1>0){
do {

    ?>
                <tr>

                    <td>
                        <a class="link_edit"
                            href="tarea_chat.php?recordID=<?php echo $row_Recordset1['id_tarea']; ?>"><?php  echo $row_Recordset1['tareatext'] ?></a>

                        <a class="link_edit" style="color:blue"
                            href="tarea_chat.php?recordID=<?php echo $row_Recordset1['id_tarea']; ?>"><?php  
                              
                              






                            //  $mifecha= $row_Recordset1['fec_finalizada']; 
                            //  $NuevaFecha = strtotime ( '-0 hour' , strtotime ($mifecha) ) ; 
                            //  $NuevaFecha = strtotime ( '-0 minute' , $NuevaFecha ) ; 
                            //  $NuevaFecha = strtotime ( '-0 second' , $NuevaFecha ) ; 
                            //  $NuevaFecha = date ( 'Y-m-d H:i:s' , $NuevaFecha); 
   //$datestr=$NuevaFecha;//Your date
   //echo '<br>'.$row_Recordset1['fec_finalizada'].' -- '.$mifecha.'<br>';

   $datestr=$row_Recordset1['fec_finalizada'];
   $date=strtotime('-0 hour', strtotime($datestr));//Converted to a PHP date (a second count)
   $diff=time()-$date;//time returns current time in seconds
   $days=floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)
   $hours=round(($diff-$days*60*60*24)/(60*60));
   
   
   
   
   echo "<br><font color=black><i class=icon-time></i>Tiempo Transcurido Desde Que Se Finalizo Hace $days dias $hours horas <font/><br />";
                              ?>
                        </a>
                    </td>
                </tr>
                <?php 
} while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
}else{
    ?>
                <tr>
                    <td>
                        <h3>No Tiene Tareas Finalizadas</h3>
                    </td>
                </tr>
                <?php 
}
?>

            </table>






            <table class="table table-light table-striped">
                <thead>
                    <tr>
                        <th scope="col">20 Ultimas Tareas Finalizadas De Los Demas</th>

                    </tr>
                </thead>
                <tbody style="border: 1px;">


                    <?php
                    if($totalRows_Recordset111>0){
                do {
                    ?>
                    <?php if($_SESSION['usuario']<>$row_Recordset111['id_usuario']){ ?>

                    <tr>

                        <td>
                            <a class="link_edit" style="color:red"
                                href="tarea_chat.php?recordID=<?php echo $row_Recordset111['id_tarea']; ?>"><?php  echo $row_Recordset111['nom_usuario']; ?><br></a>
                            <a class="link_edit"
                                href="tarea_chat.php?recordID=<?php echo $row_Recordset111['id_tarea']; ?>"><?php  echo $row_Recordset111['tareatext'] ?></a>

                            <a class="link_edit" style="color:blue"
                                href="tarea_chat.php?recordID=<?php echo $row_Recordset111['id_tarea']; ?>"><?php  
                           






                           $mifecha= $row_Recordset111['fec_finalizada']; 
                           $NuevaFecha = strtotime ( '-0 hour' , strtotime ($mifecha) ) ; 
                           $NuevaFecha = strtotime ( '-0 minute' , $NuevaFecha ) ; 
                           $NuevaFecha = strtotime ( '-0 second' , $NuevaFecha ) ; 
                           $NuevaFecha = date ( 'Y-m-d H:i:s' , $NuevaFecha); 
$datestr=$NuevaFecha;//Your date
$date=strtotime('-0 hour', strtotime($datestr));//Converted to a PHP date (a second count)
$diff=time()-$date;//time returns current time in seconds
$days=floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)
$hours=round(($diff-$days*60*60*24)/(60*60));




echo "<br><font color=black><i class=icon-time></i>Tiempo Transcurido Desde Que Se Finalizo Hace $days dias $hours horas <font/><br />";
                           

                           ?></a>
                        </td>
                    </tr>


                    <?php }
                } while ($row_Recordset111 = mysqli_fetch_assoc($Recordset111));
            }else{
                ?>
                    <tr>
                        <td>
                            <h3>No Hay Tareas Finalizadas De Los Demas</h3>
                        </td>
                    </tr>
                    <?php 
            }
            ?>


                </tbody>
            </table>
        </div>









        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
    </div>


</body>

</html>