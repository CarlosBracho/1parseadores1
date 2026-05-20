<?php
$insertSQL155 = sprintf(
    "/* PARSEADORES1 parley\parley\carculojparley2.php - QUERY 1 */ UPDATE p4jugadas  SET 
estadojugadap4=%s 
WHERE Id_p4jugadasp4=%s",
    GetSQLValueString($estadojugadap4, "int"),
    GetSQLValueString($row_Recordset1['Id_p4jugadasp4'], "int")
);
$Result155 = mysqli_query($conexionbanca, $insertSQL155) or die(mysqli_error($conexionbanca));
//echo '<a href=carculojparley3.php?nticketp4='.$row_Recordset1['nticketp4'].'>';

//require_once('carculojparley3.php?nticketp4='.$row_Recordset1['nticketp4']);
$varlosx='nticketp4='.$row_Recordset1['nticketp4'];
?>
<script>
function llamada(nticketp4) {
$.ajax(
   {
      type:'GET',
      url:'./carculojparley3.php',
      data: nticketp4,
      success: function(data){
        //alert(data);
      }
   }
); }
llamada('<?php echo $varlosx ?>');
</script>

<?php
