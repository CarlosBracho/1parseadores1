<?php
if (!isset($_SESSION)) {
    session_start();
} require_once('../Connections/conexionbanca.php');
$MM_authorizedUsers = "U"; $MM_restrictGoTo = "../index.php"; include("../includes/comprobar_acceso.php");
if (isset($_POST["js"])) {
    $_SESSION['selCarrera']=$_POST["js"];
} else {
    $_SESSION['selCarrera']=-1;
}
$hor=horaactual();
$fec=fechaactualbd();
$xbanca_Recordset1 = 2;
if (!isset($ejeMinCar)) {
    if (!isset($ejeMinCar)) {
        $ejeMinCar=$_POST["eM"];
    }
}
$query_Recordset44 = sprintf("/* PARSEADORES1 ventas\ventas_hipodromo_listas_prueba.php - QUERY 1 */ SELECT 
	ta.cod_taquilla
	FROM agencia ag, taquilla ta, usuario us
	WHERE  ag.cod_agencia = ta.cod_agencia AND ta.cod_taquilla = us.cod_taquilla AND us.id_usuario = %s 
	
	ORDER BY RAND() LIMIT 1", GetSQLValueString($_SESSION['MM_id_usuario'], "int"));
$Recordset44 = mysqli_query($conexionbanca, $query_Recordset44) or die(mysqli_error($conexionbanca));
$row_Recordset44 = mysqli_fetch_assoc($Recordset44);
$totalRows_Recordset44 = mysqli_num_rows($Recordset44);


    $query_Recordset1 = sprintf("/* PARSEADORES1 ventas\ventas_hipodromo_listas_prueba.php - QUERY 2 */ SELECT * FROM carrera WHERE carrera.fec_carrera = %s AND carrera.hor_carrera >= %s AND carrera.est_carrera = 1 AND carrera.cod_banca = %s AND can_caballos>=%s ORDER BY carrera.hor_carrera  LIMIT 0, 20", 
    GetSQLValueString($fec, "date"), GetSQLValueString($hor, "date"), GetSQLValueString($xbanca_Recordset1, "int"), GetSQLValueString($ejeMinCar, "int"));
    $Recordset1 = mysqli_query($conexionbanca, $query_Recordset1) or die(mysqli_error($conexionbanca));
    $row_Recordset1 = mysqli_fetch_assoc($Recordset1);
    $totalRows_Recordset1 = mysqli_num_rows($Recordset1);
    $t=0;
    $x=0;
    //$_SESSION['hi_blo_list']=hi_bloqueados($row_Recordset5['hip_bloqueados']);
   
    
    
    
    
    $hi_blo_explode=explode(",", $_SESSION['hi_blo_list']);


    if ($totalRows_Recordset1>0) {
        do {
            list($h, $m, $s)=restahoraVenta(horaactual(), $row_Recordset1['hor_carrera']);
            if ($h==0 && $m<50) {



                $establoqueado=0;
                //$diego=boton_hipodromo($row_Recordset1['cod_hipodromo'], $row_Recordset44D['cod_taquilla']);
                foreach($hi_blo_explode as $hi_blo_explode2){
    if($row_Recordset1['cod_hipodromo']==$hi_blo_explode2)
    {
        $establoqueado=1;
    }
                }
    
                    if($establoqueado==0){
                $cod[$t]=$row_Recordset1['cod_carrera'];
                $num_carrera[$t]=$row_Recordset1['num_carrera'];
                $nom_hipodromo[$t]=$row_Recordset1['nom_hipodromo'];
                $t++;
                    }








            }
        } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1));
    }
    if ($t==0) {
        $totalRows_Recordset1=0;
    }
    if ($t>0) {?>
        <select name="cod_carrera" tabindex="1" onKeyDown="if(event.keyCode==13) event.keyCode=9;" id="soflow" 
        style="font-size:20px; width:480px; height:35px" onBlur="startListaHipodromo()" 
        onChange="pizActualame(this);javascript:document.getElementById('numCa44').focus()">
            <option value="-1" style="background: #C00; color:#FFFFFF;" onclick="clean()">
                <?php echo "SELECCIONE HIPÓDROMO AQUÍ";?>
            </option>
            <?php
            if (isset($cod)) {
                foreach ($cod as $cod_carrera) {
                    ?>
                        <option value="<?php echo $cod_carrera; ?>" 
                            <?php if (!(strcmp(htmlentities($cod_carrera, ENT_COMPAT, 'utf-8'), $_SESSION['selCarrera']))) {
                        echo "selected=\"selected\"";
                    } ?> 
                            onfocus="clean()" onclick="clean()">
                            <?php echo $nom_hipodromo[$x]." Carr: ...".$num_carrera[$x]; ?>
                        </option>
                    <?php
                    $x++;
                }
            }?>
        </select>
    <?php
    } else {
                $_SESSION['selCarrera']=-1; ?>
        <select name="cod_carrera" tabindex="1" id="soflow" style="font-size:18px; width:522px; height:35px" disabled="disabled">
            <option value="-1" > <?php echo "En estos momentos no existen carreras abiertas"; ?></option>
        </select>
    <?php
            }
    mysqli_free_result($Recordset1);