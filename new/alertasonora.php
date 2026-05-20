<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('./Connections/conexionbanca.php');
$fechasistema=fechaactualbd();
$horasistema=horaactual();
$query_Recordset12 = sprintf("
/* PARSEADORES1 new\alertasonora.php - QUERY 1 */ SELECT * 
FROM 
chat2
WHERE sentdate=%s AND tipo=%s AND recd=1
LIMIT 1", GetSQLValueString($fechasistema, "date"), GetSQLValueString(0, "int"));
$Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
$row_Recordset12 = mysqli_fetch_assoc($Recordset12);
$totalRows_Recordset12 = mysqli_num_rows($Recordset12);




?>
<script type="text/javascript">
 //<![CDATA[
 <!--
  setTimeout("location.reload()", 2000);
 //-->
 //]]>
</script>

<!DOCTYPE html>
<meta charset="utf-8">
<html>
<head>

</head>
<body>

<?php
echo horaampm(horaactual());
echo "<br/>";

if ($totalRows_Recordset12==1) {
    echo "si hay msjs";
    $link = "../sonido/sms-alert-5-daniel_simon.wav";

    $audio = "<embed src='".$link."' AUTOSTART=TRUE WIDTH=144 HEIGHT=60>";

    echo $audio;
}
if ($totalRows_Recordset12==0) {
    echo "no hay msjs";
}
mysqli_free_result($Recordset12);

?>
<br/>
<?php
?>
</body>

    <script>
     </script>
</html>