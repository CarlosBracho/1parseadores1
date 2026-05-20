<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
include('../includes/mtp_funcion5.php');

list($horacarr, $hipodomo, $numeroca, $restante, $horacier)=consultaPacificna();
$fech=fechaactualbd();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas Hípicas:.</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<![endif]-->
<pre>
<?php
$a = array($hipodomo, $numeroca);
echo "<pre>";
print_r($a);
echo "</pre>";
?>
</pre>
</body>
<!-- InstanceEnd --></html>