
<?php
require_once('../Connections/conexionbanca.php');

$horaTxt=horaactual();
$FechaTxt=fechaactualbd();
$datetime=$FechaTxt.' '.$horaTxt;


$fechahora=$FechaTxt.' '.$horaTxt;



$hipodromo=$_POST['codigo_h'];
$cod_taquilla=$_POST['cod_taquilla'];
$modulo=$_POST['modulo'];

    rect_hipodromo($hipodromo,$cod_taquilla);
     function rect_hipodromo($hipodromo,$cod_taquilla)
     {
    
        $hipodromo=$hipodromo;
        $cod_taquilla=$cod_taquilla;
    
        global $conexionbanca;
         $query_Recordset1 = sprintf(
            "/* PARSEADORES1 apostador\Hipodromo_reset.php - QUERY 1 */ SELECT 
            taop.hip_bloqueados, taop.cod_taquilla, hi.cod_hipodromo
             FROM
            taquilla_opc_ame taop, hipodromo hi
            WHERE hi.cod_hipodromo > 0 AND
             taop.cod_taquilla = %s",
         GetSQLValueString($cod_taquilla, "int")
     );
         $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
         $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
         $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    
    if($row_Recordset1['hip_bloqueados']==''){
    }else{
    /*/
    $lop=$row_Recordset1['hip_bloqueados'];
 $lop = explode(",", $lop);
     foreach ($lop as $datos) {
         $ingreso3=$datos;
         $query_Recordset12 = sprintf(
            "SELECT 
            cod_hipodromo
             FROM
            hipodromo
             WHERE 
             cod_hipodromo = %s AND cod_hipodromo <> %s",
         GetSQLValueString($ingreso3, "int"),
         GetSQLValueString($hipodromo, "int")
        );
         $Recordset12 = mysqli_query($conexionbanca, $query_Recordset12) or die(mysqli_error($conexionbanca));
         $row_Recordset12 = mysqli_fetch_assoc($Recordset12);
         $totalRows_Recordset12 = mysqli_num_rows($Recordset12);
         
         
         if(!empty($row_Recordset12['cod_hipodromo'])){
            
            $ingreso=array($row_Recordset12['cod_hipodromo']);
            var_dump ($ingreso);
            $ingreso2=implode(" ", $ingreso);      
    
            //return array_values($ingreso);
    
         }
         
     }
     /*/
     
    //echo  $lop;
    $ingreso=NULL;
    $insertSQL1 = sprintf(
        "/* PARSEADORES1 apostador\Hipodromo_reset.php - QUERY 2 */ UPDATE taquilla_opc_ame  
            SET hip_bloqueados=%s				
            WHERE cod_taquilla=%s",
        
        GetSQLValueString($ingreso, "text"),
        GetSQLValueString($cod_taquilla, "int")
    );
    $Result1 = mysqli_query($conexionbanca, $insertSQL1) or die(mysqli_error($conexionbanca));
    }
    }


 





