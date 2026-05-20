<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_POST["js"])) {
    $_SESSION['selCarrera']=$_POST["js"];
} else {
    $_SESSION['selCarrera']=-1;
}
echo $_POST["js"];
include("../includes/ventas_hipodromo_listas.php");
if ($totalRows_Recordset1<=0) {?>
	<script language="javascript">
		$("#realizarapuesta").load('../includes/ventas_boton_realizar_apuesta.php?&js='+Math.random());
	</script>
<?php
}
?>