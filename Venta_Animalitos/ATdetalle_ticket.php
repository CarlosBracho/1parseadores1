
<?php
  opcache_reset();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION)) {
    session_start();
}
require_once('../Connections/conexionbanca.php');

//var_dump($_POST);

 if ($_POST['jtipo']==0 && $_POST['modulo']==3) {














    $query_Recordset1111 = sprintf(
        "/* PARSEADORES1 Venta_Animalitos\ATdetalle_ticket.php - QUERY 1 */ SELECT id_Loterias_y_nombres_ani1, nom_Loterias_y_nombres_ani1, animales_Loterias_y_nombres_ani1
      FROM  ani1_loterias_y_nombres
       ORDER BY id_Loterias_y_nombres_ani1 ASC");
      $Recordset1111 =mysqli_query($conexionbanca, $query_Recordset1111) or die(mysqli_error($conexionbanca));
      $row_Recordset1111 = mysqli_fetch_assoc($Recordset1111);
      $totalRows_Recordset1111 = mysqli_num_rows($Recordset1111);
      
      $dir = array();
      $cont = 0;
      if ($totalRows_Recordset1111>=1) {
        do {
         $dir[$cont] = $row_Recordset1111;
         $cont++;
        } while ($row_Recordset1111 = mysqli_fetch_assoc($Recordset1111));
      }










    $query_Recordset12 = sprintf(
        "/* PARSEADORES1 Venta_Animalitos\ATdetalle_ticket.php - QUERY 2 */ SELECT 
*
    
            FROM
ani5_jugadas
            WHERE

            id_ticket_ani5 = %s AND linea_ticket_ani5 = 1  ORDER BY linea_ticket_ani5 DESC
",
        GetSQLValueString($_POST['nticket'], "int")
    );
    $Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
    $row_Recordset12 = mysqli_fetch_assoc($Recordset12);
    $totalRows_Recordset12 = mysqli_num_rows($Recordset12);
    $query_Recordset1 = sprintf(
        "/* PARSEADORES1 Venta_Animalitos\ATdetalle_ticket.php - QUERY 3 */ SELECT 
*

        FROM
ani5_jugadas
        WHERE

        num_ticket_ani5 = %s   ORDER BY linea_ticket_ani5 DESC
",
        GetSQLValueString($_POST['nticket'], "int")
    );
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);


    $inicioff=substr($row_Recordset1['fechahora_creacion_ani5'], 0, -9);


    $iniciof=$inicioff.' 00:00:01';
     $finalf=$inicioff.' 23:59:59';

    $query_Recordset1111_solteos = sprintf(
        "/* PARSEADORES1 Venta_Animalitos\ATdetalle_ticket.php - QUERY 4 */ SELECT id_solteo_ani4,
        id_Loterias_y_nombres_ani4,
        fechahora_solteo_ani4
      FROM  ani4_solteos
      WHERE 
      fechahora_solteo_ani4 >= %s AND fechahora_solteo_ani4 <= %s
       ORDER BY id_solteo_ani4 ASC",
            GetSQLValueString($iniciof, "date"), GetSQLValueString($finalf, "date") );
      $Recordset1111_solteos =mysqli_query($conexionbanca, $query_Recordset1111_solteos) or die(mysqli_error($conexionbanca));
      $row_Recordset1111_solteos = mysqli_fetch_assoc($Recordset1111_solteos);
      $totalRows_Recordset1111_solteos = mysqli_num_rows($Recordset1111_solteos);
  
      $dir_solteos = array();
      $cont_solteos = 0;
      if ($totalRows_Recordset1111_solteos>=1) {
        do {
         $dir_solteos[$cont_solteos] = $row_Recordset1111_solteos;
         $cont_solteos++;
        } while ($row_Recordset1111_solteos = mysqli_fetch_assoc($Recordset1111_solteos));
      }








    if ($row_Recordset1['moneda_ani5']<=2) {
        $moneda='Bss';
    }
    if ($row_Recordset1['moneda_ani5']==3) {
        $moneda='Usd';
    }
    if ($row_Recordset1['moneda_ani5']==4) {
        $moneda='Cop';
    }
    if ($row_Recordset1['moneda_ani5']==5) {
        $moneda='Sol';
    }
    if ($row_Recordset1['moneda_ani5']==12) {
        $moneda='Usd';
    } ?>

<div class="card">
<div class="card-body">
    Ticket Nro.: <?php echo $row_Recordset1['id_ticket_ani5']; ?><br/>
    Fecha: <?php
echo substr($row_Recordset1['fechahora_creacion_ani5'], 0, -9); //2020-09-25
?>
    
    <br/>
    Hora: <?php $nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($row_Recordset1['fechahora_creacion_ani5']));
    $nuevahora1 = date('Y-m-j H:i:s', $nuevahora1);
    echo date("g:ia", strtotime($nuevahora1)); ?><br/>

    Apuesta <?php echo $moneda; ?>.. <?php echo $row_Recordset1['mon_venta_ani5']; ?><br/>

    <?php if ($row_Recordset12['mon_pago_ani5']>$row_Recordset1['mon_venta_ani5']) {  ?>
    Premio <?php echo $moneda; ?>.. <?php echo $row_Recordset12['mon_pago_ani5']; ?><br/>
    <?php  } ?>
    <?php if ($row_Recordset12['mon_pago_ani5']==$row_Recordset1['mon_venta_ani5']) {  ?>
    Devolucion <?php echo $moneda; ?>.. <?php echo $row_Recordset12['mon_pago_ani5']; ?><br/>
    <?php  } ?>


    <?php if ($row_Recordset12['ani_verificado_ani5']==0) {
        echo '<b>Este Ticket no ha sido Verificado</b>'; }          
 if ($row_Recordset12['ani_verificado_ani5']==1) {
        echo '<b>Este Ticket ha sido Verificado</b>';
        }
    ?>


</div>
<table class="table table-sm">
<thead class="thead-dark">
    <tr>
      <th scope="col">Tipo</th>
      <th scope="col">Equipo</th>
      <th scope="col">Logro</th>
      <th scope="col">Logro</th>
      <th scope="col">Estado</th>


    </tr>
</thead>
<tbody>

<?php do { ?>
<tr>
<td class="detalleTablaLeft"><b>
<?php 
foreach ($dir as $clave) { 
if($clave['id_Loterias_y_nombres_ani1']==$row_Recordset1['id_loteria_ani5']){ echo $clave['nom_Loterias_y_nombres_ani1']; 
$claveexp=explode(',', $clave['animales_Loterias_y_nombres_ani1']);
?>
</td><td class="detalleTablaLeft"><b>
<?php
foreach ($claveexp as $claveexp2) { 
$claveexp3=explode('.', $claveexp2);
if($claveexp3[0]==$row_Recordset1['id_animalito_ani5']){  echo $claveexp3[2];  }}}
}
?>
</td>
<td class="detalleTablaLeft">
<?php
foreach ($dir_solteos as $clave_solteos) { 
if($clave_solteos['id_solteo_ani4']==$row_Recordset1['id_solteo_ani5']){


$clave_solteos_fechahora_solteo_ani4 = date("h:i A", strtotime($clave_solteos['fechahora_solteo_ani4']));
echo $clave_solteos_fechahora_solteo_ani4;
}
        }

        ?>

</td>
<td class="detalleTablaLeft"> <?php
if ($row_Recordset1['estadojugada_ani5']==0) {
    echo 'Pendiente';
}
if ($row_Recordset1['estadojugada_ani5']==1) {
    echo 'Gano';
}
if ($row_Recordset1['estadojugada_ani5']==2) {
    echo 'Perdio';
}
if ($row_Recordset1['estadojugada_ani5']==3) {
    echo 'Devolucion';
}
?>
</td>

</tr>

<?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
</tr>
</tbody>
</table>
<?php
} 
?>
