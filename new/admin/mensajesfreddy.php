<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once('../Connections/conexionbanca.php');
date_default_timezone_set("Pacific/Honolulu") ;


$fechadesde = $_GET['fechadesde'];
$fechahasta = $_GET['fechahasta'];


$horaactual=horaactual();
$fechasistema=fechaactualbd();
//echo $fechasistema;
$hora1=$horaactual;
$nuevahora1 = strtotime($_SESSION['ZonaHorario'], strtotime($hora1)) ;
$nuevahora1 = date('H:i:s', $nuevahora1);
//echo horaampm($nuevahora1);
//echo $nuevahora1;

$inicio=fechanueva(fechaactualbd());
$final=fechanueva(fechaactualbd());
$in=fechaymd($inicio); $fi=fechaymd($final);
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "" . htmlentities($_SERVER['QUERY_STRING']);
}




$query_Recordset2 = sprintf(
    "/* PARSEADORES1 new\admin\mensajesfreddy.php - QUERY 1 */ SELECT 
chat7.message

FROM 
chat7
WHERE

(chat7.sentdate >= %s AND
chat7.sentdate <= %s)
					
AND chat7.from1 = %s  
ORDER BY 
chat7.sentdate
DESC",
    GetSQLValueString($fechadesde, "date"),
    GetSQLValueString($fechahasta, "date"),
    GetSQLValueString("DFREDDYHURTADO", "text")
);
$Recordset2 = mysqli_query($conexionbanca, $query_Recordset2) or die(mysqli_error($conexionbanca));
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);
echo $totalRows_Recordset2;







$tVta121=0;



$tVta1monto11=0;
$tVta1=0;
$x=0;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>.:Apuestas H�picas:.</title>

<script src="../js/jquery-1.9.1.min.js"></script>

<!-- InstanceBeginEditable name="aHead" -->
<!-- InstanceEndEditable -->
</head>
<body onload="Javascript:history.go(1);" onunload="Javascript:history.go(1);">


<CENTER>

           <div align="center" style="font-size:18px;width:140px; height:100px;text-align:center; background: #FFF; float:left;
        	padding:5px 5px 5px 5px;"></div>
            <br/><input type="button" onclick="window.location='./index.php';" 
            	style="height:65px; width:340px; font-size:20px; margin:0px 15px 0px 0px" 
            	value="Volver Menu Anteriol" />
				</CENTER>
<div class="container">
  
  
  
  
  <div class="contentAdmin"><!-- InstanceBeginEditable name="Contenido" -->
  	<div style="height:100%; font-size:18px;" class="xfirefox">
    <?php if ($totalRows_Recordset2>0) {?>    

    <div style="height:100%; padding:0px 0px 200px 0px ">   
	<table width="100%" border="0" align="center" border="4" >
  		<tr style="background:#5EAEFF; color:#FFFFFF; height:30px">
          <td width="92">VENTA MONTO</td>

        </tr>
        <?php do { ?>
          <tr class="brillo">

		              <td align="left">-------<?php echo $row_Recordset2['message']; ?></td>
			 </tr>		  		  
<br/><br/><br/><br/>		  
<?php
             
           } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));
          
          

}  ?>
	
      </table>
      </div>

</div>
			

      </div>
</div>
      </div>

 
</div>

  <!-- InstanceEndEditable -->
  </div>
  <div class="footer">  Copyright � Apuestas H�picas    <!-- end .footer --></div>
  <!-- end .container -->
  </div>
</body>
<!-- InstanceEnd --></html>
